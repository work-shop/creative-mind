<section class="block crop" id="slideshow">

	<div class="flexslider flexslider-hero">
		<ul class="slides">
			<?php for ($i=1; $i < 5; $i++) { ?>
				<li class="background-cover background-mask-light-broken" style="background-image: url('<?php bloginfo('template_directory'); ?>/assets/img/<?php echo $i;?>.jpg');">
					<div class="vertical-center container slideshow-caption-container">
						<div class="row">

						<?php if($i%2 == 0){ ?>

							<div class="col-sm-6 col-md-4 slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="#">
									<h6>Featured Collection</h6>
									<h2 class="serif m0">Collection <?php echo $i; ?></h2>
									<p class="m0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									consequat.</p>		
								</a>
							</div>

							<div class="col-sm-3 col-md-2 col-sm-offset-5 col-md-offset-6 mt9 slideshow-caption-link bg-brand">
								<h5 class="white">Read more <span class="icon" data-icon="&#8222;"></span></h5>
							</div>

							<?php } else{ ?>

							<div class="col-sm-3 col-md-2 mt9 slideshow-caption-link bg-brand">
								<h5 class="white">Read more <span class="icon" data-icon="&#8222;"></span></h5>
							</div>							

							<div class="col-sm-6 col-md-4 col-md-offset-6 slideshow-caption slideshow-caption-<?php echo $i;?>">
								<a href="#">
									<h6>Featured Collection</h6>
									<h2 class="serif m0">Collection <?php echo $i; ?></h2>
									<p class="m0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									consequat.</p>		
								</a>
							</div>							

							<?php } ?>


						</div>	
					</div>
				</li>
			<?php } ?>
		</ul>	
	
		<div class="flexslider-controls"></div> 
		
		<div id="previous-home" class="flexslider-direction flex-previous previous">
			<span class="icon" data-icon="&#8250;"></span>
		</div>					
		
		<div id="next-home" class="flexslider-direction flex-next next">
			<span class="icon" data-icon="&#8249;"></span>
		</div>	
		
	</div>		

</section>