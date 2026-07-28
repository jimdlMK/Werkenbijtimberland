<?php
$is_subpage       = ! is_front_page();
$subpagina_logo   = $is_subpage ? get_field( 'subpagina_logo', 'option' ) : '';
$header_logo      = $subpagina_logo ?: get_field( 'logo', 'option' );
?>
<header class="mk-header<?php echo $is_subpage ? ' mk-header--on-light' : ''; ?>">
    <div class="mk-header__inner">
        <a class="mk-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php if ( $header_logo ) : ?>
                <img src="<?php echo esc_url( $header_logo['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
            <?php endif; ?>
        </a>

        <div class="mk-header__nav-area">
            <div class="mk-header__nav-col">
                <div class="mk-header__topmenu">
                    <?php
                    $linkedin_url = '';
                    if ( have_rows( 'socials', 'option' ) ) :
                        while ( have_rows( 'socials', 'option' ) ) : the_row();
                            if ( get_sub_field( 'platform' ) === 'linkedin' ) {
                                $linkedin_url = get_sub_field( 'url' );
                            }
                        endwhile;
                    endif;

                    if ( $linkedin_url ) :
                        $linkedin_icon = get_stylesheet_directory() . '/assets/images/icons/linkedin-header.svg';
                    ?>
                    <a class="mk-header__topmenu__social" href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                        <?php if ( file_exists( $linkedin_icon ) ) : ?>
                            <?php echo file_get_contents( $linkedin_icon ); ?>
                        <?php endif; ?>
                    </a>
                    <?php endif; ?>
                    <span class="mk-header__topmenu__vfc">VFC</span>
                    <span class="mk-header__topmenu__timberland">TIMBERLAND</span>
                </div>

                <?php get_template_part( 'template-parts/header/nav-main' ); ?>
            </div>

            <div class="mk-header__bottom-row">
                <a class="mk-header__jobalert" href="/vacatures">
                    <span class="mk-header__jobalert__icon">
                        <?php
                        $bell_icon = get_stylesheet_directory() . '/assets/images/icons/bell.svg';
                        if ( file_exists( $bell_icon ) ) {
                            echo file_get_contents( $bell_icon );
                        }
                        ?>
                    </span>
                    <span class="mk-header__jobalert__label">Jobalert</span>
                </a>

                <div class="open-mobile-menu">
                    <span class="lineone"></span>
                    <span class="linetwo"></span>
                    <span class="linethree"></span>
                </div>
            </div>
        </div>
    </div>
</header>
