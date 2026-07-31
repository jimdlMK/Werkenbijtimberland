<?php

/**
 * ACF Options-pagina: top-level menu waar alle Mediakanjers instellingen
 * (stage, vacatures, ...) onder gegroepeerd worden.
 */
function mediakanjers_options_page() {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page( array(
        'page_title' => 'Mediakanjers instellingen',
        'menu_title' => 'Mediakanjers',
        'menu_slug'  => 'mediakanjers-instellingen',
        'redirect'   => true,
    ) );
}
add_action( 'acf/init', 'mediakanjers_options_page', 5 );

/**
 * ACF Options-pagina: Stage instellingen (mogelijkheden, verwachten/bieden,
 * reviews) — gebruikt door de stage-blocks.
 */
function mediakanjers_stage_options_page() {
    if ( ! function_exists( 'acf_add_options_sub_page' ) ) {
        return;
    }

    acf_add_options_sub_page( array(
        'page_title'  => 'Stage instellingen',
        'menu_title'  => 'Stage instellingen',
        'menu_slug'   => 'mediakanjers-stage-instellingen',
        'parent_slug' => 'mediakanjers-instellingen',
    ) );
}
add_action( 'acf/init', 'mediakanjers_stage_options_page' );
