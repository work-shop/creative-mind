<?php
  /**
   * @var stdClass $category the current category we're in.
   */
  $category = CM_Collection_Controller::get_current_category();

  /**
   * get an array of relevant categories for the nav
   *
   * @var array(stdClass) $categories an array of taxonomy terms.
   */
  $categories = array_filter( get_terms('category'), function( $x ) {
    return $x->term_id != 1;
  } );

?>

      <section id="megaNav" class="closed">
        <div class="container-fluid">

        <?php foreach ($categories as $category ) { ?>

          <div class="row white bg-<?php echo $category->slug; ?>-dark">

            <div class="col-sm-1 header">
              <a class="h3 uppercase bold" href="<?php echo get_term_link( $category ); ?>"><?php echo $category->name; ?></a>
            </div>
            <div class="col-sm-11 bg-<?php echo $category->slug; ?> padded m0">
              <div class="split-list">
                <?php 

                    /**
                     * @var $collections array(array('title' => title, 'id' => id, 'permalink' => permalink )) the set of collections in this category.
                     */
                    $collections = array_map( function( $p ) { return array(
                      'id' => $p->ID,
                      'title' => $p->post_title
                    ); }, CM_Collection_Controller::get_collections_for_category( $category->term_id ) );

                    /**
                     *
                     * @var array $collections_halves contains two arrays, each containing half the collections in a category
                     *
                     */
                    $collections_halves = CM_Collection_Controller::split_array( $collections );

                    echo CM_Collection_Controller::create_list( $collections_halves[0], null, 'menu' ); 
                    echo CM_Collection_Controller::create_list( $collections_halves[1], null, 'menu' ); 

                ?>
              </div>
            </div>

          </div> <!-- end .row -->

        <?php } ?>

          <div class="row mb2">
            <div class="col-sm-12 bold">
              <ul class="list-inline centered mt1">
                <li class="h3"><a href="<?php bloginfo('url'); ?>/about">About the Creative Mind</a></li>
                <li class="h3 ml1"><a href="<?php bloginfo('url'); ?>/contact">Contact Us</a></li>
              </ul>
            </div>
          </div>

        </div> <!-- /.container -->
      </section>
