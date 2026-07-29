<?php
/**
 * Doorlopende merken-ticker (logo's naast elkaar, automatisch scrollend).
 * Gebruikt door de "VF Corporation" sectie op de single-vacature pagina.
 */

$merken = get_posts( array(
    'post_type'      => 'merk',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
    'no_found_rows'  => true,
) );

if ( ! $merken ) {
    return;
}
?>
<div class="mk-merken-ticker">
    <div class="mk-merken-ticker__track">
        <?php for ( $i = 0; $i < 2; $i++ ) : // dupliceren voor een naadloze loop ?>
            <div class="mk-merken-ticker__group" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>">
                <?php foreach ( $merken as $merk ) :
                    $logo = get_field( 'merk_slider_logo', $merk->ID ) && ! empty( get_field( 'merk_slider_logo', $merk->ID )['url'] ) ? get_field( 'merk_slider_logo', $merk->ID ) : get_field( 'merk_logo', $merk->ID );

                    if ( ! $logo ) {
                        continue;
                    }
                    ?>
                    <span class="mk-merken-ticker__logo">
                        <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ?: get_the_title( $merk ) ); ?>">
                    </span>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>
