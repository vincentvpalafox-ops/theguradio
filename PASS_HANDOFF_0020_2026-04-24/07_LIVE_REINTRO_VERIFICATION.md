# Live Reintroduction Verification

## Source-backed media selected

### `8807` / `Facebook Flyer`

- source URL:
  - `https://theguradio.com/wp-content/uploads/2024/04/Facebook-Flyer.png`
- selected use:
  - flyer-class archive record

### `7230` / `Poster 1720`

- source URL:
  - `https://theguradio.com/wp-content/uploads/2021/11/Poster-1720.png`
- selected use:
  - poster-class archive record

### `8828` / `Livestream PNG`

- source URL:
  - `https://theguradio.com/wp-content/uploads/2024/09/Livestream-PNG.jpg`
- selected use:
  - second timeline-class history record

## Live record creation result

### `23744` / `Facebook Flyer`

- action:
  - created
- status:
  - `publish`
- permalink:
  - `https://theguradio.com/archive/facebook-flyer/`
- `gu_original_url`:
  - `https://theguradio.com/wp-content/uploads/2024/04/Facebook-Flyer.png`
- taxonomy:
  - `archive_type = flyer`
  - `scene_year = 2024`
- visibility:
  - `gu_approved = 1`
  - `gu_link_status = live`
- thumbnail:
  - `8807`

### `23746` / `Poster 1720`

- action:
  - created
- status:
  - `publish`
- permalink:
  - `https://theguradio.com/archive/poster-1720/`
- `gu_original_url`:
  - `https://theguradio.com/wp-content/uploads/2021/11/Poster-1720.png`
- taxonomy:
  - `archive_type = poster`
  - `scene_year = 2021`
- visibility:
  - `gu_approved = 1`
  - `gu_link_status = live`
- thumbnail:
  - `7230`

### `23748` / `Livestream PNG`

- action:
  - created
- status:
  - `publish`
- permalink:
  - `https://theguradio.com/archive/livestream-png-history-record/`
- `gu_original_url`:
  - `https://theguradio.com/wp-content/uploads/2024/09/Livestream-PNG.jpg`
- taxonomy:
  - `archive_type = history`
  - `history_topic = timeline`
  - `scene_year = 2024`
- visibility:
  - `gu_approved = 1`
  - `gu_link_status = live`
- thumbnail:
  - `8828`

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
  - `Parahellion`
  - `Livestream Series`
  - `Facebook Flyer`
  - `Poster 1720`
  - `Livestream PNG`
- does not contain:
  - `No archive records match the current filters yet.`
- fatal markers:
  - not present

### `/history/`

- HTTP:
  - `200`
- contains:
  - `Livestream Series`
  - `Livestream PNG`
  - `Timeline`
- does not contain:
  - `No history records match the current filters yet.`
- fatal markers:
  - not present

### `/history-topic/timeline/`

- HTTP:
  - `200`
- contains:
  - `Livestream Series`
  - `Livestream PNG`
  - `Timeline`
- does not contain:
  - `No history records match the current filters yet.`
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

- `/archive/facebook-flyer/`
  - `200`
  - `Open Source` link present

- `/archive/poster-1720/`
  - `200`
  - `Open Source` link present

- `/archive/livestream-png-history-record/`
  - `200`
  - `Open Source` link present
  - `Timeline` visible

## Public API state

- `wp-json/wp/v2/archive_item?per_page=100&_fields=id,slug,title,link,status`
  - returns:
    - `23748` / `livestream-png-history-record`
    - `23746` / `poster-1720`
    - `23744` / `facebook-flyer`
    - `23742` / `livestream-series-history-record`
    - `23740` / `parahellion-gu-livestream`

## Temporary runner cleanup

- Confirmed `gu-archive-reintro-0020.php` returns `404` after use
