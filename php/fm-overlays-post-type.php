<?php
/**
 * fm-overlays-post-type.php
 *
 * @created     1/6/16 3:42 PM
 * @author      Alley Interactive
 * @package     fm-overlays
 * @description Set up the custom post type for the overlays
 *
 */
if ( ! class_exists( 'Fm_Overlays_Post_Type' ) ) :

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
			 *
			 * @TODO Build out useful FM fields for this post type.
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
				'labels' => array(
					'name'               => __( 'Overlay', FM_OVERLAYS_DOMAIN ),
					'singular_name'      => __( 'Overlay', FM_OVERLAYS_DOMAIN ),
					'add_new'            => __( 'Add New Overlay', FM_OVERLAYS_DOMAIN ),
					'add_new_item'       => __( 'Add New Overlay', FM_OVERLAYS_DOMAIN ),
					'edit_item'          => __( 'Edit Overlay', FM_OVERLAYS_DOMAIN ),
					'new_item'           => __( 'New Overlay', FM_OVERLAYS_DOMAIN ),
					'view_item'          => __( 'View Overlay', FM_OVERLAYS_DOMAIN ),
					'search_items'       => __( 'Search Overlays', FM_OVERLAYS_DOMAIN ),
					'not_found'          => __( 'No Overlays found', FM_OVERLAYS_DOMAIN ),
					'not_found_in_trash' => __( 'No Overlays found in Trash', FM_OVERLAYS_DOMAIN ),
					'menu_name'          => __( 'Overlays', FM_OVERLAYS_DOMAIN ),
				),
				'menu_icon' => 'dashicons-admin-page',
				'public' => false,
				'show_ui' => true,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'show_in_menu' => true,
				'show_in_nav_menus' => false,
				'supports' => array( 'title', 'revisions' ),
			) );
		}

		/**
		 * Adds the meta boxes required to manage an overlay.
		 */
		public function add_meta_boxes() {

			$fm = new Fieldmanager_TextField( array(
				'name' => 'fm_overlay_header',
			) );
			$fm->add_meta_box( __( 'Overlay Header', FM_OVERLAYS_DOMAIN ), $this->post_type, 'normal', 'high' );
		}
	}

	Fm_Overlays_Post_Type::instance();

endif;
