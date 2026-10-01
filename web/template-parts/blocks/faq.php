<?php
/**
 * Block: Veelgestelde vragen
 *
 * Intro (titel/subtitel/tekst/knop) naast een lijst inklapbare vragen.
 * Op de front-end wordt ook FAQPage structured data (schema.org) uitgegeven.
 *
 * @param array $block      The block settings and attributes.
 * @param bool  $is_preview True tijdens de preview in de block editor.
 */

$titel    = get_field( 'faq_titel' );
$subtitel = get_field( 'faq_subtitel' );
$tekst    = get_field( 'faq_tekst' );
$knop     = get_field( 'faq_knop' );
$vragen   = get_field( 'faq_vragen' );

$block_id      = 'faq-' . sanitize_html_class( $block['id'] ?? uniqid() );
$wrapper_class = 'mk-faq mk-block-spacing';

if ( ! empty( $block['className'] ) ) {
    $wrapper_class .= ' ' . $block['className'];
}
?>
<section class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="container mk-faq__grid">
        <div class="mk-faq__intro">
            <?php if ( $titel ) : ?>
                <h2 class="mk-faq__title"><?php echo esc_html( $titel ); ?></h2>
            <?php endif; ?>
            <?php if ( $subtitel ) : ?>
                <p class="mk-faq__subtitel"><?php echo esc_html( $subtitel ); ?></p>
            <?php endif; ?>
            <?php if ( $tekst ) : ?>
                <div class="mk-faq__tekst"><?php echo wp_kses_post( $tekst ); ?></div>
            <?php endif; ?>
            <?php if ( $knop && ! empty( $knop['url'] ) ) : ?>
                <a class="btn-primary" href="<?php echo esc_url( $knop['url'] ); ?>" target="<?php echo esc_attr( $knop['target'] ?: '_self' ); ?>">
                    <?php echo esc_html( $knop['title'] ?: 'Neem contact op' ); ?>
                    <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php if ( $vragen ) : ?>
            <div class="mk-faq__list" data-faq>
                <?php foreach ( $vragen as $index => $item ) :
                    if ( empty( $item['vraag'] ) ) {
                        continue;
                    }
                    $item_id = $block_id . '-' . $index;
                ?>
                    <div class="mk-faq__item">
                        <h3 class="mk-faq__heading">
                            <button type="button" class="mk-faq__toggle" id="<?php echo esc_attr( $item_id ); ?>-knop" aria-expanded="false" aria-controls="<?php echo esc_attr( $item_id ); ?>">
                                <span class="mk-faq__vraag"><?php echo esc_html( $item['vraag'] ); ?></span>
                                <span class="mk-faq__icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                        </h3>
                        <div class="mk-faq__panel" id="<?php echo esc_attr( $item_id ); ?>" role="region" aria-labelledby="<?php echo esc_attr( $item_id ); ?>-knop">
                            <div class="mk-faq__panel__inner">
                                <div class="mk-faq__antwoord"><?php echo wp_kses_post( make_clickable( (string) $item['antwoord'] ) ); ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php
    if ( $vragen && empty( $is_preview ) ) {
        $schema = array(
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => array(),
        );

        foreach ( $vragen as $item ) {
            if ( empty( $item['vraag'] ) || empty( $item['antwoord'] ) ) {
                continue;
            }
            $schema['mainEntity'][] = array(
                '@type'          => 'Question',
                'name'           => wp_strip_all_tags( $item['vraag'] ),
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => wp_strip_all_tags( $item['antwoord'] ),
                ),
            );
        }

        if ( $schema['mainEntity'] ) {
            echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG ) . '</script>';
        }
    }
    ?>
</section>
