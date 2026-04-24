# 05 NEXT RECOMMENDED PASS

## Next Recommended Pass (Targeted)

- Re-establish or provide the active deployment path, then deploy only `class-gu-scene-archive-maintenance.php`, run `Normalize Homepage Archive Metadata` once, and verify the admin review output plus the visible archive/history cards

Why:
- the local maintenance workflow is already built and committed
- the blocker is now deployment access, not missing code
- the narrowest truthful next step is still the previously planned live run and verification

Scope:
- restore or provide the real deployment mechanism already used for this project
- deploy only `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php`
- run the existing maintenance action once
- inspect the `Homepage Archive Metadata Review` table
- re-audit only the homepage-visible archive/history records affected by that action

Do not:
- redesign homepage sections
- rewrite copy
- widen into performance-card cleanup
- invent `history_topic` values
- create a new deployment framework unless that becomes an explicitly approved task

Likely files affected:
- live plugin deployment only
- production taxonomy assignments for homepage-supporting `archive_item` records
- next handoff package only

Acceptance criteria:
- an authenticated deployment path is available and used successfully
- the maintenance file is live
- the normalization action runs successfully once
- the review table shows concrete changed versus blocked records
- visible archive/history cards can be re-audited with real live results

## Codex Behavior Check

Was Codex used in this pass:
- Yes

Expected behavior for next pass:
- Deploy-and-verify only
- No creative generation
- No redesign
- No multi-task prompt chaining
