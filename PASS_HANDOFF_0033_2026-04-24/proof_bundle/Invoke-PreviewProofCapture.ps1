param(
    [Parameter(Mandatory = $true)]
    [string]$CreateResponseFile,

    [string]$PreviewUrl = 'https://theguradio.com/archive-homepage-preview/',

    [string]$VerifierScript,

    [string]$OutDir
)

function Resolve-AbsolutePath {
    param(
        [Parameter(Mandatory = $true)]
        [string]$PathValue
    )

    return $ExecutionContext.SessionState.Path.GetUnresolvedProviderPathFromPSPath($PathValue)
}

function Normalize-Url {
    param(
        [string]$Url
    )

    if (-not $Url) {
        return ''
    }

    return ([string]$Url).TrimEnd('/')
}

$resolvedCreateResponseFile = Resolve-AbsolutePath -PathValue $CreateResponseFile
if (-not (Test-Path -LiteralPath $resolvedCreateResponseFile)) {
    throw "Create response file not found: $resolvedCreateResponseFile"
}

if (-not $VerifierScript) {
    $VerifierScript = Join-Path -Path $PSScriptRoot -ChildPath 'Invoke-HomepagePreviewVerification.ps1'
}
$resolvedVerifierScript = Resolve-AbsolutePath -PathValue $VerifierScript
if (-not (Test-Path -LiteralPath $resolvedVerifierScript)) {
    throw "Verifier script not found: $resolvedVerifierScript"
}

if (-not $OutDir) {
    $OutDir = Join-Path -Path $PSScriptRoot -ChildPath 'proof_capture_output'
}
$resolvedOutDir = Resolve-AbsolutePath -PathValue $OutDir
if (-not (Test-Path -LiteralPath $resolvedOutDir)) {
    New-Item -ItemType Directory -Force -Path $resolvedOutDir | Out-Null
}

$createResponse = Get-Content -Raw -LiteralPath $resolvedCreateResponseFile | ConvertFrom-Json
$normalizedPreviewUrl = Normalize-Url -Url $PreviewUrl
$normalizedPageUrl = Normalize-Url -Url ([string]$createResponse.page_url)
$runnerUrlMatchesPreview = ($normalizedPageUrl -ne '') -and ($normalizedPageUrl -eq $normalizedPreviewUrl)
$runnerOk = ($createResponse.ok -eq $true) -and ($createResponse.front_page_unchanged -eq $true) -and ($runnerUrlMatchesPreview -eq $true)

$verifierJsonPath = Join-Path -Path $resolvedOutDir -ChildPath 'preview_verification.json'
$verifierStdout = & powershell -ExecutionPolicy Bypass -File $resolvedVerifierScript -PreviewUrl $PreviewUrl -OutFile $verifierJsonPath

if (Test-Path -LiteralPath $verifierJsonPath) {
    $verifier = Get-Content -Raw -LiteralPath $verifierJsonPath | ConvertFrom-Json
} else {
    $verifier = $verifierStdout | ConvertFrom-Json
}

$summary = [ordered]@{
    generated_at = (Get-Date).ToString('s')
    preview_url = $PreviewUrl
    runner = [ordered]@{
        ok = [bool]$createResponse.ok
        action = [string]$createResponse.action
        page_id = $createResponse.page_id
        page_url = [string]$createResponse.page_url
        front_page_unchanged = [bool]$createResponse.front_page_unchanged
        self_deleted = [bool]$createResponse.self_deleted
        page_url_matches_preview = $runnerUrlMatchesPreview
        runner_ok = $runnerOk
    }
    verifier = [ordered]@{
        preview_status_code = [int]$verifier.preview_status_code
        preview_markers_ok = [bool]$verifier.preview_markers_ok
        preview_disallowed_ok = [bool]$verifier.preview_disallowed_ok
        routes_ok = [bool]$verifier.routes_ok
        overall_pass = [bool]$verifier.overall_pass
    }
    overall_pass = ($runnerOk -and ($verifier.overall_pass -eq $true))
}

$summaryJson = $summary | ConvertTo-Json -Depth 6
$summaryJsonPath = Join-Path -Path $resolvedOutDir -ChildPath 'preview_proof_capture.json'
$summaryMarkdownPath = Join-Path -Path $resolvedOutDir -ChildPath 'preview_proof_capture.md'

$summaryMarkdown = @(
    '# Preview Proof Capture'
    ''
    '## Runner Result'
    "- ``ok``: ``$($summary.runner.ok)``"
    "- ``action``: ``$($summary.runner.action)``"
    "- ``page_id``: ``$($summary.runner.page_id)``"
    "- ``page_url``: ``$($summary.runner.page_url)``"
    "- ``front_page_unchanged``: ``$($summary.runner.front_page_unchanged)``"
    "- ``self_deleted``: ``$($summary.runner.self_deleted)``"
    "- ``page_url_matches_preview``: ``$($summary.runner.page_url_matches_preview)``"
    "- ``runner_ok``: ``$($summary.runner.runner_ok)``"
    ''
    '## Verifier Result'
    "- ``preview_status_code``: ``$($summary.verifier.preview_status_code)``"
    "- ``preview_markers_ok``: ``$($summary.verifier.preview_markers_ok)``"
    "- ``preview_disallowed_ok``: ``$($summary.verifier.preview_disallowed_ok)``"
    "- ``routes_ok``: ``$($summary.verifier.routes_ok)``"
    "- ``overall_pass``: ``$($summary.verifier.overall_pass)``"
    ''
    '## Final Result'
    "- ``overall_pass``: ``$($summary.overall_pass)``"
) -join "`r`n"

Set-Content -LiteralPath $summaryJsonPath -Value $summaryJson -Encoding UTF8
Set-Content -LiteralPath $summaryMarkdownPath -Value $summaryMarkdown -Encoding UTF8

$summaryJson
