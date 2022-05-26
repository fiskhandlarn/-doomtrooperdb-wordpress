<?php

declare(strict_types=1);

use Designcise\ManifestJson\ManifestJson;

if (!defined('ABSPATH')) {
    exit();
}

function asset_path(string $path = ''): string
{
    $path = ltrim($path, '/');
    return get_theme_file_path('assets/'.$path);
}

function asset_url(string $url = ''): string
{
    $url = ltrim($url, '/');
    return get_theme_file_uri('assets/'.$url);
}

function image_path(string $path = ''): string
{
    $path = ltrim($path, '/');
    return asset_path('images/'.$path);
}

function image_url(string $url = ''): string
{
    $url = ltrim($url, '/');
    return asset_url('images/'.$url);
}

function require_image($imagePath)
{
    if (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY) {
        echo '<!-- '.esc_html(image_path($imagePath)).' -->'.PHP_EOL;
    }

    require_svg($imagePath);
}

// expexts $imagePath relative to theme/assets/images/
function require_svg($imagePath)
{
    require_svg_absolute(image_path($imagePath));
}

// require svg with unique "cls-" class names
function require_svg_absolute($imagePath)
{
    $image = file_get_contents($imagePath);

    $hash = md5(image_path($imagePath));
    $image = str_replace('cls-', 'cls-' . $hash . '-', $image);

    echo $image;
}

// Enqueue and register scripts the right way.
add_action('wp_enqueue_scripts', function () {
    if (get_theme_support('doomtrooperdb-deregister-jquery')) {
        wp_deregister_script('jquery');
    }

    $manifest = new ManifestJson(get_theme_file_path('assets'));
    $entries = $manifest->getAll();

    $version = wp_get_theme()->Version;

    $loop = 1;
    foreach ($entries as $entry) {
        if (isset($entry['file'])) {
            wp_enqueue_script(
                'doomtrooperdb' . $loop,
                asset_url($entry['file']),
                false,
                $version,
                true
            );
        }

        if (isset($entry['css'])) {
            foreach ($entry['css'] as $css) {
                wp_enqueue_style(
                    'doomtrooperdb' . $loop,
                    asset_url($css),
                    false,
                    $version,
                    false
                );
            }
        }

        $loop++;
    }
});
