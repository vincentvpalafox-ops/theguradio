# Token Redaction Note

- Real tokenized cPanel URLs were found during this pass.
- Those token values were treated as sensitive session material.
- The exported JSON and markdown files include only redacted URL forms:
  - `cpsess[redacted]`
- No raw cPanel session tokens were intentionally written into the handoff package.
