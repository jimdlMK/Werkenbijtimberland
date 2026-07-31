<?php

/**
 * ACF Options-pagina: Nieuws instellingen — gebruikt door het nieuws-blok
 * en de nieuws-archiefpagina.
 */
function mediakanjers_nieuws_options_page() {
    if ( ! function_exists( 'acf_add_options_sub_page' ) ) {
        return;
    }

    acf_add_options_sub_page( array(
        'page_title'  => 'Nieuws instellingen',
        'menu_title'  => 'Nieuws instellingen',
        'menu_slug'   => 'mediakanjers-nieuws-instellingen',
        'parent_slug' => 'mediakanjers-instellingen',
    ) );
}
add_action( 'acf/init', 'mediakanjers_nieuws_options_page' );
