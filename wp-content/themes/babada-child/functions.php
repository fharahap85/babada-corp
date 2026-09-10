<?php

if (!defined('ABSPATH')) {
    exit;
}

function babada_child_enqueue_assets()
{
    $theme_version = wp_get_theme()->get('Version');

    $css_file = get_stylesheet_directory() . '/assets/css/custom.css';
    $js_file  = get_stylesheet_directory() . '/assets/js/custom.js';

    wp_enqueue_style(
        'babada-child-style',
        get_stylesheet_uri(),
        [],
        $theme_version
    );

    wp_enqueue_style(
        'babada-custom-style',
        get_stylesheet_directory_uri() . '/assets/css/custom.css',
        ['babada-child-style'],
        file_exists($css_file) ? filemtime($css_file) : $theme_version
    );

    wp_enqueue_script(
        'babada-custom-script',
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        [],
        file_exists($js_file) ? filemtime($js_file) : $theme_version,
        true
    );
}

add_action('wp_enqueue_scripts', 'babada_child_enqueue_assets');