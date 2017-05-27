"use strict";
jQuery(window).on('load', function () {
    //if (jQuery('.parallax').length) {
        jQuery('.parallax').each(function () {
            jQuery(this).parallax("50%", 0.1);
        });
    //}
});

jQuery(window).load(function () {
    jQuery(document).find('body').addClass('loaded');
});
