# Runtime Verification

## Execution method

- Used a temporary live runner in `public_html` to execute the already-deployed `GU_Scene_Archive_Maintenance` normalization workflow without modifying plugin source.
- The runner was removed immediately after use.

## Live normalization result

- Executed at GMT:
  - `2026-04-24 05:29:29`
- Summary:
  - `records_considered`: `2`
  - `records_updated`: `0`
  - `source_backfills`: `0`
  - `source_skipped_existing`: `0`
  - `source_skipped_no_url`: `2`
  - `source_skipped_unknown_host`: `0`
  - `history_topic_evidence_blocked`: `1`

## Live maintenance-state transition

- Before this pass:
  - `last_homepage_archive_metadata_normalization_at`: empty
  - `last_homepage_archive_metadata_normalization_summary`: empty
- After this pass:
  - `last_homepage_archive_metadata_normalization_at`: `2026-04-24 05:29:28`
  - `last_archive_audit_completed_at`: `2026-04-24 05:29:29`

## Record-level review output

### Gallatin Valley Venue Memory Project

- Homepage role: `Featured archive + History support`
- Source result: `Blocked: missing or invalid source URL`
- History result: `Evidence-blocked: missing history topic`
- Current archive type terms: `history`
- Current history topic terms: none
- Current scene source terms: none

### Bozeman Flyer Archive

- Homepage role: `Featured archive`
- Source result: `Blocked: missing or invalid source URL`
- History result: `Not a history record`
- Current archive type terms: `flyers`
- Current history topic terms: none
- Current scene source terms: none

## Follow-up archive audit

- `total_records`: `7`
- `scene_video_records`: `5`
- `archive_item_records`: `2`
- `missing_original_url`: `2`
- `invalid_original_url`: `0`
- `missing_excerpt`: `0`
- `missing_thumbnail`: `2`
- `missing_year`: `0`
- `thin_records`: `0`
- `archive_items_missing_archive_type`: `0`
- `history_records_missing_history_topic`: `1`
- `history_topic_without_history_type`: `0`
- `duplicate_original_url_groups`: `0`
- `duplicate_original_url_records`: `0`
- `duplicate_title_groups`: `0`
- `duplicate_title_records`: `0`
- `taxonomy_collision_groups`: `0`

## Public route verification

### Archive route

- URL:
  - `https://theguradio.com/archive/`
- Result:
  - Returned content successfully
  - Contained both featured archive titles:
    - `Gallatin Valley Venue Memory Project`
    - `Bozeman Flyer Archive`

### History route

- URL:
  - `https://theguradio.com/history/`
- Result:
  - Request completed, but the HTML body rendered:
    - `Page not found`
- Implication:
  - The public history landing route is not currently functioning, even though the history-supporting record itself is live.

### History record permalink

- URL:
  - `https://theguradio.com/archive/gallatin-valley-venue-memory-project-review-seed/`
- Result:
  - Returned content successfully
  - Contained the expected record title

### Homepage check

- URL:
  - `https://theguradio.com/`
- Result:
  - Returned content successfully
  - No fatal-error markers detected in the fetched body
