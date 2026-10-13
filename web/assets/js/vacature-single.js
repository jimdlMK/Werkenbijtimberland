jQuery(document).ready(function ($) {
    if (!('IntersectionObserver' in window)) {
        return;
    }

    // ===== Snelnavigatie: verschijnt zodra de vacature-header uit beeld is =====
    var $subnav = $('[data-vac-subnav]');
    var header = document.querySelector('.mk-vac-header');

    if ($subnav.length && header) {
        new IntersectionObserver(function (entries) {
            var entry = entries[0];
            // Alleen tonen als de header boven het scherm verdwenen is (niet als
            // de pagina nog niet zo ver gescrold is).
            $subnav.toggleClass('is-visible', !entry.isIntersecting && entry.boundingClientRect.top < 0);
        }).observe(header);

        // Actieve sectie markeren (scrollspy).
        var $links = $subnav.find('[data-vac-subnav-links] a');
        var linkList = $subnav.find('[data-vac-subnav-links]')[0];

        var spy = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                var $actief = $links.removeClass('is-active').filter('[href="#' + entry.target.id + '"]').addClass('is-active');

                // Op mobiel de actieve link in beeld schuiven binnen de balk.
                if ($actief.length && linkList && linkList.scrollWidth > linkList.clientWidth) {
                    var link = $actief[0];
                    linkList.scrollTo({
                        left: link.offsetLeft - (linkList.clientWidth - link.offsetWidth) / 2,
                        behavior: 'smooth',
                    });
                }
            });
        }, { rootMargin: '-35% 0px -60% 0px' });

        $links.each(function () {
            var target = document.getElementById(this.getAttribute('href').slice(1));
            if (target) {
                spy.observe(target);
            }
        });
    }

    // ===== Sollicitatieprocedure: stappen en lijn animeren bij in beeld komen =====
    var tijdlijn = document.querySelector('[data-procedure]');

    if (tijdlijn && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        // Pas verbergen als JS draait, zodat de stappen zonder JS gewoon zichtbaar zijn.
        tijdlijn.classList.add('is-animated');

        var reveal = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                tijdlijn.classList.add('is-visible');
                reveal.disconnect();
            }
        }, { threshold: 0.25 });

        reveal.observe(tijdlijn);
    }
});
