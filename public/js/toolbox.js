/**
 * Toolbox functions.
 *
 * @author Frank Verhoeven <hi@frankverhoeven.me>
 */
(function($) {

    $(document).ready(function() {
        $('.fvch-toolbox').removeClass('fvch-hide-if-no-js');

        $('.fvch-toolbox-icon-select').click(function() {
            var range;
            var $codeBlock = $(this).parents('.fvch-codeblock').find('.fvch-code');

            if (document.body.createTextRange) { // ms
                range = document.body.createTextRange();
                range.moveToElementText($codeBlock[0]);
                range.select();
            } else if (window.getSelection) { // moz, opera, webkit
                var selection = window.getSelection();
                range = document.createRange();
                range.selectNodeContents($codeBlock[0]);
                selection.removeAllRanges();
                selection.addRange(range);
            }
        });
    });

})(jQuery);
