jQuery(document).ready(function ($) {
    // Alle vacatures staan al in de pagina; filteren en "Bekijk meer" gebeuren
    // hier direct in de browser, zonder serververzoek.
    var $grid = $('[data-vacature-grid]');

    if (!$grid.length) {
        return;
    }

    var $filters = $('[data-vacature-filters]');
    var $cards = $grid.find('.mk-vacature-card');
    var $count = $('[data-vacature-count]');
    var $empty = $('[data-vacature-empty]');
    var $loadMoreWrap = $('.mk-vacature-archief__load-more');
    var perPagina = parseInt($grid.attr('data-per-pagina'), 10) || 12;

    var sector = $grid.attr('data-sector') || 'alle';
    var zichtbaar = perPagina;

    function toon() {
        var aantal = 0;

        $cards.each(function () {
            var sectoren = ($(this).attr('data-sectoren') || '').split(' ');
            var match = sector === 'alle' || sectoren.indexOf(sector) !== -1;

            if (match) {
                aantal++;
            }

            $(this).toggleClass('is-hidden', !match || aantal > zichtbaar);
        });

        $count.text('Resultaten: ' + aantal + ' vacatures');
        $empty.toggleClass('is-hidden', aantal > 0);
        $loadMoreWrap.toggleClass('is-hidden', aantal <= zichtbaar);
    }

    $filters.on('click', '[data-sector]', function () {
        var $btn = $(this);

        sector = $btn.attr('data-sector');
        zichtbaar = perPagina;

        $filters.find('[data-sector]').removeClass('is-active');
        $btn.addClass('is-active');

        var url = new URL(window.location.href);
        if (sector === 'alle') {
            url.searchParams.delete('sector');
        } else {
            url.searchParams.set('sector', sector);
        }
        window.history.replaceState({}, '', url);

        toon();
    });

    $('[data-vacature-load-more]').on('click', function () {
        zichtbaar += perPagina;
        toon();
    });
});
