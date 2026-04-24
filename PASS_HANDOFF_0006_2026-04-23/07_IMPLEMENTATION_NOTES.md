# 07 IMPLEMENTATION NOTES

## What Changed

- the homepage archive metadata normalization action now stores:
  - summary counts
  - per-record detail rows
- the maintenance screen now renders a review table after a run

## What Each Detail Row Shows

- record title with edit link
- homepage role:
  - featured archive
  - history support
  - or both
- source result:
  - already had source label
  - backfilled source label
  - blocked by missing/invalid URL
  - blocked by unsupported source host
- history topic result:
  - history topic present
  - evidence-blocked: missing history topic
  - not a history record
- host evidence:
  - normalized canonical host from `gu_original_url`
  - or `No canonical source host`

## Why This Pass Was Worth Doing

- the previous pass created the normalization action
- this pass makes the action reviewable and safer to run in production because the operator can see exactly what it did
- it stays inside the accepted scope: homepage-supporting archive metadata only
