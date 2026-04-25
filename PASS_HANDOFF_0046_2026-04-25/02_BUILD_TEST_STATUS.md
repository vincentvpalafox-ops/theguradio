# Tests And Checks Run

## Proof Bundle Integrity

- Command: `PASS_HANDOFF_0034_2026-04-24/proof_bundle/Invoke-PreviewProofBundleIntegrity.ps1`
- Result: pass
- Evidence: `evidence_proof_bundle_integrity.json`

## Preview Creation

- The one-time preview create runner executed successfully
- Result: page `23758` created/updated at `/archive-homepage-preview/`
- `page_on_front_before = 7127`
- `page_on_front_after = 7127`
- Evidence: `evidence_create_runner_response.json`

## Live Runtime Diagnosis

- Shortcode diagnostic runner confirmed:
  - plugin active
  - shortcode classes loaded
  - `gu_scene_archive_homepage` shortcode registered
  - runtime plugin instance contains `record_manager`, `section_shortcodes`, and `playlist_shortcodes`
- Evidence: `evidence_shortcode_diagnostic.json`

## Live File Verification

- Live `class-gu-scene-archive-plugin.php` hash matched the approved local file
- Live `class-gu-scene-archive-section-shortcodes.php` hash matched the approved local file
- Evidence: `evidence_plugin_live_file.json`, `evidence_section_shortcodes_live_file.json`

## Final Preview Proof

- Command: `PASS_HANDOFF_0034_2026-04-24/proof_bundle/Invoke-PreviewProofCapture.ps1`
- Final result:
  - `preview_status_code = 200`
  - `preview_markers_ok = true`
  - `preview_disallowed_ok = true`
  - `routes_ok = true`
  - `overall_pass = true`
- Evidence: `evidence_preview_proof_capture.json`, `evidence_preview_verification.json`

## Route Health

The final proof also confirmed:

- `/` -> `200`
- `/archive/` -> `200`
- `/history/` -> `200`
- `/performances/` -> `200`
- `/search/` -> `200`
- `/archive-homepage-preview/` -> `200`
