<?php
// ponytail: minimal child theme — enqueue assets later when needed

if (!defined('ABSPATH')) {
    exit;
}

function babada_child_setup()
{
    add_theme_support('title-tag');
}

add_action('after_setup_theme', 'babada_child_setup');
