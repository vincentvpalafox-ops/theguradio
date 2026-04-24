# Blockers And Risks

## Blockers

### 1. `wp-admin` access is still required for the actual preview-page proof
- This packet is ready to use, but it cannot create the preview page by itself.

### 2. The packet assumes the current shortcode implementation is the intended preview target
- That assumption is consistent with the existing code and prior audit work.
- If the owner wants a different preview mechanism, that should be decided before execution.

## Risks

### 1. In-place editing of page `7127` would still be the wrong first move
- The packet explicitly avoids that.

### 2. Publishing a preview page too publicly would create unnecessary exposure
- The packet recommends a narrow, non-front-page preview page with no nav changes.

### 3. Mixing verification with activation would create rollback risk
- The packet keeps preview creation and homepage activation as separate passes.
