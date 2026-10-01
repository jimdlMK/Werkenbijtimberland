jQuery(document).ready(function ($) {
    var $calc = $('[data-reistijd]');

    if (!$calc.length || typeof mediakanjersReistijd === 'undefined') {
        return;
    }

    var PDOK = 'https://api.pdok.nl/bzk/locatieserver/search/v3_1/';
    var TYPES = 'type:(adres OR postcode OR woonplaats)';

    var $form = $calc.find('[data-reistijd-form]');
    var $input = $calc.find('[data-reistijd-input]');
    var $list = $calc.find('[data-reistijd-suggestions]');
    var $submit = $calc.find('[data-reistijd-submit]');
    var $error = $calc.find('[data-reistijd-error]');
    var $results = $calc.find('[data-reistijd-results]');
    var $from = $calc.find('[data-reistijd-from]');

    var suggestions = [];
    var activeIndex = -1;
    var selected = null; // { id, naam } van de gekozen suggestie
    var debounce;

    function formatMinuten(min) {
        if (min === null || typeof min === 'undefined') {
            return 'n.v.t.';
        }
        if (min < 60) {
            return min + ' min';
        }
        var uren = Math.floor(min / 60);
        var rest = min % 60;
        return uren + ' uur' + (rest ? ' ' + rest + ' min' : '');
    }

    // PDOK geeft punten terug als "POINT(lng lat)".
    function parsePunt(punt) {
        var m = /POINT\(([-\d.]+) ([-\d.]+)\)/.exec(punt || '');
        return m ? { lng: parseFloat(m[1]), lat: parseFloat(m[2]) } : null;
    }

    function showError(message) {
        $results.prop('hidden', true);
        $error.text(message).prop('hidden', false);
    }

    function closeList() {
        $list.prop('hidden', true).empty();
        $input.attr('aria-expanded', 'false').removeAttr('aria-activedescendant');
        suggestions = [];
        activeIndex = -1;
    }

    function setActive(index) {
        var $items = $list.children();
        $items.removeClass('is-active').attr('aria-selected', 'false');

        if (index < 0 || index >= $items.length) {
            activeIndex = -1;
            $input.removeAttr('aria-activedescendant');
            return;
        }

        activeIndex = index;
        var $item = $items.eq(index).addClass('is-active').attr('aria-selected', 'true');
        $input.attr('aria-activedescendant', $item.attr('id'));
    }

    function choose(index) {
        var doc = suggestions[index];
        if (!doc) {
            return;
        }
        selected = { id: doc.id, naam: doc.weergavenaam };
        $input.val(doc.weergavenaam);
        closeList();
    }

    function renderList(docs) {
        suggestions = docs;
        $list.empty();

        if (!docs.length) {
            closeList();
            return;
        }

        $.each(docs, function (i, doc) {
            $('<li>', {
                id: 'mk-reistijd-optie-' + i,
                role: 'option',
                'aria-selected': 'false',
                'class': 'mk-reistijd__suggestion',
                text: doc.weergavenaam,
            }).appendTo($list);
        });

        $list.prop('hidden', false);
        $input.attr('aria-expanded', 'true');
    }

    $input.on('input', function () {
        var q = $.trim($input.val());
        selected = null;
        clearTimeout(debounce);

        if (q.length < 3) {
            closeList();
            return;
        }

        debounce = setTimeout(function () {
            $.getJSON(PDOK + 'suggest', { q: q, fq: TYPES, rows: 6 }).done(function (data) {
                // Alleen tonen als de invoer intussen niet veranderd is.
                if ($.trim($input.val()) === q) {
                    renderList((data.response && data.response.docs) || []);
                }
            });
        }, 250);
    });

    $input.on('keydown', function (e) {
        if ($list.prop('hidden')) {
            return;
        }

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            setActive(Math.min(activeIndex + 1, suggestions.length - 1));
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            setActive(Math.max(activeIndex - 1, 0));
        } else if (e.key === 'Enter' && activeIndex > -1) {
            e.preventDefault();
            choose(activeIndex);
            $form.trigger('submit');
        } else if (e.key === 'Escape') {
            closeList();
        }
    });

    // mousedown i.p.v. click, zodat de keuze vóór de blur van het veld valt.
    $list.on('mousedown', 'li', function (e) {
        e.preventDefault();
        choose($(this).index());
        $form.trigger('submit');
    });

    $input.on('blur', function () {
        setTimeout(closeList, 150);
    });

    // Gekozen suggestie → exacte lookup; vrije invoer → beste match.
    function resolveLocatie() {
        var fl = 'centroide_ll,weergavenaam';
        var request = selected
            ? $.getJSON(PDOK + 'lookup', { id: selected.id, fl: fl })
            : $.getJSON(PDOK + 'free', { q: $.trim($input.val()), fq: TYPES, rows: 1, fl: fl });

        return request.then(function (data) {
            var doc = data.response && data.response.docs && data.response.docs[0];
            var punt = doc && parsePunt(doc.centroide_ll);
            return punt ? $.extend(punt, { naam: doc.weergavenaam }) : $.Deferred().reject().promise();
        });
    }

    $form.on('submit', function (e) {
        e.preventDefault();
        closeList();

        if (!$.trim($input.val())) {
            showError('Vul je postcode of adres in.');
            $input.trigger('focus');
            return;
        }

        $error.prop('hidden', true);
        $submit.prop('disabled', true).addClass('is-loading');

        resolveLocatie()
            .fail(function () {
                showError('We kunnen dit adres niet vinden. Controleer je postcode of adres.');
            })
            .then(function (locatie) {
                $input.val(locatie.naam);

                return $.post(mediakanjersReistijd.ajaxUrl, {
                    action: 'mediakanjers_reistijd',
                    lat: locatie.lat,
                    lng: locatie.lng,
                }).done(function (response) {
                    if (!response || !response.success) {
                        showError('Er ging iets mis bij het berekenen. Probeer het later opnieuw.');
                        return;
                    }

                    $.each(response.data, function (modus, minuten) {
                        $calc.find('[data-reistijd-value="' + modus + '"]').text(formatMinuten(minuten));
                    });

                    $from.text(locatie.naam);
                    $results.prop('hidden', false);
                }).fail(function (xhr) {
                    var data = xhr.responseJSON && xhr.responseJSON.data;
                    showError((data && data.message) || 'Er ging iets mis bij het berekenen. Probeer het later opnieuw.');
                });
            })
            .always(function () {
                $submit.prop('disabled', false).removeClass('is-loading');
            });
    });
});
