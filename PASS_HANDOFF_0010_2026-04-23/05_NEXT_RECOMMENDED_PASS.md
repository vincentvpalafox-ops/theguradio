# 05 NEXT RECOMMENDED PASS

## Next Recommended Pass (Targeted)

- Authenticate to one of the confirmed hosting surfaces, deploy the maintenance-file bundle from pass `0009`, run `Normalize Homepage Archive Metadata` once, and verify the admin review output plus the visible archive/history cards

Why:
- the deploy artifact and plugin-relative bundle already exist
- the current blocker is now precisely defined as authentication, not host reachability or missing files
- no further local packaging is justified until an authenticated path is available

Scope:
- use a valid SSH account, authorized key, or cPanel login for one of the confirmed reachable hosts
- deploy only the bundled maintenance file from `PASS_HANDOFF_0009_2026-04-23/deploy_bundle/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php`
- place it at `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php`
- run the existing maintenance action once
- inspect the admin review table
- re-audit only the homepage-visible archive/history records affected by that action

Do not:
- redesign homepage sections
- rewrite copy
- widen into performance-card cleanup
- invent `history_topic` values
- create more local deployment artifacts unless the source file changes

Likely files affected:
- live plugin deployment only
- production taxonomy assignments for homepage-supporting `archive_item` records
- next handoff package only

Acceptance criteria:
- a working authenticated deployment path is established
- the maintenance file is placed live
- the normalization action runs successfully once
- the admin review output renders
- visible archive/history cards can be re-audited with real live results

## Codex Behavior Check

Was Codex used in this pass:
- Yes

Expected behavior for next pass:
- Authenticate, deploy, and verify only
- No creative generation
- No redesign
- No multi-task prompt chaining
