<?php
/**
 * Block: Wat ons drijft
 *
 * @param array $block The block settings and attributes.
 */

$title = get_field( 'wod_title' );
$text  = get_field( 'wod_text' );
$items = get_field( 'wod_items' );

$wrapper_class = 'mk-wod mk-block-spacing';

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="container">
        <?php if ( $title || $text ) : ?>
        <div class="mk-wod__intro">
            <?php if ( $title ) : ?>
                <h2 class="mk-wod__title"><?php echo esc_html( $title ); ?></h2>
            <?php endif; ?>

            <?php if ( $text ) : ?>
                <div class="mk-wod__text"><?php echo wp_kses_post( $text ); ?></div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ( $items ) : ?>
        <div class="mk-wod__grid">
            <?php foreach ( $items as $item ) : ?>
                <div class="mk-wod__card">
                    <?php if ( ! empty( $item['image'] ) ) : ?>
                        <div class="mk-wod__card__media">
                            <img src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( $item['image']['alt'] ); ?>">
                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $item['title'] ) ) : ?>
                        <p class="mk-wod__card__title"><?php echo esc_html( $item['title'] ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
