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
			foreach ( WC()->cart->get_cart() as $item ) :

				/** @var $product WC_Product */
				$product = $item['data'];
				$stock[] = $product->get_stock_quantity();

			endforeach;

			// Get lowest value
			return empty( $stock ) ? null : min( $stock );

		}

	}

}