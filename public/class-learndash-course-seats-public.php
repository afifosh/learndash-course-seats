<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://learndash.com/
 * @since      1.0.0
 *
 * @package    Learndash_Course_Seats
 * @subpackage Learndash_Course_Seats/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Learndash_Course_Seats
 * @subpackage Learndash_Course_Seats/public
 * @author     Upen Ker <ker.upen88@gmail.com>
 */
class Learndash_Course_Seats_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Learndash_Course_Seats_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Learndash_Course_Seats_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/learndash-course-seats-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Learndash_Course_Seats_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Learndash_Course_Seats_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/learndash-course-seats-public.js', array( 'jquery' ), $this->version, false );

	}

	private function get_learndash_course_seats_data( $course_id ) {
		$course_meta_data = get_post_meta($course_id, '_sfwd-courses', true);
		$course_max_number_of_people = get_post_meta($course_id, 'max_number_of_people', true);
		if( is_wp_error( $course_meta_data ) || empty($course_meta_data) || is_wp_error( $course_max_number_of_people ) || empty($course_max_number_of_people) ) {
			return false;
		}
		$course_access_list = learndash_convert_course_access_list( $course_meta_data['sfwd-courses_course_access_list'], true );
		if( empty($course_access_list) ) {
			$course_access_list = learndash_get_course_users_access_from_meta( $course_id );
		}
		$course_access_list_count = ( ! empty( $course_access_list ) ) ? count($course_access_list) : 0;
		$seat_left = $course_max_number_of_people - $course_access_list_count;
		$seat_left = ($seat_left<=0) ? 0 : $seat_left;
		return [
			'course_access_list_count' => $course_access_list_count,
			'course_max_number_of_people' => $course_max_number_of_people,
			'seat_left' => $seat_left,
			'course_access_list' => $course_access_list
		];
	}

	public function add_seats_info_on_course_page($post_type, $course_id, $user_id) {
		$course_data = $this->get_learndash_course_seats_data( $course_id );
		if(!$course_data || !isset($course_data['seat_left'])) {
			return '';
		}
		$seat_left = $course_data['seat_left'];
		$seats_info_text = $seat_left.' '.__('Seat(s) Left', 'learndash-course-seats');
		if($seat_left<=0) {
			$seats_info_text = __('Seat not available', 'learndash-course-seats');
		}
		echo $seats_info_text;
	}

	public function learndash_course_seats_modify_payment_button( $join_button, $payment_params ) {
		
		$course_id = isset($payment_params['post']->ID) ? $payment_params['post']->ID : false;

		if(!$course_id) {
			return $join_button;
		}

		$course_data = $this->get_learndash_course_seats_data( $course_id );
		if(!$course_data || !isset($course_data['seat_left'])) {
			return $join_button;
		}

		$seat_left = $course_data['seat_left'];
		if($seat_left<=0) {
			echo '<div class="learndash-course-seats-get-started-text ld-status ld-status-error ld-tertiary-background">'.__('Course Seats are Full', 'learndash-course-seats').'</div>';
			return '';
		}

		return $join_button;
	}

}
