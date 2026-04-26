# Tests And Checks Run

## Activation Execution

- one-time activation runner executed successfully
- `page_on_front_before = 7127`
- `page_on_front_after = 23758`
- `show_on_front_before = page`
- `show_on_front_after = page`
- evidence: `evidence_activation_response.json`

## Public Root Content Check

- raw homepage shortcode visible: `false`
- opening frame present: `true`
- Gallatin Scene Record present: `true`
- Present Condition present: `true`
- Community present: `true`
- Private Review visible: `false`
- review-home text visible: `false`
- seed/demo text visible: `false`
- meta raw shortcode visible: `false`
- Open Graph raw shortcode visible: `false`
- Twitter raw shortcode visible: `false`
- evidence: `evidence_root_content_checks.json`

## Route Verification

- `/` -> `200`
- `/archive/` -> `200`
- `/performances/` -> `200`
- `/history/` -> `200`
- `/search/` -> `200`
- representative archive single -> `200`
- representative performance single -> `200`
- `/review-home/` -> `404`
- `/archive-homepage-preview/` -> `301` to `/`
- evidence: `evidence_route_verification.json`

## Result

All required activation checks passed.
