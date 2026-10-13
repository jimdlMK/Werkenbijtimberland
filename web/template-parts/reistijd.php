<?php
/**
 * Reistijd-calculator (lopen / fietsen / auto naar de vaste bestemming).
 *
 * Gebruikt op de vacature-overzichtpagina en op elke vacaturepagina. Teksten,
 * bestemming en API-key staan in Vacatures instellingen → Reistijd; de
 * berekening zit in assets/functions/reistijd-ajax.php.
 */

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
?>
<section id="reistijd" class="mk-reistijd mk-block-spacing">
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
