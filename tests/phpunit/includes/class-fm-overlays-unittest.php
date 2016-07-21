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
	 * Create new Overlay using the Factory
	 *
	 * @param boolean $return_object change to true to return the post object instead of the post ID
	 * @param array $overlay_content defaults to protected var, can be overrided by passing content meta array
	 * @param array $overlay_conditionals defaults to protected var, can be overrided by passing conditional meta array
	 * @return string|object defaults to returning a string containing the ID of the post created.  Will return an object if $return_object is set to true
	 */
	function create_overlay( $return_object = false, $overlay_content = null, $overlay_conditionals = null) {
		$overlay_config = array(
			'post_type'  => 'fm-overlay',
			'post_title' => 'UnitTest Overlay',
			'meta_input' => array(
				'fm_overlays_content' => ( ! empty( $overlay_content ) ? $overlay_content : $this->overlay_content ),
				'fm_overlays_conditionals' => ( ! empty( $overlay_conditionals ) ? $overlay_conditionals : $this->overlay_conditionals ),
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
