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
        // Native scroll: html heeft scroll-behavior: smooth, een jQuery-animate
        // zou daarmee botsen (schokkerig).
        window.scrollTo(0, 0);
    });
});
