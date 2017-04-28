<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Length_Condition' ) ) {

	class WPC_Length_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Length', 'wpc-conditions' );
			$this->slug        = __( 'length', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compared to the lengthiest product in cart', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_compare_value() {

			$length = array();
			foreach ( WC()->cart->get_cart() as $item ) :

				/** @var $product WC_Product */
				$product = $item['data'];
				$length[] = $product->get_length();

			endforeach;

			return max( $length );

		}

	}

}