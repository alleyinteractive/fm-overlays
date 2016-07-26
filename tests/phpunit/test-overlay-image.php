<?php
/**
 * Image Overlay Unit Testing.
 *
 * @todo Verify that 'richtext_content' isn't rendered despite being populated if originally a richtext overlay
 * @todo Check image_link_target is correctly passed into anchor target attribute
 * @todo Check image_id was stored / exists in media library (?)
 *
 * @package fm-overlays
 */


class Overlay_Image extends FM_Overlays_UnitTest {

	/**
	 * Image content to be used in overlay creation
	 */
	protected $overlay_content = array(
		'content_type_select' => 'image',
		'image_link' => '',
		'image_link_target' => '',
		'image_id' => ''
	);

	function test_image_overlay_content() {
		// Generate Overlay
		$this->overlay_title = 'Image Overlay';
		$factory_overlay = $this->create_overlay( true );
		$generated_overlay_id = $factory_overlay->ID;
		$overlay_content = get_post_meta( $generated_overlay_id, 'fm_overlays_content', true );

		$this->assertNotEmpty( $generated_overlay_id, 'Checking FM-Overlay Image Creation' );
		$this->assertSame( 'image', $overlay_content['content_type_select'], 'Checking FM-Overlay Content Type Image' );

		$this->go_to( '/' );
		$footer = $this->get_wp_footer();
		// check for overlay
		$this->assertContains( '<div class="fm-overlay-wrapper">', $footer );
		// check for richtext class
		$this->assertContains( 'fm-overlay-image', $footer );
		// check for fm-image
		$this->assertContains( 'fm-image', $footer );
	}

}
