# Next Recommended Pass

## Recommended Pass Name
- `PASS 0035: Homepage Shortcode Preview Proof With Integrity Gate`

## Goal
- Execute the preview-page proof from the packaged `proof_bundle` immediately after manual hosting reauthentication, starting with a local integrity check.

## Scope
- Reauthenticate to the live cPanel/Fileman surface
- Run:
  - `proof_bundle/Invoke-PreviewProofBundleIntegrity.ps1`
- If it passes:
  - upload `proof_bundle/gu-homepage-preview-create-0028.php`
  - save the create-runner JSON response
  - run `proof_bundle/Invoke-PreviewProofCapture.ps1`
- If the preview fails, upload and execute:
  - `proof_bundle/gu-homepage-preview-remove-0028.php`
- Keep `/` unchanged

## Acceptance Criteria
- integrity check returns `overall_pass = true`
- preview page returns `200`
- capture wrapper returns:
  - `runner.runner_ok = true`
  - `verifier.overall_pass = true`
  - `overall_pass = true`
- no `page_on_front` change occurs
