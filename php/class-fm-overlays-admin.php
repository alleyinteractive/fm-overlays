<?php
/**
 * class-fm-overlays-admin.php
 *
 * @created     1/8/16 2:00 PM
 * @author      Alley Interactive
 * @package     fm-overlays
 * @description Enqueue styles, scripts and handle admin manipulations.
 *
 */

class Fm_Overlays_Admin extends Fm_Overlays_Singleton {

	/**
	 * Setup.
	 */
	public function setup() {
		// Load admin styles and scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
	}

	/**
	 * Load styles and scripts.
	 *
	 * @access public
	 */
	public function admin_assets() {
		// make sure this doesn't load on any edit pages other than fm-overlays CPT edit pages.
		if ( 'fm-overlay' === get_post_type() ) {
			wp_enqueue_script( 'fm-overlays-admin-js', FM_OVERLAYS_ASSET_DIR . '/static/js/fm-overlays-admin.js', array( 'jquery' ), FM_OVERLAYS_ASSETS_VERSION, true );
			wp_enqueue_style( 'fm-overlays-admin-css', FM_OVERLAYS_ASSET_DIR . '/static/css/fm-overlays-admin.css', array(), FM_OVERLAYS_ASSETS_VERSION );
		}
	}
}

Fm_Overlays_Admin::instance();
