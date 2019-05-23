<?php
add_filter( 'deprecated_function_trigger_error', '__return_false' );
require_once( get_template_directory() . '/acf.php' );



function pagination_bar( $query_wp, $paged) 
{

	$pages = $query_wp->max_num_pages;


    $big = 999999999; // need an unlikely integer
    if ($pages > 1)
    {
    	$page_current = max(1, $paged);
    	echo paginate_links(array(
    		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    		'format' => '?paged=%#%',
    		'current' => $page_current,
    		'total' => $pages,
    	));
    }
}



function pagination_bar_ajax( $query_wp, $paged) 
{

	$pages = $query_wp;


    $big = 999999999; // need an unlikely integer
    if ($pages > 1)
    {
    	$page_current = max(1, $paged);
    	echo paginate_links(array(
    		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    		'format' => '?paged=%#%',
    		'current' => $page_current,
    		'total' => $pages,
    	));
    }
}





add_filter('show_admin_bar', '__return_false');

function add_theme_scripts() {

	wp_enqueue_style( 'style', get_stylesheet_uri()); 
	wp_enqueue_style( 'app_css_x', get_template_directory_uri() . '/assets/css/app.css', array(), '1.1', 'all');

	wp_enqueue_script( 'vendor_X', get_template_directory_uri() . '/assets/js/vendors.js', array ( 'jquery' ), 1.1, true);
	wp_enqueue_script( 'app_js_x', get_template_directory_uri() . '/assets/js/app.js', array ( 'jquery' ), 1.1, true);
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/custom.js', array ( 'jquery' ), 1.1, true);

}

add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title'  => 'Theme General Settings',
		'menu_title'  => 'Theme Settings',
		'menu_slug'   => 'theme-general-settings',
		'capability'  => 'edit_posts',
		'redirect'    => false
	));

}

function wpse_setup_theme() {

	add_theme_support('post-thumbnails');
	add_theme_support( 'woocommerce' );

}

add_action( 'after_setup_theme', 'wpse_setup_theme' );


add_action( 'woocommerce_single_product_summary', 'party_show_sku', 5 );
function party_show_sku(){
	global $product;
	echo 'SKU NO.: ' . $product->get_sku();
}



function partyfairy_main_sidebar() {
	register_sidebar(
		array (
			'name' => __( 'Party Fairy Sidebar', 'partyfairy' ),
			'id' => 'partyfairy-side-bar',
			'description' => __( '', 'partyfairy' ),
			'before_widget' => '<div class="widget-content">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'partyfairy_main_sidebar' );



///woocommerce


add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
	$cols = 1;
	return $cols;
}


///https://iconicwp.com/blog/add-custom-cart-item-data-woocommerce/
/**
 * Add engraving text to cart item.
 *
 * @param array $cart_item_data
 * @param int   $product_id
 * @param int   $variation_id
 *
 * @return array
 */



function iconic_add_engraving_text_to_cart_item( $cart_item_data, $product_id, $variation_id ) {
	$engraving_text = filter_input( INPUT_POST, 'personalise-text' );
	$date_delivery  = filter_input( INPUT_POST, 'date-delivery' );
	$time_delivery  = filter_input( INPUT_POST, 'time-delivery' );
	$date_pickup    = filter_input( INPUT_POST, 'date-pickup' );
	$time_pickup    = filter_input( INPUT_POST, 'time-pickup' );

    // if ( empty( $engraving_text ) ) {
    //     return $cart_item_data;
    // }
    // if ( empty( $date_delivery ) ) {
    //     return $cart_item_data;
    // }
    // if ( empty( $time_delivery ) ) {
    //     return $cart_item_data;
    // }    
    // if ( empty( $date_pickup ) ) {
    //     return $cart_item_data;
    // }    
    // if ( empty( $time_pickup ) ) {
    //     return $cart_item_data;
    // }

	$cart_item_data['personalise-text'] = $engraving_text;
	$cart_item_data['date-delivery'] = $date_delivery;
	$cart_item_data['time-delivery'] = $time_delivery;
	$cart_item_data['date-pickup'] = $date_pickup;
	$cart_item_data['time-pickup'] = $time_pickup;


	return $cart_item_data;
}

add_filter( 'woocommerce_add_cart_item_data', 'iconic_add_engraving_text_to_cart_item', 10, 3 );




/**
 * Display engraving text in the cart.
 *
 * @param array $item_data
 * @param array $cart_item
 *
 * @return array
 */
function iconic_display_engraving_text_cart( $item_data, $cart_item ) {
    // if ( empty( $cart_item['personalise-text'] ) ) {
    //     return $item_data;
    // }
    // if ( empty( $cart_item['date-delivery'] ) ) {
    //     return $item_data;
    // }
    // if ( empty( $cart_item['time-delivery'] ) ) {
    //     return $item_data;
    // }    
    // if ( empty( $cart_item['date-pickup'] ) ) {
    //     return $item_data;
    // }    
    // if ( empty( $cart_item['time-pickup'] ) ) {
    //     return $item_data;
    // }

	$item_data[] = array(
		'key'     => __( 'Personalise', 'personalisetext' ),
		'value'   => wc_clean( $cart_item['personalise-text'] ),
		'display' => '',
	);

	$item_data[] = array(
		'key'     => __( 'Delivery', 'delivery' ),
		'value'   => wc_clean( $cart_item['date-delivery'].' / '.$cart_item['time-delivery'] ),
		'display' => '',
	);    
	$item_data[] = array(
		'key'     => __( 'Pickup', 'Pickup' ),
		'value'   => wc_clean( $cart_item['date-pickup'].' / '.$cart_item['time-pickup'] ),
		'display' => '',
	);

	return $item_data;
}

add_filter( 'woocommerce_get_item_data', 'iconic_display_engraving_text_cart', 10, 2 );



/**
 * Add engraving text to order.
 *
 * @param WC_Order_Item_Product $item
 * @param string                $cart_item_key
 * @param array                 $values
 * @param WC_Order              $order
 */
function iconic_add_engraving_text_to_order_items( $item, $cart_item_key, $values, $order ) {
	if ( empty( $values['personalise-text'] ) ) {
		return;
	}

	$item->add_meta_data( __( 'Personalise', 'personalisetext' ), $values['personalise-text'] );
	$item->add_meta_data( __( 'Delivery', 'deliverytext' ), $values['date-delivery'].' / '.$values['time-delivery']  );
	$item->add_meta_data( __( 'Pickup', 'pickuptext' ),  $values['date-pickup'].' / '.$values['time-pickup'] );

}

add_action( 'woocommerce_checkout_create_order_line_item', 'iconic_add_engraving_text_to_order_items', 10, 4 );


// define the woocommerce_single_variation callback 
function action_woocommerce_single_variation(  ) { 
  // make action magic happen here...

remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20); // REMOVING ADD TO CART BUTTON FROM VARIATIONS

}; 

// add the action 
add_action( 'woocommerce_single_variation', 'action_woocommerce_single_variation', 10, 0 ); 


////////////////////////////////////// FILTER



function filter_category_function(){



	$paged        = ( $_GET['paged'] ) ? $_GET['paged'] : 1;
	$tampilkan    = 12;
	$cur_page     = $paged;
	$page        -= 1;
	$per_page     = $tampilkan;
	$previous_btn = true;
	$next_btn     = true;
	$first_btn    = false;
	$last_btn     = false;
	$start        = $page * $per_page;

	$args = array(

		'order'           => 'DESC',
		'post_type'       => 'product',
		'posts_per_page'  => $tampilkan,
		'post_status'     => 'publish',
		'paged'           => $paged,
  //   'tax_query' => array(
  //     'relation' => 'AND',
  //          array(
  //       'taxonomy'  => 'product-category-cookware',
  //       'field'     => 'id',
  //       'terms'     => $_GET['category'],
  //       'operator' => 'IN',

  //     ),
  //             array(
  //         'taxonomy' => 'product-color-cookware',
  //         'field'    => 'id',
  //         'terms'    => $_GET['color'],
  //         'operator' => 'IN',

  //       ),
  //          array(
  //         'taxonomy'  => 'product-material-cookware',
  //         'field'     => 'id',
  //         'terms'     => $_GET['material'],
  //         'operator' => 'IN',

  //         )   

  //   )
	);




	if( isset( $_GET['category'] ) )
		$args['tax_query'] = array(

			array(
				'taxonomy'  => 'product-cat',
				'field'     => 'id',
				'terms'     => $_GET['category'],

			)
		);

	if( isset( $_GET['color'] ) )
		$args['tax_query'] = array(

			array(
				'taxonomy' => 'pa_color',
				'field'    => 'id',
				'terms'    => $_GET['color'],


			)
		);





	$query = new WP_Query( $args );
// echo '<pre>';
// print_r($query);
// echo '</pre>';

	$args_all = array(
    'order'         => 'DESC', //$_POST['date'] // ASC or DESC
    'post_type'     => 'product',
    'posts_per_page' => 999999,
    'post_status'   => 'publish',

);


	if( isset( $_GET['category'] ) )
		$args_all['tax_query'] = array(
			array(
				'taxonomy'  => 'product_cat',
				'field'     => 'id',
				'terms'     => $_GET['category'],

			)
		);

	if( isset( $_GET['color'] ) )
		$args_all['tax_query'] = array(

			array(
				'taxonomy' => 'pa_color',
				'field'    => 'id',
				'terms'    => $_GET['color']
			)
		);





	$query_all = new WP_Query( $args_all );
	$jumlah = $query_all->post_count;
	$no_of_paginations = ceil($jumlah / $per_page);

	?>

	<div class="row">

		<?php
		global $product; 
		global $post; 


		if( $query->have_posts() ) :
			while( $query->have_posts() ): $query->the_post(); 
				$author_id = $post->post_author; 


				$link =  do_shortcode('[wcfm_store_info id="'.$author_id.'" data="store_url"]');
				preg_match_all('/<a[^>]+href=([""])(?<href>.+?)\1[^>]*>/i', $link, $result_url_vendor); 


				$name = do_shortcode('[wcfm_store_info id="'.$author_id.'" data="store_name"]');
				preg_match_all('|<div[^>]*>(?<name>[^<]+)<|', $name, $result_name_vendor);

				?>

				<div class="col-lg-3 col-md-6 col-6 tiles-box text-center"><a class="tiles--single" href="<?php the_permalink() ?>">
					<div class="tiles--single--img"><img class="img-fluid" src="<?php if ( has_post_thumbnail() ) {the_post_thumbnail_url('full'); } else { echo get_template_directory_uri().'/images/broken/img-not-available-landscape.png'; } ?>"></div><a class="tiles--single--model" href="<?php the_permalink() ?>"><?php the_title() ?></a></a>
					<div class="tiles--price">$<?php echo $product->get_price(); ?><span>each</span></div>
					<div class="tiles--code"><?php echo $product->get_sku(); ?></div><a class="tiles--seller" href="<?php if (!empty($result_url_vendor)) { echo $result_url_vendor['href'][0]; } ?>"><?php if (!empty($result_name_vendor)) { echo $result_name_vendor['name'][0]; } ?></a><a class="btn btn-rounded btn-hover btn-main btn-solid p-t-10 p-b-10 p-l-20 p-r-20 font-11" href="<?php the_permalink() ?>">DETAILS</a>
				</div>



				<?php
			endwhile;
			?>
		</div>


		<div class="page-numbers pt-6 pl-footer" <?php if($no_of_paginations == 1 ) { echo 'style="display:none"';} ?> >
			<input type="hidden" name="paged" value="" id="INJECTPAGE">           
			<div class="page-numbers">



				<?php


				if ($cur_page >= 7) {
					$start_loop = $cur_page - 3;
					if ($no_of_paginations > $cur_page + 3)
						$end_loop = $cur_page + 3;
					else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
						$start_loop = $no_of_paginations - 6;
						$end_loop = $no_of_paginations;
					} else {
						$end_loop = $no_of_paginations;
					}
				} else {
					$start_loop = 1;
					if ($no_of_paginations > 7)
						$end_loop = 7;
					else
						$end_loop = $no_of_paginations;
				}

        // Pagination Buttons logic     
				$pag_container .= "
				<div class='cvf-universal-pagination'>
				<ul>";

				if ($first_btn && $cur_page > 1) {
					$pag_container .= "<li p='1' class='active'>First</li>";
				} else if ($first_btn) {
					$pag_container .= "<li p='1' class='inactive'>First</li>";
				}

				if ($previous_btn && $cur_page > 1) {
					$pre = $cur_page - 1;
					$pag_container .= "<li p='$pre' class='active'>Previous</li>";
				} else if ($previous_btn) {
					$pag_container .= "<li class='inactive'>Previous</li>";
				}
				for ($i = $start_loop; $i <= $end_loop; $i++) {

					if ($cur_page == $i)
						$pag_container .= "<li p='$i' class = 'selected' >{$i}</li>";
					else
						$pag_container .= "<li p='$i' class='active'>{$i}</li>";
				}

				if ($next_btn && $cur_page < $no_of_paginations) {
					$nex = $cur_page + 1;
					$pag_container .= "<li p='$nex' class='active'>Next</li>";
				} else if ($next_btn) {
					$pag_container .= "<li class='inactive'>Next</li>";
				}

				if ($last_btn && $cur_page < $no_of_paginations) {
					$pag_container .= "<li p='$no_of_paginations' class='active'>Last</li>";
				} else if ($last_btn) {
					$pag_container .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
				}

				$pag_container = $pag_container . "
				</ul>
				</div>";

        // We echo the final output
				echo 

				'<div class = "cvf-pagination-nav">' . $pag_container . '</div>';




				?>


			</div>
		</div>

		<script type="text/javascript">

			$('li.active').click(function(e) {
				e.preventDefault();
				var page = $(this).attr('p');
				$('#INJECTPAGE').val(page);
				$('.hasil-ajax').remove();
                    //cvf_load_all_posts(page);
                    
                    $('html, body').animate({
                    	scrollTop: $("#response").offset().top
                    }, 1000);

                    var $form = $(this).closest('form');

                    $form.find('input[type=submit]').click();

                });

            </script>


            <?php
            wp_reset_postdata();
        else :
        	echo '<div class="col-sm-12 col-12 default-post hasil-ajax"><center>
        	<h2>No posts found</h2></center></div>';

        endif;

        die();
    }





    add_action('wp_ajax_filter_category', 'filter_category_function'); 
    add_action('wp_ajax_nopriv_filter_category', 'filter_category_function');





///////////////////////////////////// FILTER