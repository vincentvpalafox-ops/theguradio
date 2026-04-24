# Blockers And Risks

## Blockers

### 1. The preview page still does not exist
- Baseline verification confirms the recommended preview URL currently returns `404`.

### 2. `wp-admin` access is still required for the actual proof pass
- This harness validates the preview after creation.
- It does not replace the need for a legitimate WordPress content-edit session.

## Risks

### 1. Running verification against `/` instead of the dedicated preview URL would muddy the activation sequence
- Keep preview validation and front-door activation separate.

### 2. The script checks render markers, not visual design nuance
- It is a fast structural verifier, not a full visual review replacement.

### 3. A preview page can still render and yet expose copy-quality problems
- The next pass should still record human review notes in addition to the script output.
