# Preview Page Blueprint

## Target
- One non-front-page proof page for the approved archive-backed homepage implementation.

## Approved Content
```text
[gu_scene_archive_homepage]
```

## Recommended Identity
- Title: `Archive Homepage Preview`
- Slug: `archive-homepage-preview`

## Why This Blueprint
- It exercises the exact shortcode already registered in:
  - `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php:16`
- It uses the same archive-backed renderer audited earlier:
  - `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php:74`
- It avoids the higher-risk automatic front-page interception path:
  - `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php:54`
- It avoids touching the current live front-page page `7127`.

## Expected Render Characteristics
- Opening hero
- Present Condition block
- Featured Memory block
- Performances block
- Archive block
- History block
- Community / Places block
- Closing Note block

## Failure Conditions
- Raw shortcode text appears
- Page is blank or partially unstyled
- Header/footer are missing
- Review-home/private-review copy appears
- Archive/history/performance sections fail to render

## Success Criteria
- The page looks like the archive-backed homepage implementation
- It is clearly distinct from the current legacy playlist/livestream homepage
- It proves the shortcode can be rendered safely before any `/` activation decision
