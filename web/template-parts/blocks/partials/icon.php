<?php
/**
 * Herbruikbare icoon partial (rendert een svg-bestand inline zodat de
 * kleur via CSS `path { fill: ... }` overschreven kan worden).
 *
 * @param array $args ['name' => 'klok'|'locatie'|...]
 */

$name = isset( $args['name'] ) ? $args['name'] : '';
$path = get_stylesheet_directory() . '/assets/images/icons/' . $name . '.svg';

if ( $name && file_exists( $path ) ) {
    echo file_get_contents( $path );
}
