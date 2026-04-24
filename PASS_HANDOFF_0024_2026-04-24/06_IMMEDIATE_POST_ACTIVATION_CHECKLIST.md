# Immediate Post-Activation Verification Checklist

Use this checklist only after the eventual homepage activation pass.

## Required Checks
- `/` returns `200`
- `/` shows the archive-backed homepage, not the current legacy Elementor playlist/stream layout
- No `Private Review` copy appears
- No raw shortcode text appears
- Header renders correctly
- Footer renders correctly
- Home navigation still resolves to `/`
- Primary homepage CTAs resolve correctly
- `/archive/` returns `200`
- `/history/` returns `200`
- `/performances/` returns `200`
- `/search/` returns `200`
- Representative archive single returns `200`
- Representative performance single returns `200`
- No fatal error text or maintenance text appears in the body
- If activation used a new page, the old page `7127` still exists intact for rollback

## Quick Rollback Trigger Conditions
- Raw shortcode output on `/`
- Missing header/footer
- Fatal error or blank body
- Home page serves incomplete/un-styled archive markup
- Primary archive routes regress from `200`
