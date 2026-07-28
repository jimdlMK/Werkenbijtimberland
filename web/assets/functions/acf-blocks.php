<?php

/**
 * Centrale registratie van alle ACF Gutenberg blocks.
 *
 * Elk block heeft een render-template in template-parts/blocks/{name}.php.
 * Nieuwe blocks toevoegen: extra array-item hieronder + bijbehorend
 * template-parts/blocks/{name}.php + acf-json veldgroep.
 */
function mediakanjers_register_acf_blocks() {
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    $blocks = array(
        array(
            'name'        => 'hero',
            'title'       => __( 'Hero', 'mediakanjers' ),
            'description' => __( 'Hero-sectie met achtergrond afbeelding of Vimeo-video, titel en call-to-actions.', 'mediakanjers' ),
            'icon'        => 'cover-image',
            'keywords'    => array( 'hero', 'header', 'video' ),
        ),
        array(
            'name'        => 'wat-ons-drijft',
            'title'       => __( 'Wat ons drijft', 'mediakanjers' ),
            'description' => __( 'Titel, tekst en een grid van cards (titel + afbeelding).', 'mediakanjers' ),
            'icon'        => 'grid-view',
            'keywords'    => array( 'cards', 'usps', 'grid' ),
        ),
        array(
            'name'        => 'titel-tekst',
            'title'       => __( 'Titel + tekst', 'mediakanjers' ),
            'description' => __( 'Een titel (kiesbare heading-tag) met tekst eronder.', 'mediakanjers' ),
            'icon'        => 'text-page',
            'keywords'    => array( 'titel', 'tekst', 'intro' ),
        ),
        array(
            'name'        => 'merken-grid',
            'title'       => __( 'Merken grid', 'mediakanjers' ),
            'description' => __( 'Uitklapbaar grid van merken (Onze merken).', 'mediakanjers' ),
            'icon'        => 'index-card',
            'keywords'    => array( 'merken', 'accordion', 'grid' ),
        ),
        array(
            'name'        => 'slider',
            'title'       => __( 'Slider', 'mediakanjers' ),
            'description' => __( 'Gallerij- of merken-slider met optionele intro.', 'mediakanjers' ),
            'icon'        => 'images-alt2',
            'keywords'    => array( 'slider', 'carousel', 'gallerij', 'merken' ),
        ),
    );

    foreach ( $blocks as $block ) {
        acf_register_block_type( array_merge( array(
            'render_template' => 'template-parts/blocks/' . $block['name'] . '.php',
            'category'        => 'mediakanjers',
            'mode'            => 'preview',
            'supports'        => array(
                'align' => array( 'full', 'wide' ),
                'mode'  => false,
                'jsx'   => true,
            ),
        ), $block ) );
    }
}
add_action( 'acf/init', 'mediakanjers_register_acf_blocks' );

/**
 * Eigen block-categorie zodat onze ACF blocks niet tussen de core-blocks
 * verdwijnen in de block-inserter.
 */
function mediakanjers_block_category( $categories ) {
    return array_merge(
        array(
            array(
                'slug'  => 'mediakanjers',
                'title' => __( 'Mediakanjers', 'mediakanjers' ),
            ),
        ),
        $categories
    );
}
add_filter( 'block_categories_all', 'mediakanjers_block_category' );
