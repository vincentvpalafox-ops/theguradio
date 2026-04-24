# PASS HANDOFF 0017 - PUBLIC TAXONOMY SURFACE CLEANUP

## What was changed

This pass completed the next bounded cleanup after review-seed containment.

It changed the shared archive template helper so public term chips and filter selects are built from the current page's public-visible published records instead of raw taxonomy counts.

Changed local source:

- `staged_remote_changes/wp-content/plugins/gu-scene-archive/templates/archive-helpers.php`

Changed live file:

- `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/templates/archive-helpers.php`

Live deployment included a same-directory backup:

- `/home/thegalla/public_html/wp-content/plugins/gu-scene-archive/templates/archive-helpers.pre-codex-0017-20260424-000044.php`

## Results

The public archive/history taxonomy residue is now removed from the main public surfaces.

- `/archive/` still returns `200`
- `/history/` still returns `200`
- both routes keep their empty-state copy
- leftover review-stage chips/options such as `Venue Legacy`, `history`, and `flyers` no longer appear on those public surfaces
- `/performances/` still returns `200` and did not show fatal-error markers after the helper deploy

The earlier containment state is unchanged:

- `wp-json/wp/v2/archive_item` still returns `[]`
- the two old review-seed permalinks still return `404`

## Recommended next step

Run one final bounded taxonomy-route cleanup pass only if you want direct empty term routes cleaned up too.

Example residual:

- `/history-topic/venue-legacy/` still resolves as a direct empty term page because the term itself still exists, even though it no longer appears in public chips/selects

If that route should no longer exist publicly, the next pass should either:

1. prune the unused review-stage taxonomy terms from live data, or
2. make empty public term archives 404 or otherwise suppress them
