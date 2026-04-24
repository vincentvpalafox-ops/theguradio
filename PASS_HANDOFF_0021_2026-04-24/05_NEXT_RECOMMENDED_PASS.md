# Next Recommended Pass

The next admissible pass should be a narrow code fix for the public archive year filter.

## Recommended scope

- trace how the archive browse layer reads the year filter from the request
- confirm whether the public filter is using the reserved `year` query key
- replace that key or otherwise harden the filter parsing so year-based browsing does not 404
- verify at minimum:
  - `/archive/`
  - `/archive/?year=2023` or its corrected replacement
  - `/archive/?archive_type=flyer`
  - existing single-record routes
  - existing history routes

## Why this is next

This pass improved archive density with real public records. The sharpest concrete defect exposed by that progress is now browse usability, not content scarcity.
