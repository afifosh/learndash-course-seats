<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://learndash.com/
 * @since      1.0.0
 *
 * @package    Learndash_Course_Seats
 * @subpackage Learndash_Course_Seats/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Learndash_Course_Seats
 * @subpackage Learndash_Course_Seats/includes
 * @author     Upen Ker <ker.upen88@gmail.com>
 */
class Learndash_Course_Seats_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'learndash-course-seats',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
