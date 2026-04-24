# Blockers And Risks

## Current blockers

- No active blocker prevented this pass

## Remaining risks

- `/archive/` and `/history/` are still intentionally empty because the review-seed records remain contained and no real replacement archive records have been promoted yet
- Local `php` CLI is unavailable, so live smoke verification remains the main validation path for PHP changes from this workspace
- The new `history_topic` suppression is intentionally data-driven: any `history_topic` term with at least one public-visible record will resolve again without another code change
