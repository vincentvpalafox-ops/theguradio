# Next Recommended Pass

Package name:

- `Homepage Preview Proof After Reauth`

Goal:

- execute the already-prepared preview proof bundle after a legitimate hosting session is restored

Scope:

- no code changes
- no homepage activation
- create the non-front-page preview
- run the verifier and proof capture
- clean up only if the proof fails

Inputs to use:

- `PASS_HANDOFF_0034_2026-04-24/proof_bundle`
- `PASS_HANDOFF_0034_2026-04-24/proof_bundle/EXECUTE_AFTER_REAUTH.md`

Acceptance criteria:

- authenticated hosting access restored
- bundle integrity passes
- preview creation runner executes successfully
- preview verifier runs against the created preview URL
- proof capture artifacts are produced
- `/` remains unchanged

Do not do yet:

- do not switch `page_on_front`
- do not replace page `7127`
- do not deploy new product code
