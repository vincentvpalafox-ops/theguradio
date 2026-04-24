# Next Recommended Pass

## Recommended Pass Name
- `PASS 0025: Homepage Shortcode Preview Proof`

## Goal
- Prove the approved archive-backed homepage on a non-front-page WordPress page before any `/` activation.

## Scope
- Create one new dedicated page containing `[gu_scene_archive_homepage]`
- Keep it off the front door
- Preview and verify rendering
- Do not change `page_on_front`
- Do not modify page `7127`
- Do not activate `/`
- Do not change plugin code unless a rendering bug is proven by the preview itself

## Likely Affected Live Objects
- One new WordPress page
- Possibly `_elementor_data` on that new page if Elementor wrapper is required for consistent previewing
- No change to page `7127`
- No change to Reading settings in this pass

## Acceptance Criteria
- The preview page renders `[gu_scene_archive_homepage]` without raw shortcode output
- Hero, archive, performances, history, community, and closing sections all render
- Header and footer remain correct
- `/`, `/archive/`, `/history/`, `/performances/`, and `/search/` remain healthy
- No activation of `/` occurs

## Operational Prerequisite
- Restore or recover the authenticated WordPress/cPanel write path from this workspace before attempting the preview-page creation pass.
