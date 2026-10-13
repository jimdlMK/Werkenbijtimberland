<?php
/**
 * Contact-CTA: blauwe balk met ronde foto, titel, naam en bel/mail-knoppen.
 *
 * Gedeeld door het Contact-blok en de vacaturepagina (onder de procedure).
 *
 * @param array $args [
 *     'titel'    => string,
 *     'intro'    => string  Bijv. 'Neem contact op met',
 *     'naam'     => string,
 *     'functie'  => string,
 *     'telefoon' => string,
 *     'email'    => string,
 *     'foto'     => array   ACF-afbeelding,
 * ]
 */

$titel    = $args['titel'] ?? '';
$intro    = $args['intro'] ?? '';
$naam     = $args['naam'] ?? '';
$functie  = $args['functie'] ?? '';
$telefoon = $args['telefoon'] ?? '';
$email    = $args['email'] ?? '';
$foto     = $args['foto'] ?? null;

if ( ! $naam && ! $telefoon && ! $email ) {
    return;
}
?>
<div class="mk-contact__cta">
    <?php if ( $foto ) : ?>
        <div class="mk-contact__cta__media">
            <img src="<?php echo esc_url( $foto['sizes']['medium'] ?? $foto['url'] ); ?>" alt="<?php echo esc_attr( $foto['alt'] ?: $naam ); ?>">
        </div>
    <?php endif; ?>

    <div class="mk-contact__cta__content">
        <?php if ( $titel ) : ?>
            <h3 class="mk-contact__cta__title"><?php echo esc_html( $titel ); ?></h3>
        <?php endif; ?>
        <?php if ( $naam ) : ?>
            <p class="mk-contact__cta__text">
                <?php if ( $intro ) : ?>
                    <?php echo esc_html( $intro ); ?>
                <?php endif; ?>
                <strong class="mk-contact__cta__naam"><?php echo esc_html( $naam ); ?></strong>
                <?php if ( $functie ) : ?>
                    <span class="mk-contact__cta__functie"><?php echo esc_html( $functie ); ?></span>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>

    <?php if ( $telefoon || $email ) : ?>
        <div class="mk-contact__cta__actions">
            <?php if ( $telefoon ) : ?>
                <a class="mk-contact__cta__btn" href="tel:<?php echo esc_attr( preg_replace( array( '/\(0\)/', '/[^\d+]/' ), '', $telefoon ) ); ?>">
                    <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'telefoon' ) ); ?>
                    <?php echo esc_html( $telefoon ); ?>
                </a>
            <?php endif; ?>
            <?php if ( $email ) : ?>
                <a class="mk-contact__cta__btn" href="mailto:<?php echo esc_attr( $email ); ?>">
                    <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'mail' ) ); ?>
                    <?php echo esc_html( $email ); ?>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
