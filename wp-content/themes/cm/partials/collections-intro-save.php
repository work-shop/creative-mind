<section id="collections-intro" class="block padded target">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
			<?php if(is_home() || is_single() ){ ?>
				<h2 class="serif bold">Featured Collections</h2>
			<?php } else{ ?>
				<h2 class="centered serif bold courses <?php /* echo the category slug here, so a css style can be applied to the color of the text */ ?>">Take a look into the inspiring and innovative research endeavors by students and faculty at Brown.</h2>
			<?php } ?>
			</div>
		</div>
	</div>
</section>