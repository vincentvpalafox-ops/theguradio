# Pass Summary

## Scope

This pass completed the third evidence-backed archive reintroduction slice using only existing public uploads already hosted on `theguradio.com`.

The scope stayed narrow:

- reintroduce more real archive records
- keep review-seed records dark
- do not force a speculative non-`timeline` history record when the live media library did not support one cleanly

## What changed

- Created and published two additional `archive_item` records from existing source-backed media.
- Expanded public archive coverage with one additional flyer-class record and one additional media-class record.
- Introduced or confirmed public `scene_year` coverage for `2023`.
- Left both review-seed records unpublished and hidden.

## Live records introduced

- `23750` - `Show Flyer`
  - `archive_type = flyer`
  - `scene_year = 2021`
  - `gu_original_url = https://theguradio.com/wp-content/uploads/2021/12/Show-Flyer.png`

- `23752` - `Frequenseas Event`
  - `archive_type = media`
  - `scene_year = 2023`
  - `gu_original_url = https://theguradio.com/wp-content/uploads/2023/10/Frequenseas-Event.png`

## Result

- Public `archive_item` count increased from `5` to `7`.
- `/archive/` now shows both new evidence-backed records.
- `/history/` and `/history-topic/timeline/` remain healthy with the two existing timeline-class history records.
- `/history-topic/venue-legacy/` still returns `404`, which remains correct because there is still no public evidence-backed record for that term.
- This pass exposed a concrete browse defect: `/archive/?year=2023` currently returns `404`.
