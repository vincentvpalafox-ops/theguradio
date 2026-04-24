# Blockers And Risks

## Blockers

### 1. The next live pass requires authenticated WordPress admin access
- The intended pass was to create a non-front-page preview page containing `[gu_scene_archive_homepage]`.
- That requires a legitimate content-edit path.
- No reusable authenticated WordPress or cPanel write path was recovered in this pass.

### 2. Local browser evidence is present but not directly reusable
- `Profile 1` contains recent `wp-admin` history on `theguradio.com`.
- `Profile 1` also contains unexpired WordPress auth cookies and saved logins.
- But those secrets are protected using Chrome `v20` app-bound encryption.

### 3. Copied-profile validation did not preserve the authenticated session
- A copied Chrome profile with the original `Local State` launched successfully.
- The browser reached `theguradio.com`, but `/wp-admin/` still redirected to the login screen.
- That means the copied-profile path is not enough to execute the preview pass.

## Risks

### 1. Forcing further access recovery would exceed the accepted scope
- The remaining technical paths involve invasive browser secret extraction or browser-process-specific bypass work.
- That is not the same as executing a bounded WordPress content pass.

### 2. Using unsupported access work would create operational and review risk
- It would muddy the pass boundary.
- It would make the handoff less defensible than simply documenting the real blocker.

### 3. The homepage front-door work is now procedurally blocked, not architecturally blocked
- The archive-backed homepage implementation still exists and remains the correct target.
- The blocker is access to perform the preview-page proof, not missing product architecture.
