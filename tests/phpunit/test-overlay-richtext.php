<?php
/**
 * RichText Overlay Unit Testing.
 *
 * @package fm-overlays
 */

class Overlay_Richtext extends FM_Overlays_UnitTest {

	/**
	 * Richtext content to be used in overlay creation
	 */
	protected $overlay_content = array(
		'content_type_select' => 'richtext',
		'richtext_content' => '<h1>This is a header tag</h1><p>paragraph tag</p><div class="container-div"><p>paragraph inside a div</p></div><article>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</article>'
	);

	/**
	 * Tests Overlay Post Creation
	 */
	function test_basic_overlay_creation() {
		// Generate Overlay
		$factory_overlay = $this->create_overlay( true );
		$generated_overlay_id = $factory_overlay->ID;

		$this->assertNotEmpty( $generated_overlay_id, 'Checking FM-Overlay Post Creation' );
	}

	/**
	 * Tests Richtext Overlay Creation / Verify richtext_content is stored correctly into post meta
	 */
	function test_richtext_overlay_content() {
		// Generate Overlay
		$overlay_post = $this->create_overlay( true );
		$generated_overlay_id = $overlay_post->ID;
		// Retrieve overlay content post meta
		$overlay_content = get_post_meta( $generated_overlay_id, 'fm_overlays_content', true );

		$this->assertSame( 'richtext', $overlay_content['content_type_select'], 'Checking FM-Overlay Content Type Text' );
		$this->assertSame( $this->overlay_content['richtext_content'], $overlay_content['richtext_content'], 'Checking FM-Overlay Text Content' );
	}

}
