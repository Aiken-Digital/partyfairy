 <?php /* Template Name: Landing Page */ ?>
 <?php
 get_header();
 if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="page-content">
      <section>
        <div class="container">
          <div class="hero-banner hero-banner--darker -my-paroller" style="background: url(<?php echo get_template_directory_uri()  ?>/assets/imgs/banner.jpg) center -68px / cover no-repeat; " data-paroller-factor="0.3" data-paroller-factor-xs="0.2">
            <div class="hero-banner--text">
              <div class="row justify-content-center">
                <div class="col-lg-8">
                  <h1>Your One-Stop Party Shop</h1>
                  <p>We make Party Planning a breeze. Say goodbye to countless trips to multiple party vendors. You can now enjoy the convenience of getting your party supplies, balloons, entertainment and even cakes all in one place!</p><a class="btn btn-rounded btn-hover btn-main btn-solid p-t-10 p-b-10 p-l-30 p-r-30" href="#">Show more</a>
                </div>
              </div>
            </div><a class="arrow-animated" href="#whyshopwithus"></a>
          </div>
          <div class="row justify-content-center m-t-80 m-b-80" id="whyshopwithus">
            <div class="col-lg-8">
              <h2 class="text-center m-b-30">WHY SHOP WITH US?</h2>
              <div class="row">
                <div class="col-md-4">
                  <div class="center-icon-column">
                    <div class="center-icon-column--img"><img class="img-fluid" src="<?php echo get_template_directory_uri()  ?>/assets/imgs/starpin-icon.png"></div>
                    <p class="title">ONE STOP SHOP</p>
                    <p class="font-12">Choose from over 15,000 party stuff, thematic cakes, party entertainment and more! We’re just getting started	</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="center-icon-column">
                    <div class="center-icon-column--img"><img class="img-fluid" src="<?php echo get_template_directory_uri()  ?>/assets/imgs/mask-icon.png"></div>
                    <p class="title">ONE STOP SHOP</p>
                    <p class="font-12">Our network of specially curated vendors allow us to provide you with a wide variety of party supplies without compromising on quality.</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="center-icon-column">
                    <div class="center-icon-column--img"><img class="img-fluid" src="<?php echo get_template_directory_uri()  ?>/assets/imgs/support-icon.png"></div>
                    <p class="title">CUSTOMER SERVICE</p>
                    <p class="font-12">Our team is dedicated and committed to assist in your party sourcing needs to ensure you have the party of your life!	</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="hero-banner hero-banner--standard -my-paroller" style="background: url(<?php echo get_template_directory_uri()  ?>/assets/imgs/banner-1.jpg) center -68px / cover no-repeat; " data-paroller-factor="0.3" data-paroller-factor-xs="0.3">
            <div class="hero-banner--text">
              <div class="row justify-content-center m-b-60">
                <div class="col-lg-8 m-b-45">
                  <h1>Featured Party Themes</h1>
                  <p>Shop your favourite party themes such as Unicorn, Dinosaur, Princess, and many more. You’re bound to find something you love!</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center overlap-margin m-b-60">
            <div class="col-lg-8">
              <div class="row justify-content-center">
                <div class="col-lg-4"><a class="single-hover-tile" href="#"><img class="img-fluid" src="<?php echo get_template_directory_uri()  ?>/assets/imgs/thumb-1.jpg">
                    <h2 class="overlay-text">UNICORN</h2></a></div>
                <div class="col-lg-4"><a class="single-hover-tile" href="#"><img class="img-fluid" src="<?php echo get_template_directory_uri()  ?>/assets/imgs/thumb-2.jpg">
                    <h2 class="overlay-text">DINOSAUR</h2></a></div>
                <div class="col-lg-4"><a class="single-hover-tile" href="#"><img class="img-fluid" src="<?php echo get_template_directory_uri()  ?>/assets/imgs/thumb-3.jpg">
                    <h2 class="overlay-text">PRINCESS </h2></a></div>
              </div>
            </div>
          </div>
          <div class="hero-banner hero-banner--standard -my-paroller" style="background: url(<?php echo get_template_directory_uri()  ?>/assets/imgs/banner-3.jpg) center -68px / cover no-repeat; " data-paroller-factor="0.3" data-paroller-factor-xs="0.3">
            <div class="hero-banner--text">
              <div class="row justify-content-center m-b-60">
                <div class="col-lg-8 m-b-45">
                  <h1>Featured Party Occasions</h1>
                  <p>Planning a party for a baby shower, or bridal shower or kids birthday? You can now shop for over 40 occasions all under one roof.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center overlap-margin m-b-60">
            <div class="col-lg-8">
              <div class="row justify-content-center">
                <div class="col-lg-4"><a class="single-hover-tile" href="#"><img class="img-fluid" src="<?php echo get_template_directory_uri()  ?>/assets/imgs/thumb-4.jpg">
                    <h2 class="overlay-text">BABY SHOWER</h2></a></div>
                <div class="col-lg-4"><a class="single-hover-tile" href="#"><img class="img-fluid" src="<?php echo get_template_directory_uri()  ?>/assets/imgs/thumb-5.jpg">
                    <h2 class="overlay-text">KIDS BIRTHDAY</h2></a></div>
                <div class="col-lg-4"><a class="single-hover-tile" href="#"><img class="img-fluid" src="<?php echo get_template_directory_uri()  ?>/assets/imgs/thumb-6.jpg">
                    <h2 class="overlay-text">BRIDAL SHOWER </h2></a></div>
              </div>
            </div>
          </div>
          <div class="hero-banner hero-banner--standard -my-paroller" style="background: url(<?php echo get_template_directory_uri()  ?>/assets/imgs/banner-4.jpg) center -68px / cover no-repeat; " data-paroller-factor="0.3" data-paroller-factor-xs="0.3">
            <div class="hero-banner--text">
              <div class="row justify-content-center m-b-60">
                <div class="col-lg-5 m-b-45">
                  <h1>Fulfil Your Party Needs</h1>
                  <p>Lacking something for a perfect party? We got all the A to Z for your party, including entertainment services such as art & craft workshops, balloon sculpting, bouncy castle rental, and even F&B live stations to complete your party.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center overlap-margin m-b-60">
            <div class="col-lg-8">
              <div class="row justify-content-center">
                <div class="col-lg-4"><a class="single-hover-tile" href="#"><img class="img-fluid" src="<?php echo get_template_directory_uri()  ?>/assets/imgs/thumb-7.jpg">
                    <h2 class="overlay-text">BABY SHOWER</h2></a></div>
                <div class="col-lg-4"><a class="single-hover-tile" href="#"><img class="img-fluid" src="<?php echo get_template_directory_uri()  ?>/assets/imgs/thumb-8.jpg">
                    <h2 class="overlay-text">KIDS BIRTHDAY</h2></a></div>
                <div class="col-lg-4"><a class="single-hover-tile" href="#"><img class="img-fluid" src="<?php echo get_template_directory_uri()  ?>/assets/imgs/thumb-9.jpg">
                    <h2 class="overlay-text">BRIDAL SHOWER </h2></a></div>
              </div>
            </div>
          </div>
          <div class="testimonial-area">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-lg-6">
                  <div class="-carousel-testimonial p-t-45">
                                        <div class="testimonial-single">
                                          <p class="font-14 msg">"Got some Halloween decorations and themed cupcakes for my son’s birthday celebration during Halloween. Thankfully, my son’s friends also enjoyed the party and food. Generally a great experience with Party Fairy, especially the service provided. Would recommend to other parents who wants to plan a party but unsure where to look."</p>
                                          <p class="font-14 name m-b-0">MR CHRISTIAN PANG</p>
                                        </div>
                                        <div class="testimonial-single">
                                          <p class="font-14 msg">"Got some Halloween decorations and themed cupcakes for my son’s birthday celebration during Halloween. Thankfully, my son’s friends also enjoyed the party and food. Generally a great experience with Party Fairy, especially the service provided. Would recommend to other parents who wants to plan a party but unsure where to look."</p>
                                          <p class="font-14 name m-b-0">MR CHRISTIAN PANG</p>
                                        </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <div class="hero-banner hero-banner--darker hero-banner--standard -my-paroller" style="background: url(<?php echo get_template_directory_uri()  ?>/assets/imgs/cta-bg.png) center -68px / cover no-repeat; ">
                  <div class="hero-banner--text">
                    <div class="row">
                      <div class="col-lg-8 text-left">
                        <h2 class="text-left">Get Yout Party Started!</h2>
                        <p class="text-left">Planning a party is not an easy feat – You must choose your party theme, balloons and décor, entertainment, food and cakes, and it may seem all too overwhelming at first. But fret not, that’s why we’re here to help. Let’s get your party started!</p><a class="btn btn-rounded btn-hover btn-main btn-solid p-t-10 p-b-10 p-l-30 p-r-30" href="java:void(0);">Show more</a>
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
                <h2 class="m-b-10">Considerations to Make When Finding the Best Party Supplies in Singapore</h2>
                <p class="font-12">For most people, hosting a party is something they love doing. Being in charge of hosting an event like this can be fun and rewarding. A key component in throwing a great shindig is finding the Best party supplies in Singapore.</p>
                <p class="font-12">With all of the suppliers out there, it can be difficult to find the best birthday party supplies for a reasonable price. Trying to rush through this buying process can lead to a number of mistakes being made. Before trying to figure out where to buy party supplies in Singapore, here are some of the things a person will need to consider.</p>
                <h2 class="m-b-10">What Is Needed?</h2>
                <p class="font-12">The first decision a person needs to make before going out to shop is what supplies are needed. Often times, the supplies a person will need for a party will be based on the theme. If a person is hosting a child's birthday party, getting things like balloons and streamers will be essential.</p>
                <p class="font-12">Once a person has decided on a theme for their party, they can get wholesale party supplies to bring their ideas to life. A reputable party supply company will be able to help an individual find the best possible items for their gathering.</p>
                <h2 class="m-b-10">Setting A Budget Is Important</h2>
                <p class="font-12">Before going to shop for party supplies, a person will also need to think about how much money they can logically spend. The last thing anyone wants is to overextend their finances due to a lack of planning. Checking out online store in Singapore for party supplies can help a person get an idea of how much they are going to have to spend on their party.</p>
                <p class="font-12">Online research is also a great way for a person to find the best supplier of party supplies in their area. With the information from a company's website, a person can decide whether or not they are the right fit.</p>
                <p class="font-12">Rushing through this research process can lead to a person paying too much for the party decorations they need. With a bit of time and effort, a person can find what they need and get it delivered in a matter of days.</p>
                <h2 class="m-b-10">Why Party Fairy?</h2>
                <p class="font-12">With Party Fairy - being a one-stop online store for Parties, you will have access to a myriad of party supplies - from delicious cakes to delectable dessert tables, from themed balloons to customised paper plates - We have them all!</p>
                <p class="font-12">So whether you're planning for a small party or a festive gathering - We have you covered! No more travelling all over Singapore to get your ideal decor. No more waiting for countless deliveries from various vendors. Get your party supplies today!</p>
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