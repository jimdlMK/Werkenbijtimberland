<?php
/**
 * Archive: Vacatures
 */

$sectoren = get_terms( array(
    'taxonomy'   => 'vacature_categorie',
    'hide_empty' => true,
) );

$actieve_sector = isset( $_GET['sector'] ) ? sanitize_text_field( wp_unslash( $_GET['sector'] ) ) : '';

$initial_query = new WP_Query( array(
    'post_type'      => 'vacature',
    'posts_per_page' => 12,
    'paged'          => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'tax_query'      => $actieve_sector ? array(
        array(
            'taxonomy' => 'vacature_categorie',
            'field'    => 'slug',
            'terms'    => $actieve_sector,
        ),
    ) : array(),
) );

get_header();
?>
<div id="main-content" class="vervolgpagina">
    <section class="mk-vacature-archief">
        <div class="container">
            <nav class="mk-vacature-archief__breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> &gt;
                <span>Vacatures</span>
            </nav>

            <h1 class="mk-vacature-archief__title">Vacatures</h1>
            <p class="mk-vacature-archief__intro">Werken bij Timberland is jezelf, samen met je collega's dagelijks inzetten voor de verbetering en groei van onze organisatie.</p>

            <?php if ( $sectoren && ! is_wp_error( $sectoren ) ) : ?>
                <div class="mk-vacature-archief__filters">
                    <span class="mk-vacature-archief__filters__label">Snel filteren tussen sectoren:</span>
                    <div class="mk-vacature-archief__filters__pills" data-vacature-filters>
                        <button type="button" class="mk-vacature-archief__pill<?php echo '' === $actieve_sector ? ' is-active' : ''; ?>" data-sector="alle">Alle vacatures</button>
                        <?php foreach ( $sectoren as $sector ) : ?>
                            <button type="button" class="mk-vacature-archief__pill<?php echo $actieve_sector === $sector->slug ? ' is-active' : ''; ?>" data-sector="<?php echo esc_attr( $sector->slug ); ?>"><?php echo esc_html( $sector->name ); ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <p class="mk-vacature-archief__count" data-vacature-count>Resultaten: <?php echo (int) $initial_query->found_posts; ?> vacatures</p>

            <div class="mk-vacature-archief__grid" data-vacature-grid>
                <?php if ( $initial_query->have_posts() ) : ?>
                    <?php while ( $initial_query->have_posts() ) : $initial_query->the_post(); ?>
                        <?php get_template_part( 'template-parts/vacature-card', null, array( 'vacature_id' => get_the_ID() ) ); ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <p class="mk-vacature-archief__empty">Er zijn op dit moment geen vacatures gevonden.</p>
                <?php endif; ?>
            </div>

            <?php if ( $initial_query->max_num_pages > 1 ) : ?>
                <div class="mk-vacature-archief__load-more">
                    <button type="button" class="mk-vacature-archief__load-more__btn" data-vacature-load-more data-page="1" data-max-pages="<?php echo (int) $initial_query->max_num_pages; ?>" data-sector="<?php echo esc_attr( $actieve_sector ); ?>">
                        Bekijk meer
                        <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'blue' ) ); ?>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="mk-open-sollicitatie mk-block-spacing">
        <div class="container mk-open-sollicitatie__grid">
            <div class="mk-open-sollicitatie__media">
                <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . rawurlencode( 'CV 2.png' ) ); ?>" alt="">
            </div>
            <div class="mk-open-sollicitatie__content">
                <h2 class="mk-open-sollicitatie__title">Open sollicitatie</h2>
                <div class="mk-open-sollicitatie__text">
                    <p>Staat jouw droombaan er nog niet tussen? Solliciteer dan open en laat ons weten wat jij zoekt. We nemen graag contact met je op zodra er een passende vacature is.</p>
                </div>
                <a class="btn-primary" href="#">
                    Open sollicitatie versturen
                    <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                </a>
            </div>
        </div>
    </section>

    <section class="mk-vacature-cta-rijen mk-block-spacing">
        <div class="container mk-vacature-cta-rijen__grid">
            <div class="mk-vacature-cta-rij">
                <h3 class="mk-vacature-cta-rij__title">Nieuwe vacatures als eerste in je mailbox?</h3>
                <p class="mk-vacature-cta-rij__text">Sta jouw vacature er nog niet tussen? Geen zorgen, we groeien snel! Maak een job alert aan en ontvang de nieuwste vacatures bij Timberland Europe B.V. direct in je mailbox. Afmelden kan op elk moment.</p>
                <form class="mk-vacature-cta-rij__form">
                    <input type="email" placeholder="Jouw e-mailadres" required>
                    <button type="submit" class="btn-primary">
                        Aanmelden
                        <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                    </button>
                </form>
            </div>
            <div class="mk-vacature-cta-rij mk-vacature-cta-rij--blauw">
                <h3 class="mk-vacature-cta-rij__title">Stages &amp; afstuderen</h3>
                <p class="mk-vacature-cta-rij__text">Op zoek naar een leerzame stage of afstudeerplek? Bekijk alle stagemogelijkheden bij Timberland en ontdek waar jij het verschil kunt maken.</p>
                <a class="btn-secondary" href="#">
                    Bekijk alle stages
                    <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                </a>
            </div>
        </div>
    </section>
</div>
<?php get_footer(); ?>
