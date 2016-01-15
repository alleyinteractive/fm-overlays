<?php
/**
 * class-fm-overlays.php
 *
 * @created     1/14/16 4:55 PM
 * @author      Alley Interactive
 * @package     fm-overlays
 * @description Handles basic plugin functionality
 *
 */

class Fm_Overlays extends Fm_Overlays_Singleton {
	/**
	 * Set up
	 */
	public function setup() {
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
	 * Get untargeted, unprioritized overlays
	 *
	 * @return array|bool|mixed
	 */
	public function get_overlays() {
		$fm_overlays_post_type = Fm_Overlays_Post_Type::instance()->get_post_type();

		/**
		 * Filter: fm_overlays_post_count
		 *
		 * Limit overlays query to 50 posts by default.
		 * Ideally, any usecase would have far less than 50 active overlays.
		 *
		 * At any rate, use this filter to change limit.
		 */
		$args = array(
			'post_type' => $fm_overlays_post_type,
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
	 * @param array $conditional
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
	 * @param int $post_id
	 */
	public function destroy_transient( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// follow this pattern to prevent infinite loops should something be added that fires `save_post`
		// see final line of function
		remove_action( 'save_post', 'destroy_transient' );

		if ( Fm_Overlays_Post_Type::instance()->get_post_type() === get_post_type( $post_id ) ) {
			delete_transient( 'fm_overlays' );
		}

		add_action( 'save_posts', 'destroy_transient' );
	}

	/**
	 * Get the conditional values for an overlay
	 *
	 * @param int $overlay_id
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
	 * @param array $overlay
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
			 * $$prioritized_overlay could be an array of overlays with the same menu_order priority.
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
		} elseif ( null === $overlay_id ) {
			$overlay = get_post( absint( $overlay_id ) );
		}

		if ( ! empty( $overlay ) ) {
			/**
			 * @TODO Retrieve and output the overlay content (currently awaiting content fields to be added to the Overlay CPT)
			 */
		}
	}
}

Fm_Overlays::instance();
