<?php get_header();
if (have_posts()) : while (have_posts()) : the_post(); ?>



    <div class="page-content">
      <section class="account">
        <div class="container m-b-30">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?php echo home_url() ?>">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php the_title() ?></li>
            </ol>
          </nav>
          <div class="hero-banner hero-banner--standard" style="background: url(<?php the_field('header_image', get_option('page_for_posts')); ?>) center right / cover no-repeat;"></div>
          <div class="row m-t-60 m-b-60 justify-content-center">
            <div class="col-lg-12">
      <?php the_content() ?>
            </div>
          </div>
        </div>
      </section>
    </div>

        </div>
      </section>
    </div>



<?php endwhile; else: ?>
                <center><article><h3>Sorry, no posts matched your criteria</h3></article></center>
<?php endif; ?>

<?php get_footer(); ?>