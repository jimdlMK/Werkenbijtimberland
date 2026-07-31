jQuery(document).ready(function ($) {
    var $filters = $('[data-nieuws-filters]');
    var $grid = $('[data-nieuws-grid]');
    var $count = $('[data-nieuws-count]');
    var $loadMoreWrap = $('.mk-nieuws-archief__load-more');
    var $loadMoreBtn = $('[data-nieuws-load-more]');

    if (!$filters.length && !$loadMoreBtn.length) {
        return;
    }

    if (typeof mediakanjersNieuws === 'undefined') {
        return;
    }

    function fetchNieuws(categorie, page, append) {
        return $.post(mediakanjersNieuws.ajaxUrl, {
            action: 'mediakanjers_nieuws_query',
            nonce: mediakanjersNieuws.nonce,
            categorie: categorie,
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

            $count.text('Resultaten: ' + data.found_posts + ' berichten');

            if (data.page >= data.max_pages) {
                $loadMoreWrap.hide();
            } else {
                $loadMoreWrap.show();
                $loadMoreBtn.attr('data-page', data.page);
                $loadMoreBtn.attr('data-max-pages', data.max_pages);
            }
        });
    }

    $filters.on('click', '[data-categorie]', function () {
        var $btn = $(this);
        var categorie = $btn.data('categorie');

        $filters.find('[data-categorie]').removeClass('is-active');
        $btn.addClass('is-active');

        var url = new URL(window.location.href);
        if ('alle' === categorie) {
            url.searchParams.delete('categorie');
        } else {
            url.searchParams.set('categorie', categorie);
        }
        window.history.replaceState({}, '', url);

        $loadMoreBtn.attr('data-categorie', 'alle' === categorie ? '' : categorie);
        fetchNieuws('alle' === categorie ? '' : categorie, 1, false);
    });

    $loadMoreBtn.on('click', function () {
        var $btn = $(this);
        var nextPage = parseInt($btn.attr('data-page'), 10) + 1;
        var categorie = $btn.attr('data-categorie') || '';

        fetchNieuws(categorie, nextPage, true);
    });
});
