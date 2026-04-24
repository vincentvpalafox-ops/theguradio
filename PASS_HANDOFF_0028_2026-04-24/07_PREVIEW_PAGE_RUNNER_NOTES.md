# Preview Page Runner Notes

## Create Runner
- File:
  - `tools/gu-homepage-preview-create-0028.php`
- Behavior:
  - loads WordPress from public root
  - creates or updates a page with:
    - title `Archive Homepage Preview`
    - slug `archive-homepage-preview`
    - content `[gu_scene_archive_homepage]`
    - status `publish`
  - clears cache if cache hooks are available
  - reports the current `page_on_front` before and after
  - never changes `page_on_front`
  - attempts to delete itself after execution

## Cleanup Runner
- File:
  - `tools/gu-homepage-preview-remove-0028.php`
- Behavior:
  - loads WordPress from public root
  - finds the preview page by slug across any post status
  - refuses cleanup if that page has somehow become the front page
  - permanently deletes the preview page so the slug stays reusable
  - clears cache if cache hooks are available
  - attempts to delete itself after execution

## Why This Path
- It uses the same live-mutation pattern already proven in earlier passes:
  - cPanel/Fileman upload
  - one-time public-root WordPress runner
  - immediate cleanup
- It avoids the blocked `wp-admin` UI dependency.
- It does not touch `/`.

## Current Access Recheck
- `/` currently returns `200`
- `/archive-homepage-preview/` currently returns `404`
- direct `ssh` is still denied
- that makes this packet the tightest remaining executable step until authenticated upload access returns
