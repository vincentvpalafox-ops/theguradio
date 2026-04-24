# 07 DEPLOY SCRIPT NOTES

## What This Pass Added

- a dry-run-by-default PowerShell deployment script:
  - `deploy_tools/Invoke-MaintenanceDeploy.ps1`
- usage notes for that script:
  - `deploy_tools/DEPLOY_USAGE.md`

## What The Script Does

- resolves the maintenance-file bundle from pass `0009`
- verifies the local SHA-256 before any remote action
- prepares timestamped remote temp and backup paths
- prints exact `scp` and `ssh` commands in dry-run mode
- when `-Execute` is supplied:
  - uploads the bundle to the remote temp path
  - backs up the current remote file
  - promotes the uploaded file into place
  - verifies the remote SHA-256 against the expected hash

## What The Script Does Not Do

- it does not authenticate by itself
- it does not run the WordPress maintenance action
- it does not re-audit homepage cards
- it does not change the bundle contents from pass `0009`

## Why This Was The Right Bounded Pass

- the previous pass established that authentication is the only remaining blocker
- scripting the deploy path removes avoidable operator error once authentication is available
- it stays inside the accepted scope: deployment and verification for the homepage archive metadata maintenance workflow
