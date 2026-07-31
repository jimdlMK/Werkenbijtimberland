<?php
/**
 * Block: Stage - Sollicitatieformulier
 *
 * @param array $block The block settings and attributes.
 */

$titel    = get_field( 'stageopt_form_titel', 'option' );
$subtitel = get_field( 'stageopt_form_subtitel', 'option' );
$form_id  = get_field( 'stageopt_form_id', 'option' ) ?: 3;

$wrapper_class = 'mk-stage-formulier mk-block-spacing';

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section id="solliciteren" class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="mk-stage-formulier__bg">
        <div class="container mk-stage-formulier__intro">
            <?php if ( $titel ) : ?>
                <h2 class="mk-stage-formulier__title"><?php echo esc_html( $titel ); ?></h2>
            <?php endif; ?>
            <?php if ( $subtitel ) : ?>
                <div class="mk-stage-formulier__subtitel"><?php echo wp_kses_post( wpautop( $subtitel ) ); ?></div>
            <?php endif; ?>
        </div>

        <div class="container">
            <div class="mk-stage-formulier__form">
                <?php
                if ( shortcode_exists( 'gravityform' ) ) {
                    echo do_shortcode( '[gravityform id="' . (int) $form_id . '" title="false" description="false" ajax="true"]' );
                }
                ?>
            </div>
        </div>
    </div>
</section>
