# Operator Preview Page Runbook

## Purpose
- Create a safe non-front-page proof page for `[gu_scene_archive_homepage]` without touching `/`.

## Preconditions
- You have working access to `https://theguradio.com/wp-admin/`
- Do not change `page_on_front`
- Do not edit page `7127`
- Do not use `review-home`

## Preferred Creation Method
- Use a normal WordPress page.
- If Elementor is used, use a single shortcode widget only.
- If the block editor is used, put only the shortcode in the page body.

## Exact Page Setup
- Title: `Archive Homepage Preview`
- Slug: `archive-homepage-preview`
- Parent: `none`
- Menu inclusion: `no`
- Front-page setting: `unchanged`
- Content: `[gu_scene_archive_homepage]`

## Safer Visibility Order
1. Create the page in draft first.
2. Preview while logged in.
3. If draft preview is not sufficient for verification, publish the page at the preview slug without adding it to navigation and without changing Reading settings.

## If Using Elementor
- Page template: match the existing Elementor header/footer pattern if available.
- Content body: one shortcode widget only.
- Shortcode: `[gu_scene_archive_homepage]`
- Do not paste legacy playlist or livestream shortcode blocks.

## Immediate Verification
- Visit the preview page.
- Confirm:
  - hero renders
  - archive section renders
  - performances section renders
  - history section renders
  - community/places section renders
  - closing links render
  - no raw shortcode text is visible
  - no `Private Review` copy appears
  - header/footer are intact

## Route Regression Check
- `/` still returns `200`
- `/archive/` still returns `200`
- `/history/` still returns `200`
- `/performances/` still returns `200`
- `/search/` still returns `200`

## What Not To Do
- Do not switch `page_on_front`
- Do not overwrite `Home` page `7127`
- Do not deploy plugin code first
- Do not use the automatic front-page interception path as the first activation step
- Do not redesign section content during this proof pass

## Rollback / Cleanup
- If the preview page is bad:
  - keep `/` unchanged
  - delete or draft the preview page
- If the preview page is good:
  - leave it intact for a later activation decision
  - document the proof result in the next pass before changing the front door
