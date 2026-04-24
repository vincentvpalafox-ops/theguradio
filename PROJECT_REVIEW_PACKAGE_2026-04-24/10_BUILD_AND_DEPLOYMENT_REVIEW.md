# Build / Deployment Review

## Environment

| Item | Value |
| --- | --- |
| Framework | WordPress plugin/theme-driven site |
| Language | PHP, WordPress template PHP, CSS, small JS |
| Package manager | None evident for the project itself |
| Major dependencies | WordPress, Elementor, MEC, optional YouTube API/provider behavior |
| Build tool | None evident |
| Hosting target | Shared hosting / cPanel-backed live WordPress site at `theguradio.com` |
| Deployment method | Manual deployment/sync, proven by recent live passes and route verification |
| Required environment variables / secrets | WordPress secrets in `wp-config.php`, plugin provider credentials/settings in live WP options |

## Build Commands

Known commands from repo evidence:

| Command Type | Known Command |
| --- | --- |
| install | Not defined |
| dev | Not defined |
| build | Not defined |
| test | Not defined |
| lint | No project lint command; local `git diff --check` only |
| preview | Not defined |
| deploy | Manual operational workflow only; no canonical repo command |

## Current Build Status

**No standard local build exists in the reviewed repo.**

Evidence:

- No `package.json`, `composer.json`, `phpunit.xml`, or JS test/build configs were found in the reviewed workspace
- `php` CLI is unavailable locally: [logs/tool_availability.txt](logs/tool_availability.txt)
- Public route behavior was verified live instead of through a local build pipeline

## Deployment Status

**Deployed manually**

Current state:

- Live site is up
- Archive/history/search routes are deployed
- Public homepage/front-door conversion is not complete
- Deployment workflow exists operationally, but it is not normalized as a reproducible repo-driven process

## Deployment Risks

- Missing canonical deployment guide
- Secrets/config live in WordPress and `wp-config.php`, not in safe documented config examples
- Manual deployment can drift from the local snapshot
- Repo does not fully track the project workspace or live content state
- No CI/CD or automated post-deploy verification pipeline

## Evidence

- Tool availability: [logs/tool_availability.txt](logs/tool_availability.txt)
- Recent Git history: [logs/git_log_recent.txt](logs/git_log_recent.txt)
- Live route verification: [logs/route_status.txt](logs/route_status.txt)
