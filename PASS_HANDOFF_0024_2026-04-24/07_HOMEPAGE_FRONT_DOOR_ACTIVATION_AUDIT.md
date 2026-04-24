# Homepage Front-Door Activation Audit

## 1. What Currently Controls `/`
- `/` is currently controlled by a live WordPress page, not by the archive plugin route controller.
- Public REST confirms page `7127`, slug `home`, link `https://theguradio.com/`.
- Live homepage HTML confirms the body class `elementor-page-7127`.
- The rendered content is Elementor-based and currently contains legacy shortcode widgets:
  - `[gu_scene_archive_youtube_playlist ... heading="Featuring"]`
  - `[gu_scene_archive_youtube_streams ... heading="Livestream Archive"]`
  - `[gu_scene_archive_youtube_playlists ... heading="Playlist Library"]`
- The current live page also still contains an `Upcoming Shows` Elementor block in the rendered markup.

### Evidence
- `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-template-controller.php:24`
- `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-template-controller.php:37`
- live `GET /wp-json/wp/v2/pages/7127?_fields=id,slug,link,title.rendered`
- live `GET /`

## 2. What Archive-Backed Homepage Implementation Already Exists
- The archive-backed homepage already exists as shortcode `[gu_scene_archive_homepage]`.
- It is registered in `GU_Scene_Archive_Section_Shortcodes`.
- `render_homepage_shortcode()` already assembles the archive-first front door.
- `build_front_page_container()` can generate an Elementor-compatible shortcode widget container wrapping `[gu_scene_archive_homepage]`.

### Structural Sections Present In Code
- opening hero
- present condition
- featured memory
- performances
- archive
- history
- community / places
- closing note

### Evidence
- `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php:16`
- `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php:74`
- `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php:151`
- `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php:195`
- `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php:217`
- `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php:430`
- `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php:483`
- `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php:564`

## 3. Exact Activation Options

### Option A. New dedicated page with `[gu_scene_archive_homepage]`, then switch `page_on_front`
- Create a new page only for the archive-backed homepage.
- Preview and verify it first.
- Switch the WordPress Reading front page only after preview passes.

### Option B. Replace the current front-page page `7127` content with `[gu_scene_archive_homepage]`
- Overwrite the existing Elementor front page in place.
- Higher blast radius because it touches the current live front-page object directly.

### Option C. Rely on `filter_front_page_builder_content()` as the activation mechanism
- The plugin already hooks `elementor/frontend/builder_content_data`.
- If the front-page content does not already contain `[gu_scene_archive_homepage]`, the filter returns a generated container from `build_front_page_container()`.
- This is a replacement path, not a preview-first path.

### Option D. Use the existing local front-door sync runner to patch the current front page
- `staged_remote_changes/tmp/gu-sync-homepage-front-door.php` is a local helper that rewrites the current front-page `post_content` and `_elementor_data` to `[gu_scene_archive_homepage]`.
- It is not the safest first activation method.
- It directly targets the live front-page object and is operationally closer to Option B than to Option A.

## 4. Safest Recommended Activation Method
- `Option A` is the safest method.

### Why
- It avoids code deployment.
- It avoids overwriting page `7127`.
- It gives a clean preview/proof step.
- Rollback is a single `page_on_front` reversal.
- It keeps the existing live homepage intact until the replacement is proven.

### Why The Automatic Filter Is Not The Safest First Move
- `filter_front_page_builder_content()` is real and locally auditable.
- But using it first would replace front-page builder content behavior without a preview page proof.
- A content-led activation path is easier to verify and easier to reverse.

## 5. Files / Options Likely Affected

### If Using The Safest Method
- WordPress option: `page_on_front`
- new WordPress page `post_content`
- new WordPress page `_elementor_data` if Elementor wrapper is used

### If Replacing Current Front Page In Place
- page `7127` `post_content`
- page `7127` `_elementor_data`
- Elementor revisions for page `7127`

### If Using Code-Level Activation
- `staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php`
- live deployed copy of the same file

## 6. Rollback Plan

### Rollback For Option A
- switch `page_on_front` back to page `7127`
- keep the new page unpublished, draft, or non-front-page

### Rollback For Option B
- restore the current front-page content from Elementor revision history or a captured duplicate/export

### Rollback For Option C
- restore the previous deployed plugin file
- clear caches

### Rollback Quality Judgment
- best rollback: Option A
- acceptable but riskier: Option B
- least desirable for first activation: Option C

## 7. Immediate Post-Activation Verification Checklist
- See `06_IMMEDIATE_POST_ACTIVATION_CHECKLIST.md`

## 8. Blockers

### Functional Blockers
- `[gu_scene_archive_homepage]` has not yet been proven on a standalone live preview page.

### Operational Blockers
- The authenticated content-edit path used in earlier live passes was not re-established during this audit pass.
- That blocks execution of the next preview-page proof pass from this workspace until access is recovered.

## 9. Final Recommendation: Activation Safe Now Yes/No
- `No`

### Exact Meaning
- It is not safe to activate `/` blindly right now.
- It is not safe to use automatic Elementor front-page interception as the first activation step.
- It becomes safe after a bounded preview-page proof using `[gu_scene_archive_homepage]`, followed by a controlled `page_on_front` switch only if that preview passes.

## Additional Notes
- `review-home.php` is not the live front door.
- `review-home` remains private/transitional in controller code and the public route currently returns `404`.
- The current public archive stack is healthy enough to support a homepage proof pass:
  - `/archive/` returned `200`
  - `/history/` returned `200`
  - `/performances/` returned `200`
  - `/search/` returned `200`
