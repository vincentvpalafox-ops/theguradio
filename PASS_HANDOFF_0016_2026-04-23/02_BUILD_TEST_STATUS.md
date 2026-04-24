# Tests And Checks Run

## Live mutation runner

- Uploaded and executed a one-time WordPress runner against the live site.
- Result:
  - both target records updated successfully
  - cache clear executed through:
    - `wp_cache_clear_cache`
    - `wp_cache_post_change`
  - post-update public counts reported:
    - `archive_items_visible = 0`
    - `archive_items_featured_visible = 0`
    - `history_records_visible = 0`

## Public route verification

- `https://theguradio.com/archive/` -> `200`
- `https://theguradio.com/history/` -> `200`
- `https://theguradio.com/` -> `200`

## Public content verification

- `/archive/`
  - empty-state copy present
  - seeded record titles absent
  - featured archive section absent

- `/history/`
  - empty-state copy present
  - seeded record titles absent
  - featured history section absent

## Public REST verification

- Requested:
  - `https://theguradio.com/wp-json/wp/v2/archive_item?per_page=100&_fields=id,slug,title,link,status`
- Result:
  - response body is `[]`

## Direct permalink verification

- `https://theguradio.com/archive/gallatin-valley-venue-memory-project-review-seed/` -> `404`
- `https://theguradio.com/archive/bozeman-flyer-archive-review-seed/` -> `404`

## Result

- The seeded archive placeholders are no longer exposed as public archive records.
- The public archive/history routes remain healthy.
- No plugin PHP deployment was required for this pass.
