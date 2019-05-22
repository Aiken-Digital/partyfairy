<?php
add_filter( 'deprecated_function_trigger_error', '__return_false' );
require_once( get_template_directory() . '/acf.php' );


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
