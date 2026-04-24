# Executive Project Review

## Project Identity

| Item | Value |
| --- | --- |
| Project name | The Gallatin Underground / GU Scene Archive |
| Current version or phase | WordPress archive/search rollout, post-pass `0023`, still pre-final-homepage rollout |
| Repo/branch reviewed | Local repo `main` in `v:\Visual Studio Projects\The GU RADIO` |
| Review date | 2026-04-24 |
| Primary purpose | Preserve and surface Gallatin-area scene performances, archive artifacts, and history through a WordPress archive/search system |
| Intended user | Public visitors searching scene history and performances; site operators curating and maintaining records |
| Intended operating environment | WordPress on shared hosting/cPanel with a custom plugin, Elementor front page, and MEC event coexistence |
| Current deployment status | Live production site exists and archive/history/search routes are deployed; the intended public homepage/front-door conversion is still incomplete |

## One-Paragraph Project Summary

This project is not a blank-site rebuild. It is a production rollout and stabilization effort around an already-built WordPress plugin, `gu-scene-archive`, that adds scene-specific content types, taxonomies, search, history/archive routes, operator dashboards, maintenance tooling, and homepage section shortcodes for The Gallatin Underground. The archive/search backbone is real and partly deployed on `theguradio.com`, but the product is still split between a stronger underlying plugin architecture and a weaker public presentation/governance layer: the public homepage is still not the intended archive-backed front door, the repo is not the authoritative source of live content state, and several integrations and workflows are present only partially or as scaffolds.

## Current Status Judgment

**Partial production build**

Why:

- Public routes are live and working for `/archive/`, `/performances/`, `/history/`, `/search/`, and current single-record pages.
- The plugin has substantial implemented behavior, not just planning docs.
- The intended public product shape is still incomplete because `/` is not yet the final archive-backed homepage and release/noindex gates are still documented as open.
- The local repo is not a clean authoritative checkout of the full live system. Most meaningful project files and handoff artifacts are untracked in Git, and the live WordPress database state is outside version control.

## Progress Estimate

| Area | Estimate |
| --- | --- |
| Overall completion | 63% |
| Frontend/UI completion | 60% |
| Backend/data completion | 68% |
| Core functionality completion | 70% |
| Documentation completion | 78% |
| QA/testing completion | 32% |
| Deployment readiness | 58% |

These numbers are conservative. They reflect that architecture and many live behaviors exist, but production discipline, public-front-door alignment, and repeatable QA/deployment are still weak.

## Main Finding

The most important truth about the project right now is this:

**The archive/search architecture is materially ahead of the public product experience and ahead of the repo/governance quality that should support a production deployment.**

Supporting evidence:

- Vision and rollout docs describe the public homepage as incomplete and still transitional: [01_MASTER_PLATFORM_DIRECTION.md](../GU_MASTER_PLATFORM_PACKAGE/01_MASTER_PLATFORM_DIRECTION.md), [02_CURRENT_STATE_INTERPRETATION.md](../GU_MASTER_PLATFORM_PACKAGE/02_CURRENT_STATE_INTERPRETATION.md), [13_PHASED_ROLLOUT_SEQUENCE.md](../GU_MASTER_PLATFORM_PACKAGE/13_PHASED_ROLLOUT_SEQUENCE.md)
- Live route checks show deployed archive/history/search surfaces: [logs/route_status.txt](logs/route_status.txt)
- Plugin code implements real content models, route controllers, search, maintenance, and admin workflows: [gu-scene-archive.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/gu-scene-archive.php), [class-gu-scene-archive-plugin.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-plugin.php)
- Git only tracks a small subset of the workspace, so the repo is not the full project source of truth: [logs/git_status_before_package.txt](logs/git_status_before_package.txt)
