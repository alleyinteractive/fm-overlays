<?php

/*
	Plugin Name: Fieldmanager Overlays
	Plugin URI: https://github.com/alleyinteractive/fm-overlays
	Description: A Fieldmanager extension to render dynamic content in modal boxes/overlays on a site.
	Version: 0.1
	Author: Alley Interactive
	Author URI: http://www.alleyinteractive.com/
*/

/*  This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * Version number.
 *
 * @var string
 */
define( 'FM_OVERLAYS_VERSION', '0.0.1' );

/**
 * Assets Version number.
 *
 * @var string
 */
define( 'FM_OVERLAYS_ASSETS_VERSION', '0.0.1' );

/**
 * Filesystem path to Fm Overlays.
 *
 * @var string
 */
define( 'FM_OVERLAYS_PATH', plugin_dir_path( __FILE__ ) );

/**
 * URL for assets.
 */
define( 'FM_OVERLAYS_ASSET_URL', plugin_dir_url( __FILE__ ) );

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'Denied!', 'fm-overlays' ) );
}

function fm_overlays_setup_files() {
	if ( ! defined( 'FM_VERSION' ) ) {
		// If Fieldmanager is not installed, run away.
		return;
	}

	/**
	 * Spin up the hyperdrive...
	 *
	 * Just kidding, load in singleton base class.
	 */
	require_once( FM_OVERLAYS_PATH . 'php/class-fm-overlays-singleton.php' );

	/**
	 * Require post type
	 */
	require_once( FM_OVERLAYS_PATH . 'php/class-fm-overlays-post-type.php' );

	/**
	 * Require admin manipulations
	 */
	if ( is_admin() ) {
		require_once( FM_OVERLAYS_PATH . 'php/class-fm-overlays-admin.php' );
	}
}

add_action( 'after_setup_theme', 'fm_overlays_setup_files' );
