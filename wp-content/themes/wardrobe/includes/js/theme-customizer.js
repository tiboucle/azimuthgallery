( function( $ ){
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.logo a' ).html( to );
		} );
	} );
} )( jQuery );