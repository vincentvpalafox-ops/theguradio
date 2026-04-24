# 07 IMPLEMENTATION NOTES

## What The New Maintenance Step Does

- adds a new maintenance button: `Normalize Homepage Archive Metadata`
- targets `archive_item` records that support homepage archive/history sections
- only writes `scene_source` when:
  - the record is missing a source term
  - `gu_original_url` exists and is a valid URL
  - the URL host matches a supported source host
- counts history-class archive items that still lack `history_topic`, but does not guess the missing value

## Supported Source Hosts

- `youtube.com`, `youtu.be` -> `youtube`
- `soundcloud.com` -> `soundcloud`
- `spotify.com` -> `spotify`
- `bandcamp.com` -> `bandcamp`
- `facebook.com`, `fb.watch` -> `facebook`
- `instagram.com` -> `instagram`

## What It Explicitly Does Not Do

- does not rewrite excerpts or titles
- does not backfill thumbnails
- does not guess `history_topic`
- does not alter non-homepage-supporting archive items
- does not change public layout or templates

## Why This Pass Was Chosen

- the accepted next scope was metadata cleanup on homepage-visible archive records
- the workspace has no direct live content-edit path
- extending the existing maintenance tool was the smallest reversible change that makes the accepted scope executable without widening into redesign or new systems
