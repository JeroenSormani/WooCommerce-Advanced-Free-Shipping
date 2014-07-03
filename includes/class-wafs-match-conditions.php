<?php
/**
 *	Class Wafs_Match_Conditions
 *
 *	The WAFS Match Conditions class handles the matching rules for Free Shipping
 *
 *	@class      Wapl_Conditions
 *	@author     Jeroen Sormani
 *	@package 	WooCommerce Advanced Product Labels
 *	@version    1.0.0
 */
class Wafs_Match_Conditions {


	/**
	 * __construct functon.
	 */
	public function __construct() {
		
		global $woocommerce;
	
		add_action( 'wafs_match_condition_subtotal', array( $this, 'wafs_match_condition_subtotal' ), 10, 3 );
		add_action( 'wafs_match_condition_subtotal_ex_tax', array( $this, 'wafs_match_condition_subtotal_ex_tax' ), 10, 3 );
		add_action( 'wafs_match_condition_tax', array( $this, 'wafs_match_condition_tax' ), 10, 3 );
		add_action( 'wafs_match_condition_quantity', array( $this, 'wafs_match_condition_quantity' ), 10, 3 );
		add_action( 'wafs_match_condition_contains_product', array( $this, 'wafs_match_condition_contains_product' ), 10, 3 );
		add_action( 'wafs_match_condition_coupon', array( $this, 'wafs_match_condition_coupon' ), 10, 3 );
		
		add_action( 'wafs_match_condition_zipcode', array( $this, 'wafs_match_condition_zipcode' ), 10, 3 );
		add_action( 'wafs_match_condition_city', array( $this, 'wafs_match_condition_city' ), 10, 3 );
		add_action( 'wafs_match_condition_state', array( $this, 'wafs_match_condition_state' ), 10, 3 );
		add_action( 'wafs_match_condition_country', array( $this, 'wafs_match_condition_country' ), 10, 3 );
		add_action( 'wafs_match_condition_role', array( $this, 'wafs_match_condition_role' ), 10, 3 );
		
		add_action( 'wafs_match_condition_width', array( $this, 'wafs_match_condition_width' ), 10, 3 );
		add_action( 'wafs_match_condition_height', array( $this, 'wafs_match_condition_height' ), 10, 3 );
		add_action( 'wafs_match_condition_length', array( $this, 'wafs_match_condition_length' ), 10, 3 );
		add_action( 'wafs_match_condition_weight', array( $this, 'wafs_match_condition_weight' ), 10, 3 );
		add_action( 'wafs_match_condition_stock', array( $this, 'wafs_match_condition_stock' ), 10, 3 );
		add_action( 'wafs_match_condition_stock_status', array( $this, 'wafs_match_condition_stock_status' ), 10, 3 );
		add_action( 'wafs_match_condition_category', array( $this, 'wafs_match_condition_category' ), 10, 3 );
		
	}


	/* Match subtotal
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_subtotal( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;
		
		if ( '==' == $operator ) :
			$match = ( $woocommerce->cart->subtotal == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $woocommerce->cart->subtotal != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $woocommerce->cart->subtotal >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $woocommerce->cart->subtotal <= $value );
		endif;
			
		return $match;
		
	}


	/* Match subtotal excluding taxes
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_subtotal_ex_tax( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( ! isset( $woocommerce->cart ) ) return;

		if ( '==' == $operator ) :
			$match = ( $woocommerce->cart->subtotal_ex_tax == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $woocommerce->cart->subtotal_ex_tax != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $woocommerce->cart->subtotal_ex_tax >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $woocommerce->cart->subtotal_ex_tax <= $value );
		endif;
			
		return $match;
		
	}
	

	/* Match taxes
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_tax( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( ! isset( $woocommerce->cart ) ) return;

		$taxes = array_sum( (array) $woocommerce->cart->taxes );

		if ( '==' == $operator ) :
			$match = ( $taxes == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $taxes != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $taxes >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $taxes <= $value );
		endif;
			
		return $match;
		
	}
	

	/* Match quantity
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_quantity( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( ! isset( $woocommerce->cart ) ) return;
		
		if ( '==' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_count == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_count != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_count >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_count <= $value );
		endif;
			
		return $match;
		
	}
	

	/* Match quantity
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_contains_product( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( ! isset( $woocommerce->cart ) || empty( $woocommerce->cart->cart_contents ) ) return;
		
		foreach ( $woocommerce->cart->cart_contents as $product ) :
			$product_ids[] = $product['product_id'];
		endforeach;
		
		if ( '==' == $operator ) :
			$match = ( in_array( $value, $product_ids ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! in_array( $value, $product_ids ) );
		endif;
			
		return $match;
		
	}
		

	/* Match coupon
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_coupon( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( ! isset( $woocommerce->cart ) ) return;
		
		if ( '==' == $operator ) :
			$match = ( in_array( $value, $woocommerce->cart->applied_coupons ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! in_array( $value, $woocommerce->cart->applied_coupons ) );
		endif;
			
		return $match;
		
	}

	
/***************************
 *	
 *				User details
 *
 ***************************
*/


	/* Match zipcode
	 *
	 * @since 1.0.2; $value may contain single or comma (,) separated zipcodes
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_zipcode( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( !isset( $woocommerce->customer ) ) return;

		if ( '==' == $operator ) :

			if ( preg_match( '/\,(\s)?/', $value ) ) :
				$match = ( in_array( $woocommerce->customer->get_shipping_postcode(), explode( ',', $value ) ) );
			else :
				$match = ( $woocommerce->customer->get_shipping_postcode() == $value );
			endif;

		elseif ( '!=' == $operator ) :

			if ( preg_match( '/\,/', $value ) ) :
				$match = ( !in_array( $woocommerce->customer->get_shipping_postcode(), explode( ',', $value ) ) );
			else :
				$match = ( $woocommerce->customer->get_shipping_postcode() != $value );
			endif;

		elseif ( '>=' == $operator ) :
			$match = ( $woocommerce->customer->get_shipping_postcode() >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $woocommerce->customer->get_shipping_postcode() <= $value );
		endif;
			
		return $match;
		
	}


	/* Match city
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_city( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( ! isset( $woocommerce->customer ) ) return;
		
		if ( '==' == $operator ) :
			$match = ( preg_match( "/^$value$/i", $woocommerce->customer->get_shipping_city() ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! preg_match( "/^$value$/i", $woocommerce->customer->get_shipping_city() ) );
		endif;
			
		return $match;
		
	}
	
	
	/* Match state
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_state( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( ! isset( $woocommerce->customer ) ) return;
		
		if ( '==' == $operator ) :
			$match = ( $woocommerce->customer->get_shipping_state() == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $woocommerce->customer->get_shipping_state() != $value );
		endif;
			
		return $match;
		
	}
	
	
	/* Match city
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_country( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( ! isset( $woocommerce->customer ) ) return;
		
		if ( '==' == $operator ) :
			$match = ( preg_match( "/^$value$/i", $woocommerce->customer->get_shipping_country() ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! preg_match( "/^$value$/i", $woocommerce->customer->get_shipping_country() ) );
		endif;
			
		return $match;
		
	}
	

	/* Match role
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_role( $match, $operator, $value ) {

		global $woocommerce, $current_user;

		if ( '==' == $operator ) :
			$match = ( array_key_exists( $value, $current_user->caps ) );
		elseif ( '!=' == $operator ) :
			$match = ( ! array_key_exists( $value, $current_user->caps ) );
		endif;
		
		return $match;
		
	}
	

/***************************
 *	
 *					 Product
 *
 ***************************
*/


	/* Match width
	 *
	 * Match the user value to the widest product 
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_width( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( ! isset( $woocommerce->cart ) || empty( $woocommerce->cart->cart_contents ) ) return;
		
		foreach ( $woocommerce->cart->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_width ) : 
				$width[] = ( get_post_meta( $product['data']->variation_id, '_width', true ) );
			else :
				$width[] = ( get_post_meta( $product['product_id'], '_width', true ) );
			endif;

		endforeach;

		$max_width = max( (array) $width );
				
		if ( '==' == $operator ) :
			$match = ( $max_width == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $max_width != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $max_width >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $max_width <= $value );
		endif;

		return $match;
		
	}

	
	/* Match height
	 *
	 * Match the user value to the highest product 
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */

	public function wafs_match_condition_height( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( ! isset( $woocommerce->cart ) || empty( $woocommerce->cart->cart_contents ) ) return;
		
		foreach ( $woocommerce->cart->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_height ) : 
				$height[] = ( get_post_meta( $product['data']->variation_id, '_height', true ) );
			else :
				$height[] = ( get_post_meta( $product['product_id'], '_height', true ) );
			endif;

		endforeach;

		$max_height = max( $height );
		
		if ( '==' == $operator ) :
			$match = ( $max_height == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $max_height != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $max_height >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $max_height <= $value );
		endif;
			
		return $match;
		
	}
	
	
	/* Match length
	 *
	 * Match the user value to the biggest product 
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */

	public function wafs_match_condition_length( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( ! isset( $woocommerce->cart ) || empty( $woocommerce->cart->cart_contents ) ) return;
		
		foreach ( $woocommerce->cart->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_length ) : 
				$length[] = ( get_post_meta( $product['data']->variation_id, '_length', true ) );
			else :
				$length[] = ( get_post_meta( $product['product_id'], '_length', true ) );
			endif;

		endforeach;

		$max_length = max( $length );

		if ( '==' == $operator ) :
			$match = ( $max_length == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $max_length != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $max_length >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $max_length <= $value );
		endif;		   
			
		return $match;
		
	}
	
	
	/* Match weight
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_weight( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;
		
		if ( '==' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_weight == $value );
		elseif ( '!=' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_weight != $value );
		elseif ( '>=' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_weight >= $value );
		elseif ( '<=' == $operator ) :
			$match = ( $woocommerce->cart->cart_contents_weight <= $value );
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
	public function wafs_match_condition_stock( $match, $operator, $value ) {

		global $woocommerce;
		
		if ( ! isset( $woocommerce->cart ) || empty( $woocommerce->cart->cart_contents ) ) return;

		foreach ( $woocommerce->cart->cart_contents as $product ) :

			if ( true == $product['data']->variation_has_stock ) : 
				$stock[] = ( get_post_meta( $product['data']->variation_id, '_stock', true ) );
			else :
				$stock[] = ( get_post_meta( $product['product_id'], '_stock', true ) );
			endif;

		endforeach;
		
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


	/* Match all product stock statusses
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_stock_status( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;
		
		if ( '==' == $operator ) :
		
			$match = true;
			foreach ( $woocommerce->cart->cart_contents as $product ) :
				if ( get_post_meta( $product['product_id'], '_stock_status', true ) != $value )
					$match = false;
			endforeach;
			
		elseif ( '!=' == $operator ) :

			$match = true;
			foreach ( $woocommerce->cart->cart_contents as $product ) :
				if ( get_post_meta( $product['product_id'], '_stock_status', true ) == $value )
					$match = false;
			endforeach;
		
		endif;
			
		return $match;
		
	}	
	

	/* Match category
	 *
	 * @param bool $match
	 * @param string $operator
	 * @param mixed $value
	 * @return bool
	 */
	public function wafs_match_condition_category( $match, $operator, $value ) {

		global $woocommerce;

		if ( ! isset( $woocommerce->cart ) ) return;
		
		$match = true;
		
		if ( '==' == $operator ) :
			
			foreach ( $woocommerce->cart->cart_contents as $product ) :

				if ( ! has_term( $value, 'product_cat', $product['product_id'] ) ) :
					$match = false;
				endif;
				
			endforeach;
			
		elseif ( '!=' == $operator ) :
			
			foreach ( $woocommerce->cart->cart_contents as $product ) :
			
				if ( has_term( $value, 'product_cat', $post->ID ) ) :
					$match = false;
				endif;
				
			endforeach;
		
		endif;
			
		return $match;
		
	}
	
}
new Wafs_Match_Conditions();

?>