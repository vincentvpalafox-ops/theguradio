# Next Recommended Pass

## Recommended Pass Name
- `PASS 0033: Homepage Shortcode Preview Proof From One-Shot Bundle`

## Goal
- Execute the preview-page proof from the packaged `proof_bundle` immediately after manual hosting reauthentication.

## Scope
- Reauthenticate to the live cPanel/Fileman surface
- Upload `proof_bundle/gu-homepage-preview-create-0028.php`
- Execute it once
- Save the JSON response
- Run:
  - `proof_bundle/Invoke-HomepagePreviewVerification.ps1`
- If the preview fails, upload and execute:
  - `proof_bundle/gu-homepage-preview-remove-0028.php`
- Keep `/` unchanged

## Acceptance Criteria
- preview page returns `200`
- `front_page_unchanged = true`
- verifier returns:
  - `preview_markers_ok = true`
  - `preview_disallowed_ok = true`
  - `routes_ok = true`
- no `page_on_front` change occurs
