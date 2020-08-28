<?php
/**
 * FM Overlays Admin screen.
 *
 * @created     1/8/16 2:00 PM
 * @author      Alley Interactive
 * @package     fm-overlays
 * @description Enqueue styles, scripts and handle admin manipulations.
 *
 */

/**
 * Class Fm_Overlays_Admin
 */
class Fm_Overlays_Admin extends Fm_Overlays_Singleton {

	/**
	 * Setup.
	 */
	public function setup() {
		// Load admin styles and scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
	}

	/**
	 * Load styles and scripts.
	 *
	 * @access public
	 */
	public function admin_assets() {
		// make sure this doesn't load on any edit pages other than fm-overlays CPT edit pages.
		if ( Fm_Overlays_Post_Type()->get_post_type() === get_post_type() ) {
			wp_enqueue_script( 'fm-overlays-admin-js', FM_OVERLAYS_ASSET_URL . '/static/js/fm-overlays-admin.js', array( 'jquery' ), FM_OVERLAYS_ASSETS_VERSION, true );
			wp_enqueue_style( 'fm-overlays-admin-css', FM_OVERLAYS_ASSET_URL . '/static/css/fm-overlays-admin.css', array(), FM_OVERLAYS_ASSETS_VERSION );
		}
	}
}

/**
 * Define callable
 *
 * @return Fm_Overlays_Admin
 */
function Fm_Overlays_Admin() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return Fm_Overlays_Admin::instance();
}
Fm_Overlays_Admin();
