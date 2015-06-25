/**
 * module for asynchronous post loading in Wordpress.
 *
 * This module us supplied with the admin_url for ajax requests as a parameter.
 * The module assumes a one-one correspondence between post_ids and post content,
 * it uses this assumption to cache post content for future asychronous calls.
 *
 * Public Interface:
 * =============
 *
 * getPost : int => (err x int => void) => boolean | undefined => void
 *
 */
 var libasync = (function( url, $ ) {

 	/**
 	 * An associative array of post_ids -- stored as strings -- and content
 	 * which is also stored as a string.
 	 *
 	 * @var cache Map(String => {title: String, content: String}).
 	 */
 	var cache = {};

 	/**
 	 * Convert an int to a string.
 	 */
 	function str( i ) { return "" + i + ""; }

 	/**
 	 * Make an asynchronous http request, requesting the specific 
 	 * post_id, and then passing control to the provided callback.
 	 */
 	function request( post_id, callback ) {
		$.post( 
 			url, 
 			{
				'action': 'cm_get_story',
				'story': post_id
			}, 
			function( quote ) {
				try {
					//console.log( quote );
					var data = $.parseJSON( quote );

					if ( data.success ) {

						var value = cache[ str( post_id ) ] = { title: data.title, content: data.post };
						callback( null, value );

					} else {
						callback( new Error( data.error ) );
					}

				} catch ( err ) { callback( err ); }
			}
		);
 	}

 	/**
 	 * Given a post ID as a parameter, this method returns a string representing 
 	 * the post's content. It caches the content it retrieves, and serves cached content
 	 * if force is false or undefined.
 	 *
 	 * @param int post_id
 	 * @param (err x string => void) callback. a continuation to invoke.
 	 * @param boolean force, if true, do not serve from the cache.
 	 */
 	function get_post( post_id, callback, force ) {
 		if ( force || !cache[ str( post_id ) ] ) {	
 			request( post_id, callback );
 		} else {
 			callback( null, cache[ str( post_id ) ] );
 		}
 	}
 	
 	return {
 		getPost : get_post
 	};


})( ajax.url, jQuery ); 


/**
 * module performs asynchronous javascript actions based on the url
 *
 * This module consumes an array of valid #-parameters to take action
 *
 */
var urlmanager = (function( $, pollLocation, libAsync ) {
 	/**
 	 * An associative array of #-parameters to function to execute
 	 *
 	 * @var cache Map(String => (String => void)).
 	 */
	var actions = {};

	/**
	 * add new action to the list of actions to be invoked when the URL
	 * matches this parameter.
	 */
	function set_action( namespace, parameter, callback ) {
		if ( actions[ namespace ] ) {
			if ( actions[ namespace ][ parameter ] ) {
				actions[ namespace ][ parameter ].push( callback ); 
			} else {
				actions[ namespace ][ parameter ] = [ callback ];
			}
		} else {
			actions[ namespace ] = {};
			actions[ namespace ][ parameter ] = [ callback ];
		}
	}

	function do_action( namespace, parameter ) {
		if ( actions[ namespace ] && actions[ namespace ][ parameter ] ) {
			actions[ namespace ][parameter].forEach( function( f ) { f( parameter ); });
		}
	}

	function reduce_url( url ) {
		if ( url.indexOf('#') != -1 ) {
			return url.substr( url.indexOf('#'), url.length ).split('#');
		} else {
			return [];
		}
	}

	function run() {
		pollLocation( true );
		$( window ).on('href-changed', function( e, url ) {
			//console.log('href');
			var parameter = reduce_url( url );
			var populated = parameter.reduce( function( prev, curr ) { return (curr.length != 0) || prev }, false );

			if ( populated ) {
				console.log( 'triggered: ');
				console.log( parameter );

				var namespace = parameter[ parameter.length - 2 ];
				do_action( namespace, parameter[ parameter.length - 1 ] );
			} else {
				do_action( 'default', 'default');
			}
		});
	}

	return {
		on: set_action,
		trigger: do_action,
		run: run,
		actions: function() { return actions; }
	};

})( jQuery, pollLocation );


/**
 * Use these functions to walk your array,
 * and you'll find the array has become topologically
 * similar to a circle.
 */

/**
 *
 *
 *
 */
function circular_next( arr, current_index ) {
	if ( current_index == arr.length - 1 ) {
		return arr[ 0 ];
	} else {
		return arr[ current_index + 1 ];
	}

}

/**
 *
 *
 *
 */
function circular_prev( arr, current_index ) {
	if ( current_index == 0 ) {
		return arr[ arr.length - 1 ];
	} else {
		return arr[ current_index - 1 ];
	}
}
/**
 *
 *
 *
 */
function circular_selection_prev( unit, current ) {
	var sel = current.prev( unit );

	if ( sel.length == 0 ) {
		return $( unit ).last();
	} else {
		return sel;
	}
}
/**
 *
 *
 *
 */
function circular_selection_next( unit, current ) {
	var sel = current.next( unit );

	if ( sel.length == 0 ) {
		return $( unit ).first();
	} else {
		return sel;
	}
}

/**
 *
 *
 *
 */
function divide( collection, key ) {
	var ret = {};

	collection.each(function( i, d ) {
		d = $( d );
		if ( ret[ d.attr( key ) ] )  {
			ret[ d.attr( key ) ].push( d );
		} else {
			ret[ d.attr( key ) ] = [ d ];
		}
		
	})

	return ret;
}

/**
 * This function is called whenever an asynchronous request is completed.
 * Any kind of DOM manipulation with the returned content should be handled
 * in the routine, or in functions called by this routine.
 *
 * @param thisStory an object representing the rendered story: {title: string, content: html}
 * @param nextStory a jQuery object representing the thumbnail of the next story.
 * @param prevStory a jQuery object representing the thumbnail of the previous story.
 *
 */
function updateView( thisStory, nextStory, prevStory ) {

	//console.log( thisStory );
	//console.log( prevStory );
	//console.log( nextStory );

	function makeSlug( slug ) { return '#' + slug; }

	function makeCategoryColor( category ) { return "border-" + category; }
	function makeCategoryBackgroundColor( category ) { return "bg-" + category; }

	function injectContent( target, content ) {

		content = $(content);

		//console.log( target );
		
		//console.log('content: ');
		//console.log( content.attr('async-slug') );
		//console.log( content.attr('async-background-image') );
		//console.log( content.attr('async-category' ) );

		target.attr('href', makeSlug( content.attr('async-collection-slug') ) + makeSlug( content.attr('async-slug') ) );

		target.find('.preview')
			.attr('style', "background-image:url(" + content.attr('async-background-image') + ");")
			.addClass( makeCategoryColor( content.attr('async-category' ) ) );

		target.find('h3').text( content.find('h3').text() );

		$('#story-modal').addClass( makeCategoryBackgroundColor( content.attr('async-category')));
		$('title').html('Story Title');

	}


	var storyTarget = $('#current-story'),
		nextTarget = $('#next-story-link'),
		prevTarget = $('#previous-story-link')
		storyModal = $('#story-modal');

		if(storyModal.hasClass('inactive')){
			storyModal.removeClass('inactive').addClass('activated').addClass('active');
		}

		injectContent( nextTarget, nextStory );
		injectContent( prevTarget, prevStory );

		storyTarget.html( thisStory.content );
		var myString = 'interviews';

		videoSetup();
		view();

		if($('.flexslider-story-images')){
	 		$('.flexslider-story-images').flexslider({	
		 	      animation: 'fade',
		 	      slideshowSpeed: 8000,           
		 		  animationSpeed: 500,
		 	      directionNav: false,
		 	      controlNav: true,
		 	      slideshow: false
		 	 }); 
 		}

		//storyModal.addClass('bg-' + thisStory.content.attr('async-category' ));

		// add the category color to the story target!

		// close button stuff has to happen here.

		// loading animation stops here
}

/**
 * This function is called whenever the DEFAULT asynchronous request is completed
 * Any DOM manipulation that happens in updateView should be UNDONE here,
 * in the routine, or in functions called by this routine.
 *
 *
 */
function clearView() {

		function clearContent( target ) {
			target.attr('href', "#" );

			target.find('.preview')
			.attr('style', "" );

			target.find('h3').text( "" );

			$('title').html('Story Title');
		}

		var 	storyTarget = $('#current-story'),
			nextTarget = $('#next-story-link'),
			prevTarget = $('#previous-story-link')
			storyModal = $('#story-modal');

		if(storyModal.hasClass('active')){
			storyModal.removeClass('active').removeClass('activated').addClass('inactive');
		}

		clearContent( prevTarget );
		clearContent( nextTarget );

		storyTarget.html( "" );
}

/**
 * Work the asynchrony into the view.
 */
$( document ).ready( function() {

	urlmanager.run();

	var buckets = divide( $('.story-slide'), 'async-collection-slug' );

	console.log( buckets );

	for ( var collection in buckets ) {

		buckets[ collection ].forEach( function( story, index, bucket ) {
			var nextStory = circular_next( bucket, index );
			var prevStory = circular_prev( bucket, index );

			urlmanager.on( story.attr('async-collection-slug'), story.attr('async-slug'), function( ) {
				libasync.getPost( parseInt( story.attr('async-id') ),  function( err, data ) {
					if ( err ) console.log( err );

					updateView( data, nextStory, prevStory );

				});
			});
		});
	}

	urlmanager.on( 'default', 'default', clearView);

	$(window).trigger('href-changed', window.location.href );

});
























