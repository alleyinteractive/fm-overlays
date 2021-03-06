<?php
/**
 * FM Overlays
 *
 * @created     1/14/16 4:55 PM
 * @author      Alley Interactive
 * @package     fm-overlays
 * @description Handles basic plugin functionality
 *
 */

/**
 * Class Fm_Overlays
 */
class Fm_Overlays extends Fm_Overlays_Singleton {
	/**
	 * Targeted conditions.
	 *
	 * @var array targeted conditions.
	 */
	public $targeted_conditions = array();

	/**
	 * Set up
	 */
	public function setup() {
		// Handle transient flushing.
		add_action( 'save_post', array( $this, 'destroy_transient' ) );

		// Load in front end assets.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_fe_assets' ) );

		// Display the overlay post markup.
		add_action( 'wp_footer', array( $this, 'display_overlay' ) );
	}

	/**
	 * Load in scripts and styles used by the front end
	 */
	public function enqueue_fe_assets() {
		wp_enqueue_style( 'fm-overlays-global-css', FM_OVERLAYS_ASSET_URL . '/static/css/global.min.css', array(), FM_GLOBAL_ASSET_VERSION );
		wp_enqueue_script( 'fm-overlays-global-js', FM_OVERLAYS_ASSET_URL . '/static/js/global.min.js', array(), FM_GLOBAL_ASSET_VERSION, true );
	}

	/**
	 * Get untargeted, unprioritized overlays
	 *
	 * @return array|bool|mixed
	 */
	public function get_overlays() {
		$fm_overlays_post_type = Fm_Overlays_Post_Type()->get_post_type();

		/**
		 * Filter: fm_overlays_post_count
		 *
		 * Limit overlays query to 50 posts by default.
		 * Ideally, any usecase would have far less than 50 active overlays.
		 *
		 * @param int numberposts controls the number of posts retrieved by get_posts
		 * @since 1.0.0
		 */
		$args = array(
			'post_type'        => $fm_overlays_post_type,
			'numberposts'      => apply_filters( 'fm_overlays_post_count', 50 ),
			'suppress_filters' => false,
			'oderby'           => 'menu_order date',
			'order'            => 'DESC',
		);

		$fm_overlays = get_transient( 'fm_overlays' );

		if ( empty( $fm_overlays ) ) {
			$_overlays = get_posts( $args ); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_posts_get_posts

			foreach ( $_overlays as $_overlay_cpt ) {
				$priority = (int) $_overlay_cpt->menu_order;

				$fm_overlays[] = array(
					'conditionals' => $this->get_conditionals( $_overlay_cpt->ID ),
					'priority'     => $priority,
					'post_id'      => $_overlay_cpt->ID,
				);
			}

			set_transient( 'fm_overlays', $fm_overlays, 60 * MINUTE_IN_SECONDS );
		}

		return $fm_overlays;
	}

	/**
	 * Get the latest overlay post id that is targeted by the conditionals.
	 *
	 * @TODO Add caching to this function.
	 * @return array|null|WP_Post
	 */
	public function get_targeted_overlay() {
		// Find the latest overlay that is targeted by the conditionals.
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

				/*
				 * Check if overlay is targeted via conditionals
				 * returns count of all positive matches
				 */
				$targeted_conditionals = $this->process_overlay_conditions( $overlay );

				/*
				 * Verify the validity of the condition based on the function call result
				 * and the affirmation/negation of the condition.
				 */
				if ( $targeted_conditionals > 0 ) {
					// Add a key to conditional array if it was targeted then add to collection.
					$overlay['conditionals_matched'] = $targeted_conditionals;
					$targeted_overlays[]             = $overlay;
				}
			}
		}

		// We don't need to continue if there are no targeted overlays.
		if ( empty( $targeted_overlays ) ) {
			return null;
		}

		/*
		 * Prioritize the display of the overlays based on
		 * the priority (menu order) of the overlays
		 */
		$overlay_to_display = $this->prioritize_overlays( $targeted_overlays );

		return ( ! empty( $overlay_to_display['post_id'] ) ) ? get_post( $overlay_to_display['post_id'] ) : null;
	}

	/**
	 * Helper to return the appropriate associated conditional arg meta field.
	 *
	 * @param array $conditional FM Overlay targeting conditional.
	 * @return string
	 */
	private function _get_associated_conditional_arg( $conditional ) { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
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
	 * @param int $post_id Post ID.
	 */
	public function destroy_transient( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Remove action to prevent infinite loops should something be added that fires `save_post`.
		remove_action( 'save_post', 'destroy_transient' );

		if ( Fm_Overlays_Post_Type()->get_post_type() === get_post_type( $post_id ) ) {
			delete_transient( 'fm_overlays' );
		}

		// Re-add removed callback.
		add_action( 'save_posts', 'destroy_transient' );
	}

	/**
	 * Get the conditional values for an overlay
	 *
	 * @param int $overlay_id Overlay ID.
	 * @return bool|mixed
	 */
	public static function get_conditionals( $overlay_id ) {
		$conditionals = get_post_meta( $overlay_id, 'fm_overlays_conditionals', true );

		return ( empty( $conditionals ) ) ? false : $conditionals;
	}

	/**
	 * Get Overlay Cookie Name
	 * See global.js for cookie name
	 *
	 * @param int $overlay_id Overlay ID.
	 * @return string
	 */
	public static function get_overlay_cookie_name( $overlay_id ) {
		$cookie_name = Fm_Overlays_Post_Type()->post_type . '-' . $overlay_id;

		return $cookie_name;
	}

	/**
	 * Get overlay cookie expiration time in hours.
	 * Defaults to 24 hours.
	 *
	 * @param int $overlay_id Overlay ID.
	 * @return string
	 */
	public static function get_overlay_expiration( $overlay_id ) {
		$expiration = get_post_meta( $overlay_id, 'fm_overlays_config_expiration', true );

		return ( empty( $expiration ) ) ? apply_filters( 'fm_overlays_default_expiration', 24 ) : $expiration;
	}

	/**
	 * Logic for including overlays based on their conditionals.
	 *
	 * @todo Perform further testing on the various combinations of conditions with and without args.
	 * @param array $overlay Overlay.
	 * @return int
	 */
	public function process_overlay_conditions( $overlay ) {
		// include if the conditionals are empty.
		$include = 0;

		// reset for each overlay.
		$this->targeted_conditions = array();

		// pull in conditional meta array.
		$conditional_meta = get_post_meta( $overlay['post_id'], 'fm_overlays_conditionals', true );

		if ( ! empty( $overlay['conditionals'] ) ) {
			foreach ( $overlay['conditionals'] as $key => $condition ) {
				// Begin with the faith that this condition is false.
				$result = false;

				// used to pass targeted conditions to class var.
				$cond_str_prefix = '';

				// start with the assumption that that the condition is affirmative.
				// (i.e. that the condition is not negated).
				$affirmative_condition = true;

				// The name of the conditional function is the same as the select value.
				// note: this will always be set as long as $overlay['conditionals'] is not empty.
				$cond_func = $condition['condition_select'];

				// get the associated arguments meta field.
				$cond_arg_key = $this->_get_associated_conditional_arg( $condition );
				if ( ! empty( $cond_arg_key ) ) {
					$cond_arg = isset( $conditional_meta[ $key ][ $cond_arg_key ] ) ? $conditional_meta[ $key ][ $cond_arg_key ] : '';
				}

				// If the condition is negated, then we need to skip the condition.
				if ( isset( $condition['condition_negation'] ) && 'negated' === $condition['condition_negation'] ) {
					$affirmative_condition = false;
					$cond_str_prefix       = 'not-';
				}

				/*
				 * Run conditional function that is passed
				 * from the Fieldmanager select options.
				 */
				if ( empty( $cond_arg ) ) {
					$result = call_user_func( $cond_func );
				} elseif ( ! empty( $cond_arg ) && true === $affirmative_condition ) {
					$result = call_user_func( $cond_func, $cond_arg );
				}

				/*
				 * Verify the validity of the condition based on the function call result
				 * and the affirmation/negation of the condition.
				 */
				if ( $affirmative_condition === $result ) {
					++$include;
					$this->targeted_conditions[] = $cond_str_prefix . $cond_func;
				}
			}
		}

		return $include;
	}

	/**
	 * Prioritize the display of the Overlays
	 *
	 * To prioritize overlays a point value is associated
	 * with various overlay configuration settings.
	 *
	 * Prioritization Point System:
	 *
	 * 200 Conditional Specificity
	 * 50  Conditioanl Match
	 * +   Menu Order Value
	 *
	 * @param array $unprioritized_overlays Unprioritized Overlays.
	 * @return mixed
	 */
	public function prioritize_overlays( $unprioritized_overlays = array() ) {
		// Begin by assuming there are no specially prioritized overlays.
		$prioritization_basis = 'date';
		$prioritized_overlays = array();

		foreach ( $unprioritized_overlays as $overlay ) {
			/*
			 * Check for Conditional Specificity
			 *
			 * Find out if the conditionals contain a target, and
			 * adjust its priority weight accordingly
			 */
			$is_specific = false;
			$priority    = 0;

			// act on conditionals if we have them.
			if ( ! empty( $overlay['conditionals'] ) && is_array( $overlay['conditionals'] ) ) {
				// loop through each conditional attached to the overlay.
				foreach ( $overlay['conditionals'] as $condition ) {
					$cond_arg_key = $this->_get_associated_conditional_arg( $condition );
					// check if condition contains target specificity.
					if ( isset( $condition[ $cond_arg_key ] ) ) {
						$is_specific = true;
					}
				}

				// check if the overlay is specifically targeted to a page, tax, term, or tag.
				if ( $is_specific ) {

					/**
					 * Filter: fm_overlays_is_specific_priority
					 *
					 * Edit the value applied to priority when an overlay is specifically targeted.
					 * Defaults to 200.
					 *
					 * @param float $priority weight of targeted overlays.
					 * @since 1.0.0
					 */
					$priority += floatval( apply_filters( 'fm_overlays_is_specific_priority', 200 ) );
				}

				// each matching conditionals adds 50 to the priority weight.
				if ( ! empty( $condition['conditionals_matched'] ) && is_int( $condition['conditionals_matched'] ) ) {

					/**
					 * Filter: fm_overlays_conditional_matched_priority
					 *
					 * Edit the value addded to priority for each overlay conditional that returns true.
					 * Defaults to 50.
					 *
					 * @param float $priority weight of matched conditionals.
					 * @since 1.0.0
					 */
					$priority += $condition['conditionals_matched'] * floatval( apply_filters( 'fm_overlays_conditional_matched_priority', 50 ) );
				}
			}

			// Add in the menu order value to our overall priority.
			$priority += ( ! empty( $overlay['priority'] ) ) ? $overlay['priority'] : 0;

			/**
			 * Filter: fm_overlays_priority_override
			 *
			 * Completely override the priority value of a specific overlay.
			 * The current overlay is passed as the second argument.
			 *
			 * @param int    $priority current priority value after calculating conditionals and menu order.
			 * @param object $overlay  Instance of overlay post object being prioritized
			 * @since 1.0.0
			 */
			$priority = absint( apply_filters( 'fm_overlays_priority_override', $priority, $overlay ) );

			$prioritized_overlays[ $priority ][] = $overlay;

			// if there is a set menu order, then base the prioritization
			// on menu_order instead of post date.
			$prioritization_basis = ( $priority > 0 ) ? 'menu_order' : $prioritization_basis;
		}

		if ( 'menu_order' === $prioritization_basis ) {
			// The highest array index value is the highest priority.
			$prioritized_index   = max( array_keys( $prioritized_overlays ) );
			$prioritized_overlay = $prioritized_overlays[ $prioritized_index ];

			/*
			 * $$prioritized_overlay could be an array of overlays with the same menu_order priority.
			 * The first one will be the latest, most preferred overlay.
			 */
			$prioritized_overlay = $prioritized_overlay[0];
		} else {
			// $prioritization is by 'date', take the first one, since it will be the latest.
			$prioritized_overlay = $unprioritized_overlays[0];
		}

		return $prioritized_overlay;
	}

	/**
	 * Display overlay markup in footer
	 *
	 * @param null $overlay_id Overlay ID.
	 * @todo Add caching to this function
	 */
	public function display_overlay( $overlay_id = null ) {
		if ( empty( $overlay_id ) ) {
			$overlay = $this->get_targeted_overlay();
		} elseif ( null !== $overlay_id ) {
			$overlay = get_post( absint( $overlay_id ) );
		}

		/*
		 * make sure we were able to populate $overlay before trying
		 * to find a cookie using its ID
		 */
		if ( ! empty( $overlay ) ) {
			/*
			 * we don't want to display same overlay more than once in a day
			 * so we set a cookie on the client for 20 hours after initial
			 * render of each overlay.
			 */
			$overlay_cookie_name = $this->get_overlay_cookie_name( $overlay->ID );

			if ( empty( $_COOKIE[ $overlay_cookie_name ] ) ) { // phpcs:ignore WordPressVIPMinimum.Variables.RestrictedVariables.cache_constraints___COOKIE
				// Enhance overlay post object with additional post meta to be used in templating.
				$overlay->overlay_content = get_post_meta( $overlay->ID, 'fm_overlays_content', true );

				// include overlay-basic in site footer.
				include FM_OVERLAYS_PATH . 'templates/fm-overlay-basic.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
			}
		}
	}
}

/**
 * Define callable.
 *
 * @return Fm_Overlays
 */
function FM_Overlays() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return Fm_Overlays::instance();
}

FM_Overlays();
