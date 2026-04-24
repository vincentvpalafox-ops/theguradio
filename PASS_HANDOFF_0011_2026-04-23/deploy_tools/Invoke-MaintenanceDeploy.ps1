param(
    [Parameter(Mandatory = $false)]
    [string]$HostName,

    [Parameter(Mandatory = $false)]
    [string]$UserName,

    [Parameter(Mandatory = $false)]
    [string]$KeyPath = (Join-Path $env:USERPROFILE '.ssh\id_ed25519'),

    [Parameter(Mandatory = $false)]
    [string]$BundleFile,

    [Parameter(Mandatory = $false)]
    [string]$RemoteTarget = '/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php',

    [Parameter(Mandatory = $false)]
    [string]$ExpectedSha256 = '9AC1E208FCAB9A6498FC40B28EF8B87D865C5C6551B4A81104BDF6CDCD0A7DDA',

    [switch]$Execute
)

$ErrorActionPreference = 'Stop'

function Quote-RemotePath {
    param(
        [Parameter(Mandatory = $true)]
        [string]$Path
    )

    return "'" + ($Path -replace "'", "'\\''") + "'"
}

function Write-Step {
    param(
        [Parameter(Mandatory = $true)]
        [string]$Message
    )

    Write-Host "[deploy] $Message"
}

$scriptRoot = if ($PSScriptRoot) {
    $PSScriptRoot
} else {
    Split-Path -Parent $MyInvocation.MyCommand.Path
}

if ([string]::IsNullOrWhiteSpace($BundleFile)) {
    $BundleFile = Join-Path $scriptRoot '..\..\PASS_HANDOFF_0009_2026-04-23\deploy_bundle\wp-content\plugins\gu-scene-archive\includes\class-gu-scene-archive-maintenance.php'
}

$resolvedBundle = (Resolve-Path $BundleFile).Path

if (-not (Test-Path $resolvedBundle)) {
    throw "Bundle file not found: $BundleFile"
}

if (-not (Test-Path $KeyPath)) {
    throw "SSH key not found: $KeyPath"
}

$bundleHash = (Get-FileHash $resolvedBundle -Algorithm SHA256).Hash.ToUpperInvariant()

if ($bundleHash -ne $ExpectedSha256.ToUpperInvariant()) {
    throw "Bundle hash mismatch. Expected $ExpectedSha256 but got $bundleHash"
}

$timestamp = Get-Date -Format 'yyyyMMddHHmmss'
$remoteTmp = "$RemoteTarget.codex-upload-$timestamp"
$remoteBackup = "$RemoteTarget.codex-backup-$timestamp"

Write-Step "Bundle file: $resolvedBundle"
Write-Step "Bundle SHA-256: $bundleHash"
Write-Step "Remote target: $RemoteTarget"
Write-Step "Remote temp path: $remoteTmp"
Write-Step "Remote backup path: $remoteBackup"

if ([string]::IsNullOrWhiteSpace($HostName) -or [string]::IsNullOrWhiteSpace($UserName)) {
    Write-Step 'HostName and UserName were not both provided.'
    Write-Step 'Dry-run only. Example usage:'
    Write-Host "powershell -ExecutionPolicy Bypass -File `"$PSCommandPath`" -HostName theguradio.com -UserName thegalla"
    exit 0
}

$scpTarget = '{0}@{1}:{2}' -f $UserName, $HostName, $remoteTmp
$scpCommand = @(
    'scp',
    '-i', $KeyPath,
    $resolvedBundle,
    $scpTarget
)

$remoteVerifyCommand = @"
set -e
backup_path=$(Quote-RemotePath $remoteBackup)
target_path=$(Quote-RemotePath $RemoteTarget)
tmp_path=$(Quote-RemotePath $remoteTmp)
cp "`$target_path" "`$backup_path"
mv "`$tmp_path" "`$target_path"
if command -v sha256sum >/dev/null 2>&1; then
    actual_hash=`$(sha256sum "`$target_path" | awk '{print toupper(`$1)}')
elif command -v shasum >/dev/null 2>&1; then
    actual_hash=`$(shasum -a 256 "`$target_path" | awk '{print toupper(`$1)}')
else
    echo "No SHA-256 command available on remote host." >&2
    exit 1
fi
if [ "`$actual_hash" != "$ExpectedSha256" ]; then
    echo "Remote hash mismatch: `$actual_hash" >&2
    exit 1
fi
echo "REMOTE_SHA256=`$actual_hash"
echo "REMOTE_BACKUP=`$backup_path"
"@

$sshCommand = @(
    'ssh',
    '-i', $KeyPath,
    ('{0}@{1}' -f $UserName, $HostName),
    $remoteVerifyCommand
)

Write-Step 'Prepared commands:'
Write-Host ('  ' + ($scpCommand -join ' '))
Write-Host ('  ' + ($sshCommand -join ' '))

if (-not $Execute) {
    Write-Step 'Dry-run complete. No remote action was taken.'
    exit 0
}

Write-Step 'Uploading bundle file via scp...'
& $scpCommand[0] $scpCommand[1..($scpCommand.Length - 1)]

Write-Step 'Promoting uploaded file on the remote host and verifying SHA-256...'
& $sshCommand[0] $sshCommand[1..($sshCommand.Length - 1)]

Write-Step 'Deployment command path completed successfully.'
Write-Step 'Next manual step: open the WordPress admin maintenance screen, run Normalize Homepage Archive Metadata once, and inspect the review table.'
