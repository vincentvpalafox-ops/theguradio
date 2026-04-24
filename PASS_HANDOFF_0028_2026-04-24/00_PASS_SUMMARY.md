# PASS 0028 Summary

## Pass Identity
- Pass: `0028`
- Date: `2026-04-24`
- Scope: `Homepage Preview Page Runner Packet`
- Repo/branch reviewed: `main`
- Repo head at start: `8dfdefe`

## What Changed
- Created the `PASS_HANDOFF_0028_2026-04-24` execution packet for the blocked homepage preview proof.
- Added a one-time WordPress runner that creates or updates the non-front-page preview page:
  - title: `Archive Homepage Preview`
  - slug: `archive-homepage-preview`
  - content: `[gu_scene_archive_homepage]`
- Added a paired cleanup runner that trashes that preview page if the proof needs to be rolled back.
- Added a cPanel/Fileman runbook that uses the existing live runner pattern instead of `wp-admin`.
- Rechecked the current live state:
  - `/` still returns `200`
  - `/archive-homepage-preview/` still returns `404`
  - direct shell access to `thegalla@theguradio.com` is still denied
- No product code changed.
- No deployment occurred.
- No WordPress content or options were edited in this pass.

## Files Modified
- `PASS_HANDOFF_0028_2026-04-24/00_PASS_SUMMARY.md`
- `PASS_HANDOFF_0028_2026-04-24/01_FILES_CHANGED.md`
- `PASS_HANDOFF_0028_2026-04-24/02_BUILD_TEST_STATUS.md`
- `PASS_HANDOFF_0028_2026-04-24/03_NOT_CHANGED.md`
- `PASS_HANDOFF_0028_2026-04-24/04_BLOCKERS_AND_RISKS.md`
- `PASS_HANDOFF_0028_2026-04-24/05_NEXT_RECOMMENDED_PASS.md`
- `PASS_HANDOFF_0028_2026-04-24/06_CPANEL_RUNNER_EXECUTION_RUNBOOK.md`
- `PASS_HANDOFF_0028_2026-04-24/07_PREVIEW_PAGE_RUNNER_NOTES.md`
- `PASS_HANDOFF_0028_2026-04-24/tools/gu-homepage-preview-create-0028.php`
- `PASS_HANDOFF_0028_2026-04-24/tools/gu-homepage-preview-remove-0028.php`

## Result
- The preview-page proof is still blocked from this workspace by missing authenticated live access.
- The remaining execution gap is now smaller:
  - upload one runner
  - hit one URL
  - run the existing verifier from pass `0027`
  - keep `/` unchanged
- A paired rollback path now exists even without `wp-admin`.

## What Was Not Changed
- Plugin PHP in `staged_remote_changes`
- Theme/templates
- Live front-page page `7127`
- WordPress `page_on_front`
- Any live WordPress page/post/taxonomy data
- Any deployed remote file

## Tests / Checks Run
- `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/`
- `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/archive-homepage-preview/`
- `ssh -o BatchMode=yes -o ConnectTimeout=10 thegalla@theguradio.com "pwd"`
- static review of the new runner files
- `git diff --check`
- `git diff --cached --check`

## Blockers / Risks
- The cPanel/Fileman authenticated path used in earlier live-mutation passes is not currently available from this workspace.
- Direct SSH remains unavailable.
- The preview proof still cannot be executed until an authenticated upload path is restored.

## Recommended Next Step
- Use the existing live cPanel/Fileman workflow to upload and execute `tools/gu-homepage-preview-create-0028.php`.
- Immediately run the pass `0027` verifier against `https://theguradio.com/archive-homepage-preview/`.
- If the preview fails structurally, upload and execute `tools/gu-homepage-preview-remove-0028.php`.
- Do not switch `page_on_front` in that pass.
