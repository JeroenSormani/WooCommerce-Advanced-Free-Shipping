<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Country_Condition' ) ) {

	class WPC_Country_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Country', 'wpc-conditions' );
			$this->slug        = __( 'country', 'wpc-conditions' );
			$this->group       = __( 'User', 'wpc-conditions' );
			$this->description = __( 'Compare against the customer country', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {

			$value            = $this->get_value( $value );
			$customer_country = $this->get_compare_value();

			if ( method_exists( WC()->countries, 'get_continent_code_for_country' ) ) :
				$customer_continent = WC()->countries->get_continent_code_for_country( $customer_country );
			endif;

			if ( '==' == $operator ) :
				$match = stripos( $customer_country, $value ) === 0;

				// Check for continents if available
				if ( ! $match && isset( $customer_continent ) && strpos( $value, 'CO_' ) === 0 ) :
					$match = stripos( $customer_continent, str_replace( 'CO_','', $value ) ) === 0;
				endif;
			elseif ( '!=' == $operator ) :
				$match = stripos( $customer_country, $value ) === false;

				// Check for continents if available
				if ( isset( $customer_continent ) && strpos( $value, 'CO_' ) === 0 ) :
					$match = stripos( $customer_continent, str_replace( 'CO_','', $value ) ) === false;
				endif;
			endif;

			return $match;

		}

		public function get_compare_value() {
			return WC()->customer->get_shipping_country();
		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

		// @todo test with <2.5 to see how 'Continents' react
		public function get_value_field_args() {

			$countries  =  WC()->countries->get_allowed_countries() + WC()->countries->get_shipping_countries();
			$continents = array();
			if ( method_exists( WC()->countries, 'get_continents' ) ) :
				foreach ( WC()->countries->get_continents() as $k => $v ) :
					$continents[ 'CO_' . $k ] = $v['name']; // Add prefix for country key compatibility
				endforeach;
			endif;

			$field_args = array(
				'type' => 'select',
				'class' => array( 'wpc-value', 'wc-enhanced-select' ),
				'options' => array(
					__( 'Continents', 'woocommerce' ) => $continents,
					__( 'Countries', 'woocommerce' ) => $countries,
				),
			);

			return $field_args;

		}

	}

}