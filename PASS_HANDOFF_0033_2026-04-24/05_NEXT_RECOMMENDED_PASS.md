# Next Recommended Pass

## Recommended Pass Name
- `PASS 0034: Homepage Shortcode Preview Proof With Capture Wrapper`

## Goal
- Execute the preview-page proof from the packaged `proof_bundle` immediately after manual hosting reauthentication and capture one canonical proof summary.

## Scope
- Reauthenticate to the live cPanel/Fileman surface
- Upload `proof_bundle/gu-homepage-preview-create-0028.php`
- Execute it once and save the JSON response to a local file
- Run:
  - `proof_bundle/Invoke-PreviewProofCapture.ps1`
- If the preview fails, upload and execute:
  - `proof_bundle/gu-homepage-preview-remove-0028.php`
- Keep `/` unchanged

## Acceptance Criteria
- preview page returns `200`
- `front_page_unchanged = true`
- capture wrapper returns:
  - `runner.runner_ok = true`
  - `verifier.overall_pass = true`
  - `overall_pass = true`
- no `page_on_front` change occurs
