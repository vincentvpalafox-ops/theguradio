# Manual Reauth Decision

## Decision
- Manual hosting reauthentication is now the required gate before further homepage-preview execution.

## Why This Decision Is Locked
- SSH path: failed
- cPanel credential-store path: not recoverable
- Chrome remote-debugging path: not available
- recovered tokenized cPanel URLs: expired
- browser-session evidence: present but not callable

## What This Means For The Next Operator
- Do not spend the next pass on more local recovery attempts.
- Start with a fresh authenticated hosting login.
- Then run the preview proof packet already prepared.
