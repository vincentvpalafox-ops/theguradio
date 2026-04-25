# Build And Test Status

This pass was blocker-state documentation only. No build, deploy, or content mutation was attempted.

Checks run:

1. `git rev-parse --short HEAD`
   - Result: `7ed0f01`

2. `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/`
   - Result: `200`

3. `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/archive-homepage-preview/`
   - Result: `404`

4. `powershell -ExecutionPolicy Bypass -File PASS_HANDOFF_0034_2026-04-24/proof_bundle/Invoke-PreviewProofBundleIntegrity.ps1 -OutDir tmp_pass0044_integrity`
   - Result: `overall_pass = true`

5. `git diff --check -- PASS_HANDOFF_0044_2026-04-24`
   - Result: pass

6. `git diff --cached --check`
   - Result: pass

Interpretation:

- live behavior is unchanged
- the preview proof still has not executed
- the prepared proof bundle remains valid
