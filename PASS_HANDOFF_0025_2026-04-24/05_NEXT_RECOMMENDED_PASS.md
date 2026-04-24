# Next Recommended Pass

## Recommended Pass Name
- `PASS 0026: Homepage Shortcode Preview Proof`

## Goal
- Execute the already-defined preview-page proof using a legitimate live admin session.

## Scope
- Log into `https://theguradio.com/wp-admin/`
- Create one new non-front-page page containing `[gu_scene_archive_homepage]`
- Keep `/` unchanged
- Verify the preview page render
- Verify `/archive/`, `/history/`, `/performances/`, and `/search/` remain healthy

## Acceptance Criteria
- The preview page exists
- It renders `[gu_scene_archive_homepage]` without raw shortcode output
- Header/footer render correctly
- Core archive routes remain healthy
- No switch of `page_on_front` occurs in that pass

## Do Not Cross
- Do not activate `/`
- Do not overwrite page `7127`
- Do not redesign homepage sections
- Do not change provider/search systems

## Required Prerequisite
- Restore a legitimate authenticated WordPress admin login path in this workspace or provide another approved live content-edit channel.
