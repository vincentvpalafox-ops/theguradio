# Next Best Step Recommendation

## Recommended Next Move

**Activate the archive-backed homepage on the public `/` route using the existing `gu_scene_archive_homepage` implementation, then verify that the public front door matches the live archive/history/performance system already in place.**

## Why This Comes Next

- It addresses the largest user-facing gap in the entire project
- The archive/history/search backbone is already stronger than the current public entry point
- More content, provider work, or automation will have reduced product value if users still land on the wrong experience
- The code for the intended homepage already exists, which makes this a bounded activation/alignment pass rather than a speculative redesign

## What Not To Do Yet

- Do not expand SoundCloud or Spotify integration
- Do not start a full design overhaul
- Do not attempt a repo-wide cleanup/refactor of all handoff artifacts
- Do not launch a broad testing initiative before the public front door is correct
- Do not index/release as production-final yet

## Exact Next Work Package

**Package Name:** Homepage Front Door Activation

**Goal:** Make the public homepage reflect the actual archive product already implemented in the plugin.

**Scope:**

- Confirm how the current front page is wired in WordPress/Elementor
- Activate the archive-backed homepage implementation on `/`
- Ensure the public homepage links cleanly into `/performances/`, `/archive/`, and `/history/`
- Ensure no private-review labels or transitional review-home copy appear on the public homepage
- Verify that homepage sections render sanely against the current live dataset

**Files likely affected:**

- [class-gu-scene-archive-section-shortcodes.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php)
- Potentially homepage-related CSS in `assets/css/sections.css`
- Potentially WordPress front-page/Elementor content outside repo-tracked files
- Deployment/handoff documentation for the pass

**Acceptance criteria:**

- `/` returns `200` and displays the archive-backed homepage
- The public homepage includes working links to `/performances/`, `/archive/`, and `/history/`
- No private review labels, parked review-only sections, or placeholder review-home copy are publicly visible
- `/archive/`, `/performances/`, `/history/`, `/search/`, and representative single-record pages remain healthy after the change
- Existing review-only route protections remain intact

**Do-not-cross boundaries:**

- No provider expansion
- No search redesign beyond what is strictly necessary for homepage activation
- No unrelated theme rebuild
- No large-scale content migration

**Expected deliverables:**

- Deployed homepage/front-door change
- Verification report with public route checks
- Updated handoff/review notes

## Acceptance Criteria

Pass:

- Public homepage now represents the archive product, not the old transitional front page
- Core archive routes remain healthy
- The homepage is curated, coherent, and free of review-only language

Fail:

- `/` still resolves to the old homepage
- Public homepage contains review-only or placeholder content
- Archive/history/performance routes regress
