<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Stock_Condition' ) ) {

	class WPC_Stock_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Stock', 'wpc-conditions' );
			$this->slug        = __( 'stock', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compared against the product with the lowest stock amount.', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_compare_value() {

			$stock = array();

			// $package['contents']
			foreach ( WC()->cart->get_cart() as $product ) :

				if ( true == $product['data']->variation_has_stock ) :
					$stock[] = ( get_post_meta( $product['data']->variation_id, '_stock', true ) );
				else :
					$stock[] = ( get_post_meta( $product['product_id'], '_stock', true ) );
				endif;

			endforeach;

			// Get lowest value
			return min( $stock );

		}

	}

}