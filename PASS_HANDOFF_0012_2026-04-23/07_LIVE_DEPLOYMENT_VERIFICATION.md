# Live Deployment Verification

## Deployment source

- Local deployment source:
  - `PASS_HANDOFF_0009_2026-04-23/deploy_bundle/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php`
- Expected SHA-256:
  - `9AC1E208FCAB9A6498FC40B28EF8B87D865C5C6551B4A81104BDF6CDCD0A7DDA`
- Expected size:
  - `48431` bytes

## Pre-deploy live state

- Remote target:
  - `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php`
- Pulled pre-deploy live file through Fileman `get_file_content`.
- Pre-deploy SHA-256:
  - `CCA41A13193912F5F130DE7C1994235667A3540C4E0D37C2A1AF7205FD4CC200`
- Pre-deploy size:
  - `36308` bytes

## Swap sequence

1. Uploaded the approved bundle as temporary file:
   - `class-gu-scene-archive-maintenance.codex-upload-0012-20260423-232200.php`
2. Verified the temporary upload by size and SHA-256:
   - `9AC1E208FCAB9A6498FC40B28EF8B87D865C5C6551B4A81104BDF6CDCD0A7DDA`
3. Renamed the existing live file to backup:
   - `class-gu-scene-archive-maintenance.pre-codex-0012-20260423-232200.php`
4. Renamed the verified temporary upload into:
   - `class-gu-scene-archive-maintenance.php`

## Post-deploy verification

- Pulled the live file again through Fileman `get_file_content`.
- Post-deploy live SHA-256:
  - `9AC1E208FCAB9A6498FC40B28EF8B87D865C5C6551B4A81104BDF6CDCD0A7DDA`
- Post-deploy live size:
  - `48431` bytes
- Pulled the backup file and verified it preserved the previous live bytes:
  - backup SHA-256: `CCA41A13193912F5F130DE7C1994235667A3540C4E0D37C2A1AF7205FD4CC200`
  - backup size: `36308` bytes

## Public-site smoke check

- Requested `https://theguradio.com/`
- HTTP status: `200`
- Response-body scan:
  - `Fatal error`: not present
  - `There has been a critical error`: not present
  - `Briefly unavailable for scheduled maintenance`: not present

## Cleanup performed

- Removed the earlier probe artifact `/home/thegalla/public_html/gu-codex-save-test.txt`
- Removed the disposable plugin-directory probe file before the production swap
