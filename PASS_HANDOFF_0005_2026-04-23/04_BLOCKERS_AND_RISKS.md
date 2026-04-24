# 04 BLOCKERS AND RISKS

- Active blockers:
  - no direct live admin/content-edit path exists in this workspace, so the original metadata cleanup could not be applied straight to production records from here
  - no local `php` CLI is available, so syntax validation is limited to static review
- Known risks introduced or still unresolved:
  - the new normalization code has not been run against live data yet
  - host-based `scene_source` backfills depend on a valid `gu_original_url`; records missing or misconfigured source URLs remain unchanged
  - history-topic gaps remain unresolved by design unless a human assigns them from real evidence
  - the workspace still contains live/local drift on `review-home`, so code deployment should be checked carefully against the current live plugin state
- Was project drift observed:
  - no scope drift in this pass
  - yes, pre-existing live/local drift remains unresolved
- Did architectural questions surface:
  - no new product architecture question surfaced
  - one operational question remains: how the current live `review-home` implementation diverged from the local template snapshot
- Did scope pressure appear:
  - mild; the originally requested metadata cleanup was blocked by missing live edit access, so the pass was redirected into the smallest existing-maintenance extension that can support it safely
