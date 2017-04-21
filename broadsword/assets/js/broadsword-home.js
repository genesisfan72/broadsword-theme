/**
 * Broadsword home page specific Javascript Code
 *
 */

( function ($) {
    "use strict";

    var COLUMN_WIDTH = $("#posts ul li").outerWidth();
    var HORIZONTAL_POST_HEIGHT = 300;
    var broadswordSwiper;
    var PHONE_HORIZONTAL_WIDTH = 568;
    var IS_MOBILE_SAFARI_7 = !!navigator.userAgent.match(/i(Pad|Phone|Pod).+(Version\/7\.\d+ Mobile)/i);

    function wocBroadswordPixelsOffViewport(side) {
        var numPixels = 0;

        if (side === 'left') {
            numPixels = $(".post-column:first-child").position().left;
        }
        else if (side === 'right') {
            numPixels = $(".post-column:last-child").position().left + COLUMN_WIDTH - $(".viewport").width();
        }
        else if (side === 'bottom') {
            numPixels = $(".post-column:last-child").position().top + HORIZONTAL_POST_HEIGHT - $(".viewport").innerHeight();
        }
        else if (side === 'top') {
            numPixels = $(".post-column:first-child").position().top;
        }

        return numPixels;
    }

    function wocBroadswordScrollColumns(direction) {
        // No scrolling if the column is in full view in the direction we want to scroll
        if ( (direction === "right" && wocBroadswordPixelsOffViewport("left") === 0) ||
             (direction === "left" && wocBroadswordPixelsOffViewport("right") === 0) ||
             (direction === "up" && wocBroadswordPixelsOffViewport("bottom") === 0) ||
             (direction === "down" && wocBroadswordPixelsOffViewport("top") === 0) ) {
            return;
        }

        // Are we moving a full slide width, or just the remainder of the last slide?
        var slideWidth = 0;

        if (direction === "left") {
            var pixelsOffScreenRight = wocBroadswordPixelsOffViewport("right");
            slideWidth = pixelsOffScreenRight < COLUMN_WIDTH ? pixelsOffScreenRight : COLUMN_WIDTH;
        }
        else if (direction === "right") {
            var pixelsOffScreenLeft = wocBroadswordPixelsOffViewport("left");
            if (pixelsOffScreenLeft < 0) {
                if (Math.abs(pixelsOffScreenLeft) < COLUMN_WIDTH) {
                    slideWidth = Math.abs(pixelsOffScreenLeft);
                }
                else {
                    var remainder = wocBroadswordPixelsOffViewport("left") % COLUMN_WIDTH;
                    if (Math.abs(remainder) > 0) {
                        slideWidth = COLUMN_WIDTH + Math.abs(remainder);
                    }
                    else slideWidth = COLUMN_WIDTH;
                }
            }
        }
        else if (direction === "up") {
            var pixelsOffScreenBottom = wocBroadswordPixelsOffViewport("bottom");
            slideWidth = pixelsOffScreenBottom < HORIZONTAL_POST_HEIGHT ? pixelsOffScreenBottom : HORIZONTAL_POST_HEIGHT;
        }
        else if (direction === "down") {
            var pixelsOffScreenTop = wocBroadswordPixelsOffViewport("top");
            if (pixelsOffScreenTop < 0) {
                if (Math.abs(pixelsOffScreenTop) < HORIZONTAL_POST_HEIGHT) {
                    slideWidth = Math.abs(pixelsOffScreenTop);
                }
                else {
                    var remainder = wocBroadswordPixelsOffViewport("top") % HORIZONTAL_POST_HEIGHT;
                    if (Math.abs(remainder) > 0) {
                        slideWidth = HORIZONTAL_POST_HEIGHT + Math.abs(remainder);
                    }
                    else slideWidth = HORIZONTAL_POST_HEIGHT;
                }
            }
        }

        if (slideWidth > 0) {
            if (direction === 'left' || direction === 'right') {
                var pixelsToMove = (wocBroadswordPixelsOffViewport("left")) + (direction === 'left' ? -1 * slideWidth : slideWidth);
                $(".post-column").css('transform', 'translateX(' + pixelsToMove +'px)');

                if (direction === "left") {
                    if (slideWidth !== COLUMN_WIDTH) {
                       $(".arrow-container-right").fadeOut("slow");
                    }
                }
                else {
                    if ((slideWidth + wocBroadswordPixelsOffViewport("left")) === 0) {
                        $(".arrow-container-left").fadeOut("slow");
                    }
                }
            }
            else if (direction === 'up' || direction === 'down') {
                var pixelsToMove = (wocBroadswordPixelsOffViewport("top")) + (direction === 'up' ? -1 * slideWidth : slideWidth);
                $(".post-column").css('transform', 'translateY(' + pixelsToMove +'px)');

                if (direction === "up") {
                    if (slideWidth !== HORIZONTAL_POST_HEIGHT) {
                        $(".arrow-container-bottom").fadeOut("slow");
                    }
                }
                else {
                    if ((slideWidth + wocBroadswordPixelsOffViewport("top")) === 0) {
                        $(".arrow-container-top").fadeOut("slow");
                    }
                }
            }
        }
    }

    function wocBroadswordFrontPageLayout() {
        var numPosts = $(".post-column").length;
        var ulWidth = numPosts * COLUMN_WIDTH;
        var viewportWidth = $(".viewport").width();

        if (ulWidth < viewportWidth) {
            var liWidth = viewportWidth / numPosts;

            $("#posts ul li").css("max-width", "none");
            $("#posts ul li").css("width", liWidth + "px");
            ulWidth = numPosts * liWidth;
        }

        if (home_script_vars.front_page_style === 'horizontal' || home_script_vars.front_page_style === 'horizontal-bg') {
            var mastheadHeight = $("#masthead").height();
            var viewportHeight = $(".viewport").height();

            if (Modernizr.mq('only screen and (max-width: 1024px)')) {
                $(".view-more-container").show();

                // Viewport height for horizontal posts show a minimum of five posts, if five exist
                var numPosts = $(".post-column").length;

                if (numPosts > 5) {
                    viewportHeight = 5 * HORIZONTAL_POST_HEIGHT;
                    $(".load-more").show();
                }
                $(".viewport").css("height", viewportHeight + "px");
            }
            else {
                $(".viewport").css("height", viewportHeight - mastheadHeight + "px");
            }

            $("#content").css("margin-top", mastheadHeight + "px");
        }
        else {
            $("#posts ul").css("width", ulWidth + "px");
        }

        // Ease in the main viewport
        $('.site-main .viewport').addClass('opaque');

        if (home_script_vars.front_page_style === 'default' || home_script_vars.front_page_style === 'imaged') {
            // Get the max height of all post-columns
            var maxHeight = 0;
            $(".post-details").each(function() {
                if ($(this).height() > maxHeight) maxHeight = $(this).height();
            });
            $(".post-details").css("height", maxHeight + "px");
        }

        // Set the next and prev arrows to match
        $("#arrow_next, #arrow_prev").css("height", maxHeight + "px");

        // Load in the post columns
        var header_t = setTimeout(function() {
            $("body").addClass("move");
            $(".post-details").each(function(index){
                var self = this;
                var posts_t = setTimeout(function() {
                    $(self).removeClass("offscreen");
                    $(self).addClass("loaded");

                    if (home_script_vars.front_page_style !== 'default' && home_script_vars.front_page_style !== 'horizontal-bg') {
                        $(self).parent().find(".post-column-image").addClass("dimmed-04");
                    }

                    if (index === $(".post-details").length - 1) {
                        // After loading the posts, check to see if the directional arrows are needed
                        if (wocBroadswordPixelsOffViewport("left") > 0)
                            $(".arrow-container-left").fadeIn('slow');

                        if (wocBroadswordPixelsOffViewport("right") > 0)
                            $(".arrow-container-right").fadeIn('slow');

                        if (wocBroadswordPixelsOffViewport("bottom") > 0)
                            $(".arrow-container-bottom").fadeIn('slow');

                        if (wocBroadswordPixelsOffViewport("top") > 0)
                            $(".arrow-container-top").fadeIn('slow');
                    }
                }, 200 * index);
            });
        }, 200);


        if (typeof version !== 'undefined' && version[0] <= 7 && (home_script_vars.front_page_style === 'default' || home_script_vars.front_page_style === 'imaged')) {
            // IOS 7 Safari needs help when vertically centering in parents set with vh
            var pHeight = window.innerHeight;
            $(".post-details").css("top", pHeight / 2 + "px");
        }


        // Style adjustments for mobile devices
        if (Modernizr.mq('only screen and (max-width: 1024px)')) {
            $(".post-details").addClass("mobile-post-details");
            $("#posts").addClass("mobile-posts");
        }

        // Set the li width based on the body width
        var body_width = $("body").width();

        if (body_width < COLUMN_WIDTH || window.innerWidth <= PHONE_HORIZONTAL_WIDTH) {
            $(".swiper-slide").width($("body").width() * 0.85);
        }

        if (home_script_vars.front_page_style === 'default' || home_script_vars.front_page_style === 'horizontal-bg') {
            var bgImg = new Image();
            bgImg.id = 'bgLoader';
            bgImg.src = home_script_vars.page_bg_image;

            $(bgImg).load(function () {
                var newBg = "linear-gradient(to bottom, rgba(0,0,0,0.4) 0%,rgba(0,0,0,0.4) 100%), url(" + bgImg.src + ") center / cover";
                $('.site-main .viewport').css('background', newBg);
            });
        }

        if (home_script_vars.front_page_style === 'default' || home_script_vars.front_page_style === 'imaged') {
            // Enable swiping on small devices
            if (Modernizr.mq('only screen and (max-device-width: 1024px)')) {
                broadswordSwiper = new Swiper('.swiper-container', {
                    slidesPerView: 'auto'
                });
            }
        }

        $(".arrow-container-right").on("click", function() {
            wocBroadswordScrollColumns("left");
            $(".arrow-container-left").fadeIn('slow');
        });

        $(".arrow-container-left").on("click", function() {
            wocBroadswordScrollColumns("right");
            $(".arrow-container-right").fadeIn('slow');
        });

        $(".arrow-container-bottom").on("click", function() {
            wocBroadswordScrollColumns("up");
            $(".arrow-container-top").fadeIn('slow');
        });

        $(".arrow-container-top").on("click", function() {
            wocBroadswordScrollColumns("down");
            $(".arrow-container-bottom").fadeIn('slow');
        });

        $(".post-column").on("click", function() {
            var url = $(this).find("a").attr("href");
            window.location.href = url;
        });

        $(".view-more").on("click", function() {
            // Get current number on display
            var currentViewportHeight = $(".viewport").height();
            var numPostsCurrent = currentViewportHeight / HORIZONTAL_POST_HEIGHT;

            // Get the total number of posts
            var numTotalPosts = $(".post-column").length;

            // Show up to the next five
            if ((numTotalPosts - numPostsCurrent) >= 5) {
                $(".viewport").css("height", (currentViewportHeight + 5 * HORIZONTAL_POST_HEIGHT) + "px");
            }
            else {
                $(".viewport").css("height", numTotalPosts * HORIZONTAL_POST_HEIGHT + "px");
                $(".view-more-container").hide();
            }

        });
    }

    // Initial call
    wocBroadswordFrontPageLayout();

    $(window).on('resize', function() {
        // Enable swiping on small devices
        if (Modernizr.mq('only screen and (max-device-width: 1024px)')) {
            var pHeight = window.innerHeight;

            if (home_script_vars.front_page_style === 'default' || home_script_vars.front_page_style === 'imaged') {
                $(".site-main .viewport").css("height", pHeight + "px");
                $(".swiper-slide").width($("body").width() * 0.85);
                if (typeof broadswordSwiper !== 'undefined') {
                    broadswordSwiper.destroy();
                    broadswordSwiper = new Swiper('.swiper-container', {
                        slidesPerView: 'auto'
                    });
                }
            }

            if (typeof version !== 'undefined' && version[0] <= 7) {
                window.viewportUnitsBuggyfill.init();
                $(".post-details").css("top", pHeight / 2 + "px");
            }
        }
    });

}) (jQuery);