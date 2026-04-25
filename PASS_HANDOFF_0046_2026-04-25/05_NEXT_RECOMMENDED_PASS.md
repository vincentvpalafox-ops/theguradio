# Next Recommended Pass

The next bounded pass should be the homepage front-door activation decision pass.

Recommended scope:

1. Review the live preview at `/archive-homepage-preview/`.
2. If accepted, switch `page_on_front` from `7127` to `23758`.
3. Verify `/`, `/archive/`, `/history/`, `/performances/`, and `/search/`.
4. Keep rollback simple: switch `page_on_front` back to `7127` if anything fails.

Do not widen that pass into redesign, provider work, or search changes.
