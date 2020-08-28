<?php
/**
 * FM Overlays Singleton
 *
 * Abstract class to be implemented by all other singleton Fm Overlays classes.
 *
 * @created     1/6/16 3:42 PM
 * @author      Alley Interactive
 * @package     fm-overlays
 * @description Set up the custom post type for the overlays
 */

/**
 * Class Fm_Overlays_Singleton
 */
abstract class Fm_Overlays_Singleton {
	/**
	 * Reference to the singleton instance.
	 *
	 * @var Fm_Overlays_Singleton
	 */
	private static $instances;

	/**
	 * Fm_Overlays_Singleton constructor.
	 */
	protected function __construct() {
		/*
		 * Silence is golden - intentionally left blank
		 */
	}

	/**
	 * Method to get an instance.
	 *
	 * @return $this
	 */
	public static function instance() {
		$class_name = get_called_class();

		if ( ! isset( self::$instances[ $class_name ] ) ) {
			self::$instances[ $class_name ] = new $class_name; // phpcs:ignore WordPress.Classes.ClassInstantiation.MissingParenthesis
			self::$instances[ $class_name ]->setup();
		}

		return self::$instances[ $class_name ];
	}

	/**
	 * Method that sets up new classes.
	 */
	protected function setup() {}
}
