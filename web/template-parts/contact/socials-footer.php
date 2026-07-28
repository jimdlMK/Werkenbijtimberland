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
<a class="mk-footer__social" href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
    <?php if ( file_exists( $linkedin_icon ) ) : ?>
        <?php echo file_get_contents( $linkedin_icon ); ?>
    <?php endif; ?>
</a>
<?php endif; ?>
