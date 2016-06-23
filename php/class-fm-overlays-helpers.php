<?php
/**
 * class-fm-overlays-helpers.php
 *
 * @created     1/8/16 2:00 PM
 * @author      Alley Interactive
 * @package     fm-overlays
 * @description Provides helpers for templates.
 *
 */

class Fm_Overlays_Helpers extends Fm_Overlays_Singleton {

	/**
	 * Setup.
	 */
	public function setup() {


	}


	/**
	 * Generates Overlay Classes
	 *
	 * @param object $overlay enhanced post object containing overlay_content meta data
	 * @param array $classes optional array of additional classes
	 */
	public function get_overlay_classes( $overlay, $classes = null ) {
		if ( empty( $overlay ) ) {
			return;
		}

		if ( empty( $classes ) ) {
			$classes = array();
		}

		// basic classes for ID & post type
		$classes[] = $overlay->post_type . '-' . $overlay->ID;
		$classes[] = $overlay->post_type;

		// add content type class
		if ( ! empty( $overlay->overlay_content['content_type_select'] ) ) {
			$classes[] = 'fm-overlay-' . $overlay->overlay_content['content_type_select'];
		}

		return implode( ' ', $classes );
	}


	public function get_image_src( $attachment_id, $size = null ) {
		$default_image_src = wp_get_attachment_image_src( $attachment_id, ( ! empty( $size ) ? $size : 'thumbnail' ) );
		if ( ! empty( $default_image_src ) ) {
			return array(
				'src' => $default_image_src[0],
				'width' => $default_image_src[1],
				'height' => $default_image_src[2],
				'generated_image' => $default_image_src[3],
			);
		}
		return false;
	}


	public function get_overlay_image_sizes( $attachment_id ) {
		$transient_slug = 'fm_overlay_image_sizes_' . $attachment_id;
		// if ( false === ( $image_sizes = get_transient( $transient_slug ) ) ) {
			// Create an array of all the image sizes required
			$image_sizes = array(
				'desktop_src' => $this->get_image_src( $attachment_id, 'full' ),
				'tablet_src' => $this->get_image_src( $attachment_id, 'large' ),
				'mobile_src' => $this->get_image_src( $attachment_id, 'medium_large' ),
			);

			// set_transient( $transient_slug, $image_sizes );
		// }
		return $image_sizes;
	}

}

Fm_Overlays_Helpers::instance();