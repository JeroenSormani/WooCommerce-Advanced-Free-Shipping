<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPC_Height_Condition' ) ) {

	class WPC_Height_Condition extends WPC_Condition {

		public function __construct() {
			$this->name        = __( 'Height', 'wpc-conditions' );
			$this->slug        = __( 'height', 'wpc-conditions' );
			$this->group       = __( 'Product', 'wpc-conditions' );
			$this->description = __( 'Compared to the highest product in cart', 'wpc-conditions' );

			parent::__construct();
		}

		public function get_compare_value() {

			$height = array();
			foreach ( WC()->cart->get_cart() as $item ) :

				/** @var $product WC_Product */
				$product = $item['data'];
				$height[] = $product->get_height();

			endforeach;

			return max( $height );

		}

	}

}