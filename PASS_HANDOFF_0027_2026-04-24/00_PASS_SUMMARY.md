# PASS 0027 Summary

## Pass Identity
- Pass: `0027`
- Date: `2026-04-24`
- Scope: `Homepage Preview Verification Harness`
- Repo/branch reviewed: `main`
- Repo head at start: `0eaa539`

## What Changed
- Created the `PASS_HANDOFF_0027_2026-04-24` verification package.
- Added a local verification script to check a future homepage preview page without modifying the site.
- Hardened the script to use `curl.exe` for reliable public status/body capture and explicit JSON artifact output.
- Captured a baseline verification run against the recommended preview URL.
- No product code changed.
- No deployment occurred.
- No WordPress content or options were edited.

## Files Modified
- `PASS_HANDOFF_0027_2026-04-24/00_PASS_SUMMARY.md`
- `PASS_HANDOFF_0027_2026-04-24/01_FILES_CHANGED.md`
- `PASS_HANDOFF_0027_2026-04-24/02_BUILD_TEST_STATUS.md`
- `PASS_HANDOFF_0027_2026-04-24/03_NOT_CHANGED.md`
- `PASS_HANDOFF_0027_2026-04-24/04_BLOCKERS_AND_RISKS.md`
- `PASS_HANDOFF_0027_2026-04-24/05_NEXT_RECOMMENDED_PASS.md`
- `PASS_HANDOFF_0027_2026-04-24/06_PREVIEW_VERIFICATION_RUNBOOK.md`
- `PASS_HANDOFF_0027_2026-04-24/07_PREVIEW_VERIFICATION_SCRIPT_NOTES.md`
- `PASS_HANDOFF_0027_2026-04-24/tools/Invoke-HomepagePreviewVerification.ps1`
- `PASS_HANDOFF_0027_2026-04-24/preview_verification_probe.json`

## Result
- The verification harness is ready for the future preview-page proof.
- Baseline run against `https://theguradio.com/archive-homepage-preview/` produced the expected pre-preview result:
  - preview URL returned `404`
  - route health for `/`, `/archive/`, `/history/`, `/performances/`, and `/search/` remained `200`
- This package now gives the operator with `wp-admin` access a concrete way to verify the preview page immediately after creation and before any front-door activation.

## What Was Not Changed
- Plugin PHP
- Theme/templates
- Live homepage page `7127`
- WordPress Reading settings
- Any WordPress page/post/taxonomy content
- Any deploy helper or remote file

## Tests / Checks Run
- Current route-health confirmation for `/`, `/archive/`, `/history/`, `/performances/`, `/search/`
- Local script execution against the recommended preview URL
- `git diff --check`
- `git diff --cached --check`

## Blockers / Risks
- The actual preview-page creation still requires legitimate `wp-admin` access.
- This harness validates the preview after creation, but it does not create the page.

## Recommended Next Step
- Use the operator packet from pass `0026` to create the preview page.
- Immediately run `tools/Invoke-HomepagePreviewVerification.ps1` from this pass against that preview URL.
- If the preview passes, document the evidence in the next pass before any `page_on_front` switch.
