jQuery(document).ready(function ($) {
    // Het Vimeo-veld mag een los ID zijn, of een volledige (share/embed) link.
    // Niet-openbare video's hebben een privacy-hash nodig (vimeo.com/ID/HASH
    // of ?h=HASH), anders weigert Vimeo de embed. Die nemen we hier mee.
    function vimeoSrc(value, params) {
        value = $.trim(String(value || ''));

        var id = value.match(/(\d{6,})/);
        if (!id) {
            return '';
        }

        var hash = value.match(/[?&]h=([0-9a-f]+)/i) || value.match(new RegExp(id[1] + '\\/([0-9a-f]+)', 'i'));

        return 'https://player.vimeo.com/video/' + id[1] + '?' + (hash ? 'h=' + hash[1] + '&' : '') + params;
    }

    // Achtergrondvideo: iframe pas injecteren op desktop/tablet, zodat
    // mobiel nooit een Vimeo-embed laadt (data/performance).
    function loadHeroBackgroundVideo() {
        $('.mk-hero[data-hero-vimeo-id], .mk-titel-tekst__media-onder[data-hero-vimeo-id], .mk-vac-afdeling__media[data-hero-vimeo-id]').each(function () {
            var $hero = $(this);
            var $target = $hero.find('.mk-hero__media__video, .mk-titel-tekst__media-onder__video, .mk-vac-afdeling__media__video');

            if (!$target.length || $target.find('iframe').length) {
                return;
            }

            if (window.innerWidth < 768) {
                return;
            }

            var src = vimeoSrc($hero.attr('data-hero-vimeo-id'), 'background=1&autoplay=1&muted=1&loop=1&byline=0&title=0&portrait=0');

            if (!src) {
                return;
            }

            $target.html('<iframe src="' + src + '" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>');
        });
    }

    loadHeroBackgroundVideo();

    var resizeTimer;
    $(window).on('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(loadHeroBackgroundVideo, 250);
    });

    // "Bekijk hele video" lightbox
    var $lightbox = $('<div class="mk-video-lightbox">' +
        '<div class="mk-video-lightbox__inner">' +
        '<button type="button" class="mk-video-lightbox__close" aria-label="Sluiten"></button>' +
        '<div class="mk-video-lightbox__frame"></div>' +
        '</div>' +
        '</div>');
    $('body').append($lightbox);

    var $lightboxFrame = $lightbox.find('.mk-video-lightbox__frame');

    function openLightbox(vimeoValue) {
        var src = vimeoSrc(vimeoValue, 'autoplay=1');

        if (!src) {
            return;
        }

        $lightboxFrame.html('<iframe src="' + src + '" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>');
        $lightbox.addClass('is-active');
        $('body').addClass('freeze');
    }

    function closeLightbox() {
        $lightbox.removeClass('is-active');
        $lightboxFrame.empty();
        $('body').removeClass('freeze');
    }

    $(document).on('click', '[data-hero-video-trigger]', function () {
        openLightbox($(this).attr('data-vimeo-id'));
    });

    $lightbox.on('click', '.mk-video-lightbox__close', closeLightbox);

    $lightbox.on('click', function (e) {
        if (e.target === this) {
            closeLightbox();
        }
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
});
