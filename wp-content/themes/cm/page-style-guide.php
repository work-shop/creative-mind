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
			<div class="row mb1"><p>
				This class, offered jointly by professors at RISD and Brown and in partnership with the Science Center and the Creative Mind Initiative, will explore and develop the pedagogy of using visual media to convey scientific concepts. There is a growing library of online content but often times it is not well suited for seamless adoption into educational use. The goal of this course will be to assess examples of existing material and design new material that not only fills an educational need but makes science engaging and accessible. Class time will be comprised of lectures, labs, screenings, discussions, critiques and guest speakers. After an introduction to science teaching pedagogy and the basics of animation and visual design, small student teams with a balance of science and art backgrounds will collaborate on a series of short exercises leading to the creation of final videos or animations that explain scientific concepts.
			</p></div>
		</div>
	</div>

<?php get_template_part('partials/content_page');?>

<?php get_template_part('partials/site_description');?>

<?php get_footer(); ?>