param(
    [string]$OutFile,
    [int]$TimeoutSec = 15
)

function Invoke-CurlStatus {
    param(
        [Parameter(Mandatory = $true)]
        [string]$Url
    )

    $curlPath = Get-Command 'curl.exe' -ErrorAction SilentlyContinue
    if (-not $curlPath) {
        return [pscustomobject]@{
            url = $Url
            status_code = 0
        }
    }

    $status = & $curlPath.Source `
        --silent `
        --show-error `
        --output NUL `
        --write-out '%{http_code}' `
        --connect-timeout $TimeoutSec `
        --max-time $TimeoutSec `
        $Url

    $code = 0
    if ($status -match '^\d+$') {
        $code = [int]$status
    }

    return [pscustomobject]@{
        url = $Url
        status_code = $code
    }
}

function Invoke-SshProbe {
    param(
        [Parameter(Mandatory = $true)]
        [string]$Target
    )

    $sshPath = Get-Command 'ssh.exe' -ErrorAction SilentlyContinue
    if (-not $sshPath) {
        return [pscustomobject]@{
            target = $Target
            exit_code = -1
            output = 'ssh_not_found'
        }
    }

    $stdoutPath = Join-Path -Path ([System.IO.Path]::GetTempPath()) -ChildPath ("gu-ssh-probe-out-" + [guid]::NewGuid().ToString() + ".txt")
    $stderrPath = Join-Path -Path ([System.IO.Path]::GetTempPath()) -ChildPath ("gu-ssh-probe-err-" + [guid]::NewGuid().ToString() + ".txt")
    $process = $null

    try {
        $process = Start-Process -FilePath $sshPath.Source `
            -ArgumentList @('-o', 'BatchMode=yes', '-o', "ConnectTimeout=$TimeoutSec", $Target, 'pwd') `
            -Wait `
            -PassThru `
            -NoNewWindow `
            -RedirectStandardOutput $stdoutPath `
            -RedirectStandardError $stderrPath

        $combined = ''
        if (Test-Path -LiteralPath $stdoutPath) {
            $combined += (Get-Content -Raw -LiteralPath $stdoutPath)
        }
        if (Test-Path -LiteralPath $stderrPath) {
            if ($combined) {
                $combined += "`n"
            }
            $combined += (Get-Content -Raw -LiteralPath $stderrPath)
        }

        return [pscustomobject]@{
            target = $Target
            exit_code = $process.ExitCode
            output = $combined.Trim()
        }
    } finally {
        if (Test-Path -LiteralPath $stdoutPath) {
            Remove-Item -LiteralPath $stdoutPath -Force -ErrorAction SilentlyContinue
        }
        if (Test-Path -LiteralPath $stderrPath) {
            Remove-Item -LiteralPath $stderrPath -Force -ErrorAction SilentlyContinue
        }
    }
}

function Get-ChromeMainProcess {
    $processes = Get-CimInstance Win32_Process -Filter "Name = 'chrome.exe'"
    $main = $processes | Where-Object { $_.CommandLine -match '--profile-directory=Profile 1' -and $_.CommandLine -notmatch '--type=' } | Select-Object -First 1
    if (-not $main) {
        return $null
    }

    return [pscustomobject]@{
        process_id = [int]$main.ProcessId
        command_line = [string]$main.CommandLine
    }
}

function Get-ChromeDebugPorts {
    $chromeIds = Get-Process chrome -ErrorAction SilentlyContinue | Select-Object -ExpandProperty Id
    if (-not $chromeIds) {
        return @()
    }

    return @(Get-NetTCPConnection -State Listen -ErrorAction SilentlyContinue |
        Where-Object { $_.OwningProcess -in $chromeIds } |
        Select-Object LocalAddress, LocalPort, OwningProcess |
        Sort-Object LocalPort)
}

function Get-RecentChromeSessionUrls {
    $sessionDir = 'C:\Users\fl_ip\AppData\Local\Google\Chrome\User Data\Profile 1\Sessions'
    if (-not (Test-Path -LiteralPath $sessionDir)) {
        return [pscustomobject]@{
            files = @()
            urls = @()
        }
    }

    $files = @(Get-ChildItem -LiteralPath $sessionDir -File |
        Where-Object { $_.Name -like 'Session_*' -or $_.Name -like 'Tabs_*' } |
        Sort-Object LastWriteTime -Descending |
        Select-Object -First 2)

    $urlResults = New-Object System.Collections.Generic.List[string]
    foreach ($file in $files) {
        try {
            $bytes = [System.IO.File]::ReadAllBytes($file.FullName)
            $text = [System.Text.Encoding]::UTF8.GetString($bytes)
            $matches = [regex]::Matches($text, 'https?://[^\s\x00"''<>]+')
            foreach ($match in $matches) {
                $value = [string]$match.Value
                if ($value -match 'theguradio|webhosting2021|wp-admin|2083') {
                    $cleanValue = $value -replace '[\x00-\x1F\x7F]', ''
                    $urlResults.Add($cleanValue)
                }
            }
        } catch {
        }
    }

    return [pscustomobject]@{
        files = @($files | ForEach-Object {
            [pscustomobject]@{
                name = $_.Name
                last_write_time = $_.LastWriteTime.ToString('s')
                length = [int64]$_.Length
            }
        })
        urls = @($urlResults | Sort-Object -Unique)
    }
}

function Get-CredentialMatches {
    $cmdkeyOutput = (cmdkey /list | Out-String)
    $cmdkeyMatches = @([regex]::Matches($cmdkeyOutput, '(?im)^\s*Target:\s*(.+)$') |
        ForEach-Object { $_.Groups[1].Value } |
        Where-Object { $_ -match 'theguradio|webhosting2021|peak|ftp|2083|cpanel' } |
        Sort-Object -Unique)

    $vaultWebOutput = ''
    $vaultWinOutput = ''
    try {
        $vaultWebOutput = (vaultcmd /listcreds:"Web Credentials" | Out-String)
    } catch {
        $vaultWebOutput = ''
    }
    try {
        $vaultWinOutput = (vaultcmd /listcreds:"Windows Credentials" | Out-String)
    } catch {
        $vaultWinOutput = ''
    }

    $vaultMatches = @([regex]::Matches(($vaultWebOutput + "`n" + $vaultWinOutput), '(?im)^\s*Resource:\s*(.+)$') |
        ForEach-Object { $_.Groups[1].Value } |
        Where-Object { $_ -match 'theguradio|webhosting2021|peak|ftp|2083|cpanel' } |
        Sort-Object -Unique)

    return [pscustomobject]@{
        cmdkey_targets = $cmdkeyMatches
        vault_resources = $vaultMatches
    }
}

$result = [ordered]@{
    generated_at = (Get-Date).ToString('s')
    routes = [ordered]@{
        home = Invoke-CurlStatus -Url 'https://theguradio.com/'
        preview = Invoke-CurlStatus -Url 'https://theguradio.com/archive-homepage-preview/'
    }
    ssh_probe = Invoke-SshProbe -Target 'thegalla@theguradio.com'
    chrome_main_process = Get-ChromeMainProcess
    chrome_debug_ports = @(Get-ChromeDebugPorts)
    chrome_recent_session = Get-RecentChromeSessionUrls
    credential_matches = Get-CredentialMatches
}

$json = $result | ConvertTo-Json -Depth 6

if ($OutFile) {
    $resolvedOutFile = $ExecutionContext.SessionState.Path.GetUnresolvedProviderPathFromPSPath($OutFile)
    $outDir = Split-Path -Path $resolvedOutFile -Parent
    if ($outDir -and -not (Test-Path -LiteralPath $outDir)) {
        New-Item -ItemType Directory -Force -Path $outDir | Out-Null
    }
    Set-Content -LiteralPath $resolvedOutFile -Value $json -Encoding UTF8
}

$json
