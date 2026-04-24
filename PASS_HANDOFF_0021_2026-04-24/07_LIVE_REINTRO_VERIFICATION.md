# Live Reintroduction Verification

## Source-backed media selected

### `7355` / `Show Flyer`

- source URL:
  - `https://theguradio.com/wp-content/uploads/2021/12/Show-Flyer.png`
- selected use:
  - flyer-class archive record

### `8641` / `Frequenseas Event`

- source URL:
  - `https://theguradio.com/wp-content/uploads/2023/10/Frequenseas-Event.png`
- selected use:
  - media-class archive record

## Live record creation result

### `23750` / `Show Flyer`

- action:
  - created
- status:
  - `publish`
- permalink:
  - `https://theguradio.com/archive/show-flyer/`
- `gu_original_url`:
  - `https://theguradio.com/wp-content/uploads/2021/12/Show-Flyer.png`
- taxonomy:
  - `archive_type = flyer`
  - `scene_year = 2021`
- visibility:
  - `gu_approved = 1`
  - `gu_link_status = live`
- thumbnail:
  - `7355`

### `23752` / `Frequenseas Event`

- action:
  - created
- status:
  - `publish`
- permalink:
  - `https://theguradio.com/archive/frequenseas-event/`
- `gu_original_url`:
  - `https://theguradio.com/wp-content/uploads/2023/10/Frequenseas-Event.png`
- taxonomy:
  - `archive_type = media`
  - `scene_year = 2023`
- visibility:
  - `gu_approved = 1`
  - `gu_link_status = live`
- thumbnail:
  - `8641`

## Scene year coverage

- `2023` was created or confirmed as `scene_year` term id `142`

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

### `/archive/`

- HTTP:
  - `200`
- contains:
  - `Show Flyer`
  - `Frequenseas Event`
- fatal markers:
  - not present

### `/archive/?year=2023`

- HTTP:
  - `404`
- interpretation:
  - unexpected browse failure
  - likely year-filter query-var collision

### `/history/`

- HTTP:
  - `200`
- contains:
  - `Livestream Series`
  - `Livestream PNG`
- fatal markers:
  - not present

### `/history-topic/timeline/`

- HTTP:
  - `200`
- contains:
  - `Livestream Series`
  - `Livestream PNG`
- fatal markers:
  - not present

### `/history-topic/venue-legacy/`

- HTTP:
  - `404`
- contains:
  - not-found markers
- fatal markers:
  - not present

### Single records

- `/archive/show-flyer/`
  - `200`
  - `Open Source` link present

- `/archive/frequenseas-event/`
  - `200`
  - `Open Source` link present
  - `2023` visible

## Public API state

- `wp-json/wp/v2/archive_item?per_page=100&_fields=id,slug,title,link,status`
  - returns:
    - `23752` / `frequenseas-event`
    - `23750` / `show-flyer`
    - `23748` / `livestream-png-history-record`
    - `23746` / `poster-1720`
    - `23744` / `facebook-flyer`
    - `23742` / `livestream-series-history-record`
    - `23740` / `parahellion-gu-livestream`

## Temporary runner cleanup

- Confirmed `gu-archive-reintro-0021.php` returns `404` after use
