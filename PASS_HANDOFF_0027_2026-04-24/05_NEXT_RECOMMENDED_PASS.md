# Next Recommended Pass

## Recommended Pass Name
- `PASS 0028: Homepage Shortcode Preview Proof`

## Goal
- Create the preview page in WordPress and immediately verify it with the operator packet from pass `0026` and the script from this pass.

## Scope
- Log into `https://theguradio.com/wp-admin/`
- Create the preview page using `[gu_scene_archive_homepage]`
- Run:
  - `PASS_HANDOFF_0027_2026-04-24/tools/Invoke-HomepagePreviewVerification.ps1`
- Capture both the script output and human review notes
- Leave `/` unchanged

## Acceptance Criteria
- Preview page exists and returns `200`
- Preview page contains the expected archive-home markers
- No raw shortcode output appears
- No `Private Review` copy appears
- Core archive routes remain healthy
- No `page_on_front` switch occurs
