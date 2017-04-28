<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Product_Age_Condition' ) ) {

	class WPC_Product_Age_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Product age', 'wpc-conditions' );
			$this->slug        = __( 'product_age', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compare against the product age', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {

			if ( ! $this->validate() ) {
				return false;
			}

			$raw_value = $value;
			$value = $this->get_value( $value );
			$compare_value = $this->get_compare_value();

			if ( '==' == $operator ) :
				$match = ( $compare_value == $value );
			elseif ( '!=' == $operator ) :
				$match = ( $compare_value != $value );
			elseif ( '>=' == $operator ) :
				if ( date( 'Y-m-d', strtotime( $raw_value ) ) > 1970 ) {
					$match = ( $compare_value >= $value ); // Reversed operator intentional
				} else {
					$match = ( $compare_value <= $value );
				}
			elseif ( '<=' == $operator ) :
				if ( date( 'Y-m-d', strtotime( $raw_value ) ) > 1970 ) {
					$match = ( $compare_value <= $value );
				} else {
					$match = ( $compare_value >= $value ); // Reversed operator intentional
				}
			endif;

			return $match;

		}

		public function get_value( $value ) {

			if ( date( 'Y-m-d', strtotime( $value ) ) > 1970 ) {
				$value = date( 'Y-m-d', strtotime( $value ) );
			} else {
				$value = date( 'Y-m-d', strtotime( "-$value days", time() ) );
			}

			return $value;

		}

		public function get_compare_value() {
			/** @var $post WP_Post */
			global $post;
			return date( 'Y-m-d', strtotime( $post->post_date ) );
		}

		public function get_value_field_args() {

			$field_args = array(
				'placeholder' => __( 'Product age in days or date', 'woocommerce-advanced-product-labels' ),
			);

			return $field_args;

		}

	}

}