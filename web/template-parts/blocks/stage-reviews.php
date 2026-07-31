<?php
/**
 * Block: Stage - Reviews
 *
 * @param array $block The block settings and attributes.
 */

$reviews = get_field( 'stageopt_reviews', 'option' );

if ( ! $reviews ) {
    return;
}

$slider_id     = 'stage-reviews-' . $block['id'];
$wrapper_class = 'mk-stage-reviews mk-block-spacing';

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="mk-stage-reviews__viewport">
        <div class="swiper" id="<?php echo esc_attr( $slider_id ); ?>" data-slider-type="stage-reviews">
            <div class="swiper-wrapper">
                <?php foreach ( $reviews as $review ) :
                    $foto = $review['foto'];
                    $naam = $review['naam'];
                    $rol  = $review['rol'];
                    $tekst = $review['tekst'];

                    if ( ! $naam ) {
                        continue;
                    }
                ?>
                    <div class="swiper-slide">
                        <div class="mk-stage-reviews__card">
                            <?php if ( $foto ) : ?>
                                <div class="mk-stage-reviews__card__media">
                                    <img src="<?php echo esc_url( $foto['url'] ); ?>" alt="<?php echo esc_attr( $foto['alt'] ?: $naam ); ?>">
                                </div>
                            <?php endif; ?>

                            <div class="mk-stage-reviews__card__content">
                                <?php if ( $tekst ) : ?>
                                    <div class="mk-stage-reviews__card__text"><?php echo wp_kses_post( wpautop( $tekst ) ); ?></div>
                                <?php endif; ?>

                                <div class="mk-stage-reviews__card__footer">
                                    <span class="mk-stage-reviews__card__naam"><?php echo esc_html( $naam ); ?></span>
                                    <?php if ( $rol ) : ?>
                                        <span class="mk-stage-reviews__card__rol"><?php echo esc_html( $rol ); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="mk-stage-reviews__dots swiper-pagination" data-dots-for="<?php echo esc_attr( $slider_id ); ?>"></div>
    </div>
</section>
