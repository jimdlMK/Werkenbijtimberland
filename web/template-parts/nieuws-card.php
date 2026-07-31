<?php
/**
 * Herbruikbare nieuws-card.
 *
 * @param array $args ['nieuws_id' => int]
 */

$nieuws_id = isset( $args['nieuws_id'] ) ? $args['nieuws_id'] : get_the_ID();

$intro     = get_field( 'nieuws_intro', $nieuws_id );
$thumbnail = get_field( 'nieuws_thumbnail', $nieuws_id );
$permalink = get_permalink( $nieuws_id );
$titel     = get_the_title( $nieuws_id );
?>
<a class="mk-nieuws-card" href="<?php echo esc_url( $permalink ); ?>">
    <div class="mk-nieuws-card__media">
        <?php if ( $thumbnail ) : ?>
            <img src="<?php echo esc_url( $thumbnail['url'] ); ?>" alt="<?php echo esc_attr( $thumbnail['alt'] ?: $titel ); ?>">
        <?php endif; ?>
    </div>
    <div class="mk-nieuws-card__footer">
        <h3 class="mk-nieuws-card__title"><?php echo esc_html( $titel ); ?></h3>
        <?php if ( $intro ) : ?>
            <div class="mk-nieuws-card__intro"><?php echo wp_kses_post( wpautop( $intro ) ); ?></div>
        <?php endif; ?>
        <span class="mk-nieuws-card__link">
            Lees meer
            <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
        </span>
    </div>
</a>
