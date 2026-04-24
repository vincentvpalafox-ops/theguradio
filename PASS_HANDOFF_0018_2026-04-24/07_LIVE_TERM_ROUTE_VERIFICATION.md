# Live Term Route Verification

## Deployment source

- Local deployment source:
  - `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-template-controller.php`
- Added controller behavior:
  - empty direct `history_topic` term routes now render `404`
- Local SHA-256:
  - `9C905E13E9194A78FC99D786FEDB1882A068BFF5619809536DD5A39443D49D97`
- Local size:
  - `11709` bytes

## Pre-deploy live state

- Remote target:
  - `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-template-controller.php`
- Pre-deploy SHA-256:
  - `E1DF821884E8CA17DD2AADB1A7CC4FF48210D2304336DF139F2DF004CA2C131B`
- Pre-deploy size:
  - `10337` bytes
- Confirmed residual issue in the old live state:
  - direct empty `history_topic` routes still rendered a public empty-state page

## Swap sequence

1. Uploaded the patched controller as temporary file:
   - `class-gu-scene-archive-template-controller.codex-upload-0018-20260424-001754.php`
2. Verified the temporary upload by SHA-256:
   - `9C905E13E9194A78FC99D786FEDB1882A068BFF5619809536DD5A39443D49D97`
3. Renamed the existing live controller into backup:
   - `class-gu-scene-archive-template-controller.pre-codex-0018-20260424-001754.php`
4. Renamed the verified temporary upload into:
   - `class-gu-scene-archive-template-controller.php`

## Post-deploy verification

- Post-deploy live SHA-256:
  - `9C905E13E9194A78FC99D786FEDB1882A068BFF5619809536DD5A39443D49D97`
- Post-deploy live size:
  - `11709` bytes
- Backup SHA-256:
  - `E1DF821884E8CA17DD2AADB1A7CC4FF48210D2304336DF139F2DF004CA2C131B`
- Backup size:
  - `10337` bytes

## Cache refresh

- Executed one-time runner:
  - `gu-history-topic-route-refresh-0018.php`
- Runner response:
  - `{"wp_cache_clear_cache":null}`
- Runner cleanup:
  - public runner URL returns `404` after removal

## Public-route verification

### Direct term route

- URL:
  - `https://theguradio.com/history-topic/venue-legacy/`
- Result:
  - HTTP `404`
  - `Venue Legacy` term title absent
  - history empty-state copy absent
  - not-found markers present
  - no fatal-error markers detected

### History archive route

- URL:
  - `https://theguradio.com/history/`
- Result:
  - HTTP `200`
  - contains `No history records match the current filters yet.`
  - no fatal-error markers detected

### Archive route

- URL:
  - `https://theguradio.com/archive/`
- Result:
  - HTTP `200`
  - contains `No archive records match the current filters yet.`
  - no fatal-error markers detected

### Performances route

- URL:
  - `https://theguradio.com/performances/`
- Result:
  - HTTP `200`
  - expected performance archive copy still visible
  - no fatal-error markers detected

### Homepage route

- URL:
  - `https://theguradio.com/`
- Result:
  - HTTP `200`
  - no fatal-error or maintenance markers detected

## Unchanged public state

- `https://theguradio.com/wp-json/wp/v2/archive_item?per_page=100&_fields=id,slug,title,link,status` remains `[]`
