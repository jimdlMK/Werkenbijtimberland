<?php

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
        'parent_slug' => 'Mediakanjers',
    ) );
}
add_action( 'acf/init', 'mediakanjers_stage_options_page' );
