/**
 * fm-overlays-global.js
 *
 * @created 1/15/16 5:33 PM
 * @author Alley Interactive
 * @package fm-overlays
 * @description Front-end JS for fm-overlays.
 *
 */

(function( $ ) {
	'use strict';

	/**
	 * Very simple overlay event handler.
	 *
	 * @returns {fmOverlay}
	 */
	function fmOverlay() {

		var overlay = $( '#fm-overlay' ),
			overlayWrapper = overlay.children( '.fm-overlay-wrapper' ),
			timer = 500, // matches css transition duration
			activeClass = 'visible',
			closeButton = overlayWrapper.children( 'a.fm-overlay-close' );

		/**
		 * Hide overlay after fading out
		 */
		function hideOverlay() {
			overlay.removeClass( activeClass );

			setTimeout( function() {
				overlay.hide();
			}, timer );
		}

		if ( overlay.length ) {

			/**
			 * Display the overlay
			 */
			setTimeout( function() {
				overlay.show().addClass( activeClass );
			}, timer );

			/**
			 * Exit strategies
			 */
			$( document ).keyup( function( e ) {
				if ( e.keyCode == 27 ) {
					hideOverlay();
				}
			} );

			closeButton.click( function() {
				hideOverlay();
			} );

			// close the overlay when a click occurs outside of the overlay content
			overlay.children( '.fm-overlay-fade' ).click( function() {
				hideOverlay();
			} );
		}
	}

	/**
	 * Initialize
	 */
	$( document ).ready( function() {
		fmOverlay();
	} );

})( jQuery );
