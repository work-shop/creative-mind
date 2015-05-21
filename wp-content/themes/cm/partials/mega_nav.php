<?php
  /**
   * @var stdClass $category the current category we're in.
   */
  $category = CM_Collection_Controller::get_current_category();

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

?>

<div class="modal fade" id="megaNav" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <section class="block">
        <div class="container-fluid">

          <div class="row white bg-courses-dark">

            <div class="col-sm-1">
              <header class="bold">
                <h4 class="uppercase"><a href="<?php bloginfo('url'); ?>/courses">Courses</a></h4>
              </header>
            </div>
            <div class="col-sm-11 bg-courses padded-less m0">
              <div class="row">
                <?php 
                  echo CM_Collection_Controller::create_list( $collections_halves[0], null, 'category' ); 
                  echo CM_Collection_Controller::create_list( $collections_halves[1], null, 'category' ); 
                ?>
              </div>
            </div>
            
          </div> <!-- end .row -->

          <div class="row white bg-research-dark">

            <div class="col-sm-1">
              <header class="bold">
                <h4 class="uppercase"><a href="<?php bloginfo('url'); ?>/research">Research</a></h4>
              </header>
            </div>
            <div class="col-sm-11 bg-research padded-less m0">
              <div class="row">
                <?php 
                  echo CM_Collection_Controller::create_list( $collections_halves[0], null, 'category' ); 
                  echo CM_Collection_Controller::create_list( $collections_halves[1], null, 'category' ); 
                ?>
              </div>
            </div>
            
          </div> <!-- end .row -->

          <div class="row white bg-interviews-dark">

            <div class="col-sm-1">
              <header class="bold">
                <h4 class="uppercase"><a href="<?php bloginfo('url'); ?>/interviews">Interviews</a></h4>
              </header>
            </div>
            <div class="col-sm-11 bg-interviews padded-less m0">
              <div class="row">
                <?php 
                  echo CM_Collection_Controller::create_list( $collections_halves[0], null, 'category' ); 
                  echo CM_Collection_Controller::create_list( $collections_halves[1], null, 'category' ); 
                ?>
              </div>
            </div>
            
          </div> <!-- end .row -->

          <div class="row white bg-lectures-dark">

            <div class="col-sm-1">
              <header class="bold">
                <h4 class="uppercase"><a href="<?php bloginfo('url'); ?>/lectures">Lectures</a></h4>
              </header>
            </div>
            <div class="col-sm-11 bg-lectures padded-less m0">
              <div class="row">
                <?php 
                  echo CM_Collection_Controller::create_list( $collections_halves[0], null, 'category' ); 
                  echo CM_Collection_Controller::create_list( $collections_halves[1], null, 'category' ); 
                ?>
              </div>
            </div>
            
          </div> <!-- end .row -->

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
