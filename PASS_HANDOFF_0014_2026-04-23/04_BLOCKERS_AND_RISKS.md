# Blockers And Risks

## Remaining blocker

- Both qualifying archive records still lack canonical `gu_original_url` values:
  - `Gallatin Valley Venue Memory Project`
  - `Bozeman Flyer Archive`

Because the normalization workflow only backfills `scene_source` from canonical source URLs, it still has no evidence it can use to assign source labels safely.

## Remaining risk

- The old live template-controller file remains on disk as a backup:
  - `class-gu-scene-archive-template-controller.pre-codex-0014-20260423-233431.php`
- That is intentional for rollback safety, but it should not remain indefinitely without an explicit retention decision.

## Resolved blocker

- The public `/history/` route blocker is resolved.
- The missing `history_topic` blocker on the live history record is resolved.
