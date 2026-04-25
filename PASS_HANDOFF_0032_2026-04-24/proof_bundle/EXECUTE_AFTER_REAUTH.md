# Execute After Reauth

## Purpose
- Prove the archive-backed homepage shortcode on a dedicated preview URL.
- Do not activate `/`.

## Step 1. Upload The Create Runner
- Upload:
  - `gu-homepage-preview-create-0028.php`
- Target:
  - `/home/thegalla/public_html/gu-homepage-preview-create-0028.php`

## Step 2. Execute The Create Runner
- Request:
  - `https://theguradio.com/gu-homepage-preview-create-0028.php`
- Save the JSON response.
- Required result:
  - `front_page_unchanged = true`

## Step 3. Verify The Preview
- Run locally:

```powershell
powershell -ExecutionPolicy Bypass -File .\proof_bundle\Invoke-HomepagePreviewVerification.ps1 `
  -PreviewUrl https://theguradio.com/archive-homepage-preview/ `
  -OutFile .\preview_post_create_verification.json
```

- Required result:
  - `preview_status_code = 200`
  - `preview_markers_ok = true`
  - `preview_disallowed_ok = true`
  - `routes_ok = true`

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
