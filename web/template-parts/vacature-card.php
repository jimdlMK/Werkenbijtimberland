<?php
/**
 * Herbruikbare vacature-card.
 *
 * @param array $args [
 *     'vacature_id' => int,
 *     'sectoren'    => string[] Optioneel: sector-slugs, voor het filteren op de overzichtpagina,
 *     'verborgen'   => bool     Optioneel: card start verborgen (gefilterd of na "Bekijk meer"),
 * ]
 */

$vacature_id = isset( $args['vacature_id'] ) ? $args['vacature_id'] : get_the_ID();
$sectoren    = isset( $args['sectoren'] ) ? (array) $args['sectoren'] : null;
$verborgen   = ! empty( $args['verborgen'] );

$uren      = get_field( 'vac_uren', $vacature_id );
$locatie   = get_field( 'vac_locatie', $vacature_id );
$salaris   = get_field( 'vac_salaris', $vacature_id );
$thumbnail = get_field( 'vac_thumbnail', $vacature_id );
$permalink = get_permalink( $vacature_id );
$titel     = get_the_title( $vacature_id );
?>
<a class="mk-vacature-card<?php echo $verborgen ? ' is-hidden' : ''; ?>" href="<?php echo esc_url( $permalink ); ?>"<?php echo null !== $sectoren ? ' data-sectoren="' . esc_attr( implode( ' ', $sectoren ) ) . '"' : ''; ?>>
    <div class="mk-vacature-card__media">
        <?php if ( $thumbnail ) : ?>
            <img src="<?php echo esc_url( $thumbnail['url'] ); ?>" alt="<?php echo esc_attr( $thumbnail['alt'] ?: $titel ); ?>">
        <?php endif; ?>
    </div>
    <div class="mk-vacature-card__footer">
        <div class="mk-vacature-card__footer__top">
            <h3 class="mk-vacature-card__title"><?php echo esc_html( $titel ); ?></h3>
            <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'copper' ) ); ?>
        </div>
        <div class="mk-vacature-card__meta">
            <?php if ( $uren ) : ?>
                <span class="mk-vacature-card__meta__item">
                    <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'klok' ) ); ?>
                    <?php echo esc_html( $uren ); ?>
                </span>
            <?php endif; ?>
            <?php if ( $locatie ) : ?>
                <span class="mk-vacature-card__meta__item">
                    <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'locatie' ) ); ?>
                    <?php echo esc_html( $locatie ); ?>
                </span>
            <?php endif; ?>
        </div>
        <?php if ( $salaris ) : ?>
            <p class="mk-vacature-card__salaris">
                <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'euro' ) ); ?>
                <?php echo esc_html( $salaris ); ?>
            </p>
        <?php endif; ?>
    </div>
</a>
