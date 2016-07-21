<?php
/**
 * Overlay Conditional Display Unit Testing.
 *
 * @todo create overlay conditional checks using wp_footer() to verify they are loaded in on the appropriate pages
 *
 * @package fm-overlays
 */

class Overlay_Display_Conditionals extends FM_Overlays_UnitTest {

	/**
	 * array of conditionals controlling overlay display
	 */
	protected $overlay_conditionals = array(
		array (
			'condition_select' => 'is_home'
		)
	);

	/**
	 * Parse through overlay conditionals
	 */
	function _parse_conditional( $args ) {

	}

	/**
	 * Check overlay displays on homepage
	 */
	function test_homepage_conditional() {
		// Create overlay
		$homepage_overlay = $this->create_overlay( true );

		$this->assertTrue( true );


	}
}
