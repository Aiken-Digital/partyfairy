<?php

/**
 * WCFMu plugin core
 *
 * WCFM Marketplace Orders Support
 *
 * @author 		WC Lovers
 * @package 	wcfmu/core
 * @version   5.2.0
 */
 
class WCFMu_Orders {
	
	public function __construct() {
    global $WCFMu;
    
    // Orders Manage Query Var Filter
		add_filter( 'wcfm_query_vars', array( &$this, 'wcorder_wcfm_query_vars' ), 20 );
		add_filter( 'wcfm_endpoint_title', array( &$this, 'wcorder_wcfm_endpoint_title' ), 20, 2 );
		add_action( 'init', array( &$this, 'wcorder_wcfm_init' ), 20 );
		
		add_filter( 'wcfm_menus', array( &$this, 'wcorder_wcfm_menus' ), 20 );
		
		// Order Edit Button
		add_action( 'after_wcfm_orders_details_items', array( &$this, 'wcorder_order_edit_button' ), 50, 3 );
		
		// Generate Order Edit Form Html
    add_action('wp_ajax_wcfm_edit_order_form_html', array( &$this, 'wcorder_order_edit_form_html' ) );
		
		// Orders Quick Action - Add Order
		add_action( 'wcfm_orders_quick_actions', array( &$this, 'wcorder_order_manage' ) );
		add_action( 'wcfm_after_order_quick_actions', array( &$this, 'wcorder_order_manage' ) );
		
		// Orders Manage Load WCFMu Scripts
		add_action( 'wcfm_load_scripts', array( &$this, 'wcorder_load_scripts' ), 30 );
		add_action( 'after_wcfm_load_scripts', array( &$this, 'wcorder_load_scripts' ), 30 );
		
		// Orders Manage Load WCFMu Styles
		add_action( 'wcfm_load_styles', array( &$this, 'wcorder_load_styles' ), 30 );
		add_action( 'after_wcfm_load_styles', array( &$this, 'wcorder_load_styles' ), 30 );
		
		// Orders Manage Load WCFMu views
		add_action( 'wcfm_load_views', array( &$this, 'wcorder_load_views' ), 30 );
		
		// Orders Manage Custom Add Link
		add_action( 'wcfm_orders_manage_after_customers_list',array( &$this, 'wcorder_add_customer_link' ), 40 );
		
		// Generate Orders Manage Custom Add Html
    add_action('wp_ajax_wcfm_order_add_customer_html', array( &$this, 'wcfm_order_add_customer_html' ) );
    
    // Get Customer Address
    add_action('wp_ajax_wcfm_orders_manage_customer_address', array( &$this, 'wcfm_orders_manage_customer_address' ) );
    
    // Orders Manage Add Customer Ajax Controllers
		add_action( 'after_wcfm_ajax_controller', array( &$this, 'wcorder_ajax_controller' ), 30 );
    
  }
  
  /**
   * Order Manage Query Var
   */
  function wcorder_wcfm_query_vars( $query_vars ) {
  	$wcfm_modified_endpoints = (array) get_option( 'wcfm_endpoints' );
  	
		$query_orders_vars = array(
			'wcfm-orders-manage'       => ! empty( $wcfm_modified_endpoints['wcfm-orders-manage'] ) ? $wcfm_modified_endpoints['wcfm-orders-manage'] : 'orders-manage',
		);
		
		$query_vars = array_merge( $query_vars, $query_orders_vars );
		
		return $query_vars;
  }
  
  /**
   * Order Manage End Point Title
   */
  function wcorder_wcfm_endpoint_title( $title, $endpoint ) {
  	global $wp;
  	switch ( $endpoint ) {
			case 'wcfm-orders-manage' :
				$title = __( 'Create Order', 'wc-frontend-manager-ultimate' );
			break;
  	}
  	
  	return $title;
  }
  
  /**
   * Order Manage Endpoint Intialize
   */
  function wcorder_wcfm_init() {
  	global $WCFM_Query;
	
		// Intialize WCFM End points
		$WCFM_Query->init_query_vars();
		$WCFM_Query->add_endpoints();
		
		if( !get_option( 'wcfm_updated_end_point_wc_orderss' ) ) {
			// Flush rules after endpoint update
			flush_rewrite_rules();
			update_option( 'wcfm_updated_end_point_wc_orderss', 1 );
		}
  }
  
  /**
   * Order Manage Menu
   */
  function wcorder_wcfm_menus( $menus ) {
  	global $WCFM;
  	
		$menus['wcfm-orders'] = array( 'label'  => __( 'Orders', 'wc-frontend-manager'),
																	 'url'        => get_wcfm_orders_url(),
																	 'icon'       => 'shopping-cart',
																	 'has_new'    => 'yes',
																	 'new_class'  => 'wcfm_sub_menu_items_order_manage',
																	 'new_url'    => get_wcfm_manage_order_url(),
																	 'capability' => 'wcfm_is_allow_orders',
																	 'submenu_capability' => 'wcfm_is_allow_manage_order',
																	 'priority'   => 35
																	);
  	return $menus;
  }
  
  /**
   * Orders Edit Button
   */
  function wcorder_order_edit_button( $order_id, $order, $line_items ) {
  	global $WCFM, $WCFMu;
  	
  	$order_status = sanitize_title( $order->get_status() );
		if( in_array( $order_status, apply_filters( 'wcfm_edit_order_status', array( 'failed', 'cancelled', 'refunded', 'processing', 'completed' ) ) ) ) return;
  	
		echo '<br /><a class="wcfm_order_edit_request add_new_wcfm_ele_dashboard" href="#" data-order="' . $order_id . '"><span class="fa fa-pencil text_tip"></span><span class="text">' . __( 'Edit Order', 'wc-frontend-manager-ultimate' ) . '</span></a>';
  }
  
  /**
   * Order Edit Form HTML
   */
  function wcorder_order_edit_form_html() {
  	global $WCFM, $WCFMu, $_POST;
  	if( isset( $_POST['order_id'] ) && !empty( $_POST['order_id'] ) ) {
  		$WCFMu->template->get_template( 'orders/wcfmu-view-orders-edit-popup.php', array( 'order_id' => sanitize_text_field( $_POST['order_id'] ) ) );
  	}
  	die;
  }
  
  /**
   * Orders Dashaboard Manage Order Link
   */
  function wcorder_order_manage( $order_id = '' ) {
  	echo '<a id="add_new_order_dashboard" class="add_new_wcfm_ele_dashboard text_tip" href="'.get_wcfm_manage_order_url().'" data-tip="' . __('Add New Order', 'wc-frontend-manager-ultimate') . '"><span class="fa fa-cart-plus"></span><span class="text">' . __( 'Add New', 'wc-frontend-manager') . '</span></a>';
  }
  
  /**
   * Order Manage Scripts
   */
  public function wcorder_load_scripts( $end_point ) {
	  global $WCFM, $WCFMu;
    
	  switch( $end_point ) {
      case 'wcfm-orders-manage':
      	$WCFM->library->load_select2_lib();
      	$WCFM->library->load_collapsible_lib();
	    	wp_enqueue_script( 'wcfm_orders_manage_js', $WCFMu->library->js_lib_url . 'orders/wcfmu-script-orders-manage.js', array('jquery'), $WCFMu->version, true );
	    	
	    	// Localized Script
        $wcfm_messages = get_wcfm_orders_manage_messages();
			  wp_localize_script( 'wcfm_orders_manage_js', 'wcfm_orders_manage_messages', $wcfm_messages );
      break;
	  }
	}
	
	/**
   * Order Manage Styles
   */
	public function wcorder_load_styles( $end_point ) {
	  global $WCFM, $WCFMu;
		
	  switch( $end_point ) {
	  	case 'wcfm-orders-manage':
	  		wp_enqueue_style( 'wcfm_orders_manage_css',  $WCFMu->library->css_lib_url . 'orders/wcfmu-style-orders-manage.css', array(), $WCFMu->version );
	  	break;
	  }
	}
	
	/**
   * Order Manage Views
   */
  public function wcorder_load_views( $end_point ) {
	  global $WCFM, $WCFMu;
	  
	  switch( $end_point ) {
      case 'wcfm-orders-manage':
        $WCFMu->template->get_template( 'orders/wcfmu-view-orders-manage.php' );
      break;
	  }
	}
	
	function wcorder_add_customer_link() {
		global $WCFM, $WCFMu;
		?>
		<div class="wcfm_order_add_new_customer_box">
		  <p class="description wcfm_full_ele wcfm_order_add_new_customer">+<?php _e( 'Add new customer', 'wc-frontend-manager-ultimate' ); ?></p>
		</div>
		<?php
	}
	
	function wcfm_order_add_customer_html() {
		global $WCFM, $WCFMu;
		
		include_once( $WCFMu->plugin_path . 'views/orders/wcfmu-view-orders-add-customer.php' );
		die;
	}
	
	/**
	 * Load Customer Address
	 */
	function wcfm_orders_manage_customer_address() {
		global $WCFM, $WCFMu;
		
		$customer_address = array();
		$customer_id      = absint( $_POST['customer_id'] );
		
		if( $customer_id ) {
			$wcfm_order_billing_fields = array( 
																					'billing_first_name'  => 'bfirst_name',
																					'billing_last_name'   => 'blast_name',
																					'billing_phone'       => 'bphone',
																					'billing_address_1'   => 'baddr_1',
																					'billing_address_2'   => 'baddr_2',
																					'billing_country'     => 'bcountry',
																					'billing_city'        => 'bcity',
																					'billing_state'       => 'bstate',
																					'billing_postcode'    => 'bzip'
																				);
			
			foreach( $wcfm_order_billing_fields as $wcfm_order_default_key => $wcfm_order_default_field ) {
				$customer_address[$wcfm_order_default_field] = get_user_meta( $customer_id, $wcfm_order_default_key, true );
			}
			
			$wcfm_order_shipping_fields = array( 
																					'shipping_first_name'  => 'sfirst_name',
																					'shipping_last_name'   => 'slast_name',
																					'shipping_address_1'   => 'saddr_1',
																					'shipping_address_2'   => 'saddr_2',
																					'shipping_country'     => 'scountry',
																					'shipping_city'        => 'scity',
																					'shipping_state'       => 'sstate',
																					'shipping_postcode'    => 'szip'
																				);
			
			foreach( $wcfm_order_shipping_fields as $wcfm_order_default_key => $wcfm_order_default_field ) {
				$customer_address[$wcfm_order_default_field] = get_user_meta( $customer_id, $wcfm_order_default_key, true );
			}
			
		}
		
		wp_send_json( $customer_address );
	}
	
	/**
   * Order Manage Ajax Controllers
   */
  public function wcorder_ajax_controller() {
  	global $WCFM, $WCFMu;
  	
  	$controllers_path = $WCFMu->plugin_path . 'controllers/orders/';
  	
  	$controller = '';
  	if( isset( $_POST['controller'] ) ) {
  		$controller = $_POST['controller'];
  		
  		switch( $controller ) {
  			case 'wcfm-orders-manage-add-customer':
					include_once( $controllers_path . 'wcfmu-controller-orders-manage-add-customer.php' );
					new WCFMu_Orders_Manage_Customer_Add_Controller();
				break;
				
				case 'wcfm-orders-manage':
					include_once( $controllers_path . 'wcfm-controller-orders-manage.php' );
					new WCFMu_Orders_Manage_Controller();
				break;
				
				case 'wcfm-orders-edit':
					include_once( $controllers_path . 'wcfm-controller-orders-edit.php' );
					new WCFMu_Orders_Edit_Controller();
				break;
  		}
  	}
  }
}