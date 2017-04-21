/**
 * Broadsword contact page specific Javascript Code
 *
 */

( function ($) {
    "use strict";

    if ($(window).width() > 680) {
        $(".contact-icon-container a").hover(
            function() {
                $(this).parents(".icons-list").addClass("expanded");
                $(this).next(".icon-details").fadeIn("fast");
            },
            function() {
                $(this).parents(".icons-list").removeClass("expanded");
                $(this).next(".icon-details").fadeOut("fast");
            }
        );
    }

    $("#contactform").validate();

    // Make sure the contact map goes full width
    $(".contact-map iframe").attr("width", "100%");
    $(".contact-map iframe").attr("height", "100%");

}) (jQuery);