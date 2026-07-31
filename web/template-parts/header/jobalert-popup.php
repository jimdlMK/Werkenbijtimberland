<?php
/**
 * Job alert popup: opent via het jobalert-knopje in de header.
 */

$titel           = get_field( 'vacopt_ja_titel', 'option' ) ?: 'Nieuwe vacatures als eerste in je mailbox?';
$tekst           = get_field( 'vacopt_ja_tekst', 'option' ) ?: 'Sta jouw vacature er nog niet tussen? Geen zorgen, we groeien snel! Maak een job alert aan en ontvang de nieuwste vacatures direct in je mailbox. Afmelden kan op elk moment.';
$afbeelding      = get_field( 'vacopt_ja_afbeelding', 'option' );
$afbeelding_url  = $afbeelding ? $afbeelding['url'] : get_stylesheet_directory_uri() . '/assets/images/' . rawurlencode( 'jobalert 4.png' );
$afbeelding_alt  = $afbeelding ? $afbeelding['alt'] : '';
$form_id         = get_field( 'vacopt_ja_form_id', 'option' ) ?: 1;
?>
<div class="mk-jobalert-popup" id="mk-jobalert-popup" aria-hidden="true">
    <div class="mk-jobalert-popup__overlay" data-jobalert-close></div>
    <div class="mk-jobalert-popup__dialog" role="dialog" aria-modal="true" aria-labelledby="mk-jobalert-popup-title">
        <button type="button" class="mk-jobalert-popup__close" data-jobalert-close aria-label="Sluiten">
            <span></span>
            <span></span>
        </button>

        <div class="mk-jobalert-popup__media">
            <img src="<?php echo esc_url( $afbeelding_url ); ?>" alt="<?php echo esc_attr( $afbeelding_alt ); ?>">
        </div>

        <div class="mk-jobalert-popup__content">
            <span class="mk-jobalert-popup__badge">
                <?php
                $bell_icon = get_stylesheet_directory() . '/assets/images/icons/bell.svg';
                if ( file_exists( $bell_icon ) ) {
                    echo file_get_contents( $bell_icon );
                }
                ?>
                Jobalert
            </span>

            <?php if ( $titel ) : ?>
                <h2 class="mk-jobalert-popup__title" id="mk-jobalert-popup-title"><?php echo esc_html( $titel ); ?></h2>
            <?php endif; ?>

            <?php if ( $tekst ) : ?>
                <div class="mk-jobalert-popup__text"><?php echo wp_kses_post( wpautop( $tekst ) ); ?></div>
            <?php endif; ?>

            <div class="mk-jobalert-popup__form">
                <?php
                if ( shortcode_exists( 'mailerlite_form' ) ) {
                    echo do_shortcode( '[mailerlite_form form_id="' . (int) $form_id . '"]' );
                }
                ?>
            </div>
        </div>
    </div>
</div>
