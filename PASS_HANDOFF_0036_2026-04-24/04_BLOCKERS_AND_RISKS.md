# Blockers And Risks

## Primary Blocker

Manual hosting reauthentication is still required.

The blocker is not theoretical:

- the live homepage remains healthy, so there is no site outage to repair
- the preview slug still returns `404`, so the proof has not been executed
- the proof bundle still passes integrity, so the remaining failure point is not local file readiness
- prior passes exhausted workspace-only recovery paths for WordPress admin, SSH, and cPanel session reuse

## Risk If Ignored

Continuing with more workspace-only passes would create documentation churn without moving the activation proof forward.

## Operational Risk

Once reauthentication is available, the operator must still follow the proof flow exactly:

1. run the integrity gate
2. execute the preview proof bundle
3. verify the preview output
4. leave `page_on_front` unchanged
