/**
 * Broadsword single post specific Javascript Code
 *
 */

( function ($) {
    "use strict";

    var header_t = setTimeout(function() {
        $("body").addClass("move");
    }, 500);

    var bgImg = new Image();
    bgImg.id = 'bgLoader';
    bgImg.src = singular_script_vars.header_bg_image;

    // Ease in the main container
    $('.header-image').addClass('opaque');

    $(bgImg).load(function () {
        var newBg = "linear-gradient(to bottom, rgba(0,0,0,0.4) 0%,rgba(0,0,0,0.4) 100%), url(" + bgImg.src + ") center / cover";
        $('.header-image').css('background', newBg);
    });

    $(".title-details").addClass("opaque");
    $(".arrow-container-bottom").fadeIn("slow");

    $(".arrow-container-bottom").on("click", function(){
        // Scroll to the main post content
        var menuHeight = $("#masthead").height();
        $("html,body").animate({
            scrollTop: $("#main").offset().top - menuHeight
        }, 600);
    });

    $(".footer-nav").hover(
        function() {
            $(this).addClass("hover");
            $(this).find(".nav-image-container").addClass("hover");
            $(this).find(".overlay").addClass("hover");
        },
        function() {
            $(this).removeClass("hover");
            $(this).find(".nav-image-container").removeClass("hover");
            $(this).find(".overlay").removeClass("hover");
        }
    );

    // Fix to allow wp-tiles gallery images to use the Responsive Lightbox
    $(".wp-tiles-tile a").attr("rel", "lightbox");


}) (jQuery);