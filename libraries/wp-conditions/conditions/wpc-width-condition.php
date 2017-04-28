<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Width_Condition' ) ) {

	class WPC_Width_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Width', 'wpc-conditions' );
			$this->slug        = __( 'width', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compared to the widest product in cart', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_compare_value() {

			$width = array();
			foreach ( WC()->cart->get_cart() as $item ) :

				/** @var $product WC_Product */
				$product = $item['data'];
				$width[] = $product->get_width();

			endforeach;

			return max( $width );

		}

	}

}