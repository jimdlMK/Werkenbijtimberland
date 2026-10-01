jQuery(document).ready(function ($) {
    // Vragen klappen onafhankelijk van elkaar in/uit, zodat bezoekers
    // meerdere antwoorden naast elkaar kunnen lezen.
    $(document).on('click', '.mk-faq__toggle', function () {
        var $toggle = $(this);
        var $item = $toggle.closest('.mk-faq__item');
        var isOpen = $item.toggleClass('is-open').hasClass('is-open');

        $toggle.attr('aria-expanded', isOpen ? 'true' : 'false');
    });
});
