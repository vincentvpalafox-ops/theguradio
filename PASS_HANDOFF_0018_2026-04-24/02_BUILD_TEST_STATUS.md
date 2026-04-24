# Tests And Checks Run

## Local static checks

- Reviewed the controller diff in `class-gu-scene-archive-template-controller.php`
- `git diff --check` passed for the code change
  - Git emitted only the standard Windows line-ending warning for the working copy

## Live deployment verification

- Pulled the pre-deploy live controller through cPanel Fileman `get_file_content`
- Verified the temporary upload by SHA-256 before promotion
- Renamed the old live controller into a timestamped backup
- Promoted the verified temporary upload into the live controller path
- Verified the live deployed SHA-256 matched the local controller exactly:
  - local SHA-256: `9C905E13E9194A78FC99D786FEDB1882A068BFF5619809536DD5A39443D49D97`
  - temp upload SHA-256: `9C905E13E9194A78FC99D786FEDB1882A068BFF5619809536DD5A39443D49D97`
  - post-deploy live SHA-256: `9C905E13E9194A78FC99D786FEDB1882A068BFF5619809536DD5A39443D49D97`
- Verified the backup preserved the previous live controller exactly:
  - pre-deploy live SHA-256: `E1DF821884E8CA17DD2AADB1A7CC4FF48210D2304336DF139F2DF004CA2C131B`
  - backup SHA-256: `E1DF821884E8CA17DD2AADB1A7CC4FF48210D2304336DF139F2DF004CA2C131B`

## Cache refresh

- Executed a one-time live cache-refresh runner
- Result:
  - `{"wp_cache_clear_cache":null}`
- Verified the runner was removed after use:
  - `https://theguradio.com/gu-history-topic-route-refresh-0018.php` -> `404`

## Public route verification

- `https://theguradio.com/history-topic/venue-legacy/` -> `404`
  - empty-state history copy absent
  - `Venue Legacy` term title absent
  - not-found markers present
  - no fatal-error markers detected
- `https://theguradio.com/history/` -> `200`
  - `No history records match the current filters yet.` present
  - no fatal-error markers detected
- `https://theguradio.com/archive/` -> `200`
  - `No archive records match the current filters yet.` present
  - no fatal-error markers detected
- `https://theguradio.com/performances/` -> `200`
  - expected performance archive copy present
  - no fatal-error markers detected
- `https://theguradio.com/` -> `200`
  - no fatal-error or maintenance markers detected

## Unchanged-behavior verification

- `https://theguradio.com/wp-json/wp/v2/archive_item?per_page=100&_fields=id,slug,title,link,status` -> `[]`

## Validation gap

- Local `php` CLI is still unavailable in this workspace, so no local PHP lint was possible before deployment
