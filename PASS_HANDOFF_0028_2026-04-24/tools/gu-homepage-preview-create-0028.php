<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

function gu_preview_emit(array $payload, int $status = 200): void {
    http_response_code($status);
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        $json = "{\"ok\":false,\"error\":\"json_encode_failed\"}";
    }

    $selfDeleted = @unlink(__FILE__);
    if (isset($payload['self_deleted']) === false) {
        $payload['self_deleted'] = $selfDeleted;
        $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            $json = "{\"ok\":false,\"error\":\"json_encode_failed_after_delete\"}";
        }
    }

    echo $json;
    exit;
}

$wpLoadCandidates = array(
    __DIR__ . '/wp-load.php',
    dirname(__DIR__) . '/wp-load.php',
);

$wpLoadPath = '';
foreach ($wpLoadCandidates as $candidate) {
    if (is_file($candidate)) {
        $wpLoadPath = $candidate;
        break;
    }
}

if ($wpLoadPath === '') {
    gu_preview_emit(array(
        'ok' => false,
        'error' => 'wp_load_not_found',
        'self_deleted' => false,
    ), 500);
}

require_once $wpLoadPath;

if (!function_exists('wp_insert_post') || !function_exists('get_posts')) {
    gu_preview_emit(array(
        'ok' => false,
        'error' => 'wordpress_bootstrap_incomplete',
        'self_deleted' => false,
    ), 500);
}

$slug = 'archive-homepage-preview';
$title = 'Archive Homepage Preview';
$content = '[gu_scene_archive_homepage]';
$pageOnFrontBefore = (int) get_option('page_on_front');

$authorId = 1;
$adminIds = get_users(array(
    'role' => 'administrator',
    'number' => 1,
    'fields' => 'ID',
));
if (!empty($adminIds) && isset($adminIds[0])) {
    $authorId = (int) $adminIds[0];
}

$existingPosts = get_posts(array(
    'name' => $slug,
    'post_type' => 'page',
    'post_status' => 'any',
    'posts_per_page' => 1,
    'orderby' => 'ID',
    'order' => 'DESC',
));
$existingPage = !empty($existingPosts) ? $existingPosts[0] : null;
$elementorMetaRemoved = array();

$postarr = array(
    'post_title' => $title,
    'post_name' => $slug,
    'post_type' => 'page',
    'post_status' => 'publish',
    'post_content' => $content,
    'comment_status' => 'closed',
    'ping_status' => 'closed',
    'post_author' => $authorId,
);

$action = 'created';
if ($existingPage instanceof WP_Post) {
    $postarr['ID'] = (int) $existingPage->ID;
    $action = 'updated';

    if (get_post_status((int) $existingPage->ID) === 'trash' && function_exists('wp_untrash_post')) {
        wp_untrash_post((int) $existingPage->ID);
    }

    foreach (array('_elementor_data', '_elementor_edit_mode', '_elementor_template_type', '_elementor_page_settings') as $metaKey) {
        if (delete_post_meta((int) $existingPage->ID, $metaKey)) {
            $elementorMetaRemoved[] = $metaKey;
        }
    }
}

$postId = isset($postarr['ID']) ? wp_update_post($postarr, true) : wp_insert_post($postarr, true);

if (is_wp_error($postId)) {
    gu_preview_emit(array(
        'ok' => false,
        'error' => 'page_write_failed',
        'message' => $postId->get_error_message(),
        'action' => $action,
        'page_on_front_before' => $pageOnFrontBefore,
        'self_deleted' => false,
    ), 500);
}

$postId = (int) $postId;
clean_post_cache($postId);

if (function_exists('wp_cache_post_change')) {
    wp_cache_post_change($postId);
}
if (function_exists('wp_cache_clear_cache')) {
    wp_cache_clear_cache();
}

$pageOnFrontAfter = (int) get_option('page_on_front');
$pageUrl = get_permalink($postId);

gu_preview_emit(array(
    'ok' => true,
    'action' => $action,
    'page_id' => $postId,
    'page_url' => $pageUrl,
    'slug' => $slug,
    'shortcode' => $content,
    'elementor_meta_removed' => $elementorMetaRemoved,
    'page_on_front_before' => $pageOnFrontBefore,
    'page_on_front_after' => $pageOnFrontAfter,
    'front_page_unchanged' => ($pageOnFrontBefore === $pageOnFrontAfter),
));
