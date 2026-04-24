# Pass Summary

## Scope

This pass completed the fourth evidence-backed archive reintroduction slice using only existing public uploads already hosted on `theguradio.com`.

The scope stayed narrow:

- add the next small set of real archive records
- keep review-seed records dark
- use the corrected `gu_scene_year` archive-filter path during verification
- avoid forcing speculative history-topic expansion

## What changed

- Created and published two additional `archive_item` records from existing source-backed media.
- Expanded public year coverage into `2022`.
- Preserved both review-seed records as unpublished and hidden.

## Live records introduced

- `23754` - `Open Slot`
  - `archive_type = media`
  - `scene_year = 2023`
  - `gu_original_url = https://theguradio.com/wp-content/uploads/2023/01/Open-Slot.png`

- `23756` - `Post Art Show`
  - `archive_type = media`
  - `scene_year = 2022`
  - `gu_original_url = https://theguradio.com/wp-content/uploads/2022/12/Post-Art-Show.png`

## Result

- Public `archive_item` count increased from `7` to `9`.
- `https://theguradio.com/archive/?gu_scene_year=2022` now returns `200` and shows `Post Art Show`.
- `https://theguradio.com/archive/?gu_scene_year=2023` returns `200` and now shows both `Open Slot` and `Frequenseas Event`.
- `/history/` remained healthy and unchanged for the existing real timeline records.
- Legacy `?year=` archive links still redirect correctly to `?gu_scene_year=...`.
