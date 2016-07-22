<?php
/**
 * Base Class for FM-Overlays Unit Testing.
 *
 * @author 		Alley Interactive
 * @package 	fm-overlays
 */

class FM_Overlays_UnitTest extends WP_UnitTestCase {

	/**
	 *  Default Title of Overlay
	 */
	protected $overlay_title = 'Overlay UnitTest';

	/**
	 *  Array containing overlay content type and content
	 */
	protected $overlay_content;

	/**
	 * Array of conditionals controlling overlay display
	 */
	protected $overlay_conditionals;

	/**
	 * Get Wordpress Footer
	 *
	 * @return string returns entire wp_footer object
	 */
	protected function get_wp_footer() {
		ob_start();
		do_action( 'wp_footer' );
		return ob_get_clean();
	}

	/**
	 * Create new Overlay using the Factory
	 *
	 * @param boolean $return_object change to true to return the post object instead of the post ID
	 * @param array $content_override defaults to protected var, can be overridden by passing content meta array
	 * @param array $conditional_override defaults to protected var, can be overridden by passing conditional meta array
	 * @return string|object defaults to returning a string containing the ID of the post created.  Will return an object if $return_object is set to true
	 */
	protected function create_overlay( $return_object = false, $content_override = null, $conditional_override = null) {
		$overlay_config = array(
			'post_status' => 'publish',
			'post_date' => '2016-04-01 00:00:00',
			'post_type'  => 'fm-overlay',
			'post_title' => $this->overlay_title,
			'meta_input' => array(
				'fm_overlays_content' => ( ! empty( $content_override ) ? $content_override : $this->overlay_content ),
				'fm_overlays_conditionals' => ( ! empty( $conditional_override ) ? $conditional_override : $this->overlay_conditionals ),
			)
		);
		// determine return type & generate post
		if ( ! $return_object ) {
			return $this->factory->post->create( $overlay_config );
		} else {
			return $this->factory->post->create_and_get( $overlay_config );
		}
	}
}
