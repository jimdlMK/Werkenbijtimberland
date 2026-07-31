<?php
/**
 * Archive: Nieuws
 */

$categorieen = get_terms( array(
    'taxonomy'   => 'nieuws_categorie',
    'hide_empty' => true,
) );

$actieve_categorie = isset( $_GET['categorie'] ) ? sanitize_text_field( wp_unslash( $_GET['categorie'] ) ) : '';

$archief_intro = get_field( 'nieuwsopt_archief_intro', 'option' );

$initial_query = new WP_Query( array(
    'post_type'      => 'nieuws',
    'posts_per_page' => 12,
    'paged'          => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'tax_query'      => $actieve_categorie ? array(
        array(
            'taxonomy' => 'nieuws_categorie',
            'field'    => 'slug',
            'terms'    => $actieve_categorie,
        ),
    ) : array(),
) );

get_header();
?>
<div id="main-content" class="vervolgpagina">
    <section class="mk-nieuws-archief">
        <div class="container">
            <nav class="mk-nieuws-archief__breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> &gt;
                <span>Nieuws</span>
            </nav>

            <h1 class="mk-nieuws-archief__title">Nieuws</h1>
            <?php if ( $archief_intro ) : ?>
                <div class="mk-nieuws-archief__intro"><?php echo wp_kses_post( $archief_intro ); ?></div>
            <?php endif; ?>

            <?php if ( $categorieen && ! is_wp_error( $categorieen ) ) : ?>
                <div class="mk-nieuws-archief__filters">
                    <span class="mk-nieuws-archief__filters__label">Snel filteren tussen categorieën:</span>
                    <div class="mk-nieuws-archief__filters__pills" data-nieuws-filters>
                        <button type="button" class="mk-nieuws-archief__pill<?php echo '' === $actieve_categorie ? ' is-active' : ''; ?>" data-categorie="alle">Alle nieuws</button>
                        <?php foreach ( $categorieen as $categorie ) : ?>
                            <button type="button" class="mk-nieuws-archief__pill<?php echo $actieve_categorie === $categorie->slug ? ' is-active' : ''; ?>" data-categorie="<?php echo esc_attr( $categorie->slug ); ?>"><?php echo esc_html( $categorie->name ); ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <p class="mk-nieuws-archief__count" data-nieuws-count>Resultaten: <?php echo (int) $initial_query->found_posts; ?> berichten</p>

            <div class="mk-nieuws-archief__grid" data-nieuws-grid>
                <?php if ( $initial_query->have_posts() ) : ?>
                    <?php while ( $initial_query->have_posts() ) : $initial_query->the_post(); ?>
                        <?php get_template_part( 'template-parts/nieuws-card', null, array( 'nieuws_id' => get_the_ID() ) ); ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <p class="mk-nieuws-archief__empty">Er zijn op dit moment geen nieuwsberichten gevonden.</p>
                <?php endif; ?>
            </div>

            <?php if ( $initial_query->max_num_pages > 1 ) : ?>
                <div class="mk-nieuws-archief__load-more">
                    <button type="button" class="mk-nieuws-archief__load-more__btn" data-nieuws-load-more data-page="1" data-max-pages="<?php echo (int) $initial_query->max_num_pages; ?>" data-categorie="<?php echo esc_attr( $actieve_categorie ); ?>">
                        Bekijk meer
                        <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'blue' ) ); ?>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php get_footer(); ?>
