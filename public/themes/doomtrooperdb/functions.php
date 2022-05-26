<?php

declare(strict_types=1);

require_once get_theme_file_path('includes/assets.php');
require_once get_theme_file_path('includes/headache.php');

add_action('after_setup_theme', function () {
    show_admin_bar(false);

    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');

    register_nav_menus([
        'navigation' => __('Navigation'),
    ]);
});
