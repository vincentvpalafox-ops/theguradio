# Route And Runtime Verification

## Template-controller deployment

- Local file deployed:
  - `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-template-controller.php`
- Local SHA-256:
  - `E1DF821884E8CA17DD2AADB1A7CC4FF48210D2304336DF139F2DF004CA2C131B`
- Local size:
  - `10337` bytes

## Previous live template-controller state

- Previous live SHA-256:
  - `75D23B1D3B864F4E8318AEB37FF5603738194EBEB161CCBFD4F04FBC9C179682`
- Previous live size:
  - `5740` bytes
- Key missing behavior in the old live file:
  - no `/history/` route registration
  - no `gu_scene_history` query var
  - no history-template override
  - no history-route virtual 200 handling

## Post-deploy verification

- Live SHA-256 after deploy:
  - `E1DF821884E8CA17DD2AADB1A7CC4FF48210D2304336DF139F2DF004CA2C131B`
- Live size after deploy:
  - `10337` bytes
- Backup file created:
  - `class-gu-scene-archive-template-controller.pre-codex-0014-20260423-233431.php`
- Backup SHA-256:
  - `75D23B1D3B864F4E8318AEB37FF5603738194EBEB161CCBFD4F04FBC9C179682`

## History-topic correction

- Target record:
  - `23680` / `Gallatin Valley Venue Memory Project`
- History-topic before:
  - none
- History-topic assigned:
  - `venue-legacy`
- History-topic after:
  - `venue-legacy`

## Post-correction maintenance summary

- `records_considered`: `2`
- `records_updated`: `0`
- `source_backfills`: `0`
- `source_skipped_existing`: `0`
- `source_skipped_no_url`: `2`
- `source_skipped_unknown_host`: `0`
- `history_topic_evidence_blocked`: `0`

## Post-correction archive audit

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
- `history_records_missing_history_topic`: `0`
- `history_topic_without_history_type`: `0`
- `duplicate_original_url_groups`: `0`
- `duplicate_original_url_records`: `0`
- `duplicate_title_groups`: `0`
- `duplicate_title_records`: `0`
- `taxonomy_collision_groups`: `0`

## Public-route verification

### History route

- URL:
  - `https://theguradio.com/history/`
- Result:
  - HTTP `200`
  - contains `Featured History Records`
  - contains `Gallatin Valley Venue Memory Project`
  - contains `Venue Legacy`
  - does not contain `Page not found`
  - does not contain fatal-error markers

### History-topic term route

- URL:
  - `https://theguradio.com/history-topic/venue-legacy/`
- Result:
  - HTTP `200`
  - contains `Gallatin Valley Venue Memory Project`
  - no not-found body
  - no fatal-error markers

### Archive route

- URL:
  - `https://theguradio.com/archive/`
- Result:
  - HTTP `200`

### Homepage route

- URL:
  - `https://theguradio.com/`
- Result:
  - HTTP `200`

## Remaining unresolved issue

- Source URLs are still missing on both qualifying archive records, so `scene_source` backfills are still blocked.
