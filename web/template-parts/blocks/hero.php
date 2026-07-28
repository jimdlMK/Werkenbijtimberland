<?php
/**
 * Block: Hero
 *
 * @param array $block The block settings and attributes.
 */

$image      = get_field( 'hero_image' );
$vimeo_id   = get_field( 'hero_vimeo_id' );
$title      = get_field( 'hero_title' );
$cta_primary   = get_field( 'hero_cta_primary' );
$cta_secondary = get_field( 'hero_cta_secondary' );

if ( ! $image ) {
    return;
}

$has_video   = ! empty( $vimeo_id );
$block_id    = 'hero-' . $block['id'];
$wrapper_class = 'mk-hero mk-block-spacing';

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $wrapper_class ); ?>"<?php echo $has_video ? ' data-hero-vimeo-id="' . esc_attr( $vimeo_id ) . '"' : ''; ?>>
    <div class="mk-hero__viewport">
        <div class="mk-hero__media">
            <img
                class="mk-hero__media__image"
                src="<?php echo esc_url( $image['url'] ); ?>"
                alt="<?php echo esc_attr( $image['alt'] ); ?>"
                <?php echo $has_video ? '' : 'fetchpriority="high"'; ?>
            >
            <?php if ( $has_video ) : ?>
            <div class="mk-hero__media__video" data-vimeo-id="<?php echo esc_attr( $vimeo_id ); ?>"></div>
            <?php endif; ?>
            <div class="mk-hero__media__overlay"></div>
        </div>

        <div class="mk-hero__content">
            <div class="mk-hero__content__inner">
                <?php if ( $title ) : ?>
                    <h1 class="mk-hero__title"><?php echo wp_kses_post( $title ); ?></h1>
                <?php endif; ?>

                <?php if ( $cta_primary || $cta_secondary ) : ?>
                <div class="mk-hero__ctas">
                    <?php if ( $cta_primary && ! empty( $cta_primary['url'] ) ) : ?>
                        <a class="btn-primary" href="<?php echo esc_url( $cta_primary['url'] ); ?>" target="<?php echo esc_attr( $cta_primary['target'] ?: '_self' ); ?>">
                            <?php echo esc_html( $cta_primary['title'] ); ?>
                            <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ( $cta_secondary && ! empty( $cta_secondary['url'] ) ) : ?>
                        <a class="mk-hero__cta-secondary" href="<?php echo esc_url( $cta_secondary['url'] ); ?>" target="<?php echo esc_attr( $cta_secondary['target'] ?: '_self' ); ?>">
                            <?php echo esc_html( $cta_secondary['title'] ); ?>
                            <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'blue' ) ); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <?php if ( $has_video ) : ?>
            <button type="button" class="mk-hero__watch-video" data-hero-video-trigger="<?php echo esc_attr( $block_id ); ?>" data-vimeo-id="<?php echo esc_attr( $vimeo_id ); ?>">
                <span class="mk-hero__watch-video__icon">
                    <?php
                    $play_icon = get_stylesheet_directory() . '/assets/images/icons/play.svg';
                    if ( file_exists( $play_icon ) ) {
                        echo file_get_contents( $play_icon );
                    }
                    ?>
                </span>
                <span class="mk-hero__watch-video__label">Bekijk hele video</span>
            </button>
            <?php endif; ?>
        </div>
    </div>
</section>
