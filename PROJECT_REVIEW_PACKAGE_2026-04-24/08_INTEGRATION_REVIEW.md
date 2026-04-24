# Integration Review

## Integration Inventory

| Integration | Purpose | Current Status | Auth Needed | Data Direction | Issues |
| --- | --- | --- | --- | --- | --- |
| WordPress core | Host CPTs, taxonomies, templates, admin screens | Functional | Native WP auth for admin | Two-way | Primary platform, but live DB state is not versioned in repo |
| Elementor | Front-page/page-builder integration | Partial | Admin | Mostly WordPress page content into public site | Current public homepage still sits outside final archive-front-door goal |
| MEC / `mec-events` | Event cards for homepage/events sections | Partial | Admin | Read from WP event posts into homepage sections | Secondary dependency; not core archive product |
| YouTube provider | External search, playlists, streams | Functional with issues | API key for best behavior | Read into search/playlist sections | Auth-sensitive; fallback behavior depends on public pages |
| SoundCloud provider | Planned external search | Stubbed | Would require auth | Read | Not implemented |
| Spotify provider | Planned external search | Stubbed | Would require auth | Read | Not implemented |
| WordPress REST API | Public record visibility and verification | Functional | Public for exposed endpoints | Read | Limited slice of truth; not a full dataset contract |
| Shared hosting / cPanel / SSH | Production deployment path | Functional with issues | Yes | Code push to live site | Manual and under-documented |
| GitHub | Version control sync | Functional with issues | Git auth | Code sync | Repo only tracks a small subset of workspace/project |
| WP cron | Weekly link validation schedule | Functional | No additional auth | Internal scheduled maintenance | No external observability in repo |

## Integration Gaps

- No complete SoundCloud integration
- No complete Spotify integration
- No CI/CD deployment pipeline
- No authoritative export/sync integration for live WordPress content into version control
- No formal analytics or telemetry integration surfaced in the reviewed repo

## Integration Risks

- Provider-auth gaps can make search appear partially broken
- Manual deployment increases the risk of drift between local snapshot and live server
- Elementor/front-page state can diverge from plugin-defined homepage logic
- MEC event dependence can make the events section inconsistent across environments
- GitHub does not currently reflect the full project workspace, which weakens reviewability and rollback confidence

## Evidence

- Plugin README: [staged_remote_changes/wp-content/plugins/gu-scene-archive/README.md](../staged_remote_changes/wp-content/plugins/gu-scene-archive/README.md)
- Provider classes: [includes/providers](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/providers)
- Section shortcodes: [class-gu-scene-archive-section-shortcodes.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php)
