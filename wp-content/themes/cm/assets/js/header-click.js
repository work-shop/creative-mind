/* header-click.js */

function pushStickyElement( e ) {
	console.log( 'going down' );
	console.log( e );
	var ref = new Waypoint.Sticky({
		element: e
	});
}

function popStickyElement() {

}

$( document ).ready( function() {
	var padding = 10;

	// $('.collection-header').waypoint({
	// 	handler: function( direction ) {
	// 		if ( direction == 'down' ) { pushStickyElement( $( this ) ); }
	// 		else { popStickyElement( $( this ) ); }
	// 	}
	// });

	$('.collection-header').each( function(e) {
		var ref = new Waypoint.Sticky({
			element: $(this)
		});
	})
	
}); 