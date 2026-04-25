# Execute After Reauth

## Purpose
- Prove the archive-backed homepage shortcode on a dedicated preview URL.
- Validate the bundle before any upload.
- Capture one canonical proof result.
- Do not activate `/`.

## Step 0. Validate The Bundle
- Run locally:

```powershell
powershell -ExecutionPolicy Bypass -File .\proof_bundle\Invoke-PreviewProofBundleIntegrity.ps1 `
  -OutDir .\proof_integrity_output
```

- Required result in `proof_integrity_output\proof_bundle_integrity.json`:
  - `overall_pass = true`

## Step 1. Upload The Create Runner
- Upload:
  - `gu-homepage-preview-create-0028.php`
- Target:
  - `/home/thegalla/public_html/gu-homepage-preview-create-0028.php`

## Step 2. Execute The Create Runner
- Request:
  - `https://theguradio.com/gu-homepage-preview-create-0028.php`
- Save the JSON response locally as:
  - `create_runner_response.json`
- Required result:
  - `front_page_unchanged = true`

## Step 3. Capture The Proof
- Run locally:

```powershell
powershell -ExecutionPolicy Bypass -File .\proof_bundle\Invoke-PreviewProofCapture.ps1 `
  -CreateResponseFile .\create_runner_response.json `
  -PreviewUrl https://theguradio.com/archive-homepage-preview/ `
  -OutDir .\proof_capture_output
```

- Required result in `proof_capture_output\preview_proof_capture.json`:
  - `runner.runner_ok = true`
  - `verifier.overall_pass = true`
  - `overall_pass = true`

## Step 4. Roll Back Only If The Preview Fails
- Upload:
  - `gu-homepage-preview-remove-0028.php`
- Target:
  - `/home/thegalla/public_html/gu-homepage-preview-remove-0028.php`
- Request:
  - `https://theguradio.com/gu-homepage-preview-remove-0028.php`

## Hard Boundary
- Do not change `page_on_front`.
- Do not edit page `7127`.
- Do not activate `/`.
