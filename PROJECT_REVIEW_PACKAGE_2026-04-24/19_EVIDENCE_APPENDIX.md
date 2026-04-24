# Evidence Appendix

## Command and Route Evidence

### Live route status snapshot

From [logs/route_status.txt](logs/route_status.txt):

```text
200 https://theguradio.com/
404 https://theguradio.com/review-home/
200 https://theguradio.com/archive/
200 https://theguradio.com/performances/
200 https://theguradio.com/history/
200 https://theguradio.com/search/
200 https://theguradio.com/history-topic/timeline/
404 https://theguradio.com/history-topic/venue-legacy/
```

### Year-filter regression snapshot

From [logs/year_filter_checks.txt](logs/year_filter_checks.txt):

```text
https://theguradio.com/archive/?gu_scene_year=2023 -> 200
https://theguradio.com/archive/?year=2023 -> 301 https://theguradio.com/archive/?gu_scene_year=2023
https://theguradio.com/history/?gu_scene_year=2024 -> 200
https://theguradio.com/performances/?gu_scene_year=2024 -> 200
```

### Tool availability snapshot

From [logs/tool_availability.txt](logs/tool_availability.txt):

```text
php: NOT FOUND
npm: C:\Program Files\nodejs\npm.ps1
node: C:\Program Files\nodejs\node.exe
composer: NOT FOUND
git: C:\Program Files\Git\cmd\git.exe
```

### Repo-state evidence

- Recent Git history: [logs/git_log_recent.txt](logs/git_log_recent.txt)
- Git status before packaging: [logs/git_status_before_package.txt](logs/git_status_before_package.txt)
- Diff hygiene check: [logs/git_diff_check.txt](logs/git_diff_check.txt)

## Public Data Samples

### Archive items

Current public archive set is captured in [logs/public_archive_items.json](logs/public_archive_items.json). At review time it contained 9 items, including:

- `Post Art Show`
- `Open Slot`
- `Frequenseas Event`
- `Show Flyer`
- `Livestream PNG`
- `Poster 1720`
- `Facebook Flyer`
- `Livestream Series`
- `Parahellion â€“ GU Livestream`

### Performance records

Current public performance set is captured in [logs/public_scene_videos.json](logs/public_scene_videos.json). At review time it contained 5 items, including:

- `Frequenseas â€“ 01-17-2025 â€“ Filling Station â€“ Bozeman, MT`
- `Jacob Rountree â€“ The Gallatin Underground Livestream Series`
- `Sausalito Ferry â€“ Live @ The Bozeman Hot Springs`
- `Bottle Cap â€“ The Gallatin Underground Livestream Series`
- `Rocky Mountain Sonic â€“ The Gallatin Underground Livestream Series`

## Repo Structure Notes

- The repo root contains many pass artifacts and zip exports
- The actual working plugin snapshot lives under `staged_remote_changes/wp-content/plugins/gu-scene-archive`
- The root Git repo tracks only a small subset of the workspace

## Files Too Large or Too Volatile To Inline Fully

- `class-gu-scene-archive-section-shortcodes.php`
- `class-gu-scene-archive-settings.php`
- `class-gu-scene-archive-maintenance.php`
- `class-gu-scene-archive-operator-dashboard.php`

These files are better inspected directly at path rather than pasted into the review package.

## Screenshot Limitation

No screenshots are included because no local browser executable was available for capture in this workspace during review.
