jQuery(document).ready(function ($) {
    var $popup = $('#mk-jobalert-popup');

    if (!$popup.length) {
        return;
    }

    function openPopup() {
        $popup.addClass('is-active').attr('aria-hidden', 'false');
        $('body').addClass('freeze');
    }

    function closePopup() {
        $popup.removeClass('is-active').attr('aria-hidden', 'true');
        $('body').removeClass('freeze');
    }

    $(document).on('click', '[data-jobalert-open]', function (e) {
        e.preventDefault();
        openPopup();
    });

    $(document).on('click', '[data-jobalert-close]', function (e) {
        e.preventDefault();
        closePopup();
    });

    $(document).on('keydown', function (e) {
        if ('Escape' === e.key && $popup.hasClass('is-active')) {
            closePopup();
        }
    });
});
