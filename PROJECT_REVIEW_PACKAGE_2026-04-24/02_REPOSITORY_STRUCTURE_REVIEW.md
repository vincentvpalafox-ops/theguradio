# Repository / File Structure Review

## Top-Level Structure

Readable top-level structure based on the reviewed workspace:

```text
/The GU RADIO
  /.git
  /GU_MASTER_PLATFORM_PACKAGE
  /PASS_HANDOFF_0001_2026-04-23
  /PASS_HANDOFF_0002_2026-04-23
  ...
  /PASS_HANDOFF_0023_2026-04-24
  /PASS_HANDOFF_TEMPLATE
  /production_backup
  /staged_remote_changes
    /wp-content
      /plugins
        /gu-scene-archive
          /assets
          /includes
          /templates
          gu-scene-archive.php
          README.md
    wp-config.php
  /tmp
  CHATGPT_PLATFORM_ASSESSMENT_20260419.md
  MASTER_SITE_RENOVATION_PLAN.md
  SEARCH_SYSTEM_IMPLEMENTATION_SPEC.md
  README.md
```

The workspace is unusual:

- It contains the working plugin snapshot in `staged_remote_changes/`
- It contains many handoff packages and backups
- The root Git repo is newly initialized and only tracks a fraction of the workspace

## Important Files

| File | Purpose | Status | Notes |
| --- | --- | --- | --- |
| [staged_remote_changes/wp-content/plugins/gu-scene-archive/gu-scene-archive.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/gu-scene-archive.php) | Plugin entry point | Active | Boots the real archive system |
| [staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-plugin.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-plugin.php) | System composition/root class | Active | Wires settings, content, search, templates, maintenance, dashboards |
| [staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-content.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-content.php) | CPT/taxonomy registration | Active | Primary data-model source |
| [staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-template-controller.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-template-controller.php) | Route and template controller | Active | Defines `/history/`, `review-home`, archive templates, year-filter redirect |
| [staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-search-controller.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-search-controller.php) | `/search/` route and form behavior | Active | Public search entry point |
| [staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-search-service.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-search-service.php) | Search logic and provider orchestration | Active | Internal-first logic and scoring live here |
| [staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-section-shortcodes.php) | Homepage/archive section shortcodes | Active | Contains intended archive-backed homepage implementation |
| [staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-maintenance.php) | Maintenance tools and audit state | Active | Significant operator/admin functionality |
| [staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-operator-dashboard.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-operator-dashboard.php) | Operator dashboard | Active | Curatorial/maintenance workflow surface |
| [staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-promotion-workflow.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-promotion-workflow.php) | Promotion/admin workflow | Partial | Real code exists, but end-to-end operational maturity remains unclear |
| [staged_remote_changes/wp-content/plugins/gu-scene-archive/templates/review-home.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/templates/review-home.php) | Transitional review homepage | Transitional | Still contains private-review copy and placeholder sections |
| [GU_MASTER_PLATFORM_PACKAGE/00_READ_ME_FIRST.md](../GU_MASTER_PLATFORM_PACKAGE/00_READ_ME_FIRST.md) | Documentation entry point | Active | Best starting doc for project intent |
| [CHATGPT_PLATFORM_ASSESSMENT_20260419.md](../CHATGPT_PLATFORM_ASSESSMENT_20260419.md) | Prior high-level status review | Active but aging | Important context, but some live status has moved since it was written |
| [README.md](../README.md) | Repo root README | Inadequate | Contains only `# theguradio` |

## Suspect Files

These files/folders are not necessarily wrong, but they materially increase review and maintenance overhead:

- Root `README.md`: essentially empty and not usable
- `PASS_HANDOFF_*` folders and `.zip` exports: useful as artifacts, but clutter the root and are not integrated into a conventional changelog/release workflow
- `production_backup/`: necessary as backup evidence, but not part of a normal repo layout
- `tmp/` plus root `tmp_*` HTML/PHP files: clearly temporary inspection/debug artifacts
- `staged_remote_changes/`: functionally important, but the name itself signals that the real codebase is living in a staging snapshot rather than in a normal repo structure
- `templates/review-home.php`: clearly seed/review-only and still conflicting with the intended production front door
- old plugin zip exports in root: release artifacts with unclear current relevance

## Missing Files

Expected project files that are missing or inadequate:

- A meaningful repo root `README.md`
- A real changelog or release-history file
- A deployment guide that matches the actual live workflow
- An `.env.example` or equivalent secret/config guide
- A local development/setup guide
- Automated test configuration
- A route map as maintained documentation
- A data dictionary/export policy for live WordPress records
- A source-control policy explaining what belongs in Git versus the live database
- Design system or UI standards documentation at repo root
