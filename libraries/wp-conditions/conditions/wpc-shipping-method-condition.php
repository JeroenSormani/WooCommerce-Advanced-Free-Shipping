<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Shipping_Method_Condition' ) ) {

	class WPC_Shipping_Method_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Shipping method', 'wpc-conditions' );
			$this->slug        = __( 'shipping_method', 'wpc-conditions' );
			$this->group       = __( 'Cart', 'wpc-conditions' );
			$this->description = __( 'Match against the chosen shipping method', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {

			$value                   = $this->get_value( $value );
			$chosen_shipping_methods = $this->get_compare_value();

			if ( '==' == $operator ) :
				$match = ( in_array( $value, $chosen_shipping_methods ) );
			elseif ( '!=' == $operator ) :
				$match = ( ! in_array( $value, $chosen_shipping_methods ) );
			endif;

			return $match;

		}

		public function get_compare_value() {
			return (array) WC()->session->get( 'chosen_shipping_methods' );
		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

		public function get_value_field_args() {

			$field_args = array(
				'type'    => 'select',
				'options' => $this->get_shipping_options(),
			);

			return $field_args;

		}

		private function get_shipping_options() {

			$shipping_options = array();
			foreach ( WC()->shipping()->load_shipping_methods() as $method ) :
				$shipping_options['Methods'][ $method->id ] = $method->get_method_title();
			endforeach;

			// Advanced Shipping
			$shipping_options = array_merge( $shipping_options, $this->get_advanced_shipping_rates() );

			// WC Zones
			$shipping_options = array_merge( $shipping_options, $this->get_zone_instances() );

			return $shipping_options;

		}


		/**
		 * Get Advanced Shipping rates.
		 *
		 * Get the rates from the Advanced Shipping plugin (if available).
		 *
		 * @link https://codecanyon.net/item/woocommerce-advanced-shipping/8634573
		 *
		 * @return array List of shipping rates.
		 */
		private function get_advanced_shipping_rates() {

			$rates = array();

			$was_rates = new WP_Query( array( 'fields' => 'ids', 'post_type' => 'was', 'post_status' => 'any', 'posts_per_page' => 1000, 'update_post_term_cache' => false, 'no_found_rows' => true ) );
			$was_rates = $was_rates->get_posts();
			foreach ( $was_rates as $was_id ) :
				$shipping_method                       = get_post_meta( $was_id, '_was_shipping_method', true );
				$rates['Advanced Shipping'][ $was_id ] = isset( $shipping_method['shipping_title'] ) ? $shipping_method['shipping_title'] : 'WooCommerce Advanced Shipping rate ID ' . $was_id;
			endforeach;

			return $rates;

		}


		/**
		 * Get zone instances.
		 *
		 * Get the rates that are within a shipping zone.
		 *
		 * @return array List of shipping rates.
		 */
		private function get_zone_instances() {

			$rates = array();

			if ( ! class_exists( 'WC_Shipping_Zones' ) ) {
				return $rates;
			}

			foreach ( WC_Shipping_Zones::get_zones() as $zone ) {
				foreach ( $zone['shipping_methods'] as $instance_id => $rate ) {
					$rates[ $zone['zone_name'] ][ $rate->get_rate_id() ] = $rate->get_title();
				}
			}

			// 'Rest of the world' zone
			$row_zone = WC_Shipping_Zones::get_zone( 0 );
			foreach ( $row_zone->get_shipping_methods() as $instance_id => $rate ) {
				$rates[ $row_zone->get_zone_name() ][ $rate->get_rate_id() ] = $rate->get_title();
			}

			return $rates;

		}

	}

}