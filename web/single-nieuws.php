<?php
/**
 * Single: Nieuws
 */

get_header();

while ( have_posts() ) :
    the_post();

    $nieuws_id = get_the_ID();
    $intro     = get_field( 'nieuws_intro', $nieuws_id );
    $thumbnail = get_field( 'nieuws_thumbnail', $nieuws_id );

    $meer_nieuws = get_posts( array(
        'post_type'      => 'nieuws',
        'posts_per_page' => 3,
        'post__not_in'   => array( $nieuws_id ),
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );
    ?>

    <div id="main-content" class="vervolgpagina">
        <section class="mk-nieuws-header">
            <div class="container">
                <nav class="mk-nieuws-header__breadcrumb">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> &gt;
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'nieuws' ) ); ?>">Nieuws</a> &gt;
                    <span><?php the_title(); ?></span>
                </nav>

                <p class="mk-nieuws-header__datum"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></p>
                <h1 class="mk-nieuws-header__title"><?php the_title(); ?></h1>

                <?php if ( $intro ) : ?>
                    <div class="mk-nieuws-header__intro"><?php echo wp_kses_post( wpautop( $intro ) ); ?></div>
                <?php endif; ?>
            </div>

            <?php if ( $thumbnail ) : ?>
                <div class="container">
                    <div class="mk-nieuws-header__media">
                        <img src="<?php echo esc_url( $thumbnail['url'] ); ?>" alt="<?php echo esc_attr( $thumbnail['alt'] ?: get_the_title() ); ?>">
                    </div>
                </div>
            <?php endif; ?>
        </section>

        <section class="mk-nieuws-content mk-block-spacing">
            <div class="container mk-nieuws-content__inner">
                <?php the_content(); ?>
            </div>
        </section>

        <?php if ( ! empty( $meer_nieuws ) ) : ?>
            <section class="mk-nieuws-meer mk-block-spacing">
                <div class="container">
                    <h2 class="mk-nieuws-meer__title">Meer nieuws</h2>
                    <div class="mk-nieuws-meer__grid">
                        <?php foreach ( $meer_nieuws as $item ) : ?>
                            <?php get_template_part( 'template-parts/nieuws-card', null, array( 'nieuws_id' => $item->ID ) ); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>

<?php
endwhile;

get_footer();
