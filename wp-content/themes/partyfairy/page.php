<?php get_header();
if (have_posts()) : while (have_posts()) : the_post(); ?>


<?php the_content() ?>

<?php endwhile; else: ?>
                <center><article><h3>Sorry, no posts matched your criteria</h3></article></center>
<?php endif; ?>

<?php get_footer(); ?>