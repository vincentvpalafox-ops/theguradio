<?php

if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/archive-helpers.php';

get_header();

$settings = GU_Scene_Archive_Settings::get_all();
$library_columns = max(1, min(4, absint($settings['library_cards_per_row'])));
$library_card_min_width = max(240, absint($settings['library_card_min_width']));
$page_kicker = ! empty($settings['archive_item_library_kicker']) ? $settings['archive_item_library_kicker'] : 'Archive';
$page_title = ! empty($settings['archive_item_library_title']) ? $settings['archive_item_library_title'] : 'Scene Archive';
$page_intro = ! empty($settings['archive_item_library_intro']) ? $settings['archive_item_library_intro'] : '';
$legacy_intro = 'Review-stage archive records for posters, history, features, and scene artifacts.';
$featured_records = get_posts(
    array(
        'post_type' => 'archive_item',
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
    $page_intro = 'Flyers, artifacts, media, venue memory, and history records collected as long-term reference. Browse by type, history topic, area, and year so the archive reads like a structured record instead of a loose post feed.';
}

$type_chips = gu_scene_archive_template_render_term_chips(
    'archive_type',
    'Browse By Archive Type',
    get_post_type_archive_link('archive_item'),
    'archive_type',
    8
);
$history_chips = gu_scene_archive_template_render_term_chips(
    'history_topic',
    'Browse By History Topic',
    get_post_type_archive_link('archive_item'),
    'history_topic',
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

        <?php if ($type_chips || $history_chips) : ?>
            <div class="gu-scene-library-browse-groups">
                <?php echo $type_chips; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php echo $history_chips; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        <?php endif; ?>

        <?php if (! empty($featured_records)) : ?>
            <section class="gu-scene-library-featured">
                <div class="gu-scene-library-section-head">
                    <div>
                        <p class="gu-scene-library-kicker">Curated Picks</p>
                        <h2>Featured Archive Records</h2>
                        <p>Featured records keep the archive intentional. They surface the pieces that explain scene identity, not just the items that happen to be newest.</p>
                    </div>
                </div>

                <div class="gu-scene-library-grid">
                    <?php foreach ($featured_records as $featured_record) : ?>
                        <?php echo gu_scene_archive_template_render_card($featured_record->ID, 'archive_item', array('show_excerpt' => true, 'excerpt_words' => 22)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="gu-scene-library-browse">
            <div class="gu-scene-library-section-head">
                <div>
                    <p class="gu-scene-library-kicker">Library</p>
                    <h2>Browse Archive Records</h2>
                    <p>Move through the archive by type, history topic, area, and year so the material feels like a usable scene record instead of a stack of miscellaneous posts.</p>
                </div>
            </div>

            <form class="gu-scene-filter-form" method="get">
                <?php gu_scene_archive_render_filter_select('area', 'scene_area', 'Area'); ?>
                <?php gu_scene_archive_render_filter_select('archive_type', 'archive_type', 'Archive Type'); ?>
                <?php gu_scene_archive_render_filter_select('history_topic', 'history_topic', 'History Topic'); ?>
                <?php gu_scene_archive_render_filter_select(GU_Scene_Archive_Template_Controller::YEAR_FILTER_QUERY_VAR, 'scene_year', 'Year'); ?>
                <div class="gu-scene-filter-actions">
                    <button type="submit">Apply Filters</button>
                    <a href="<?php echo esc_url(get_post_type_archive_link('archive_item')); ?>">Reset</a>
                </div>
            </form>

            <?php if (have_posts()) : ?>
                <div class="gu-scene-library-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php echo gu_scene_archive_template_render_card(get_the_ID(), 'archive_item', array('show_excerpt' => true, 'excerpt_words' => 22)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p class="gu-scene-library-empty">No archive records match the current filters yet.</p>
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
