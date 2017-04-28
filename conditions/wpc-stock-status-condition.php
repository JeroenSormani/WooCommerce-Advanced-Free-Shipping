<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Stock_Status_Condition' ) ) {

	class WPC_Stock_Status_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Stock status', 'wpc-conditions' );
			$this->slug        = __( 'stock_status', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'All products in cart must match stock status', 'wpc-conditions' );

			parent::__construct();
		}

		public function match( $match, $operator, $value ) {

			$value = $this->get_value( $value );

			if ( '==' == $operator ) :

				$match = true;
				// $package['contents']
				foreach ( WC()->cart->get_cart() as $item ) :

					/** @var $product WC_Product */
					$product = $item['data'];

					if ( method_exists( $product, 'get_stock_status' ) ) { // WC 2.7 compatibility
						$stock_status = $product->get_stock_status();
					} else { // Pre 2.7
						$stock_status = $product->stock_status;
					}

					if ( $stock_status != $value ) :
						return false;
					endif;

				endforeach;

			elseif ( '!=' == $operator ) :

				$match = true;
				// $package['contents']
				foreach ( WC()->cart->get_cart() as $item ) :

					/** @var $product WC_Product */
					$product = $item['data'];

					if ( method_exists( $product, 'get_stock_status' ) ) { // WC 2.7 compatibility
						$stock_status = $product->get_stock_status();
					} else { // Pre 2.7
						$stock_status = $product->stock_status;
					}

					if ( $stock_status == $value ) :
						return false;
					endif;

				endforeach;

			endif;

			return $match;

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
				'options' => array(
					'1' => __( 'In stock', 'woocommerce' ),
					'0' => __( 'Out of stock', 'woocommerce' ),
				),
			);

			return $field_args;

		}

	}

}
