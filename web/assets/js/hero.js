jQuery(document).ready(function ($) {
    // Achtergrondvideo: iframe pas injecteren op desktop/tablet, zodat
    // mobiel nooit een Vimeo-embed laadt (data/performance).
    function loadHeroBackgroundVideo() {
        $('.mk-hero[data-hero-vimeo-id], .mk-titel-tekst__media-onder[data-hero-vimeo-id]').each(function () {
            var $hero = $(this);
            var $target = $hero.find('.mk-hero__media__video, .mk-titel-tekst__media-onder__video');

            if (!$target.length || $target.find('iframe').length) {
                return;
            }

            if (window.innerWidth < 768) {
                return;
            }

            var vimeoId = $hero.data('hero-vimeo-id');
            var src = 'https://player.vimeo.com/video/' + vimeoId +
                '?background=1&autoplay=1&muted=1&loop=1&byline=0&title=0&portrait=0';

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

    function openLightbox(vimeoId) {
        var src = 'https://player.vimeo.com/video/' + vimeoId + '?autoplay=1';
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
        openLightbox($(this).data('vimeo-id'));
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
