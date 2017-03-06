<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Height_Condition' ) ) {

	class WPC_Height_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Height', 'wpc-conditions' );
			$this->slug        = __( 'height', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compared to highest product in cart', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_compare_value() {

			$height = array();
			foreach ( WC()->cart->get_cart() as $product ) :

				if ( true == $product['data']->variation_has_height ) :
					$height[] = ( get_post_meta( $product['data']->variation_id, '_height', true ) );
				else :
					$height[] = ( get_post_meta( $product['product_id'], '_height', true ) );
				endif;

			endforeach;

			return max( $height );

		}

	}

}