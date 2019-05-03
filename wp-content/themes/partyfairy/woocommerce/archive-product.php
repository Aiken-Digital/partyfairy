<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$queried_object = get_queried_object();

$term_id 		= $queried_object->term_id;

$the_query = new WP_Query( array(
    'post_type' => 'product',
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $term_id
        )
    )
) );
$count_post = $the_query->found_posts;

?>

    <div class="page-content">
      <section>
        <div class="container">
<?php 
//do_action( 'woocommerce_before_main_content' );

 ?>

             <?php 
              $args = array(
                'delimiter'   => '',
                'wrap_before' => '<ol class="breadcrumb">',
                'wrap_after'  => '</ol>',
                'before'      => '<li class="breadcrumb-item">',
                'after'       => '</li>'
            );
            woocommerce_breadcrumb($args); ?>

		<div class="row">

	<?php






/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */




/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	//do_action( 'woocommerce_before_shop_loop' );

	//woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {


  			 $thumbnail_id = get_woocommerce_term_meta( $term_id, 'thumbnail_id', true );
	    	$image = wp_get_attachment_url( $thumbnail_id );
		?>
		<div class="col-lg-10">

		        <div class="row">
                <div class="col-12">
                  <div class="innner-banner"><img class="img-fluid w-100" src="<?php echo $image ?>"></div>
                  <div class="inner-page-title m-b-0 lg-m-b-30">
                    <h2><?php echo $queried_object->name; ?> <span class="font-12">(<?php echo $count_post ?> total)</span></h2>
                    <div class="toolbar-sorter sorter d-none d-lg-block">
                      <label class="sorter-label" for="sorter">Sort By</label>
                      <select class="sorter-options" data-role="sorter">
                        <option value="position">Position</option>
                        <option value="name" selected="selected">Product Name</option>
                        <option value="price">Price</option>
                      </select><a class="sorter-action sort-asc" title="Set Descending Direction" href="#" data-role="direction-switcher" data-value="desc"></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="m-filter d-lg-none">
                <div class="filter-by m-filter-child -active-filter-by">Filter By </div>
                <div class="sort-by m-filter-child">Sort By</div>
              </div>

              <div class="row tiles">
		<?php


		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}

		?>
			</div>
		<?php
	}

	//woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */

	echo '<div class="row">';
		echo '<div class="col-12 pf-paging">';

	do_action( 'woocommerce_after_shop_loop' );

		echo '</div>';
	echo '</div>';



	echo '</div>'; //class="col-lg-10"

} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
//do_action( 'woocommerce_sidebar' );

?>
		</div>
        </div>
      </section>
    </div>

    <?php

get_footer( 'shop' );
