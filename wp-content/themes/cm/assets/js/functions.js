
//global variables
var cw,ch;
var loaded = false;
var state = 'intro';
var moving = false;

var log = console.log;

//initial events, and general event binding
jQuery(document).ready(function($) {

	view();

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
		menuToggle();
		console.log('.menu-toggle clicked');
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
	if(e.which == 109 || e.which == 77) {	
		if($("input:focus")){
			var elem = document.activeElement;
			if ( elem.type ){ 
				
			}
			else{ 
				menuToggle();	
			}
		}
	}
});

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
		  animationSpeed: 1500,
	      directionNav: false,
	      controlNav: true
	 });	 

	$('.flexslider-story').flexslider({	
	      animation: 'fade',
	      controlsContainer: '.flexslider-controls',	      
	      slideshowSpeed: 8000,           
		  animationSpeed: 500,
	      directionNav: false,
	      controlNav: true
	 }); 			 
	 	 	
}

//animate jump links
function scrollLink(destination){
	$('html,body').animate({
		scrollTop: $(destination).offset().top - 100
	},1500);
}

//open and close the menu
function menuToggle(){
	console.log('menutoggle');
	
	if($('#menu').hasClass('off')){
		$('#menu').removeClass('off');
		$('#menu').addClass('on');
		$('html').removeClass('menu-closed');
		$('html').addClass('menu-open');
		$('#menu').scrollTop(0);				
		$('html,body').scrollTop(0);			
		var trim = $(window).height();		
		$('html,body').css('height',trim);
		$('html,body').css('overflow','hidden');
	}
	
	else if($('#menu').hasClass('on')){
		$('#menu').removeClass('on');
		$('#menu').addClass('off');
		$('html').removeClass('menu-open');
		$('html').addClass('menu-closed');
		$('html').scrollTop(0);	
		$('html,body').css('height','100%');
		$('html,body').css('overflow','visible');
	}
	
}

/**
 * storyToggle : jQuery(clicked-tile) -> ()
 */
function storyToggle(clicked){

	console.log( 'startToggle' );
	console.log( clicked );

	ch = $(window).height();
	cw = $(window).width();
	heroHeight = cw/3;
	storyHeight = ch - 80;

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

	console.log( 'sending:' + clicked.attr('async-source') );
	console.log( $('#collection-single').attr('async-source') );

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
		console.log( data );

		if ( data.success ) {
			console.log( "success" );

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

	$('#active-story').addClass('story-activated');
	$('body').addClass('story-activated');		
	$('#active-story').height(storyHeight);		
	$('#active-story').removeClass('story-loading').addClass('story-loaded');
	$('body').removeClass('story-loading').addClass('story-loaded');
	flexsliderSetup();
	storySetup();
	view();
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
	storyVideoHeight = ch - 200;



	if($('.story').hasClass('story-type-video')){

		if($('body').hasClass('story-video-active')){
			$('.story-hero').css('height',storyVideoHeight);
			$('.story-video-container').css('height',storyVideoHeight);
		}
		else{
			$('.story-hero').css('height',storyHeight);
			$('.story-video-container').css('height',storyHeight);		
		}
	}
	else if($('.story').hasClass('story-type-video_gallery')){	
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
	
	if(!loaded){
		loadPage();
	}		

}

//once all elements are sized, slideshows initialized, fade in the content
function loadPage(){
	loaded = true;
	
	flexsliderSetup();

	setTimeout(function(){
		$('.loading').addClass('loaded');
		$('.landing').addClass('landed');
		view();
		if ( $('.spy').length > 0 ) { $(document).trigger('spy-init'); }	
	},1000);		
		
}

$(window).scroll(function() { 

	if( !$('html').hasClass('menu-open') ) {	
	
		var after = $('body').offset().top + 40;
		       
		if($(this).scrollTop() >= after && $("body").hasClass('before')){
			$("body").removeClass('before').addClass('after');
		} 
		else if($(this).scrollTop() < after && $("body").hasClass('after')){
			$("body").removeClass('after').addClass('before');	
		} 
	
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




