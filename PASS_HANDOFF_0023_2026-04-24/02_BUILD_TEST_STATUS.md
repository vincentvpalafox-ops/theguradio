# Tests And Checks Run

## Live source discovery checks

- Queried the live media library through the public REST API for additional candidates.
- Selected only records with:
  - public upload URLs already hosted on `theguradio.com`
  - titles clear enough to support a public archive record
  - enough metadata confidence to avoid inventing provenance or forcing a speculative history classification

## Live write checks

- Ran a one-time creation runner to insert two new `archive_item` records.
- Result:
  - `23754` / `Open Slot` created with the expected source URL and taxonomy on first pass
  - `23756` / `Post Art Show` created with the expected source URL and taxonomy on first pass
  - `scene_year = 2022` created as term id `143`
  - `scene_year = 2023` confirmed as term id `142`

- Confirmed both review-seed records remained unchanged:
  - `23679` still `draft` and `hidden`
  - `23680` still `draft` and `hidden`

## Public route verification

- `https://theguradio.com/archive/?gu_scene_year=2023&codex_verify=0023` -> `200`
  - contains `Open Slot`
  - contains `Frequenseas Event`
  - no 404 marker
  - no fatal marker

- `https://theguradio.com/archive/?gu_scene_year=2022&codex_verify=0023` -> `200`
  - contains `Post Art Show`
  - no 404 marker
  - no fatal marker

- `https://theguradio.com/history/?gu_scene_year=2024&codex_verify=0023` -> `200`
  - contains `Livestream PNG`
  - no 404 marker
  - no fatal marker

## Single-record verification

- `https://theguradio.com/archive/open-slot/?codex_verify=0023` -> `200`
  - title visible
  - `Open Source` link present

- `https://theguradio.com/archive/post-art-show/?codex_verify=0023` -> `200`
  - title visible
  - `Open Source` link present

## Legacy URL compatibility verification

- `https://theguradio.com/archive/?year=2022&codex_verify=0023`
  - initial response: `301`
  - redirected location ends in `?gu_scene_year=2022`
  - final response: `200`
  - contains `Post Art Show`
  - no 404 marker
  - no fatal marker

## Public API verification

- `https://theguradio.com/wp-json/wp/v2/archive_item?per_page=100&_fields=id,slug,title,link,status`
  - now returns nine published items:
    - `23756` / `post-art-show`
    - `23754` / `open-slot`
    - `23752` / `frequenseas-event`
    - `23750` / `show-flyer`
    - `23748` / `livestream-png-history-record`
    - `23746` / `poster-1720`
    - `23744` / `facebook-flyer`
    - `23742` / `livestream-series-history-record`
    - `23740` / `parahellion-gu-livestream`

## Review-seed containment verification

- `https://theguradio.com/archive/bozeman-flyer-archive-review-seed/?codex_verify=0023` -> `404`
- `https://theguradio.com/archive/gallatin-valley-venue-memory-project-review-seed/?codex_verify=0023` -> `404`

## Temporary runner cleanup verification

- Confirmed `https://theguradio.com/gu-archive-reintro-0023.php` returns `404` after cleanup
