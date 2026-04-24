# Gap Analysis

| Area | Intended State | Current State | Gap | Priority |
| --- | --- | --- | --- | --- |
| Product scope | Public site clearly presents archive/search/history as the product | Public archive routes work, but `/` still does not represent that product clearly | Front door does not match core system | Critical |
| User workflows | Visitors land on homepage and move naturally into archive surfaces | Strong archive routes exist, but current entry point is misaligned | Users do not start in the strongest flow | Critical |
| UI | Consistent public-facing archive-first experience | Archive routes are stronger than homepage experience | UI cohesion is incomplete | High |
| Data | Stable, trustworthy, documented archive records | Live data is real but not versioned/exported and still content-thin | Data governance is weak | High |
| Logic | Search, filters, routes, and homepage all reflect same model | Archive year filter was fixed, but search still uses older filter conventions | Functional inconsistency remains | High |
| Reporting / admin stewardship | Operator workflows fully documented and reliable | Strong admin code exists, but process docs are incomplete | Operational dependency on tacit knowledge | Medium |
| Integrations | External providers and events behave intentionally | YouTube leads, SoundCloud/Spotify stubbed, MEC secondary | Integration surface is uneven | Medium |
| Mobile usability | Proven responsive behavior | Not fully evidenced in review | Validation gap | Medium |
| Documentation | Clean, current, reviewer-friendly documentation | Strong volume, weak consolidation, stale/inadequate entry docs | Review cost remains high | High |
| Testing | Repeatable automated or semi-automated validation | Manual-only, no local PHP lint | QA maturity is low | High |
| Deployment | Clear version-controlled deploy path | Manual operational process, partial repo | Release risk remains elevated | High |
| Governance / versioning | Repo is the clear source of truth for code/process | Repo is a wrapper around a partially tracked workspace | Governance is incomplete | Critical |
