# Next Recommended Pass

## Recommended Pass Name
- `PASS 0027: Homepage Shortcode Preview Proof`

## Goal
- Execute the already-defined preview-page proof in WordPress using the operator packet from this pass.

## Scope
- Log into `https://theguradio.com/wp-admin/`
- Create one new non-front-page page
- Use only `[gu_scene_archive_homepage]`
- Verify its render
- Leave `/` unchanged
- Do not modify page `7127`

## Acceptance Criteria
- Preview page exists at the chosen slug
- The page renders archive-backed homepage content
- No raw shortcode output appears
- Header/footer render correctly
- `/`, `/archive/`, `/history/`, `/performances/`, and `/search/` remain healthy
- No `page_on_front` switch occurs

## Do Not Cross
- Do not activate `/`
- Do not overwrite page `7127`
- Do not deploy code as part of the preview-page proof unless the preview exposes a real rendering bug
