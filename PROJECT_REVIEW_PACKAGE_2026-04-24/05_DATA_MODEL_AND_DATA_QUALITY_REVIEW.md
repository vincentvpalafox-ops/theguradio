# Data Model and Data Quality Review

## Data Sources

Current data sources in the reviewed system:

- WordPress custom post types: `scene_video`, `archive_item`
- WordPress taxonomies: `scene_area`, `scene_genre`, `scene_artist`, `scene_venue`, `scene_source`, `scene_year`, `archive_type`, `history_topic`
- WordPress post meta: source URLs, embed URLs, featured flags, approval flags, link status, source IDs, validation metadata
- WordPress options: plugin settings, maintenance state, operator queue
- WordPress media/uploads
- WordPress pages and Elementor content for the current homepage shell
- MEC event posts and metadata, when present
- External provider APIs/pages, primarily YouTube
- Mocked/stubbed external providers for SoundCloud and Spotify

## Data Tables / Collections / Objects

| Data Object | Purpose | Fields | Source | Used By | Issues |
| --- | --- | --- | --- | --- | --- |
| `scene_video` | Permanent performance records | title, content/excerpt, featured/approved/link meta, source URLs, source ID, scene taxonomies | WordPress DB | performances archive, search, homepage sections, admin tools | Live DB only; no versioned dataset export |
| `archive_item` | Permanent archive/history records | title, content/excerpt, featured/approved/link meta, source URLs, archive/history taxonomies | WordPress DB | archive/history routes, homepage sections, search, admin tools | Public set is still small and uneven |
| `scene_area` | Place classification | term name/slug | WordPress taxonomy | filters, chips, search scoring | Depends on manual curation |
| `scene_genre` | Genre classification | term name/slug | WordPress taxonomy | performance filters, chips, search scoring | No evidence of controlled vocabulary policy |
| `scene_artist` | Artist classification | term name/slug | WordPress taxonomy | performance filters, scoring, metadata | Manual consistency risk |
| `scene_venue` | Venue classification | term name/slug | WordPress taxonomy | performance filters, scoring, metadata | Manual consistency risk |
| `scene_source` | Source labeling | term name/slug | WordPress taxonomy | archive/performance filters, metadata | Backfilled manually/through maintenance; still dependent on clean URLs |
| `scene_year` | Year classification | term name/slug | WordPress taxonomy | all archive filters and chips | Search route still uses legacy `year` text input |
| `archive_type` | Archive record type | term name/slug | WordPress taxonomy | archive/history filters and labels | Archive composition still content-thin |
| `history_topic` | History grouping | term name/slug | WordPress taxonomy | history route and chips | Public coverage currently narrow |
| Maintenance state option | Stores audit/validation/normalization summaries | timestamps, summaries, detail rows | WordPress option | admin maintenance panel | Operational state not versioned in repo |
| Review queue option | Stores queued discovery candidates | provider, title, URL, timestamps | WordPress option | operator dashboard | Hidden from repo reviewers |
| Plugin settings option | Controls search, providers, display, noindex, ranking | many plugin settings | WordPress option | all plugin subsystems | Secret-bearing and environment-specific |
| MEC event posts | Event cards for homepage/events sections | dates, times, thumbnails, excerpts | WordPress DB / MEC plugin | events shortcode | Optional dependency, not core archive source |

## Data Quality Problems

- Live content is not reproducible from the repo because the authoritative state is in WordPress DB and uploads, not in versioned fixtures
- The current public archive is real but still thin: 9 public `archive_item` records and 5 public `scene_video` records were verified via REST during review: [logs/public_archive_items.json](logs/public_archive_items.json), [logs/public_scene_videos.json](logs/public_scene_videos.json)
- History coverage is still narrow; current public history is mainly represented by timeline-class items
- Seed/review-era copy still exists in code, especially in `review-home.php`
- Search filter inputs still use free-text values, which weakens taxonomy-data integrity compared with the controlled filter selects on archive routes
- No versioned data dictionary exists for archive records, history topics, or source-label rules
- External-provider completeness is inconsistent: YouTube has real logic, SoundCloud and Spotify are scaffolds only

## Data Trust Level

**Low**

Why:

- The visible live data subset is real and verifiable
- The underlying authoritative content state is not captured in Git
- There is no repo-level export or schema contract for the live WordPress dataset
- A reviewer cannot reconstruct the operational data state from the repo alone

## Critical Data Risks

- The product can mislead reviewers if repo state is treated as equivalent to live WordPress data
- Content quality depends on manual curation with limited formal controls
- Search and archive quality can drift if taxonomy naming and metadata cleanup are not actively maintained
- Provider behavior can appear broken to users when external sources are enabled in principle but not actually implemented or authenticated

## Evidence

- Content model: [class-gu-scene-archive-content.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-content.php)
- Record meta/public visibility: [class-gu-scene-archive-record-manager.php](../staged_remote_changes/wp-content/plugins/gu-scene-archive/includes/class-gu-scene-archive-record-manager.php)
- Live public records: [logs/public_archive_items.json](logs/public_archive_items.json), [logs/public_scene_videos.json](logs/public_scene_videos.json)
