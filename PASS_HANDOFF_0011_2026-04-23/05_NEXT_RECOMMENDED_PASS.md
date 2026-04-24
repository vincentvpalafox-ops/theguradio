# 05 NEXT RECOMMENDED PASS

## Next Recommended Pass (Targeted)

- Authenticate to one of the confirmed hosting surfaces, run the deployment script from this pass with `-Execute`, then run `Normalize Homepage Archive Metadata` once and verify the admin review output plus the visible archive/history cards

Why:
- the deployment bundle already exists
- the deploy-and-verify command path is now scripted
- the only remaining blocker is valid authentication, not missing files or missing commands

Scope:
- use a valid SSH account and authorized key for one of the confirmed reachable hosts
- run `PASS_HANDOFF_0011_2026-04-23/deploy_tools/Invoke-MaintenanceDeploy.ps1 -Execute`
- deploy only the bundled maintenance file from pass `0009`
- run the existing maintenance action once
- inspect the admin review table
- re-audit only the homepage-visible archive/history records affected by that action

Do not:
- redesign homepage sections
- rewrite copy
- widen into performance-card cleanup
- invent `history_topic` values
- create more local packaging unless the source file changes

Likely files affected:
- live plugin deployment only
- production taxonomy assignments for homepage-supporting `archive_item` records
- next handoff package only

Acceptance criteria:
- a working authenticated deployment path is established
- the script uploads and verifies the maintenance file successfully
- the normalization action runs successfully once
- the admin review output renders
- visible archive/history cards can be re-audited with real live results

## Codex Behavior Check

Was Codex used in this pass:
- Yes

Expected behavior for next pass:
- Authenticate, execute the script, and verify only
- No creative generation
- No redesign
- No multi-task prompt chaining
