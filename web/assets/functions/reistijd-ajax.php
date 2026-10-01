<?php

/**
 * Reistijd-calculator op de vacature-overzichtpagina.
 *
 * De bezoeker kiest een adres (PDOK-suggesties in de browser), wij berekenen
 * hier server-side de reistijd lopend, fietsend en met de auto via
 * OpenRouteService. Zo blijft de API-key op de server. ORS rekent zonder
 * actuele verkeerssituatie, precies wat we willen.
 *
 * Geen nonce: het endpoint is publiek en read-only, en een nonce verloopt op
 * gecachete pagina's. Misbruik beperken we met caching + een limiet per IP.
 */

const MEDIAKANJERS_REISTIJD_PROFIELEN = array(
    'lopen'   => 'foot-walking',
    'fietsen' => 'cycling-regular',
    'auto'    => 'driving-car',
);

/**
 * Is de calculator volledig ingesteld (API-key + bestemming)?
 */
function mediakanjers_reistijd_actief() {
    return get_field( 'vacopt_rt_ors_key', 'option' ) && get_field( 'vacopt_rt_adres', 'option' );
}

/**
 * Coördinaten van het bestemmingsadres via PDOK, gecachet per adres.
 *
 * @return array|null [lng, lat]
 */
function mediakanjers_reistijd_bestemming() {
    $adres = trim( (string) get_field( 'vacopt_rt_adres', 'option' ) );

    if ( '' === $adres ) {
        return null;
    }

    $cache_key = 'mk_rt_dest_' . md5( $adres );
    $cached    = get_transient( $cache_key );

    if ( is_array( $cached ) ) {
        return $cached;
    }

    $response = wp_remote_get( add_query_arg( array(
        'q'    => $adres,
        'rows' => 1,
        'fl'   => 'centroide_ll',
    ), 'https://api.pdok.nl/bzk/locatieserver/search/v3_1/free' ), array( 'timeout' => 8 ) );

    if ( is_wp_error( $response ) ) {
        return null;
    }

    $body = json_decode( wp_remote_retrieve_body( $response ), true );
    $punt = $body['response']['docs'][0]['centroide_ll'] ?? '';

    if ( ! preg_match( '/POINT\(([-\d.]+) ([-\d.]+)\)/', $punt, $m ) ) {
        return null;
    }

    $coords = array( (float) $m[1], (float) $m[2] );
    set_transient( $cache_key, $coords, MONTH_IN_SECONDS );

    return $coords;
}

/**
 * Reistijd in minuten voor één ORS-profiel, of null als het niet lukt.
 */
function mediakanjers_reistijd_ors( $profiel, $van, $naar, $api_key ) {
    $response = wp_remote_post( 'https://api.openrouteservice.org/v2/directions/' . $profiel, array(
        'timeout' => 8,
        'headers' => array(
            'Authorization' => $api_key,
            'Content-Type'  => 'application/json',
        ),
        'body'    => wp_json_encode( array(
            'coordinates'  => array( $van, $naar ),
            'preference'   => 'fastest',
            'instructions' => false,
            'geometry'     => false,
        ) ),
    ) );

    if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
        return null;
    }

    $body     = json_decode( wp_remote_retrieve_body( $response ), true );
    $duration = $body['routes'][0]['summary']['duration'] ?? null;

    return null === $duration ? null : max( 1, (int) round( $duration / 60 ) );
}

function mediakanjers_reistijd_bereken() {
    $lat = isset( $_POST['lat'] ) ? (float) $_POST['lat'] : 0;
    $lng = isset( $_POST['lng'] ) ? (float) $_POST['lng'] : 0;

    // Alleen Nederland (ruim genomen): PDOK levert ook alleen NL-adressen.
    if ( $lat < 50.5 || $lat > 53.8 || $lng < 3.2 || $lng > 7.3 ) {
        wp_send_json_error( array( 'message' => 'Dit adres kunnen we helaas niet vinden.' ), 400 );
    }

    if ( ! mediakanjers_reistijd_actief() ) {
        wp_send_json_error( array( 'message' => 'De reistijdcalculator is nog niet ingesteld.' ), 503 );
    }

    $naar = mediakanjers_reistijd_bestemming();

    if ( ! $naar ) {
        wp_send_json_error( array( 'message' => 'Er ging iets mis bij het berekenen. Probeer het later opnieuw.' ), 500 );
    }

    // Afronden op ~100 meter: buren delen dezelfde cache-entry.
    $van       = array( round( $lng, 3 ), round( $lat, 3 ) );
    $cache_key = 'mk_rt_' . md5( wp_json_encode( array( $van, $naar ) ) );
    $cached    = get_transient( $cache_key );

    if ( is_array( $cached ) ) {
        wp_send_json_success( $cached );
    }

    $ip        = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
    $limit_key = 'mk_rt_rl_' . md5( $ip );
    $aantal    = (int) get_transient( $limit_key );

    if ( $aantal >= 30 ) {
        wp_send_json_error( array( 'message' => 'Je hebt de reistijd al vaak berekend. Probeer het over een uur opnieuw.' ), 429 );
    }

    set_transient( $limit_key, $aantal + 1, HOUR_IN_SECONDS );

    $api_key   = get_field( 'vacopt_rt_ors_key', 'option' );
    $resultaat = array();

    foreach ( MEDIAKANJERS_REISTIJD_PROFIELEN as $modus => $profiel ) {
        $resultaat[ $modus ] = mediakanjers_reistijd_ors( $profiel, $van, $naar, $api_key );
    }

    if ( ! array_filter( $resultaat ) ) {
        wp_send_json_error( array( 'message' => 'Er ging iets mis bij het berekenen. Probeer het later opnieuw.' ), 502 );
    }

    set_transient( $cache_key, $resultaat, MONTH_IN_SECONDS );

    wp_send_json_success( $resultaat );
}
add_action( 'wp_ajax_mediakanjers_reistijd', 'mediakanjers_reistijd_bereken' );
add_action( 'wp_ajax_nopriv_mediakanjers_reistijd', 'mediakanjers_reistijd_bereken' );
