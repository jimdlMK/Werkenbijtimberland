<?php
$linkedin_url = '';
if ( have_rows( 'socials', 'option' ) ) :
    while ( have_rows( 'socials', 'option' ) ) : the_row();
        if ( get_sub_field( 'platform' ) === 'linkedin' ) {
            $linkedin_url = get_sub_field( 'url' );
        }
    endwhile;
endif;
$linkedin_icon = get_stylesheet_directory() . '/assets/images/icons/linkedin-header.svg';
?>
<div class="mk-mobile-menu">
    <div class="mk-mobile-menu__inner">
        <div class="mk-mobile-menu__inner__top">
            <img class="mk-mobile-menu__inner__top__logo" src="<?php echo esc_url(get_field('logo' , 'option')['url']);?>">
            <div class="close">
                <span class="lineone"></span>
                <span class="linetwo"></span>
            </div>
        </div>
        <div class="mk-mobile-menu__inner__menu">
            <?php wp_nav_menu( array( 'menu' => 'Hoofdmenu' ) ); ?>
        </div>
        <div class="mk-mobile-menu__inner__bottom">
            <ul class="mk-mobile-menu__external">
                <?php if ( $linkedin_url ) : ?>
                    <li>
                        <a href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" rel="noopener noreferrer">
                            <span class="mk-mobile-menu__external__icon">
                                <?php if ( file_exists( $linkedin_icon ) ) : ?>
                                    <?php echo file_get_contents( $linkedin_icon ); ?>
                                <?php endif; ?>
                            </span>
                            <span class="mk-mobile-menu__external__label">LinkedIn</span>
                            <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'copper' ) ); ?>
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="https://vfc.com" target="_blank" rel="noopener noreferrer">
                        <span class="mk-mobile-menu__external__label">VFC</span>
                        <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'copper' ) ); ?>
                    </a>
                </li>
                <li>
                    <a href="https://timberland.nl" target="_blank" rel="noopener noreferrer">
                        <span class="mk-mobile-menu__external__label">Timberland</span>
                        <?php get_template_part( 'template-parts/blocks/partials/arrow-icon', null, array( 'color' => 'copper' ) ); ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>