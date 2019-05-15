 <?php /* Template Name: Landing Page */ ?>
 <?php
 get_header();
 if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="page-content">
      <section>
        <div class="container">
          <div class="hero-banner hero-banner--darker -my-paroller" style="background: url(<?php the_field('header_image', get_option('page_for_posts')); ?>) center -68px / cover no-repeat; " data-paroller-factor="0.3" data-paroller-factor-xs="0.2">
            <div class="hero-banner--text">
              <div class="row justify-content-center">
                <div class="col-lg-8">
                  <h1><?php the_field('tagline', get_option('page_for_posts')); ?></h1>
                  <p><?php the_field('description', get_option('page_for_posts')); ?></p><a class="btn btn-rounded btn-hover btn-main btn-solid p-t-10 p-b-10 p-l-30 p-r-30" rel="nofollow" href="<?php the_field('url', get_option('page_for_posts')); ?>">Contact Us</a>
                </div>
              </div>
            </div><a class="arrow-animated" href="#whyshopwithus" rel="nofollow"></a>
          </div>
          <div class="row justify-content-center m-t-80 m-b-80" id="whyshopwithus">
            <div class="col-lg-8">
              <h2 class="text-center m-b-30"><?php the_field('title_with_us', get_option('page_for_posts')); ?></h2>
              <div class="row">

<?php $wu = get_field('icon_with_us', get_option('page_for_posts')); 

if($wu){

foreach ($wu as $key => $value) { 
?>
                <div class="col-md-4">
                  <div class="center-icon-column">
                    <div class="center-icon-column--img"><img class="img-fluid" src="<?php echo $value['icon'] ?>"></div>
                    <p class="title"><?php echo $value['title'] ?></p>
                    <p class="font-12"><?php echo $value['description'] ?></p>
                  </div>
                </div>
   <?php } } ?>

              </div>
            </div>
          </div>


<?php $f = get_field('featured', get_option('page_for_posts')); 

if($f){

foreach ($f as $key => $value) { 
?>
            
          <div class="hero-banner hero-banner--standard -my-paroller" style="background: url(<?php echo $value['background'] ?>) center -68px / cover no-repeat; " data-paroller-factor="0.3" data-paroller-factor-xs="0.3">
            <div class="hero-banner--text">
              <div class="row justify-content-center m-b-60">
                <div class="col-lg-8 m-b-45">
                  <h1><?php echo $value['tagline_featured'] ?></h1>
                  <p><?php echo $value['description_featured'] ?></p>
                </div>
              </div>
            </div>
          </div>

          <?php if($value['icon_featured']){ ?>

          <div class="row justify-content-center overlap-margin m-b-60">
            <div class="col-lg-8">
              <div class="row justify-content-center">

            <?php foreach ($value['icon_featured'] as $s_key => $s_value) { ?>                
                <div class="col-lg-4"><a class="single-hover-tile" href="<?php echo $s_value['url'] ?>" rel="nofollow">
                  <img class="img-fluid" src="<?php echo $s_value['icon'] ?>">
                    <h2 class="overlay-text"><?php echo $s_value['title'] ?></h2></a>
                  </div>

              <?php } ?>

              </div>
            </div>
          </div>

   <?php  } } } ?>



          <div class="testimonial-area">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-lg-8">
                  <div class="-carousel-testimonial p-t-45">

                          <?php $s = get_field('they_say', get_option('page_for_posts')); 

                          if($s){
                            foreach ($s as $key => $value) {
                              # code...
                            
                           ?>
                                        <div class="testimonial-single">
                                          <p class="font-14 msg">"<?php echo $value['say']; ?>"</p>
                                          <p class="font-14 name m-b-0"><?php echo $value['by']; ?></p>
                                        </div>

                                 <?php } } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <div class="hero-banner hero-banner--darker hero-banner--standard -my-paroller" style="background: url(<?php the_field('background_image_gt', get_option('page_for_posts')); ?>) center -68px / cover no-repeat; ">
                  <div class="hero-banner--text">
                    <div class="row">
                      <div class="col-lg-8 text-left">
                        <h2 class="text-left"><?php the_field('title_gt', get_option('page_for_posts')); ?></h2>
                        <p class="text-left"><?php the_field('description_gt', get_option('page_for_posts')); ?></p><a class="btn btn-rounded btn-hover btn-main btn-solid p-t-10 p-b-10 p-l-30 p-r-30" rel="nofollow" href="<?php the_field('url_gs', get_option('page_for_posts')); ?>">Contact Us</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="container m-t-45 m-b-45">
            <div class="row">
              <div class="col-lg">
 

<?php $q = get_field('list', get_option('page_for_posts')); 

if($q){

foreach ($q as $key => $value) { 
?>                

                <h2 class="m-b-10"><?php echo $value['title']; ?></h2>
                <p class="font-12"><?php echo $value['description']; ?></p>

<?php } } ?>

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