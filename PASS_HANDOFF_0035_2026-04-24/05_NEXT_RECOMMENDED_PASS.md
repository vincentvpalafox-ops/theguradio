# Next Recommended Pass

## Recommended Pass Name
- `PASS 0036: Homepage Shortcode Preview Proof After Manual Hosting Reauthentication`

## Goal
- Execute the already-prepared preview proof bundle against the live site immediately after a real hosting login event.

## Scope
- Reauthenticate to the live cPanel/Fileman surface
- Run:
  - `PASS_HANDOFF_0034_2026-04-24/proof_bundle/Invoke-PreviewProofBundleIntegrity.ps1`
- If it passes:
  - follow `PASS_HANDOFF_0034_2026-04-24/proof_bundle/EXECUTE_AFTER_REAUTH.md`
- Keep `/` unchanged

## Acceptance Criteria
- integrity check returns `overall_pass = true`
- preview page returns `200`
- capture wrapper returns:
  - `runner.runner_ok = true`
  - `verifier.overall_pass = true`
  - `overall_pass = true`
- no `page_on_front` change occurs
