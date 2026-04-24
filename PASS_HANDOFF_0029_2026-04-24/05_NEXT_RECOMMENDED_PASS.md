# Next Recommended Pass

## Recommended Pass Name
- `PASS 0030: Homepage Shortcode Preview Proof Via Reauthenticated Upload`

## Goal
- Execute the already-prepared preview-page proof immediately after a real hosting re-authentication event.

## Scope
- Reauthenticate to the live cPanel/Fileman surface
- Upload `PASS_HANDOFF_0028_2026-04-24/tools/gu-homepage-preview-create-0028.php`
- Execute it once
- Save the JSON response
- Run:
  - `PASS_HANDOFF_0027_2026-04-24/tools/Invoke-HomepagePreviewVerification.ps1`
- If the preview fails, run:
  - `PASS_HANDOFF_0028_2026-04-24/tools/gu-homepage-preview-remove-0028.php`
- Keep `/` unchanged

## Acceptance Criteria
- preview page returns `200`
- `front_page_unchanged = true`
- pass `0027` verifier returns:
  - `preview_markers_ok = true`
  - `preview_disallowed_ok = true`
  - `routes_ok = true`
- no `page_on_front` change occurs
