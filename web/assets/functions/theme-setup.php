<?php

/**
 * Theme supports
 */
function mediakanjers_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'custom-logo', array(
        'height'      => 70,
        'width'       => 280,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // theme.json stuurt kleuren/font-sizes/spacing van de block editor aan.
    // Handmatige add_theme_support( 'editor-color-palette' ) etc. is niet nodig
    // en zou theme.json juist overschrijven.

    register_nav_menus( array(
        'main-menu'     => __( 'Hoofdmenu', 'mediakanjers' ),
        'footer-menu-1' => __( 'Footer menu 1 (Vacatures/Stages/Over ons)', 'mediakanjers' ),
        'footer-menu-2' => __( 'Footer menu 2 (Merken/Nieuws/Voorwaarden)', 'mediakanjers' ),
    ) );
}
add_action( 'after_setup_theme', 'mediakanjers_theme_setup' );

/**
 * ACF: eigen acf-json map in het child theme voor sync van veldgroepen.
 */
function mediakanjers_acf_json_save_point( $path ) {
    return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'mediakanjers_acf_json_save_point' );

function mediakanjers_acf_json_load_point( $paths ) {
    unset( $paths[0] );
    $paths[] = get_stylesheet_directory() . '/acf-json';

    return $paths;
}
add_filter( 'acf/settings/load_json', 'mediakanjers_acf_json_load_point' );

/**
 * Body-class voor pagina's met de optie "Tweekleurige achtergrond"
 * (Pagina-instellingen in de zijbalk van de editor).
 */
function mediakanjers_body_classes( $classes ) {
    if ( is_page() && function_exists( 'get_field' ) && get_field( 'page_bg_tweekleurig' ) ) {
        $classes[] = 'mk-bg-tweekleurig';
    }

    return $classes;
}
add_filter( 'body_class', 'mediakanjers_body_classes' );
