<?php
/**
 * Block: Contact
 *
 * Titel/tekst + contactgegevens naast een Gravity Forms contactformulier.
 *
 * @param array $block The block settings and attributes.
 */

$titel = get_field( 'contact_titel' );
$tekst = get_field( 'contact_tekst' );

$adres_titel    = get_field( 'contact_adres_titel' );
$adres_tekst    = get_field( 'contact_adres_tekst' );
$telefoon_titel = get_field( 'contact_telefoon_titel' );
$telefoon       = get_field( 'contact_telefoon' );
$email_titel    = get_field( 'contact_email_titel' );
$email          = get_field( 'contact_email' );
$uren_titel     = get_field( 'contact_uren_titel' );
$uren_tekst     = get_field( 'contact_uren_tekst' );

$form_titel = get_field( 'contact_form_titel' );
$form_id    = get_field( 'contact_form_id' ) ?: 1;

$wrapper_class = 'mk-contact mk-block-spacing';

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="container mk-contact__grid">
        <div class="mk-contact__col mk-contact__col--info">
            <?php if ( $titel ) : ?>
                <h2 class="mk-contact__title"><?php echo esc_html( $titel ); ?></h2>
            <?php endif; ?>
            <?php if ( $tekst ) : ?>
                <div class="mk-contact__tekst"><?php echo wp_kses_post( wpautop( $tekst ) ); ?></div>
            <?php endif; ?>

            <div class="mk-contact__details">
                <?php if ( $adres_tekst ) : ?>
                    <div class="mk-contact__detail">
                        <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'locatie' ) ); ?>
                        <div class="mk-contact__detail__content">
                            <?php if ( $adres_titel ) : ?>
                                <span class="mk-contact__detail__label"><?php echo esc_html( $adres_titel ); ?></span>
                            <?php endif; ?>
                            <span class="mk-contact__detail__value"><?php echo nl2br( wp_kses_post( $adres_tekst ) ); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( $telefoon ) : ?>
                    <div class="mk-contact__detail">
                        <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'klok' ) ); ?>
                        <div class="mk-contact__detail__content">
                            <?php if ( $telefoon_titel ) : ?>
                                <span class="mk-contact__detail__label"><?php echo esc_html( $telefoon_titel ); ?></span>
                            <?php endif; ?>
                            <a class="mk-contact__detail__value" href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $telefoon ) ); ?>"><?php echo esc_html( $telefoon ); ?></a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( $email ) : ?>
                    <div class="mk-contact__detail">
                        <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'sector' ) ); ?>
                        <div class="mk-contact__detail__content">
                            <?php if ( $email_titel ) : ?>
                                <span class="mk-contact__detail__label"><?php echo esc_html( $email_titel ); ?></span>
                            <?php endif; ?>
                            <a class="mk-contact__detail__value" href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( $uren_tekst ) : ?>
                    <div class="mk-contact__detail">
                        <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'klok' ) ); ?>
                        <div class="mk-contact__detail__content">
                            <?php if ( $uren_titel ) : ?>
                                <span class="mk-contact__detail__label"><?php echo esc_html( $uren_titel ); ?></span>
                            <?php endif; ?>
                            <span class="mk-contact__detail__value"><?php echo esc_html( $uren_tekst ); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php get_template_part( 'template-parts/contact/socials' ); ?>
        </div>

        <div class="mk-contact__col mk-contact__col--form">
            <div class="mk-contact__form-card">
                <?php if ( $form_titel ) : ?>
                    <h3 class="mk-contact__form-title"><?php echo esc_html( $form_titel ); ?></h3>
                <?php endif; ?>

                <div class="mk-contact__form">
                    <?php
                    if ( shortcode_exists( 'gravityform' ) ) {
                        echo do_shortcode( '[gravityform id="' . (int) $form_id . '" title="false" description="false" ajax="true"]' );
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
