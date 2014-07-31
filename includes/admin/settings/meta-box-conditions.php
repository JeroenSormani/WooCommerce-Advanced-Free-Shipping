<?php
/**
 * WAFS meta box conditions
 *
 * Display the shipping conditions in the meta box
 *
 * @author		Jeroen Sormani
 * @package		WooCommerce Advanced Free Shipping
 * @version		1.0.0
 */

wp_nonce_field( 'wafs_conditions_meta_box', 'wafs_conditions_meta_box_nonce' );

global $post;
$conditions = get_post_meta( $post->ID, '_wafs_shipping_method_conditions', true );

?>
<div class='wafs wafs_conditions wafs_meta_box wafs_conditions_meta_box'>

	<p><strong><?php _e( 'Match all of the following rules to allow free shipping:', 'woocommerce-advanced-free-shipping' ); ?></strong></p>
	
	<?php
	if ( !empty( $conditions ) ) :

		foreach ( $conditions as $condition_group => $conditions ) :
			?>
			<div class='condition-group condition-group-<?php echo $condition_group; ?>' data-group='<?php echo $condition_group; ?>'>

				<p class='or_match'><?php _e( 'Or match all of the following rules to allow free shipping:', 'woocommerce-advanced-free-shipping' );?></p>
				<?php
				foreach ( $conditions as $condition_id => $condition ) :
	
					new Wafs_Condition( $condition_id, $condition_group, $condition['condition'], $condition['operator'], $condition['value'] );
				
				endforeach;
				?>
			</div>
			
			<p><strong><?php _e( 'Or', 'woocommerce-advanced-free-shipping' ); ?></strong></p>
			<?php
		endforeach;
		
	else :
		
		?><div class='condition-group condition-group-0' data-group='0'><?php
		new Wafs_Condition();
		?></div><?php
		
	endif;
	?>

</div>

<a class='button condition-group-add' href='javascript:void(0);'><?php _e( 'Add \'Or\' group', 'woocommerce-advanced-free-shipping' ); ?></a>