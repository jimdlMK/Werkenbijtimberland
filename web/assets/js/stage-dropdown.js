jQuery(document).ready(function ($) {
    $(document).on('click', '.mk-stage-dropdown__toggle', function () {
        var $toggle = $(this);
        var $item = $toggle.closest('.mk-stage-dropdown__item');
        var $list = $toggle.closest('.mk-stage-dropdown__list');
        var isOpen = $item.hasClass('is-open');

        $list.find('.mk-stage-dropdown__item.is-open').each(function () {
            $(this).removeClass('is-open');
            $(this).find('.mk-stage-dropdown__toggle').attr('aria-expanded', 'false');
        });

        if (!isOpen) {
            $item.addClass('is-open');
            $toggle.attr('aria-expanded', 'true');
        }
    });
});
