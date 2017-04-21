/**
 * Broadsword-specific Javascript Code
 *
 */

/**
 * Function to detect iOS version
 * Used primarily to fix viewport bugs in iOS 7
 */

"use strict";

function iOSversion() {
    if (/iP(hone|od|ad)/.test(navigator.platform)) {
        // supports iOS 2.0 and later: <http://bit.ly/TJjs1V>
        var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/);
        return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)];
    }
}

var version = iOSversion();

(function($) {
    $(document).ready(function(){

        /**
         * Menu
         */
        $("#showRightPush").on( "click", function(){
            $("#masthead").addClass("transparent");
            $(".cbp-spmenu-right").show();
            $('.nav-close').show();
            $(this).toggleClass( 'active' );
            $('body').toggleClass( 'cbp-spmenu-push-toleft' );
            $('body.move #masthead').toggleClass( 'cbp-spmenu-push-toleft' );
            $('#header_nav_menu').toggleClass( 'cbp-spmenu-open' );
        });

        $(".nav-close").on( "click", function(){
            $("#masthead").removeClass("transparent");
            $(".cbp-spmenu-right").hide();
            $('#showRightPush').show();
            $('#showRightPush').toggleClass( 'active' );
            $('body').toggleClass( 'cbp-spmenu-push-toleft' );
            $('body.move #masthead').toggleClass( 'cbp-spmenu-push-toleft' );
            $('#header_nav_menu').toggleClass( 'cbp-spmenu-open' );
        });

        if ($(window).width() <= 400) {
            $('.logo img').toggleClass('logo-sm');
        }

        /**
         * Add a class to identify anchor tags that surround images in the footer. Used for opacity settings.
         */
        $("footer img").parent("a").addClass('footerImg');

        /**
         * Define a custom scrollbar for the overlay
         */
        $('.overlay-content').jScrollPane();

        /**
         * Add a semi-transparent background to the masthead when scrolling down the page
         */
        var fadeStart=50,
            fadeUntil=300,
            fading = $('#masthead'),
            logo = $('#masthead .logo'),
            about = $('#masthead .about'),
            menu = $('#masthead .menu');

        $(window).bind('scroll', function() {
            var offset = $(document).scrollTop(), opacity = 0;
            var redraw_margins = false;

            if (offset > 10) {
                logo.addClass('shrink');
                about.addClass('shrink');
                menu.addClass('shrink');
            }
            else {
                logo.removeClass('shrink');
                about.removeClass('shrink');
                menu.removeClass('shrink');
            }

            if ( offset <= fadeStart ){
                fading.removeClass('opaque');
            }
            else {
                fading.addClass('opaque');
            }
        });


        // Initialize the Safari IOS 7 Buggyfill
        if (typeof version !== 'undefined' && version[0] <= 7) {
            window.viewportUnitsBuggyfill.init();
        }

    });

    $(".footer-nav").on("click", function() {
        var url = $(this).find(".entry-header a").attr("href");
        window.location.href = url;
    });

}) (jQuery);