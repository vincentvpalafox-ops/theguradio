# Blockers And Risks

## Blockers

### 1. Authenticated live upload is still unavailable from this workspace
- The previous live-mutation passes depended on cPanel/Fileman access.
- That authenticated path was not recoverable in this pass.

### 2. Direct shell access is still not available
- `ssh` to `thegalla@theguradio.com` still returns `Permission denied`.

## Risks

### 1. The preview page will be public while the proof is running
- That is acceptable for this bounded pass, but it should remain a dedicated preview slug and should not replace `/`.

### 2. The runner depends on `wp-load.php` resolving from public root
- The runbook keeps the upload target in `/home/thegalla/public_html/` so that assumption stays valid.

### 3. If a broken preview page already existed later, rerunning the create runner will update it
- That is intentional and keeps the slug deterministic, but the operator should still capture the JSON result and the follow-up verifier output.
