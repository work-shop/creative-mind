<?php get_header(); ?>

	<div id="style-guide" class="style-guide block padded bg-white" >
		<div class="container-fluid">
			<div class="row mb1">
				<div class="col-sm-12">
					<h2 class="centered serif bold mb3">Color Tests</h2>
				</div>
			</div>
			<?php if( have_rows('color_tests') ): ?>
				<div id="color-tests">
					<?php while( have_rows('color_tests') ): the_row(); 
						$color = get_sub_field('color'); ?>
						<div class="color row mb3">
							<div class="col-md-2 col-sm-3 color-block color-item" style="background-color: <?php echo $color;?>">
								<h3 class="white">Courses</h3>
							</div>
							<div class="col-sm-8">	
								<h2 class="serif centered mt0 color-item" style="color: <?php echo $color; ?>">Communicating Science Through Visual Media</h2>
							</div>
							<div class="col-sm-2">
								<h4 class="mt2 color-item" style="color: <?php echo $color; ?>"><?php echo $color; ?></h4>
							</div>	
						</div>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

<?php get_template_part('partials/content_page');?>

<?php get_template_part('partials/site_description');?>

<?php get_footer(); ?>