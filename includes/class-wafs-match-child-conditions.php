<?php
/**
 *	Class Wafs_Match_Conditions
 *
 *	The WAFS Match Conditions class handles the matching rules for Free Shipping
 *
 *	@class      Wapl_Conditions
 *	@author     Jeroen Sormani
 *	@package 	WooCommerce Advanced Product Labels
 *	@version    1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Wafs_Match_Child_Conditions {


	/**
	 * __construct functon.
	 */
	public function __construct() {
		
		global $woocommerce;
	
		add_action( 'wafs_match_child_condition_quantity', array( $this, 'wafs_match_child_condition_quantity' ), 10, 5 );
		add_action( 'wafs_match_child_condition_variation', array( $this, 'wafs_match_child_condition_variation' ), 10, 6 );
		add_action( 'wafs_match_child_condition_weight', array( $this, 'wafs_match_child_condition_weight' ), 10, 5 );
		add_action( 'wafs_match_child_condition_stock', array( $this, 'wafs_match_child_condition_stock' ), 10, 5 );
		add_action( 'wafs_match_child_condition_stock_status', array( $this, 'wafs_match_child_condition_stock_status' ), 10, 5 );

	}


	/* Match quantity.
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_child_condition_quantity( $match, $operator, $value, $parent_condition, $product = array() ) {

		$match = false;

		if ( '==' == $operator ) :
			if ( $product['quantity'] == $value ) :
				$match = true;
			endif;
		elseif ( '!=' == $operator ) :
			if ( $product['quantity'] != $value ) :
				$match = true;
			endif;
		elseif ( '>=' == $operator ) :
			if ( $product['quantity'] >= $value ) :
				$match = true;
			endif;
		elseif ( '<=' == $operator ) :
			if ( $product['quantity'] <= $value ) :
				$match = true;
			endif;
		endif;

		return $match;
		
	}


	/* Match variation.
	 * 
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_child_condition_variation( $match, $operator, $value, $parent_condition, $product = array(), $parent_conditions ) {

		global $woocommerce;

		if ( 'contains_product' == $parent_condition['condition'] ) :
			
				$match = false;
				
				if ( '==' == $operator ) :
					if ( $product['variation_id'] == $value ) :
						$match = true;
					endif;
				elseif ( '!=' == $operator ) :
					if ( $product['variation_id'] != $value ) :
						$match = true;
					endif;
				endif;


		elseif ( 'only_contains' == $parent_condition['condition'] ) :
			
			
				$match = true; // Match until proven false.
				$allowed_variations = array();
				
				// Get allowed variation ID's
				foreach ( $parent_conditions as $id => $condition ) :
					if ( 'only_contains' == $condition['condition'] && isset( $condition['child_conditions'] ) ) :
					
						foreach ( $condition['child_conditions'] as $child_condition ) :
							if ( 'variation' == $child_condition['condition'] && '==' == $child_condition['operator'] ) :
								$allowed_variations[] = $child_condition['value'];
							endif;
	
						endforeach;
						
					endif;
				endforeach;
	
	
				// Get all variation ids of the product we're checking right now.
				foreach ( $woocommerce->cart->cart_contents as $id => $product ) :
					if ( $parent_condition['value'] == $product['product_id'] ) :
						$variation_ids[] = $product['variation_id'];
					endif;
				endforeach;
	
				if ( '==' == $operator ) :
					if ( count( array_diff( $variation_ids, $allowed_variations ) ) > 0 || ! in_array( $value, $variation_ids ) ) : // Must contain && can't contain any other.
						$match = false;
					endif;
				elseif ( '!=' == $operator ) :
					if ( in_array( $value, $variation_ids ) ) :
						$match = false;
					endif;
				endif;

			
		endif;

		return $match;
		
	}
	
	
	/* Match variation
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_child_condition_weight( $match, $operator, $value, $parent_condition, $product = array() ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;

		$weight = 0;
		foreach ( $woocommerce->cart->cart_contents as $id => $product ) :

			if ( $parent_condition['value'] != $product['product_id'] ) :
				continue;
			endif;
			
			if ( isset( $product['data']->weight ) ) :
				$weight += $product['data']->weight * $product['quantity'];
			endif;
			
		endforeach;

		if ( '==' == $operator ) :
			$match = ( $weight == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $weight != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $weight >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $weight <= $value );
		endif;

			
		return $match;
		
	}


	/* Match all product stock
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_child_condition_stock( $match, $operator, $value, $parent_condition, $product = array() ) {

		if ( true == $product['data']->variation_has_stock ) : 
			$stock[] = ( get_post_meta( $product['data']->variation_id, '_stock', true ) );
		else :
			$stock[] = ( get_post_meta( $product['product_id'], '_stock', true ) );
		endif;

		$min_stock = min( $stock );

		if ( '==' == $operator ) :
			$match = ( $min_stock == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $min_stock != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $min_stock >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $min_stock <= $value );
		endif;
			
		return $match;
		
	}


		
}
new Wafs_Match_Child_Conditions();

?>