<?php



/** 
* @snippet       Set Custom Order Status during Checkout
* @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055 
* @sourcecode    https://businessbloomer.com/?p=77911
* @author        Rodolfo Melogli 
* @compatible    WooCommerce 3.5.4
* @donate $9     https://businessbloomer.com/bloomer-armada/
*/

// ---------------------
// 1. Register Order Status

add_filter( 'woocommerce_register_shop_order_post_statuses', 'bbloomer_register_custom_order_status' );

function bbloomer_register_custom_order_status( $order_statuses ){

   // Status must start with "wc-"
	$order_statuses['wc-pending'] = array(                                 
		'label'                     => _x( 'Pending', 'Order status', 'woocommerce' ),
		'public'                    => false,                                 
		'exclude_from_search'       => false,                                 
		'show_in_admin_all_list'    => true,                                 
		'show_in_admin_status_list' => true,                                 
		'label_count'               => _n_noop( 'Pending <span class="count">(%s)</span>', 'Pending <span class="count">(%s)</span>', 'woocommerce' ),                              
	);      
	return $order_statuses;
}

// ---------------------
// 2. Show Order Status in the Dropdown @ Single Order and "Bulk Actions" @ Orders

add_filter( 'wc_order_statuses', 'bbloomer_show_custom_order_status' );

function bbloomer_show_custom_order_status( $order_statuses ) {      
	$order_statuses['wc-pending'] = _x( 'Pending', 'Order status', 'woocommerce' );       
	return $order_statuses;
}

add_filter( 'bulk_actions-edit-shop_order', 'bbloomer_get_custom_order_status_bulk' );

function bbloomer_get_custom_order_status_bulk( $bulk_actions ) {
   // Note: "mark_" must be there instead of "wc"
	$bulk_actions['mark_pending'] = 'Change status to pending';
	return $bulk_actions;
}



// ---------------------
// 3. Set Custom Order Status @ WooCommerce Checkout Process

add_action( 'woocommerce_thankyou', 'bbloomer_thankyou_change_order_status' );

function bbloomer_thankyou_change_order_status( $order_id ){
	if( ! $order_id ) return;
	$order = wc_get_order( $order_id );

   // Status without the "wc-" prefix
	$order->update_status( 'pending' );
}






// Register a custom order status
//add_action('init', 'register_custom_order_statuses');
function register_custom_order_statuses() {
	register_post_status('wc-accept ', array(
		'label' => __( 'Accept', 'woocommerce' ),
		'public' => true,
		'exclude_from_search' => false,
		'show_in_admin_all_list' => true,
		'show_in_admin_status_list' => true,
		'label_count' => _n_noop('Accept <span class="count">(%s)</span>', 'Accept <span class="count">(%s)</span>')
	));
}


// Add a custom order status to list of WC Order statuses
//add_filter('wc_order_statuses', 'add_custom_order_statuses');
function add_custom_order_statuses($order_statuses) {
	$new_order_statuses = array();

    // add new order status before processing
	foreach ($order_statuses as $key => $status) {
		$new_order_statuses[$key] = $status;
		if ('wc-processing' === $key) {
			$new_order_statuses['wc-accept'] = __('Accept', 'woocommerce' );
		}
	}
	return $new_order_statuses;
}


// Adding custom status 'awaiting-delivery' to admin order list bulk dropdown
//add_filter( 'bulk_actions-edit-shop_order', 'custom_dropdown_bulk_actions_shop_order', 50, 1 );
function custom_dropdown_bulk_actions_shop_order( $actions ) {
	$new_actions = array();

    // add new order status before processing
	foreach ($actions as $key => $action) {
		if ('mark_processing' === $key)
			$new_actions['mark_accept'] = __( 'Change status to accept', 'woocommerce' );

		$new_actions[$key] = $action;
	}
	return $new_actions;
}

// Add a custom order status action button (for orders with "processing" status)
add_filter( 'woocommerce_admin_order_actions', 'add_custom_order_status_actions_button', 100, 2 );
function add_custom_order_status_actions_button( $actions, $order ) {
    // Display the button for all orders that have a 'processing', 'pending' or 'on-hold' status
	if ( $order->has_status( array( 'pending' ) ) ) { //'on-hold', 'processing', 

        // The key slug defined for your action button
	$action_slug = 'processing';

        // Set the action button
	$actions[$action_slug] = array(
		'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status='.$action_slug.'&order_id='.$order->get_id() ), 'woocommerce-mark-order-status' ),
		'name'      => __( 'Accept', 'woocommerce' ),
		'action'    => $action_slug,
	);
}
return $actions;
}



add_action('init', 'register_custom_order_statuses_processed');
function register_custom_order_statuses_processed() {
	register_post_status('wc-processed', array(
		'label' => __( 'Processed', 'woocommerce' ),
		'public' => true,
		'exclude_from_search' => false,
		'show_in_admin_all_list' => true,
		'show_in_admin_status_list' => true,
		'label_count' => _n_noop('Processed <span class="count">(%s)</span>', 'Processed <span class="count">(%s)</span>')
	));
}





add_filter('wc_order_statuses', 'add_custom_order_statuses_processed');
function add_custom_order_statuses_processed($order_statuses) {
	$new_order_statuses = array();

    // add new order status before processing
	foreach ($order_statuses as $key => $status) {
		$new_order_statuses[$key] = $status;
		if ('wc-processing' === $key) {
			$new_order_statuses['wc-processed'] = __('Processed', 'woocommerce' );
		}
	}
	return $new_order_statuses;
}




add_filter( 'bulk_actions-edit-shop_order', 'custom_dropdown_bulk_actions_shop_order_processed', 50, 1 );
function custom_dropdown_bulk_actions_shop_order_processed( $actions ) {
	$new_actions = array();

    // add new order status before processing
	foreach ($actions as $key => $action) {
		if ('mark_processing' === $key)
			$new_actions['mark_processed'] = __( 'Change status to processed', 'woocommerce' );

		$new_actions[$key] = $action;
	}
	return $new_actions;
}



// Add a custom order status action button (for orders with "processing" status)
add_filter( 'woocommerce_admin_order_actions', 'add_custom_order_status_processed', 100, 2 );
function add_custom_order_status_processed( $actions, $order ) {
    // Display the button for all orders that have a 'processing', 'pending' or 'on-hold' status
	if ( $order->has_status( array( 'processing' ) ) ) { //'on-hold', 'processing', 

        // The key slug defined for your action button
	$action_slug = 'processed';

        // Set the action button
	$actions[$action_slug] = array(
		'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status='.$action_slug.'&order_id='.$order->get_id() ), 'woocommerce-mark-order-status' ),
		'name'      => __( 'Processed', 'woocommerce' ),
		'action'    => $action_slug,
	);
}
return $actions;
}


/////////////////

add_filter( 'woocommerce_admin_order_actions', 'add_custom_order_status_actions_button_decline', 100, 2 );
function add_custom_order_status_actions_button_decline( $actions, $order ) {
    // Display the button for all orders that have a 'processing', 'pending' or 'on-hold' status
	if ( $order->has_status( array(  'pending' ) ) ) {

        // The key slug defined for your action button
		$action_slug = 'cancelled';

        // Set the action button
		$actions[$action_slug] = array(
			'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status='.$action_slug.'&order_id='.$order->get_id() ), 'woocommerce-mark-order-status' ),
			'name'      => __( 'Decline', 'woocommerce' ),
			'action'    => $action_slug,
		);
	}
	return $actions;
}


////

// Set styling for custom order status action button icon and List icon
add_action( 'admin_head', 'add_custom_order_status_actions_button_css' );
function add_custom_order_status_actions_button_css() {
	?>
	<style>

		a.button.wc-action-button.wc-action-button-processing.processing::after {
			content: none !important;
		}

		a.button.wc-action-button.wc-action-button-processing.processing  {
			background-color: #86c40d !important;
			color: #f9f9f9 !important;
			text-indent: inherit;
			width: 50px !important;
			text-align: center;
			border: none !important;
		}



		a.button.wc-action-button.wc-action-button-processed.processed::after {
			content: none !important;
		}

		a.button.wc-action-button.wc-action-button-processed.processed  {
			background-color: #86c40d !important;
			color: #f9f9f9 !important;
			text-indent: inherit;
			width: 70px !important;
			text-align: center;
			border: none !important;
		}



		a.button.wc-action-button.wc-action-button-cancelled.cancelled::after {
			content: none !important;
		}

		a.button.wc-action-button.wc-action-button-cancelled.cancelled  {
			background-color: #da0943 !important;
			color: #f9f9f9 !important;
			text-indent: inherit;
			width: 50px !important;
			text-align: center;
			border: none !important;
		}

		a.button.wc-action-button.wc-action-button-complete.complete {
			display: none;
		</style>
		<?php
	}

////



	function misha_remove_order_statuses( $wc_statuses_arr ){
		global $pagenow;


    // Enable the process to be executed daily when browsing Admin order list 


		$order = wc_get_order( get_the_ID() );

		if(is_a( $order, 'WC_Order') ) {
			if ($order->get_status() == 'pending') {

		// Processing
		if( isset( $wc_statuses_arr['wc-processing'] ) ) { // if exists
			//unset( $wc_statuses_arr['wc-processing'] ); // remove it from array
		}
		if( isset( $wc_statuses_arr['wc-processed'] ) ) { // if exists
		//unset( $wc_statuses_arr['wc-processing'] ); // remove it from array
		}
	// Refunded
		if( isset( $wc_statuses_arr['wc-refunded'] ) ){
			unset( $wc_statuses_arr['wc-refunded'] );
		}
	// On Hold
		if( isset( $wc_statuses_arr['wc-on-hold'] ) ){
			unset( $wc_statuses_arr['wc-on-hold'] );
		}
	// Failed
		if( isset( $wc_statuses_arr['wc-failed'] ) ){
			unset( $wc_statuses_arr['wc-failed'] );
		}
	// Pending payment
		if( isset( $wc_statuses_arr['wc-pending'] ) ){
			unset( $wc_statuses_arr['wc-pending'] );
		}

	// Cancelled
		if( isset( $wc_statuses_arr['wc-cancelled'] ) ){
		//unset( $wc_statuses_arr['wc-cancelled'] );
		}

	// Completed
		if( isset( $wc_statuses_arr['wc-completed'] ) ){
			unset( $wc_statuses_arr['wc-completed'] );
		}


	}

}
	return $wc_statuses_arr; // return result statuses

}
//add_filter( 'wc_order_statuses', 'misha_remove_order_statuses' );



