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
        array(
            'name'        => 'sectoren',
            'title'       => __( 'Sectoren', 'mediakanjers' ),
            'description' => __( 'Slider met vacature-sectoren, linkt door naar het gefilterde vacature-overzicht.', 'mediakanjers' ),
            'icon'        => 'category',
            'keywords'    => array( 'sectoren', 'categorieen', 'vacatures', 'slider' ),
        ),
        array(
            'name'        => 'vacatures',
            'title'       => __( 'Vacatures', 'mediakanjers' ),
            'description' => __( 'Slider met de nieuwste vacatures, afbeelding + informatie.', 'mediakanjers' ),
            'icon'        => 'businessman',
            'keywords'    => array( 'vacatures', 'jobs', 'slider' ),
        ),
        array(
            'name'        => 'stage-mogelijkheden-intro',
            'title'       => __( 'Stage: Mogelijkheden', 'mediakanjers' ),
            'description' => __( 'Intro-sectie ("Talent inzetten...") vanuit de Stage instellingen.', 'mediakanjers' ),
            'icon'        => 'lightbulb',
            'keywords'    => array( 'stage', 'mogelijkheden', 'intro' ),
        ),
        array(
            'name'        => 'stage-mogelijkheden-dropdown',
            'title'       => __( 'Stage: Mogelijkheden dropdown', 'mediakanjers' ),
            'description' => __( 'Titel + tekst met een uitklapbare lijst van stagemogelijkheden.', 'mediakanjers' ),
            'icon'        => 'menu-alt',
            'keywords'    => array( 'stage', 'mogelijkheden', 'accordion', 'dropdown' ),
        ),
        array(
            'name'        => 'stage-verwachten-bieden',
            'title'       => __( 'Stage: Verwachten & bieden', 'mediakanjers' ),
            'description' => __( 'Grijsblauwe sectie met "Wat verwachten wij" en "Wat bieden wij" naast elkaar.', 'mediakanjers' ),
            'icon'        => 'yes-alt',
            'keywords'    => array( 'stage', 'verwachten', 'bieden' ),
        ),
        array(
            'name'        => 'stage-reviews',
            'title'       => __( 'Stage: Reviews', 'mediakanjers' ),
            'description' => __( 'Slider met reviews van (oud-)stagiaires.', 'mediakanjers' ),
            'icon'        => 'testimonial',
            'keywords'    => array( 'stage', 'reviews', 'slider' ),
        ),
        array(
            'name'        => 'stage-formulier',
            'title'       => __( 'Stage: Sollicitatieformulier', 'mediakanjers' ),
            'description' => __( 'Blauw vlak met titel, subtitel en het Gravity Forms sollicitatieformulier.', 'mediakanjers' ),
            'icon'        => 'feedback',
            'keywords'    => array( 'stage', 'formulier', 'solliciteren' ),
        ),
        array(
            'name'        => 'mailerlite',
            'title'       => __( 'Mailerlite mailbox', 'mediakanjers' ),
            'description' => __( 'Illustratie + titel/tekst met een MailerLite-aanmeldformulier.', 'mediakanjers' ),
            'icon'        => 'email-alt',
            'keywords'    => array( 'mailerlite', 'nieuwsbrief', 'mailbox', 'aanmelden' ),
        ),
        array(
            'name'        => 'nieuws-contact',
            'title'       => __( 'Nieuws + contactformulier', 'mediakanjers' ),
            'description' => __( 'Laatste nieuwsbericht naast een Gravity Forms contactformulier.', 'mediakanjers' ),
            'icon'        => 'megaphone',
            'keywords'    => array( 'nieuws', 'contact', 'formulier' ),
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
