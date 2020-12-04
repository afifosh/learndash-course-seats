<?php

/**
 *
 * @link              https://learndash.com/
 * @since             1.0.0
 * @package           Learndash_Course_Seats
 *
 * @wordpress-plugin
 * Plugin Name:       LearnDash Course Seats
 * Plugin URI:        https://github.com/bhavsinh-ker/learndash-course-seats/
 * Description:       This is plugin is extension of LearnDash LMS plugin and it is allowing option on the course configuration to limit the number of people who can take the course. (e.g 50). The number is entered by the user.
 * Version:           1.0.0
 * Author:            Bhavik Ker
 * Author URI:        https://www.linkedin.com/in/bhavik-ker-b8b04786/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       learndash-course-seats
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LEARNDASH_COURSE_SEATS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-learndash-course-seats-activator.php
 */
function activate_learndash_course_seats() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-learndash-course-seats-activator.php';
	Learndash_Course_Seats_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-learndash-course-seats-deactivator.php
 */
function deactivate_learndash_course_seats() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-learndash-course-seats-deactivator.php';
	Learndash_Course_Seats_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_learndash_course_seats' );
register_deactivation_hook( __FILE__, 'deactivate_learndash_course_seats' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-learndash-course-seats.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_learndash_course_seats() {

	$plugin = new Learndash_Course_Seats();
	$plugin->run();

}
run_learndash_course_seats();
