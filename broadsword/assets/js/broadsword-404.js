/**
 * Broadsword 404 specific Javascript Code
 *
 */

( function ($) {
    "use strict";

    var header_t = setTimeout(function() {
        $("body").addClass("move");
    }, 500);

    var bgImg = new Image();
    bgImg.id = 'bgLoader';
    bgImg.src = pg_404_script_vars.header_bg_image;

    // Ease in the main container
    $('.header-image').addClass('opaque');

    $(bgImg).load(function () {
        var newBg = "linear-gradient(to bottom, rgba(0,0,0,0.4) 0%,rgba(0,0,0,0.4) 100%), url(" + bgImg.src + ") center / cover";
        $('.header-image').css('background', newBg);
    });

    $(".title-details").addClass("opaque");

}) (jQuery);