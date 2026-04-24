<?php

if (! defined('ABSPATH')) {
    exit;
}

class GU_Scene_Archive_Template_Controller {
    public function __construct() {
        add_action('init', array($this, 'register_routes'));
        add_action('pre_get_posts', array($this, 'filter_archive_queries'));
        add_filter('query_vars', array($this, 'register_query_vars'));
        add_filter('template_include', array($this, 'override_template'), 20);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_filter('body_class', array($this, 'filter_body_class'));
        add_filter('wp_robots', array($this, 'filter_wp_robots'));
        add_action('template_redirect', array($this, 'handle_virtual_routes'), 1);
    }

    public function register_routes() {
        add_rewrite_tag('%gu_scene_review_home%', '([^&]+)');
        add_rewrite_tag('%gu_scene_history%', '([^&]+)');
        add_rewrite_rule('^review-home/?$', 'index.php?gu_scene_review_home=1', 'top');
        add_rewrite_rule('^history/?$', 'index.php?gu_scene_history=1', 'top');
    }

    public function register_query_vars($vars) {
        $vars[] = 'gu_scene_review_home';
        $vars[] = 'gu_scene_history';
        return $vars;
    }

    public function override_template($template) {
        if ($this->is_review_home_request()) {
            return $this->can_access_review_home()
                ? GU_SCENE_ARCHIVE_PATH . 'templates/review-home.php'
                : (get_404_template() ?: $template);
        }

        if ($this->is_history_request() || is_tax('history_topic')) {
            return GU_SCENE_ARCHIVE_PATH . 'templates/history-archive.php';
        }

        if (is_post_type_archive('scene_video')) {
            return GU_SCENE_ARCHIVE_PATH . 'templates/archive-scene-video.php';
        }

        if (is_post_type_archive('archive_item')) {
            return GU_SCENE_ARCHIVE_PATH . 'templates/archive-archive-item.php';
        }

        if (is_singular('scene_video')) {
            return GU_SCENE_ARCHIVE_PATH . 'templates/single-scene-video.php';
        }

        if (is_singular('archive_item')) {
            return GU_SCENE_ARCHIVE_PATH . 'templates/single-archive-item.php';
        }

        return $template;
    }

    public function enqueue_assets() {
        if ($this->is_review_home_request() && $this->can_access_review_home()) {
            $review_css = GU_SCENE_ARCHIVE_PATH . 'assets/css/review-home.css';
            $card_links_js = GU_SCENE_ARCHIVE_PATH . 'assets/css/card-links.js';

            wp_enqueue_style(
                'gu-scene-archive-review',
                GU_SCENE_ARCHIVE_URL . 'assets/css/review-home.css',
                array(),
                file_exists($review_css) ? (string) filemtime($review_css) : GU_SCENE_ARCHIVE_VERSION
            );

            wp_enqueue_script(
                'gu-scene-archive-card-links',
                GU_SCENE_ARCHIVE_URL . 'assets/css/card-links.js',
                array(),
                file_exists($card_links_js) ? (string) filemtime($card_links_js) : GU_SCENE_ARCHIVE_VERSION,
                true
            );
        }

        if (
            is_post_type_archive('scene_video')
            || is_post_type_archive('archive_item')
            || is_singular('scene_video')
            || is_singular('archive_item')
            || $this->is_history_request()
            || is_tax('history_topic')
        ) {
            $archive_css = GU_SCENE_ARCHIVE_PATH . 'assets/css/archive.css';
            $card_links_js = GU_SCENE_ARCHIVE_PATH . 'assets/css/card-links.js';

            wp_enqueue_style(
                'gu-scene-archive-library',
                GU_SCENE_ARCHIVE_URL . 'assets/css/archive.css',
                array(),
                file_exists($archive_css) ? (string) filemtime($archive_css) : GU_SCENE_ARCHIVE_VERSION
            );

            wp_enqueue_script(
                'gu-scene-archive-card-links',
                GU_SCENE_ARCHIVE_URL . 'assets/css/card-links.js',
                array(),
                file_exists($card_links_js) ? (string) filemtime($card_links_js) : GU_SCENE_ARCHIVE_VERSION,
                true
            );
        }
    }

    public function filter_body_class($classes) {
        if ($this->is_review_home_request() && $this->can_access_review_home()) {
            $classes[] = 'gu-scene-review-home';
        }

        if ($this->is_history_request() || is_tax('history_topic')) {
            $classes[] = 'gu-scene-history-archive';
        }

        return $classes;
    }

    public function filter_wp_robots($robots) {
        if ($this->is_review_home_request()) {
            $robots['noindex'] = true;
            $robots['nofollow'] = true;
        }

        if ($this->is_history_request() && ! $this->should_index_archive_routes()) {
            $robots['noindex'] = true;
            $robots['nofollow'] = true;
        }

        return $robots;
    }

    public function handle_virtual_routes() {
        if ($this->is_review_home_request()) {
            if (! $this->can_access_review_home()) {
                $this->render_404_response();
            }

            $this->mark_virtual_route_as_found();
            return;
        }

        if ($this->is_history_request()) {
            $this->mark_virtual_route_as_found();
            return;
        }

        if ($this->should_404_empty_history_topic_route()) {
            $this->render_404_response();
        }
    }

    public function filter_archive_queries($query) {
        if (is_admin() || ! $query->is_main_query()) {
            return;
        }

        if ($query->is_post_type_archive('scene_video')) {
            $tax_query = $this->build_tax_query(
                array(
                    'area' => 'scene_area',
                    'genre' => 'scene_genre',
                    'artist' => 'scene_artist',
                    'venue' => 'scene_venue',
                    'source' => 'scene_source',
                    'year' => 'scene_year',
                )
            );

            if (! empty($tax_query)) {
                $query->set('tax_query', $tax_query);
            }

            $query->set(
                'meta_query',
                array(
                    'relation' => 'AND',
                    GU_Scene_Archive_Record_Manager::build_public_visibility_meta_query(),
                )
            );
            $query->set('posts_per_page', 12);
        }

        if ($query->is_post_type_archive('archive_item')) {
            $tax_query = $this->build_tax_query(
                array(
                    'area' => 'scene_area',
                    'year' => 'scene_year',
                    'archive_type' => 'archive_type',
                    'history_topic' => 'history_topic',
                )
            );

            if (! empty($tax_query)) {
                $query->set('tax_query', $tax_query);
            }

            $query->set(
                'meta_query',
                array(
                    'relation' => 'AND',
                    GU_Scene_Archive_Record_Manager::build_public_visibility_meta_query(),
                )
            );
            $query->set('posts_per_page', 12);
        }

        if ($query->is_tax('history_topic')) {
            $query->set(
                'meta_query',
                array(
                    'relation' => 'AND',
                    GU_Scene_Archive_Record_Manager::build_public_visibility_meta_query(),
                )
            );
            $query->set('posts_per_page', 12);
        }
    }

    private function is_review_home_request() {
        if (get_query_var('gu_scene_review_home')) {
            return true;
        }

        $path = wp_parse_url(home_url(add_query_arg(array())), PHP_URL_PATH);
        $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) wp_unslash($_SERVER['REQUEST_URI']) : '';
        $request_path = trim((string) wp_parse_url($request_uri, PHP_URL_PATH), '/');

        if ($path) {
            $base = trim((string) $path, '/');

            if ($base && 0 === strpos($request_path, $base . '/')) {
                $request_path = trim(substr($request_path, strlen($base)), '/');
            }
        }

        return 'review-home' === $request_path;
    }

    private function can_access_review_home() {
        return is_user_logged_in() && current_user_can('manage_options');
    }

    private function is_history_request() {
        if (get_query_var('gu_scene_history')) {
            return true;
        }

        $path = wp_parse_url(home_url(add_query_arg(array())), PHP_URL_PATH);
        $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) wp_unslash($_SERVER['REQUEST_URI']) : '';
        $request_path = trim((string) wp_parse_url($request_uri, PHP_URL_PATH), '/');

        if ($path) {
            $base = trim((string) $path, '/');

            if ($base && 0 === strpos($request_path, $base . '/')) {
                $request_path = trim(substr($request_path, strlen($base)), '/');
            }
        }

        return 'history' === $request_path;
    }

    private function should_index_archive_routes() {
        return ! empty(GU_Scene_Archive_Settings::get('index_scene_archive_publicly'));
    }

    private function mark_virtual_route_as_found() {
        global $wp_query;

        if (isset($wp_query->is_404)) {
            $wp_query->is_404 = false;
        }

        status_header(200);
    }

    private function render_404_response() {
        global $wp_query;

        if ($wp_query instanceof WP_Query) {
            $wp_query->set_404();
        }

        status_header(404);
        nocache_headers();

        $template = get_404_template();

        if ($template) {
            include $template;
        } else {
            wp_die('Not found', 'Not found', array('response' => 404));
        }

        exit;
    }

    private function should_404_empty_history_topic_route() {
        if (! is_tax('history_topic')) {
            return false;
        }

        $term = get_queried_object();

        if (! ($term instanceof WP_Term)) {
            return false;
        }

        return ! $this->history_topic_has_public_records($term);
    }

    private function history_topic_has_public_records(WP_Term $term) {
        $query = new WP_Query(
            array(
                'post_type' => 'archive_item',
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'fields' => 'ids',
                'no_found_rows' => true,
                'ignore_sticky_posts' => true,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'history_topic',
                        'field' => 'term_id',
                        'terms' => array((int) $term->term_id),
                    ),
                ),
                'meta_query' => array(
                    'relation' => 'AND',
                    GU_Scene_Archive_Record_Manager::build_public_visibility_meta_query(),
                ),
            )
        );

        return $query->have_posts();
    }

    private function build_tax_query($map) {
        $tax_query = array();

        foreach ($map as $request_key => $taxonomy) {
            if (empty($_GET[$request_key])) {
                continue;
            }

            $tax_query[] = array(
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => sanitize_title(wp_unslash($_GET[$request_key])),
            );
        }

        if (count($tax_query) > 1) {
            $tax_query['relation'] = 'AND';
        }

        return $tax_query;
    }
}
