<?php

/**
 * ACF Options-pagina: Vacatures instellingen (o.a. VF Corporation sectie
 * op de single-vacature pagina).
 */
function mediakanjers_vacatures_options_page() {
    if ( ! function_exists( 'acf_add_options_sub_page' ) ) {
        return;
    }

    acf_add_options_sub_page( array(
        'page_title'  => 'Vacatures instellingen',
        'menu_title'  => 'Vacatures instellingen',
        'menu_slug'   => 'mediakanjers-vacatures-instellingen',
        'parent_slug' => 'Mediakanjers',
    ) );
}
add_action( 'acf/init', 'mediakanjers_vacatures_options_page' );
