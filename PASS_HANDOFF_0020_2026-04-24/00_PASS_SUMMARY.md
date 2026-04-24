# Pass Summary

## Scope

This pass completed the second evidence-backed archive reintroduction slice using only existing public uploads already hosted on `theguradio.com`.

## What changed

- Created and published three additional `archive_item` records from existing source-backed media.
- Expanded public archive coverage into flyer and poster record types.
- Added a second real `timeline` history record.
- Left both review-seed records unpublished and hidden.

## Live records introduced

- `23744` — `Facebook Flyer`
  - `archive_type = flyer`
  - `scene_year = 2024`
  - `gu_original_url = https://theguradio.com/wp-content/uploads/2024/04/Facebook-Flyer.png`

- `23746` — `Poster 1720`
  - `archive_type = poster`
  - `scene_year = 2021`
  - `gu_original_url = https://theguradio.com/wp-content/uploads/2021/11/Poster-1720.png`

- `23748` — `Livestream PNG`
  - `archive_type = history`
  - `history_topic = timeline`
  - `scene_year = 2024`
  - `gu_original_url = https://theguradio.com/wp-content/uploads/2024/09/Livestream-PNG.jpg`

## Result

- Public `archive_item` count increased from `2` to `5`.
- `/archive/` now shows all five evidence-backed records.
- `/history/` now shows two real timeline-class history records:
  - `Livestream Series`
  - `Livestream PNG`
- `/history-topic/timeline/` now contains both history records.
- `/history-topic/venue-legacy/` still returns `404`, which remains correct because there is still no public evidence-backed record for that term.
