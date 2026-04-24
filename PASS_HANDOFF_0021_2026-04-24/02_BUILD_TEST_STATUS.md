# Tests And Checks Run

## Live source discovery checks

- Queried the live media library for additional archive and history candidates.
- Selected only records with:
  - public upload URLs already hosted on `theguradio.com`
  - attachment titles clear enough to support public archive records
  - enough metadata confidence to avoid inventing provenance or forcing a speculative history classification

## Live write checks

- Ran a one-time creation runner to insert two new `archive_item` records.
- Result:
  - `23750` / `Show Flyer` created with the expected source URL and taxonomy on first pass
  - `23752` / `Frequenseas Event` created with the expected source URL and taxonomy on first pass
  - `scene_year = 2023` created or confirmed as term id `142`

- Confirmed both review-seed records remained unchanged:
  - `23679` still `draft` and `hidden`
  - `23680` still `draft` and `hidden`

## Public route verification

- `https://theguradio.com/archive/` -> `200`
  - contains:
    - `Show Flyer`
    - `Frequenseas Event`
  - no fatal-error markers detected

- `https://theguradio.com/archive/?year=2023` -> `404`
  - unexpected
  - likely indicates a browse-filter defect around the public year query key

- `https://theguradio.com/history/` -> `200`
  - contains:
    - `Livestream Series`
    - `Livestream PNG`
  - no fatal-error markers detected

- `https://theguradio.com/history-topic/timeline/` -> `200`
  - contains:
    - `Livestream Series`
    - `Livestream PNG`
  - no fatal-error markers detected

- `https://theguradio.com/history-topic/venue-legacy/` -> `404`
  - not-found markers present
  - no fatal-error markers detected

## Single-record verification

- `https://theguradio.com/archive/show-flyer/` -> `200`
  - title visible
  - `Open Source` link present

- `https://theguradio.com/archive/frequenseas-event/` -> `200`
  - title visible
  - `Open Source` link present
  - `2023` visible

## Public API verification

- `https://theguradio.com/wp-json/wp/v2/archive_item?per_page=100&_fields=id,slug,title,link,status`
  - now returns seven published items:
    - `23752` / `frequenseas-event`
    - `23750` / `show-flyer`
    - `23748` / `livestream-png-history-record`
    - `23746` / `poster-1720`
    - `23744` / `facebook-flyer`
    - `23742` / `livestream-series-history-record`
    - `23740` / `parahellion-gu-livestream`

## Review-seed containment verification

- `https://theguradio.com/archive/bozeman-flyer-archive-review-seed/` -> `404`
- `https://theguradio.com/archive/gallatin-valley-venue-memory-project-review-seed/` -> `404`

## Temporary runner cleanup verification

- Confirmed `https://theguradio.com/gu-archive-reintro-0021.php` returns `404` after cleanup
