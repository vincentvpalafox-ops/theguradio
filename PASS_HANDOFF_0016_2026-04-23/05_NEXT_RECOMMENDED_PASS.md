# Next Recommended Pass

## Recommended pass

Run a bounded public taxonomy-surface cleanup pass.

## Goal

Remove empty review-stage taxonomy chips and filter options from `/archive/` and `/history/` now that there are no public archive records.

## Preferred implementation order

1. Inspect the term-chip and filter builders used by:
   - `archive-archive-item.php`
   - `history-archive.php`

2. Make those builders render only terms that have at least one public-visible published record behind them.

3. Verify:
   - `/archive/` still returns `200`
   - `/history/` still returns `200`
   - empty-state copy remains
   - empty review-stage chips/options are gone

## Alternative if data-only is preferred

If you want a pure live-data pass instead of a code pass, prune the unused review-stage terms from the live taxonomies, but only if those terms are not needed for later real archive records.
