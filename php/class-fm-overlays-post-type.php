<?php
/**
 * class-class-fm-overlays-post-type.php
 *
 * @created     1/6/16 3:42 PM
 * @author      Alley Interactive
 * @package     fm-overlays
 * @description Set up the abstract base class for all fm-overlays singletons.
 *
 */

class Fm_Overlays_Post_Type extends Fm_Overlays_Singleton {

	/**
	 * Post type name.
	 * @access public
	 * @var string
	 */
	public $post_type = 'fm-overlay';

	/**
	 * Set us up the singleton, why don't we?
	 */
	public function setup() {
		// Create overlay post type
		add_action( 'init', array( $this, 'create_post_type' ) );

		/**
		 * Add the custom meta boxes for managing this post type
		 */
		add_action( 'fm_post_' . $this->post_type, array( $this, 'add_meta_boxes' ) );

		/**
		 * @TODO Integrate targeting logic (yet to be created -- look into ad-layers for inspo).
		 */
	}

	/**
	 * Obviously, this method creates the post type.
	 */
	public function create_post_type() {
		register_post_type( $this->post_type, array(
			'labels'              => array(
				'name'               => __( 'Overlay', 'fm-overlays' ),
				'singular_name'      => __( 'Overlay', 'fm-overlays' ),
				'add_new'            => __( 'Add New Overlay', 'fm-overlays' ),
				'add_new_item'       => __( 'Add New Overlay', 'fm-overlays' ),
				'edit_item'          => __( 'Edit Overlay', 'fm-overlays' ),
				'new_item'           => __( 'New Overlay', 'fm-overlays' ),
				'view_item'          => __( 'View Overlay', 'fm-overlays' ),
				'search_items'       => __( 'Search Overlays', 'fm-overlays' ),
				'not_found'          => __( 'No Overlays found', 'fm-overlays' ),
				'not_found_in_trash' => __( 'No Overlays found in Trash', 'fm-overlays' ),
				'menu_name'          => __( 'Overlays', 'fm-overlays' ),
			),
			'menu_icon'           => 'dashicons-admin-page',
			'public'              => false,
			'show_ui'             => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'supports'            => array( 'title', 'revisions' ),
		) );
	}

	/**
	 * Adds the meta boxes required to manage an overlay.
	 *
	 * @TODO Build out useful content fields for this post type.
	 */
	public function add_meta_boxes() {
		$fm = new Fieldmanager_Group( array(
			'name' => 'fm_overlays_conditionals',
			'collapsible' => true,
			'sortable' => true,
			'limit' => 0,
			'label' => 'Condition',
			'add_more_label' => __( 'Add another condition', 'fm-overlays' ),
			'extra_elements' => 0,
			'children' => array(
				'condition_select' => new Fieldmanager_Select( array(
					'attributes' => array(
						'conditional' => 'labels',
					),
					'options' => array(
						'is_home' => __( 'Is Home', 'fm-overlays' ),
						'is_front_page' => __( 'Is Front Page', 'fm-overlays' ),
						'is_category' => __( 'Is Category', 'fm-overlays' ),
						'has_category' => __( 'Has Category', 'fm-overlays' ),
						'is_single' => __( 'Is Single', 'fm-overlays' ),
						'is_page' => __( 'Is Page', 'fm-overlays' ),
						'is_tag' => __( 'Is Tag', 'fm-overlays' ),
						'has_tag' => __( 'Has Tag', 'fm-overlays' ),
					),
				) ),
				'condition_argument_category' => new Fieldmanager_Autocomplete( array(
					'display_if' => array(
						'src' => 'condition_select',
						'value' => 'is_category,has_category',
					),
					'label' => __( 'Specific Category (Leave blank for any category)', 'fm-overlays' ),
					'datasource' => new Fieldmanager_Datasource_Term( array(
						'taxonomy' => 'category',
					) ),
				) ),
				'condition_argument_tag' => new Fieldmanager_Autocomplete( array(
					'display_if' => array(
						'src' => 'condition_select',
						'value' => 'is_tag,has_tag',
					),
					'label' => __( 'Specific tag (Leave blank for any tag)', 'fm-overlays' ),
					'datasource' => new Fieldmanager_Datasource_Term( array(
						'taxonomy' => 'post_tag',
					) ),
				) ),
				'condition_argument_single' => new Fieldmanager_Autocomplete( array(
					'display_if' => array(
						'src' => 'condition_select',
						'value' => 'is_single',
					),
					'label' => __( 'Specific post (Leave blank for any single post)', 'fm-overlays' ),
					'datasource' => new Fieldmanager_Datasource_Post( array(
						'query_args' => array(
							'post_type' => 'post',
						),
					) ),
				) ),
				'condition_argument_page' => new Fieldmanager_Autocomplete( array(
					'display_if' => array(
						'src' => 'condition_select',
						'value' => 'is_page',
					),
					'label' => __( 'Specific page (Leave blank for any WP page)', 'fm-overlays' ),
					'datasource' => new Fieldmanager_Datasource_Post( array(
						'query_args' => array(
							'post_type' => 'page',
						),
					) ),
				) ),
			),
		) );
		$fm->add_meta_box( __( 'Use these fields to determine on which pages this overlay will appear.', 'fm-overlays' ), $this->post_type, 'normal', 'high' );
	}
}

Fm_Overlays_Post_Type::instance();
