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
