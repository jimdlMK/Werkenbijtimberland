<?php
/**
 * Block: Stage - Verwachten & bieden
 *
 * @param array $block The block settings and attributes.
 */

$vw_titel = get_field( 'stageopt_vw_titel', 'option' );
$vw_tekst = get_field( 'stageopt_vw_tekst', 'option' );
$wb_titel = get_field( 'stageopt_wb_titel', 'option' );
$wb_tekst = get_field( 'stageopt_wb_tekst', 'option' );

if ( ! $vw_tekst && ! $wb_tekst ) {
    return;
}

$wrapper_class = 'mk-stage-vraag-bod mk-block-spacing';

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="container mk-stage-vraag-bod__grid">
        <?php if ( $vw_tekst ) : ?>
            <div class="mk-stage-vraag-bod__col">
                <?php if ( $vw_titel ) : ?>
                    <h2 class="mk-stage-vraag-bod__title"><?php echo esc_html( $vw_titel ); ?></h2>
                <?php endif; ?>
                <div class="mk-stage-vraag-bod__checklist"><?php echo wp_kses_post( $vw_tekst ); ?></div>
            </div>
        <?php endif; ?>

        <?php if ( $wb_tekst ) : ?>
            <div class="mk-stage-vraag-bod__col">
                <?php if ( $wb_titel ) : ?>
                    <h2 class="mk-stage-vraag-bod__title"><?php echo esc_html( $wb_titel ); ?></h2>
                <?php endif; ?>
                <div class="mk-stage-vraag-bod__checklist"><?php echo wp_kses_post( $wb_tekst ); ?></div>
            </div>
        <?php endif; ?>
    </div>
</section>
