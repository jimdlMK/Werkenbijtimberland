<?php
/**
 * Archive: Vacatures
 */

$sectoren = get_terms( array(
    'taxonomy'   => 'vacature_categorie',
    'hide_empty' => true,
) );

$actieve_sector = isset( $_GET['sector'] ) ? sanitize_text_field( wp_unslash( $_GET['sector'] ) ) : '';

$archief_intro = get_field( 'vacopt_intro', 'option' ) ?: 'Werken bij Timberland is jezelf, samen met je collega\'s dagelijks inzetten voor de verbetering en groei van onze organisatie.';

$os_titel = get_field( 'vacopt_os_titel', 'option' ) ?: 'Open sollicitatie';
$os_tekst = get_field( 'vacopt_os_tekst', 'option' ) ?: '<p>Staat jouw droombaan er nog niet tussen? Solliciteer dan open en laat ons weten wat jij zoekt. We nemen graag contact met je op zodra er een passende vacature beschikbaar is.</p>';
$os_cta   = get_field( 'vacopt_os_cta', 'option' );

$rt_titel = get_field( 'vacopt_rt_titel', 'option' ) ?: 'Reisafstand naar je nieuwe baan?';
$rt_tekst = get_field( 'vacopt_rt_tekst', 'option' ) ?: '<p>Wil je weten hoe ver je moet lopen, fietsen of rijden naar je werk?<br>Bereken hieronder je reistijd!</p>';
$rt_bestemming = get_field( 'vacopt_rt_bestemming', 'option' ) ?: 'Distribution Center Almelo';
$rt_modi = array(
    'lopen'   => array(
        'label' => 'Lopen',
        'icon'  => '<circle cx="13" cy="4" r="1"/><path d="M7 21l3-4"/><path d="M16 21l-2-4-3-3 1-6"/><path d="M6 12l2-3 4-1 3 3 3 1"/>',
    ),
    'fietsen' => array(
        'label' => 'Fietsen',
        'icon'  => '<circle cx="18.5" cy="17.5" r="3.5"/><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="15" cy="5" r="1"/><path d="M12 17.5V14l-3-3 4-3 2 3h2"/>',
    ),
    'auto'    => array(
        'label' => 'Auto',
        'icon'  => '<path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/>',
    ),
);

$ja_titel =get_field( 'vacopt_ja_titel', 'option' ) ?: 'Nieuwe vacatures als eerste in je mailbox?';
$ja_tekst = get_field( 'vacopt_ja_tekst', 'option' ) ?: 'Sta jouw vacature er nog niet tussen? Geen zorgen, we groeien snel! Maak een job alert aan en ontvang de nieuwste vacatures bij Timberland Europe B.V. direct in je mailbox. Afmelden kan op elk moment.';

$stages_titel = get_field( 'vacopt_stages_titel', 'option' ) ?: 'Stages & afstuderen';
$stages_tekst = get_field( 'vacopt_stages_tekst', 'option' ) ?: 'Op zoek naar een leerzame stage of afstudeerplek? Bekijk alle stagemogelijkheden bij Timberland en ontdek waar jij het verschil kunt maken.';
$stages_cta   = get_field( 'vacopt_stages_cta', 'option' );

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
            <div class="mk-vacature-archief__intro"><?php echo wp_kses_post( $archief_intro ); ?></div>

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
                <h2 class="mk-open-sollicitatie__title"><?php echo esc_html( $os_titel ); ?></h2>
                <div class="mk-open-sollicitatie__text"><?php echo wp_kses_post( $os_tekst ); ?></div>
                <?php if ( $os_cta && ! empty( $os_cta['url'] ) ) : ?>
                    <a class="btn-primary" href="<?php echo esc_url( $os_cta['url'] ); ?>" target="<?php echo esc_attr( $os_cta['target'] ?: '_self' ); ?>">
                        <?php echo esc_html( $os_cta['title'] ?: 'Open sollicitatie versturen' ); ?>
                        <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                    </a>
                <?php else : ?>
                    <a class="btn-primary" href="#">
                        Open sollicitatie versturen
                        <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="mk-reistijd mk-block-spacing">
        <div class="container">
            <div class="mk-reistijd__box">
                <h2 class="mk-reistijd__title"><?php echo esc_html( $rt_titel ); ?></h2>
                <div class="mk-reistijd__text"><?php echo wp_kses_post( $rt_tekst ); ?></div>

                <?php if ( mediakanjers_reistijd_actief() ) : ?>
                    <div class="mk-reistijd__calc" data-reistijd>
                        <form class="mk-reistijd__form" data-reistijd-form novalidate>
                            <div class="mk-reistijd__field">
                                <label class="mk-reistijd__label" for="mk-reistijd-input">Jouw postcode of adres</label>
                                <input id="mk-reistijd-input" type="text" placeholder="Jouw postcode of adres" autocomplete="off" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="mk-reistijd-suggesties" data-reistijd-input>
                                <ul id="mk-reistijd-suggesties" class="mk-reistijd__suggestions" role="listbox" hidden data-reistijd-suggestions></ul>
                            </div>
                            <button type="submit" class="btn-primary" data-reistijd-submit>
                                Bereken reistijd
                                <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                            </button>
                        </form>

                        <p class="mk-reistijd__error" role="alert" hidden data-reistijd-error></p>

                        <div class="mk-reistijd__results" aria-live="polite" hidden data-reistijd-results>
                            <p class="mk-reistijd__route">Reistijd naar <?php echo esc_html( $rt_bestemming ); ?> vanaf <strong data-reistijd-from></strong></p>
                            <div class="mk-reistijd__tiles">
                                <?php foreach ( $rt_modi as $modus => $rt_modus ) : ?>
                                    <div class="mk-reistijd__tile">
                                        <svg class="mk-reistijd__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $rt_modus['icon']; // phpcs:ignore WordPress.Security.EscapeOutput -- vaste SVG hierboven ?></svg>
                                        <span class="mk-reistijd__tile__label"><?php echo esc_html( $rt_modus['label'] ); ?></span>
                                        <span class="mk-reistijd__tile__value" data-reistijd-value="<?php echo esc_attr( $modus ); ?>"></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <p class="mk-reistijd__note">Snelste route, zonder rekening te houden met de actuele verkeerssituatie.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="mk-vacature-cta-rijen mk-block-spacing">
        <div class="container mk-vacature-cta-rijen__grid">
            <div class="mk-vacature-cta-rij">
                <h3 class="mk-vacature-cta-rij__title"><?php echo esc_html( $ja_titel ); ?></h3>
                <div class="mk-vacature-cta-rij__text"><?php echo wp_kses_post( $ja_tekst ); ?></div>
                <form class="mk-vacature-cta-rij__form">
                    <input type="email" placeholder="Jouw e-mailadres" required>
                    <button type="submit" class="btn-primary">
                        Aanmelden
                        <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                    </button>
                </form>
            </div>
            <div class="mk-vacature-cta-rij mk-vacature-cta-rij--blauw">
                <h3 class="mk-vacature-cta-rij__title"><?php echo esc_html( $stages_titel ); ?></h3>
                <div class="mk-vacature-cta-rij__text"><?php echo wp_kses_post( $stages_tekst ); ?></div>
                <?php if ( $stages_cta && ! empty( $stages_cta['url'] ) ) : ?>
                    <a class="btn-secondary" href="<?php echo esc_url( $stages_cta['url'] ); ?>" target="<?php echo esc_attr( $stages_cta['target'] ?: '_self' ); ?>">
                        <?php echo esc_html( $stages_cta['title'] ?: 'Bekijk alle stages' ); ?>
                        <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                    </a>
                <?php else : ?>
                    <a class="btn-secondary" href="#">
                        Bekijk alle stages
                        <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
<?php get_footer(); ?>
