# Next Recommended Pass

## Recommended Pass Name
- `PASS 0029: Homepage Shortcode Preview Proof Via Runner`

## Goal
- Create the non-front-page preview page through the existing cPanel/Fileman runner workflow and verify it immediately.

## Scope
- Upload `PASS_HANDOFF_0028_2026-04-24/tools/gu-homepage-preview-create-0028.php`
- Execute it once from the public root
- Capture the JSON response
- Run:
  - `PASS_HANDOFF_0027_2026-04-24/tools/Invoke-HomepagePreviewVerification.ps1`
- Confirm `/` remains unchanged
- If the preview fails, execute the cleanup runner from this pass

## Acceptance Criteria
- `https://theguradio.com/archive-homepage-preview/` returns `200`
- The JSON response confirms `front_page_unchanged = true`
- The pass `0027` verifier reports:
  - `preview_status_code = 200`
  - `preview_markers_ok = true`
  - `preview_disallowed_ok = true`
  - `routes_ok = true`
- No `page_on_front` change occurs
