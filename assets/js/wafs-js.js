jQuery( function( $ ) {
	
	var loading_icon = '<span class="loading-icon"><img src="/wp-admin/images/wpspin_light.gif"/></span>';
	
	// Add condition
	$( '#wafs_conditions' ).on( 'click', '.condition-add', function() {
		
		var data = { action: 'wafs_add_condition', group: $( this ).attr( 'data-group' ) };

		$( '.condition-group-' + data.group ).append( loading_icon ).children( ':last' );

		$.post( ajaxurl, data, function( response ) {
			$( '.condition-group-' + data.group ).append( response ).children( ':last' ).hide().fadeIn( 'normal' );
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
		})

		
	});
	
});