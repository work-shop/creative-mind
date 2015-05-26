
//global variables
var cw,ch;
var loaded = false;
var state = 'intro';
var moving = false;

var log = console.log;

//initial events, and general event binding
jQuery(document).ready(function($) {

	view();

	videoSetup();

	$('#fade').click(function(event) {
	  	event.preventDefault();
		console.log('fade');
		$(this).addClass('fade-out');
	});
	
	$('#backtotop').click(function(event) {
	  	event.preventDefault();
		$('body,html').animate({scrollTop:0},2000);
	});

	$('.menu-toggle').click(function(event) {
		event.preventDefault();
		$('#megaNav').modal('toggle');
	});

	$('#megaNav ul > li > a').click( function(event){
		event.preventDefault();
		console.log('clicked');
		submenuToggle($(this));
	});

	$(".jump").click(function(e){
		e.preventDefault();
		var href = $(this).attr("href");
		href = href.toLowerCase();
		scrollLink(href);	
	});
	
	$('.single .story-tile').click(function(event) {
	  	event.preventDefault();
		storyToggle($(this));
	});		

	$('.story-toggle').click(function(event) {
	  	event.preventDefault();
		storyToggle($(this));
	});	

	storySetup();

	loadInitialStory();			

});//end document.ready

function storySetup() {
	$(window).ready(function() { $('[data-toggle="tooltip"]').tooltip(); });//end window.ready

	$('.story-video-play').click(function(event) {
	  	event.preventDefault();
		playVideo();
	});

	$('.flexslider .flex-previous').click(function() {
	    $('.flexslider').flexslider('prev');
	    return false;		
	});		
	
	$('.flexslider .flex-next').click(function() {
	    $('.flexslider').flexslider('next');
	    return false;		
	});	


}



$(window).resize(function() {

	view();	
	
});//end window.resize



//FUNCTIONS

//m or M	
$(document).keypress(function(e) { 
	if (e.which == 109 || e.which == 77) {
		$('.menu-toggle').click(); 
	}
} );

//down arrow
$(document).keydown(function(e){
    if (e.keyCode == 40 && !moving) { 
    	moving = true;
    	pos = stateNext.offset().top;

	 	$('html,body').animate({
			scrollTop: pos
		},2000, function() {
			moving = false;
		});  
       return false;
    }
});

//up arrow
$(document).keydown(function(e){
    if (e.keyCode == 38 && !moving) { 
    	moving = true;
    	pos = statePrevious.offset().top;

	 	$('html,body').animate({
			scrollTop: pos
		},2000, function() {
			moving = false;
		});  
       return false;
    }
});

//left arrow
$(document).keydown(function(e){
    if (e.keyCode == 37) { 
    	
       return false;
    }
});

//right arrow
$(document).keydown(function(e){
    if (e.keyCode == 39) { 
    	
       return false;
    }
});


//initialize flexslider slideshows
function flexsliderSetup(){

	$('.flexslider-hero').flexslider({	
	      animation: 'fade',
	      controlsContainer: '.flexslider-controls',	      
	      slideshowSpeed: 8000,           
		  animationSpeed: 700,
	      directionNav: false,
	      controlNav: true
	 });	 

		
	 if ( $('body').hasClass('single-stories') ) {
	 	$('.flexslider-story').flexslider({	
	 	      animation: 'fade',
	 	      controlsContainer: '.flexslider-controls',	      
	 	      slideshowSpeed: 8000,           
	 		  animationSpeed: 500,
	 	      directionNav: false,
	 	      controlNav: "thumbnails",
	 	      slideshow: false
	 	 }); 
	 } else {
	 	$('.flexslider-story').flexslider({	
	 	      animation: 'fade',
	 	      slideshowSpeed: 8000,           
	 		  animationSpeed: 500,
	 	      directionNav: false,
	 	      controlNav: true,
	 	      slideshow: false
	 	 }); 
	 }	

	$('.flex-control-nav li:first-child').addClass('table-of-contents');
	$('.flex-control-nav li:first-child a').html('<span class="icon" data-icon="&#52;"></span>');	 	 
	 	 	
}

//animate jump links
function scrollLink(destination){
	$('html,body').animate({
		scrollTop: $(destination).offset().top - 100
	},1500);
}

//toggle submenu
function submenuToggle(item) {
	if ( $(item).hasClass('open') ) {
		$(item).removeClass('open');
	} else {
		$('#megaNav ul > li > a').removeClass('open');
		$(item).addClass('open');
	}	
}

/**
 * storyToggle : jQuery(clicked-tile) -> ()
 */
function storyToggle(clicked){

	//console.log( 'startToggle' );
	//console.log( clicked );

	ch = $(window).height();
	cw = $(window).width();
	heroHeight = cw/3;
	storyHeight = ch - 110;

	if($('#active-story').hasClass('story-loaded')){
		$('body').removeClass('story-loaded').removeClass('story-video-active').addClass('story-loading');
		$('#active-story').removeClass('story-loaded').addClass('story-loading');
	}

	//append styles to the active story tile
	$('.story-tile').removeClass('active').addClass('inactive');
	
	if ( clicked.hasClass('story-tile') ) {
		clicked.removeClass('inactive').addClass('active');
	}
	
	//transition to story-loading state			
	$('#active-story').addClass('story-loading');
	$('body').addClass('story-loading');

	//console.log( 'sending:' + clicked.attr('async-source') );
	//console.log( $('#collection-single').attr('async-source') );

	$.post( async.url, {
			'action': 'cm_get_story',
			'story': clicked.attr('async-source'),
			'collection': $('#collection-single').attr('async-source')
		}, update_dom_contents
	)
	.done( cleanup_async_call )
	.fail(function(){console.log('done with failure');});	
}

function loadInitialStory() {
	var target = $('#collection-single').attr('async-trigger');

	if ( target ) {
		storyToggle( $( '#story-' + target ) );
	}
}


function update_dom_contents( quote ) {
	try {
		var data = $.parseJSON( quote );
			//console.log( data );

		if ( data.success ) {
			//console.log( "success" );

			var story = $('[async-target="story"]');
			var prev = $('[async-target="previous"]');
			var curr = $('[async-target="current"]');
			var next = $('[async-target="next"]');

			prev.text( data.previous_story.title );
			prev.closest('a.story-toggle').attr( 'async-source', data.previous_story.id );

			curr.text( data.story_title );

			next.text( data.next_story.title  );
			next.closest('a.story-toggle').attr( 'async-source', data.next_story.id );

			story.html( data.post );
			//videoSetup();


		} else {

			$('[async-target="story"]').html( data.error );

		}

	} catch (e) {
		console.log( "error" );
		console.log( e );
	}
}

function cleanup_async_call() {
	// moved the animation to after the dom has loaded, because of a bottleneck on the event thread
	$('html,body').animate({scrollTop: 0},1000);	
	$('#active-story').animate({scrollTop: 0},1000);

	ch = $(window).height();
	cw = $(window).width();
	heroHeight = cw/3;
	storyHeight = ch - 110;

	setTimeout( function() { // is this needed?
		storyHeight = $(window).height() - 110;

		$('#active-story').addClass('story-activated');
		$('body').addClass('story-activated').addClass('story-active');	
		$('#active-story').height(storyHeight);		
		$('#active-story').removeClass('story-loading').addClass('story-loaded');
		$('body').removeClass('story-loading').addClass('story-loaded');

		flexsliderSetup();
		videoSetup();
		storySetup();
		view();

	}, 1500 ); // is this needed?

}



function playVideo(){

	$('body').addClass('story-video-active');
	view();
	
}

//measure, resize, and adjust the viewport
function view(){
	
	ch = $(window).height();
	cw = $(window).width();
	ph = ch - 130;
	fw = cw*.5;
	storyHeight = cw/3;
	storyVideoHeight = ch - 110;


	if($('.story').hasClass('story-type-video')){

		if($('body').hasClass('story-video-active')){
			$('.story-hero').css('height',storyVideoHeight);
			$('.story-video-container').css('height',storyVideoHeight);
		}
		else{
			$('.story-hero').css('height',storyHeight);
			$('.story-video-container').css('height',storyVideoHeight);		
		}
	}
	else if($('.story').hasClass('story-type-video-gallery')){	
		$('.story-hero').css('height','auto');
		$('.video-gallery-main').css('height',ch/2);
	}	
	else{
		$('.story-hero').css('height',storyHeight);
	}	
	
	if($(window).width() >= 768){		


		$('.block.half').css('height',ch/2);
		$('.block.golden-max').css('max-height',ch*.72);		
		$('.block.sixty').css('height',ch*.69);										
		$('.block.full').css('height',ch+60);	
		$('.block.min').css('min-height',ch);				
		$('.block.min-large').css('min-height',ch);	
		$('.block.three-quarter').css('height',ph);	
		$('.block.three-quarter-max').css('max-height',ph);		
		//$('.flexslider-hero').css('height',fw);																									
	}
	else{

		$('.block.half').css('height',ch/2);
		$('.block.golden-max').css('max-height',ch*.70);		
		$('.block.full').css('height',ch+60);	
		$('.block.min').css('min-height',ch);							
		$('.block.min-large').css('min-height','none');	
		$('.block.three-quarter').css('height',ph);			
		$('.block.three-quarter-max').css('max-height',ph);	
		//$('.flexslider-hero').css('height',fw);																															
	}

	$('.home .slides').css('height',ch-240);
	
	if(!loaded){
		loadPage();
	}		

}

//once all elements are sized, slideshows initialized, fade in the content
function loadPage(){
	loaded = true;
	
	flexsliderSetup();
	var duration;

	if($('body').hasClass('home')){
		duration = 4000;
	}
	else{
		duration = 500;
	}

	setTimeout(function(){
		$('.loading').addClass('loaded');
		$('.landing').removeClass('landing').addClass('landed');
		view();
		if ( $('.spy').length > 0 ) { $(document).trigger('spy-init'); }	
	},duration);	
		
}

$(window).scroll(function() { 

	if( !$('html').hasClass('menu-open') ) {

			if($('body').hasClass('home')){	
		
			var after = $('body').offset().top + 40;
			       
			if(76087066 >= after && $("body").hasClass('before')){
				$("body").removeClass('before').addClass('after');
			} 
			else if($(this).scrollTop() < after && $("body").hasClass('after')){
				$("body").removeClass('after').addClass('before');	
			} 
		
		}

	}

	console.log($(this).scrollTop());
	if( $('body').hasClass('story-active') && $(this).scrollTop() > 0) {
		$('body').removeClass('story-active').addClass('story-removed');
	}
	else if( $('body').hasClass('story-removed') && $(this).scrollTop() <= 0){
		$('body').addClass('story-active').removeClass('story-removed');
	}

	if( $(this).scrollTop() > 60) {
		$('.menu-minimal').removeClass('visible-xs');
		$('.menu-full').addClass('hidden');
	}
	else if( $(this).scrollTop() < 60) {
		$('.menu-minimal').addClass('visible-xs');
		$('.menu-full').removeClass('hidden');
	}

});//end window.scroll


















$(document).on('spy-init', function() {

	var current = undefined;
	var previousBodyClass;


	spied = {};

	$('.spy .target:not(.exclude)').each( function( i,d ) { 
		spied[ $(d).attr('id') ] = true;
	});
	/**
	 * When spying on the state of the page, we're interested in:
	 * the currently-viewed element. (and performing actions on it).
	 * at any point we can:
	 * jump to
	 */

	 $(document).on('spy-recalculate', function() {
	 	decideActive(  $('.block.target:in-viewport'));
	 });

	 $(document).on('spy-repaint', function( event, d ) {
	 	if ( current != d ) {
	 		var c = $(current);
	 		    d = $( d );
	 		
	 		var b = $('body');
	 		var bodyClass = 'block-active-' + d.attr('id');

	 		b.removeClass(previousBodyClass);
	 		c.removeClass('active');
	 		d.addClass('active').addClass('activated');
	 		b.addClass(bodyClass);
	 		previousBodyClass = bodyClass;

	 		current = d;
	 	}
	 })


	 $(window).on('scroll', function() {
	 	if( !$('html').hasClass('menu-open') ) {	
	 		$(document).trigger('spy-recalculate');
	 	}
	 });

	 $(document).trigger('spy-recalculate');

	 function decideActive( candidates ) {
	 	/**
		 * Let's define an element as "active" if its body is intersecting the
		 * centerpoint of the page. Let's compute the current centerpoint, and 
		 * iterate across the blocks that are in view, decide which ones are active,
		 * and trigger the desired action on them.
		 */


		var w = $(window), doc = $(document);
		var centerline = w.scrollTop() + (w.height() / 3);

		candidates.each( function( i,d ) {
			d = $( d );

			if ( d.offset().top < centerline && (d.offset().top + d.height()) > centerline ) {
 				var s = $('.spy');

 				doc.trigger('spy-repaint', d);

 				if ( $('.spy').hasClass('falloff') && d.is( $('.falloff-link').attr('href') ) ) {
 					s.addClass('off');
 				} else {
 					s.removeClass('off');
 				}
 			}
		});
	 }

	 //currently unused
	 function decideOffset() {
	 	var w = $(window);
	 	return 0;
	 	//return ($('body').hasClass('home')) ? ((w.width() < 768) ? 350 : (w.height() / 2)) : 80;
	 }
});

function videoSetup() {
	var players = [];

	var iframe = $('#story-video-1');

	console.log( iframe );

	if ( !$.isEmptyObject( iframe ) ) {
		iframe.each( function( undefined,frame ) {
			var p = players[ $( frame ).attr('id') ] = $f( frame );

			p.addEvent('ready', function( player_id ) {
				 console.log('ready');
				 p.addEvent('play', function(d){});
			});

			$('.story-video-play').bind('click', function() {
		    		p.api('play');
			});
		});
	}	
}




