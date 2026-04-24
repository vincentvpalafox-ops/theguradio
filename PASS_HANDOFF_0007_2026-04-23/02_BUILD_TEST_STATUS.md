# 02 BUILD TEST STATUS

## Commands Run

| Command | Result | Key output excerpt |
| --- | --- | --- |
| `git status -sb` | pass | confirmed the repo is on `main...origin/main` and the workspace still contains many unrelated untracked files that were intentionally left untouched |
| `git ls-files` | pass | confirmed the tracked scope is still narrow and already includes the maintenance file plus prior handoff packages |
| `rg -n "deploy|deployment|cPanel|ftp|sftp|ssh|live plugin|production|upload" ...` | pass | found deployment-posture guidance and historical deploy artifacts, but no active reusable deployment command |
| `Get-ChildItem Env: | Where-Object { $_.Name -match 'CPANEL|WHM|FTP|SFTP|SSH|TOKEN|API|GITHUB' }` | pass | no relevant deployment environment variables were present |
| `rg -n "Authorization: cpanel|Authorization: whm|uapi --user|whmapi1|save_file_content" .` | pass | no reusable authenticated invocation was found in the workspace |
| `curl.exe -sS -o NUL -w "home %{http_code}\n" https://theguradio.com/` | pass | `home 200` |
| `curl.exe -sS -o NUL -w "opcache %{http_code}\n" https://theguradio.com/gu-opcache-reset.php` | pass | `opcache 404` |
| `curl.exe -sS -o NUL -w "purge %{http_code}\n" https://theguradio.com/gu-litespeed-purge.php` | pass | `purge 404` |
| `curl.exe -sS -o NUL -w "direct-write %{http_code}\n" https://theguradio.com/gu-direct-write.php` | pass | `direct-write 404` |
| `curl.exe -sS -o NUL -w "js-uploader %{http_code}\n" https://theguradio.com/gu-js-uploader.php` | pass | `js-uploader 404` |
| `php -v` | fail | local `php` CLI is still unavailable in this workspace |

## Current Build Posture

`deployment blocked`

## Notes

- This pass did not change PHP code because the next accepted step was live deployment and verification, not more local feature work.
- The live site is reachable, but the previously referenced public helper endpoints are not present on the site as of `2026-04-23`.
- No authenticated deployment path could be recovered from the workspace or environment during this pass.
