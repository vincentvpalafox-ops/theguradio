# 04 BLOCKERS AND RISKS

- Active blockers:
  - no reusable authenticated deployment mechanism is available in this workspace
  - no live execution path is available yet for running `Normalize Homepage Archive Metadata`
  - no local `php` CLI is available for syntax linting or direct execution checks
- Known risks introduced or still unresolved:
  - the bundle can go stale if the tracked maintenance source changes before deployment
  - the expected live target path is still inferred from the current plugin structure and prior sibling-file deployment evidence, not newly validated against the server in this pass
  - the maintenance workflow remains unverified on production until the bundled file is deployed and the action is run once
  - earlier live/local drift on `review-home` remains outside the scope of this pass
- Was project drift observed:
  - no scope drift in this pass
  - yes, operational drift still exists because deployment access is missing while the local deployment bundle is now prepared
- Did architectural questions surface:
  - no new architecture questions surfaced
  - the remaining issue is operational deployment access, not plugin structure
- Did scope pressure appear:
  - no; the pass stayed inside deployment packaging for the already-accepted maintenance workflow
