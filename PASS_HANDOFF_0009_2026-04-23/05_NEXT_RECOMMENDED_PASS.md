# 05 NEXT RECOMMENDED PASS

## Next Recommended Pass (Targeted)

- Use the deployment bundle from this package to place `class-gu-scene-archive-maintenance.php` on the live site, then run `Normalize Homepage Archive Metadata` once and verify the admin review output plus the visible archive/history cards

Why:
- the maintenance code is already tracked and stable
- this pass reduced deployment input to a plugin-relative bundle instead of a loose file
- the next missing truth check is still live execution, not more local packaging

Scope:
- use the active deployment mechanism already used for this project
- deploy only the bundled maintenance file from `PASS_HANDOFF_0009_2026-04-23/deploy_bundle/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php`
- place it at the expected live plugin path documented in `deploy_bundle/DEPLOY_BUNDLE_MANIFEST.md`
- run the existing maintenance action once
- inspect the admin review table
- re-audit only the homepage-visible archive/history records affected by that action

Do not:
- redesign homepage sections
- rewrite copy
- widen into performance-card cleanup
- invent `history_topic` values
- make new code changes unless live verification reveals a concrete defect

Likely files affected:
- live plugin deployment only
- production taxonomy assignments for homepage-supporting `archive_item` records
- next handoff package only

Acceptance criteria:
- the bundle is deployed to the live maintenance file path
- the normalization action runs successfully once
- the admin review output renders
- visible archive/history cards can be re-audited with real live results

## Codex Behavior Check

Was Codex used in this pass:
- Yes

Expected behavior for next pass:
- Deploy-and-verify only
- No creative generation
- No redesign
- No multi-task prompt chaining
