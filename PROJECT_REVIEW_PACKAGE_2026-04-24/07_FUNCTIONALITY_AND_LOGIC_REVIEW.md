# Functionality and Logic Review

## Core Functionality Status

| Function | Expected Behavior | Actual Behavior | Status | Issues |
| --- | --- | --- | --- | --- |
| Browse performances | Visitors can filter and open performance records | Works on live route with controlled filters | Functional | No automated QA or local PHP lint |
| Browse archive items | Visitors can filter and open archive records | Works on live route with archive-type/history/year filters | Functional | Content depth still limited |
| Browse history | Visitors can view history records and topics | Works on live route; empty topics suppressed | Functional with issues | Topic coverage is narrow |
| Search internal content | Query should return grouped internal matches first | Works and renders internal sections first | Functional | Filter UX remains legacy/free-text |
| Search external content | Enabled providers should return grouped external matches | Works structurally, but empty when providers are disabled/stubbed | Functional with issues | SoundCloud and Spotify are not implemented |
| Legacy year-filter handling | Old `?year=` links should not break archive-related routes | Live redirect now works for archive route | Functional | Search route still uses raw `year` instead of the newer archive query-var model |
| Review-home access control | Review homepage should stay private | Public route returns `404`; admin access guarded in code | Functional | Transitional template still exists and can drift |
| Maintenance actions | Admin should be able to audit, validate, normalize, and clear caches | Real admin actions exist in code and have been used in prior passes | Functional | Not reproducible from repo alone |
| Promotion workflow | Admin should be able to create permanent records from discoveries | Substantial workflow exists in code | Partial | Production maturity and end-to-end QA remain unclear |
| Homepage front door | `/` should represent the archive product clearly | Public `/` is still a legacy/front-page state | Partial | Biggest product-level logic gap |

## Broken Behavior

- SoundCloud provider results are not implemented
- Spotify provider results are not implemented
- There is no repeatable local build/lint/test path for the PHP plugin in this workspace

## Partial Behavior

- Public homepage/front-door conversion is incomplete
- Search works, but its filter inputs still use the older raw `year` query approach rather than the archive-route controlled-select pattern
- Promotion/discovery workflows exist, but their operational completeness is not fully evidenced from repo-only review
- Events surface is conditional on MEC data and otherwise falls back to archive records

## Placeholder Behavior

- `review-home.php` still contains parked/placeholder “Upcoming Shows” copy
- SoundCloud and Spotify adapters are deliberate scaffolds, not live integrations
- The repo root `README.md` functions as a placeholder rather than real project documentation

## Logic Risks

- Split source of truth: local repo, `staged_remote_changes`, live DB, and handoff packages each hold part of the truth
- Search UI/parameter logic is not fully aligned with the corrected archive year-filter behavior
- Manual operational state in WordPress options is invisible to Git-based review
- The public experience can drift from the intended product if the homepage remains outside the plugin-centered architecture
- External-result expectations can exceed current provider reality

## Evidence

- Search controller/service: [class-gu-scene-archive-search-controller.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-search-controller.php), [class-gu-scene-archive-search-service.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-search-service.php)
- Route controller: [class-gu-scene-archive-template-controller.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-template-controller.php)
- Provider stubs: [class-gu-scene-archive-soundcloud-provider.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/providers/class-gu-scene-archive-soundcloud-provider.php), [class-gu-scene-archive-spotify-provider.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/providers/class-gu-scene-archive-spotify-provider.php)
- Live year-filter checks: [logs/year_filter_checks.txt](logs/year_filter_checks.txt)
