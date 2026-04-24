# Build / Test Status

## Scope Note
- This was a verification-tooling pass, not a live write pass.
- No product code changed, so no build/lint/deploy cycle was appropriate.

## Checks Run

| Check | Result | Notes |
| --- | --- | --- |
| `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/` | pass | returned `200` |
| `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/archive/` | pass | returned `200` |
| `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/history/` | pass | returned `200` |
| `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/performances/` | pass | returned `200` |
| `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/search/` | pass | returned `200` |
| `rg -n "gu_scene_archive_homepage|filter_front_page_builder_content|build_front_page_container|review-home"` against audited shortcode/controller files | pass | reconfirmed the preview target and the current front-door architecture |
| `powershell -ExecutionPolicy Bypass -File .\\PASS_HANDOFF_0027_2026-04-24\\tools\\Invoke-HomepagePreviewVerification.ps1 -PreviewUrl https://theguradio.com/archive-homepage-preview/ -OutFile .\\PASS_HANDOFF_0027_2026-04-24\\preview_verification_probe.json` | pass | script executed successfully, returned preview `404`, kept core routes at `200`, and wrote the JSON probe artifact |
| `git diff --check -- PASS_HANDOFF_0027_2026-04-24` | pass | no whitespace issues |
| `git diff --cached --check` | pass | no staged whitespace issues |

## Result
- Verification harness works.
- Current baseline confirms no preview page exists yet at the recommended slug.
- The evidence artifact for that baseline is `PASS_HANDOFF_0027_2026-04-24/preview_verification_probe.json`.
