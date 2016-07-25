<?php
/**
 * Overlay Priority Unit Testing.
 *
 * @author 		Alley Interactive
 * @package 	fm-overlays
 */

class Overlay_Display_Priority extends FM_Overlays_UnitTest {

	/**
	 * default content used by create_overlay() function
	 */
	protected $overlay_content = array(
		'content_type_select' => 'richtext',
		'richtext_content' => '<h1>This is basic RichText that should</h1>'
	);

	/**
	 * Tests basic menu order priority
	 */
	public function test_basic_priority() {
		$this->post_title = 'Low Priority';
		$hidden_overlay_id = $this->create_overlay( false, array(
			'menu_order' => 0
		) );

		$this->post_title = 'High Priority';
		$target_overlay = $this->create_overlay( true, array(
			'menu_order' => 5,
			'content' => array(
				'content_type_select' => 'image',
			)
		) );

		$this->go_to( '/' );
		$footer = $this->get_wp_footer();
		// check for overlay
		$this->assertNotContains( $hidden_overlay_id, $footer );
		// check for condition
		$this->assertContains( 'fm-overlay-image', $footer );
	}
}
