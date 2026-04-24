# Tests And Checks Run

## Live source discovery checks

- Queried the live media library for additional history, flyer, and poster candidates
- Selected only records with:
  - public upload URLs already hosted on `theguradio.com`
  - clear enough attachment titles to support public archive records
  - year coverage already supported by existing taxonomy terms

## Live write checks

- Ran a one-time creation runner to insert or update three new `archive_item` records
- Result:
  - `23744` / `Facebook Flyer` created with correct terms on first pass
  - `23746` / `Poster 1720` created with correct terms on first pass
  - `23748` / `Livestream PNG` created with correct terms on first pass
- Confirmed both review-seed records remained unchanged:
  - `23679` still `draft` and `hidden`
  - `23680` still `draft` and `hidden`

## Public route verification

- `https://theguradio.com/archive/` -> `200`
  - empty-state archive copy absent
  - contains:
    - `Parahellion`
    - `Livestream Series`
    - `Facebook Flyer`
    - `Poster 1720`
    - `Livestream PNG`
  - no fatal-error markers detected

- `https://theguradio.com/history/` -> `200`
  - empty-state history copy absent
  - contains:
    - `Livestream Series`
    - `Livestream PNG`
    - `Timeline`
  - no fatal-error markers detected

- `https://theguradio.com/history-topic/timeline/` -> `200`
  - empty-state history copy absent
  - contains:
    - `Livestream Series`
    - `Livestream PNG`
    - `Timeline`
  - no fatal-error markers detected

- `https://theguradio.com/history-topic/venue-legacy/` -> `404`
  - not-found markers present
  - no fatal-error markers detected

## Single-record verification

- `https://theguradio.com/archive/facebook-flyer/` -> `200`
  - title visible
  - `Open Source` link present

- `https://theguradio.com/archive/poster-1720/` -> `200`
  - title visible
  - `Open Source` link present

- `https://theguradio.com/archive/livestream-png-history-record/` -> `200`
  - title visible
  - `Timeline` visible
  - `Open Source` link present

## Public API verification

- `https://theguradio.com/wp-json/wp/v2/archive_item?per_page=100&_fields=id,slug,title,link,status`
  - now returns five published items:
    - `23748` / `livestream-png-history-record`
    - `23746` / `poster-1720`
    - `23744` / `facebook-flyer`
    - `23742` / `livestream-series-history-record`
    - `23740` / `parahellion-gu-livestream`

## Review-seed containment verification

- `https://theguradio.com/archive/bozeman-flyer-archive-review-seed/` -> `404`
- `https://theguradio.com/archive/gallatin-valley-venue-memory-project-review-seed/` -> `404`

## Temporary runner cleanup verification

- `https://theguradio.com/gu-archive-reintro-0020.php` -> `404` after cleanup
