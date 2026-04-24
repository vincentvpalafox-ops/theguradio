<?php

if (! defined('ABSPATH')) {
    exit;
}

class GU_Scene_Archive_Maintenance {
    const CRON_HOOK = 'gu_scene_archive_validate_links';
    const STATE_OPTION = 'gu_scene_archive_maintenance_state';

    public function __construct() {
        add_filter('cron_schedules', array($this, 'register_cron_schedule'));
        add_action(self::CRON_HOOK, array($this, 'run_scheduled_validation'));

        if (is_admin()) {
            add_action('admin_post_gu_scene_archive_run_validation', array($this, 'handle_manual_validation'));
            add_action('admin_post_gu_scene_archive_run_archive_audit', array($this, 'handle_manual_archive_audit'));
            add_action('admin_post_gu_scene_archive_normalize_terms', array($this, 'handle_normalize_terms'));
            add_action('admin_post_gu_scene_archive_normalize_homepage_archive_metadata', array($this, 'handle_normalize_homepage_archive_metadata'));
            add_action('admin_post_gu_scene_archive_clear_caches', array($this, 'handle_clear_caches'));
        }
    }

    public static function activate() {
        self::schedule_validation();
    }

    public static function deactivate() {
        wp_clear_scheduled_hook(self::CRON_HOOK);
    }

    public static function get_state() {
        return wp_parse_args(
            get_option(
                self::STATE_OPTION,
                array(
                    'last_validation_started_at' => '',
                    'last_validation_completed_at' => '',
                    'last_validation_summary' => array(),
                    'last_archive_audit_started_at' => '',
                    'last_archive_audit_completed_at' => '',
                    'last_archive_audit_summary' => array(),
                    'last_taxonomy_collision_summary' => array(),
                    'last_taxonomy_normalization_at' => '',
                    'last_taxonomy_normalization_summary' => array(),
                    'last_homepage_archive_metadata_normalization_at' => '',
                    'last_homepage_archive_metadata_normalization_summary' => array(),
                    'last_homepage_archive_metadata_normalization_details' => array(),
                    'last_cache_clear_at' => '',
                )
            ),
            array(
                'last_validation_started_at' => '',
                'last_validation_completed_at' => '',
                'last_validation_summary' => array(),
                'last_archive_audit_started_at' => '',
                'last_archive_audit_completed_at' => '',
                'last_archive_audit_summary' => array(),
                'last_taxonomy_collision_summary' => array(),
                'last_taxonomy_normalization_at' => '',
                'last_taxonomy_normalization_summary' => array(),
                'last_homepage_archive_metadata_normalization_at' => '',
                'last_homepage_archive_metadata_normalization_summary' => array(),
                'last_homepage_archive_metadata_normalization_details' => array(),
                'last_cache_clear_at' => '',
            )
        );
    }

    public static function render_admin_panel() {
        $state = self::get_state();
        $counts = array(
            'scene_video' => wp_count_posts('scene_video'),
            'archive_item' => wp_count_posts('archive_item'),
        );
        $validation_summary = isset($state['last_validation_summary']) && is_array($state['last_validation_summary']) ? $state['last_validation_summary'] : array();
        $audit_summary = isset($state['last_archive_audit_summary']) && is_array($state['last_archive_audit_summary']) ? $state['last_archive_audit_summary'] : array();
        $collision_summary = isset($state['last_taxonomy_collision_summary']) && is_array($state['last_taxonomy_collision_summary']) ? $state['last_taxonomy_collision_summary'] : array();
        $normalization_summary = isset($state['last_taxonomy_normalization_summary']) && is_array($state['last_taxonomy_normalization_summary']) ? $state['last_taxonomy_normalization_summary'] : array();
        $homepage_metadata_summary = isset($state['last_homepage_archive_metadata_normalization_summary']) && is_array($state['last_homepage_archive_metadata_normalization_summary']) ? $state['last_homepage_archive_metadata_normalization_summary'] : array();
        $homepage_metadata_details = isset($state['last_homepage_archive_metadata_normalization_details']) && is_array($state['last_homepage_archive_metadata_normalization_details']) ? $state['last_homepage_archive_metadata_normalization_details'] : array();
        ?>
        <hr>
        <h2>Maintenance Tools</h2>
        <p>Use these actions to validate stored source links, audit archive depth, normalize taxonomy drift, and clear cached provider queries without changing the public homepage structure.</p>

        <table class="widefat striped" style="max-width: 980px; margin: 16px 0 24px;">
            <tbody>
                <tr>
                    <th style="width: 320px;">Published Scene Videos</th>
                    <td><?php echo esc_html((string) (isset($counts['scene_video']->publish) ? $counts['scene_video']->publish : 0)); ?></td>
                </tr>
                <tr>
                    <th>Published Archive Items</th>
                    <td><?php echo esc_html((string) (isset($counts['archive_item']->publish) ? $counts['archive_item']->publish : 0)); ?></td>
                </tr>
                <tr>
                    <th>Last Validation Started</th>
                    <td><?php echo self::format_state_timestamp(isset($state['last_validation_started_at']) ? $state['last_validation_started_at'] : ''); ?></td>
                </tr>
                <tr>
                    <th>Last Validation Completed</th>
                    <td><?php echo self::format_state_timestamp(isset($state['last_validation_completed_at']) ? $state['last_validation_completed_at'] : ''); ?></td>
                </tr>
                <tr>
                    <th>Last Archive Audit Started</th>
                    <td><?php echo self::format_state_timestamp(isset($state['last_archive_audit_started_at']) ? $state['last_archive_audit_started_at'] : ''); ?></td>
                </tr>
                <tr>
                    <th>Last Archive Audit Completed</th>
                    <td><?php echo self::format_state_timestamp(isset($state['last_archive_audit_completed_at']) ? $state['last_archive_audit_completed_at'] : ''); ?></td>
                </tr>
                <tr>
                    <th>Last Taxonomy Normalization</th>
                    <td><?php echo self::format_state_timestamp(isset($state['last_taxonomy_normalization_at']) ? $state['last_taxonomy_normalization_at'] : ''); ?></td>
                </tr>
                <tr>
                    <th>Last Homepage Archive Metadata Normalization</th>
                    <td><?php echo self::format_state_timestamp(isset($state['last_homepage_archive_metadata_normalization_at']) ? $state['last_homepage_archive_metadata_normalization_at'] : ''); ?></td>
                </tr>
                <tr>
                    <th>Last Cache Clear</th>
                    <td><?php echo self::format_state_timestamp(isset($state['last_cache_clear_at']) ? $state['last_cache_clear_at'] : ''); ?></td>
                </tr>
            </tbody>
        </table>

        <?php if (! empty($validation_summary)) : ?>
            <h3>Link Validation Summary</h3>
            <?php self::render_key_value_summary_table(
                $validation_summary,
                array(
                    'total' => 'Total Checked',
                    'live' => 'Live',
                    'warning' => 'Warning',
                    'dead' => 'Dead',
                    'skipped' => 'Skipped',
                )
            ); ?>
        <?php endif; ?>

        <?php if (! empty($audit_summary)) : ?>
            <h3>Archive Audit Summary</h3>
            <?php self::render_key_value_summary_table(
                $audit_summary,
                array(
                    'total_records' => 'Total Published Records',
                    'scene_video_records' => 'Scene Videos',
                    'archive_item_records' => 'Archive Items',
                    'missing_original_url' => 'Missing Source URL',
                    'invalid_original_url' => 'Invalid Source URL',
                    'missing_excerpt' => 'Missing Excerpt',
                    'missing_thumbnail' => 'Missing Thumbnail',
                    'missing_year' => 'Missing Year',
                    'thin_records' => 'Thin Records',
                    'archive_items_missing_archive_type' => 'Archive Items Missing Type',
                    'history_records_missing_history_topic' => 'History Records Missing Topic',
                    'history_topic_without_history_type' => 'History Topic Without History Type',
                    'duplicate_original_url_groups' => 'Duplicate Source URL Groups',
                    'duplicate_original_url_records' => 'Duplicate Source URL Records',
                    'duplicate_title_groups' => 'Duplicate Title Groups',
                    'duplicate_title_records' => 'Duplicate Title Records',
                    'taxonomy_collision_groups' => 'Taxonomy Collision Groups',
                )
            ); ?>
        <?php endif; ?>

        <?php if (! empty($collision_summary)) : ?>
            <h3>Taxonomy Collision Review</h3>
            <p>Normalization merges only formatting-equivalent terms such as case, punctuation, spacing, or ampersand variations. It does not invent new taxonomy names.</p>
            <?php self::render_collision_table($collision_summary); ?>
        <?php endif; ?>

        <?php if (! empty($normalization_summary)) : ?>
            <h3>Last Taxonomy Normalization</h3>
            <?php self::render_key_value_summary_table(
                $normalization_summary,
                array(
                    'groups_processed' => 'Collision Groups Processed',
                    'taxonomies_touched' => 'Taxonomies Touched',
                    'terms_merged' => 'Terms Merged',
                    'relationships_migrated' => 'Relationships Migrated',
                    'history_backfills' => 'History Type Backfills',
                )
            ); ?>
        <?php endif; ?>

        <?php if (! empty($homepage_metadata_summary)) : ?>
            <h3>Last Homepage Archive Metadata Normalization</h3>
            <p>Only homepage-supporting archive items are touched here. Source labels are backfilled from canonical source URLs only, and missing history topics are reported but never guessed.</p>
            <?php self::render_key_value_summary_table(
                $homepage_metadata_summary,
                array(
                    'records_considered' => 'Homepage Archive Records Considered',
                    'records_updated' => 'Records Updated',
                    'source_backfills' => 'Source Labels Backfilled',
                    'source_skipped_existing' => 'Source Labels Already Present',
                    'source_skipped_no_url' => 'Source Labels Blocked By Missing URL',
                    'source_skipped_unknown_host' => 'Source Labels Blocked By Unsupported Host',
                    'history_topic_evidence_blocked' => 'History Topics Still Evidence-Blocked',
                )
            ); ?>
        <?php endif; ?>

        <?php if (! empty($homepage_metadata_details)) : ?>
            <h3>Homepage Archive Metadata Review</h3>
            <p>These are the exact homepage-supporting archive records considered during the last normalization run and whether each one was changed or left evidence-blocked.</p>
            <?php self::render_homepage_metadata_detail_table($homepage_metadata_details); ?>
        <?php endif; ?>

        <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom: 20px;">
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('gu_scene_archive_run_validation'); ?>
                <input type="hidden" name="action" value="gu_scene_archive_run_validation">
                <?php submit_button('Run Link Validation Now', 'secondary', '', false); ?>
            </form>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('gu_scene_archive_run_archive_audit'); ?>
                <input type="hidden" name="action" value="gu_scene_archive_run_archive_audit">
                <?php submit_button('Run Archive Audit', 'secondary', '', false); ?>
            </form>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('gu_scene_archive_normalize_terms'); ?>
                <input type="hidden" name="action" value="gu_scene_archive_normalize_terms">
                <?php submit_button('Normalize Duplicate Terms', 'secondary', '', false); ?>
            </form>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('gu_scene_archive_normalize_homepage_archive_metadata'); ?>
                <input type="hidden" name="action" value="gu_scene_archive_normalize_homepage_archive_metadata">
                <?php submit_button('Normalize Homepage Archive Metadata', 'secondary', '', false); ?>
            </form>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('gu_scene_archive_clear_caches'); ?>
                <input type="hidden" name="action" value="gu_scene_archive_clear_caches">
                <?php submit_button('Clear Search Caches', 'secondary', '', false); ?>
            </form>
        </div>
        <?php
    }

    public function register_cron_schedule($schedules) {
        if (! isset($schedules['gu_weekly'])) {
            $schedules['gu_weekly'] = array(
                'interval' => WEEK_IN_SECONDS,
                'display' => 'Once Weekly',
            );
        }

        return $schedules;
    }

    public function run_scheduled_validation() {
        $this->validate_records();
    }

    public function handle_manual_validation() {
        if (! current_user_can(function_exists('gu_scene_archive_admin_capability') ? gu_scene_archive_admin_capability() : 'activate_plugins')) {
            wp_die('Sorry, you are not allowed to do that.');
        }

        check_admin_referer('gu_scene_archive_run_validation');
        $this->validate_records();

        wp_safe_redirect($this->get_admin_redirect_url());
        exit;
    }

    public function handle_manual_archive_audit() {
        if (! current_user_can(function_exists('gu_scene_archive_admin_capability') ? gu_scene_archive_admin_capability() : 'activate_plugins')) {
            wp_die('Sorry, you are not allowed to do that.');
        }

        check_admin_referer('gu_scene_archive_run_archive_audit');
        $this->run_archive_audit();

        wp_safe_redirect($this->get_admin_redirect_url());
        exit;
    }

    public function handle_normalize_terms() {
        if (! current_user_can(function_exists('gu_scene_archive_admin_capability') ? gu_scene_archive_admin_capability() : 'activate_plugins')) {
            wp_die('Sorry, you are not allowed to do that.');
        }

        check_admin_referer('gu_scene_archive_normalize_terms');
        $summary = $this->normalize_duplicate_terms();

        $state = self::get_state();
        $state['last_taxonomy_normalization_at'] = current_time('mysql', true);
        $state['last_taxonomy_normalization_summary'] = $summary;
        update_option(self::STATE_OPTION, $state, false);

        $this->run_archive_audit();

        wp_safe_redirect($this->get_admin_redirect_url());
        exit;
    }

    public function handle_normalize_homepage_archive_metadata() {
        if (! current_user_can(function_exists('gu_scene_archive_admin_capability') ? gu_scene_archive_admin_capability() : 'activate_plugins')) {
            wp_die('Sorry, you are not allowed to do that.');
        }

        check_admin_referer('gu_scene_archive_normalize_homepage_archive_metadata');
        $result = $this->normalize_homepage_archive_metadata();

        $state = self::get_state();
        $state['last_homepage_archive_metadata_normalization_at'] = current_time('mysql', true);
        $state['last_homepage_archive_metadata_normalization_summary'] = isset($result['summary']) && is_array($result['summary']) ? $result['summary'] : array();
        $state['last_homepage_archive_metadata_normalization_details'] = isset($result['details']) && is_array($result['details']) ? $result['details'] : array();
        update_option(self::STATE_OPTION, $state, false);

        $this->run_archive_audit();

        wp_safe_redirect($this->get_admin_redirect_url());
        exit;
    }

    public function handle_clear_caches() {
        if (! current_user_can(function_exists('gu_scene_archive_admin_capability') ? gu_scene_archive_admin_capability() : 'activate_plugins')) {
            wp_die('Sorry, you are not allowed to do that.');
        }

        check_admin_referer('gu_scene_archive_clear_caches');
        $this->clear_provider_caches();

        $state = self::get_state();
        $state['last_cache_clear_at'] = current_time('mysql', true);
        update_option(self::STATE_OPTION, $state, false);

        wp_safe_redirect($this->get_admin_redirect_url());
        exit;
    }

    private static function schedule_validation() {
        if (! wp_next_scheduled(self::CRON_HOOK)) {
            wp_schedule_event(time() + HOUR_IN_SECONDS, 'gu_weekly', self::CRON_HOOK);
        }
    }

    private static function format_state_timestamp($value) {
        return ! empty($value) ? esc_html((string) $value) : 'Never';
    }

    private static function render_key_value_summary_table($summary, $labels) {
        ?>
        <table class="widefat striped" style="max-width: 980px; margin: 0 0 24px;">
            <tbody>
                <?php foreach ($labels as $key => $label) : ?>
                    <tr>
                        <th style="width: 320px;"><?php echo esc_html($label); ?></th>
                        <td><?php echo esc_html((string) (isset($summary[$key]) ? $summary[$key] : 0)); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    private static function render_collision_table($collisions) {
        ?>
        <table class="widefat striped" style="max-width: 1180px; margin: 0 0 24px;">
            <thead>
                <tr>
                    <th>Taxonomy</th>
                    <th>Canonical Term</th>
                    <th>Merge Candidates</th>
                    <th>Total Terms</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($collisions, 0, 30) as $collision) : ?>
                    <tr>
                        <td><?php echo esc_html(isset($collision['taxonomy_label']) ? $collision['taxonomy_label'] : $collision['taxonomy']); ?></td>
                        <td><?php echo esc_html(isset($collision['canonical_name']) ? $collision['canonical_name'] : ''); ?></td>
                        <td><?php echo esc_html(implode(', ', isset($collision['merge_names']) ? (array) $collision['merge_names'] : array())); ?></td>
                        <td><?php echo esc_html((string) (isset($collision['term_count']) ? $collision['term_count'] : 0)); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    private static function render_homepage_metadata_detail_table($details) {
        ?>
        <table class="widefat striped" style="max-width: 1180px; margin: 0 0 24px;">
            <thead>
                <tr>
                    <th>Record</th>
                    <th>Homepage Role</th>
                    <th>Source Result</th>
                    <th>History Topic Result</th>
                    <th>Host Evidence</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ((array) $details as $detail) : ?>
                    <tr>
                        <td>
                            <?php if (! empty($detail['edit_url'])) : ?>
                                <a href="<?php echo esc_url((string) $detail['edit_url']); ?>"><?php echo esc_html(isset($detail['title']) ? (string) $detail['title'] : 'Untitled'); ?></a>
                            <?php else : ?>
                                <?php echo esc_html(isset($detail['title']) ? (string) $detail['title'] : 'Untitled'); ?>
                            <?php endif; ?>
                        </td>
                        <td><?php echo esc_html(isset($detail['homepage_role']) ? (string) $detail['homepage_role'] : ''); ?></td>
                        <td><?php echo esc_html(isset($detail['source_result']) ? (string) $detail['source_result'] : ''); ?></td>
                        <td><?php echo esc_html(isset($detail['history_result']) ? (string) $detail['history_result'] : ''); ?></td>
                        <td><?php echo esc_html(isset($detail['host_evidence']) ? (string) $detail['host_evidence'] : ''); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    private function validate_records() {
        $state = self::get_state();
        $state['last_validation_started_at'] = current_time('mysql', true);
        update_option(self::STATE_OPTION, $state, false);

        $query = new WP_Query(
            array(
                'post_type' => GU_Scene_Archive_Record_Manager::get_supported_post_types(),
                'post_status' => 'publish',
                'posts_per_page' => 200,
                'fields' => 'ids',
                'no_found_rows' => true,
                'meta_query' => array(
                    array(
                        'key' => 'gu_original_url',
                        'compare' => 'EXISTS',
                    ),
                ),
            )
        );

        $summary = array(
            'total' => 0,
            'live' => 0,
            'warning' => 0,
            'dead' => 0,
            'skipped' => 0,
        );

        foreach ((array) $query->posts as $post_id) {
            $status = $this->validate_record((int) $post_id);

            if ('skipped' === $status) {
                ++$summary['skipped'];
                continue;
            }

            ++$summary['total'];

            if (isset($summary[$status])) {
                ++$summary[$status];
            }
        }

        $state['last_validation_completed_at'] = current_time('mysql', true);
        $state['last_validation_summary'] = $summary;
        update_option(self::STATE_OPTION, $state, false);
    }

    private function run_archive_audit() {
        $state = self::get_state();
        $state['last_archive_audit_started_at'] = current_time('mysql', true);
        update_option(self::STATE_OPTION, $state, false);

        $query = new WP_Query(
            array(
                'post_type' => GU_Scene_Archive_Record_Manager::get_supported_post_types(),
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'orderby' => 'date',
                'order' => 'DESC',
                'no_found_rows' => true,
            )
        );

        $summary = array(
            'total_records' => 0,
            'scene_video_records' => 0,
            'archive_item_records' => 0,
            'missing_original_url' => 0,
            'invalid_original_url' => 0,
            'missing_excerpt' => 0,
            'missing_thumbnail' => 0,
            'missing_year' => 0,
            'thin_records' => 0,
            'archive_items_missing_archive_type' => 0,
            'history_records_missing_history_topic' => 0,
            'history_topic_without_history_type' => 0,
            'duplicate_original_url_groups' => 0,
            'duplicate_original_url_records' => 0,
            'duplicate_title_groups' => 0,
            'duplicate_title_records' => 0,
            'taxonomy_collision_groups' => 0,
        );

        $url_index = array();
        $title_index = array();

        foreach ((array) $query->posts as $post_id) {
            $post_id = (int) $post_id;
            $post = get_post($post_id);

            if (! $post instanceof WP_Post) {
                continue;
            }

            ++$summary['total_records'];

            if ('scene_video' === $post->post_type) {
                ++$summary['scene_video_records'];
            } elseif ('archive_item' === $post->post_type) {
                ++$summary['archive_item_records'];
            }

            $original_url = trim((string) get_post_meta($post_id, 'gu_original_url', true));

            if ('' === $original_url) {
                ++$summary['missing_original_url'];
            } elseif (! wp_http_validate_url($original_url)) {
                ++$summary['invalid_original_url'];
            } else {
                $normalized_url = $this->normalize_url_for_compare($original_url);

                if ('' !== $normalized_url) {
                    if (! isset($url_index[$normalized_url])) {
                        $url_index[$normalized_url] = array();
                    }

                    $url_index[$normalized_url][] = $post_id;
                }
            }

            $excerpt = trim((string) get_post_field('post_excerpt', $post_id));
            $content = trim(wp_strip_all_tags(strip_shortcodes((string) get_post_field('post_content', $post_id))));

            if ('' === $excerpt) {
                ++$summary['missing_excerpt'];
            }

            if (! $this->record_has_thumbnail($post_id)) {
                ++$summary['missing_thumbnail'];
            }

            if (empty($this->get_post_term_slugs($post_id, 'scene_year'))) {
                ++$summary['missing_year'];
            }

            if ('' === $excerpt && '' === $content && ! $this->record_has_thumbnail($post_id)) {
                ++$summary['thin_records'];
            }

            if ('archive_item' === $post->post_type) {
                $archive_types = $this->get_post_term_slugs($post_id, 'archive_type');
                $history_topics = $this->get_post_term_slugs($post_id, 'history_topic');

                if (empty($archive_types)) {
                    ++$summary['archive_items_missing_archive_type'];
                }

                if (! empty($history_topics) && ! in_array('history', $archive_types, true)) {
                    ++$summary['history_topic_without_history_type'];
                }

                if (in_array('history', $archive_types, true) && empty($history_topics)) {
                    ++$summary['history_records_missing_history_topic'];
                }
            }

            $normalized_title = $this->normalize_term_name((string) get_the_title($post_id));

            if ('' !== $normalized_title) {
                if (! isset($title_index[$normalized_title])) {
                    $title_index[$normalized_title] = array();
                }

                $title_index[$normalized_title][] = $post_id;
            }
        }

        $summary['duplicate_original_url_groups'] = $this->count_duplicate_groups($url_index);
        $summary['duplicate_original_url_records'] = $this->count_duplicate_records($url_index);
        $summary['duplicate_title_groups'] = $this->count_duplicate_groups($title_index);
        $summary['duplicate_title_records'] = $this->count_duplicate_records($title_index);

        $collisions = $this->build_taxonomy_collision_summary();
        $summary['taxonomy_collision_groups'] = count($collisions);

        $state['last_archive_audit_completed_at'] = current_time('mysql', true);
        $state['last_archive_audit_summary'] = $summary;
        $state['last_taxonomy_collision_summary'] = $collisions;
        update_option(self::STATE_OPTION, $state, false);

        return $summary;
    }

    private function normalize_duplicate_terms() {
        $summary = array(
            'groups_processed' => 0,
            'taxonomies_touched' => 0,
            'terms_merged' => 0,
            'relationships_migrated' => 0,
            'history_backfills' => 0,
        );
        $collisions = $this->build_taxonomy_collision_summary();
        $touched_taxonomies = array();

        if (function_exists('wp_defer_term_counting')) {
            wp_defer_term_counting(true);
        }

        foreach ($collisions as $collision) {
            $taxonomy = isset($collision['taxonomy']) ? (string) $collision['taxonomy'] : '';
            $canonical_id = isset($collision['canonical_id']) ? (int) $collision['canonical_id'] : 0;
            $merge_ids = isset($collision['merge_ids']) ? array_map('intval', (array) $collision['merge_ids']) : array();

            if ('' === $taxonomy || $canonical_id <= 0 || empty($merge_ids)) {
                continue;
            }

            ++$summary['groups_processed'];
            $touched_taxonomies[$taxonomy] = true;

            foreach ($merge_ids as $duplicate_id) {
                if ($duplicate_id <= 0 || $duplicate_id === $canonical_id) {
                    continue;
                }

                $object_ids = wp_get_objects_in_term($duplicate_id, $taxonomy);

                if (! is_wp_error($object_ids) && ! empty($object_ids)) {
                    foreach (array_unique(array_map('intval', $object_ids)) as $object_id) {
                        if ($object_id <= 0) {
                            continue;
                        }

                        wp_add_object_terms($object_id, array($canonical_id), $taxonomy);
                        ++$summary['relationships_migrated'];
                    }
                }

                $deleted = wp_delete_term($duplicate_id, $taxonomy);

                if (! is_wp_error($deleted) && $deleted) {
                    ++$summary['terms_merged'];
                }
            }
        }

        if (function_exists('wp_defer_term_counting')) {
            wp_defer_term_counting(false);
        }

        $summary['taxonomies_touched'] = count($touched_taxonomies);
        $summary['history_backfills'] = $this->backfill_history_archive_terms();

        return $summary;
    }

    private function build_taxonomy_collision_summary() {
        $collisions = array();

        foreach ($this->get_audit_taxonomies() as $taxonomy) {
            if (! taxonomy_exists($taxonomy)) {
                continue;
            }

            $terms = get_terms(
                array(
                    'taxonomy' => $taxonomy,
                    'hide_empty' => false,
                )
            );

            if (is_wp_error($terms) || empty($terms)) {
                continue;
            }

            $groups = array();

            foreach ($terms as $term) {
                $normalized_name = $this->normalize_term_name($term->name);

                if ('' === $normalized_name) {
                    continue;
                }

                $group_key = $taxonomy . '|' . $normalized_name;

                if (is_taxonomy_hierarchical($taxonomy)) {
                    $group_key .= '|parent:' . (int) $term->parent;
                }

                if (! isset($groups[$group_key])) {
                    $groups[$group_key] = array();
                }

                $groups[$group_key][] = $term;
            }

            foreach ($groups as $group_key => $group_terms) {
                if (count($group_terms) < 2) {
                    continue;
                }

                usort($group_terms, array($this, 'sort_terms_for_normalization'));
                $canonical = array_shift($group_terms);

                $collisions[] = array(
                    'taxonomy' => $taxonomy,
                    'taxonomy_label' => $this->get_taxonomy_label($taxonomy),
                    'group_key' => $group_key,
                    'canonical_id' => (int) $canonical->term_id,
                    'canonical_name' => (string) $canonical->name,
                    'merge_ids' => array_map(
                        'intval',
                        wp_list_pluck($group_terms, 'term_id')
                    ),
                    'merge_names' => array_map(
                        'strval',
                        wp_list_pluck($group_terms, 'name')
                    ),
                    'term_count' => count($group_terms) + 1,
                );
            }
        }

        usort(
            $collisions,
            function ($left, $right) {
                $left_count = isset($left['term_count']) ? (int) $left['term_count'] : 0;
                $right_count = isset($right['term_count']) ? (int) $right['term_count'] : 0;

                if ($left_count !== $right_count) {
                    return $right_count <=> $left_count;
                }

                $left_name = isset($left['canonical_name']) ? (string) $left['canonical_name'] : '';
                $right_name = isset($right['canonical_name']) ? (string) $right['canonical_name'] : '';

                return strcasecmp($left_name, $right_name);
            }
        );

        return $collisions;
    }

    private function sort_terms_for_normalization($left, $right) {
        $left_count = isset($left->count) ? (int) $left->count : 0;
        $right_count = isset($right->count) ? (int) $right->count : 0;

        if ($left_count !== $right_count) {
            return $right_count <=> $left_count;
        }

        $left_name = isset($left->name) ? (string) $left->name : '';
        $right_name = isset($right->name) ? (string) $right->name : '';

        $name_comparison = strcasecmp($left_name, $right_name);

        if (0 !== $name_comparison) {
            return $name_comparison;
        }

        $left_id = isset($left->term_id) ? (int) $left->term_id : 0;
        $right_id = isset($right->term_id) ? (int) $right->term_id : 0;

        return $left_id <=> $right_id;
    }

    private function backfill_history_archive_terms() {
        if (! taxonomy_exists('history_topic') || ! taxonomy_exists('archive_type')) {
            return 0;
        }

        $history_term = term_exists('history', 'archive_type');

        if (! $history_term) {
            $history_term = wp_insert_term('History', 'archive_type', array('slug' => 'history'));
        }

        if (is_wp_error($history_term)) {
            return 0;
        }

        $history_term_id = isset($history_term['term_id']) ? (int) $history_term['term_id'] : (int) $history_term;

        if ($history_term_id <= 0) {
            return 0;
        }

        $query = new WP_Query(
            array(
                'post_type' => 'archive_item',
                'post_status' => 'any',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'history_topic',
                        'operator' => 'EXISTS',
                    ),
                ),
                'no_found_rows' => true,
            )
        );

        $updated = 0;

        foreach ((array) $query->posts as $post_id) {
            $post_id = (int) $post_id;
            $assigned_types = $this->get_post_term_slugs($post_id, 'archive_type');

            if (in_array('history', $assigned_types, true)) {
                continue;
            }

            wp_set_object_terms($post_id, array($history_term_id), 'archive_type', true);
            ++$updated;
        }

        return $updated;
    }

    private function normalize_homepage_archive_metadata() {
        $query = new WP_Query(
            array(
                'post_type' => 'archive_item',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'no_found_rows' => true,
                'meta_query' => array(
                    GU_Scene_Archive_Record_Manager::build_public_visibility_meta_query(),
                ),
            )
        );

        $summary = array(
            'records_considered' => 0,
            'records_updated' => 0,
            'source_backfills' => 0,
            'source_skipped_existing' => 0,
            'source_skipped_no_url' => 0,
            'source_skipped_unknown_host' => 0,
            'history_topic_evidence_blocked' => 0,
        );
        $details = array();

        foreach ((array) $query->posts as $post_id) {
            $post_id = (int) $post_id;
            $archive_types = $this->get_post_term_slugs($post_id, 'archive_type');
            $is_featured = ! empty(get_post_meta($post_id, 'gu_featured', true));
            $is_history = in_array('history', $archive_types, true);

            if (! $is_featured && ! $is_history) {
                continue;
            }

            ++$summary['records_considered'];
            $updated = false;
            $source_terms = $this->get_post_term_slugs($post_id, 'scene_source');
            $original_url = trim((string) get_post_meta($post_id, 'gu_original_url', true));
            $host_evidence = $this->extract_host_for_reporting($original_url);
            $source_result = '';
            $history_result = $is_history ? 'History topic present' : 'Not a history record';

            if (! empty($source_terms)) {
                ++$summary['source_skipped_existing'];
                $source_result = 'Already had source label';
            } else {
                if ('' === $original_url || ! wp_http_validate_url($original_url)) {
                    ++$summary['source_skipped_no_url'];
                    $source_result = 'Blocked: missing or invalid source URL';
                } else {
                    $source_term = $this->infer_supported_source_term_from_url($original_url);

                    if ('' === $source_term) {
                        ++$summary['source_skipped_unknown_host'];
                        $source_result = 'Blocked: unsupported source host';
                    } else {
                        wp_set_object_terms($post_id, array($source_term), 'scene_source', true);
                        ++$summary['source_backfills'];
                        $updated = true;
                        $source_result = sprintf('Backfilled source label: %s', $source_term);
                    }
                }
            }

            if ($is_history && empty($this->get_post_term_slugs($post_id, 'history_topic'))) {
                ++$summary['history_topic_evidence_blocked'];
                $history_result = 'Evidence-blocked: missing history topic';
            } elseif ($is_history) {
                $history_result = 'History topic present';
            }

            if ($updated) {
                ++$summary['records_updated'];
            }

            $details[] = array(
                'title' => get_the_title($post_id),
                'edit_url' => get_edit_post_link($post_id, 'url'),
                'homepage_role' => $this->build_homepage_archive_role_label($is_featured, $is_history),
                'source_result' => $source_result,
                'history_result' => $history_result,
                'host_evidence' => '' !== $host_evidence ? $host_evidence : 'No canonical source host',
            );
        }

        return array(
            'summary' => $summary,
            'details' => $details,
        );
    }

    private function validate_record($post_id) {
        $original_url = trim((string) get_post_meta($post_id, 'gu_original_url', true));

        if ('' === $original_url || ! wp_http_validate_url($original_url)) {
            update_post_meta($post_id, 'gu_link_status', 'hidden');
            update_post_meta($post_id, 'gu_last_validation_at', current_time('mysql', true));
            return 'skipped';
        }

        $response = $this->request_url($original_url);
        $threshold = max(1, (int) GU_Scene_Archive_Settings::get('validation_failures_to_dead', 2));
        $failures = (int) get_post_meta($post_id, 'gu_validation_failures', true);
        $http_code = isset($response['code']) ? (string) $response['code'] : '';
        $status = 'warning';

        if (! empty($response['live'])) {
            $status = 'live';
            $failures = 0;
        } elseif (! empty($response['hard_dead'])) {
            $status = 'dead';
            $failures = $threshold;
        } else {
            ++$failures;
            $status = $failures >= $threshold ? 'dead' : 'warning';
        }

        update_post_meta($post_id, 'gu_link_status', $status);
        update_post_meta($post_id, 'gu_validation_failures', $failures);
        update_post_meta($post_id, 'gu_last_validation_http_code', $http_code);
        update_post_meta($post_id, 'gu_last_validation_at', current_time('mysql', true));

        return $status;
    }

    private function request_url($url) {
        $args = array(
            'timeout' => 8,
            'redirection' => 5,
            'user-agent' => 'GU Scene Archive Validator/1.0; ' . home_url('/'),
        );

        $response = wp_remote_head($url, $args);

        if (is_wp_error($response) || $this->should_fallback_to_get($response)) {
            $fallback_args = $args;
            $fallback_args['limit_response_size'] = 2048;
            $response = wp_remote_get($url, $fallback_args);
        }

        if (is_wp_error($response)) {
            return array(
                'live' => false,
                'hard_dead' => false,
                'code' => 'error',
            );
        }

        $code = absint(wp_remote_retrieve_response_code($response));

        if ($code >= 200 && $code < 400) {
            return array(
                'live' => true,
                'hard_dead' => false,
                'code' => $code,
            );
        }

        return array(
            'live' => false,
            'hard_dead' => in_array($code, array(404, 410), true),
            'code' => $code,
        );
    }

    private function should_fallback_to_get($response) {
        if (is_wp_error($response)) {
            return true;
        }

        $code = absint(wp_remote_retrieve_response_code($response));

        return in_array($code, array(0, 401, 403, 405, 429), true);
    }

    private function clear_provider_caches() {
        global $wpdb;

        $transient_like = $wpdb->esc_like('_transient_gu_scene_archive_') . '%';
        $timeout_like = $wpdb->esc_like('_transient_timeout_gu_scene_archive_') . '%';

        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
                $transient_like,
                $timeout_like
            )
        );
    }

    private function record_has_thumbnail($post_id) {
        if (has_post_thumbnail($post_id)) {
            return true;
        }

        return '' !== trim((string) get_post_meta($post_id, 'gu_source_id', true));
    }

    private function get_post_term_slugs($post_id, $taxonomy) {
        $terms = wp_get_post_terms($post_id, $taxonomy, array('fields' => 'slugs'));

        if (is_wp_error($terms) || empty($terms)) {
            return array();
        }

        return array_values(array_filter(array_unique(array_map('sanitize_title', $terms))));
    }

    private function count_duplicate_groups($index) {
        $count = 0;

        foreach ((array) $index as $items) {
            if (count((array) $items) > 1) {
                ++$count;
            }
        }

        return $count;
    }

    private function count_duplicate_records($index) {
        $count = 0;

        foreach ((array) $index as $items) {
            $items = (array) $items;

            if (count($items) > 1) {
                $count += count($items) - 1;
            }
        }

        return $count;
    }

    private function normalize_url_for_compare($url) {
        $parts = wp_parse_url($url);

        if (empty($parts['host'])) {
            return '';
        }

        $host = strtolower((string) $parts['host']);
        $host = preg_replace('/^www\./', '', $host);
        $path = isset($parts['path']) ? untrailingslashit((string) $parts['path']) : '';
        $query = array();

        if (! empty($parts['query'])) {
            parse_str((string) $parts['query'], $query);

            foreach (array_keys($query) as $key) {
                $normalized_key = strtolower((string) $key);

                if (0 === strpos($normalized_key, 'utm_') || in_array($normalized_key, array('fbclid', 'gclid'), true)) {
                    unset($query[$key]);
                }
            }

            ksort($query);
        }

        return $host . $path . (! empty($query) ? '?' . http_build_query($query) : '');
    }

    private function normalize_term_name($name) {
        $name = html_entity_decode(wp_strip_all_tags((string) $name), ENT_QUOTES, get_bloginfo('charset'));
        $name = str_replace('&', ' and ', $name);
        $name = strtolower($name);
        $name = preg_replace('/[^a-z0-9]+/i', ' ', $name);
        $name = preg_replace('/\s+/', ' ', (string) $name);

        return trim((string) $name);
    }

    private function infer_supported_source_term_from_url($url) {
        $host = wp_parse_url($url, PHP_URL_HOST);

        if (! is_string($host) || '' === $host) {
            return '';
        }

        $host = strtolower(preg_replace('/^www\./', '', $host));

        if ($this->host_matches($host, array('youtube.com', 'youtu.be'))) {
            return 'youtube';
        }

        if ($this->host_matches($host, array('soundcloud.com'))) {
            return 'soundcloud';
        }

        if ($this->host_matches($host, array('spotify.com'))) {
            return 'spotify';
        }

        if ($this->host_matches($host, array('bandcamp.com'))) {
            return 'bandcamp';
        }

        if ($this->host_matches($host, array('facebook.com', 'fb.watch'))) {
            return 'facebook';
        }

        if ($this->host_matches($host, array('instagram.com'))) {
            return 'instagram';
        }

        return '';
    }

    private function build_homepage_archive_role_label($is_featured, $is_history) {
        $roles = array();

        if ($is_featured) {
            $roles[] = 'Featured archive';
        }

        if ($is_history) {
            $roles[] = 'History support';
        }

        if (empty($roles)) {
            return 'Homepage support';
        }

        return implode(' + ', $roles);
    }

    private function extract_host_for_reporting($url) {
        $host = wp_parse_url($url, PHP_URL_HOST);

        if (! is_string($host) || '' === $host) {
            return '';
        }

        return strtolower(preg_replace('/^www\./', '', $host));
    }

    private function host_matches($host, $suffixes) {
        foreach ((array) $suffixes as $suffix) {
            $suffix = strtolower((string) $suffix);

            if ('' === $suffix) {
                continue;
            }

            if ($host === $suffix || substr($host, -strlen('.' . $suffix)) === '.' . $suffix) {
                return true;
            }
        }

        return false;
    }

    private function get_audit_taxonomies() {
        return array(
            'scene_artist',
            'scene_venue',
            'scene_genre',
            'scene_area',
            'scene_source',
            'scene_year',
            'archive_type',
            'history_topic',
        );
    }

    private function get_taxonomy_label($taxonomy) {
        $taxonomy_object = get_taxonomy($taxonomy);

        if ($taxonomy_object && isset($taxonomy_object->labels->name)) {
            return (string) $taxonomy_object->labels->name;
        }

        return ucwords(str_replace('_', ' ', (string) $taxonomy));
    }

    private function get_admin_redirect_url() {
        return admin_url('admin.php?page=gu-scene-archive-maintenance');
    }
}
