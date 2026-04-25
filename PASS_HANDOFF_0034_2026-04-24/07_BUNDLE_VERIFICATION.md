# Bundle Verification

## Current Live Baseline
- `/` -> `200`
- `/archive-homepage-preview/` -> `404`

## Integrity Script Behavior
- checks presence and SHA-256 of:
  - `gu-homepage-preview-create-0028.php`
  - `gu-homepage-preview-remove-0028.php`
  - `Invoke-HomepagePreviewVerification.ps1`
  - `Invoke-PreviewProofCapture.ps1`
- emits:
  - `proof_bundle_integrity.json`
  - `proof_bundle_integrity.md`
