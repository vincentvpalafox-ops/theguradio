# Blockers And Risks

## Blockers

### 1. Authenticated live upload is still unavailable from this workspace
- The preview-page runner from pass `0028` depends on the earlier cPanel/Fileman live-mutation path.
- That authenticated path was not recoverable here.

### 2. Direct shell access is still unavailable
- `ssh` to `thegalla@theguradio.com` still returns `Permission denied`.

### 3. Browser-session evidence exists, but not a callable browser automation path
- Recent Chrome session files show real `wp-admin` work on page `7127` and archive admin routes.
- No remote-debugging port is exposed on the running Chrome session.
- That means the browser evidence is useful for diagnosis, but not enough to execute the preview proof automatically.

## Risks

### 1. Repeating access probes without a real re-authentication event is now low-yield
- Further discovery from this workspace is likely to repeat the same negative result.

### 2. The preview proof remains pending
- The archive-backed homepage still has not been proven live on a non-front-page preview URL.

### 3. Activation work should not start before preview proof succeeds
- `page_on_front` should remain untouched until pass `0028` can actually run.
