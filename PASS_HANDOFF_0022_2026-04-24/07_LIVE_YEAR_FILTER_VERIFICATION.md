# Live Year Filter Verification

## Code change summary

The live fix replaced the archive-route year filter query key with `gu_scene_year` and added a compatibility redirect for legacy `?year=` requests on archive-related routes.

## Live deployment verification

### `class-gu-scene-archive-template-controller.php`

- remote target:
  - `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-template-controller.php`
- pre-deploy SHA-256:
  - `9C905E13E9194A78FC99D786FEDB1882A068BFF5619809536DD5A39443D49D97`
- post-deploy SHA-256:
  - `53E838428EFCA0BEA3F6754A3B816F2B62914708B8B5DA087168FD6910D71A89`
- backup file:
  - `class-gu-scene-archive-template-controller.pre-codex-0022-20260424-004713.php`

### `archive-archive-item.php`

- remote target:
  - `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/templates/archive-archive-item.php`
- pre-deploy SHA-256:
  - `5B64B7402B72A8659A4F62C4D1A5C1BDD54A2A8CDF2524D8F7BFB961B130285E`
- post-deploy SHA-256:
  - `C1BDFFD7322F70940600161F641F1323A53A3079ACFC8DADC57496F6610F8CE3`
- backup file:
  - `archive-archive-item.pre-codex-0022-20260424-004713.php`

### `archive-scene-video.php`

- remote target:
  - `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/templates/archive-scene-video.php`
- pre-deploy SHA-256:
  - `A945C82E984E8C8F65BAE6B2A2A1EE96959E3CABBEC735AFA53864DB9E9981D6`
- post-deploy SHA-256:
  - `37E615057586A70E844051E149F5764CE129E4A7D18485A5AF2FAB4489262B1E`
- backup file:
  - `archive-scene-video.pre-codex-0022-20260424-004713.php`

### `history-archive.php`

- remote target:
  - `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/templates/history-archive.php`
- pre-deploy SHA-256:
  - `92F8D7460AF5E6B0A33FC5A5C8C4A7A9DA290CCD7AFC6C671AC8AD6F74C622B8`
- post-deploy SHA-256:
  - `0613D73E9E1173067E9A60F66F3818C2ABD97C5D937C8B0CAF74285C7865442C`
- backup file:
  - `history-archive.pre-codex-0022-20260424-004713.php`

## Public route verification

### Corrected year-filter routes

- `/archive/?gu_scene_year=2023&codex_verify=0022`
  - `200`
  - contains `Frequenseas Event`

- `/history/?gu_scene_year=2024&codex_verify=0022`
  - `200`
  - contains `Livestream PNG`

- `/performances/?gu_scene_year=2024&codex_verify=0022`
  - `200`

- `/history-topic/timeline/?gu_scene_year=2024&codex_verify=0022`
  - `200`
  - contains `Livestream PNG`

### Related unaffected routes

- `/archive/?archive_type=flyer&codex_verify=0022`
  - `200`
  - contains `Show Flyer`
  - contains `Facebook Flyer`

- `/archive/show-flyer/?codex_verify=0022`
  - `200`
  - contains `Show Flyer`
  - contains `Open Source`

### Legacy compatibility

- `/archive/?year=2023&codex_verify=0022`
  - first response: `301`
  - `Location`: `https://theguradio.com/archive/?codex_verify=0022&gu_scene_year=2023`
  - final response: `200`
  - contains `Frequenseas Event`

## Data impact

- No live archive or history records were modified during this pass.
