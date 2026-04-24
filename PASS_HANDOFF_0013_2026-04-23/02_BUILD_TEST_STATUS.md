# Tests And Checks Run

## Live execution checks

- Uploaded a one-time runner to the live `public_html` root.
- Bootstrapped WordPress through `wp-load.php`.
- Invoked the existing private normalization routine from `GU_Scene_Archive_Maintenance`.
- Updated the maintenance state option exactly as the admin handler would.
- Invoked the existing follow-up archive-audit routine.
- Removed the remote runner after successful execution.

## State verification

- Confirmed the normalization state was empty before this pass.
- Confirmed the normalization timestamp and summary were populated after execution.
- Confirmed the archive-audit timestamp and summary were refreshed after execution.

## Public-surface checks

- Requested `https://theguradio.com/archive/`
  - Result: live archive surface returned content and contained both featured archive record titles.
- Requested `https://theguradio.com/history/`
  - Result: request completed, but the body rendered a `Page not found` surface.
- Requested `https://theguradio.com/`
  - Result: homepage returned content with no fatal-error markers.
- Requested the history-supporting record permalink directly:
  - `https://theguradio.com/archive/gallatin-valley-venue-memory-project-review-seed/`
  - Result: returned content and contained the record title.

## Results

- Workflow execution passed.
- Remote cleanup passed.
- Archive route verification passed.
- History record permalink verification passed.
- Public history landing route verification failed because `/history/` currently renders a not-found page.

## Not run

- No WordPress admin-browser session was used in this pass.
- No local PHP CLI lint was run because `php` is still unavailable in this workspace.
