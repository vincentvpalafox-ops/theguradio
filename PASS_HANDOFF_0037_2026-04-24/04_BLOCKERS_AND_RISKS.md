# Blockers And Risks

## Primary Blocker

Authenticated hosting access still has not been restored.

Fresh evidence:

- `ssh_available = false`
- `cpanel_authenticated_surface_recovered = false`
- `manual_reauth_required = true`
- `workspace_only_paths_exhausted = true`

## Risk

Continuing with additional workspace-only passes would still not move the homepage preview proof forward. The technical path is ready; the environment prerequisite is still missing.

## Operational Reminder

Once reauthentication exists, the proof must still be executed in the approved order:

1. integrity gate
2. create preview runner
3. verifier
4. proof capture
5. no `page_on_front` switch yet
