<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://learndash.com/
 * @since      1.0.0
 *
 * @package    Learndash_Course_Seats
 * @subpackage Learndash_Course_Seats/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Learndash_Course_Seats
 * @subpackage Learndash_Course_Seats/admin
 * @author     Upen Ker <ker.upen88@gmail.com>
 */
class Learndash_Course_Seats_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/learndash-course-seats-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/learndash-course-seats-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_course_setting_fields( $setting_option_fields = array(), $settings_metabox_key = '' ) {
		// Check the metabox includes/settings/settings-metaboxes/class-ld-settings-metabox-course-access-settings.php line 23 where
        // settings_metabox_key is set. Each metabox or section has a unique settings key.
        if ( 'learndash-course-access-settings' === $settings_metabox_key ) {
 
            // Add field here.
            $post_id           = get_the_ID();
            $my_settings_value = get_post_meta( $post_id, 'max_number_of_people', true );
             
            if ( ! isset( $setting_option_fields['max-number-of-people'] ) ) {
                $setting_option_fields['max-number-of-people'] = array(
                    'name'      => 'max-number-of-people',
                    'label'     => sprintf(
                        // translators: placeholder: Course.
                        esc_html_x( '%s Max Number of People', 'placeholder: (e.g 50)', 'learndash-course-seats' ),
                        learndash_get_custom_label( 'course' )
                    ),
                    // Check the LD fields ligrary under incldues/settings/settings-fields/
                    'type'      	=> 'text',
                    'class'     	=> '-medium',
                    'value'     	=> $my_settings_value,
					'default'   	=> '',
					'placeholder' 	=> '(e.g 50)',
                    'help_text'		=> sprintf(
                        // translators: placeholder: course.
                        esc_html_x( 'This option will add limit the number of people who can take the course. (e.g 50). The number is entered by the %s user.', 'placeholder: course.', 'learndash-course-seats' ),
                        learndash_get_custom_label_lower( 'course' )
                    ),
                );
            }
        }
 
        // Always return $setting_option_fields
        return $setting_option_fields;
	}

	public function save_add_course_setting_fields( $post_id = 0, $post = null, $update = false ) {
		// All the metabox fields are in sections. Here we are grabbing the post data
        // within the settings key array where the added the custom field.
        if ( isset( $_POST['learndash-course-access-settings']['max-number-of-people'] ) ) {
            $max_number_of_people_value = esc_attr( $_POST['learndash-course-access-settings']['max-number-of-people'] );
            // Then update the post meta
            update_post_meta( $post_id, 'max_number_of_people', $max_number_of_people_value );
        }
	}

}
