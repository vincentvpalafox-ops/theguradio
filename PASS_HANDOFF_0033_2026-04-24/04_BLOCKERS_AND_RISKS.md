# Blockers And Risks

## Blockers

### 1. Manual hosting reauthentication is still required
- The bundle is ready, but the live upload surface is still blocked until a fresh authenticated session exists.

## Risks

### 1. The operator could still ignore the wrapper and capture inconsistent proof
- The runbook now directs the operator to use the wrapper, not just the raw verifier.

### 2. `/` must still remain untouched
- This bundle is only for the preview proof.
- It must not be used to activate the front page.
