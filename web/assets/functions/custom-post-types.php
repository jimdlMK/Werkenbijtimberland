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
?>
