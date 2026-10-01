<?php
/**
 * Block: Merken grid
 *
 * @param array $block The block settings and attributes.
 */

$merk_ids    = get_field( 'mg_merken' );
$achtergrond = get_field( 'mg_achtergrond' ) ?: 'geen';

if ( ! $merk_ids ) {
    return;
}

$wrapper_class = 'mk-merken-grid mk-block-spacing mk-merken-grid--bg-' . $achtergrond;

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="container">
        <div class="mk-merken-grid__grid">
            <?php foreach ( $merk_ids as $merk_id ) :
                $logo         = get_field( 'merk_logo', $merk_id );
                $content      = get_field( 'merk_content', $merk_id );
                $externe_link = get_field( 'merk_externe_link', $merk_id );
                $item_id      = 'merk-' . $merk_id;

                if ( ! $logo ) {
                    continue;
                }
            ?>
            <div class="mk-merken-grid__item">
                <button type="button" class="mk-merken-grid__toggle" aria-expanded="false" aria-controls="<?php echo esc_attr( $item_id ); ?>">
                    <img class="mk-merken-grid__logo" src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ?: get_the_title( $merk_id ) ); ?>">
                    <span class="mk-merken-grid__arrow">
                        <?php
                        $arrow_icon = get_stylesheet_directory() . '/assets/images/icons/arrow-right-blue.svg';
                        if ( file_exists( $arrow_icon ) ) {
                            echo file_get_contents( $arrow_icon );
                        }
                        ?>
                    </span>
                </button>

                <div class="mk-merken-grid__panel" id="<?php echo esc_attr( $item_id ); ?>">
                    <div class="mk-merken-grid__panel__inner">
                        <?php if ( $content ) : ?>
                            <div class="mk-merken-grid__text"><?php echo wp_kses_post( $content ); ?></div>
                        <?php endif; ?>

                        <?php if ( $externe_link && ! empty( $externe_link['url'] ) ) : ?>
                            <a class="mk-merken-grid__link" href="<?php echo esc_url( $externe_link['url'] ); ?>" target="<?php echo esc_attr( $externe_link['target'] ?: '_blank' ); ?>" rel="noopener noreferrer">
                                <?php echo esc_html( $externe_link['title'] ?: 'Naar de website' ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
