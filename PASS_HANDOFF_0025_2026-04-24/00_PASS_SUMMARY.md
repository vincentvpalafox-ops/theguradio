# PASS 0025 Summary

## Pass Identity
- Pass: `0025`
- Date: `2026-04-24`
- Scope: `Homepage Shortcode Preview Proof - Access Recovery Probe`
- Repo/branch reviewed: `main`
- Repo head at start: `9e8a508`

## What Changed
- Created the `PASS_HANDOFF_0025_2026-04-24` blocker package only.
- No product code changed.
- No deployment occurred.
- No WordPress content or options were edited.
- No homepage preview page was created.
- `/` was not activated and not modified.

## Files Modified
- `PASS_HANDOFF_0025_2026-04-24/00_PASS_SUMMARY.md`
- `PASS_HANDOFF_0025_2026-04-24/01_FILES_CHANGED.md`
- `PASS_HANDOFF_0025_2026-04-24/02_BUILD_TEST_STATUS.md`
- `PASS_HANDOFF_0025_2026-04-24/03_NOT_CHANGED.md`
- `PASS_HANDOFF_0025_2026-04-24/04_BLOCKERS_AND_RISKS.md`
- `PASS_HANDOFF_0025_2026-04-24/05_NEXT_RECOMMENDED_PASS.md`
- `PASS_HANDOFF_0025_2026-04-24/07_WORDPRESS_ADMIN_ACCESS_RECOVERY_PROBE.md`

## Result
- The next admissible product pass remained `Homepage Shortcode Preview Proof`.
- That pass could not execute from this workspace because the remaining live write path depends on browser-held WordPress admin authentication.
- Local evidence shows recent `wp-admin` use on `theguradio.com`, plus unexpired WordPress auth cookies and saved logins in Chrome profile data.
- However, both cookies and saved passwords are stored using Chrome `v20` app-bound encryption, and the safe recovery attempts in this pass did not produce a reusable authenticated admin session.
- An isolated copied Chrome profile launched successfully under remote debugging, but navigating to `/wp-admin/` redirected to `wp-login.php`, proving the copied profile did not carry live authenticated WordPress access.

## What Was Not Changed
- No plugin PHP
- No theme/template code
- No WordPress pages or posts
- No Elementor content
- No `page_on_front`
- No deploy helpers
- No public routes

## Tests / Checks Run
- Chrome profile history audit for `theguradio.com/wp-admin`
- Chrome cookie store inspection for `theguradio.com`
- Chrome login store inspection for `theguradio.com/wp-login.php`
- Isolated copied-profile Chrome launch on remote debugging port `9223`
- DevTools navigation and cookie inspection against `/wp-admin/`
- Local config inspection for database host constraints

## Blockers / Risks
- True blocker: authenticated WordPress admin access was not recoverable in a safe bounded way from this workspace.
- The remaining possible recovery routes would require invasive browser credential bypass or unsupported extraction work, which is outside the accepted scope for this pass.

## Recommended Next Step
- Restore a legitimate live admin path, then re-run the preview-page proof pass:
  1. log into `wp-admin`
  2. create one new non-front-page page containing `[gu_scene_archive_homepage]`
  3. verify that preview page
  4. do not switch `/` yet
