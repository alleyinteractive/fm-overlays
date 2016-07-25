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
	 * @param array $args is used to override any settings when generating the overlay.  `content` and `conditionals` key values override default protected vars
	 * @return string|object defaults to returning a string containing the ID of the post created.  Will return an object if $return_object is set to true
	 */
	protected function create_overlay( $return_object = false, $args = null ) {
		$overlay_config = array(
			'post_status' => 'publish',
			'post_date' => '2016-04-01 00:00:00',
			'post_type'  => 'fm-overlay',
			'post_title' => $this->overlay_title,
			'meta_input' => array(
				'fm_overlays_content' => ( ! empty( $args['content'] ) ? $args['content'] : $this->overlay_content ),
				'fm_overlays_conditionals' => ( ! empty( $args['conditionals'] ) ? $args['conditionals'] : $this->overlay_conditionals ),
			)
		);
		// Erase meta input values before merge
		if ( ! empty( $args['content'] ) ) {
			unset( $args['content'] );
		}
		if ( ! empty( $args['conditionals'] ) ) {
			unset( $args['conditionals'] );
		}

		var_dump($args);

		// Check for remaining arguments and merge em in
		if ( ! empty( $args ) && is_array( $args ) ) {
			$overlay_config = array_merge( $overlay_config, $args );
		}

		// var_dump($overlay_config);

		// determine return type & generate post
		if ( ! $return_object ) {
			return $this->factory->post->create( $overlay_config );
		} else {
			return $this->factory->post->create_and_get( $overlay_config );
		}
	}
}
