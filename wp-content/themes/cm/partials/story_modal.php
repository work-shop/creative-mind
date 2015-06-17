<?php
/**
 *
 *
 *
 */
?>
<div id="story-modal" class="inactive">

	<div class="stories-nav hidden-xs">
		<a id="previous-story-link" href="#" class="prev-story"><span class="icon" data-icon="&#8216;">
			<div class="preview centered" style="background-image:url('')">
				<div class="overlay">
					<span class="icon-custom" data-icon="&#xe600;"></span>
					<h3 class="bold story-heading centered"></h3>
				</div>
			</div>
		</span></a>

		<a id="next-story-link" href="#" class="next-story"><span class="icon" data-icon="—">
			<div class="preview centered" style="background-image:url('')">
				<div class="overlay">
					<span class="icon-custom" data-icon="&#xe600;"></span><!-- Change this to the Next Arrow! -->
					<h3 class="bold story-heading centered"></h3>
				</div>
			</div>
		</span></a>
	</div>

	<?php
	/**
	 * This is where the content for the story goes.
	 */
	?>
	<div id="current-story"></div>
</div>