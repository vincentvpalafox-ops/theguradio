# Blockers And Risks

## Blockers

### 1. Manual hosting reauthentication is still required
- The consolidated snapshot marks:
  - `manual_reauth_required = true`

### 2. Workspace-only access paths are exhausted
- The consolidated snapshot marks:
  - `workspace_only_paths_exhausted = true`
- That result is based on current evidence, not assumption:
  - `ssh_available = false`
  - `chrome_debug_port_available = false`
  - `credential_store_has_hosting_path = false`
  - `cpanel_authenticated_surface_recovered = false`

## Risks

### 1. Additional local discovery passes are now mostly churn
- The highest-yield browser, shell, credential-store, and token-recovery paths have already been exercised.

### 2. The preview proof is still pending
- The archive-backed homepage has still not been proven live on the dedicated preview URL.

### 3. Activation work should still not begin
- `/` should remain unchanged until the preview proof succeeds.
