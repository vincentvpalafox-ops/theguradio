# cPanel Runner Execution Runbook

## Purpose
- Create the dedicated preview page without using `wp-admin`.
- Keep `/` unchanged.
- Preserve a clean rollback path.

## Upload Target
- Upload to:
  - `/home/thegalla/public_html/gu-homepage-preview-create-0028.php`

## Create Step
1. Upload `tools/gu-homepage-preview-create-0028.php` through the existing cPanel/Fileman workflow.
2. Request:
   - `https://theguradio.com/gu-homepage-preview-create-0028.php`
3. Save the JSON response for the pass record.

## Expected JSON Fields
- `action`
- `page_id`
- `page_url`
- `slug`
- `page_on_front_before`
- `page_on_front_after`
- `front_page_unchanged`
- `self_deleted`

## Immediate Verification
1. Confirm the runner URL itself now returns `404` or otherwise no longer exposes the file after execution.
2. Run:

```powershell
powershell -ExecutionPolicy Bypass -File .\PASS_HANDOFF_0027_2026-04-24\tools\Invoke-HomepagePreviewVerification.ps1 `
  -PreviewUrl https://theguradio.com/archive-homepage-preview/ `
  -OutFile .\PASS_HANDOFF_0028_2026-04-24\preview_post_create_verification.json
```

3. Confirm:
   - preview page returns `200`
   - markers all present
   - no raw shortcode output
   - no `Private Review` copy
   - `/`, `/archive/`, `/history/`, `/performances/`, `/search/` remain healthy

## Rollback If Needed
1. Upload:
   - `tools/gu-homepage-preview-remove-0028.php`
   - to `/home/thegalla/public_html/gu-homepage-preview-remove-0028.php`
2. Request:
   - `https://theguradio.com/gu-homepage-preview-remove-0028.php`
3. Confirm:
   - preview page returns `404`
   - runner self-deletes
   - `/` remains unchanged

## Hard Boundary
- Do not switch `page_on_front`.
- Do not edit page `7127`.
- Do not use the automatic front-page interception path in this pass.
