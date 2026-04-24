# Project Vision and Scope

## Intended Product Vision

The intended product is a structured cultural archive for the Gallatin Underground scene, not just a blog or event calendar. The target experience is a clear public front door with a stable navigation model:

- Home
- Performances
- Archive
- History
- About

The archive system is meant to preserve performances, posters, flyers, artifacts, venue memory, scene history, and discovery material in a way that reads like a long-term scene record rather than a reverse-chronology content feed. This vision is explicitly described in [01_MASTER_PLATFORM_DIRECTION.md](../GU_MASTER_PLATFORM_PACKAGE/01_MASTER_PLATFORM_DIRECTION.md), [04_PUBLIC_HOMEPAGE_PRODUCTION_SPEC.md](../GU_MASTER_PLATFORM_PACKAGE/04_PUBLIC_HOMEPAGE_PRODUCTION_SPEC.md), and [06_ARCHIVE_AND_HISTORY_MODEL.md](../GU_MASTER_PLATFORM_PACKAGE/06_ARCHIVE_AND_HISTORY_MODEL.md).

## Primary User Workflows

| Workflow name | User goal | Starting screen or entry point | Expected steps | Expected result | Current implementation status |
| --- | --- | --- | --- | --- | --- |
| Browse performances | Find scene videos by artist, venue, genre, source, area, or year | `/performances/` | Open archive, apply filters, open record or source link | Reach a usable performance record library | Functional |
| Browse archive records | Find flyers, artifacts, media, and other archive records | `/archive/` | Open archive, use browse chips or filters, open record/source | Reach structured non-performance archive material | Functional with issues |
| Browse history | Navigate history records by topic and year | `/history/` or `/history-topic/{slug}/` | Open history archive, filter by topic/area/year, open record | Reach history-specific records and context | Functional with issues |
| Search archive | Search internal records first, optionally external media after | `/search/` | Enter query, optionally set filters, review grouped results | Internal results prioritized over external sources | Functional with issues |
| Review/promote discoveries | Turn search discoveries into permanent records | Admin plugin screens | Search preview, queue/promote candidate, edit metadata | Create permanent archive record | Partial |
| Stewardship and maintenance | Validate links, audit records, normalize terms, monitor homepage support | Admin maintenance/dashboard | Run maintenance actions and fix surfaced issues | Keep live archive usable and structurally clean | Functional |
| Public homepage/front door | Understand the project quickly and move into archive/history/performance surfaces | `/` | Land on homepage, follow curated sections/CTAs | Enter archive through an intentional public front door | Partial |

## In Scope

- WordPress-based public archive/search/history system
- `scene_video` and `archive_item` records
- Scene taxonomies and metadata
- Internal-first search plus supported external providers
- Public archive, history, performances, and single-record templates
- Maintenance/audit/operator workflows for curators
- Homepage sections that surface curated archive material
- MEC event coexistence where useful

## Out of Scope

- A generic full-site redesign unrelated to the archive architecture
- Replacing WordPress with a new stack
- Expanding provider support before core archive/search behavior is stable
- Treating MEC/calendar pages as the primary product
- Automating content promotion without moderation and dedupe rules
- Broad visual redesign work disconnected from the existing GU identity

## Locked Decisions

- WordPress is the primary platform authority: [03_STACK_AND_SYSTEM_AUTHORITY.md](../GU_MASTER_PLATFORM_PACKAGE/03_STACK_AND_SYSTEM_AUTHORITY.md)
- `gu-scene-archive` is the core archive/search product layer
- Search is internal-first and external sources are secondary: [10_SEARCH_AND_DISCOVERY_PRIORITY.md](../GU_MASTER_PLATFORM_PACKAGE/10_SEARCH_AND_DISCOVERY_PRIORITY.md)
- SoundCloud and Spotify are later-work providers, not current production dependencies: [staged_remote_changes/wp-content/plugins/gu-scene-archive/README.md](../staged_remote_changes/wp-content/plugins/gu-scene-archive/README.md)
- Review/demo surfaces are transitional and should not remain public-facing: [08_TRANSITIONAL_SURFACE_CLEANUP.md](../GU_MASTER_PLATFORM_PACKAGE/08_TRANSITIONAL_SURFACE_CLEANUP.md)
- Archive/history/search surfaces should remain noindex until release gates are satisfied: [12_NOINDEX_AND_RELEASE_GATES.md](../GU_MASTER_PLATFORM_PACKAGE/12_NOINDEX_AND_RELEASE_GATES.md)

## Open Decisions

- When and how `/` will be converted to the archive-backed homepage already implemented in shortcode form
- Whether the current history model is sufficient or still needs a dedicated history-layer/content-type expansion
- What exact curation threshold is required before full indexing/release
- How the moderation/promotion workflow should be operationalized day to day
- What the authoritative long-term source-control/deployment workflow should be, since the current Git repo is only a partial shell around the workspace

## Known Constraints

- Shared-hosting WordPress environment with manual deployment history
- Live data is in WordPress DB and media uploads, not fully represented in Git
- `php` CLI is not available locally in this workspace: [logs/tool_availability.txt](logs/tool_availability.txt)
- No standard app build system is present in repo root
- Provider auth is required for full YouTube API behavior and future external-provider support
- Content quality is constrained by real evidence-backed scene records, not by filler/demo content
- Release policy explicitly discourages surfacing incomplete archive/search systems to indexers
