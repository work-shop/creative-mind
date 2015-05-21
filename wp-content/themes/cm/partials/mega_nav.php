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

<div class="modal fade" id="megaNav" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <section class="block">
        <div class="container-fluid">

        <?php foreach ($categories as $category ) { ?>

        <div class="row white bg-<?php echo $category->slug; ?>-dark">

        <div class="col-sm-1">
          <header class="bold">
            <h4 class="uppercase"><a href="<?php echo get_term_link( $category ); ?>"><?php echo $category->name; ?></a></h4>
          </header>
        </div>
        <div class="col-sm-11 bg-<?php echo $category->slug; ?> padded-less m0">
          <div class="row">
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

          <div class="row">
            <div class="col-sm-12 bold">
              <ul class="list-inline centered mt1">
                <li class="h4"><a href="<?php bloginfo('url'); ?>/about">About the Creative Mind</a></li>
                <li class="h4 ml1"><a href="<?php bloginfo('url'); ?>/contact">Contact Us</a></li>
              </ul>
            </div>
          </div>

        </div> <!-- /.container -->
      </section>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
