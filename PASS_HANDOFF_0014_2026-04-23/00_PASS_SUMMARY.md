# PASS HANDOFF 0014 - HISTORY ROUTE RESTORE AND HISTORY-TOPIC CORRECTION

## What was changed

This pass corrected the two live issues exposed by pass `0013` that were safe to fix from existing evidence:

- Replaced the live `class-gu-scene-archive-template-controller.php` file with the newer local version that includes `/history/` route handling and history-template overrides.
- Preserved the prior live template-controller file as a timestamped backup in the same remote directory.
- Assigned the existing `venue-legacy` history topic to `Gallatin Valley Venue Memory Project`, based on the record title and excerpt.
- Flushed WordPress rewrite rules.
- Re-ran the live homepage-archive metadata normalization and follow-up archive audit.

## Results

- `https://theguradio.com/history/` now resolves correctly and renders the history archive surface.
- `https://theguradio.com/history-topic/venue-legacy/` now resolves correctly and includes `Gallatin Valley Venue Memory Project`.
- `Gallatin Valley Venue Memory Project` now has `history_topic = venue-legacy`.
- Maintenance summary improved:
  - `history_topic_evidence_blocked`: `0` (was `1`)
  - `history_records_missing_history_topic`: `0` (was `1`)
- The remaining source-url blocker did not change:
  - `records_updated`: `0`
  - `source_backfills`: `0`
  - `source_skipped_no_url`: `2`

## Recommended next step

Finish the remaining bounded data-correction slice:

1. Add evidence-backed canonical `gu_original_url` values to:
   - `Gallatin Valley Venue Memory Project`
   - `Bozeman Flyer Archive`
2. Re-run the same normalization verification pass.
3. Confirm `source_backfills > 0` and `source_skipped_no_url = 0`.
