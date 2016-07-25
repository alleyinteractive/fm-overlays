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
		// Generate overlay with lower priority
		$low_priority_id = $this->create_overlay( false, array(
			'post_title' => 'Low Priority',
			'menu_order' => 1
		) );

		// Generate overlay with higher priority
		$high_priority_id = $this->create_overlay( false, array(
			'post_title' => 'High Priority',
			'menu_order' => 5,
			'content' => array(
				'content_type_select' => 'image',
				'image_link' => '',
				'image_link_target' => '',
				'image_id' => ''
			),
		) );

		$this->go_to( '/' );
		$footer = $this->get_wp_footer();
		// check we don't display low priority overlay
		$this->assertNotContains( $low_priority_id, $footer );
		$this->assertNotContains( 'fm-overlay-richtext', $footer );

		// check for correct overlay type & higher priority overlay id
		$this->assertContains( 'fm-overlay-image', $footer );
		$this->assertContains( 'fm-overlay-' . $high_priority_id, $footer );
	}

}
