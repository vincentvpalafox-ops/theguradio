# Next Recommended Pass

Package name:

- `Homepage Preview Proof After Reauth`

Goal:

- execute the already-prepared preview proof flow after authenticated hosting access is restored

Scope:

- no code changes
- no homepage activation
- create the non-front-page preview only
- run verifier and proof capture

Inputs to use:

- `PASS_HANDOFF_0034_2026-04-24/proof_bundle`
- `PASS_HANDOFF_0034_2026-04-24/proof_bundle/EXECUTE_AFTER_REAUTH.md`

Acceptance criteria:

- authenticated hosting access restored
- proof bundle integrity passes
- preview creation runner executes successfully
- preview verifier completes against the created preview URL
- proof capture artifacts are produced
- `/` remains unchanged
