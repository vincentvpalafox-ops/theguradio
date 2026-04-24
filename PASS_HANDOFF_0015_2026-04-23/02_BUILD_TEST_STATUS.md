# Tests And Checks Run

## Workspace evidence checks

- Searched the workspace for:
  - `Gallatin Valley Venue Memory Project`
  - `Bozeman Flyer Archive`
  - candidate supported-host URLs
- Result:
  - Found only review-stage documentation and rendered archive snapshots.
  - Did not find record-specific canonical source URLs for either archive item.

## Live REST checks

- Requested:
  - `https://theguradio.com/wp-json/wp/v2/archive_item/23680?_embed=1`
  - `https://theguradio.com/wp-json/wp/v2/archive_item/23679?_embed=1`
- Result:
  - both records still have empty `scene_source`
  - both records still have no `gu_original_url`
  - both records have `featured_media = 0`
  - `Gallatin Valley Venue Memory Project` now correctly carries `history_topic = venue-legacy`

## Live deep-inspection check

- Uploaded and executed a one-time runner to inspect all post meta and child attachments for both records.
- Result:
  - `Gallatin Valley Venue Memory Project` post meta only contained:
    - `gu_approved`
    - `gu_featured`
    - `ekit_post_views_count`
    - `_elementor_page_assets`
  - `Bozeman Flyer Archive` post meta only contained:
    - `gu_approved`
    - `gu_featured`
    - `ekit_post_views_count`
  - neither record had any child attachments

## Result

- No evidence-backed supported-host source URL was recoverable for either record.
- No live write was performed because assigning a made-up source URL would violate the accepted scope and the plugin's evidence-only normalization rule.
