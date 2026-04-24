# Live Taxonomy Verification

## Deployed helper behavior

The deployed `archive-helpers.php` now resolves chips and filter terms from public-visible published object IDs in the current archive context:

- archive archive -> `archive_item`
- history archive -> public `archive_item` records limited to history context
- performance archive -> `scene_video`

## Main public routes

### `/archive/`

- returns `200`
- renders:
  - `No archive records match the current filters yet.`
- does not render:
  - `Venue Legacy` chip/option
  - `history` option
  - `flyers` option

### `/history/`

- returns `200`
- renders:
  - `No history records match the current filters yet.`
- does not render:
  - helper-generated `Venue Legacy` chip
  - helper-generated `Venue Legacy` filter option

### `/performances/`

- returns `200`
- no fatal-error markers detected
- expected archive copy still visible

## Direct term route

### `/history-topic/venue-legacy/`

- returns `200`
- renders:
  - `Venue Legacy` as the direct queried term title
  - empty-state copy
- does not render:
  - helper-generated topic chip
  - helper-generated topic select option

## Unchanged public state

- `/wp-json/wp/v2/archive_item` remains `[]`
- direct old review-seed record URLs remain `404`
