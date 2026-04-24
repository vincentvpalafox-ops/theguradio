# Risk Register

| Risk | Probability | Impact | Severity | Mitigation |
| --- | --- | --- | --- | --- |
| Public users continue entering through the wrong homepage | High | High | High | Convert `/` to the archive-backed homepage next |
| Repo and live system drift further apart | High | High | High | Normalize source-of-truth and deployment rules after next bounded product pass |
| Manual deployment introduces silent regression | Medium | High | High | Document process and add repeatable verification checklist |
| Thin or narrow archive/history content weakens trust | Medium | High | High | Continue evidence-backed curation after front-door alignment |
| Search expectations exceed actual provider support | High | Medium | High | Keep unsupported providers clearly documented and disabled |
| Lack of automated tests allows regressions through | High | Medium | High | Add minimum repeatable QA/lint checks after homepage pass |
| Documentation drift obscures current state | High | Medium | High | Consolidate status docs and replace placeholder README |
| Seed/demo/transitional content leaks back into public surfaces | Medium | Medium | Medium | Keep review-only surfaces private and continue cleanup |
| MEC/event dependency distracts from core archive product | Medium | Medium | Medium | Treat events as secondary and fallback-friendly |
| No local PHP tooling slows verification | High | Medium | Medium | Add PHP CLI or CI-based linting |
