# Deploy Manifest

- Source file: `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php`
- Artifact file: `PASS_HANDOFF_0008_2026-04-23/deploy_artifact/class-gu-scene-archive-maintenance.php`
- Source file last changed in tracked history: `7033223` (`add review output for homepage metadata normalization`)
- Expected live target path:
  - `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php`
  - This target path is inferred from the current plugin structure and prior deploy/save results for sibling files in the same plugin `includes/` directory.

## Integrity Data

- SHA-256:
  - `9AC1E208FCAB9A6498FC40B28EF8B87D865C5C6551B4A81104BDF6CDCD0A7DDA`
- File size:
  - `48431` bytes
- Line count:
  - `1216`

## Verification Performed

- source and artifact SHA-256 hashes match exactly
- source and artifact byte sizes match exactly
- source and artifact line counts match exactly
- `git diff --no-index --exit-code` reported no content difference beyond line-ending warnings

## Use Rules

- deploy this file only if the target plugin is the same `gu-scene-archive` instance represented by the local tracked source
- do not deploy this artifact if the tracked source file changes later without regenerating the artifact
- after deployment, run the existing `Normalize Homepage Archive Metadata` action once and verify the admin review output
