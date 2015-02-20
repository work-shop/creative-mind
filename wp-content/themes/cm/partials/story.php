
	<?php 

	//video, video_gallery, image_gallery, video_and_image_gallery
	$story_type = 'video';

	?>

	<article class="story block target story-type-<?php echo $story_type;?>">
		<div class="story-header story-header-<?php echo $story_type;?>">
			<div class="story-hero">
				<?php 
				switch ($story_type) {
					case 'video': ?>
						<div class="story-video-container">	
							<div class="story-video">				
								<?php
								$vimeo_id = '93171956';
								echo vimeo_frame($vimeo_id,'story-video-1'); 
								?>
							</div>
							<div class="story-video-poster">
								<img src="<?php bloginfo('template_directory');?>/assets/img/empathy.jpg" />
							</div>
							<div class="story-video-play" data-toggle="tooltip" data-placement="top" title="watch the video!">
								<span class="icon" data-icon="Ò"></span>
							</div>
						</div>
					<?php break;

					case 'image_gallery': ?>



					<?php break;

					case 'video_gallery': ?>



					<?php break;

					case 'video_and_image_gallery': ?>



					<?php break;						

					default: ?>
						
					<?php break;

				} 
				?>
			</div>
			<div class="story-meta centered">
				<div class="container">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
							<h1 class="m0 bold serif story-heading">Empathy</h1>
							<h5 class="m0 hidden">Communicating Science Through Visual Media</h5>
							<h2 class="m1">This course focused on producing short animations to communicate the science side of empathy.</h2>
							<h5 class="m0">Taught by John Stein and Steven Subotnick</h5>
							<h5 class="m0">Spring 2013</h5>
							<h5 class="m0"><a class="underline" href="http://brown.edu">http://brown.edu</a></h5>
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="story-body">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1">
					<p>
			Course Description: This class, offered jointly by professors at RISD and Brown and in partnership with the Science Center and the Creative Mind Initiative, will explore and develop the pedagogy of using visual media to convey scientific concepts. There is a growing library of online content but often times it is not well suited for seamless adoption into educational use. The goal of this course will be to assess examples of existing material and design new material that not only fills an educational need but makes science engaging and accessible. Class time will be comprised of lectures, labs, screenings, discussions, critiques and guest speakers. After an introduction to science teaching pedagogy and the basics of animation and visual design, small student teams with a balance of science and art backgrounds will collaborate on a series of short exercises leading to the creation of final videos or animations that explain scientific concepts. Concept selection will be based on filling an identified educational need, where a satisfactory example does not yet exist and where the topic benefits from a visual presentation. Student groups will be paired with faculty mentors from the life or physical sciences to design visual media that is appropriate for a particular audience. Projects will be evaluated on scientific accuracy, clarity of explanation, meeting the educational need, and originality of approach. The developed skills of lesson plan design along with writing, recording, animating and editing short educational videos will give students experience within the growing field of visual supplements to traditional learning. RISD students have the option to take this course either for studio or liberal arts credit.
			</p>

			<p>
			RISD students and Brown students worked together in small teams under the guidance of instructors, John Stein and Steven Subotnick, with additional assistance from outside mentor, David Targan.
			</p>

		</div>
	</article>

	<?php // get_template_part('partials/break'); ?>