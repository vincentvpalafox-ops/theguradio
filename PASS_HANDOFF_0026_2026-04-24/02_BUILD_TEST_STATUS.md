# Build / Test Status

## Scope Note
- This was an operator-packet pass, not a live write pass.
- No code changes were made, so no build/lint/deploy cycle was appropriate.

## Checks Run

| Check | Result | Notes |
| --- | --- | --- |
| `git branch --show-current` and `git rev-parse --short HEAD` | pass | confirmed `main` at `84fa7a7` at pass start |
| `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/` | pass | returned `200` |
| `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/archive/` | pass | returned `200` |
| `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/history/` | pass | returned `200` |
| `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/performances/` | pass | returned `200` |
| `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/search/` | pass | returned `200` |
| `rg -n "gu_scene_archive_homepage|filter_front_page_builder_content|build_front_page_container|page_on_front"` against shortcode/controller files | pass | reconfirmed the existing front-door implementation and interception logic |
| `rg -n "review-home"` against controller/template files | pass | reconfirmed `review-home` remains transitional/private and is not the live front door |

## Result
- The site remains stable.
- The documentation packet is aligned with the current code and live route state.
