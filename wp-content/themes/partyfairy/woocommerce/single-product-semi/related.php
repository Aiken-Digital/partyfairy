<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



$terms = wp_get_post_terms(get_the_ID(), 'product_tag');
if ($terms) {
	$output = array();
	foreach ($terms as $term) {
		$output[] = $term->term_id;
	}




	$args = array( 
		'post_type'   => 'product', 
		'post_status' => 'publish',
		'post__not_in' => array(get_the_ID() ),
		'posts_per_page' => 10,
		'orderby'        => 'rand',
	);

	$args['tax_query'] = array(

		array(
			'taxonomy' => 'product_tag',
			'field'    => 'id',
			'terms'    => $output,


		)
	);


	$product_image = new WP_Query($args); 


	if ( $product_image->have_posts() ) : 

		?>          
		<div class="mightlike-wrap m-b-30">
			<div class="row">
				<div class="col-12">
					<h2 class="text-center">You Might Also Like...</h2>
				</div>
			</div>
			<div class="-carousel p-t-45">



				<?php 

				while ( $product_image->have_posts() ) : $product_image->the_post(); 
					global $product; 
					$product = wc_get_product( get_the_ID());
					?>

					<div class="tiles-box p-l-15 p-r-15"><a class="tiles--single" href="<?php the_permalink() ?> ?>">
						<div class="tiles--single--img border-line"><img class="img-fluid" src="<?php if ( has_post_thumbnail() ) {the_post_thumbnail_url('full'); } else { echo get_template_directory_uri().'/images/broken/img-not-available-landscape.png'; } ?>"></div><a class="tiles--single--achor font-12" href=""><?php the_title() ?></a></a>
						<div class="tiles--quatity font-normal"><?php $price = $product->get_price();  if($price){ echo 'FROM $'.$price; } ?></div>
					</div>

				<?php endwhile; wp_reset_postdata(); else :?> 

			</div>
		</div>

	<?php  endif;  } ?>
