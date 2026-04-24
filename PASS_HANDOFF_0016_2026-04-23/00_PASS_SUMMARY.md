# PASS HANDOFF 0016 - REVIEW SEED CONTAINMENT

## What was changed

This pass completed the next bounded remediation after the source-URL blocker.

The two unattributable review-seed archive records were converted from public placeholders into internal-only records:

- `Gallatin Valley Venue Memory Project` (`23680`)
- `Bozeman Flyer Archive` (`23679`)

Final live state for both records:

- `gu_featured` cleared
- `gu_link_status = hidden`
- `post_status = draft`

The pass used the existing live cPanel/Fileman workflow plus a one-time WordPress runner to update only those two records and clear cache.

## Results

Public archive dependency on seeded placeholder records is now removed.

- `/archive/` remains live and now renders its empty-state copy instead of the two review seeds.
- `/history/` remains live and now renders its empty-state copy instead of the seeded history record.
- `wp-json/wp/v2/archive_item` now returns an empty list.
- Direct public permalinks for the two seed records now return `404`.
- `/` still returns `200`.

## Recommended next step

Run one more bounded public taxonomy cleanup pass.

The archive and history pages still expose leftover review-stage taxonomy chips and filter options such as `Venue Legacy`, `history`, and `flyers` even though there are no public archive records behind them.

The next pass should do one of these, without widening scope:

1. make the public term-chip and filter builders hide empty public terms, or
2. prune the unused review-stage terms from the live taxonomies if they are no longer needed
