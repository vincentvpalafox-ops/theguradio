# PASS HANDOFF 0012 - LIVE MAINTENANCE FILE DEPLOY

## What was changed

This pass executed the previously-prepared maintenance-file deployment to the live site using authenticated cPanel Fileman APIs.

- Replaced the live `class-gu-scene-archive-maintenance.php` file at `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/includes/` with the already-approved deployment bundle from pass `0009`.
- Preserved the previous live file as `class-gu-scene-archive-maintenance.pre-codex-0012-20260423-232200.php` in the same remote directory.
- Removed the earlier probe artifact `public_html/gu-codex-save-test.txt` from the live account.
- Added this handoff package for review.

## Results

- Live pre-deploy maintenance-file hash: `CCA41A13193912F5F130DE7C1994235667A3540C4E0D37C2A1AF7205FD4CC200`
- Live post-deploy maintenance-file hash: `9AC1E208FCAB9A6498FC40B28EF8B87D865C5C6551B4A81104BDF6CDCD0A7DDA`
- Expected deployment bundle hash: `9AC1E208FCAB9A6498FC40B28EF8B87D865C5C6551B4A81104BDF6CDCD0A7DDA`
- Public homepage returned HTTP `200` after deployment, with no detected fatal-error or maintenance-mode markers in the response body.

## Recommended next step

Use WordPress admin to run `Normalize Homepage Archive Metadata` once, then review the maintenance screen output and the homepage-visible archive/history cards.
