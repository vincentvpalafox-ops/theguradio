# Rollback Plan

## Exact Rollback Method

If rollback is required, restore the previous static front page:

- restore `page_on_front = 7127`
- keep `show_on_front = page`

No plugin file revert is required for this activation rollback because this pass only changed the front-page option.

## Cache To Clear After Rollback

After restoring `page_on_front = 7127`:

- clean post cache for page `7127`
- clean post cache for page `23758`
- run `wp_cache_flush()`
- run `wp_cache_clear_cache()` if available
- allow LiteSpeed/public cache to refresh

## What The Rollback Restores

- the prior public homepage page/content
- the prior `/` experience
- the preview page remains preserved as page `23758`

## How To Verify Rollback

1. `/` returns `200`
2. `/` no longer shows the archive-backed opening frame
3. `/` again matches the prior page `7127` experience
4. `/archive-homepage-preview/` is reachable as the preview page again
5. `/archive/`, `/performances/`, `/history/`, and `/search/` remain healthy
