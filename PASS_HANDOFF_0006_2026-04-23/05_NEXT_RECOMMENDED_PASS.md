# 05 NEXT RECOMMENDED PASS

## Next Recommended Pass (Targeted)

- Deploy the updated maintenance file to the live plugin, run `Normalize Homepage Archive Metadata` once, and verify the new review table plus the visible archive/history cards

Why:
- the code path for safe normalization and record-level review now exists
- the next truth check is no longer more code; it is live execution and verification
- this remains the narrowest path to actually improving homepage-supporting archive metadata without widening scope

Scope:
- deploy only `class-gu-scene-archive-maintenance.php`
- run the existing maintenance action once
- inspect the new `Homepage Archive Metadata Review` table
- re-audit only the visible archive/history records on `review-home`

Do not:
- redesign homepage sections
- rewrite copy
- widen into performance-card cleanup
- invent `history_topic` values

Likely files affected:
- live plugin deployment only
- production taxonomy assignments for homepage-supporting `archive_item` records
- next handoff package only

Acceptance criteria:
- the maintenance action runs successfully on live
- the review table clearly shows changed versus blocked records
- visible archive/history cards can be re-audited with concrete before/after results

## Codex Behavior Check

Was Codex used in this pass:
- Yes

Expected behavior for next pass:
- Deploy-and-verify only
- No creative generation
- No redesign
- No multi-task prompt chaining
