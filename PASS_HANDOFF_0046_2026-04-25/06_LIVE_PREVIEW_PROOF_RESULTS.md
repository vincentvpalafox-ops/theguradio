# Live Preview Proof Results

## What Was Actually Proven

- The preview page can exist live without changing the front page.
- The approved archive-backed homepage implementation now renders correctly on the live site.
- The stale live shortcode implementation was replaced with the approved local implementation.
- The raw shortcode leakage in the preview page source was reduced to the page head only, then removed by setting a real excerpt.
- The final preview proof returned a clean pass.

## Important Intermediate Findings

1. The first live failure was not a missing preview page. The preview page was created correctly on the first successful create-runner execution.
2. The next failure was stale live plugin bootstrap code. `class-gu-scene-archive-plugin.php` on live was older than local and was not instantiating the shortcode classes.
3. After the bootstrap fix, shortcode rendering existed, but the live `class-gu-scene-archive-section-shortcodes.php` file was still older than the approved local version.
4. After the shortcode file deploy, the preview body matched the approved homepage implementation.
5. The last remaining failure was raw shortcode leakage in meta tags, which was fixed by setting the preview page excerpt.

## Evidence Pointers

- preview create result: `evidence_create_runner_response.json`
- bootstrap deploy response: `evidence_plugin_save_response.json`
- shortcode deploy response: `evidence_section_shortcodes_save_response.json`
- runtime shortcode diagnostics: `evidence_shortcode_diagnostic.json`
- excerpt update result: `evidence_preview_excerpt_response.json`
- final proof capture: `evidence_preview_proof_capture.json`
- final proof verification: `evidence_preview_verification.json`
