param(
    [string]$OutDir
)

if (-not $OutDir) {
    $OutDir = Join-Path -Path $PSScriptRoot -ChildPath 'integrity_check_output'
}

$resolvedOutDir = $ExecutionContext.SessionState.Path.GetUnresolvedProviderPathFromPSPath($OutDir)
if (-not (Test-Path -LiteralPath $resolvedOutDir)) {
    New-Item -ItemType Directory -Force -Path $resolvedOutDir | Out-Null
}

$expected = [ordered]@{
    'gu-homepage-preview-create-0028.php' = '8013166B91E2A0834EE45AA41E83CBA17F1114CEE16112320943A0BC6FB4BA85'
    'gu-homepage-preview-remove-0028.php' = '1A55FEAE7FA536A16CCD1695932454BBEEBE70D2FD3A5A3C0FE2B31AD3E92E1F'
    'Invoke-HomepagePreviewVerification.ps1' = 'BBD4BBAE5FDA013FC210323407B91236C78932B5280C9014C932E4B87E3DBA69'
    'Invoke-PreviewProofCapture.ps1' = '1B69FD526E3CA9193D5FBBB052FCEEE473AE46F0288DF602393BD928EB53E692'
}

$files = New-Object System.Collections.Generic.List[object]
foreach ($fileName in $expected.Keys) {
    $filePath = Join-Path -Path $PSScriptRoot -ChildPath $fileName
    $exists = Test-Path -LiteralPath $filePath
    $actualHash = ''
    if ($exists) {
        $actualHash = (Get-FileHash -Algorithm SHA256 -LiteralPath $filePath).Hash
    }

    $files.Add([pscustomobject]@{
        file = $fileName
        exists = $exists
        expected_hash = $expected[$fileName]
        actual_hash = $actualHash
        match = ($exists -and ($actualHash -eq $expected[$fileName]))
    })
}

$overallPass = @($files | Where-Object { -not $_.match }).Count -eq 0

$summary = [ordered]@{
    generated_at = (Get-Date).ToString('s')
    overall_pass = $overallPass
    files = @($files | ForEach-Object {
        [pscustomobject]@{
            file = $_.file
            exists = $_.exists
            expected_hash = $_.expected_hash
            actual_hash = $_.actual_hash
            match = $_.match
        }
    })
}

$json = $summary | ConvertTo-Json -Depth 5
$jsonPath = Join-Path -Path $resolvedOutDir -ChildPath 'proof_bundle_integrity.json'
$mdPath = Join-Path -Path $resolvedOutDir -ChildPath 'proof_bundle_integrity.md'

$md = @(
    '# Proof Bundle Integrity'
    ''
    "- ``overall_pass``: ``$overallPass``"
    ''
    '## Files'
) + @($files | ForEach-Object {
    "- ``$($_.file)``: exists=``$($_.exists)`` match=``$($_.match)``"
})

Set-Content -LiteralPath $jsonPath -Value $json -Encoding UTF8
Set-Content -LiteralPath $mdPath -Value ($md -join "`r`n") -Encoding UTF8

$json
