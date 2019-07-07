 <?php /* Template Name: 404 Page */ ?>
 <?php
 get_header();
 if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="page-content">
      <section class="account">
        <div class="container m-b-30">
          <div class="row no-gutters justify-content-center p-t-120 p-b-120">
            <div class="col-lg-3">
              <div class="d-flex justify-content-center m-b-30"><img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/imgs/magic-rabbit.png"></div>
            </div>
            <div class="col-lg-3">
              <div class="text-center">
                <h1 class="bold m-b-40">Error 404</h1>
                <h2 class="m-b-15">Oops! The page you requested for doesn't exist. There is only a rabbit.</h2><a class="btn btn-hover btn-main btn-solid p-t-10 p-b-10 p-l-15 p-r-15" href="<?php echo home_url() ?>">TAKE ME HOME!</a>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-lg-2">
              <div class="d-flex justify-content-center align-items-center flex-column text-center">
                <div class="m-b-15" style="width: 100px;"><img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/imgs/pf-logo.png"></div>
                <p class="font-12">Copyright © 2019 Party Fairy Pte Ltd</p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

<?php endwhile; else: ?>
                <center><article><h3>Sorry, no posts matched your criteria</h3></article></center>
<?php endif; ?>

<?php get_footer(); ?>