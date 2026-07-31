<?php
/**
 * Block: Nieuws + contactformulier
 *
 * Toont links de laatste nieuws-card, rechts een Gravity Forms
 * contactformulier.
 *
 * @param array $block The block settings and attributes.
 */

$titel      = get_field( 'nieuwsopt_blok_titel', 'option' ) ?: 'Laatste nieuws';
$link_tekst = get_field( 'nieuwsopt_blok_link_tekst', 'option' ) ?: 'Bekijk alles';
$link_url   = get_field( 'nieuwsopt_blok_link_url', 'option' ) ?: get_post_type_archive_link( 'nieuws' );

$contact_titel = get_field( 'nieuwsopt_contact_titel', 'option' ) ?: 'Heb je vragen of opmerkingen?';
$contact_tekst = get_field( 'nieuwsopt_contact_tekst', 'option' );
$form_id       = get_field( 'nieuwsopt_contact_form_id', 'option' ) ?: 1;

$laatste_nieuws = get_posts( array(
    'post_type'      => 'nieuws',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

$wrapper_class = 'mk-nieuws-contact mk-block-spacing';

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="container mk-nieuws-contact__grid">
        <div class="mk-nieuws-contact__col mk-nieuws-contact__col--nieuws">
            <div class="mk-nieuws-contact__header">
                <h2 class="mk-nieuws-contact__title"><?php echo esc_html( $titel ); ?></h2>
                <?php if ( $link_url ) : ?>
                    <a class="mk-nieuws-contact__link" href="<?php echo esc_url( $link_url ); ?>">
                        <?php echo esc_html( $link_tekst ); ?>
                        <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'copper' ) ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ( ! empty( $laatste_nieuws ) ) : ?>
                <?php get_template_part( 'template-parts/nieuws-card', null, array( 'nieuws_id' => $laatste_nieuws[0]->ID ) ); ?>
            <?php else : ?>
                <p class="mk-nieuws-contact__empty">Er is nog geen nieuws geplaatst.</p>
            <?php endif; ?>
        </div>

        <div class="mk-nieuws-contact__col mk-nieuws-contact__col--contact">
            <h2 class="mk-nieuws-contact__title"><?php echo esc_html( $contact_titel ); ?></h2>
            <?php if ( $contact_tekst ) : ?>
                <div class="mk-nieuws-contact__contact-tekst"><?php echo wp_kses_post( wpautop( $contact_tekst ) ); ?></div>
            <?php endif; ?>

            <div class="mk-nieuws-contact__form">
                <?php
                if ( shortcode_exists( 'gravityform' ) ) {
                    echo do_shortcode( '[gravityform id="' . (int) $form_id . '" title="false" description="false" ajax="true"]' );
                }
                ?>
            </div>
        </div>
    </div>
</section>
