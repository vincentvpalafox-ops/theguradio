# Blockers And Risks

## Blockers

- No blocker prevented completion of this pass.

## Remaining risks

- Local PHP lint is still unavailable in this workspace because `php` CLI is not installed.
- The public year filter is now stable on archive-related routes, but any external references should use `gu_scene_year` going forward.
- Search-page text filters still use `year`, but that path was intentionally left out of scope for this archive-route fix.
