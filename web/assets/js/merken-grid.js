jQuery(document).ready(function ($) {
    $(document).on('click', '.mk-merken-grid__toggle', function () {
        var $toggle = $(this);
        var $item = $toggle.closest('.mk-merken-grid__item');
        var $grid = $toggle.closest('.mk-merken-grid__grid');
        var isOpen = $item.hasClass('is-open');

        $grid.find('.mk-merken-grid__item.is-open').each(function () {
            $(this).removeClass('is-open');
            $(this).find('.mk-merken-grid__toggle').attr('aria-expanded', 'false');
        });

        if (!isOpen) {
            $item.addClass('is-open');
            $toggle.attr('aria-expanded', 'true');
        }
    });
});
