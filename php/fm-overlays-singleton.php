<?php
/**
 * fm-overlays-post-type.php
 *
 * Abstract class to be implemented by all other singleton Fm Overlays classes.
 *
 * @created     1/6/16 3:42 PM
 * @author      Alley Interactive
 * @package     fm-overlays
 * @description Set up the custom post type for the overlays
 */
if ( ! class_exists( 'Fm_Overlays_singleton' ) ) :
	abstract class Fm_Overlays_singleton {
		/**
		 * Reference to the singleton instance.
		 *
		 * @var Fm_Overlays_singleton
		 */
		private static $instances;

		protected function __construct() {
			/*
			 * Silence is golden - intentionally left blank
			 */
		}

		/**
		 * Method to get an instance.
		 *
		 * @return Fm_Overlays_singleton
		 */
		public static function instance() {
			$class_name = get_called_class();

			if ( ! isset( self::$instances[ $class_name ] ) ) {
				self::$instances[ $class_name ] = new $class_name;
				self::$instances[ $class_name ]->setup();
			}

			return self::$instances[ $class_name ];
		}

		/**
		 * Method that sets up new classes.
		 */
		abstract public function setup();
	}
endif;