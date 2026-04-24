# Access Recovery Runbook

## Purpose
- Stop spending time on more passive discovery from this workspace.
- Move directly to the one manual event that can unblock the preview proof.

## What The Diagnostics Proved
- A real recent `wp-admin` operator session existed in Chrome `Profile 1`.
- The current main Chrome process is still that profile with `--restore-last-session`.
- No remote-debugging port is available for attachment.
- No reusable cPanel/theguradio hosting credential entry is visible in Windows credential stores.
- Direct `ssh` is still denied.

## What Must Happen Next
1. Reauthenticate manually to the live hosting/cPanel/Fileman surface.
2. Do not activate `/`.
3. Do not edit page `7127`.
4. Use pass `0028` immediately after re-authentication.

## Exact Execution Sequence After Reauthentication
1. Upload:
   - `PASS_HANDOFF_0028_2026-04-24/tools/gu-homepage-preview-create-0028.php`
2. Execute:
   - `https://theguradio.com/gu-homepage-preview-create-0028.php`
3. Save the JSON response.
4. Run:

```powershell
powershell -ExecutionPolicy Bypass -File .\PASS_HANDOFF_0027_2026-04-24\tools\Invoke-HomepagePreviewVerification.ps1 `
  -PreviewUrl https://theguradio.com/archive-homepage-preview/ `
  -OutFile .\PASS_HANDOFF_0030_2026-04-24\preview_post_create_verification.json
```

5. If the preview fails structurally, upload and execute the cleanup runner from pass `0028`.

## Hard Boundary
- No `page_on_front` switch.
- No automatic front-page interception activation.
- No changes to the live front-page page `7127`.
