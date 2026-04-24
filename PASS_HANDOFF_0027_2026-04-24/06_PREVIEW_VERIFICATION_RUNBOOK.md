# Preview Verification Runbook

## Purpose
- Validate the future homepage preview page immediately after it is created.

## Command
```powershell
powershell -ExecutionPolicy Bypass -File .\PASS_HANDOFF_0027_2026-04-24\tools\Invoke-HomepagePreviewVerification.ps1 `
  -PreviewUrl https://theguradio.com/archive-homepage-preview/ `
  -OutFile .\PASS_HANDOFF_0027_2026-04-24\preview_verification_probe.json
```

## What The Script Checks
- Preview URL HTTP status
- `/`, `/archive/`, `/history/`, `/performances/`, `/search/` HTTP status
- Presence of archive-home render markers:
  - `gu-homepage`
  - `gu-homepage-opening`
  - `gu-homepage-performances`
  - `gu-homepage-archive`
  - `gu-homepage-history`
  - `gu-homepage-community`
  - `gu-homepage-closing`
- Absence of:
  - raw `[gu_scene_archive_homepage]`
  - `Private Review`

## How To Read Results
- `preview_status_code = 200` is required.
- `preview_markers_ok = true` is required.
- `preview_disallowed_ok = true` is required.
- `routes_ok = true` is required.
- `overall_pass = true` means the preview proof passed structurally.

## What To Do After The Script
- Open the preview page manually.
- Confirm the page is clearly the archive-backed homepage and not the current legacy playlist/livestream front page.
- Record any copy or layout concerns in the next handoff.

## What Not To Do
- Do not run this against `/` as a substitute for the preview-page proof.
- Do not switch `page_on_front` based only on assumptions.
- Do not overwrite page `7127` during the preview proof pass.
