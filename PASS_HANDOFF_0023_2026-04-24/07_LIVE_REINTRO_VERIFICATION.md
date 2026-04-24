# Live Reintroduction Verification

## Source-backed media selected

### `8535` / `Open Slot`

- source URL:
  - `https://theguradio.com/wp-content/uploads/2023/01/Open-Slot.png`
- selected use:
  - media-class archive record

### `8106` / `Post-Art-Show.png`

- source URL:
  - `https://theguradio.com/wp-content/uploads/2022/12/Post-Art-Show.png`
- selected use:
  - media-class archive record

## Live record creation result

### `23754` / `Open Slot`

- action:
  - created
- status:
  - `publish`
- permalink:
  - `https://theguradio.com/archive/open-slot/`
- `gu_original_url`:
  - `https://theguradio.com/wp-content/uploads/2023/01/Open-Slot.png`
- taxonomy:
  - `archive_type = media`
  - `scene_year = 2023`
- visibility:
  - `gu_approved = 1`
  - `gu_link_status = live`
- thumbnail:
  - `8535`

### `23756` / `Post Art Show`

- action:
  - created
- status:
  - `publish`
- permalink:
  - `https://theguradio.com/archive/post-art-show/`
- `gu_original_url`:
  - `https://theguradio.com/wp-content/uploads/2022/12/Post-Art-Show.png`
- taxonomy:
  - `archive_type = media`
  - `scene_year = 2022`
- visibility:
  - `gu_approved = 1`
  - `gu_link_status = live`
- thumbnail:
  - `8106`

## Term coverage

- `scene_year = 2022` created as term id `143`
- `scene_year = 2023` confirmed as term id `142`
- `archive_type = media` confirmed as term id `133`

## Review-seed containment preserved

### `23679` / `Bozeman Flyer Archive`

- status:
  - `draft`
- `gu_link_status`:
  - `hidden`
- `gu_original_url`:
  - empty

### `23680` / `Gallatin Valley Venue Memory Project`

- status:
  - `draft`
- `gu_link_status`:
  - `hidden`
- `gu_original_url`:
  - empty

## Public-route verification

### `/archive/?gu_scene_year=2023`

- HTTP:
  - `200`
- contains:
  - `Open Slot`
  - `Frequenseas Event`
- fatal markers:
  - not present

### `/archive/?gu_scene_year=2022`

- HTTP:
  - `200`
- contains:
  - `Post Art Show`
- fatal markers:
  - not present

### `/history/?gu_scene_year=2024`

- HTTP:
  - `200`
- contains:
  - `Livestream PNG`
- fatal markers:
  - not present

### Single records

- `/archive/open-slot/`
  - `200`
  - `Open Source` link present

- `/archive/post-art-show/`
  - `200`
  - `Open Source` link present

## Legacy compatibility

- `/archive/?year=2022&codex_verify=0023`
  - first response: `301`
  - redirected to `?gu_scene_year=2022`
  - final response: `200`
  - contains `Post Art Show`

## Public API state

- `wp-json/wp/v2/archive_item?per_page=100&_fields=id,slug,title,link,status`
  - returns:
    - `23756` / `post-art-show`
    - `23754` / `open-slot`
    - `23752` / `frequenseas-event`
    - `23750` / `show-flyer`
    - `23748` / `livestream-png-history-record`
    - `23746` / `poster-1720`
    - `23744` / `facebook-flyer`
    - `23742` / `livestream-series-history-record`
    - `23740` / `parahellion-gu-livestream`

## Temporary runner cleanup

- Confirmed `gu-archive-reintro-0023.php` returns `404` after use
