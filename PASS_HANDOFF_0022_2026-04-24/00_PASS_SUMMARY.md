# Pass Summary

## Scope

This pass completed the narrow public year-filter fix that pass `0021` exposed.

The scope stayed bounded:

- fix year-based archive browsing on public archive surfaces
- avoid changing taxonomy structure or content records
- deploy only the files needed for the filter-path correction

## What changed

- Replaced the public archive/history/performance year filter query key with `gu_scene_year`.
- Added a route-scoped legacy redirect so existing `?year=` links on archive-related surfaces resolve to the new filter key instead of failing.
- Updated archive, history, and performance filter forms to submit the non-reserved year query key.
- Deployed the four changed plugin files live with verified backup-and-swap steps.

## Result

- `https://theguradio.com/archive/?gu_scene_year=2023` now returns `200`.
- Legacy `https://theguradio.com/archive/?year=2023` now returns `301` to `?gu_scene_year=2023` and resolves successfully.
- `archive`, `history`, `history-topic`, `performances`, and existing single-record routes stayed healthy after deployment.
- No archive or history data records were changed in this pass.
