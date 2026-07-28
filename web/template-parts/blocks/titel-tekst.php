<?php
/**
 * Block: Titel + tekst
 *
 * @param array $block The block settings and attributes.
 */

$layout       = get_field( 'tt_layout' ) ?: 'simpel';
$achtergrond  = get_field( 'tt_achtergrond' ) ?: 'geen';
$tag          = get_field( 'tt_tag' ) ?: 'h2';
$title        = get_field( 'tt_title' );
$text         = get_field( 'tt_text' );
$cta_type     = get_field( 'tt_cta_type' ) ?: 'geen';
$cta          = get_field( 'tt_cta' );

if ( ! $title && ! $text ) {
    return;
}

$allowed_layouts = array( 'simpel', 'media-onder', '2-koloms' );
$layout           = in_array( $layout, $allowed_layouts, true ) ? $layout : 'simpel';

$allowed_tags = array( 'h1', 'h2', 'h3', 'h4' );
$tag          = in_array( $tag, $allowed_tags, true ) ? $tag : 'h2';

$media_afbeelding = 'media-onder' === $layout ? get_field( 'tt_media_afbeelding' ) : null;
$media_vimeo_id   = 'media-onder' === $layout ? get_field( 'tt_media_vimeo_id' ) : null;
$kolom_afbeelding = '2-koloms' === $layout ? get_field( 'tt_kolom_afbeelding' ) : null;
$heeft_video      = ! empty( $media_vimeo_id );

$block_id      = 'titel-tekst-' . $block['id'];
$wrapper_class = 'mk-titel-tekst mk-block-spacing mk-titel-tekst--' . $layout . ' mk-titel-tekst--bg-' . $achtergrond;

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="container">
        <div class="mk-titel-tekst__grid">
            <div class="mk-titel-tekst__content">
                <?php if ( $title ) : ?>
                    <<?php echo esc_html( $tag ); ?> class="mk-titel-tekst__title"><?php echo esc_html( $title ); ?></<?php echo esc_html( $tag ); ?>>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <div class="mk-titel-tekst__text"><?php echo wp_kses_post( $text ); ?></div>
                <?php endif; ?>

                <?php if ( 'geen' !== $cta_type && $cta && ! empty( $cta['url'] ) ) : ?>
                    <?php if ( 'knop-primary' === $cta_type ) : ?>
                        <a class="btn-primary mk-titel-tekst__cta" href="<?php echo esc_url( $cta['url'] ); ?>" target="<?php echo esc_attr( $cta['target'] ?: '_self' ); ?>">
                            <?php echo esc_html( $cta['title'] ); ?>
                            <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                        </a>
                    <?php elseif ( 'knop-secondary' === $cta_type ) : ?>
                        <a class="btn-secondary mk-titel-tekst__cta" href="<?php echo esc_url( $cta['url'] ); ?>" target="<?php echo esc_attr( $cta['target'] ?: '_self' ); ?>">
                            <?php echo esc_html( $cta['title'] ); ?>
                            <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                        </a>
                    <?php elseif ( 'link' === $cta_type ) : ?>
                        <a class="mk-titel-tekst__link" href="<?php echo esc_url( $cta['url'] ); ?>" target="<?php echo esc_attr( $cta['target'] ?: '_self' ); ?>">
                            <?php echo esc_html( $cta['title'] ); ?>
                            <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'blue' ) ); ?>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <?php if ( '2-koloms' === $layout && $kolom_afbeelding ) : ?>
                <div class="mk-titel-tekst__media">
                    <img src="<?php echo esc_url( $kolom_afbeelding['url'] ); ?>" alt="<?php echo esc_attr( $kolom_afbeelding['alt'] ); ?>">
                </div>
            <?php endif; ?>
        </div>

        <?php if ( 'media-onder' === $layout && $media_afbeelding ) : ?>
            <div class="mk-titel-tekst__media-onder"<?php echo $heeft_video ? ' data-hero-vimeo-id="' . esc_attr( $media_vimeo_id ) . '"' : ''; ?>>
                <img
                    class="mk-titel-tekst__media-onder__image"
                    src="<?php echo esc_url( $media_afbeelding['url'] ); ?>"
                    alt="<?php echo esc_attr( $media_afbeelding['alt'] ); ?>"
                >
                <?php if ( $heeft_video ) : ?>
                    <div class="mk-titel-tekst__media-onder__video" data-vimeo-id="<?php echo esc_attr( $media_vimeo_id ); ?>"></div>

                    <button type="button" class="mk-titel-tekst__watch-video" data-hero-video-trigger="<?php echo esc_attr( $block_id ); ?>" data-vimeo-id="<?php echo esc_attr( $media_vimeo_id ); ?>">
                        <span class="mk-titel-tekst__watch-video__icon">
                            <?php
                            $play_icon = get_stylesheet_directory() . '/assets/images/icons/play.svg';
                            if ( file_exists( $play_icon ) ) {
                                echo file_get_contents( $play_icon );
                            }
                            ?>
                        </span>
                        <span class="mk-titel-tekst__watch-video__label">Bekijk hele video</span>
                    </button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
