# Tests And Checks Run

## Code deployment checks

- Pulled the live pre-deploy `class-gu-scene-archive-template-controller.php` file and hashed it.
- Uploaded the local replacement as a temporary remote file.
- Verified the temporary remote upload by size and SHA-256.
- Renamed the live file to a timestamped backup.
- Renamed the verified upload into the production filename.
- Pulled the post-deploy live file and verified it matched the local file exactly.
- Pulled the backup file and verified it preserved the previous live bytes.

## Live correction checks

- Uploaded a one-time runner to the live root.
- Assigned `history_topic = venue-legacy` to post `23680`.
- Flushed rewrite rules.
- Re-ran the live homepage-archive metadata normalization.
- Re-ran the live archive audit.
- Removed the runner after successful execution.

## Public-surface checks

- Requested `https://theguradio.com/history/`
  - Result: `200`
  - Confirmed body contains:
    - `Featured History Records`
    - `Gallatin Valley Venue Memory Project`
    - `Venue Legacy`
  - Confirmed body does not contain:
    - `Page not found`
    - `Fatal error`
    - `There has been a critical error`
- Requested `https://theguradio.com/archive/`
  - Result: `200`
- Requested `https://theguradio.com/history-topic/venue-legacy/`
  - Result: `200`
  - Confirmed body contains `Gallatin Valley Venue Memory Project`
- Requested `https://theguradio.com/`
  - Result: `200`

## Data verification

- Requested `https://theguradio.com/wp-json/wp/v2/archive_item/23680`
  - Confirmed `history_topic` now includes term `139`
  - Confirmed class list now includes `history_topic-venue-legacy`

## Results

- All route-restoration checks passed.
- All live deployment checks passed.
- The history-topic blocker was cleared.
- The source-url blocker remains unresolved.
