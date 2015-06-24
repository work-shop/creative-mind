<?php if ( $slides = get_field('home_page_slideshow', 'options') ) : ?>

			<header id="header2" class="codrops-header">
				<h1>Draggable Dual-View Slideshow</h1>
				<span class="message">This mobile version does not have the slideshow switch</span>
				<button class="slider-switch">Switch view</button>
			</header>
			<div id="overlay" class="overlay">
				<div class="info">
					<h2>Demo interactions</h2>
					<span class="info-drag">Drag Sliders</span>
					<span class="info-keys">Use Arrows</span>
					<span class="info-switch">Switch view</span>
					<button>Got it!</button>	
				</div>
			</div>

<section class="block crop dragslider" id="slideshow">

	<section class="img-dragger img-dragger-large dragdealer">
		<div class="handle">

			<?php foreach( $slides as $i => $slide ) : ?>
			
				<?php
				$image_url = ( $slide['slide_type'] == 'custom') 
						  ? $slide['slide_image']['sizes']['slideshow_home']
						  : (( $slide['slide_type'] == "story") 
						  ? wp_get_attachment_url( get_post_thumbnail_id( $slide['slide_story'][0]->ID, 'slideshow_home' ) )
						  : wp_get_attachment_url( get_post_thumbnail_id( $slide['slide_collection'][0]->ID, 'slideshow_home' ) ));
				?>

				<div class="slide" >
					<div class="img-wrap"><img src="<?php echo $image_url; ?>" alt="slide"/></div>
						<h1><?php echo $slide['slide_title']; ?></h1>
						<h4 class="hidden"></h4>
						<button class="content-switch">Read more <span class="icon" data-icon="&#8222;"></span></button>
					</div>
				</div>

		<?php endforeach; ?>
		</div>	
		
		<div id="previous-home" class="flexslider-direction flex-previous previous">
			<span class="icon" data-icon="&#8250;"></span>
		</div>					
		
		<div id="next-home" class="flexslider-direction flex-next next">
			<span class="icon" data-icon="&#8249;"></span>
		</div>	
		
	</div>		

</section>

<script>
	(function() {

		var overlay = document.getElementById( 'overlay' ),
			overlayClose = overlay.querySelector( 'button' ),
			header = document.getElementById( 'header2' )
			switchBtnn = header.querySelector( 'button.slider-switch' ),
			toggleBtnn = function() {
				// if( slideshow.isFullscreen ) {
				// 	classie.add( switchBtnn, 'view-maxi' );
				// 	$(s)
				// }
				// else {
				// 	classie.remove( switchBtnn, 'view-maxi' );
				// }
			},
			toggleCtrls = function() {
				// if( !slideshow.isContent ) {
				// 	classie.add( header, 'hide' );
				// }
			},
			toggleCompleteCtrls = function() {
				// if( !slideshow.isContent ) {
				// 	classie.remove( header, 'hide' );
				// }
			},
			slideshow = new DragSlideshow( document.getElementById( 'slideshow' ), { 
				// toggle between fullscreen and minimized slideshow
				onToggle : toggleBtnn,
				// toggle the main image and the content view
				onToggleContent : toggleCtrls,
				// toggle the main image and the content view (triggered after the animation ends)
				onToggleContentComplete : toggleCompleteCtrls
			}),
			toggleSlideshow = function() {
				// slideshow.toggle();
				// toggleBtnn();
			},
			closeOverlay = function() {
				// classie.add( overlay, 'hide' );
			};

		// toggle between fullscreen and small slideshow
		switchBtnn.addEventListener( 'click', toggleSlideshow );
		// close overlay
		overlayClose.addEventListener( 'click', closeOverlay );

	}());
</script>


<?php endif; ?>