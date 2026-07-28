<div class="mk-nav-main">
    <?php
    wp_nav_menu( array(
        'menu'            => 'Hoofdmenu',
        'walker'          => new Mediakanjers_Nav_Badge_Walker(),
        'container'       => false,
    ) );
    ?>
</div>