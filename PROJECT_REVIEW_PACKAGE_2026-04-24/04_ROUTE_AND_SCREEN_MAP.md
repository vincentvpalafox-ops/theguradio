# Route / Screen Map

## Public Routes and Screens

| Route / Screen | Purpose | Components Used | Data Source | Current Status | Known Problems |
| --- | --- | --- | --- | --- | --- |
| `/` | Current public homepage | WordPress page/Elementor, not yet the intended archive-backed front door | Live WordPress page content | Functional with issues | Misaligned with intended final product |
| `/review-home/` | Transitional private review homepage | `review-home.php` via virtual route in template controller | `scene_video` posts | Partial | Publicly returns `404`; template still contains placeholder copy |
| `/performances/` | Public performance library | `archive-scene-video.php`, archive helpers | `scene_video` CPT, taxonomies, meta | Functional | Quality depends on curated records and search/filter consistency |
| `/performances/{slug}/` | Single performance record | `single-scene-video.php` | `scene_video` post/meta/taxonomies | Functional | No automated regression coverage |
| `/archive/` | Public archive library | `archive-archive-item.php`, archive helpers | `archive_item` CPT, taxonomies, meta | Functional | Depth still thin; still in partial-product context |
| `/archive/{slug}/` | Single archive record | `single-archive-item.php` | `archive_item` post/meta/taxonomies | Functional | No automated regression coverage |
| `/history/` | History archive | `history-archive.php` | `archive_item` plus `history_topic`/`archive_type` | Functional | Current topic diversity is narrow |
| `/history-topic/{slug}/` | Direct history topic archive | `history-archive.php` | `history_topic` taxonomy + archive items | Functional with issues | Empty terms are intentionally suppressed with `404`; only populated topics work |
| `/search/` | Public search screen | `search-page.php`, search controller/service | Internal posts plus enabled providers | Functional with issues | Filter UX still uses free-text inputs and legacy `year` parameter |

## Admin / Operator Screens

| Route / Screen | Purpose | Components Used | Data Source | Current Status | Known Problems |
| --- | --- | --- | --- | --- | --- |
| `wp-admin/admin.php?page=gu-scene-archive` | Main plugin admin/dashboard | Settings, operator dashboard | WordPress options and live records | Functional | No consolidated operator guide |
| `wp-admin/admin.php?page=gu-scene-archive-maintenance` | Maintenance actions and summaries | Maintenance class | WordPress options, live records | Functional | State stored only in live DB |
| `wp-admin/admin.php?page=gu-scene-archive-preview` | Search preview/discovery surface | Promotion/search workflow | Search service and providers | Partial | Operational maturity unclear |

## Navigation Model

Intended navigation model from project docs:

- Home
- Performances
- Archive
- History
- About

Current movement through the product:

- Public visitors can reliably move between `/archive/`, `/performances/`, `/history/`, and `/search/`
- Single-record pages are reachable from archive cards and REST-exposed records
- The strongest implemented archive experience is inside those dedicated archive routes, not on `/`
- `review-home` is intentionally not a public navigation destination

## Dead Routes

| Route | Why it is listed |
| --- | --- |
| `/review-home/` | Publicly unreachable by design because access requires logged-in admin capability; if anything still links to it publicly, that is a problem |
| `/history-topic/venue-legacy/` | Currently returns `404` because empty history-topic term routes are now intentionally suppressed |

## Missing Routes

These are product-level missing routes or missing public route states, not just absent URLs:

- A public homepage state at `/` that matches the intended archive-backed homepage design
- A clearly documented public About-route strategy aligned with the final navigation model
- A documented public moderation/promote workflow route map for operators

## Route Evidence

- Live route statuses: [logs/route_status.txt](logs/route_status.txt)
- Year-filter behavior: [logs/year_filter_checks.txt](logs/year_filter_checks.txt)
- Route controller implementation: [class-gu-scene-archive-template-controller.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-template-controller.php), [class-gu-scene-archive-search-controller.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-search-controller.php)
