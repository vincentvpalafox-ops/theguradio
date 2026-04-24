# Deploy Usage

## Purpose

This script is the execution wrapper for the already-prepared maintenance-file bundle from pass `0009`.

It does three things:

1. verifies the local bundle hash before upload
2. uploads the file to a timestamped remote temp path
3. backs up the current remote file, promotes the upload, and verifies the remote SHA-256

## Default Mode

The script is dry-run by default.

Example:

```powershell
powershell -ExecutionPolicy Bypass -File .\PASS_HANDOFF_0011_2026-04-23\deploy_tools\Invoke-MaintenanceDeploy.ps1 -HostName theguradio.com -UserName thegalla
```

This prints the exact `scp` and `ssh` commands without making remote changes.

## Execute Mode

Only use execute mode after valid authentication exists.

```powershell
powershell -ExecutionPolicy Bypass -File .\PASS_HANDOFF_0011_2026-04-23\deploy_tools\Invoke-MaintenanceDeploy.ps1 -HostName theguradio.com -UserName thegalla -Execute
```

## Expected Bundle Source

The script defaults to the bundle file from pass `0009`:

`PASS_HANDOFF_0009_2026-04-23/deploy_bundle/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php`

## Expected Remote Target

`/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php`

## After Deployment

1. Open the WordPress admin maintenance screen.
2. Run `Normalize Homepage Archive Metadata` once.
3. Inspect the review table.
4. Re-audit only the homepage-visible archive/history cards affected by that action.
