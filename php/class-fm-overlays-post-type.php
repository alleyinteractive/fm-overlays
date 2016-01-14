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
		/**
		 * Create overlay post type
		 */
		add_action( 'init', array( $this, 'create_post_type' ) );

		/**
		 * add order column to admin listing screen for menu order
		 */
		add_filter( "manage_{$this->post_type}_posts_columns", array( $this, 'add_menu_order_column' ) );

		/**
		 * Show columns
		 */
		add_action( "manage_{$this->post_type}_posts_custom_column", array( $this, 'show_menu_order_column' ), 10, 2 );

		/**
		 * Register the menu order column as "sortable".
		 */
		add_filter( "manage_edit-{$this->post_type}_sortable_columns", array( $this, 'register_sortable_menu_order_column' ) );

		/**
		 * Load sorted Overlays in admin area by priority
		 */
		add_action( 'pre_get_posts', array( $this, 'load_sorted_by_columns' ) );

		/**
		 * Add the custom meta boxes for managing this post type
		 */
		add_action( 'fm_post_' . $this->post_type, array( $this, 'add_meta_boxes' ) );

		/**
		 * Handle transient flushing.
		 */
		add_action( 'save_post', array( $this, 'destroy_transient' ) );

		/**
		 * Display the overlay post markup
		 */
		add_action( 'wp_footer', array( $this, 'display_overlay' ) );
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
			'supports'            => array( 'title', 'revisions', 'page-attributes' ),
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
			'label' => __( 'Condition', 'fm-overlays' ),
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
				'condition_negation' => new Fieldmanager_Checkbox( array(
					'label_after_element' => false,
					'label' => __( 'Not this condition', 'fm-overlays' ),
					'checked_value' => 'negated',
					'default_value' => '0',
				) ),
			),
		) );
		$fm->add_meta_box( __( 'Use these fields to determine on which pages this overlay will appear.', 'fm-overlays' ), $this->post_type, 'normal', 'high' );
	}

	/**
	 * Get overlay content
	 *
	 * @return array|bool|mixed
	 */
	public function get_overlays() {
		/**
		 * Filter: fm_overlays_post_count
		 *
		 * Limit overlays query to 50 posts by default.
		 * Ideally, any usecase would have far less than 50 active overlays.
		 *
		 * At any rate, use this filter to change limit.
		 */
		$args = array(
			'post_type' => $this->post_type,
			'numberposts' => apply_filters( 'fm_overlays_post_count', 50 ),
			'suppress_filters' => false,
			'oderby' => 'menu_order date',
			'order' => 'DESC',
		);

		$fm_overlays = get_transient( 'fm_overlays' );

		if ( empty( $fm_overlays ) ) {
			$_overlays = get_posts( $args );

			foreach ( $_overlays as $_overlay_cpt ) {
				$priority = (int) $_overlay_cpt->menu_order;

				$fm_overlays[] = array(
					'conditionals' => $this->get_conditionals( $_overlay_cpt->ID ),
					'priority' => $priority,
					'post_id' => $_overlay_cpt->ID,
				);
			}

			set_transient( 'fm_overlays', $fm_overlays, 60 * MINUTE_IN_SECONDS );
		}

		wp_reset_query();

		return $fm_overlays;
	}

	/**
	 * Get the latest overlay post id that is targeted by the conditionals.
	 *
	 * @TODO Add caching to this function.
	 *
	 * @return array|null|WP_Post
	 */
	public function get_targeted_overlay() {
		/**
		 * Find the latest overlay that is targeted by the conditionals.
		 */
		$targeted_overlays = array();

		$overlays = $this->get_overlays();

		if ( ! empty( $overlays ) ) {
			foreach ( $overlays as $overlay ) {
				// If the overlay doesn't have any conditionals, it matches everything,
				// so add it to the list of targeted overlays.
				if ( empty( $overlay['conditionals'] ) ) {
					$targeted_overlays[] = $overlay;
					continue;
				}

				/**
				 * Is this overly targeted as a result of this condition?
				 */
				$is_targeted = $this->process_overlay_conditions( $overlay );

				/**
				 * Verify the validity of the condition based on the function call result
				 * and the affirmation/negation of the condition.
				 */
				if ( true === $is_targeted ) {
					$targeted_overlays[] = $overlay;
				}
			}
		}

		// We don't need to continue if there are no targeted overlays
		if ( empty( $targeted_overlays ) ) {
			return null;
		}

		/**
		 * Prioritize the display of the overlays based on
		 * the priority (menu order) of the overlays
		 */
		$overlay_to_display = $this->prioritize_overlays( $targeted_overlays );

		return ( ! empty( $overlay_to_display['post_id'] ) ) ? get_post( $overlay_to_display['post_id'] ) : null;
	}

	/**
	 * Helper to return the appropriate associated conditional arg meta field.
	 * @param $conditional
	 *
	 * @return string
	 */
	private function _get_associated_conditional_arg( $conditional ) {
		$conditional_args = '';

		if ( ! empty( $conditional['condition_select'] ) ) {
			// remove the word is or has from the condition select field
			// and we are left with the condition_argument_* meta field name we are looking for.
			$conditional_args = 'condition_argument' . str_replace( array( 'is', 'has' ), '', $conditional['condition_select'] );
		}

		return $conditional_args;
	}

	/**
	 * Destroy transient
	 *
	 * @param $post_id
	 */
	public function destroy_transient( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// follow this pattern to prevent infinite loops should something be added that fires `save_post`
		// see final line of function
		remove_action( 'save_post', 'destroy_transient' );

		if ( $this->post_type === get_post_type( $post_id ) ) {
			delete_transient( 'fm_overlays' );
		}

		add_action( 'save_posts', 'destroy_transient' );
	}

	/**
	 * Get the conditional values for an overlay
	 *
	 * @param $overlay_id
	 *
	 * @return bool|mixed
	 */
	public function get_conditionals( $overlay_id ) {
		$conditionals = get_post_meta( $overlay_id, 'fm_overlays_conditionals', true );
		return ( empty( $conditionals ) ) ? false : $conditionals;
	}

	/**
	 * Logic for including overlays based on their conditionals.
	 *
	 * @TODO Perform further testing on the various combinations of conditions with and without args.
	 *
	 * @param $overlay
	 *
	 * @return array
	 */
	public function process_overlay_conditions( $overlay ) {
		// include if the conditionals are empty
		$include = true;

		if ( ! empty( $overlay['conditionals'] ) ) {
			foreach ( $overlay['conditionals'] as $condition ) {
				// Begin with the faith that this condition is false.
				$result = false;

				// start with the assumption that that the condition is affirmative
				// (i.e. that the condition is not negated)
				$affirmative_condition = true;

				// The name of the conditional function is the same as the select value.
				// note: this will always be set as long as $overlay['conditionals'] is not empty
				$cond_func = $condition['condition_select'];

				// get the associated arguments meta field
				$cond_arg = get_post_meta( $overlay['post_id'], $this->_get_associated_conditional_arg( $condition ), true );

				// If the condition is negated, then we need to skip the condition.
				if ( isset( $condition['condition_negation'] ) && 'negated' === $condition['condition_negation'] ) {
					$affirmative_condition = false;
				}

				/**
				 * Run conditional function that is passed
				 * from the Fieldmanager select options.
				 */
				if ( empty( $cond_arg ) ) {
					$result = call_user_func( $cond_func );
				} elseif ( ! empty( $cond_arg ) && true === $affirmative_condition ) {
					$result = call_user_func( $cond_func, $cond_arg );
				}

				/**
				 * Verify the validity of the condition based on the function call result
				 * and the affirmation/negation of the condition.
				 */
				if ( $affirmative_condition === $result ) {
					$include = true;
				} else {
					$include = false;
				}
			}
		}

		return $include;
	}

	/**
	 * Add Menu Order to columns
	 *
	 * @param $columns
	 *
	 * @return mixed
	 */
	public function add_menu_order_column( $columns ) {
		$new_columns = array(
			'menu_order'   => __( 'Priority', 'fm-overlays' ),
		);

		return array_merge( $columns, $new_columns );
	}

	/**
	 * Show custom order column values
	 *
	 * @param $name
	 */
	public function show_menu_order_column( $name ) {
		global $post;

		switch ( $name ) {
			case 'menu_order':
				$order = $post->menu_order;
				echo (int) $order ;
				break;
			default:
				break;
		}
	}

	/**
	 * Register the menu order column as "sortable".
	 *
	 * @param $columns
	 *
	 * @return mixed
	 */
	public function register_sortable_menu_order_column( $columns ) {
		$columns['menu_order'] = 'menu_order';

		return $columns;
	}

	/**
	 * Using pre_get_posts, make sure the overlays are
	 * loading sorted by priority in the admin area
	 *
	 * @param $query
	 */
	public function load_sorted_by_columns( $query ) {
		if ( ! is_admin() || $this->post_type !== get_query_var( 'post_type' ) ) {
			return;
		}

		$query->set( 'orderby', 'menu_order date' );
		$query->set( 'order', 'DESC' );
	}

	/**
	 * Prioritize the display of the overlays based on
	 * the priority (menu order) of the overlays
	 *
	 * @param array $unprioritized_overlays
	 *
	 * @return mixed
	 */
	public function prioritize_overlays( $unprioritized_overlays = array() ) {
		// Begin by assuming there are no specially prioritized overlays.
		$prioritization_basis = 'date';
		$prioritized_overlays = array();

		foreach ( $unprioritized_overlays as $overlay ) {
			$priority = ( ! empty( $overlay['priority'] ) ) ? $overlay['priority'] : 0;
			$prioritized_overlays[ $priority ][] = $overlay;

			// if there is a set menu order, then base the prioritization
			// on menu_order instead of post date.
			$prioritization_basis = ( $priority > 0  ) ? 'menu_order' : $prioritization_basis;
		}

		if ( 'menu_order' === $prioritization_basis ) {
			// The highest array index value is the highest priority
			$prioritized_index = max( array_keys( $prioritized_overlays ) );
			$prioritized_overlay = $prioritized_overlays[ $prioritized_index ];

			/*
			 * $overlay_to_display could be an array of overlays with the same menu_order priority.
			 * The first one will be the latest, most preferred overlay.
			 */
			$prioritized_overlay = $prioritized_overlay[0];
		} else {
			// $prioritization is by 'date', take the first one, since it will be the latest
			$prioritized_overlay = $unprioritized_overlays[0];
		}

		return $prioritized_overlay;
	}

	/**
	 * Display overlay markup in footer
	 *
	 * @param null $overlay_id
	 */
	public function display_overlay( $overlay_id = null ) {
		if ( empty( $overlay_id ) ) {
			$overlay = $this->get_targeted_overlay();
		} else {
			$overlay = get_post( absint( $overlay_id ) );
		}

		if ( ! empty( $overlay ) ) {
			/**
			 * @TODO Retrieve and output the overlay content (currently awaiting content fields to be added to the Overlay CPT)
			 */
		}
	}
}

Fm_Overlays_Post_Type::instance();
