 <?php /* Template Name: AboutUs Page */ ?>
 <?php
 get_header();
 if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="page-content">
      <section class="account">
        <div class="container m-b-30">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
          </nav>
          <div class="hero-banner hero-banner--standard" style="background: url(<?php echo get_template_directory_uri(); ?>/assets/imgs/about-us.jpg) center right / cover no-repeat;"></div>
          <div class="row no-gutters">
            <div class="col-lg-6">
              <div class="row justify-content-center p-t-60 p-b-60 align-items-center h-100">
                <div class="col-lg-10">
                  <div class="center-icon-column">
                    <div class="center-icon-column--img"><img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/imgs/magicstick-icon.png"></div>
                    <p class="title">We’re Your Party-Everything Store</p>
                    <p class="font-12">Forget Googling your life away each time you have to plan a party. Party Fairy was created to make party planning a breeze. We do that by scouring Singapore for the best party people and having them sell their wares right here.</p>
                    <p class="font-12">From big things like photo booth backdrops and balloon sculptures, to small things like candles and disposable cutlery, and essential things like cakes, food, decorations, goodie bags, party favours and so, so much more, we’ve got them all at one stop.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6"><img class="img-fluid w-100" src="<?php echo get_template_directory_uri(); ?>/assets/imgs/about-us-1.jpg"></div>
          </div>
          <div class="row flex-column-reverse flex-lg-row no-gutters">
            <div class="col-lg-6"><img class="img-fluid w-100" src="<?php echo get_template_directory_uri(); ?>/assets/imgs/about-us-2.jpg"></div>
            <div class="col-lg-6">
              <div class="row justify-content-center p-t-60 p-b-60 align-items-center h-100">
                <div class="col-lg-10">
                  <div class="center-icon-column">
                    <div class="center-icon-column--img"><img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/imgs/balloon-icon.svg"></div>
                    <p class="title">We Take Things Personally</p>
                    <p class="font-12">It’s not what you think. (We’re nice, promise!). Rather, we know when it comes to parties, personalised gifts and décor are the icing on the cake. That’s why at Party Fairy, you’ll see heaps and heaps of products you can customise and personalise to your heart’s content.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row no-gutters">
            <div class="col-lg-6">
              <div class="row justify-content-center p-t-60 p-b-60 align-items-center h-100">
                <div class="col-lg-10">
                  <div class="center-icon-column">
                    <div class="center-icon-column--img"><img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/imgs/magicstick-icon.png"></div>
                    <p class="title">We Make Every Step Of Party Planning Easy-Peasy</p>
                    <p class="font-12">Not all of us are naturally gifted with Martha Stewart skills but that does not mean you can’t throw a party like her. Party Fairy has curated bundles that fit every theme, occasion and vibe so you don’t need to figure out what goes with what. Prices are transparent (no need to negotiate or ask for a quotation) so planning your party is stress-free and seamless.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6"><img class="img-fluid w-100" src="<?php echo get_template_directory_uri(); ?>/assets/imgs/about-us-3.jpg"></div>
          </div>
        </div>
      </section>
    </div>

<?php endwhile; else: ?>
                <center><article><h3>Sorry, no posts matched your criteria</h3></article></center>
<?php endif; ?>

<?php get_footer(); ?>