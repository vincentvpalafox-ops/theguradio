<?php

if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/archive-helpers.php';

get_header();

$settings = GU_Scene_Archive_Settings::get_all();
$library_columns = max(1, min(4, absint($settings['library_cards_per_row'])));
$library_card_min_width = max(240, absint($settings['library_card_min_width']));
$queried_topic = is_tax('history_topic') ? get_queried_object() : null;
$year_filter_key = GU_Scene_Archive_Template_Controller::YEAR_FILTER_QUERY_VAR;
$selected_topic = $queried_topic && ! is_wp_error($queried_topic) ? (string) $queried_topic->slug : (isset($_GET['history_topic']) ? sanitize_title(wp_unslash($_GET['history_topic'])) : '');
$selected_area = isset($_GET['area']) ? sanitize_title(wp_unslash($_GET['area'])) : '';
$selected_year = isset($_GET[$year_filter_key]) ? sanitize_title(wp_unslash($_GET[$year_filter_key])) : '';
$paged = max(1, absint(get_query_var('paged')), absint(get_query_var('page')), isset($_GET['paged']) ? absint(wp_unslash($_GET['paged'])) : 0);
$page_kicker = $queried_topic ? 'History Topic' : 'History';
$page_title = $queried_topic ? $queried_topic->name : 'Scene History';
$page_intro = $queried_topic && ! empty($queried_topic->description)
    ? $queried_topic->description
    : 'Scene history lives here as structured archive records: venue legacy, artist eras, milestones, timeline fragments, and the slower-moving context that explains the present.';

$history_tax_query = array(
    'relation' => 'AND',
    array(
        'relation' => 'OR',
        array(
            'taxonomy' => 'history_topic',
            'operator' => 'EXISTS',
        ),
        array(
            'taxonomy' => 'archive_type',
            'field' => 'slug',
            'terms' => array('history'),
        ),
    ),
);

if ('' !== $selected_topic) {
    $history_tax_query[] = array(
        'taxonomy' => 'history_topic',
        'field' => 'slug',
        'terms' => $selected_topic,
    );
}

if ('' !== $selected_area) {
    $history_tax_query[] = array(
        'taxonomy' => 'scene_area',
        'field' => 'slug',
        'terms' => $selected_area,
    );
}

if ('' !== $selected_year) {
    $history_tax_query[] = array(
        'taxonomy' => 'scene_year',
        'field' => 'slug',
        'terms' => $selected_year,
    );
}

$featured_history = get_posts(
    array(
        'post_type' => 'archive_item',
        'post_status' => 'publish',
        'posts_per_page' => 4,
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
        'tax_query' => $history_tax_query,
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

$history_query = new WP_Query(
    array(
        'post_type' => 'archive_item',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'paged' => $paged,
        'ignore_sticky_posts' => true,
        'tax_query' => $history_tax_query,
        'meta_query' => array(
            'relation' => 'AND',
            GU_Scene_Archive_Record_Manager::build_public_visibility_meta_query(),
        ),
    )
);

$topic_chips = gu_scene_archive_template_render_term_chips(
    'history_topic',
    'Browse By History Topic',
    home_url('/history/'),
    'history_topic',
    10
);

$pagination_url = add_query_arg(
    array_filter(
        array(
            'history_topic' => $selected_topic,
            'area' => $selected_area,
            $year_filter_key => $selected_year,
            'paged' => '%#%',
        )
    ),
    home_url('/history/')
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

        <?php if ($topic_chips) : ?>
            <div class="gu-scene-library-browse-groups">
                <?php echo $topic_chips; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        <?php endif; ?>

        <?php if (! empty($featured_history)) : ?>
            <section class="gu-scene-library-featured gu-scene-library-featured-history">
                <div class="gu-scene-library-section-head">
                    <div>
                        <p class="gu-scene-library-kicker">Anchors</p>
                        <h2>Featured History Records</h2>
                        <p>These records carry the larger timeline: scene shifts, venue memory, artist eras, and the pieces that help the archive explain itself.</p>
                    </div>
                </div>

                <div class="gu-scene-library-grid">
                    <?php foreach ($featured_history as $featured_record) : ?>
                        <?php echo gu_scene_archive_template_render_card($featured_record->ID, 'archive_item', array('show_excerpt' => true, 'excerpt_words' => 22)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="gu-scene-library-browse gu-scene-library-browse-history">
            <div class="gu-scene-library-section-head">
                <div>
                    <p class="gu-scene-library-kicker">Browse</p>
                    <h2>History Records</h2>
                    <p>Filter by topic, area, and year to move through history as grouped memory rather than a flattened post stream.</p>
                </div>
            </div>

            <form class="gu-scene-filter-form" method="get" action="<?php echo esc_url(home_url('/history/')); ?>">
                <?php gu_scene_archive_render_filter_select('history_topic', 'history_topic', 'History Topic'); ?>
                <?php gu_scene_archive_render_filter_select('area', 'scene_area', 'Area'); ?>
                <?php gu_scene_archive_render_filter_select($year_filter_key, 'scene_year', 'Year'); ?>
                <div class="gu-scene-filter-actions">
                    <button type="submit">Apply Filters</button>
                    <a href="<?php echo esc_url(home_url('/history/')); ?>">Reset</a>
                </div>
            </form>

            <?php if ($history_query->have_posts()) : ?>
                <div class="gu-scene-library-grid">
                    <?php while ($history_query->have_posts()) : $history_query->the_post(); ?>
                        <?php echo gu_scene_archive_template_render_card(get_the_ID(), 'archive_item', array('show_excerpt' => true, 'excerpt_words' => 22)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p class="gu-scene-library-empty">No history records match the current filters yet.</p>
            <?php endif; ?>

            <?php if ($history_query->max_num_pages > 1) : ?>
                <div class="gu-scene-library-pagination">
                    <?php
                    echo paginate_links(
                        array(
                            'base' => $pagination_url,
                            'format' => '',
                            'current' => $paged,
                            'total' => max(1, (int) $history_query->max_num_pages),
                            'prev_text' => 'Previous',
                            'next_text' => 'Next',
                        )
                    );
                    ?>
                </div>
            <?php endif; ?>
        </section>
    </section>
</main>
<?php
wp_reset_postdata();
get_footer();
