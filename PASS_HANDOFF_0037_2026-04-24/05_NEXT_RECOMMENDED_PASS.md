# Next Recommended Pass

Package name:

- `Homepage Preview Proof After Reauth`

Goal:

- execute the prepared preview proof flow once authenticated hosting access is restored

Scope:

- no code changes
- no homepage activation
- no content redesign
- create the non-front-page preview only
- verify and capture proof outputs

Inputs to use:

- `PASS_HANDOFF_0034_2026-04-24/proof_bundle`
- `PASS_HANDOFF_0034_2026-04-24/proof_bundle/EXECUTE_AFTER_REAUTH.md`

Acceptance criteria:

- authenticated hosting access restored
- proof bundle integrity passes
- preview creation runner succeeds
- preview verifier succeeds against the created preview URL
- proof capture artifacts are produced
- `/` remains unchanged

Do not do yet:

- do not switch `page_on_front`
- do not edit page `7127`
- do not deploy new product code
