<?php

if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/archive-helpers.php';

get_header();

$settings = GU_Scene_Archive_Settings::get_all();
$library_columns = max(1, min(4, absint($settings['library_cards_per_row'])));
$library_card_min_width = max(240, absint($settings['library_card_min_width']));
$page_kicker = ! empty($settings['scene_video_archive_kicker']) ? $settings['scene_video_archive_kicker'] : 'Performances';
$page_title = ! empty($settings['scene_video_archive_title']) ? $settings['scene_video_archive_title'] : 'Performance Archive';
$page_intro = ! empty($settings['scene_video_archive_intro']) ? $settings['scene_video_archive_intro'] : '';
$legacy_intro = 'Review-stage performance archive for The Gallatin Underground. This library is currently hidden from indexing while the archive system is under construction.';
$featured_records = get_posts(
    array(
        'post_type' => 'scene_video',
        'post_status' => 'publish',
        'posts_per_page' => 4,
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
        'meta_query' => array(
            'relation' => 'AND',
            GU_Scene_Archive_Record_Manager::build_public_visibility_meta_query(),
            array(
                'key' => 'gu_featured',
                'value' => '1',
            ),
        ),
    )
);

if ('' === trim($page_intro) || $legacy_intro === $page_intro) {
    $page_intro = 'Curated performance records from The Gallatin Underground archive. Use artists, venues, genres, areas, and years to move through the scene intentionally instead of skimming a generic reverse-chronology feed.';
}

$genre_chips = gu_scene_archive_template_render_term_chips(
    'scene_genre',
    'Browse By Genre',
    get_post_type_archive_link('scene_video'),
    'genre',
    8
);
$venue_chips = gu_scene_archive_template_render_term_chips(
    'scene_venue',
    'Browse By Venue',
    get_post_type_archive_link('scene_video'),
    'venue',
    8
);
?>
<main class="gu-scene-library-page">
    <section
        class="gu-scene-library-shell"
        style="<?php echo esc_attr('--gu-scene-library-columns:' . $library_columns . ';--gu-scene-library-card-min:' . $library_card_min_width . 'px;'); ?>"
    >
        <div class="gu-scene-library-hero">
            <p class="gu-scene-library-kicker"><?php echo esc_html($page_kicker); ?></p>
            <h1><?php echo esc_html($page_title); ?></h1>
            <p><?php echo esc_html($page_intro); ?></p>
        </div>

        <?php if ($genre_chips || $venue_chips) : ?>
            <div class="gu-scene-library-browse-groups">
                <?php echo $genre_chips; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php echo $venue_chips; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        <?php endif; ?>

        <?php if (! empty($featured_records)) : ?>
            <section class="gu-scene-library-featured">
                <div class="gu-scene-library-section-head">
                    <div>
                        <p class="gu-scene-library-kicker">Curated Picks</p>
                        <h2>Featured Performances</h2>
                        <p>These records are intentionally surfaced first so the archive reads like a guided library, not a dump of whatever was added most recently.</p>
                    </div>
                </div>

                <div class="gu-scene-library-grid">
                    <?php foreach ($featured_records as $featured_record) : ?>
                        <?php echo gu_scene_archive_template_render_card($featured_record->ID, 'scene_video', array('show_excerpt' => true, 'excerpt_words' => 22)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="gu-scene-library-browse">
            <div class="gu-scene-library-section-head">
                <div>
                    <p class="gu-scene-library-kicker">Library</p>
                    <h2>Browse Performance Records</h2>
                    <p>Filter by artist, venue, genre, source, area, or year to move through the archive by scene context instead of relying on chronology alone.</p>
                </div>
            </div>

            <form class="gu-scene-filter-form" method="get">
                <?php gu_scene_archive_render_filter_select('area', 'scene_area', 'Area'); ?>
                <?php gu_scene_archive_render_filter_select('genre', 'scene_genre', 'Genre'); ?>
                <?php gu_scene_archive_render_filter_select('artist', 'scene_artist', 'Artist'); ?>
                <?php gu_scene_archive_render_filter_select('venue', 'scene_venue', 'Venue'); ?>
                <?php gu_scene_archive_render_filter_select('source', 'scene_source', 'Source'); ?>
                <?php gu_scene_archive_render_filter_select(GU_Scene_Archive_Template_Controller::YEAR_FILTER_QUERY_VAR, 'scene_year', 'Year'); ?>
                <div class="gu-scene-filter-actions">
                    <button type="submit">Apply Filters</button>
                    <a href="<?php echo esc_url(get_post_type_archive_link('scene_video')); ?>">Reset</a>
                </div>
            </form>

            <?php if (have_posts()) : ?>
                <div class="gu-scene-library-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php echo gu_scene_archive_template_render_card(get_the_ID(), 'scene_video', array('show_excerpt' => true, 'excerpt_words' => 22)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p class="gu-scene-library-empty">No performance records match the current filters yet.</p>
            <?php endif; ?>

            <div class="gu-scene-library-pagination">
                <?php
                the_posts_pagination(
                    array(
                        'prev_text' => 'Previous',
                        'next_text' => 'Next',
                    )
                );
                ?>
            </div>
        </section>
    </section>
</main>
<?php
get_footer();
