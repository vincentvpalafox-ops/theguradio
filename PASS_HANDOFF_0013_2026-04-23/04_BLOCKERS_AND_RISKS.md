# Blockers And Risks

## Data blockers

- `Gallatin Valley Venue Memory Project`
  - Missing canonical source URL
  - Missing `history_topic`
- `Bozeman Flyer Archive`
  - Missing canonical source URL

Because both qualifying records still lack canonical source URLs, the normalization routine had no evidence it could use to backfill `scene_source` safely.

## Public-surface blocker

- `https://theguradio.com/history/` currently renders a `Page not found` body.
- The history-supporting record itself is live at its direct permalink, but the intended public history landing route is not functioning.

## Scope risk clarified by runtime

- The normalization workflow is working as designed.
- The remaining problem is not code failure inside the maintenance routine; it is incomplete record data plus an unresolved public history route.
