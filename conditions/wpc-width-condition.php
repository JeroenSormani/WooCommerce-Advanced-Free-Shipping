<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Width_Condition' ) ) {

	class WPC_Width_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Width', 'wpc-conditions' );
			$this->slug        = __( 'width', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compared to widest product in cart', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_compare_value() {

			$width = array();
			foreach ( WC()->cart->get_cart() as $product ) :

				if ( true == $product['data']->variation_has_width ) :
					$width[] = ( get_post_meta( $product['data']->variation_id, '_width', true ) );
				else :
					$width[] = ( get_post_meta( $product['product_id'], '_width', true ) );
				endif;

			endforeach;

			return max( $width );

		}

	}

}