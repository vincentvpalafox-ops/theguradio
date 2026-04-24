# Pass Summary

## Scope

This pass completed the first evidence-backed archive/history reintroduction slice after the public cleanup work.

## What changed

- Created and published two new `archive_item` records backed by existing public upload URLs already hosted on `theguradio.com`.
- Assigned real archive taxonomy terms and thumbnails from the existing media library.
- Left the two contained review-seed records unpublished and hidden.

## Live records introduced

- `23740` — `Parahellion – GU Livestream`
  - `archive_type = media`
  - `scene_year = 2024`
  - `gu_original_url = https://theguradio.com/wp-content/uploads/2024/01/Parahellion-GU-Livestream.png`
  - `thumbnail_id = 8658`

- `23742` — `Livestream Series`
  - `archive_type = history`
  - `history_topic = timeline`
  - `scene_year = 2021`
  - `gu_original_url = https://theguradio.com/wp-content/uploads/2021/10/Livestream-Series.png`
  - `thumbnail_id = 8656`

## Result

- `/archive/` is no longer empty and now shows both real archive records.
- `/history/` is no longer empty and now shows `Livestream Series`.
- `/history-topic/timeline/` now returns `200` with a real public record behind it.
- `/history-topic/venue-legacy/` still returns `404`, which remains correct because no public evidence-backed record exists for that term yet.
