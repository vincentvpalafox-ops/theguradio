<?php

if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('gu_scene_archive_template_record_thumb_url')) {
    function gu_scene_archive_template_record_thumb_url($post_id) {
        if (function_exists('gu_scene_archive_record_thumb_url')) {
            return gu_scene_archive_record_thumb_url($post_id);
        }

        $thumbnail_url = get_the_post_thumbnail_url($post_id, 'large');

        if ($thumbnail_url) {
            return $thumbnail_url;
        }

        $video_id = (string) get_post_meta($post_id, 'gu_source_id', true);

        if ($video_id) {
            return 'https://i.ytimg.com/vi/' . rawurlencode($video_id) . '/hqdefault.jpg';
        }

        return '';
    }
}

if (! function_exists('gu_scene_archive_template_term_names')) {
    function gu_scene_archive_template_term_names($post_id, $taxonomy) {
        if (function_exists('gu_scene_archive_term_names')) {
            return gu_scene_archive_term_names($post_id, $taxonomy);
        }

        $terms = wp_get_post_terms($post_id, $taxonomy, array('fields' => 'names'));

        if (is_wp_error($terms) || empty($terms)) {
            return array();
        }

        return array_values(array_filter(array_unique($terms)));
    }
}

if (! function_exists('gu_scene_archive_template_source_url')) {
    function gu_scene_archive_template_source_url($post_id) {
        return trim((string) get_post_meta($post_id, 'gu_original_url', true));
    }
}

if (! function_exists('gu_scene_archive_template_record_label')) {
    function gu_scene_archive_template_record_label($post_id, $post_type) {
        if ('scene_video' === $post_type) {
            return 'Performance';
        }

        $types = array_map('sanitize_title', gu_scene_archive_template_term_names($post_id, 'archive_type'));
        $history_topics = gu_scene_archive_template_term_names($post_id, 'history_topic');

        if (in_array('history', $types, true) || ! empty($history_topics)) {
            return 'History Record';
        }

        return 'Archive Record';
    }
}

if (! function_exists('gu_scene_archive_template_record_meta_items')) {
    function gu_scene_archive_template_record_meta_items($post_id, $post_type) {
        if ('scene_video' === $post_type) {
            $items = array(
                gu_scene_archive_template_term_names($post_id, 'scene_artist'),
                gu_scene_archive_template_term_names($post_id, 'scene_venue'),
                gu_scene_archive_template_term_names($post_id, 'scene_genre'),
                gu_scene_archive_template_term_names($post_id, 'scene_year'),
            );
        } else {
            $items = array(
                gu_scene_archive_template_term_names($post_id, 'archive_type'),
                gu_scene_archive_template_term_names($post_id, 'history_topic'),
                gu_scene_archive_template_term_names($post_id, 'scene_area'),
                gu_scene_archive_template_term_names($post_id, 'scene_year'),
            );
        }

        $flattened = array();

        foreach ($items as $group) {
            if (empty($group)) {
                continue;
            }

            $flattened[] = (string) $group[0];
        }

        return array_values(array_filter(array_unique($flattened)));
    }
}

if (! function_exists('gu_scene_archive_template_record_excerpt')) {
    function gu_scene_archive_template_record_excerpt($post_id, $word_count = 24) {
        $excerpt = trim((string) get_post_field('post_excerpt', $post_id));

        if ('' !== $excerpt) {
            return $excerpt;
        }

        $content = wp_strip_all_tags(strip_shortcodes((string) get_post_field('post_content', $post_id)));

        if ('' === trim($content)) {
            return '';
        }

        return wp_trim_words($content, max(8, absint($word_count)));
    }
}

if (! function_exists('gu_scene_archive_template_render_card')) {
    function gu_scene_archive_template_render_card($post_id, $post_type, $args = array()) {
        $args = wp_parse_args(
            $args,
            array(
                'show_excerpt' => true,
                'show_actions' => true,
                'excerpt_words' => 24,
            )
        );

        $record_url = get_permalink($post_id);
        $source_url = gu_scene_archive_template_source_url($post_id);
        $thumb_url = gu_scene_archive_template_record_thumb_url($post_id);
        $meta_items = gu_scene_archive_template_record_meta_items($post_id, $post_type);
        $excerpt = $args['show_excerpt'] ? gu_scene_archive_template_record_excerpt($post_id, $args['excerpt_words']) : '';
        $type_label = gu_scene_archive_template_record_label($post_id, $post_type);

        ob_start();
        ?>
        <article class="gu-scene-library-card gu-scene-card-clickable" data-gu-click-url="<?php echo esc_url($record_url); ?>">
            <?php if ($thumb_url) : ?>
                <a class="gu-scene-library-thumb-link" href="<?php echo esc_url($record_url); ?>">
                    <img class="gu-scene-library-thumb" src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>" loading="lazy">
                </a>
            <?php endif; ?>
            <div class="gu-scene-library-card-body">
                <p class="gu-scene-library-type"><?php echo esc_html($type_label); ?></p>

                <?php if (! empty($meta_items)) : ?>
                    <ul class="gu-scene-library-meta-list">
                        <?php foreach ($meta_items as $meta_item) : ?>
                            <li class="gu-scene-library-meta-item"><?php echo esc_html($meta_item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <h2><a href="<?php echo esc_url($record_url); ?>"><?php echo esc_html(get_the_title($post_id)); ?></a></h2>

                <?php if ($excerpt) : ?>
                    <p><?php echo esc_html($excerpt); ?></p>
                <?php endif; ?>

                <?php if ($args['show_actions']) : ?>
                    <div class="gu-scene-library-actions">
                        <a class="gu-scene-library-link" href="<?php echo esc_url($record_url); ?>">View Record</a>
                        <?php if ($source_url && $source_url !== $record_url) : ?>
                            <a class="gu-scene-library-link gu-scene-library-link-source" href="<?php echo esc_url($source_url); ?>" target="_blank" rel="noopener noreferrer">Open Source</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </article>
        <?php

        return ob_get_clean();
    }
}

if (! function_exists('gu_scene_archive_template_render_term_chips')) {
    function gu_scene_archive_template_render_term_chips($taxonomy, $title, $base_url, $query_key, $limit = 8) {
        $terms = gu_scene_archive_template_get_public_terms(
            $taxonomy,
            array(
                'orderby' => 'count',
                'order' => 'DESC',
                'number' => max(1, absint($limit)),
            )
        );

        if (is_wp_error($terms) || empty($terms)) {
            return '';
        }

        ob_start();
        ?>
        <section class="gu-scene-library-term-group">
            <h2><?php echo esc_html($title); ?></h2>
            <div class="gu-scene-library-term-chips">
                <?php foreach ($terms as $term) : ?>
                    <a class="gu-scene-library-term-chip" href="<?php echo esc_url(add_query_arg($query_key, $term->slug, $base_url)); ?>">
                        <?php echo esc_html($term->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php

        return ob_get_clean();
    }
}

if (! function_exists('gu_scene_archive_render_filter_select')) {
    function gu_scene_archive_render_filter_select($name, $taxonomy, $placeholder) {
        $terms = gu_scene_archive_template_get_public_terms($taxonomy);
        $selected = isset($_GET[$name]) ? sanitize_text_field(wp_unslash($_GET[$name])) : '';

        echo '<label class="gu-scene-filter-field">';
        echo '<span>' . esc_html($placeholder) . '</span>';
        echo '<select name="' . esc_attr($name) . '">';
        echo '<option value="">' . esc_html($placeholder) . '</option>';

        if (! is_wp_error($terms)) {
            foreach ($terms as $term) {
                printf(
                    '<option value="%1$s" %2$s>%3$s</option>',
                    esc_attr($term->slug),
                    selected($selected, $term->slug, false),
                    esc_html($term->name)
                );
            }
        }

        echo '</select>';
        echo '</label>';
    }
}

if (! function_exists('gu_scene_archive_template_get_public_terms')) {
    function gu_scene_archive_template_get_public_terms($taxonomy, $args = array()) {
        $args = wp_parse_args(
            $args,
            array(
                'orderby' => 'name',
                'order' => 'ASC',
                'number' => 0,
                'context' => array(),
            )
        );

        $object_ids = gu_scene_archive_template_get_public_object_ids($taxonomy, $args['context']);

        if (empty($object_ids)) {
            return array();
        }

        $term_args = array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
            'object_ids' => $object_ids,
            'orderby' => $args['orderby'],
            'order' => $args['order'],
        );

        if (! empty($args['number'])) {
            $term_args['number'] = max(1, absint($args['number']));
        }

        $terms = get_terms($term_args);

        if (is_wp_error($terms) || empty($terms)) {
            return array();
        }

        return array_values($terms);
    }
}

if (! function_exists('gu_scene_archive_template_get_public_object_ids')) {
    function gu_scene_archive_template_get_public_object_ids($taxonomy, $context = array()) {
        static $cache = array();

        $resolved_context = gu_scene_archive_template_resolve_term_context($taxonomy, $context);
        $cache_key = md5(wp_json_encode(array($taxonomy, $resolved_context)));

        if (isset($cache[$cache_key])) {
            return $cache[$cache_key];
        }

        $query_args = array(
            'post_type' => $resolved_context['post_types'],
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'no_found_rows' => true,
            'ignore_sticky_posts' => true,
            'meta_query' => array(
                'relation' => 'AND',
                gu_scene_archive_template_build_public_visibility_meta_query(),
            ),
        );

        if (! empty($resolved_context['history_only'])) {
            $query_args['tax_query'] = array(
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
            );
        }

        $query = new WP_Query($query_args);
        $cache[$cache_key] = array_values(array_map('intval', (array) $query->posts));

        return $cache[$cache_key];
    }
}

if (! function_exists('gu_scene_archive_template_resolve_term_context')) {
    function gu_scene_archive_template_resolve_term_context($taxonomy, $context = array()) {
        $resolved = wp_parse_args(
            $context,
            array(
                'post_types' => array(),
                'history_only' => null,
            )
        );

        $resolved['post_types'] = array_values(
            array_filter(
                array_map('sanitize_key', (array) $resolved['post_types'])
            )
        );

        if (empty($resolved['post_types'])) {
            if (get_query_var('gu_scene_history') || is_tax('history_topic')) {
                $resolved['post_types'] = array('archive_item');
                $resolved['history_only'] = true;
            } elseif (is_post_type_archive('archive_item') || is_singular('archive_item') || is_tax('archive_type')) {
                $resolved['post_types'] = array('archive_item');
            } elseif (is_post_type_archive('scene_video') || is_singular('scene_video')) {
                $resolved['post_types'] = array('scene_video');
            } elseif (in_array($taxonomy, array('archive_type', 'history_topic'), true)) {
                $resolved['post_types'] = array('archive_item');
            } else {
                $resolved['post_types'] = array('scene_video', 'archive_item');
            }
        }

        if (null === $resolved['history_only']) {
            $resolved['history_only'] = false;
        }

        return $resolved;
    }
}

if (! function_exists('gu_scene_archive_template_build_public_visibility_meta_query')) {
    function gu_scene_archive_template_build_public_visibility_meta_query() {
        if (class_exists('GU_Scene_Archive_Record_Manager')) {
            return GU_Scene_Archive_Record_Manager::build_public_visibility_meta_query();
        }

        return array(
            'relation' => 'OR',
            array(
                'key' => 'gu_link_status',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key' => 'gu_link_status',
                'value' => array('dead', 'hidden'),
                'compare' => 'NOT IN',
            ),
        );
    }
}
