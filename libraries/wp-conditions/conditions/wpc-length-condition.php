<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Length_Condition' ) ) {

	class WPC_Length_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Length', 'wpc-conditions' );
			$this->slug        = __( 'length', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compared to lengthiest product in cart', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_compare_value() {

			$length = array();
			foreach ( WC()->cart->get_cart() as $product ) :

				if ( true == $product['data']->variation_has_length ) :
					$length[] = ( get_post_meta( $product['data']->variation_id, '_length', true ) );
				else :
					$length[] = ( get_post_meta( $product['product_id'], '_length', true ) );
				endif;

			endforeach;

			return max( $length );

		}

	}

}