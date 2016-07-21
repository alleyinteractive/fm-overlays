<?php
/**
 * General Overlay Unit Testing.
 *
 * @author 		Alley Interactive
 * @package 	fm-overlays
 */

class Overlay_General extends FM_Overlays_UnitTest {

	/**
	 * Tests Overlay Post Creation
	 */
	public function test_overlay_creation() {
		// Generate Overlay
		$this->overlay_title = 'Overlay Post Creation Test';
		$overlay_post = $this->create_overlay( true );
		$generated_overlay_id = $overlay_post->ID;

		$this->assertNotEmpty( $generated_overlay_id, 'Checking FM-Overlay Post Creation' );
	}

	/**
	 * Tests Cookie Name
	 *
	 * Verifies data-cookiename attribute is being populated with correct cookie name
	 */
	public function test_cookie_name() {
		$this->overlay_title = 'Cookie Test';
		$overlay_post = $this->create_overlay( true );
		$cookie_name = Fm_Overlays::instance()->get_overlay_cookie_name( $overlay_post->ID );

		$this->go_to( '/' );
		$footer = $this->get_wp_footer();
		$this->assertContains( 'data-cookiename="' . $cookie_name . '"', $footer );
	}

}
