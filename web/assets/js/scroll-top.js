jQuery(document).ready(function ($) {
    var $btn = $('.mk-scroll-top');

    if (!$btn.length) {
        return;
    }

    function toggleVisibility() {
        if ($(window).scrollTop() > 400) {
            $btn.addClass('is-visible');
        } else {
            $btn.removeClass('is-visible');
        }
    }

    toggleVisibility();
    $(window).on('scroll', toggleVisibility);

    $btn.on('click', function () {
        $('html, body').animate({ scrollTop: 0 }, 500);
    });
});
