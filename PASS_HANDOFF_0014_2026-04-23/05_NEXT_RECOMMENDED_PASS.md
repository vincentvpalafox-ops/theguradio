# Next Recommended Pass

Proceed with the final bounded metadata-correction slice:

1. Gather evidence-backed canonical source URLs for:
   - `Gallatin Valley Venue Memory Project`
   - `Bozeman Flyer Archive`
2. Write those `gu_original_url` values to the live records.
3. Re-run the existing homepage-archive metadata normalization.
4. Confirm:
   - `source_backfills > 0`
   - `source_skipped_no_url = 0`
   - `scene_source` terms appear on both qualifying records
5. Decide whether to keep or remove the template-controller backup file after that verification pass.
