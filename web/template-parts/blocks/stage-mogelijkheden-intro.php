<?php
/**
 * Block: Stage - Mogelijkheden (intro)
 *
 * @param array $block The block settings and attributes.
 */

$titel = get_field( 'stageopt_mog_titel', 'option' );
$tekst = get_field( 'stageopt_mog_tekst', 'option' );

if ( ! $titel && ! $tekst ) {
    return;
}

$wrapper_class = 'mk-stage-mogelijkheden-intro mk-block-spacing';

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="container">
        <?php if ( $titel ) : ?>
            <h2 class="mk-stage-mogelijkheden-intro__title"><?php echo esc_html( $titel ); ?></h2>
        <?php endif; ?>
        <?php if ( $tekst ) : ?>
            <div class="mk-stage-mogelijkheden-intro__text"><?php echo wp_kses_post( $tekst ); ?></div>
        <?php endif; ?>
    </div>
</section>
