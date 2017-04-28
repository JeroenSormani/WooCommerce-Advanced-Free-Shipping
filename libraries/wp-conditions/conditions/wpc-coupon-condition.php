<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Coupon_Condition' ) ) {

	class WPC_Coupon_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Coupon', 'wpc-conditions' );
			$this->slug        = __( 'coupon', 'wpc-conditions' );
			$this->group       = __( 'Cart', 'wpc-conditions' );
			$this->description = __( 'Matched against the applied coupon codes or coupon amounts (use \'%\' or \'$\' for the respective amounts', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {

			$value   = $this->get_value( $value );
			$coupons = $this->get_compare_value();

			// Match against coupon percentage
			if ( strpos( $value, '%' ) !== false ) {
				$percentage_value = str_replace( '%', '', $value );
				if ( '==' == $operator ) :
					$match = in_array( $percentage_value, $coupons['percent'] );
				elseif ( '!=' == $operator ) :
					$match = ! in_array( $percentage_value, $coupons['percent'] );
				elseif ( '>=' == $operator ) :
					$match = empty( $coupons['percent'] ) ? $match : ( min( $coupons['percent'] ) >= $percentage_value );
				elseif ( '<=' == $operator ) :
					$match = ! is_array( $coupons['percent'] ) ? false : ( max( $coupons['percent'] ) <= $percentage_value );
				endif;

			// Match against coupon amount
			} elseif( strpos( $value, '$' ) !== false ) {
				$amount_value = str_replace( '$', '', $value );
				if ( '==' == $operator ) :
					$match = in_array( $amount_value, $coupons['fixed'] );
				elseif ( '!=' == $operator ) :
					$match = ! in_array( $amount_value, $coupons['fixed'] );
				elseif ( '>=' == $operator ) :
					$match = empty( $coupons['fixed'] ) ? $match : ( min( $coupons['fixed'] ) >= $amount_value );
				elseif ( '<=' == $operator ) :
					$match = ! is_array( $coupons['fixed'] ) ? $match : ( max( $coupons['fixed'] ) <= $amount_value );
				endif;

			// Match coupon codes
			} else {
				if ( '==' == $operator ) :
					$match = ( array_intersect( preg_split( '/\, ?/', $value ), WC()->cart->get_applied_coupons() ) );
				elseif ( '!=' == $operator ) :
					$match = ( ! array_intersect( preg_split( '/\, ?/', $value ), WC()->cart->get_applied_coupons() ) );
				endif;
			}

			return $match;

		}

		public function get_compare_value() {

			$coupons = array( 'percent' => array(), 'fixed' => array() );
			foreach ( WC()->cart->get_coupons() as $coupon ) {
				/** @var $coupon WC_Coupon */
				if ( version_compare( WC()->version, '2.7', '>=' ) ) {
					$type               = str_replace( '_product', '', $coupon->get_discount_type() );
					$type               = str_replace( '_cart', '', $type );
					$coupons[ $type ][] = $coupon->get_amount();
				} else {
					$type               = str_replace( '_product', '', $coupon->discount_type );
					$type               = str_replace( '_cart', '', $type );
					$coupons[ $type ][] = $coupon->coupon_amount;
				}
			}

			return $coupons;

		}

	}

}