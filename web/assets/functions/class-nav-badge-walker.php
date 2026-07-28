<?php

/**
 * Nav walker die een aantal-badge toont achter menu-items "Vacatures" en "Stages".
 *
 * Het aantal is nu een placeholder (0) totdat de vacature/stage custom post types
 * bestaan; dan wordt mediakanjers_get_nav_badge_count() vervangen door een echte telling.
 */
class Mediakanjers_Nav_Badge_Walker extends Walker_Nav_Menu {

    private $badge_labels = array( 'vacatures', 'stages' );

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $atts    = array();
        $atts['href'] = ! empty( $item->url ) ? $item->url : '';

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( '' !== $value ) {
                $attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
            }
        }

        $slug  = sanitize_title( $item->title );
        $badge = in_array( $slug, $this->badge_labels, true )
            ? mediakanjers_get_nav_badge_count( $slug )
            : null;

        $output .= '<li class="' . esc_attr( implode( ' ', $classes ) ) . '">';
        $output .= '<a' . $attributes . '>';
        $output .= '<span class="mk-nav-main__label">' . esc_html( $item->title ) . '</span>';

        if ( null !== $badge ) {
            $output .= '<span class="mk-nav-main__badge">' . esc_html( $badge ) . '</span>';
        }

        $output .= '</a>';
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}

/**
 * Placeholder tellerfunctie voor de nav-badges.
 * TODO: vervangen door een echte count_posts() zodra de vacature/stage CPT's bestaan.
 */
function mediakanjers_get_nav_badge_count( $slug ) {
    return 0;
}
