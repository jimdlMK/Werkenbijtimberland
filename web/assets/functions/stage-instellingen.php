<?php

/**
 * ACF Options-pagina: top-level menu waar alle Mediakanjers instellingen
 * (stage, vacatures, ...) onder gegroepeerd worden.
 */
function mediakanjers_options_page() {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    // Slug blijft 'mediakanjers-instellingen' (onderpagina's en links verwijzen ernaar).
    acf_add_options_page( array(
        'page_title' => 'Centrale teksten',
        'menu_title' => 'Centrale teksten',
        'menu_slug'  => 'mediakanjers-instellingen',
        'icon_url'   => 'dashicons-edit-page',
        'position'   => 21,
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
        'page_title'  => 'Centrale teksten: Stages',
        'menu_title'  => 'Stages',
        'menu_slug'   => 'mediakanjers-stage-instellingen',
        'parent_slug' => 'mediakanjers-instellingen',
    ) );
}
add_action( 'acf/init', 'mediakanjers_stage_options_page' );
