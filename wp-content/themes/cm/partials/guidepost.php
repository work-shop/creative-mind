
	<section class="block guidepost" id="guidepost">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h2 class="serif bold centered mb1">
					Explore the Creative Mind!
					</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 sign">
					<a href="<?php bloginfo('url');?>/about">
						<h3 class="serif bold centered brand">
						About the Creative Mind
						</h3>
						<h4 class="centered">
						Learn more about our growing initiative to capture creativity at Brown University.
						</h4>
					</a>
				</div>

				<?php
				$target = 2;
				$cat = ($id = get_the_ID() ) ? CM_Collection_Controller::get_category_for_collection( $id ) : CM_Collection_Controller::get_current_category();
				$cats = array_filter( get_categories(), function( $x ) { return $x->name != "Uncategorized"; });
				shuffle( $cats );

				foreach ($cats as $i => $category) {
					if ( $i >= $target ) break;
					if ( $cat && $category->term_id == $cat->term_id ) {
						$target += 1;
						continue;
					}

					set_global('x_category_slug', $category->slug);
					set_global('x_category_name', $category->name );
					set_global('x_category_description', CM_Collection_Controller::get_category_description( $category->term_id ) );

					get_template_part('partials/guidepost_tile');

					unset_global('x_category_slug' );
					unset_global('x_category_name' );
					unset_global('x_category_description' );
				}

				?>

			</div>			
		</div>
	</section>