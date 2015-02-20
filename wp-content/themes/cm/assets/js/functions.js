
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
	
	$('.flexslider .flex-previous').click(function() {
	    $('.flexslider').flexslider('prev');
	    return false;		
	});		
	
	$('.flexslider .flex-next').click(function() {
	    $('.flexslider').flexslider('next');
	    return false;		
	});	

	$('.single .story-tile').click(function(event) {
	  	event.preventDefault();
		storyToggle($(this));
	});		

	$('.story-toggle').click(function(event) {
	  	event.preventDefault();
		storyToggle($(this));
	});		

});//end document.ready



$(window).ready(function() {

	$('[data-toggle="tooltip"]').tooltip();

});//end window.ready



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

	$('.flexslider').flexslider({	
	      animation: 'fade',
	      controlsContainer: '.flexslider-controls',	      
	      slideshowSpeed: 8000,           
		  animationSpeed: 1500,
	      directionNav: false,
	      controlNav: false
	 });	 			 
	 	 	
}

//animate jump links
function scrollLink(destination){
	$('html,body').animate({
		scrollTop: $(destination).offset().top - 0
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

function storyToggle(clicked){

	ch = $(window).height();
	cw = $(window).width();
	heroHeight = cw/3;
	storyHeight = ch - 80;

	if($('#active-story').hasClass('story-loaded')){
		$('body').removeClass('story-loaded').addClass('story-loading');
		$('#active-story').removeClass('story-loaded').addClass('story-loading');
	}

	//append styles to the active story tile
	$('.story-tile').removeClass('active').addClass('inactive');
	clicked.removeClass('inactive').addClass('active');
	
	//transition to story-loading state	
	$('html,body').animate({scrollTop: 0},1000);	
	$('#active-story').animate({scrollTop: 0},1000);		
	$('#active-story').addClass('story-loading');
	$('body').addClass('story-loading');

	setTimeout(function(){
		$('#active-story').addClass('story-activated');
		$('body').addClass('story-activated');		
		$('#active-story').height(storyHeight);		
		$('#active-story .story .story-hero').height(heroHeight);
		$('#active-story').removeClass('story-loading').addClass('story-loaded');
		$('body').removeClass('story-loading').addClass('story-loaded');
		
	},2000);
	
}

//measure, resize, and adjust the viewport
function view(){
	
	ch = $(window).height();
	cw = $(window).width();
	ph = ch - 130;
	fw = cw*.5;
	
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
	console.log('loadPage');
	
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

	spied = {};

	$('.spy .target:not(.exclude)').each( function( i,d ) { 
		spied[ $(d).attr('id') ] = true;
			console.log(spied);

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

	 		c.removeClass('active');
	 		d.addClass('active').addClass('activated');

	 		if($('#active-story').hasClass('story-activated') && d.attr('id') == 'collection-single'){
	 			// $('#collection-intro').removeClass('tucked').addClass('untucked');
				$('body').removeClass('story-loaded').removeClass('story-loading').removeClass('story-activated');

	 		}

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
		var centerline = w.scrollTop() + (w.height() / 2);

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

	 function decideOffset() {
	 	var w = $(window);
	 	return ($('body').hasClass('home')) ? ((w.width() < 768) ? 350 : (w.height() / 2)) : 80;
	 }
});




