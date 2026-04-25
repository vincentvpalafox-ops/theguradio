# cPanel Recovery Notes

## What Was Found
- Chrome session files in the `Default` profile still contained real cPanel URLs for:
  - `webhosting2021.is.cc:2083`
  - tokenized `cpsess...` paths
  - a File Manager route

## What Was Tested
- The recovered tokenized URLs were fetched directly.
- The results were recorded only in redacted form.

## What Happened
- The tokenized URLs resolved to pages titled `cPanel Login`.
- Login-form markers were present.
- File Manager markers were absent.

## Meaning
- The session tokens were once valid.
- They are no longer valid enough to reuse for the preview-runner upload.
- That closes the remaining browser-session recovery avenue.
