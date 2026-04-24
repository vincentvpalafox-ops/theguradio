# Next Recommended Pass

Proceed with a bounded content-and-route correction pass:

1. Add canonical `gu_original_url` values to the two featured archive records:
   - `Gallatin Valley Venue Memory Project`
   - `Bozeman Flyer Archive`
2. Add a real `history_topic` term to `Gallatin Valley Venue Memory Project`.
3. Verify or restore the public `/history/` route so the history surface resolves to the intended archive template.
4. Re-run the same live normalization verification pass and confirm:
   - `source_backfills > 0`
   - `history_topic_evidence_blocked = 0`
   - `/history/` renders the expected history archive instead of a not-found page
