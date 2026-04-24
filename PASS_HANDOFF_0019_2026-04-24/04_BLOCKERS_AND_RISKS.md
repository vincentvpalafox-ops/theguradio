# Blockers And Risks

## Current blockers

- No blocker prevented completion of this pass

## Remaining risks

- Archive depth is still very thin
  - only `2` public `archive_item` records now exist
  - only `1` public history record exists
- Public taxonomy depth is still sparse
  - `timeline` now resolves correctly
  - `venue-legacy` still returns `404` because there is still no public evidence-backed record for that term
- The cPanel public-root upload path was unreliable for the disposable cache-refresh runner during this pass
  - content writes and reads still worked
  - cache-refresh confirmation through that path did not
