 <?php /* Template Name: Page Store Manager */ ?>
 <?php
 get_header();
 if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="page-content">
      <section>
        <div id="checkout" class="container">

<?php the_content() ?>
</div>
</section>
</div>
 	<?php endwhile; else: ?>
                <center><article><h3>Sorry, no posts matched your criteria</h3></article></center>
<?php endif; ?>

<?php get_footer(); ?>