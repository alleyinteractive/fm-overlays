/**
 * fm-overlays-admin.js
 *
 * @created 1/8/16 2:44 PM
 * @author Alley Interactive
 * @package fm-overlays
 * @description JS manipulations to the fm-overlays admin area.
 *
 */

'use strict';
(function( $ ) {

	/**
	 * Pass select field data to the labels
	 * to make the UI a little easier and slicker
	 */
	function conditionFieldLabelLoader() {
		// When a select field is updated, also update the label
		$( 'body' ).on( 'change', 'select[conditional="labels"]', function() {
			var selectField = $( this ),
				selectVal = selectField.val(),
				separator = ' - ',
				labelSelector = selectField.closest( '.fm-fm_overlays_conditionals' ).find( '.fm-label-fm_overlays_conditionals' ),
				labelText = labelSelector.text();

			if ( ! selectVal ) {
				selectVal = '';
				separator = '';
			}

			// update the label string
			labelText = labelText.split( ' ', 1 ) + separator + selectVal;

			// replace the label
			labelSelector.text( labelText );

		} );

		// trigger a change for the select fields so the labels load according to their values
		$( 'select[conditional="labels"]' ).trigger( 'change' );
	}

	/**
	 * DOM ready
	 */
	$( document ).ready( function() {
		conditionFieldLabelLoader();
	} );
})( jQuery );