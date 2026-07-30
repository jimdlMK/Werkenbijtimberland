<?php
/**
 * Block: Vacatures
 *
 * Toont automatisch de 3 nieuwste vacatures in een slider.
 *
 * @param array $block The block settings and attributes.
 */

$vacatures = get_posts( array(
    'post_type'      => 'vacature',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
) );

if ( ! $vacatures ) {
    return;
}

$edge          = get_field( 'vacs_edge' ) ?: 'vol';
$slider_id     = 'vacatures-' . $block['id'];
$wrapper_class = 'mk-vacatures-blok mk-block-spacing mk-vacatures-blok--edge-' . $edge;

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="mk-vacatures-blok__viewport">
        <div class="swiper" id="<?php echo esc_attr( $slider_id ); ?>" data-slider-type="vacatures" data-slider-edge="<?php echo esc_attr( $edge ); ?>"<?php echo 'rechts' === $edge ? ' dir="rtl"' : ''; ?>>
            <div class="swiper-wrapper">
                <?php foreach ( $vacatures as $vacature ) :
                    $functie   = get_field( 'vac_functie', $vacature->ID );
                    $uren      = get_field( 'vac_uren', $vacature->ID );
                    $locatie   = get_field( 'vac_locatie', $vacature->ID );
                    $intro     = get_field( 'vac_intro', $vacature->ID );
                    $thumbnail = get_field( 'vac_thumbnail', $vacature->ID );
                    $permalink = get_permalink( $vacature );
                ?>
                    <div class="swiper-slide">
                        <div class="mk-vacatures-blok__slide" dir="ltr">
                            <div class="mk-vacatures-blok__slide__media">
                                <?php if ( $thumbnail ) : ?>
                                    <img src="<?php echo esc_url( $thumbnail['url'] ); ?>" alt="<?php echo esc_attr( $thumbnail['alt'] ?: $vacature->post_title ); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="mk-vacatures-blok__slide__content">
                                <h3 class="mk-vacatures-blok__slide__title"><?php echo esc_html( $vacature->post_title ); ?></h3>

                                <div class="mk-vacatures-blok__slide__meta">
                                    <?php if ( $functie ) : ?>
                                        <span class="mk-vacatures-blok__slide__meta__item mk-vacatures-blok__slide__meta__item--functie">
                                            <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'sector' ) ); ?>
                                            <?php echo esc_html( $functie ); ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ( $uren ) : ?>
                                        <span class="mk-vacatures-blok__slide__meta__item">
                                            <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'klok' ) ); ?>
                                            <?php echo esc_html( $uren ); ?> uur
                                        </span>
                                    <?php endif; ?>
                                    <?php if ( $locatie ) : ?>
                                        <span class="mk-vacatures-blok__slide__meta__item">
                                            <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'locatie' ) ); ?>
                                            <?php echo esc_html( $locatie ); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <?php if ( $intro ) : ?>
                                    <div class="mk-vacatures-blok__slide__intro"><?php echo wp_kses_post( wpautop( $intro ) ); ?></div>
                                <?php endif; ?>

                                <a class="mk-vacatures-blok__slide__link" href="<?php echo esc_url( $permalink ); ?>">
                                    Bekijk vacature
                                    <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="mk-vacatures-blok__dots swiper-pagination" data-dots-for="<?php echo esc_attr( $slider_id ); ?>"></div>
    </div>
</section>
