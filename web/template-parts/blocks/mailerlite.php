<?php
/**
 * Block: Mailerlite mailbox
 *
 * @param array $block The block settings and attributes.
 */

$afbeelding = get_field( 'ml_afbeelding' );
$titel      = get_field( 'ml_titel' );
$tekst      = get_field( 'ml_tekst' );
$form_id    = get_field( 'ml_form_id' ) ?: 1;

if ( ! $titel && ! $tekst ) {
    return;
}

$wrapper_class = 'mk-mailerlite mk-block-spacing';

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="container">
        <div class="mk-mailerlite__card">
            <?php if ( $afbeelding ) : ?>
                <div class="mk-mailerlite__media">
                    <img src="<?php echo esc_url( $afbeelding['url'] ); ?>" alt="<?php echo esc_attr( $afbeelding['alt'] ); ?>">
                </div>
            <?php endif; ?>

            <div class="mk-mailerlite__content">
                <?php if ( $titel ) : ?>
                    <h3 class="mk-mailerlite__title"><?php echo esc_html( $titel ); ?></h3>
                <?php endif; ?>
                <?php if ( $tekst ) : ?>
                    <div class="mk-mailerlite__text"><?php echo wp_kses_post( $tekst ); ?></div>
                <?php endif; ?>

                <div class="mk-mailerlite__form">
                    <?php
                    if ( shortcode_exists( 'mailerlite_form' ) ) {
                        echo do_shortcode( '[mailerlite_form form_id="' . (int) $form_id . '"]' );
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
