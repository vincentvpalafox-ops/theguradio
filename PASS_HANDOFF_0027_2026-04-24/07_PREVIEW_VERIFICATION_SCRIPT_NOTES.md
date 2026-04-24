# Preview Verification Script Notes

## Script Location
- `PASS_HANDOFF_0027_2026-04-24/tools/Invoke-HomepagePreviewVerification.ps1`

## Intended Use
- Fast structural verification after the preview page is created.

## Fetch Strategy
- The script now uses `curl.exe` as its primary fetch path.
- Reason:
  - local PowerShell `Invoke-WebRequest` was collapsing the missing preview URL into a connection-abort with no usable HTTP response
  - `curl.exe` returns the real public status code and still captures response body content for marker checks

## Current Baseline Result
- The baseline run in this pass targeted:
  - `https://theguradio.com/archive-homepage-preview/`
- Expected outcome before page creation:
  - preview `404`
  - core routes healthy
- That is exactly what happened.

## Why This Script Exists
- It reduces ambiguity in the preview proof pass.
- It makes the pass result easier to audit.
- It separates:
  - page creation
  - route regression check
  - preview render validation

## Limitations
- It does not log into WordPress.
- It does not create the preview page.
- It does not verify fine-grained visual quality beyond marker presence and disallowed text checks.
- It assumes `curl.exe` is available on the operator machine.
