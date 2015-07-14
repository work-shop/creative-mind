
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

	if($('body').hasClass('home')){
		//isotopeSetup();
		isotopeSize();
	}

	$('#fade').click(function(event) {
	  	event.preventDefault();
		//console.log('fade');
		$(this).addClass('fade-out');
	});

	$('.story-close').click(function(event) {
	  	event.preventDefault();
		//console.log('fade');
		$('#story-modal').removeClass('active');
	});	
	
	$('#backtotop').click(function(event) {
	  	event.preventDefault();
		$('body,html').animate({scrollTop:0},2000);
	});

	$('.menu-toggle').click(function(event) {
		event.preventDefault();
		//$('#megaNav').modal('toggle');
		menuToggle();
	});

	$('#megaNav ul > li > a').click( function(event){
		event.preventDefault();
		//console.log('clicked');
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

});//end document.ready

function storySetup() {
	$(window).ready(function() { $('[data-toggle="tooltip"]').tooltip(); });//end window.ready

	// $('#video-play').click(function(event) {
	//   	event.preventDefault();
	//   	console.log('clicked story-video-play');
	// 	playVideo();
	// });

	$('.flexslider .flex-previous').click(function() {
		$(this).parent('.flexslider').flexslider('prev');
	    return false;		
	});		
	
	$('.flexslider .flex-next').click(function() {
		$(this).parent('.flexslider').flexslider('next');
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


//initialize flexslider slideshows
function flexsliderSetup(){
	

	$('.slick').slick({
		slidesToShow: 1,
		adaptiveHeight: false,
		centerMode: false,
		centerPadding: '0px',
		variableWidth: false

	});

	$('.slick-collection').slick({
		slidesToShow: 5,
		slidesToScroll: 3,
		friction: 0,
		adaptiveHeight: false,
		centerMode: false,
		centerPadding: '0px',
		variableWidth: false,
		responsive: [
		    {
		      breakpoint: 1200,
		      settings: {
		        slidesToShow: 3,
		        slidesToScroll: 3,
		        infinite: true,
		        dots: true
		      }
		    },
		    {
		      breakpoint: 768,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    }
		    // You can unslick at a given breakpoint now by adding:
		    // settings: "unslick"
		    // instead of a settings object
		  ]		

	});	
				

	$('.flexslider-hero').flexslider({	
	      animation: 'fade',
	      controlsContainer: '.flexslider-controls',	      
	      slideshowSpeed: 8000,           
		  animationSpeed: 700,
	      directionNav: false,
	      controlNav: true
	 });	 

	$('.flexslider-collection').flexslider({	
	      animation: 'slide',
	      slideshow: false,           
		  animationSpeed: 700,
	      directionNav: false,
	      controlNav: true,
	      startAt: 0
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
	 	// $('.flexslider-story-images').flexslider({	
	 	//       animation: 'fade',
	 	//       slideshowSpeed: 8000,           
	 	// 	  animationSpeed: 500,
	 	//       directionNav: false,
	 	//       controlNav: true,
	 	//       slideshow: false
	 	//  }); 
	 }	

	$('.flex-control-paging li:first-child').addClass('table-of-contents');
	$('.flex-control-paging li:first-child a').html('<span class="icon" data-icon="&#52;"></span>');	 	 
	 	 	
}

//animate jump links
function scrollLink(destination){
	$('html,body').animate({
		scrollTop: $(destination).offset().top - 65
	},1500);
}

//toggle submenu
function submenuToggle(item) {
	if ( $(item).hasClass('open') ) {
		//$(item).removeClass('open');
	} else {
		//$('#megaNav ul > li > a').removeClass('open');
		$(item).addClass('open');
	}	
}


function playVideo(){

	console.log('playvideo');

	$('body').addClass('story-video-active');
	view();
	
}

//measure, resize, and adjust the viewport
function view(){

	backShareCheck();
	
	ch = $(window).height();
	cw = $(window).width();
	ph = ch - 70;
	fw = cw*.5;
	threeQuarter = ch*.75;
	storyHeight = cw/3;
	storyVideoHeight = ch - 110;
	collectionSlideHeight = ($('.col-md-8').width() * .45);
	collectionSlideHeightMobile = ($('.col-md-8').width() * 1.2);
	slickHeight = ch - 200;


	if($('.story').hasClass('story-type-video_gallery') || $('.story').hasClass('story-type-video_and_image_gallery') ){
		storyVideoGalleryHeight = $('#video-gallery').width() * .4;
		$('.video-gallery-main-video').css('height',storyVideoGalleryHeight);
	}
	
	if($(window).width() >= 768){		

		$('.block.half').css('height',ch/2);
		$('.block.golden-max').css('max-height',ch*.72);		
		$('.block.sixty').css('height',ch*.69);										
		$('.block.full').css('height',ph);	
		$('.block.min').css('min-height',ph);				
		$('.block.min-large').css('min-height',ch);	
		$('.block.three-quarter').css('height',threeQuarter);	
		$('.block.three-quarter-max').css('max-height',ph);		
		$('.flexslider-collection .slides').css('height',collectionSlideHeight);
		$('.home-slide').css('height',slickHeight).css('width',cw);	
		$('.flexslider-gallery-story li').css('height',($('.flexslider-gallery-story').width() * .5));			

	}
	else{

		$('.block.half').css('height',ch/2);
		$('.block.golden-max').css('max-height',ch*.70);		
		$('.block.full').css('height',ph);	
		$('.block.min').css('min-height',ph);							
		$('.block.min-large').css('min-height','none');	
		$('.block.three-quarter').css('height',threeQuarter);			
		$('.block.three-quarter-max').css('max-height',ph);	
		$('.flexslider-collection .slides').css('height',collectionSlideHeightMobile);
		$('.home-slide').css('height',slickHeight).css('width',cw);		

	}
	
	if(!loaded){
		loadPage();
	}		

}

//once all elements are sized, slideshows initialized, fade in the content
function loadPage(){
	loaded = true;
	
	flexsliderSetup();
	var duration;

	duration = 750;

	setTimeout(function(){
		$('.loading').addClass('loaded');
		$('.landing').removeClass('landing').addClass('landed');
		view();
		if ( $('.spy').length > 0 ) { $(document).trigger('spy-init'); }	
	},duration);	
		
}

$(window).scroll(function() { 

	requestAnimationFrame( backShareCheck );

	if($('body').hasClass('home')){
		requestAnimationFrame( parallax );		
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



(function() {
	function videoGallerySwap( source, target ) {

		target.frame.attr('src', source.frame.attr('src'));
		target.element.find('h4').text( source.element.find('h4').text() );

		$('.video-gallery-clip').removeClass('active');
		$('.video-gallery-clip').find('.overlay').removeClass('active');

		console.log( $( source.element ) );

		$( source.element ).addClass('active')
		$( source.element ).find('.overlay').addClass('active');
	}

	

	$(document).ready( function() {
		console.log( $('.video-gallery-clip').find('.overlay') );

		$('.video-gallery-clip').find('.overlay').on('click', function( e ) {
			if ( $( this ).hasClass('active') ) return;

			var target = $('.video-gallery-main-video').find('iframe');
			var source = $(this).parent('.video-gallery-clip').find('iframe');

			videoGallerySwap( { element: $(this).parent('.video-gallery-clip') , frame: source}, {element: $('.video-gallery-main'), frame: target} );

		});
	});
})();





/**
 * WARNING: REFACTOR
 * Had to refector this video setup from 
 *
 */
function videoSetup(playFlag, callback) {

	console.log('videoSetup');

	var players = [];

	var iframe = $('#story-video-1');

	if ( !$.isEmptyObject( iframe ) ) {
		iframe.each( function( undefined, frame ) {

			console.log( 'iterator' );

			var p = players[ $( frame ).attr('id') ] = $f( frame );

			p.addEvent('ready', function( player_id ) {
				 console.log('ready');
				 p.addEvent('play', function(d){});
				 callback();
			});

			if(playFlag){
				p.api('play');
		    		playVideo();
			}

			$('.story-video-play').bind('click', function() {
		    		p.api('play');
		    		playVideo();
		    		console.log('story-video-play clicked');
			});
		});
	}	
}


//open and close the menu
function menuToggle(){	
	if($('body').hasClass('menu-closed')){
		$('#megaNav').removeClass('closed');
		$('#megaNav').addClass('open');
		$('body').removeClass('menu-closed');
		$('body').addClass('menu-open');
		$('body').css('height',($(window).height()));
	}
	
	else if($('body').hasClass('menu-open')){
		$('#megaNav').removeClass('open');
		$('#megaNav').addClass('closed');
		$('body').removeClass('menu-open');
		$('body').addClass('menu-closed');
		$($('body').css('height','auto'));

	}
	
}


//initialize home page isotope grid
function isotopeSetup(){

	// $('.grid').isotope({
	//   layoutMode: 'fitColumns',
	//   itemSelector: '.grid-item'
	// });


	var $grid = $('.grid').imagesLoaded( function() {

	isotopeSize();		
	  
	  // init Isotope after all images have loaded
	  $grid.isotope({

		    itemSelector: 		'.grid-item',

		    masonry: {
		      columnWidth: 		'.grid-item',
		      gutter: 			'.gutter-sizer'

		  	}

	  });

	});

}


function isotopeSize(){
	var tiles = $('.tile-story');
	var min = 300;
	var max = 500;

	tiles.each( function( i, l ){
		l = $( l );
		tileHeight = Math.random() * (max - min) + min;
  		l.css('height',tileHeight);
	});

}


function backShareCheck(){

	if(loaded){

		var flag = $('#back-share:in-viewport');
		if(flag.length > 0){
			flag = true;
		}
		else{
			flag = false;
		}

		if(flag && $('#back-share').hasClass('invisible')){
			$('#back-share').removeClass('invisible').addClass('visible').addClass('visibled');
		}
		else if(!flag && $('#back-share').hasClass('visible')){
			$('#back-share').removeClass('visible').addClass('invisible');		
		}

	}

}

function parallax(){
	
	scrollTop = $(window).scrollTop();

	var pOpacity,pLineHeight;

	pDistance = ($(window).height()) / 2;
	pOpacityTop = 1;
	pOpacityBottom = 0;
	pProgress = scrollTop / pDistance;
	pOpacity = 1 - pProgress;
	pLineHeight = pOpacity*1.2;

	pTopFactor = 5;
	pTop = (scrollTop / pTopFactor) * 1;

	pTop1 = pTop * .1; pTop1 = 'translateY(' + pTop1 + '%)'; //console.log(pTop1);
	pTop2 = pTop * .2; pTop2 = 'translateY(' + pTop2 + '%)';
	pTop3 = pTop * .19; pTop3 = 'translateY(' + pTop3 + '%)';
	pTop4 = pTop * .1;	pTop4 = 'translateY(' + pTop4 + '%)';
	
	$('.grid-col-1').css('transform',pTop1);
	$('.grid-col-2').css('transform',pTop2);
	$('.grid-col-3').css('transform',pTop3);
	$('.grid-col-4').css('transform',pTop4);

}

