<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Wafs_Free_Shipping_Method' ) ) {


	class Wafs_Free_Shipping_Method extends WC_Shipping_Method {
	
	
		/**
		 * Constructor for your shipping class
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {

			$this->id                	= 'advanced_free_shipping';
			$this->title  				= __( 'Free Shipping <small>(may change at user configuration)</small>', 'woocommerce-advanced-free-shipping' );
			$this->method_title  		= __( 'Advanced Free Shipping', 'woocommerce-advanced-free-shipping' );
			$this->method_description 	= __( 'Configure WooCommerce Advanced Free Shipping', 'woocommerce-advanced-free-shipping' ); // 

			$this->matched_methods	 	= $this->wafs_match_methods();
			
			$this->init();
		
		}


		/**
		 * Init your settings
		 *
		 * @access public
		 * @return void
		 */
		function init() {
		
			$this->init_form_fields();
			$this->init_settings();

			$this->enabled 			= $this->get_option( 'enabled' );
			$this->hide_shipping 	= $this->get_option( 'hide_other_shipping_when_available' );
						
			// Save settings in admin if you have any defined
			add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
			
			// Hide shipping methods
			global $woocommerce;
			if ( version_compare( $woocommerce->version, '2.1', '<' ) ) :
				add_filter( 'woocommerce_available_shipping_methods', array( $this, 'hide_all_shipping_when_free_is_available' ) );
			else :
				add_filter( 'woocommerce_package_rates', array( $this, 'hide_all_shipping_when_free_is_available' ) );
			endif;
			
		}
		
	
		/**
		 * Match methods
		 *
		 * Checks if methods matches conditions
		 *
		 * @access public
		 * @return Array
		 */
		public function wafs_match_methods() {

			$matched_methods = '';
			$methods = get_posts( array( 'posts_per_page' => '-1', 'post_type' => 'wafs' ) );
			
			foreach ( $methods as $method ) :

				$condition_groups = get_post_meta( $method->ID, '_wafs_shipping_method_conditions', true );

				// Check if method conditions match
				$match = $this->wafs_match_conditions( $condition_groups );
				
				// Add (single) match to parameter
				if ( true == $match ) :
					$matched_methods = $method->ID;
				endif;
				
			endforeach;
			
			return $matched_methods;
			
		}
		
		
		/**
		 * Match conditions
		 *
		 * @access public
		 * @return BOOL
		 */
		public function wafs_match_conditions( $condition_groups = array() ) {

			if ( empty( $condition_groups ) ) return false;

			// All condition groups
			foreach ( $condition_groups as $condition_group => $conditions ) :

				$match_condition_group = true;

				// Single conditions
				foreach ( $conditions as $id => $condition ) :

					$match = apply_filters( 'wafs_match_condition_' . $condition['condition'], false, $condition['operator'], $condition['value'], $conditions );		

					// Child conditions
					if ( isset( $condition['child_conditions'] ) && true == $match ) : // Only if parent condition is true
						$match = $this->wafs_match_child_conditions( $condition, $conditions );
					endif;

					if ( false == $match ) :
						$match_condition_group = false;
					endif;
					
				endforeach;

				// return true if one condition group matches
				if ( true == $match_condition_group ) :
					return true;
				endif;
				
			endforeach;
			
			return false;
			
		}
		

		/**
		 * Match child conditions
		 *
		 * @access public
		 * @return BOOL
		 */
		public function wafs_match_child_conditions( $parent_condition, $parent_conditions ) {

			global $woocommerce;

			if ( ! isset( $woocommerce->cart ) || ! is_array( $woocommerce->cart->cart_contents ) ) :
				return;
			endif;
			
			foreach ( $woocommerce->cart->cart_contents as $id => $product ) :
			
				$child_match = true;			
				$child_match_conditions = true;
				foreach ( $parent_condition['child_conditions'] as $condition ) :
					
					if ( ! isset( $condition['condition'] ) || ! isset( $condition['operator'] ) || ! isset( $condition['value'] ) ) :
						return false;
					endif;
					
					$child_match_conditions = apply_filters( 'wafs_match_child_condition_' . $condition['condition'], false, 
						$condition['operator'], $condition['value'], $parent_condition, $product, $parent_conditions );

					if ( false == $child_match_conditions ) :
						$child_match = false;
					endif;

				endforeach;

				if ( true == $child_match ) :
					return true;
				endif;
				
			endforeach;
			
			return $child_match;
			
		}


		/**
		 * Init form fields
		 *
		 * @access public
		 * @return void
		 */
		public function init_form_fields() {
		
			$this->form_fields = array(
				'enabled' => array(
					'title' 		=> __( 'Enable/Disable', 'woocommerce' ),
					'type' 			=> 'checkbox',
					'label' 		=> __( 'Enable Advanced Free Shipping', 'woocommerce-advanced-free-shipping' ),
					'default' 		=> 'yes'
				),
				'hide_other_shipping_when_available' => array(
					'title' 		=> __( 'Hide other shipping', 'woocommerce-advanced-free-shipping' ),
					'type' 			=> 'checkbox',
					'label' 		=> __( 'Hide other shipping methods when free shipping is available', 'woocommerce-advanced-free-shipping' ),
					'default' 		=> 'no'
				),
				'conditions' => array(
					'type' 			=> 'conditions_table',
				)
			);
			
			
		}
		
		/* Settings tab table.
		 *
		 * Load and render the table on the Advanced Free Shipping settings tab.
		 *
		 * @return string
		 */
		public function generate_conditions_table_html() {
			
			ob_start();
			
				/**
				 * Load conditions table file
				 */
				require_once plugin_dir_path( __FILE__ ) . 'admin/views/conditions-table.php';
			
			return ob_get_clean();
			
		}
		
		
		/**
		 * validate_additional_conditions_table_field function.
		 *
		 * @access public
		 * @param mixed $key
		 * @return bool
		 */
		public function validate_additional_conditions_table_field( $key ) {
			return false;
		}



		/**
		 * calculate_shipping function.
		 *
		 * @access public
		 * @param mixed $package
		 * @return void
		 */
		public function calculate_shipping( $package ) {

			if ( false == $this->matched_methods || 'no' == $this->enabled ) return;
			
			$match_details 	= get_post_meta( $this->matched_methods, '_wafs_shipping_method', true );
			$label 			= @$match_details['shipping_title'];
			$calc_tax 		= @$match_details['calc_tax'];
			
			$rate = array(
				'id'       => $this->id,
				'label'    => ( null == $label ) ? __( 'Free Shipping', 'woocommerce-advanced-free-shipping' ) : $label,
				'cost'     => '0',
				'calc_tax' => ( null == $calc_tax ) ? 'per_order' : $calc_tax
			);
			
			// Register the rate
			$this->add_rate( $rate );

			
		}
		
		
		/**
		 * Hide shipping.
		 *
		 * Hide Shipping methods when regular or advanced free shipping is available
		 *
		 * @param array $available_methods
		 * @return array
		 */
		public function hide_all_shipping_when_free_is_available( $available_methods ) {

			if ( 'no' == $this->hide_shipping ) return $available_methods;
			
		 	if ( isset( $available_methods['advanced_free_shipping'] ) ) :
		 	
				return array( $available_methods['advanced_free_shipping'] );
		 	
		 	elseif ( isset( $available_methods['free_shipping'] ) ) :

		 		return array( $available_methods['free_shipping'] );
		 		
		 	else :
		 	
		 		return $available_methods;
		 		
		 	endif;
		 	
		  	
		}
		
		
	}
	$wafs_free_shipping_method = new Wafs_Free_Shipping_Method();
	
}



?>