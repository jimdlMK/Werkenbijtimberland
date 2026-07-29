<?php

/**
 * AJAX-filter + load-more voor de vacature-overzichtpagina.
 */
function mediakanjers_vacatures_query() {
    check_ajax_referer( 'mediakanjers_vacatures', 'nonce' );

    $sector      = isset( $_POST['sector'] ) ? sanitize_text_field( wp_unslash( $_POST['sector'] ) ) : '';
    $page        = isset( $_POST['page'] ) ? max( 1, (int) $_POST['page'] ) : 1;
    $per_page    = 12;

    $args = array(
        'post_type'      => 'vacature',
        'posts_per_page' => $per_page,
        'paged'          => $page,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    if ( $sector && 'alle' !== $sector ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'vacature_categorie',
                'field'    => 'slug',
                'terms'    => $sector,
            ),
        );
    }

    $query = new WP_Query( $args );

    ob_start();
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/vacature-card', null, array( 'vacature_id' => get_the_ID() ) );
        }
    }
    $html = ob_get_clean();
    wp_reset_postdata();

    wp_send_json_success( array(
        'html'        => $html,
        'found_posts' => (int) $query->found_posts,
        'max_pages'   => (int) $query->max_num_pages,
        'page'        => $page,
    ) );
}
add_action( 'wp_ajax_mediakanjers_vacatures_query', 'mediakanjers_vacatures_query' );
add_action( 'wp_ajax_nopriv_mediakanjers_vacatures_query', 'mediakanjers_vacatures_query' );
