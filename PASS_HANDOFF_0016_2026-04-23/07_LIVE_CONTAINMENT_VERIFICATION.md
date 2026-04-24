# Live Containment Verification

## Target records

### `23680` - Gallatin Valley Venue Memory Project

- initial public state during this pass:
  - review-seed archive record
  - no canonical source URL
  - final public role no longer acceptable
- final state:
  - `post_status = draft`
  - `gu_link_status = hidden`
  - `gu_featured = empty`
  - direct public permalink returns `404`

### `23679` - Bozeman Flyer Archive

- initial public state during this pass:
  - review-seed archive record
  - no canonical source URL
  - final public role no longer acceptable
- final state:
  - `post_status = draft`
  - `gu_link_status = hidden`
  - `gu_featured = empty`
  - direct public permalink returns `404`

## Public route outcomes

### `/archive/`

- returns `200`
- renders:
  - `No archive records match the current filters yet.`
- does not render:
  - `Gallatin Valley Venue Memory Project`
  - `Bozeman Flyer Archive`
  - `Featured Archive Records`

### `/history/`

- returns `200`
- renders:
  - `No history records match the current filters yet.`
- does not render:
  - `Gallatin Valley Venue Memory Project`
  - `Bozeman Flyer Archive`
  - `Featured History Records`

### `/wp-json/wp/v2/archive_item`

- returns:
  - `[]`

## Remaining public residue

The archive/history pages still show review-era term chips or filter options even though there are no public archive records left.

Observed examples:

- `Venue Legacy`
- `history`
- `flyers`

That residue now appears to come from term-surface generation rather than live public record exposure.
