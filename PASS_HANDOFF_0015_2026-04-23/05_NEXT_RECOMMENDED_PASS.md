# Next Recommended Pass

Proceed only after source evidence is available.

Safe next moves are:

1. Recover or provide real canonical source URLs for the two archive records.
2. Write those URLs into `gu_original_url`.
3. Re-run homepage-archive metadata normalization.
4. Confirm:
   - `source_backfills > 0`
   - `source_skipped_no_url = 0`
   - `scene_source` terms appear on both records

If no real external source exists for one or both records:

1. replace the seed record with a real attributable archive item, or
2. remove it from featured homepage/archive support so the public surface no longer depends on unverifiable placeholder content
