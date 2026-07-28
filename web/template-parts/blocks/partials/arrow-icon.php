<?php
/**
 * Herbruikbare pijl-icoon partial.
 *
 * @param array $args ['color' => 'white'|'copper'|'blue']
 */

$color = isset( $args['color'] ) ? $args['color'] : 'white';
$file  = 'arrow-right-' . $color . '.svg';
$path  = get_stylesheet_directory() . '/assets/images/icons/' . $file;

if ( file_exists( $path ) ) {
    echo file_get_contents( $path );
}
