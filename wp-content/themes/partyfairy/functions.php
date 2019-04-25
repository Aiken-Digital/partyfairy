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

