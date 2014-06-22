jQuery( function( $ ) {
	
	var loading_icon = '<span class="loading-icon"><img src="/wp-admin/images/wpspin_light.gif"/></span>';
	
	// Add condition
	$( '#wafs_conditions' ).on( 'click', '.condition-add', function() {
		
		var data = { 
			action: 'wafs_add_condition', 
			group: $( this ).attr( 'data-group' ) 
		};

		$( '.condition-group-' + data.group ).append( loading_icon ).children( ':last' );

		$.post( ajaxurl, data, function( response ) {
			$( '.condition-group-' + data.group ).append( response ).children( ':last' ).hide().fadeIn( 'normal' );
			$( '.condition-group-' + data.group + ' .loading-icon' ).children( ':first' ).remove();
		});
		
	});
	
	// Add child condition
	$( '#wafs_conditions' ).on( 'click', '.add-child-condition', function() {
	
		var data = { 
			action: 'wafs_add_child_condition', 
			group: $( this ).attr( 'data-group' ), 
			parent_id: $( this ).parent( '[data-id]' ).attr( 'data-id' ) 
		};

		var t = $( this ); // Save 'this' to use in $.post
		t.parent( '.wafs-condition-wrap' ).after( loading_icon ).children( ':last' );

		$.post( ajaxurl, data, function( response ) {
			t.parent( '.wafs-condition-wrap' ).after( response ).children( ':last' ).hide().fadeIn( 'normal' );
			$( '.condition-group-' + data.group + ' .loading-icon' ).children( ':first' ).remove();
		});
		
	});
	
	// Delete condition
	$( '#wafs_conditions' ).on( 'click', '.condition-delete', function() {

		if ( $( this ).closest( '.condition-group' ).children( '.wafs-condition-wrap' ).length == 1 ) { 
			$( this ).closest( '.condition-group' ).fadeOut( 'normal', function() { $( this ).remove();	});
		} else {
			$( this ).closest( '.wafs-condition-wrap' ).fadeOut( 'normal', function() { $( this ).remove(); });
		}

	});
	
	// Delete child condition
	$( '#wafs_conditions' ).on( 'click', '.child-condition-delete', function() {
		$( this ).parents( '.child-condition' ).fadeOut( 'normal', function() { $( this ).remove(); });
	});
	
	
	// Add condition group
	$( '#wafs_conditions' ).on( 'click', '.condition-group-add', function() {
		
		// Display loading icon
		$( '.wafs_conditions' ).append( loading_icon ).children( ':last' );
		
		var data = {
			action: 'wafs_add_condition_group',
			group: 	parseInt( $( '.condition-group' ).last().attr( 'data-group') ) + 1
		};
		
		// Insert condition group
		$.post( ajaxurl, data, function( response ) {
			$( '.condition-group ~ .loading-icon' ).last().remove();
			$( '.wafs_conditions' ).append( response ).children( ':last' ).hide().fadeIn( 'normal' );
		});
		
	});
	
	// Update condition values
	$( '#wafs_conditions' ).on( 'change', '.wafs-condition', function () {
		
		var data = {
			action: 		'wafs_update_condition_value',
			id:				$( this ).attr( 'data-id' ),
			group:			$( this ).attr( 'data-group' ),
			condition: 		$( this ).val()
		};
		
		var replace = '.wafs-value-wrap-' + data.id;

		$( replace ).html( loading_icon );
		
		$.post( ajaxurl, data, function( response ) {
			$( replace ).replaceWith( response );
		});
		
		// Update condition description
		var description = {
			action:		'wafs_update_condition_description',
			condition: 	data.condition
		};
		
		$.post( ajaxurl, description, function( description_response ) {
			$( replace + ' ~ .wafs-description' ).replaceWith( description_response );
		});
		
		// Update condition add child button
		var data_child_button = {
			action:		'wafs_update_condition_add_child_button',
			condition: 	data.condition
		};
		
		$.post( ajaxurl, data_child_button, function( child_button_response ) {
			$( replace + ' ~ .add-child-condition' ).remove();
			$( replace + ' ~ .condition-add' ).after( child_button_response );
		});		

	});
	
	// Update child condition values
	$( '#wafs_conditions' ).on( 'change', '.wafs-child-condition', function () {
		
		var parent_id = $( this ).attr( 'data-parent-id' );
		
		var p_value = $( '.wafs-value-wrap-' + parent_id + ' .wafs-value' );
		var parent_value = ( p_value.is( 'select' ) ) ? p_value.find( ':selected' ).val() : p_value.val();

		var p_condition = $( '.wafs-condition-wrap-' + parent_id + ' .wafs-condition' );
		var parent_condition = ( p_condition.is( 'select' ) ) ? p_condition.find( ':selected' ).val() : p_condition.val();

		var data = {
			action: 			'wafs_update_child_condition_value',
			parent_id:			parent_id,
			parent_condition:	parent_condition,
			parent_value:		parent_value,
			id:					$( this ).attr( 'data-id' ),
			group:				$( this ).attr( 'data-group' ),
			condition: 			$( this ).val()
		};
		
		var replace = '.wafs-value-wrap-' + data.id;

		$( replace ).html( loading_icon );
		
		$.post( ajaxurl, data, function( response ) {
			$( replace ).replaceWith( response );
		});
		
		// Update condition description
		var description = {
			action:		'wafs_update_condition_description',
			condition: 	data.condition
		};
		
		$.post( ajaxurl, description, function( description_response ) {
			$( replace + ' ~ .wafs-description' ).replaceWith( description_response );
		});
		
	});		
	
});