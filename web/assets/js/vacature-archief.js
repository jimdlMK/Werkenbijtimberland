jQuery(document).ready(function ($) {
    var $filters = $('[data-vacature-filters]');
    var $grid = $('[data-vacature-grid]');
    var $count = $('[data-vacature-count]');
    var $loadMoreWrap = $('.mk-vacature-archief__load-more');
    var $loadMoreBtn = $('[data-vacature-load-more]');

    if (!$filters.length && !$loadMoreBtn.length) {
        return;
    }

    if (typeof mediakanjersVacatures === 'undefined') {
        return;
    }

    function fetchVacatures(sector, page, append) {
        return $.post(mediakanjersVacatures.ajaxUrl, {
            action: 'mediakanjers_vacatures_query',
            nonce: mediakanjersVacatures.nonce,
            sector: sector,
            page: page,
        }).done(function (response) {
            if (!response || !response.success) {
                return;
            }

            var data = response.data;

            if (append) {
                $grid.append(data.html);
            } else {
                $grid.html(data.html);
            }

            $count.text('Resultaten: ' + data.found_posts + ' vacatures');

            if (data.page >= data.max_pages) {
                $loadMoreWrap.hide();
            } else {
                $loadMoreWrap.show();
                $loadMoreBtn.attr('data-page', data.page);
                $loadMoreBtn.attr('data-max-pages', data.max_pages);
            }
        });
    }

    $filters.on('click', '[data-sector]', function () {
        var $btn = $(this);
        var sector = $btn.data('sector');

        $filters.find('[data-sector]').removeClass('is-active');
        $btn.addClass('is-active');

        var url = new URL(window.location.href);
        if ('alle' === sector) {
            url.searchParams.delete('sector');
        } else {
            url.searchParams.set('sector', sector);
        }
        window.history.replaceState({}, '', url);

        $loadMoreBtn.attr('data-sector', 'alle' === sector ? '' : sector);
        fetchVacatures('alle' === sector ? '' : sector, 1, false);
    });

    $loadMoreBtn.on('click', function () {
        var $btn = $(this);
        var nextPage = parseInt($btn.attr('data-page'), 10) + 1;
        var sector = $btn.attr('data-sector') || '';

        fetchVacatures(sector, nextPage, true);
    });
});
