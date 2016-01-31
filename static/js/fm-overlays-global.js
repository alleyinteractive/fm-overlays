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
			timer = 150,
			speed = 250,
			closeButton = overlay.children( 'a.close-fm-overlay' );

		if ( overlay.length ) {

			/**
			 * Display the overlay
			 */
			setTimeout( function() {
				overlay.fadeIn( speed );
			}, timer );

			/**
			 * Exit strategies
			 */
			$( document ).keyup( function( e ) {
				if ( e.keyCode == 27 ) {
					setTimeout( function() {
						overlay.fadeOut( speed );
					}, timer );
				}
			} );

			closeButton.click( function() {
				setTimeout( function() {
					overlay.fadeOut( speed );
				}, timer );
			} );

			// close the overlay when a click occurs outside of the overlay content
			overlay.children( '.fm-overlay-fade' ).click( function() {
				setTimeout( function() {
					overlay.fadeOut( speed );
				}, timer );
			} );
		}
	}

	/**
	 * Initialize
	 */
	jQuery( document ).ready( function() {
		fmOverlay();
	} );

})( jQuery );
