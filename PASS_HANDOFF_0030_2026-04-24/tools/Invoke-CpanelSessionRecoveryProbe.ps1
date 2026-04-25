param(
    [string]$OutFile,
    [int]$TimeoutSec = 15
)

function Redact-CpanelSessionUrl {
    param(
        [Parameter(Mandatory = $true)]
        [string]$Url
    )

    return ($Url -replace 'cpsess\d+', 'cpsess[redacted]')
}

function Get-CpanelSessionCandidates {
    $base = 'C:\Users\fl_ip\AppData\Local\Google\Chrome\User Data'
    if (-not (Test-Path -LiteralPath $base)) {
        return @()
    }

    $sessionFiles = Get-ChildItem -Path $base -Recurse -File -ErrorAction SilentlyContinue |
        Where-Object { $_.FullName -match '\\Sessions\\(Session_|Tabs_)' } |
        Sort-Object LastWriteTime -Descending |
        Select-Object -First 30

    $results = New-Object System.Collections.Generic.List[object]

    foreach ($file in $sessionFiles) {
        try {
            $bytes = [System.IO.File]::ReadAllBytes($file.FullName)
            $text = [System.Text.Encoding]::UTF8.GetString($bytes)
            $matches = [regex]::Matches($text, 'https?://[^\s\x00"''<>]+')
            foreach ($match in $matches) {
                $url = ([string]$match.Value -replace '[\x00-\x1F\x7F]', '')
                if ($url -match '^https://[^/]+:2083/' -or $url -match '^https://[^/]+:2083$') {
                    if ($url -match 'cpsess\d+' -or $url -match 'webhosting2021\.is\.cc:2083') {
                        $results.Add([pscustomobject]@{
                            source_file = $file.FullName
                            source_last_write_time = $file.LastWriteTime.ToString('s')
                            raw_url = $url
                            redacted_url = (Redact-CpanelSessionUrl -Url $url)
                        })
                    }
                }
            }
        } catch {
        }
    }

    return @($results | Sort-Object redacted_url -Unique)
}

function Test-CpanelUrl {
    param(
        [Parameter(Mandatory = $true)]
        [string]$Url
    )

    $curlPath = Get-Command 'curl.exe' -ErrorAction SilentlyContinue
    if (-not $curlPath) {
        return [pscustomobject]@{
            final_status = 0
            title = ''
            has_login_form = $false
            has_filemanager = $false
            has_domains = $false
        }
    }

    $bodyPath = Join-Path -Path ([System.IO.Path]::GetTempPath()) -ChildPath ("gu-cpanel-recovery-body-" + [guid]::NewGuid().ToString() + ".html")
    $hdrPath = Join-Path -Path ([System.IO.Path]::GetTempPath()) -ChildPath ("gu-cpanel-recovery-headers-" + [guid]::NewGuid().ToString() + ".txt")

    try {
        $null = & $curlPath.Source -k -L -sS -D $hdrPath -o $bodyPath --connect-timeout $TimeoutSec --max-time $TimeoutSec $Url

        $headers = if (Test-Path -LiteralPath $hdrPath) { Get-Content -Raw -LiteralPath $hdrPath } else { '' }
        $body = if (Test-Path -LiteralPath $bodyPath) { Get-Content -Raw -LiteralPath $bodyPath } else { '' }
        $statusMatches = [regex]::Matches($headers, 'HTTP/[^\s]+\s+(\d{3})')
        $finalStatus = 0
        if ($statusMatches.Count -gt 0) {
            $finalStatus = [int]$statusMatches[$statusMatches.Count - 1].Groups[1].Value
        }

        $title = ''
        $titleMatch = [regex]::Match($body, '<title>(.*?)</title>', 'IgnoreCase,Singleline')
        if ($titleMatch.Success) {
            $title = ($titleMatch.Groups[1].Value -replace '\s+', ' ').Trim()
        }

        return [pscustomobject]@{
            final_status = $finalStatus
            title = $title
            has_login_form = ($body -match 'login_form|Log in to cPanel|user=')
            has_filemanager = ($body -match 'File Manager|filemanager')
            has_domains = ($body -match 'Domains')
        }
    } finally {
        if (Test-Path -LiteralPath $bodyPath) {
            Remove-Item -LiteralPath $bodyPath -Force -ErrorAction SilentlyContinue
        }
        if (Test-Path -LiteralPath $hdrPath) {
            Remove-Item -LiteralPath $hdrPath -Force -ErrorAction SilentlyContinue
        }
    }
}

$candidates = Get-CpanelSessionCandidates
$tested = New-Object System.Collections.Generic.List[object]

foreach ($candidate in $candidates | Select-Object -First 5) {
    $probe = Test-CpanelUrl -Url $candidate.raw_url
    $tested.Add([pscustomobject]@{
        source_last_write_time = $candidate.source_last_write_time
        redacted_url = $candidate.redacted_url
        final_status = $probe.final_status
        title = $probe.title
        has_login_form = $probe.has_login_form
        has_filemanager = $probe.has_filemanager
        has_domains = $probe.has_domains
    })
}

$result = [ordered]@{
    generated_at = (Get-Date).ToString('s')
    candidate_count = $candidates.Count
    candidates = @($candidates | ForEach-Object {
        [pscustomobject]@{
            source_last_write_time = $_.source_last_write_time
            redacted_url = $_.redacted_url
        }
    })
    tested = @($tested | ForEach-Object {
        [pscustomobject]@{
            source_last_write_time = $_.source_last_write_time
            redacted_url = $_.redacted_url
            final_status = $_.final_status
            title = $_.title
            has_login_form = $_.has_login_form
            has_filemanager = $_.has_filemanager
            has_domains = $_.has_domains
        }
    })
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
