# Blockers And Risks

## Blockers

### 1. Standalone shortcode proof is still missing
- `[gu_scene_archive_homepage]` exists in code, but this pass did not create a live preview page and did not exercise that shortcode on a non-front-page page.
- Until that proof exists, switching `/` directly remains avoidable risk.

### 2. Automatic builder interception is higher risk than a content-led swap
- `filter_front_page_builder_content()` inspects the current front page and, when the shortcode is not present, returns a replacement container built by `build_front_page_container()`.
- That is a full builder-content substitution path, not a preview-first path.
- Using it as the first activation mechanism would make rollback more dependent on code deployment and file-state confidence than on a simple WordPress Reading-setting reversal.

### 3. Current `/` is still a live Elementor production page
- `/` is backed by page `7127`.
- That page renders legacy playlist/stream sections and hidden review-era scaffolding.
- Replacing it in place is possible, but it has a larger blast radius than activating a new dedicated preview page.

### 4. The authenticated live content-edit path was not recovered in this pass
- Earlier passes proved live content and file changes were possible from this workspace.
- During this audit pass, no reusable authenticated WordPress or cPanel write path was recovered.
- That blocks the immediate execution of the next preview-page proof pass from this workspace.

## Risks

### 1. Blind activation could swap the homepage without a proven fallback preview
- This is the main product risk.

### 2. Replacing page `7127` directly would mix activation work with rollback-sensitive existing Elementor content
- Safer to keep `7127` intact until the archive-backed page is visually and structurally proven.

### 3. Code-level activation alone is harder to reason about than content-led activation
- The filter path, shortcode path, assets, and Elementor builder behavior may all be correct in code and still produce an unexpected live result if the page state differs.

### 4. Rollback quality depends on activation method
- `page_on_front` switch rollback is trivial.
- In-place Elementor/front-page content overwrite rollback is slower and more error-prone.
- Code deployment rollback is the most fragile of the three.
