# UI / UX Review

## Overall UI Judgment

| Area | Score |
| --- | --- |
| Professional polish | 6/10 |
| Layout consistency | 7/10 |
| Readability | 7/10 |
| Navigation clarity | 6/10 |
| Mobile usability | 5/10 |
| Visual hierarchy | 7/10 |
| Production readiness | 5/10 |

These scores are based on live HTML/content review, route behavior, and template inspection. They are conservative because screenshot-based cross-device verification was not possible in this workspace.

## Screen-by-Screen UI Notes

| Screen | What Works | What Fails | Severity | Recommended Fix |
| --- | --- | --- | --- | --- |
| Home `/` | Live and branded; public entry point works | Still not the intended archive-centric front door | High | Replace with the archive-backed homepage already implemented in shortcode form |
| Archive `/archive/` | Clear heading, filters, browse chips, reusable cards | Still feels content-light; success depends on a small dataset | Medium | Keep template, deepen records, and wire from homepage |
| Performances `/performances/` | Consistent archive treatment and clear filter model | Still depends on a limited performance dataset and no formal QA | Medium | Keep current template and validate after homepage conversion |
| History `/history/` | Dedicated history surface exists and is no longer broken | Topic breadth is narrow; history feels thin | Medium | Expand history coverage after homepage/front-door alignment |
| Search `/search/` | Clear internal/external grouping; result cards have actionable links | Filter UX is weaker than archive pages and external empties are common | Medium | Replace free-text filter inputs with controlled UI later |
| Review-home code surface | Has a coherent visual direction for a review surface | Private-review label, placeholder “Upcoming Shows”, duplicated content logic, and stale product story | High | Keep private or retire; do not use as public front door |

## Layout Defects

Observed or strongly indicated defects:

- The public homepage is structurally inconsistent with the intended archive system
- `review-home.php` contains a parked placeholder section for upcoming shows instead of real product behavior
- Search filters use free-text inputs, which is weaker UX than the controlled selects used on archive routes
- No screenshot-based evidence was available for mobile/tablet validation, so responsive quality is not production-proven

Not fully tested in this review:

- Overlapping text
- Stacked letters
- Broken small-screen wrapping
- Contrast/accessibility failures
- Modal/drawer behavior

## Design System Status

Present:

- Shared archive/search/section CSS files
- Reusable archive card rendering helpers
- Reusable shortcode-driven sections
- Common CTA/button patterns in templates

Partial:

- Color palette
- Typography rules
- Spacing system
- Card standards
- Form standards

Missing or under-documented:

- Repo-level design system documentation
- Explicit mobile standards
- Accessibility standards
- Table/dashboard standards as maintained documentation
- A formal source of truth for homepage visual language

## Evidence

- Templates: [archive-archive-item.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/templates/archive-archive-item.php), [archive-scene-video.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/templates/archive-scene-video.php), [history-archive.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/templates/history-archive.php), [search-page.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/templates/search-page.php), [review-home.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/templates/review-home.php)
- Live route markers: [logs/route_status.txt](logs/route_status.txt)
