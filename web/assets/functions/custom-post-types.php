<?php
    // VOORBEELD CUSTOM POST TYPE REGISTRATIE
    // function mk_cpt() {
    //     register_post_type('CUSTOM POST TYPE', [
    //         'public' => true,
    //         'has_archive' => false,
    //         'label'  => 'CUSTOM POST TYPE',
    //         'supports' => ['title', 'editor', 'thumbnail'],
    //         'show_in_rest' => true,
    //         'menu_icon'      => 'dashicons-admin-network',
    //     ]);
    // }
    // add_action('init', 'mk_cpt');

    /**
     * CPT: Onze merken
     */
    function mediakanjers_cpt_merken() {
        register_post_type( 'merk', array(
            'public'       => true,
            'has_archive'  => false,
            'label'        => 'Onze merken',
            'labels'       => array(
                'name'          => 'Onze merken',
                'singular_name' => 'Merk',
                'add_new_item'  => 'Nieuw merk toevoegen',
                'edit_item'     => 'Merk bewerken',
                'all_items'     => 'Alle merken',
            ),
            'supports'     => array( 'title' ),
            'show_in_rest' => true,
            'menu_icon'    => 'dashicons-tag',
            'rewrite'      => array( 'slug' => 'merken' ),
        ) );
    }
    add_action( 'init', 'mediakanjers_cpt_merken' );

    /**
     * CPT: Vacatures
     */
    function mediakanjers_cpt_vacatures() {
        register_post_type( 'vacature', array(
            'public'       => true,
            'has_archive'  => 'vacatures',
            'label'        => 'Vacatures',
            'labels'       => array(
                'name'          => 'Vacatures',
                'singular_name' => 'Vacature',
                'add_new_item'  => 'Nieuwe vacature toevoegen',
                'edit_item'     => 'Vacature bewerken',
                'all_items'     => 'Alle vacatures',
            ),
            'supports'     => array( 'title' ),
            'show_in_rest' => true,
            'menu_icon'    => 'dashicons-businessman',
            'rewrite'      => array( 'slug' => 'vacature' ),
        ) );
    }
    add_action( 'init', 'mediakanjers_cpt_vacatures' );

    /**
     * CPT: Nieuws
     */
    function mediakanjers_cpt_nieuws() {
        register_post_type( 'nieuws', array(
            'public'       => true,
            'has_archive'  => 'nieuws',
            'label'        => 'Nieuws',
            'labels'       => array(
                'name'          => 'Nieuws',
                'singular_name' => 'Nieuwsbericht',
                'add_new_item'  => 'Nieuw nieuwsbericht toevoegen',
                'edit_item'     => 'Nieuwsbericht bewerken',
                'all_items'     => 'Alle nieuwsberichten',
            ),
            'supports'     => array( 'title', 'editor' ),
            'show_in_rest' => false,
            'menu_icon'    => 'dashicons-media-document',
            'rewrite'      => array( 'slug' => 'nieuws' ),
        ) );
    }
    add_action( 'init', 'mediakanjers_cpt_nieuws' );

    /**
     * Taxonomy: Nieuwscategorieën
     */
    function mediakanjers_tax_nieuws_categorie() {
        register_taxonomy( 'nieuws_categorie', array( 'nieuws' ), array(
            'public'            => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
            'label'             => 'Nieuwscategorieën',
            'labels'            => array(
                'name'          => 'Nieuwscategorieën',
                'singular_name' => 'Nieuwscategorie',
                'add_new_item'  => 'Nieuwe categorie toevoegen',
                'edit_item'     => 'Categorie bewerken',
                'all_items'     => 'Alle categorieën',
            ),
            'show_admin_column' => true,
            'rewrite'           => array( 'slug' => 'nieuws-categorie' ),
        ) );
    }
    add_action( 'init', 'mediakanjers_tax_nieuws_categorie' );

    /**
     * Taxonomy: Vacature categorieën (sectoren)
     */
    function mediakanjers_tax_vacature_categorie() {
        register_taxonomy( 'vacature_categorie', array( 'vacature' ), array(
            'public'            => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
            'label'             => 'Sectoren',
            'labels'            => array(
                'name'          => 'Sectoren',
                'singular_name' => 'Sector',
                'add_new_item'  => 'Nieuwe sector toevoegen',
                'edit_item'     => 'Sector bewerken',
                'all_items'     => 'Alle sectoren',
            ),
            'show_admin_column' => true,
            'rewrite'           => array( 'slug' => 'vacature-sector' ),
        ) );
    }
    add_action( 'init', 'mediakanjers_tax_vacature_categorie' );
?>
