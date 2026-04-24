# 04 BLOCKERS AND RISKS

- Active blockers:
  - no working authenticated deployment path is available from this machine for the prepared maintenance-file bundle
  - the available local SSH key is not accepted for the tested likely hosting usernames
  - no reusable FileZilla, WinSCP, or clearly deploy-specific stored credential entry was found locally
  - no local `php` CLI is available for syntax linting or direct execution checks
- Known risks introduced or still unresolved:
  - continued local packaging without authentication would become churn instead of progress
  - the deployment bundle from pass `0009` can go stale if the tracked maintenance source changes before deployment
  - the maintenance workflow remains unverified on production until the bundled file is deployed and the action is run once
  - earlier live/local drift on `review-home` remains outside the scope of this pass
- Was project drift observed:
  - no scope drift in this pass
  - yes, operational drift remains because connectivity exists but valid authentication does not
- Did architectural questions surface:
  - no new architecture questions surfaced
  - the remaining issue is authentication to an existing hosting surface, not plugin structure
- Did scope pressure appear:
  - no; the pass stayed inside deployment-access recovery for the accepted maintenance workflow
