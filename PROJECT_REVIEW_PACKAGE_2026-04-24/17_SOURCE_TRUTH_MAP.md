# Source Truth Map

| Area | Current Source of Truth | Confidence | Conflicts |
| --- | --- | --- | --- |
| Product vision | `GU_MASTER_PLATFORM_PACKAGE` docs, especially `00`-`04` and `13` | High | Public homepage does not yet match the documented vision |
| Feature list | Plugin code plus plugin README | Medium | Docs and live deployment are not perfectly aligned |
| Routes | Template/search controller code plus live route checks | High | Some transitional routes still exist in code |
| Data model | `class-gu-scene-archive-content.php` and record-manager code | High | Live data values are outside repo |
| Design system | Template/CSS implementation in plugin | Medium-Low | No maintained design-system document |
| User roles/capabilities | WordPress capability checks in plugin code | Medium | No dedicated role/capability matrix doc |
| Workflow logic | Platform docs plus maintenance/promotion/operator code | Medium | Operational maturity varies by feature |
| Scoring/calculations | `class-gu-scene-archive-search-service.php` and settings | High | Search UX does not fully reflect the corrected archive filter model |
| Deployment instructions | Recent pass artifacts and operator knowledge | Low | No single canonical deployment guide |
| Content/docs/handbook | Live WordPress database/content | Low | Not versioned in Git |
| Issue tracking | Pass handoffs and ad hoc docs | Low | No normalized issue tracker in repo |
| Changelog/version history | Git log plus pass artifacts | Medium-Low | Git covers only part of workspace/project |

If no stronger source exists, this package should be treated as the current review-level synthesis rather than a permanent source of truth.
