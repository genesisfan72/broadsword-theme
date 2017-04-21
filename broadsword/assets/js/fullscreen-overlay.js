(function($) {
	"use strict";

	$(document).ready(function() {

		var triggerBttnFeatured = document.getElementById( 'trigger-overlay-featured' ),
	        overlay = document.querySelector( 'div.fullscreen-overlay' ),
	        docbody = document.getElementsByTagName( 'body' )[0],
	        closeBttn = overlay.querySelector( 'button.overlay-close' ),

			transEndEventNames = {
				'WebkitTransition': 'webkitTransitionEnd',
				'MozTransition': 'transitionend',
				'OTransition': 'oTransitionEnd',
				'msTransition': 'MSTransitionEnd',
				'transition': 'transitionend'
			},
			transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
			support = { transitions : Modernizr.csstransitions };

		function toggleOverlay() {
	        document.querySelector('.overlay-featured').style.display = 'block';

	        var hidemes = document.querySelectorAll('.hideme');
			if( classie.has( overlay, 'open' ) ) {
				classie.remove( overlay, 'open' );
				classie.add( overlay, 'closing' );

				var onEndTransitionFn = function( ev ) {
					if( support.transitions ) {
						if( ev.propertyName !== 'visibility' ) return;
						this.removeEventListener( transEndEventName, onEndTransitionFn );
					}

	           		classie.remove( overlay, 'closing' );
				};
				if( support.transitions ) {
					overlay.addEventListener( transEndEventName, onEndTransitionFn );
				}
				else {
					onEndTransitionFn();
				}

				[].forEach.call(hidemes, function(hideme) {
					hideme.style.opacity = '1';
				});
				var arrows = document.querySelector('.arrow-container');
				if ( arrows!== null )
					arrows.style.visibility = 'visible';
				document.querySelector('footer').style.opacity = '1';
				docbody.style.overflowY = 'scroll';
			}
			else if( !classie.has( overlay, 'closing' ) ) {
				classie.add( overlay, 'open' );
				[].forEach.call(hidemes, function(hideme) {
					hideme.style.opacity = '0';
				});
				var arrows = document.querySelector('.arrow-container');
				if ( arrows!== null )
					arrows.style.visibility = 'hidden';
				document.querySelector('footer').style.opacity = '0';
				docbody.style.overflowY = 'hidden';
			}
		}

		if ( typeof triggerBttnFeatured !== 'undefined' && triggerBttnFeatured !== null )
			triggerBttnFeatured.addEventListener( 'click', toggleOverlay );
	    closeBttn.addEventListener( 'click', toggleOverlay );
	});
})(jQuery);