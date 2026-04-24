# Tests And Checks Run

## Live discovery checks

- Queried the live `archive_item` inventory before changes
  - result: only the two hidden review seeds existed
- Queried targeted live media attachments and confirmed source-backed candidates
  - attachment `8658` / `Parahellion – GU Livestream`
  - attachment `8656` / `Livestream Series`
- Queried live taxonomy inventory and confirmed reusable existing terms
  - `archive_type = media`
  - `archive_type = history`
  - `history_topic = timeline`
  - `scene_year = 2024`
  - `scene_year = 2021`

## Live write checks

- Ran a one-time creation runner to insert or update two new `archive_item` records
- First creation pass succeeded for post creation, source URLs, approval state, and thumbnails
- First creation pass exposed a taxonomy nuance:
  - hierarchical taxonomies did not accept the initial string term payload
  - resulting posts were live but temporarily missing assigned terms
- Ran a second one-time correction runner with taxonomy term IDs
  - result: final term assignments were correct

## Final live inventory verification

- Final archive-item inventory confirmed:
  - `23740` published with `archive_type = media`, `scene_year = 2024`
  - `23742` published with `archive_type = history`, `history_topic = timeline`, `scene_year = 2021`
  - review seeds `23679` and `23680` still `draft` and `hidden`

## Public route verification

- `https://theguradio.com/archive/` -> `200`
  - empty-state archive copy absent
  - contains `Parahellion`
  - contains `Livestream Series`
  - no fatal-error markers detected

- `https://theguradio.com/history/` -> `200`
  - empty-state history copy absent
  - contains `Livestream Series`
  - contains `Timeline`
  - no fatal-error markers detected

- `https://theguradio.com/history-topic/timeline/` -> `200`
  - empty-state history copy absent
  - contains `Livestream Series`
  - contains `Timeline`
  - no fatal-error markers detected

- `https://theguradio.com/history-topic/venue-legacy/` -> `404`
  - not-found markers present
  - no fatal-error markers detected

- `https://theguradio.com/archive/parahellion-gu-livestream/` -> `200`
  - title visible
  - `Open Source` link present
  - no fatal-error markers detected

- `https://theguradio.com/archive/livestream-series-history-record/` -> `200`
  - title visible
  - `Timeline` visible
  - `Open Source` link present
  - no fatal-error markers detected

## Public API verification

- `https://theguradio.com/wp-json/wp/v2/archive_item?per_page=100&_fields=id,slug,title,link,status`
  - now returns exactly two published items:
    - `23742` / `livestream-series-history-record`
    - `23740` / `parahellion-gu-livestream`

## Review-seed containment verification

- `https://theguradio.com/archive/bozeman-flyer-archive-review-seed/` -> `404`
- `https://theguradio.com/archive/gallatin-valley-venue-memory-project-review-seed/` -> `404`

## Temporary runner cleanup verification

- All disposable runner URLs used in this pass return `404` after cleanup

## Cache-clear attempt

- Attempted a one-time public-root cache-refresh runner after the data pass
- Result:
  - cPanel upload returned `500 Internal Server Error`
  - no cache-refresh execution could be confirmed through that runner path
- Impact:
  - non-blocking, because the public archive/history routes already reflected the new records without waiting on stale cache
