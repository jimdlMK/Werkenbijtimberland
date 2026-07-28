jQuery(document).ready(function ($) {
    if (typeof Swiper === 'undefined') {
        return;
    }

    $('.swiper[data-slider-type="gallerij"]').each(function () {
        new Swiper(this, {
            slidesPerView: 1.2,
            spaceBetween: 20,
            loop: true,
            speed: 600,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
        });
    });

    $('.swiper[data-slider-type="merken"]').each(function () {
        var $swiper = $(this);
        var sliderId = $swiper.attr('id');
        var $progressbar = $('[data-progressbar-for="' + sliderId + '"]');

        new Swiper(this, {
            slidesPerView: 'auto',
            spaceBetween: 20,
            speed: 600,
            loop: true,
            centeredSlides: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: $progressbar.length ? $progressbar[0] : null,
                type: 'progressbar',
            },
        });
    });

    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind('[data-fancybox="mk-gallerij"]', {});
    }
});
