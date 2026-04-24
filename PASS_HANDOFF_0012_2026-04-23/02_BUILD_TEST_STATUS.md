# Tests And Checks Run

## Deployment-path checks

- Read the pre-deploy live maintenance file through cPanel Fileman `get_file_content`.
- Hashed the pre-deploy live file after local writeout.
- Uploaded the approved bundle as a temporary remote file through cPanel Fileman `upload_files`.
- Verified the temporary remote upload by size and by SHA-256 after pullback.
- Renamed the live file to a timestamped backup through cPanel API 2 `Fileman::fileop`.
- Renamed the verified temporary upload into the production filename through cPanel API 2 `Fileman::fileop`.
- Pulled the post-deploy live file back through cPanel Fileman and verified SHA-256.
- Pulled the new backup file back through cPanel Fileman and verified it matched the old live hash.

## Public-surface checks

- Requested `https://theguradio.com/` after deployment.
- Confirmed HTTP status `200`.
- Scanned the homepage response body for:
  - `Fatal error`
  - `There has been a critical error`
  - `Briefly unavailable for scheduled maintenance`

## Results

- All deployment verification checks passed.
- Homepage request returned `200`.
- Fatal/critical/maintenance markers were not present in the fetched homepage body.

## Not run

- No local PHP CLI lint was run in this pass because the workspace still does not have `php` available.
- No WordPress-admin action was run in this pass.
