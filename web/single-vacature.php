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
    $wat_bieden_cta = get_field( 'vac_wat_bieden_wij_cta', $vacature_id );

    $afdeling_titel      = get_field( 'vac_afdeling_titel', $vacature_id );
    $afdeling_tekst      = get_field( 'vac_afdeling_tekst', $vacature_id );
    $afdeling_afbeelding = get_field( 'vac_afdeling_afbeelding', $vacature_id );
    $afdeling_vimeo_id   = get_field( 'vac_afdeling_vimeo_id', $vacature_id );
    $afdeling_heeft_video = ! empty( $afdeling_vimeo_id );

    $procedure_stappen = get_field( 'vac_procedure_stappen', $vacature_id );

    $contact_naam       = get_field( 'vac_contact_naam', $vacature_id );
    $contact_functie    = get_field( 'vac_contact_functie', $vacature_id );
    $contact_telefoon   = get_field( 'vac_contact_telefoon', $vacature_id );
    $contact_email      = get_field( 'vac_contact_email', $vacature_id );
    $contact_afbeelding = get_field( 'vac_contact_afbeelding', $vacature_id );
    $heeft_contact       = $contact_naam || $contact_telefoon || $contact_email;

    $formulier_titel    = get_field( 'vac_formulier_titel', $vacature_id );
    $formulier_subtitel = get_field( 'vac_formulier_subtitel', $vacature_id );

    $vf_titel = get_field( 'vacopt_vf_titel', 'option' ) ?: 'VF Corporation';
    $vf_tekst = get_field( 'vacopt_vf_tekst', 'option' );
    ?>

    <div id="main-content" class="vervolgpagina">
        <section class="mk-vac-header">
            <div class="container">
                <nav class="mk-vac-header__breadcrumb">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> &gt;
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'vacature' ) ); ?>">Vacatures</a> &gt;
                    <span><?php the_title(); ?></span>
                </nav>

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
                            <?php echo esc_html( $uren ); ?> uur
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
                    <div class="mk-vac-header__intro"><?php echo wp_kses_post( wpautop( $intro ) ); ?></div>
                <?php endif; ?>


                <?php if ( $thumbnail ) : ?>
                    <div class="mk-vac-header__media">
                        <img src="<?php echo esc_url( $thumbnail['url'] ); ?>" alt="<?php echo esc_attr( $thumbnail['alt'] ?: get_the_title() ); ?>">
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php if ( $vf_titel || $vf_tekst ) : ?>
            <section class="mk-vac-vf mk-block-spacing">
                <div class="container">
                    <?php if ( $vf_titel ) : ?>
                        <h2 class="mk-vac-vf__title"><?php echo esc_html( $vf_titel ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $vf_tekst ) : ?>
                        <div class="mk-vac-vf__text"><?php echo wp_kses_post( $vf_tekst ); ?></div>
                    <?php endif; ?>
                </div>

                <?php get_template_part( 'template-parts/merken-ticker' ); ?>
            </section>
        <?php endif; ?>

        <?php if ( $jouw_rol ) : ?>
            <section class="mk-vac-sectie mk-vac-sectie--centered mk-block-spacing">
                <div class="container">
                    <h2 class="mk-vac-sectie__title">Jouw rol als <?php the_title(); ?></h2>
                    <div class="mk-vac-sectie__text"><?php echo wp_kses_post( $jouw_rol ); ?></div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( $wat_ga_je_doen_tekst || $wat_ga_je_doen_afbeelding ) : ?>
            <section class="mk-vac-sectie mk-vac-sectie--media mk-block-spacing">
                <div class="container mk-vac-sectie--media__grid">
                    <div class="mk-vac-sectie--media__content">
                        <h2 class="mk-vac-sectie__title">Wat ga je doen</h2>
                        <?php if ( $wat_ga_je_doen_tekst ) : ?>
                            <div class="mk-vac-sectie__text"><?php echo wp_kses_post( $wat_ga_je_doen_tekst ); ?></div>
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
            <section class="mk-vac-sectie mk-block-spacing">
                <div class="container mk-vac-vraag-bod">
                    <?php if ( $wat_vragen_wij ) : ?>
                        <div class="mk-vac-vraag-bod__col">
                            <h2 class="mk-vac-sectie__title">Wat vragen wij van jou</h2>
                            <div class="mk-vac-sectie__text"><?php echo wp_kses_post( $wat_vragen_wij ); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ( $wat_bieden_wij ) : ?>
                        <div class="mk-vac-vraag-bod__col">
                            <h2 class="mk-vac-sectie__title">Wat bieden wij jou</h2>
                            <div class="mk-vac-sectie__text"><?php echo wp_kses_post( $wat_bieden_wij ); ?></div>
                            <?php if ( $wat_bieden_cta && ! empty( $wat_bieden_cta['url'] ) ) : ?>
                                <a class="btn-primary mk-vac-sectie__cta" href="<?php echo esc_url( $wat_bieden_cta['url'] ); ?>" target="<?php echo esc_attr( $wat_bieden_cta['target'] ?: '_self' ); ?>">
                                    <?php echo esc_html( $wat_bieden_cta['title'] ); ?>
                                    <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'white' ) ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( $afdeling_titel || $afdeling_tekst || $afdeling_afbeelding ) : ?>
            <section class="mk-vac-afdeling mk-block-spacing">
                <div class="container mk-vac-afdeling__intro">
                    <?php if ( $afdeling_titel ) : ?>
                        <h2 class="mk-vac-sectie__title"><?php echo esc_html( $afdeling_titel ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $afdeling_tekst ) : ?>
                        <div class="mk-vac-sectie__text"><?php echo wp_kses_post( $afdeling_tekst ); ?></div>
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
            <section class="mk-vac-procedure mk-block-spacing">
                <div class="container mk-vac-procedure__grid">
                    <?php if ( $procedure_stappen ) : ?>
                        <div class="mk-vac-procedure__col">
                            <h2 class="mk-vac-sectie__title">Sollicitatieprocedure</h2>
                            <div class="mk-vac-procedure__stappen">
                                <?php
                                $totaal = count( $procedure_stappen );
                                foreach ( $procedure_stappen as $index => $stap ) :
                                    $is_laatste = ( $index === $totaal - 1 );
                                ?>
                                    <div class="mk-vac-procedure__stap">
                                        <div class="mk-vac-procedure__stap__card">
                                            <?php if ( ! empty( $stap['icoon'] ) ) : ?>
                                                <div class="mk-vac-procedure__stap__icoon">
                                                    <img src="<?php echo esc_url( $stap['icoon']['url'] ); ?>" alt="">
                                                </div>
                                            <?php endif; ?>
                                            <div class="mk-vac-procedure__stap__content">
                                                <?php if ( ! empty( $stap['titel'] ) ) : ?>
                                                    <h3 class="mk-vac-procedure__stap__title"><?php echo esc_html( $stap['titel'] ); ?></h3>
                                                <?php endif; ?>
                                                <?php if ( ! empty( $stap['tekst'] ) ) : ?>
                                                    <p class="mk-vac-procedure__stap__text"><?php echo esc_html( $stap['tekst'] ); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <?php if ( ! $is_laatste ) : ?>
                                            <div class="mk-vac-procedure__arrow">
                                                <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'blue' ) ); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( $heeft_contact ) : ?>
                        <div class="mk-vac-procedure__col mk-vac-procedure__col--contact">
                            <div class="mk-vac-contact__card">
                                <?php if ( $contact_afbeelding ) : ?>
                                    <div class="mk-vac-contact__media">
                                        <img src="<?php echo esc_url( $contact_afbeelding['url'] ); ?>" alt="<?php echo esc_attr( $contact_afbeelding['alt'] ?: $contact_naam ); ?>">
                                    </div>
                                <?php endif; ?>
                                <div class="mk-vac-contact__content">
                                    <h2 class="mk-vac-contact__title">Meer weten over deze vacature?</h2>
                                    <p class="mk-vac-contact__intro">Neem contact op met:</p>
                                    <?php if ( $contact_naam ) : ?>
                                        <p class="mk-vac-contact__naam">
                                            <?php echo esc_html( $contact_naam ); ?>
                                            <?php if ( $contact_functie ) : ?>
                                                <span class="mk-vac-contact__functie"><?php echo esc_html( $contact_functie ); ?></span>
                                            <?php endif; ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if ( $contact_telefoon ) : ?>
                                        <p class="mk-vac-contact__detail"><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $contact_telefoon ) ); ?>"><?php echo esc_html( $contact_telefoon ); ?></a></p>
                                    <?php endif; ?>
                                    <?php if ( $contact_email ) : ?>
                                        <p class="mk-vac-contact__detail"><a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

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
