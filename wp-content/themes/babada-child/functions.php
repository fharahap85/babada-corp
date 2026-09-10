<?php

if (!defined('ABSPATH')) {
    exit;
}

function babada_child_enqueue_assets()
{
    wp_enqueue_style(
        'astra-parent-style',
        get_template_directory_uri() . '/style.css'
    );

    wp_enqueue_style(
        'babada-child-style',
        get_stylesheet_uri(),
        ['astra-parent-style'],
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style(
        'babada-custom-style',
        get_stylesheet_directory_uri() . '/assets/css/custom.css',
        ['babada-child-style'],
        '1.0.0'
    );

    wp_enqueue_script(
        'babada-custom-script',
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        [],
        '1.0.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'babada_child_enqueue_assets');
