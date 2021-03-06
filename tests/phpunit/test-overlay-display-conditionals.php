<?php
/**
 * Overlay Conditional Display Unit Testing.
 *
 * @author 		Alley Interactive
 * @package 	fm-overlays
 */

class Overlay_Display_Conditionals extends FM_Overlays_UnitTest {

	/**
	 * default array of overlay display conditionals used by create_overlay() function
	 */
	protected $overlay_conditionals = array(
		array(
			'condition_select' => 'is_home'
		),
		array(
			'condition_select' => 'is_front_page'
		)
	);

	/**
	 * Tests 'is_home' conditional class
	 */
	public function test_homepage() {
		$this->overlay_title = 'Is Home / Is Front Page';
		$overlay_id = $this->create_overlay( false );

		$this->go_to( '/' );
		$footer = $this->get_wp_footer();
		// check for overlay
		$this->assertContains( '<div class="fm-overlay-wrapper">', $footer );
		// check for condition
		$this->assertContains( 'fm-overlay-is_home', $footer );
		$this->assertContains( 'fm-overlay-is_front_page', $footer );
	}

	/**
	 * Tests 'has_cat' conditional class
	 */
	public function test_has_cat() {
		// Generate Category & Post for Test
		$cat_id = $this->factory->category->create( array( 'name' => 'cat' ) );
		$post_id = $this->factory->post->create( array( 'post_title' => 'has-cat-post', 'post_status' => 'publish', 'post_date' => '2016-04-01 00:00:00', 'post_type' => 'post' ) );
		wp_set_object_terms( $post_id, array( $cat_id ), 'category' );

		// Generate Overlay and pass a $conditional_override
		$overlay_id = $this->create_overlay( false, array(
			'post_title' => 'Has Category',
			'conditionals' => array(
				array( 'condition_select' => 'has_category', 'condition_argument_category' => $cat_id )
			)
		) );

		$this->go_to( get_permalink( $post_id ) );
		$footer = $this->get_wp_footer();
		// check for overlay
		$this->assertContains( '<div class="fm-overlay-wrapper">', $footer );
		// check for condition
		$this->assertContains( 'fm-overlay-has_category', $footer );
	}

	/**
	 * Tests 'is_cat' conditional class
	 */
	public function test_is_cat() {
		// Generate Category & Post for Test
		$cat_id = $this->factory->category->create( array( 'name' => 'cat' ) );
		$post_id = $this->factory->post->create( array( 'post_title' => 'is-cat-post', 'post_status' => 'publish', 'post_date' => '2016-04-01 00:00:00', 'post_type' => 'post' ) );
		wp_set_object_terms( $post_id, array( $cat_id ), 'category' );

		// Generate Overlay and pass a $conditional_override
		$overlay_id = $this->create_overlay( false, array(
			'post_title' => 'Is Category',
			'conditionals' => array(
				array( 'condition_select' => 'is_category', 'condition_argument_category' => $cat_id )
			)
		) );

		$this->go_to( get_term_link( $cat_id, 'category' ) );
		$footer = $this->get_wp_footer();
		// check for overlay
		$this->assertContains( '<div class="fm-overlay-wrapper">', $footer );
		// check for condition
		$this->assertContains( 'fm-overlay-is_category', $footer );
	}

	/**
	 * Tests 'has_tag' conditional class
	 */
	public function test_has_tag() {
		// Generate Tag & Post for Test
		$tag_id = $this->factory->tag->create( array( 'name' => 'tag' ) );
		$post_id = $this->factory->post->create( array( 'post_title' => 'has-tag-post', 'post_status' => 'publish', 'post_date' => '2016-04-01 00:00:00', 'post_type' => 'post' ) );
		wp_set_object_terms( $post_id, array( $tag_id ), 'post_tag' );

		// Generate Overlay and pass a $conditional_override
		$overlay_id = $this->create_overlay( false, array(
			'post_title' => 'Has Tag',
			'conditionals' => array(
				array( 'condition_select' => 'has_tag', 'condition_argument_category' => $tag_id  )
			)
		) );

		$this->go_to( get_term_link( $tag_id, 'post_tag' ) );
		$footer = $this->get_wp_footer();
		// check for overlay
		$this->assertContains( '<div class="fm-overlay-wrapper">', $footer );
		// check for condition
		$this->assertContains( 'fm-overlay-has_tag', $footer );
	}

	/**
	 * Tests 'is_tag' conditional class
	 */
	public function test_is_tag() {
		// Generate Tag & Post for Test
		$tag_id = $this->factory->tag->create( array( 'name' => 'tag' ) );
		$post_id = $this->factory->post->create( array( 'post_title' => 'is-tag-post', 'post_status' => 'publish', 'post_date' => '2016-04-01 00:00:00', 'post_type' => 'post' ) );
		wp_set_object_terms( $post_id, array( $tag_id ), 'post_tag' );

		// Generate Overlay and pass a $conditional_override
		$overlay_id = $this->create_overlay( false, array(
			'post_title' => 'Is Tag',
			'conditionals' => array(
				array( 'condition_select' => 'is_tag', 'condition_argument_category' => $tag_id  )
			)
		) );

		$this->go_to( get_term_link( $tag_id, 'post_tag' ) );
		$footer = $this->get_wp_footer();
		// check for overlay
		$this->assertContains( '<div class="fm-overlay-wrapper">', $footer );
		// check for condition
		$this->assertContains( 'fm-overlay-is_tag', $footer );
	}

	/**
	 * Tests 'is_page' conditional class
	 */
	public function test_is_page() {
		// Generate Page for Test
		$page_id = $this->factory->post->create( array( 'post_type' => 'page', 'name' => 'is_page' ) );

		// Generate Overlay and pass a $conditional_override
		$overlay_id = $this->create_overlay( false, array(
			'post_title' => 'Is Page',
			'conditionals' => array(
				array( 'condition_select' => 'is_page', 'condition_argument_category' => $page_id  )
			)
		) );

		$this->go_to( get_page_link( $page_id ) );
		$footer = $this->get_wp_footer();

		// check for overlay
		$this->assertContains( '<div class="fm-overlay-wrapper">', $footer );
		// check for condition
		$this->assertContains( 'fm-overlay-is_page', $footer );
	}

	/**
	 * Tests 'is_single' conditional class
	 */
	public function test_is_single() {
		// Generate Page for Test
		$post_id = $this->factory->post->create( array( 'name' => 'is_single' ) );

		// Generate Overlay and pass a $conditional_override
		$overlay_id = $this->create_overlay( false, array(
			'post_title' => 'Is Single',
			'conditionals' => array(
				array( 'condition_select' => 'is_single', 'condition_argument_category' => $post_id  )
			)
		) );

		$this->go_to( get_permalink( $post_id ) );
		$footer = $this->get_wp_footer();

		// check for overlay
		$this->assertContains( '<div class="fm-overlay-wrapper">', $footer );
		// check for condition
		$this->assertContains( 'fm-overlay-is_single', $footer );
	}
}
