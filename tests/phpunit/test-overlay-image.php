<?php
/**
 * Image Overlay Unit Testing.
 *
 * @package fm-overlays
 *
 * @todo Verify that 'richtext_content' isn't rendered despite being populated if originally a richtext overlay
 */


class Overlay_Image extends FM_Overlays_UnitTest {

	protected $overlay_content = array(
		'content_type_select' => 'image',
		'image_link' => '',
		'image_link_target' => '',
		'image_id' => ''
	);

	function test_image_overlay_content() {
		// Generate Overlay
		$factory_overlay = $this->create_overlay( true );
		$generated_overlay_id = $factory_overlay->ID;
		$overlay_content = get_post_meta( $generated_overlay_id, 'fm_overlays_content', true );

		$this->assertNotEmpty( $generated_overlay_id, 'Checking FM-Overlay Image Creation' );
		$this->assertSame( 'image', $overlay_content['content_type_select'], 'Checking FM-Overlay Content Type Image' );
	}
}
