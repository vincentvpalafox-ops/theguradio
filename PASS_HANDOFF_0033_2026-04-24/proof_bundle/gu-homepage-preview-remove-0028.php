<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

function gu_preview_cleanup_emit(array $payload, int $status = 200): void {
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
    gu_preview_cleanup_emit(array(
        'ok' => false,
        'error' => 'wp_load_not_found',
        'self_deleted' => false,
    ), 500);
}

require_once $wpLoadPath;

if (!function_exists('get_posts') || !function_exists('wp_delete_post')) {
    gu_preview_cleanup_emit(array(
        'ok' => false,
        'error' => 'wordpress_bootstrap_incomplete',
        'self_deleted' => false,
    ), 500);
}

$slug = 'archive-homepage-preview';
$pageOnFrontBefore = (int) get_option('page_on_front');
$existingPosts = get_posts(array(
    'name' => $slug,
    'post_type' => 'page',
    'post_status' => 'any',
    'posts_per_page' => 1,
    'orderby' => 'ID',
    'order' => 'DESC',
));
$page = !empty($existingPosts) ? $existingPosts[0] : null;

if (!$page instanceof WP_Post) {
    gu_preview_cleanup_emit(array(
        'ok' => true,
        'action' => 'noop_not_found',
        'slug' => $slug,
        'page_on_front_before' => $pageOnFrontBefore,
    ));
}

$pageId = (int) $page->ID;
if ($pageOnFrontBefore === $pageId) {
    gu_preview_cleanup_emit(array(
        'ok' => false,
        'error' => 'refusing_to_trash_front_page',
        'page_id' => $pageId,
        'slug' => $slug,
        'page_on_front_before' => $pageOnFrontBefore,
        'self_deleted' => false,
    ), 409);
}

$deleteResult = wp_delete_post($pageId, true);
if (!$deleteResult instanceof WP_Post) {
    gu_preview_cleanup_emit(array(
        'ok' => false,
        'error' => 'delete_failed',
        'page_id' => $pageId,
        'slug' => $slug,
        'page_on_front_before' => $pageOnFrontBefore,
        'self_deleted' => false,
    ), 500);
}

clean_post_cache($pageId);

if (function_exists('wp_cache_post_change')) {
    wp_cache_post_change($pageId);
}
if (function_exists('wp_cache_clear_cache')) {
    wp_cache_clear_cache();
}

$pageOnFrontAfter = (int) get_option('page_on_front');

gu_preview_cleanup_emit(array(
    'ok' => true,
    'action' => 'deleted',
    'page_id' => $pageId,
    'slug' => $slug,
    'page_on_front_before' => $pageOnFrontBefore,
    'page_on_front_after' => $pageOnFrontAfter,
    'front_page_unchanged' => ($pageOnFrontBefore === $pageOnFrontAfter),
));
