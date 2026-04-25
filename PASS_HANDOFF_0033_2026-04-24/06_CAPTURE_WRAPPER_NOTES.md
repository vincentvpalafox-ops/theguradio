# Capture Wrapper Notes

## What The Wrapper Adds
- Reads the create-runner JSON
- Confirms:
  - `ok = true`
  - `front_page_unchanged = true`
  - preview page URL matches the expected preview URL
- Runs the verifier automatically
- Emits:
  - `preview_proof_capture.json`
  - `preview_proof_capture.md`

## Why This Matters
- It turns multiple manual checks into one canonical pass/fail result.
- It reduces the chance that the preview exists but the proof record is incomplete or inconsistent.
