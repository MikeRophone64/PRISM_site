<?php
/**
 * PRISM Theme — functions.php
 * Minimal WordPress setup. All styling is self-contained in each page template.
 */

// ── Theme support ──────────────────────────────────────────────────────────
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'gallery', 'caption']);
});

// ── Remove WordPress default styles that interfere ────────────────────────
add_action('wp_enqueue_scripts', function () {
    // Dequeue default block styles — not needed for this theme
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
}, 100);

// ── Clean up wp_head() output ─────────────────────────────────────────────
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

// Test Deploy 3 - Tue May 26 - 20:44