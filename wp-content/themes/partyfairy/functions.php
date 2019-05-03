<?php

//require_once( get_template_directory() . '/acf.php' );




function add_theme_scripts() {
  
  wp_enqueue_style( 'style', get_stylesheet_uri()); 
  wp_enqueue_style( 'app_css', get_template_directory_uri() . '/assets/css/app.css', array(), '1.1', 'all');
  
  wp_enqueue_script( 'vendor', get_template_directory_uri() . '/assets/js/vendors.js', array ( 'jquery' ), 1.1, true);
  wp_enqueue_script( 'app_js', get_template_directory_uri() . '/assets/js/app.js', array ( 'jquery' ), 1.1, true);
  
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



add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 1;
  return $cols;
}

