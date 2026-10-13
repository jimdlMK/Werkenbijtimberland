<?php
/**
 * Single: Vacature
 */

// Pas dit aan zodra het echte Gravity Forms-formulier is aangemaakt.
$mediakanjers_gf_form_id = 3;

get_header();

while ( have_posts() ) :
    the_post();

    $vacature_id = get_the_ID();

    $functie   = get_field( 'vac_functie', $vacature_id );
    $uren      = get_field( 'vac_uren', $vacature_id );
    $locatie   = get_field( 'vac_locatie', $vacature_id );
    $salaris   = get_field( 'vac_salaris', $vacature_id );
    $intro     = get_field( 'vac_intro', $vacature_id );
    $thumbnail = get_field( 'vac_thumbnail', $vacature_id );

    $jouw_rol = get_field( 'vac_jouw_rol', $vacature_id );

    $wat_ga_je_doen_tekst      = get_field( 'vac_wat_ga_je_doen_tekst', $vacature_id );
    $wat_ga_je_doen_afbeelding = get_field( 'vac_wat_ga_je_doen_afbeelding', $vacature_id );

    $wat_vragen_wij = get_field( 'vac_wat_vragen_wij', $vacature_id );
    $wat_bieden_wij = get_field( 'vac_wat_bieden_wij', $vacature_id );

    $afdeling_titel      = get_field( 'vac_afdeling_titel', $vacature_id );
    $afdeling_tekst      = get_field( 'vac_afdeling_tekst', $vacature_id );
    $afdeling_afbeelding = get_field( 'vac_afdeling_afbeelding', $vacature_id );
    $afdeling_vimeo_id   = get_field( 'vac_afdeling_vimeo_id', $vacature_id );
    $afdeling_heeft_video = ! empty( $afdeling_vimeo_id );

    $procedure_stappen = get_field( 'vacopt_procedure_stappen', 'option' );

    // Contactpersoon: één keer ingesteld in Vacatures instellingen → Contactpersoon.
    $contact_titel      = get_field( 'vacopt_contact_titel', 'option' );
    $contact_intro      = get_field( 'vacopt_contact_intro', 'option' );
    $contact_naam       = get_field( 'vacopt_contact_naam', 'option' );
    $contact_functie    = get_field( 'vacopt_contact_functie', 'option' );
    $contact_telefoon   = get_field( 'vacopt_contact_telefoon', 'option' );
    $contact_email      = get_field( 'vacopt_contact_email', 'option' );
    $contact_afbeelding = get_field( 'vacopt_contact_afbeelding', 'option' );
    $heeft_contact      = $contact_naam || $contact_telefoon || $contact_email;

    $formulier_titel    = get_field( 'vac_formulier_titel', $vacature_id );
    $formulier_subtitel = get_field( 'vac_formulier_subtitel', $vacature_id );

    // Snelnavigatie: alleen secties die op deze vacature ook echt getoond worden.
    $subnav = array_filter( array(
        'functie'        => $jouw_rol ? 'De functie' : '',
        'wat-ga-je-doen' => ( $wat_ga_je_doen_tekst || $wat_ga_je_doen_afbeelding ) ? 'Wat ga je doen' : '',
        'vragen-bieden'  => ( $wat_vragen_wij || $wat_bieden_wij ) ? 'Wat vragen & bieden we' : '',
        'afdeling'       => ( $afdeling_titel || $afdeling_tekst || $afdeling_afbeelding ) ? 'De afdeling' : '',
        'procedure'      => ( $procedure_stappen || $heeft_contact ) ? 'Procedure' : '',
        'reistijd'       => mediakanjers_reistijd_actief() ? 'Reistijd' : '',
    ) );

    $vf_titel = get_field( 'vacopt_vf_titel', 'option' ) ?: 'VF Corporation';
    $vf_tekst = get_field( 'vacopt_vf_tekst', 'option' );
    ?>

    <div id="main-content" class="vervolgpagina">
        <section class="mk-vac-header">
            <div class="container">
                <div class="mk-vac-header__top">
                    <nav class="mk-vac-header__breadcrumb">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> &gt;
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'vacature' ) ); ?>">Vacatures</a> &gt;
                        <span><?php the_title(); ?></span>
                    </nav>

                    <div class="mk-vac-header__ctas">
                        <?php if ( mediakanjers_reistijd_actief() ) : ?>
                            <a class="mk-vac-header__reistijd" href="#reistijd">
                                <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'locatie-lijn' ) ); ?>
                                Bereken reistijd
                            </a>
                        <?php endif; ?>
                        <a class="btn-primary mk-vac-header__cta" href="#solliciteren">
                            Solliciteer direct
                            <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                        </a>
                    </div>
                </div>

                <h1 class="mk-vac-header__title"><?php the_title(); ?></h1>

                <div class="mk-vac-header__meta">
                    <?php if ( $functie ) : ?>
                        <span class="mk-vac-header__meta__item mk-vac-header__meta__item--functie">
                            <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'sector' ) ); ?>
                            <?php echo esc_html( $functie ); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ( $uren ) : ?>
                        <span class="mk-vac-header__meta__item">
                            <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'klok' ) ); ?>
                            <?php echo esc_html( $uren ); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ( $locatie ) : ?>
                        <span class="mk-vac-header__meta__item">
                            <?php get_template_part( 'template-parts/blocks/partials/icon', null, array( 'name' => 'locatie' ) ); ?>
                            <?php echo esc_html( $locatie ); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ( $salaris ) : ?>
                        <span class="mk-vac-header__meta__item"><?php echo esc_html( $salaris ); ?></span>
                    <?php endif; ?>
                </div>

                <?php if ( $intro ) : ?>
                    <div class="mk-vac-header__intro"><?php echo mediakanjers_richtext( wpautop( $intro ) ); ?></div>
                <?php endif; ?>


                <?php if ( $thumbnail ) : ?>
                    <div class="mk-vac-header__media">
                        <img src="<?php echo esc_url( $thumbnail['url'] ); ?>" alt="<?php echo esc_attr( $thumbnail['alt'] ?: get_the_title() ); ?>">
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <nav class="mk-vac-subnav" aria-label="Snel naar" data-vac-subnav>
            <div class="container mk-vac-subnav__inner">
                <span class="mk-vac-subnav__titel"><?php the_title(); ?></span>
                <?php if ( $subnav ) : ?>
                    <ul class="mk-vac-subnav__links" data-vac-subnav-links>
                        <?php foreach ( $subnav as $anker => $label ) : ?>
                            <li><a href="#<?php echo esc_attr( $anker ); ?>"><?php echo esc_html( $label ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <a class="btn-primary mk-vac-subnav__cta" href="#solliciteren">
                    Solliciteer direct
                    <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                </a>
            </div>
        </nav>

        <?php if ( $vf_titel || $vf_tekst ) : ?>
            <section class="mk-vac-vf mk-block-spacing">
                <div class="container">
                    <?php if ( $vf_titel ) : ?>
                        <h2 class="mk-vac-vf__title"><?php echo esc_html( $vf_titel ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $vf_tekst ) : ?>
                        <div class="mk-vac-vf__text"><?php echo mediakanjers_richtext( $vf_tekst ); ?></div>
                    <?php endif; ?>
                </div>

                <?php get_template_part( 'template-parts/merken-ticker' ); ?>
            </section>
        <?php endif; ?>

        <?php if ( $jouw_rol ) : ?>
            <section id="functie" class="mk-vac-sectie mk-vac-sectie--centered mk-block-spacing">
                <div class="container">
                    <h2 class="mk-vac-sectie__title">Jouw rol als <?php the_title(); ?></h2>
                    <div class="mk-vac-sectie__text"><?php echo mediakanjers_richtext( $jouw_rol ); ?></div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( $wat_ga_je_doen_tekst || $wat_ga_je_doen_afbeelding ) : ?>
            <section id="wat-ga-je-doen" class="mk-vac-sectie mk-vac-sectie--media mk-block-spacing">
                <div class="container mk-vac-sectie--media__grid">
                    <div class="mk-vac-sectie--media__content">
                        <h2 class="mk-vac-sectie__title">Wat ga je doen</h2>
                        <?php if ( $wat_ga_je_doen_tekst ) : ?>
                            <div class="mk-vac-sectie__text"><?php echo mediakanjers_richtext( $wat_ga_je_doen_tekst ); ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if ( $wat_ga_je_doen_afbeelding ) : ?>
                        <div class="mk-vac-sectie--media__media">
                            <img src="<?php echo esc_url( $wat_ga_je_doen_afbeelding['url'] ); ?>" alt="<?php echo esc_attr( $wat_ga_je_doen_afbeelding['alt'] ); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( $wat_vragen_wij || $wat_bieden_wij ) : ?>
            <section id="vragen-bieden" class="mk-vac-sectie mk-vac-vraag-bod-sectie mk-block-spacing">
                <div class="container mk-vac-vraag-bod-sectie__media">
                    <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/single-vacature-persons.png' ); ?>" alt="">
                </div>
                <div class="container mk-vac-vraag-bod">
                    <?php if ( $wat_vragen_wij ) : ?>
                        <div class="mk-vac-vraag-bod__col">
                            <h2 class="mk-vac-sectie__title">Wat vragen wij van jou</h2>
                            <div class="mk-vac-sectie__text"><?php echo mediakanjers_richtext( $wat_vragen_wij ); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ( $wat_bieden_wij ) : ?>
                        <div class="mk-vac-vraag-bod__col">
                            <h2 class="mk-vac-sectie__title">Wat bieden wij jou</h2>
                            <div class="mk-vac-sectie__text"><?php echo mediakanjers_richtext( $wat_bieden_wij ); ?></div>
                            <a class="btn-primary mk-vac-sectie__cta" href="#solliciteren">
                                Solliciteer direct
                                <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( $afdeling_titel || $afdeling_tekst || $afdeling_afbeelding ) : ?>
            <section id="afdeling" class="mk-vac-afdeling mk-block-spacing">
                <div class="container mk-vac-afdeling__intro">
                    <?php if ( $afdeling_titel ) : ?>
                        <h2 class="mk-vac-sectie__title"><?php echo esc_html( $afdeling_titel ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $afdeling_tekst ) : ?>
                        <div class="mk-vac-sectie__text"><?php echo mediakanjers_richtext( $afdeling_tekst ); ?></div>
                    <?php endif; ?>
                </div>

                <?php if ( $afdeling_afbeelding ) : ?>
                    <div class="container">
                        <div class="mk-vac-afdeling__media"<?php echo $afdeling_heeft_video ? ' data-hero-vimeo-id="' . esc_attr( $afdeling_vimeo_id ) . '"' : ''; ?>>
                            <img
                                class="mk-vac-afdeling__media__image"
                                src="<?php echo esc_url( $afdeling_afbeelding['url'] ); ?>"
                                alt="<?php echo esc_attr( $afdeling_afbeelding['alt'] ); ?>"
                            >
                            <?php if ( $afdeling_heeft_video ) : ?>
                                <div class="mk-vac-afdeling__media__video" data-vimeo-id="<?php echo esc_attr( $afdeling_vimeo_id ); ?>"></div>

                                <button type="button" class="mk-vac-afdeling__watch-video" data-hero-video-trigger="afdeling-<?php echo esc_attr( $vacature_id ); ?>" data-vimeo-id="<?php echo esc_attr( $afdeling_vimeo_id ); ?>">
                                    <span class="mk-vac-afdeling__watch-video__icon">
                                        <?php
                                        $play_icon = get_stylesheet_directory() . '/assets/images/icons/play.svg';
                                        if ( file_exists( $play_icon ) ) {
                                            echo file_get_contents( $play_icon );
                                        }
                                        ?>
                                    </span>
                                    <span class="mk-vac-afdeling__watch-video__label">Bekijk hele video</span>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php if ( $procedure_stappen || $heeft_contact ) : ?>
            <section id="procedure" class="mk-vac-procedure mk-block-spacing">
                <div class="container">
                    <?php if ( $procedure_stappen ) : ?>
                        <div class="mk-vac-procedure__intro">
                            <h2 class="mk-vac-sectie__title">Sollicitatieprocedure</h2>
                            <p class="mk-vac-procedure__subtitel">In <?php echo (int) count( $procedure_stappen ); ?> stappen naar je nieuwe baan</p>
                        </div>

                        <?php $aantal_stappen = count( $procedure_stappen ); ?>
                        <ol class="mk-vac-procedure__tijdlijn" style="--stappen: <?php echo (int) $aantal_stappen; ?>;" data-procedure>
                            <?php foreach ( array_values( $procedure_stappen ) as $index => $stap ) : ?>
                                <li class="mk-vac-procedure__stap" style="--i: <?php echo (int) $index; ?>;">
                                    <div class="mk-vac-procedure__stap__top">
                                        <div class="mk-vac-procedure__stap__icoon">
                                            <?php if ( ! empty( $stap['icoon'] ) ) : ?>
                                                <img src="<?php echo esc_url( $stap['icoon']['url'] ); ?>" alt="">
                                            <?php else : ?>
                                                <span class="mk-vac-procedure__stap__cijfer" aria-hidden="true"><?php echo (int) $index + 1; ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <span class="mk-vac-procedure__stap__nummer"><span class="screen-reader-text">Stap </span><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
                                    </div>
                                    <h3 class="mk-vac-procedure__stap__title"><?php echo esc_html( $stap['titel'] ?? '' ); ?></h3>
                                    <p class="mk-vac-procedure__stap__text"><?php echo wp_kses_post( $stap['tekst'] ?? '' ); ?></p>
                                    <span class="mk-vac-procedure__stap__balk" aria-hidden="true"></span>
                                    <?php if ( $index < $aantal_stappen - 1 ) : ?>
                                        <span class="mk-vac-procedure__stap__pijl" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                                        </span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>

                    <?php if ( $heeft_contact ) : ?>
                        <?php
                        get_template_part( 'template-parts/contact-cta', null, array(
                            'titel'    => $contact_titel,
                            'intro'    => $contact_intro,
                            'naam'     => $contact_naam,
                            'functie'  => $contact_functie,
                            'telefoon' => $contact_telefoon,
                            'email'    => $contact_email,
                            'foto'     => $contact_afbeelding,
                        ) );
                        ?>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php get_template_part( 'template-parts/reistijd' ); ?>

        <section id="solliciteren" class="mk-vac-formulier mk-block-spacing">


            <div class="mk-vac-formulier__bg">
            <div class="container mk-vac-formulier__intro">
                <?php if ( $formulier_subtitel ) : ?>
                    <p class="mk-vac-formulier__subtitel"><?php echo esc_html( $formulier_subtitel ); ?></p>
                <?php endif; ?>
                <?php if ( $formulier_titel ) : ?>
                    <h2 class="mk-vac-formulier__title"><?php echo esc_html( $formulier_titel ); ?></h2>
                <?php endif; ?>
            </div>
                <div class="container">
                    <div class="mk-vac-formulier__form">
                        <?php
                        if ( shortcode_exists( 'gravityform' ) ) {
                            echo do_shortcode( '[gravityform id="' . (int) $mediakanjers_gf_form_id . '" title="false" description="false" ajax="true"]' );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php
endwhile;

get_footer();
