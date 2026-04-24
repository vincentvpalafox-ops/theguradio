# Next Recommended Pass

## Recommended pass

Run a bounded empty-term route cleanup pass.

## Goal

Decide whether unused review-stage taxonomy terms should still resolve publicly now that there are no public archive records.

## Preferred implementation order

1. Inventory the remaining empty public-facing terms in:
   - `archive_type`
   - `history_topic`
   - any shared scene taxonomies still surfaced on archive/history routes

2. Choose one narrow resolution:
   - prune the unused review-stage terms from live data, or
   - keep the terms but make empty public term routes return `404` or otherwise suppress them

3. Verify:
   - `/archive/` still returns `200`
   - `/history/` still returns `200`
   - no public chip/select residue returns
   - targeted direct empty term routes no longer present the unwanted public surface
