<?php

/**
 * Rich text (WYSIWYG) veilig uitgeven, zonder lege alinea's en opsommingspunten.
 *
 * Geplakte tekst (bijv. uit Word) of dubbele enters leveren vaak lege
 * <p>&nbsp;</p>'s en lege <li>'s op, die zorgen voor onregelmatige witruimte.
 * Die halen we hier weg; de opmaak zelf komt uit de CSS (mk-vac-richtext).
 *
 * @param string $html
 * @return string
 */
function mediakanjers_richtext( $html ) {
    $html = preg_replace(
        array(
            '#<p[^>]*>(?:\s|&nbsp;|&\#160;|\xC2\xA0|<br\s*/?>)*</p>#iu', // lege alinea's
            '#<li[^>]*>(?:\s|&nbsp;|&\#160;|\xC2\xA0)*</li>#iu',             // lege opsommingspunten
        ),
        '',
        (string) $html
    );

    return wp_kses_post( $html );
}

?>
