# Build / Test Status

## Scope Note
- This was an audit-only pass.
- No code was changed.
- No build, lint, deploy, or WordPress write action was appropriate for this scope.

## Checks Run

| Check | Result | Notes |
| --- | --- | --- |
| `rg -n "filter_front_page_builder_content|render_homepage_shortcode|build_front_page_container|gu_scene_archive_homepage"` against `class-gu-scene-archive-section-shortcodes.php` | pass | confirmed shortcode registration, front-page filter, and generated shortcode container |
| `rg -n "review-home|can_access_review_home"` against `class-gu-scene-archive-template-controller.php` and `review-home.php` | pass | confirmed `review-home` is private/transitional and not the live `/` controller |
| `curl.exe -s https://theguradio.com/wp-json/wp/v2/pages/7127?_fields=id,slug,link,title.rendered` | pass | confirmed live front page page `7127`, slug `home`, link `/` |
| `curl.exe -s https://theguradio.com/wp-json/wp/v2/pages/7127?_fields=id,slug,link,title.rendered,content.rendered` | pass | confirmed live front page renders Elementor content with legacy playlist/stream shortcode widgets |
| `curl.exe -s https://theguradio.com/` plus text search | pass | confirmed `/` body contains `elementor-page-7127` and shortcode/widget output tied to the legacy homepage |
| `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/review-home/` | pass | returned `404`, confirming `review-home` is not the public front door |
| `curl.exe -s -o NUL -w "%{http_code}"` for `/archive/`, `/history/`, `/performances/`, `/search/` | pass | all returned `200` during the audit |
| Probe of public helper endpoints `/gu-opcache-reset.php` and `/gu-litespeed-purge.php` | pass | both returned `404`; no public helper path was available for a safe write/refresh shortcut |

## Key Evidence
- Live `/` contains:
  - `elementor-page-7127`
  - `[gu_scene_archive_youtube_playlist ... heading="Featuring"]`
  - `[gu_scene_archive_youtube_streams ... heading="Livestream Archive"]`
  - `[gu_scene_archive_youtube_playlists ... heading="Playlist Library"]`
  - hidden `Upcoming Shows` section markup
- `class-gu-scene-archive-section-shortcodes.php` contains:
  - shortcode registration at line `16`
  - `filter_front_page_builder_content()` at line `54`
  - fallback replacement to `array($this->build_front_page_container())` at line `71`
  - homepage renderer `render_homepage_shortcode()` at line `74`
  - generated shortcode widget container at line `217`

## Result
- The audit evidence is internally consistent.
- No syntax or deployment verification was required because no code changed in this pass.
