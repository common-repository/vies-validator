<?php
use PH7\Eu\Vat\Validator;
use PH7\Eu\Vat\Provider\Europa;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wpzen.it
 * @since      1.0.0
 *
 * @package    Vies_Validator
 * @subpackage Vies_Validator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Vies_Validator
 * @subpackage Vies_Validator/public
 * @author     Larin Srls <marek@larin.it>
 */
class Vies_Validator_Public {

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
		 * defined in Vies_Validator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vies_Validator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vies-validator-public.css', array(), $this->version, 'all' );

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
		 * defined in Vies_Validator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vies_Validator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vies-validator-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Add VAT Number field to billing address
	 *
	 * @since    1.0.0
	 */
	public function vies_validator_add_vat_field($fields) {
		$fields[ 'vies_billing_vat' ] = array(
			'label'    => __ ( 'VAT Number', 'vies-validator' ),
			'required' => get_option('vies_validator_vat_field_required'),
			'id' => 'vies_billing_vat',
			'class'    => array( ),
			'clear'    => 1,
			'placeholder' => __('IT99999999999', 'vies-validator')
		);
		return $fields;
	}


	/**
	 * Printing the Billing Address on My Account
	 *
	 * @since    1.0.0
	 */
	public function vies_my_account_my_address_formatted_address( $fields, $customer_id, $type ) {
		if ( $type == 'billing' ) {
			$fields['vat'] = get_user_meta( $customer_id, 'vies_billing_vat', true );
		}
		return $fields;
	}

	/**
	 * Checkout -- Order Received (printed after having completed checkout)
	 *
	 * @since    1.0.0
	 */
	public function vies_add_vat_formatted_billing_address( $fields, $order ) {
		$fields['vat'] = $order->vies_billing_vat;
		return $fields;
	}

	/**
	 * Creating merger VAT variables for printing formatting
	 *
	 * @since    1.0.0
	 */
	public function vies_formatted_address_replacements( $address, $args ) {
		$address['{vat}'] = '';
		$address['{vat_upper}']= '';
		if ( ! empty( $args['vat'] ) ) {
			$address['{vat}'] = $args['vat'];
			$address['{vat_upper}'] = strtoupper($args['vat']);
		}
		return $address;
	}

	/**
	 * Filter to add VAT Customer meta fields (user profile field on the billing address grouping)
	 *
	 * @since    1.0.0
	 */
	public function vies_customer_meta_fields( $fields ) {
		$fields['billing']['fields']['vies_billing_vat'] = array(
			'label'       => __( 'VAT Number', 'vies-validator' )
		);
		return $fields;
	}

	/**
	 * Filter to add VAT to the Edit Form on:  Order --  Admin page
	 *
	 * @since    1.0.0
	 */
	public function vies_admin_billing_fields( $fields ) {
		$fields['vat'] = array(
			'label' => __( 'VAT number', 'vies-validator' ),
			'show'  => true
		);
		return $fields;
	}

	/**
	 * Filter to copy the VAT field from User meta fields to the Order Admin form (after clicking dedicated button on admin page)

	 *
	 * @since    1.0.0
	 */
	public function vies_found_customer_details( $customer_data ) {
		$customer_data['vies_billing_vat'] = get_user_meta( $_POST['user_id'], 'vies_billing_vat', true );
		return $customer_data;
	}

	/**
	 * Validate the VAT Number
	 *
	 * @since    1.0.0
	 */
	public function vies_validator_validate_vat() {
		$enable_vat = get_option($this->option_name . '_add_vat_field');
		if ($enable_vat && $enable_vat == 1) {
			$vat_id = 'vies_billing_vat';
		}
		else {
			$vat_id = get_option($this->option_name . '_vat_id');
		}

		if ($vat_id && !empty(trim($vat_id))) {
			$this->vies_validator_validate_vat_field($vat_id);
		}
	}

	/**
	 * Check a VAT Number via API
	 *
	 * @since    1.0.0
	 */
	protected function vatCheck($vat_number) {
		$country = substr($vat_number, 0, 2);
		try {
			$oVatValidator = new Validator(new Europa, $vat_number, $country);
			return $oVatValidator->check();
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	 * Validates vat number
	 *
	 * @since    1.0.0
	 */
	protected function vies_validator_validate_vat_field($vat_id) {
		 	if(isset($_POST[$vat_id]) && !empty($_POST[$vat_id])) {
		 		$vat_number = $_POST[$vat_id];
		 		if (! $this->vatCheck($vat_number)) {
		 			wc_add_notice(__(get_option('vies_validator_message'), 'vies-validator'), 'error');
		 		}
		 	}
	}

}
