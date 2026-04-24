# Testing / QA Evidence

## Tests Present

| Test / Check Type | Present | Notes |
| --- | --- | --- |
| Unit tests | No | None found in repo |
| Integration tests | No | None found in repo |
| End-to-end tests | No | None found in repo |
| Manual test scripts | Yes | Handoff packages and this review use manual route verification |
| Accessibility tests | No | None found in repo |
| Linting | Partial | `git diff --check` is possible; no PHP linter available locally |
| Type checks | No | No TypeScript/build config found |
| Build checks | Partial | Route-level live verification exists; no app build pipeline found |
| Deployment checks | Yes | Live route and REST checks used in recent passes and this review |

## Latest Test Results

| Command | Result | Notes |
| --- | --- | --- |
| `curl` route checks against `/`, `/archive/`, `/performances/`, `/history/`, `/search/`, topic routes | Pass with caveats | Public core routes are `200`; `review-home` and empty topic route correctly `404`: [logs/route_status.txt](logs/route_status.txt) |
| `curl` public REST check for `archive_item` | Pass | 9 current public archive items: [logs/public_archive_items.json](logs/public_archive_items.json) |
| `curl` public REST check for `scene_video` | Pass | 5 current public scene videos: [logs/public_scene_videos.json](logs/public_scene_videos.json) |
| `curl` year-filter regression checks | Pass | `?year=` redirects on archive route, `gu_scene_year` returns `200`: [logs/year_filter_checks.txt](logs/year_filter_checks.txt) |
| `php -v` | Fail / unavailable | `php` not installed locally: [logs/tool_availability.txt](logs/tool_availability.txt) |
| Config/build-file scan | No build/test pipeline found | No `package.json`, `composer.json`, `phpunit.xml`, Playwright/Cypress/Jest config found during review |

## Manual QA Checklist

| QA Item | Status | Notes |
| --- | --- | --- |
| Public homepage loads | Pass | Route returns `200` |
| Public archive loads | Pass | Route returns `200` |
| Public performances loads | Pass | Route returns `200` |
| Public history loads | Pass | Route returns `200` |
| Public search loads | Pass | Route returns `200` |
| Public timeline topic loads | Pass | Route returns `200` |
| Empty history-topic route suppressed | Pass | `venue-legacy` returns `404` |
| Public review-home blocked | Pass | Route returns `404` for public access |
| Archive year filter works | Pass | `gu_scene_year` works; legacy `year` redirects |
| Search query returns grouped sections | Pass | `q=livestream` produced internal/external sections |
| External search providers verified end-to-end | Fail | No evidence of SoundCloud/Spotify results; YouTube auth state not revalidated here |
| Mobile layout verified | Not tested | No browser/screenshot tool available locally |
| Accessibility verified | Not tested | No automated or manual accessibility run performed |
| Local PHP lint | Not tested | `php` CLI unavailable |

## Known QA Gaps

- No automated test suite
- No PHP syntax lint in this environment
- No screenshot/mobile/tablet validation evidence
- No accessibility audit
- No reproducible local setup to mirror live WordPress behavior

## Release Blockers

- Public homepage is still not the intended archive front door
- No reproducible automated test/build path exists
- Search/provider behavior is only partially validated
- Repo does not fully capture the live operational state
