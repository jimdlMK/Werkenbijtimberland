jQuery(document).ready(function ($) {
    if (typeof Swiper === 'undefined') {
        return;
    }

    // Bij "links"/"rechts" afgesneden mag de slider nooit voorbij de
    // afgesneden rand schuiven: loop (oneindig doorlopen via klonen) staat
    // dan uit, rewind zorgt dat hij na de laatste slide terugspringt naar
    // het begin — slide-index 0 blijft zo de harde grens aan de afgesneden
    // kant, alleen de open kant kan slides onthullen.
    $('.swiper[data-slider-type="gallerij"]').each(function () {
        var $swiper = $(this);
        var edge = $swiper.data('slider-edge') || 'vol';

        new Swiper(this, {
            // Slides wisselen om en om verticaal/liggend (zie slider.php)
            // en hebben dus elk hun eigen breedte — 'auto' laat elke
            // slide zijn eigen CSS-breedte behouden i.p.v. gelijk te trekken.
            slidesPerView: 'auto',
            spaceBetween: 40,
            loop: 'vol' === edge,
            rewind: 'vol' !== edge,
            speed: 600,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });
    });

    $('.swiper[data-slider-type="merken"]').each(function () {
        var $swiper = $(this);
        var sliderId = $swiper.attr('id');
        var $progressbar = $('[data-progressbar-for="' + sliderId + '"]');
        var edge = $swiper.data('slider-edge') || 'vol';

        new Swiper(this, {
            slidesPerView: 'auto',
            spaceBetween: 20,
            speed: 600,
            loop: 'vol' === edge,
            rewind: 'vol' !== edge,
            centeredSlides: 'vol' === edge,
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

    $('.swiper[data-slider-type="sectoren"]').each(function () {
        var $swiper = $(this);
        var sliderId = $swiper.attr('id');
        var $progressbar = $('[data-progressbar-for="' + sliderId + '"]');
        var edge = $swiper.data('slider-edge') || 'vol';

        new Swiper(this, {
            slidesPerView: 'auto',
            spaceBetween: 20,
            speed: 600,
            loop: 'vol' === edge,
            rewind: 'vol' !== edge,
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

    $('.swiper[data-slider-type="vacatures"]').each(function () {
        var $swiper = $(this);
        var sliderId = $swiper.attr('id');
        var $dots = $('[data-dots-for="' + sliderId + '"]');
        var edge = $swiper.data('slider-edge') || 'vol';

        new Swiper(this, {
            slidesPerView: 1,
            speed: 600,
            loop: 'vol' === edge,
            rewind: 'vol' !== edge,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: $dots.length ? $dots[0] : null,
                type: 'bullets',
                clickable: true,
            },
        });
    });

    $('.swiper[data-slider-type="stage-reviews"]').each(function () {
        var $swiper = $(this);
        var sliderId = $swiper.attr('id');
        var $dots = $('[data-dots-for="' + sliderId + '"]');

        new Swiper(this, {
            slidesPerView: 'auto',
            spaceBetween: 20,
            speed: 600,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: $dots.length ? $dots[0] : null,
                type: 'bullets',
                clickable: true,
            },
        });
    });

    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind('[data-fancybox="mk-gallerij"]', {});
    }
});
