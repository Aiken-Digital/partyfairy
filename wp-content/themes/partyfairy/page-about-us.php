 <?php /* Template Name: AboutUs Page */ ?>
 <?php
 get_header();
 if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="page-content">
      <section class="account">
        <div class="container m-b-30">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?php echo home_url() ?>">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
          </nav>
          <div class="hero-banner hero-banner--standard" style="background: url(<?php the_field('header_image', get_option('page_for_posts')); ?>) center right / cover no-repeat;"></div>
          

          <?php 

$data = get_field('data', get_option('page_for_posts'));

if($data){
  foreach ($data as $key => $value) {

    if($key % 2 == 0) {

      ///genap

      ?>

          <div class="row no-gutters">
            <div class="col-lg-6">
              <div class="row justify-content-center p-t-60 p-b-60 align-items-center h-100">
                <div class="col-lg-10">
                  <div class="center-icon-column">
                    <div class="center-icon-column--img"><img class="img-fluid" src="<?php echo $value['icon']; ?>"></div>
                    <p class="title"><?php echo $value['title']; ?></p>
                   <?php echo $value['description']; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6"><img class="img-fluid w-100" src="<?php echo $value['background_image']; ?>"></div>
          </div>

      <?php
    }else {

      //ganjil

      ?>

          <div class="row flex-column-reverse flex-lg-row no-gutters">
            <div class="col-lg-6"><img class="img-fluid w-100" src="<?php echo $value['background_image']; ?>"></div>
            <div class="col-lg-6">
              <div class="row justify-content-center p-t-60 p-b-60 align-items-center h-100">
                <div class="col-lg-10">
                  <div class="center-icon-column">
                    <div class="center-icon-column--img"><img class="img-fluid" src="<?php echo $value['icon']; ?>"></div>
                    <p class="title"><?php echo $value['title']; ?></p>
                    <?php echo $value['description']; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

      <?php
    }


  }
}

          ?>




        </div>
      </section>
    </div>

<?php endwhile; else: ?>
                <center><article><h3>Sorry, no posts matched your criteria</h3></article></center>
<?php endif; ?>

<?php get_footer(); ?>