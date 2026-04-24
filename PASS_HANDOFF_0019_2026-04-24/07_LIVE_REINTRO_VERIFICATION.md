# Live Reintroduction Verification

## Source-backed media selected

### Attachment `8658`

- title:
  - `Parahellion – GU Livestream`
- source URL:
  - `https://theguradio.com/wp-content/uploads/2024/01/Parahellion-GU-Livestream.png`
- file path:
  - `2024/01/Parahellion-GU-Livestream.png`
- selected use:
  - first public archive media record

### Attachment `8656`

- title:
  - `Livestream Series`
- source URL:
  - `https://theguradio.com/wp-content/uploads/2021/10/Livestream-Series.png`
- file path:
  - `2021/10/Livestream-Series.png`
- selected use:
  - first public history record

## Live record creation result

### `23740` / `Parahellion – GU Livestream`

- action:
  - created
- status:
  - `publish`
- permalink:
  - `https://theguradio.com/archive/parahellion-gu-livestream/`
- `gu_original_url`:
  - `https://theguradio.com/wp-content/uploads/2024/01/Parahellion-GU-Livestream.png`
- taxonomy:
  - `archive_type = media`
  - `scene_year = 2024`
- visibility:
  - `gu_approved = 1`
  - `gu_link_status = live`
- thumbnail:
  - `8658`

### `23742` / `Livestream Series`

- action:
  - created
- status:
  - `publish`
- permalink:
  - `https://theguradio.com/archive/livestream-series-history-record/`
- `gu_original_url`:
  - `https://theguradio.com/wp-content/uploads/2021/10/Livestream-Series.png`
- taxonomy:
  - `archive_type = history`
  - `history_topic = timeline`
  - `scene_year = 2021`
- visibility:
  - `gu_approved = 1`
  - `gu_link_status = live`
- thumbnail:
  - `8656`

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
- does not contain:
  - `No archive records match the current filters yet.`
- fatal markers:
  - not present

### `/history/`

- HTTP:
  - `200`
- contains:
  - `Livestream Series`
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

- `/archive/parahellion-gu-livestream/`
  - `200`
  - `Open Source` link present

- `/archive/livestream-series-history-record/`
  - `200`
  - `Open Source` link present
  - `Timeline` visible

## Public API state

- `wp-json/wp/v2/archive_item?per_page=100&_fields=id,slug,title,link,status`
  - returns:
    - `23742` / `livestream-series-history-record`
    - `23740` / `parahellion-gu-livestream`

## Temporary runner cleanup

- Confirmed all disposable pass `0019` runner URLs return `404` after use
