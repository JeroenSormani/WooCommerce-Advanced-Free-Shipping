<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Volume_Condition' ) ) {

	class WPC_Volume_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Volume', 'wpc-conditions' );
			$this->slug        = __( 'volume', 'wpc-conditions' );
			$this->group       = __( 'Cart', 'wpc-conditions' );
			$this->description = __( 'Volume calculated on all the cart contents', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_value( $value ) {
			return str_replace( ',', '.', $value );
		}

		public function get_compare_value() {
			$volume = 0;

			// Get all product stocks
			foreach ( WC()->cart->cart_contents as $item ) :

				$product = wc_get_product( $item['data']->get_id() );
				$volume += (float) ( $product->get_width() * $product->get_height() * $product->get_length() ) * $item['quantity'];

			endforeach;

			return $volume;
		}

	}

}
