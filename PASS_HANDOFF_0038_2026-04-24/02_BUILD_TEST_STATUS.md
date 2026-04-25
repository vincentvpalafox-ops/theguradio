# Build And Test Status

This pass was stop-condition documentation only. No build, deploy, or content mutation was attempted.

Checks run:

1. `git rev-parse --short HEAD`
   - Result: `6eb2103`

2. `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/`
   - Result: `200`

3. `curl.exe -s -o NUL -w "%{http_code}" https://theguradio.com/archive-homepage-preview/`
   - Result: `404`

4. `powershell -ExecutionPolicy Bypass -File PASS_HANDOFF_0034_2026-04-24/proof_bundle/Invoke-PreviewProofBundleIntegrity.ps1 -OutDir tmp_pass0038_integrity`
   - Result: `overall_pass = true`

5. `git diff --check -- PASS_HANDOFF_0038_2026-04-24`
   - Result: pass

6. `git diff --cached --check`
   - Result: pass

Interpretation:

- nothing changed in the live execution state
- no authenticated path appeared
- the local proof bundle is still ready
