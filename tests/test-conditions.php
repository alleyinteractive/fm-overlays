<?php
/**
 * test-conditions.php
 *
 * @created     7/11/16 2:29 PM
 * @author      Alley Interactive
 * @package     fm-overlays
 *
 */

// class Test_Conditions extends WP_UnitTestCase {
	// protected function get_wp_footer() {
	// 	ob_start();
	// 	do_action( 'wp_footer' );
	// 	return ob_get_clean();
	// }

	// public function test_homepage() {
	// 	$overlay_id = $this->factory->post->create( [ 'post_title' => 'has-cat', 'post_status' => 'publish', 'post_date' => '2016-04-01 00:00:00', 'post_type' => 'fm-overlay' ] );
	// 	update_post_meta( $overlay_id, 'fm_overlays_conditionals', [ [ 'condition_select' => 'is_front_page' ], [ 'condition_select' => 'is_home' ] ] );

	// 	$this->go_to( '/' );
	// 	$contents = $this->get_wp_footer();
	// 	// check for overlay
	// 	$this->assertContains( '<div class="fm-overlay-wrapper">', $contents );
	// 	// check for condition
	// 	$this->assertContains( 'fm-overlay-is_home', $contents );
	// }

	// public function test_has_cat() {
	// 	$cat_id = $this->factory->category->create( [ 'name' => 'cat' ] );
	// 	$overlay_id = $this->factory->post->create( [ 'post_title' => 'has-cat', 'post_status' => 'publish', 'post_date' => '2016-04-01 00:00:00', 'post_type' => 'fm-overlay' ] );
	// 	$post_id = $this->factory->post->create( [ 'post_title' => 'has-cat-post', 'post_status' => 'publish', 'post_date' => '2016-04-01 00:00:00', 'post_type' => 'post' ] );

	// 	update_post_meta( $overlay_id, 'fm_overlays_conditionals', [ [ 'condition_select' => 'has_category', 'condition_argument_category' => $cat_id ] ] );
	// 	wp_set_object_terms( $post_id, [ $cat_id ], 'category' );

	// 	$this->go_to( get_permalink( $post_id ) );
	// 	$contents = $this->get_wp_footer();
	// 	// check for overlay
	// 	$this->assertContains( '<div class="fm-overlay-wrapper">', $contents );
	// 	// check for condition
	// 	$this->assertContains( 'fm-overlay-has_category', $contents );
	// }

	// public function test_is_cat() {
	// 	$cat_id = $this->factory->category->create( [ 'name' => 'cat' ] );
	// 	$overlay_id = $this->factory->post->create( [ 'post_title' => 'is-cat', 'post_status' => 'publish', 'post_date' => '2016-04-01 00:00:00', 'post_type' => 'fm-overlay' ] );
	// 	$post_id = $this->factory->post->create( [ 'post_title' => 'is-cat-post', 'post_status' => 'publish', 'post_date' => '2016-04-01 00:00:00', 'post_type' => 'post' ] );

	// 	update_post_meta( $overlay_id, 'fm_overlays_conditionals', [ [ 'condition_select' => 'is_category', 'condition_argument_category' => $cat_id ] ] );
	// 	wp_set_object_terms( $post_id, [ $cat_id ], 'category' );

	// 	$this->go_to( get_term_link( $cat_id, 'category' ) );
	// 	$contents = $this->get_wp_footer();
	// 	// check for overlay
	// 	$this->assertContains( '<div class="fm-overlay-wrapper">', $contents );
	// 	// check for condition
	// 	$this->assertContains( 'fm-overlay-is_category', $contents );
	// }
// }
