<?php
$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

require_once $_tests_dir . '/includes/functions.php';

function _manually_load_plugin() {

	$_fm_dir = getenv( 'FM_DIR' );
	if ( empty( $_fm_dir ) ) {
		$_fm_dir = dirname( __FILE__ ) . '/../../wordpress-fieldmanager';
	}

	require $_fm_dir . '/fieldmanager.php';

	require dirname( dirname( __FILE__ ) ) . '/fm-overlays.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require $_tests_dir . '/includes/bootstrap.php';

// Overlay Text Base Class
require_once( 'phpunit/includes/class-fm-overlays-unittest.php' );
