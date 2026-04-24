# 04 BLOCKERS AND RISKS

- Active blockers:
  - no working authenticated deployment path is currently available from this machine
  - the script depends on `scp` and `ssh` access to the hosting surface
  - no local `php` CLI is available for syntax linting or direct execution checks
- Known risks introduced or still unresolved:
  - the script assumes the remote shell supports `cp`, `mv`, and either `sha256sum` or `shasum`
  - the deployment bundle from pass `0009` can go stale if the tracked maintenance source changes before deployment
  - the maintenance workflow remains unverified on production until the script is run with valid authentication and the admin action is executed once
  - earlier live/local drift on `review-home` remains outside the scope of this pass
- Was project drift observed:
  - no scope drift in this pass
  - no new operational drift beyond the already-known authentication blocker
- Did architectural questions surface:
  - no new architecture questions surfaced
  - the remaining issue is authentication to an already-confirmed hosting surface
- Did scope pressure appear:
  - no; the pass stayed inside deploy-and-verify execution prep for the accepted maintenance workflow
