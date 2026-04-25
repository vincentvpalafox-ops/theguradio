# Integrity Gate Notes

## What The Integrity Gate Adds
- Verifies the proof bundle is complete before any upload
- Verifies each tracked file hash matches the approved value
- Emits:
  - `proof_bundle_integrity.json`
  - `proof_bundle_integrity.md`

## Why This Matters
- It removes ambiguity about whether the operator is running the approved bundle or a drifted copy.
- It is the last useful prep improvement before the live authenticated step.
