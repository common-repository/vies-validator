<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpzen.it
 * @since      1.0.0
 *
 * @package    Vies_Validator
 * @subpackage Vies_Validator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vies_Validator
 * @subpackage Vies_Validator/admin
 * @author     Larin Srls <marek@larin.it>
 */
class Vies_Validator_Admin {

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
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'vies_validator';

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
		 * defined in Vies_Validator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vies_Validator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vies-validator-admin.css', array(), $this->version, 'all' );

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
		 * defined in Vies_Validator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vies_Validator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vies-validator-admin.js', array( 'jquery' ), $this->version, false );

	}



	/**
	 * Add options page
	 *
	 * @since    1.0.0
	 */
	public function add_options_page() {
		$this->plugin_screen_hook_suffix = add_options_page(
			__('Vies Validator Settings', 'vies-validator'),
			__('Vies Validator', 'vies-validator'),
			'manage_options',
			$this->plugin_name,
			array($this, 'display_options_page')
		);
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/vies-validator-admin-display.php';
	}

	/**
	 * Add options page
	 *
	 * @since    1.0.0
	 */
	 public function register_settings() {
	 	// ----------------
	 	// GENERAL SETTINGS
	 	// ----------------
	 	add_settings_section(
 			$this->option_name . '_general',
 			__( 'General', 'vies-validator' ),
 			array( $this, $this->option_name . '_general_cb' ),
 			$this->plugin_name
 		);

	 	add_settings_field(
	 		$this->option_name . '_add_vat_field',
	 		__('Add VAT Number field to checkout', 'vies-validator'),
	 		array($this, $this->option_name . '_add_vat_field_cb'),
	 		$this->plugin_name,
	 		$this->option_name . '_general',
	 		array('label_for' => $this->option_name . '_add_vat_field')
	 	);

	 	add_settings_field(
	 		$this->option_name . '_vat_field_required',
	 		__('VAT Number is required?', 'vies-validator'),
	 		array($this, $this->option_name . '_vat_field_required_cb'),
	 		$this->plugin_name,
	 		$this->option_name . '_general',
	 		array('label_for' => $this->option_name . '_vat_field_required')
	 	);

	 	add_settings_field(
	 		$this->option_name . '_message',
	 		__('Error message', 'vies-validator'),
	 		array($this, $this->option_name .'_message_cb'),
	 		$this->plugin_name,
	 		$this->option_name . '_general'
	 	);

 		add_settings_field(
 			$this->option_name . '_vat_id',
 			__('VAT field ID', 'vies-validator'),
 			array( $this, $this->option_name . '_vat_id_cb' ),
 			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_vat_id' )
 		);

 		register_setting(
 			$this->plugin_name,
 			$this->option_name . '_vat_id'
 		);

 		register_setting(
 			$this->plugin_name,
 			$this->option_name . '_add_vat_field'
 		);

 		register_setting(
 			$this->plugin_name,
 			$this->option_name . '_vat_field_required'
 		);

 		register_setting(
 			$this->plugin_name,
 			$this->option_name . '_message'
 		);
	 }

	 /**
 	 * Render the text for the general section
 	 *
 	 * @since  1.0.0
 	 */
 	 public function vies_validator_general_cb() {

 	 }

 	/**
 	* Render the add vat field input
 	*
 	* @since  1.0.0
 	*/
 	public function vies_validator_add_vat_field_cb() {
 	 $current_value = get_option($this->option_name . '_add_vat_field');
    $html = '<input type="checkbox" class="vies-field" id="vies_validator_add_vat_field" name="vies_validator_add_vat_field" value="1" ' . checked(1, $current_value, false) . '/>';
    $html .= '<label for="vies_validator_add_vat_field"> '  . __('Enable', 'vies-validator') . '</label>';
    echo $html;
 	}

 	 	/**
 		* Render the vat field required input
 		*
 		* @since  1.0.0
 		*/
 		public function vies_validator_vat_field_required_cb() {
 		 $current_value = get_option($this->option_name . '_vat_field_required');
 	   $html = '<input type="checkbox" class="vies-field" id="vies_validator_vat_field_required" name="vies_validator_vat_field_required" value="1" ' . checked(1, $current_value, false) . '/>';
 	   $html .= '<label for="vies_validator_vat_field_required"> '  . __('Enable', 'vies-validator') . '</label>';
 	   echo $html;
 		}

 	 /**
 	 * Render the vat id input for this plugin
 	 *
 	 * @since  1.0.0
 	 */
 	public function vies_validator_vat_id_cb() {
 		$current_value = get_option($this->option_name . '_vat_id');
 		$option_description = "If you already have a VAT Number field in your checkout, provided by the theme or another plugin, insert its ID to validate it.";

 		echo '<input class="vies-field vies-text-field" value="'.$current_value.'" type="text" name="' . $this->option_name . '_vat_id' . '" id="' . $this->option_name . '_vat_id' . '">';
 		echo '<span class="description">'.__($option_description, 'vies-validator').'</span>';
 	}

 	 /**
 	 * Render the vat error message field
 	 *
 	 * @since  1.0.0
 	 */
 	public function vies_validator_message_cb() {
 		$current_value = get_option($this->option_name . '_message');
 		if (empty($current_value)) {
 			$current_value = "Invalid VAT Number";
 		}
 		$option_description = "Error message to show if VAT Number is invalid.";

 		echo '<input class="vies-field vies-text-field" value="'.$current_value.'" type="text" name="' . $this->option_name . '_message' . '" id="' . $this->option_name . '_message' . '">';
 		echo '<span class="description">'.__($option_description, 'vies-validator').'</span>';
 	}

}
