/**
 * Geeft elke ACF-WYSIWYG-editor een class met de veldnaam op de body
 * ("mk-veld-{naam}"), zodat style-editor.css per veld dezelfde opmaak kan
 * tonen als op de voorkant (bijv. vinkjes bij de stage-checklists).
 *
 * Bewust buiten assets/js: die map wordt gebundeld voor de voorkant.
 */
(function () {
    if (typeof acf === 'undefined' || !acf.add_filter) {
        return;
    }

    acf.add_filter('wysiwyg_tinymce_settings', function (mceInit, id, field) {
        var naam = field && field.get ? field.get('name') : '';

        if (naam) {
            mceInit.body_class = (mceInit.body_class || '') + ' mk-veld-' + naam;
        }

        return mceInit;
    });
})();
