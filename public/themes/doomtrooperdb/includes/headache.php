<?php

/**
 * Copyright (c) Vincent Klaiber.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Plugin Name: Headache
 * Description: An easy-to-swallow painkiller plugin for WordPress.
 * Author: WordPlate
 * Author URI: https://github.com/wordplate/wordplate
 * Version: 1.0.0
 * Plugin URI: https://github.com/wordplate/mail
 */

// // Redirects all feeds to home page.
// function headache_disable_feeds(): void
// {
//     wp_redirect(site_url());
// }

// // Disables feeds.
// add_action('do_feed', 'headache_disable_feeds', 1);
// add_action('do_feed_rdf',  'headache_disable_feeds', 1);
// add_action('do_feed_rss',  'headache_disable_feeds', 1);
// add_action('do_feed_rss2', 'headache_disable_feeds', 1);
// add_action('do_feed_atom', 'headache_disable_feeds', 1);

// // Disables comments feeds.
// add_action('do_feed_rss2_comments', 'headache_disable_feeds', 1);
// add_action('do_feed_atom_comments', 'hHeadache_disable_feeds', 1);

// Disable XML RPC for security.
add_filter('xmlrpc_enabled', '__return_false');

// Removes WordPress version.
remove_action('wp_head', 'wp_generator');

// Removes shortlink.
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Removes Really Simple Discovery link.
remove_action('wp_head', 'rsd_link');

// // Removes RSS feed links.
// remove_action('wp_head', 'feed_links', 2);

// // Removes all extra RSS feed links.
// remove_action('wp_head', 'feed_links_extra', 3);

// Removes wlwmanifest.xml.
remove_action('wp_head', 'wlwmanifest_link');

// Removes meta rel=dns-prefetch href=//s.w.org
remove_action('wp_head', 'wp_resource_hints', 2);

// Removes relational links for the posts.
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Removes REST API link tag from header.
remove_action('wp_head', 'rest_output_link_wp_head', 10);

// // Removes emojis.
// remove_action('wp_head', 'print_emoji_detection_script', 7);
// remove_action('admin_print_scripts', 'print_emoji_detection_script');
// remove_action('wp_print_styles', 'print_emoji_styles');
// remove_action('admin_print_styles', 'print_emoji_styles');
// remove_filter('the_content_feed', 'wp_staticize_emoji');
// remove_filter('comment_text_rss', 'wp_staticize_emoji');
// remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

// // Removes oEmbeds.
// remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
// remove_action('wp_head', 'wp_oembed_add_host_js');

// Disable default users API endpoints for security.
// https://www.wp-tweaks.com/hackers-can-find-your-wordpress-username/
function headache_disable_rest_endpoints($endpoints)
{
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }

    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }

    return $endpoints;
}

add_filter('rest_endpoints', 'headache_disable_rest_endpoints');

// // Removes JPEG compression.
// function headache_remove_jpeg_compression(): int
// {
//     return 100;
// }

// add_filter('jpeg_quality', 'headache_remove_jpeg_compression', 10, 2);

// Update login page image link URL.
function headache_login_url(): string
{
    return home_url();
}

add_filter('login_headerurl', 'headache_login_url');

// Update login page link title.
function headache_login_title(): string
{
    return get_bloginfo('name');
}

add_filter('login_headertext', 'headache_login_title');

// // Removes ?ver= query from styles and scripts.
// function headache_remove_script_version(string $src): string
// {
//     return $src ? esc_url(remove_query_arg('ver', $src)) : $src;
// }

// add_filter('script_loader_src', 'headache_remove_script_version', 15, 1);
// add_filter('style_loader_src', 'headache_remove_script_version', 15, 1);

// Remove contributor, subscriber and author roles.
function headache_remove_roles(): void
{
    remove_role('author');
    remove_role('contributor');
    remove_role('subscriber');
}

add_action('init', 'headache_remove_roles');

add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style( 'wp-block-library' ); // Wordpress core
    wp_dequeue_style( 'wp-block-library-theme' ); // Wordpress core
    wp_dequeue_style( 'wc-block-style' ); // WooCommerce
    wp_dequeue_style( 'storefront-gutenberg-blocks' ); // Storefront theme
}, 100 );

// Remove Global Styles and SVG Filters from WP 5.9.1 - 2022-02-27
// This snippet removes the Global Styles and SVG Filters that are mostly if not only used in Full Site Editing in WordPress 5.9.1+
// Detailed discussion at: https://github.com/WordPress/gutenberg/issues/36834
// WP default filters: https://github.com/WordPress/WordPress/blob/7d139785ea0cc4b1e9aef21a5632351d0d2ae053/wp-includes/default-filters.php
add_action('init', function () {
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
	remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
});
