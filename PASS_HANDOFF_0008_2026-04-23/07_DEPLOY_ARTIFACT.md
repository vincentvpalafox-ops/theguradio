# 07 DEPLOY ARTIFACT

## What This Pass Added

- a deployment copy of the tracked maintenance file:
  - `PASS_HANDOFF_0008_2026-04-23/deploy_artifact/class-gu-scene-archive-maintenance.php`
- a manifest describing:
  - expected target path
  - source path
  - source commit reference
  - checksum and file-size integrity data

## Why This Was The Right Bounded Pass

- the previous pass established that deployment access, not code completeness, is the real blocker
- creating an exact single-file artifact reduces the next pass to authenticated file placement and live verification
- this avoids widening scope into unrelated product work while still moving the accepted maintenance workflow forward

## Important Constraints

- the deploy artifact is a copy, not the canonical source
- if the tracked maintenance source changes later, this artifact must not be reused without revalidation
- no claim is made that the file is live until deployment and one admin run are completed
