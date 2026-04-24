# 05 NEXT RECOMMENDED PASS

## Next Recommended Pass (Targeted)

- Deploy this maintenance-file change to the live plugin and run `Normalize Homepage Archive Metadata` once, then re-audit the visible archive/history cards only

Why:
- this pass created the smallest available execution path for the accepted metadata-cleanup scope
- the new action can now backfill provable `scene_source` terms without guessing public content
- the immediate next truth check is whether the live records actually normalize cleanly and which history-topic gaps remain evidence-blocked

Scope:
- deploy only `class-gu-scene-archive-maintenance.php`
- run the new admin maintenance action once
- re-check the visible archive/history cards on `review-home`
- do not redesign layout
- do not rewrite copy
- do not widen into performance-card cleanup yet

Do not:
- invent `history_topic` values
- turn this into a broader archive-seeding pass
- touch public text or page structure in the same pass
- widen into provider/search work

Likely files affected:
- live plugin file deployment only
- production/admin taxonomy assignments for homepage-supporting `archive_item` records
- next handoff package only

Acceptance criteria:
- source-label backfills run successfully where canonical source hosts are provable
- summary output shows whether any history-class records remain evidence-blocked
- a follow-up audit can state exactly what improved on the visible archive/history surface

## Codex Behavior Check

Was Codex used in this pass:
- Yes

Expected behavior for next pass:
- Deploy-and-run maintenance only
- No creative generation
- No redesign
- No multi-task prompt chaining
