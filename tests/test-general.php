<?php
/**
 * test-general.php
 *
 * @created     7/11/16 2:29 PM
 * @author      Alley Interactive
 *
 */

class Test_General extends WP_UnitTestCase {
	public function setUp() {
		parent::setUp();

		// use an overlay targeted to the homepage for all of the general test
		$overlay_id = $this->factory->post->create( [ 'post_title' => 'has-cat', 'post_status' => 'publish', 'post_date' => '2016-04-01 00:00:00', 'post_type' => 'fm-overlay' ] );
		update_post_meta( $overlay_id, 'fm_overlays_conditionals', array( array( 'condition_select' => 'is_front_page' ), array( 'condition_select' => 'is_home' ) ) );

		$this->overlay_post = get_post( $overlay_id );
	}

	protected function get_wp_footer() {
		ob_start();
		do_action( 'wp_footer' );
		return ob_get_clean();
	}
}
