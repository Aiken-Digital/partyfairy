<?php
/*
 *Plugin Name: Simple Cache and Uncache Script
 *Plugin URI: http://www.tonjoo.com/uncache-script/
 *Description: Uncache your script / css after plugin update.
 *Version: 1.2.0
 *Author: Todi
 *Author URI: http://todiadiyatmo.com/
 *License: GPLv2
 *
*/

defined('ABSPATH' ) OR exit;
define("US_VERSION", '1.2.0');
define('UNCACHE_SCRIPT_DIR',plugin_dir_path( __FILE__ ) );

add_filter( 'script_loader_src', 'tonjoo_scu_script',10,2);
add_filter( 'style_loader_src', 'tonjoo_scu_script',10,2);

function tonjoo_scu_script($src,$handle)
{

    $version = get_option('tonjoo_uncache_script_version');

    if(!$version)
    {
       $version = 1;
    }

    $src = remove_query_arg('ver',$src);

    return add_query_arg( array('scu_version'=>$version), $src );
}

function tonjoo_scu_activated()
{
    if ( ! current_user_can( 'activate_plugins' ) )
        return;
    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
    check_admin_referer( "activate-plugin_{$plugin}" );

    # Uncomment the following line to see the function in action
    // exit( var_dump( $_GET ) );
}

register_activation_hook(   __FILE__, 'tonjoo_scu_activated' );

function tonjoo_scu_deactivated()
{
    if ( ! current_user_can( 'activate_plugins' ) )
        return;
    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
    check_admin_referer( "deactivate-plugin_{$plugin}" );

    # Uncomment the following line to see the function in action
    # exit( var_dump( $_GET ) );
}

register_deactivation_hook( __FILE__, 'tonjoo_scu_deactivated' );

function tonjoo_scu_uninstall()
{
   if ( ! current_user_can( 'activate_plugins' ) )
        return;
    check_admin_referer( 'bulk-plugins' );

    // Important: Check if the file is the one
    // that was registered during the uninstall hook.
    if ( __FILE__ != WP_UNINSTALL_PLUGIN )
        return;

    # Uncomment the following line to see the function in action
    # exit( var_dump( $_GET ) );
}

register_uninstall_hook( __FILE__, 'tonjoo_scu_uninstall' );

include UNCACHE_SCRIPT_DIR.'/us-theme-options.php';

add_action( 'admin_bar_menu', 'make_parent_node', 999 );
function make_parent_node( $wp_admin_bar ) {
	$args = array(
		'id'     => 'uncache-script-toolbar',
		'title'  => 'Uncache Script',
		'parent' => false,
	);
	$wp_admin_bar->add_node( $args );

  $argsx = array(
		'id'     => 'uncache-script-toolbar-child',
		'title'  => 'Uncache',
    'href'  =>  '/wp-admin/options-general.php?page=uncache-script/us-theme-options.php&act=update',
		'parent' => 'uncache-script-toolbar',
	);
	$wp_admin_bar->add_node( $argsx );
}
