  <div class="mk-footer__container">
    <div class="mk-footer__container__inner">
        <?php
        $footer_logo = get_field( 'footer_logo', 'option' );
        if ( $footer_logo ) :
        ?>
        <div class="mk-footer__logo">
            <img src="<?php echo esc_url( $footer_logo['url'] ); ?>" alt="<?php echo esc_attr( $footer_logo['alt'] ?: 'VF Corporation' ); ?>">
        </div>
        <?php endif; ?>

        <div class="mk-footer__menus">
            <?php get_template_part( 'template-parts/footer/nav-footer' ); ?>
        </div>

        <div class="mk-footer__side">
            <?php get_template_part( 'template-parts/contact/socials-footer' ); ?>

            <div class="mk-footer__links">
                <?php
                $timberland_link = get_field( 'externe_link_timberland', 'option' );
                $vfc_link        = get_field( 'externe_link_vfc', 'option' );
                $arrow_icon      = get_stylesheet_directory() . '/assets/images/icons/arrow-right-copper.svg';

                if ( $timberland_link && ! empty( $timberland_link['url'] ) ) :
                ?>
                <a class="mk-footer__links__item" href="<?php echo esc_url( $timberland_link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
                    <span><?php echo esc_html( $timberland_link['title'] ?: 'Timberland.nl' ); ?></span>
                    <?php if ( file_exists( $arrow_icon ) ) echo file_get_contents( $arrow_icon ); ?>
                </a>
                <?php endif; ?>

                <?php if ( $vfc_link && ! empty( $vfc_link['url'] ) ) : ?>
                <a class="mk-footer__links__item" href="<?php echo esc_url( $vfc_link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
                    <span><?php echo esc_html( $vfc_link['title'] ?: 'VFC.com' ); ?></span>
                    <?php if ( file_exists( $arrow_icon ) ) echo file_get_contents( $arrow_icon ); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="mk-footer__legal">
        <?php
        $legal_pages = array(
            'disclaimer'          => 'Disclaimer',
            'privacy-statement'   => 'Privacy statement',
            'algemene-voorwaarden' => 'Algemene voorwaarden',
            'cookies'             => 'Cookies',
        );
        $legal_links = array();

        foreach ( $legal_pages as $slug => $label ) {
            $page = get_page_by_path( $slug );
            if ( $page ) {
                $legal_links[] = '<a href="' . esc_url( get_permalink( $page ) ) . '">' . esc_html( $label ) . '</a>';
            }
        }

        echo implode( ' <span class="mk-footer__legal__divider">|</span> ', $legal_links );
        ?>
    </div>
</div>
