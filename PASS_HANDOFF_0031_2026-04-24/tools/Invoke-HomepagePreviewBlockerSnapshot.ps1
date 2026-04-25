param(
    [string]$OutFile
)

$passRoot = Split-Path -Path $PSScriptRoot -Parent
$repoRoot = Split-Path -Path $passRoot -Parent

$accessScript = Join-Path -Path $repoRoot -ChildPath 'PASS_HANDOFF_0029_2026-04-24\tools\Invoke-HomepagePreviewAccessDiagnostics.ps1'
$cpanelScript = Join-Path -Path $repoRoot -ChildPath 'PASS_HANDOFF_0030_2026-04-24\tools\Invoke-CpanelSessionRecoveryProbe.ps1'

$accessOut = Join-Path -Path $passRoot -ChildPath 'access_diagnostics_component.json'
$cpanelOut = Join-Path -Path $passRoot -ChildPath 'cpanel_recovery_component.json'

function Invoke-JsonScript {
    param(
        [Parameter(Mandatory = $true)]
        [string]$ScriptPath,
        [Parameter(Mandatory = $true)]
        [string]$TargetOutFile
    )

    $json = & powershell -ExecutionPolicy Bypass -File $ScriptPath -OutFile $TargetOutFile
    if (-not $json) {
        throw "No JSON output from $ScriptPath"
    }

    return $json | ConvertFrom-Json
}

$access = Invoke-JsonScript -ScriptPath $accessScript -TargetOutFile $accessOut
$cpanel = Invoke-JsonScript -ScriptPath $cpanelScript -TargetOutFile $cpanelOut

$browserSessionEvidence = $false
if ($access.chrome_recent_session -and $access.chrome_recent_session.urls) {
    $browserSessionEvidence = @($access.chrome_recent_session.urls | Where-Object {
        $_ -match 'wp-admin/post\.php\?post=7127&action=(edit|elementor)' -or
        $_ -match 'wp-admin/admin\.php\?page=gu-scene-archive-'
    }).Count -gt 0
}

$credentialStoreHasHostingPath = $false
if ($access.credential_matches) {
    $credentialStoreHasHostingPath = (@($access.credential_matches.cmdkey_targets).Count -gt 0) -or (@($access.credential_matches.vault_resources).Count -gt 0)
}

$cpanelAuthenticatedSurfaceRecovered = $false
if ($cpanel.tested) {
    $cpanelAuthenticatedSurfaceRecovered = @($cpanel.tested | Where-Object {
        ($_.has_filemanager -or $_.has_domains) -and -not $_.has_login_form
    }).Count -gt 0
}

$sshAvailable = ($access.ssh_probe.exit_code -eq 0)
$debugPortAvailable = @($access.chrome_debug_ports).Count -gt 0
$cpanelCandidatesFound = ($cpanel.candidate_count -gt 0)
$manualReauthRequired = (-not $sshAvailable) -and (-not $debugPortAvailable) -and (-not $credentialStoreHasHostingPath) -and $cpanelCandidatesFound -and (-not $cpanelAuthenticatedSurfaceRecovered)
$workspaceOnlyPathsExhausted = $manualReauthRequired -and $browserSessionEvidence

$summary = [ordered]@{
    generated_at = (Get-Date).ToString('s')
    repo_head = (& git -C $repoRoot rev-parse --short HEAD).Trim()
    component_artifacts = [ordered]@{
        access_diagnostics = $accessOut
        cpanel_recovery = $cpanelOut
    }
    signals = [ordered]@{
        home_status_code = [int]$access.routes.home.status_code
        preview_status_code = [int]$access.routes.preview.status_code
        ssh_available = $sshAvailable
        browser_session_evidence = $browserSessionEvidence
        chrome_debug_port_available = $debugPortAvailable
        credential_store_has_hosting_path = $credentialStoreHasHostingPath
        cpanel_candidates_found = $cpanelCandidatesFound
        cpanel_authenticated_surface_recovered = $cpanelAuthenticatedSurfaceRecovered
        manual_reauth_required = $manualReauthRequired
        workspace_only_paths_exhausted = $workspaceOnlyPathsExhausted
    }
    evidence = [ordered]@{
        ssh_probe = $access.ssh_probe
        chrome_main_process = $access.chrome_main_process
        recovered_cpanel_candidates = $cpanel.candidate_count
        tested_cpanel_candidates = @($cpanel.tested)
    }
}

$json = $summary | ConvertTo-Json -Depth 8

if ($OutFile) {
    $resolvedOutFile = $ExecutionContext.SessionState.Path.GetUnresolvedProviderPathFromPSPath($OutFile)
    $outDir = Split-Path -Path $resolvedOutFile -Parent
    if ($outDir -and -not (Test-Path -LiteralPath $outDir)) {
        New-Item -ItemType Directory -Force -Path $outDir | Out-Null
    }
    Set-Content -LiteralPath $resolvedOutFile -Value $json -Encoding UTF8
}

$json
