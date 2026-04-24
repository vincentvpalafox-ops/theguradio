# Files Modified

## Local source files changed

- `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-template-controller.php`
  - added `YEAR_FILTER_QUERY_VAR = 'gu_scene_year'`
  - switched archive query parsing from `year` to `gu_scene_year`
  - added legacy `?year=` redirect logic for archive-related routes

- `staged_remote_changes/wp-content/plugins/gu-scene-archive/templates/archive-archive-item.php`
  - updated the Year filter select to use `gu_scene_year`

- `staged_remote_changes/wp-content/plugins/gu-scene-archive/templates/archive-scene-video.php`
  - updated the Year filter select to use `gu_scene_year`

- `staged_remote_changes/wp-content/plugins/gu-scene-archive/templates/history-archive.php`
  - updated year-filter reads, form submission, and pagination URLs to use `gu_scene_year`

## Local handoff files added

- `PASS_HANDOFF_0022_2026-04-24/00_PASS_SUMMARY.md`
- `PASS_HANDOFF_0022_2026-04-24/01_FILES_CHANGED.md`
- `PASS_HANDOFF_0022_2026-04-24/02_BUILD_TEST_STATUS.md`
- `PASS_HANDOFF_0022_2026-04-24/03_NOT_CHANGED.md`
- `PASS_HANDOFF_0022_2026-04-24/04_BLOCKERS_AND_RISKS.md`
- `PASS_HANDOFF_0022_2026-04-24/05_NEXT_RECOMMENDED_PASS.md`
- `PASS_HANDOFF_0022_2026-04-24/07_LIVE_YEAR_FILTER_VERIFICATION.md`

## Live deployment targets changed

- `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-template-controller.php`
- `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/templates/archive-archive-item.php`
- `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/templates/archive-scene-video.php`
- `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/templates/history-archive.php`

## Live backup files created

- `class-gu-scene-archive-template-controller.pre-codex-0022-20260424-004713.php`
- `archive-archive-item.pre-codex-0022-20260424-004713.php`
- `archive-scene-video.pre-codex-0022-20260424-004713.php`
- `history-archive.pre-codex-0022-20260424-004713.php`
