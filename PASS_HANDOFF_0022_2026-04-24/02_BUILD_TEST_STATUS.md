# Tests And Checks Run

## Local code checks

- `git diff --check`
  - pass

- targeted code review on:
  - `class-gu-scene-archive-template-controller.php`
  - `archive-archive-item.php`
  - `archive-scene-video.php`
  - `history-archive.php`
  - pass

- local PHP lint
  - not run
  - `php` CLI is still unavailable in this workspace

## Live deployment checks

- Pulled each pre-deploy live file through cPanel Fileman `get_file_content`
  - pass

- Uploaded each modified local file as a temporary remote file through cPanel Fileman `upload_files`
  - pass

- Verified each temporary upload by SHA-256 before promotion
  - pass

- Renamed each live file to a timestamped backup through cPanel API 2 `Fileman::fileop`
  - pass

- Renamed each verified temporary upload into the production filename through cPanel API 2 `Fileman::fileop`
  - pass

- Pulled each post-deploy live file back through cPanel Fileman and verified SHA-256
  - pass

- Pulled each backup file back through cPanel Fileman and verified it preserved the previous live bytes
  - pass

## Public route verification

- `https://theguradio.com/archive/?gu_scene_year=2023&codex_verify=0022`
  - `200`
  - contains `Frequenseas Event`
  - no 404 marker
  - no fatal marker

- `https://theguradio.com/archive/?archive_type=flyer&codex_verify=0022`
  - `200`
  - contains `Show Flyer`
  - contains `Facebook Flyer`
  - no 404 marker
  - no fatal marker

- `https://theguradio.com/history/?gu_scene_year=2024&codex_verify=0022`
  - `200`
  - contains `Livestream PNG`
  - no 404 marker
  - no fatal marker

- `https://theguradio.com/performances/?gu_scene_year=2024&codex_verify=0022`
  - `200`
  - no 404 marker
  - no fatal marker

- `https://theguradio.com/archive/show-flyer/?codex_verify=0022`
  - `200`
  - contains `Show Flyer`
  - contains `Open Source`
  - no 404 marker
  - no fatal marker

- `https://theguradio.com/history-topic/timeline/?gu_scene_year=2024&codex_verify=0022`
  - `200`
  - contains `Livestream PNG`
  - no 404 marker
  - no fatal marker

## Legacy URL compatibility verification

- `https://theguradio.com/archive/?year=2023&codex_verify=0022`
  - initial response: `301`
  - `Location`: `https://theguradio.com/archive/?codex_verify=0022&gu_scene_year=2023`
  - final response after redirect: `200`
  - contains `Frequenseas Event`
  - no 404 marker
  - no fatal marker
