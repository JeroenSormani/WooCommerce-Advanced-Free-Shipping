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
				foreach ( WC()->cart->get_cart() as $product ) :

					if ( true == $product['data']->variation_has_stock ) :
						$stock_status = ( get_post_meta( $product['data']->variation_id, '_stock_status', true ) );
					else :
						$stock_status = ( get_post_meta( $product['product_id'], '_stock_status', true ) );
					endif;

					if ( $stock_status != $value ) :
						$match = false;
					endif;

				endforeach;

			elseif ( '!=' == $operator ) :

				$match = true;
				// $package['contents']
				foreach ( WC()->cart->get_cart() as $product ) :

					if ( true == $product['data']->variation_has_stock ) :
						$stock_status = ( get_post_meta( $product['data']->variation_id, '_stock_status', true ) );
					else :
						$stock_status = ( get_post_meta( $product['product_id'], '_stock_status', true ) );
					endif;

					if ( $stock_status == $value ) :
						$match = false;
					endif;

				endforeach;

			endif;

		}

		public function get_available_operators() {

			$operators = parent::get_available_operators();

			unset( $operators['>='] );
			unset( $operators['<='] );

			return $operators;

		}

	}

}