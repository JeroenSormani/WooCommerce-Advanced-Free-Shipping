<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( class_exists( 'Wafs_Free_Shipping_Method' ) ) return; // Stop if the class already exists


class Wafs_Free_Shipping_Method extends WC_Shipping_Method {


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->id                 = 'advanced_free_shipping';
		$this->title              = __( 'Free Shipping (configurable per rate)', 'woocommerce-advanced-free-shipping' );
		$this->method_title       = __( 'Advanced Free Shipping', 'woocommerce-advanced-free-shipping' );
		$this->method_description = __( 'Configure Advanced Free Shipping' );

		$this->init();

	}


	/**
	 * Init.
	 *
	 * Initialize WAFS shipping method.
	 *
	 * @since 1.0.0
	 */
	function init() {

		$this->init_form_fields();
		$this->init_settings();

		$this->enabled       = $this->get_option( 'enabled' );
		$this->hide_shipping = $this->get_option( 'hide_other_shipping' );

		// Save settings in admin if you have any defined
		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );

		// Hide shipping methods
		add_filter( 'woocommerce_package_rates', array( $this, 'hide_all_shipping_when_free_is_available' ) );

	}


	/**
	 * Match methods.
	 *
	 * Checks if methods matches conditions.
	 *
	 * @since 1.0.0
	 *
	 * @return  array  Only the first matched method (since you won't need two free shipping).
	 */
	public function wafs_match_methods() {

		$methods = wafs_get_rates();

		$matched_methods = false;
		foreach ( $methods as $method ) :

			$condition_groups = get_post_meta( $method->ID, '_wafs_shipping_method_conditions', true );

			// Check if conditions match
			if ( wpc_match_conditions( $condition_groups, array( 'context' => 'wafs' ) ) ) :
				$matched_methods = $method->ID;
			endif;

		endforeach;

		return $matched_methods;

	}


	/**
	 * Init fields.
	 *
	 * Add fields to the WAFS shipping settings page.
	 *
	 * @since 1.0.0
	 */
	public function init_form_fields() {

		$this->form_fields = array(
			'enabled'             => array(
				'title'   => __( 'Enable/Disable', 'woocommerce' ),
				'type'    => 'checkbox',
				'label'   => __( 'Enable the Advanced Free Shipping rates', 'woocommerce-advanced-free-shipping' ),
				'default' => 'yes'
			),
			'hide_other_shipping' => array(
				'title'   => __( 'Hide other shipping', 'woocommerce-advanced-free-shipping' ),
				'type'    => 'checkbox',
				'label'   => __( 'Hide other shipping methods when free shipping is available', 'woocommerce-advanced-free-shipping' ),
				'default' => 'no'
			),
			'conditions'          => array(
				'type' => 'conditions_table',
			)
		);

	}


	/**
	 * Settings tab table.
	 *
	 * Load and render the table on the Advanced Free Shipping settings tab.
	 *
	 * @since 1.0.0
	 *
	 * @return  string
	 */
	public function generate_conditions_table_html() {

		ob_start();
			require_once plugin_dir_path( __FILE__ ) . 'admin/views/conditions-table.php';
		return ob_get_clean();

	}


	/**
	 * Calculate shipping.
	 *
	 * Calculate shipping costs (which is always free).
	 *
	 * @since 1.0.0
	 *
	 * @param  mixed  $package
	 */
	public function calculate_shipping( $package = array() ) {

		if ( $this->enabled == 'no' ) {
			return;
		}

		if ( ! $matched_rate = $this->wafs_match_methods() ) {
			return;
		}

		$method_args = get_post_meta( $matched_rate, '_wafs_shipping_method', true );
		$label       = ! empty( $method_args['shipping_title'] ) ? $method_args['shipping_title'] : __( 'Free Shipping', 'woocommerce-advanced-free-shipping' );

		$rate = array(
			'id'    => $this->id,
			'label' => $label,
			'cost'  => '0',
		);

		// Register the rate
		$this->add_rate( $rate );

	}


	/**
	 * Hide shipping.
	 *
	 * Hide Shipping methods when regular or advanced free shipping is available.
	 *
	 * @since 1.0.0
	 *
	 * @param   array  $available_methods
	 * @return  array
	 */
	public function hide_all_shipping_when_free_is_available( $available_methods ) {

		if ( 'no' == $this->hide_shipping ) return $available_methods;

		if ( isset( $available_methods['advanced_free_shipping'] ) ) :

			return array( 'advanced_free_shipping' => $available_methods['advanced_free_shipping'] );

		elseif ( isset( $available_methods['free_shipping'] ) ) :

			return array( 'free_shipping' => $available_methods['free_shipping'] );

		else :

			return $available_methods;

		endif;

	}


}
