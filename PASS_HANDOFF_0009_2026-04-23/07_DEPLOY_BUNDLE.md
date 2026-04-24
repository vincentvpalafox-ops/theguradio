# 07 DEPLOY BUNDLE

## What This Pass Added

- a plugin-relative deployment bundle:
  - `PASS_HANDOFF_0009_2026-04-23/deploy_bundle/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php`
- a bundle manifest describing:
  - expected live target path
  - source path
  - checksum and file-size integrity data
  - usage constraints

## Why This Was The Right Bounded Pass

- the previous pass isolated the exact file to deploy
- this pass removed path ambiguity by placing that file inside the expected plugin-relative structure
- it stays inside the accepted scope: deployment preparation for the homepage archive metadata maintenance workflow

## Important Constraints

- the bundle is a copy, not the canonical source
- if the tracked maintenance source changes later, this bundle must not be reused without revalidation
- no claim is made that the file is live until deployment and one admin run are completed
