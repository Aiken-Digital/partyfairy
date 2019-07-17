<?php
/**
 * WCFM plugin view
 *
 * Marketplace WCfM Marketplace Support
 * This template can be overridden by copying it to yourtheme/wcfm/dashboard/
 *
 * @author 		WC Lovers
 * @package 	wcfm/views/dashboard
 * @version   5.0.0
 */
 
global $WCFMmp, $WCFM, $wpdb;

$user_id = $current_user_id = apply_filters( 'wcfm_current_vendor_id', get_current_user_id() );

// Get products using a query - this is too advanced for get_posts :(
$stock          = absint( max( get_option( 'woocommerce_notify_low_stock_amount' ), 1 ) );
$nostock        = absint( max( get_option( 'woocommerce_notify_no_stock_amount' ), 0 ) );

$query_from = apply_filters( 'wcfm_report_low_in_stock_query_from', "FROM {$wpdb->posts} as posts
	INNER JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id
	INNER JOIN {$wpdb->postmeta} AS postmeta2 ON posts.ID = postmeta2.post_id
	WHERE 1=1
	AND posts.post_type IN ( 'product', 'product_variation' )
	AND posts.post_status = 'publish'
	AND posts.post_author = {$user_id}
	AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes'
	AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) <= '{$stock}'
	AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) > '{$nostock}'
", $stock, $nostock );
$lowinstock_count = absint( $wpdb->get_var( "SELECT COUNT( DISTINCT posts.ID ) {$query_from};" ) );

$query_from = apply_filters( 'wcfm_report_out_of_stock_query_from', "FROM {$wpdb->posts} as posts
	INNER JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id
	INNER JOIN {$wpdb->postmeta} AS postmeta2 ON posts.ID = postmeta2.post_id
	WHERE 1=1
	AND posts.post_type IN ( 'product', 'product_variation' )
	AND posts.post_status = 'publish'
	AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes'
	AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) <= '{$nostock}'
", $nostock );

$outofstock_count = absint( $wpdb->get_var( "SELECT COUNT( DISTINCT posts.ID ) {$query_from};" ) );

$today_date = @date('Y-m-d');
$admin_fee_mode = apply_filters( 'wcfm_is_admin_fee_mode', false );

$wcfm_dashboard_sales_interval = apply_filters( 'wcfm_dashboard_sales_interval', 'month' );

// Total Sales Amount
$gross_sales = $WCFM->wcfm_vendor_support->wcfm_get_gross_sales_by_vendor( $current_user_id, $wcfm_dashboard_sales_interval );

// Total Earned Commission
$earned = $WCFM->wcfm_vendor_support->wcfm_get_commission_by_vendor( $current_user_id, $wcfm_dashboard_sales_interval );

// Admin Fee Mode Commission
if( $admin_fee_mode ) {
	$earned = $gross_sales - $earned;
}

// Total Received Commission
//$commission = $WCFM->wcfm_vendor_support->wcfm_get_commission_by_vendor( $current_user_id, 'month', true );

// Total item sold
$total_sell = $WCFM->wcfm_vendor_support->wcfm_get_total_sell_by_vendor( $current_user_id, $wcfm_dashboard_sales_interval );

// Counts
$order_count = 0;
$on_hold_count    = 0;
$processing_count = 0;

$sql = "SELECT commission.order_id, commission.order_status FROM {$wpdb->prefix}wcfm_marketplace_orders AS commission";
$sql .= " WHERE 1=1";
$sql .= " AND commission.vendor_id = %d";
$sql .= " AND `is_refunded` != 1 AND `is_trashed` != 1";
$sql  = wcfm_query_time_range_filter( $sql, 'created', $wcfm_dashboard_sales_interval ); 
$sql .= " GROUP BY commission.order_id";

$vendor_orders = $wpdb->get_results( $wpdb->prepare( $sql, $user_id ) );
if( !empty($vendor_orders) ) {
	$order_count = apply_filters( 'wcfmmp_dashboard_vendor_order_count', count( $vendor_orders ), $vendor_orders, $user_id );
	foreach( $vendor_orders as $vendor_order ) {
		// Order exists check
		$order_post_title = get_the_title( $vendor_order->order_id );
		if( !$order_post_title ) continue;
		if( $vendor_order->order_id ) {
			if( $vendor_order->order_status == 'processing' ) $processing_count++;
			if( $vendor_order->order_status == 'on-hold' ) $on_hold_count++;
		}
	}
}

// unfulfilled_products
$unfulfilled_products = 0;
$sql  = "SELECT  COUNT(DISTINCT(commission.order_id)) FROM {$wpdb->prefix}wcfm_marketplace_orders AS commission";
$sql .= " WHERE 1=1";
$sql .= " AND commission.vendor_id = %d";
$sql .= " AND commission.shipping_status = 'pending'";
$sql  = wcfm_query_time_range_filter( $sql, 'created', $wcfm_dashboard_sales_interval ); 

$unfulfilled_products = $wpdb->get_var( $wpdb->prepare( $sql, $user_id ) );
if( !$unfulfilled_products ) $unfulfilled_products = 0;

if( $wcfm_is_allow_reports = apply_filters( 'wcfm_is_allow_reports', true ) ) {
	include_once( $WCFM->plugin_path . 'includes/reports/class-wcfmmarketplace-report-sales-by-date.php' );
	$wcfm_report_sales_by_date = new WCFM_Marketplace_Report_Sales_By_Date( 'month' );
	$wcfm_report_sales_by_date->calculate_current_range( 'month' );
	$report_data   = $wcfm_report_sales_by_date->get_report_data();
}

// WCFM Analytics
if( $wcfm_is_allow_analytics = apply_filters( 'wcfm_is_allow_analytics', true ) ) {
	include_once( $WCFM->plugin_path . 'includes/reports/class-wcfm-report-analytics.php' );
	$wcfm_report_analytics = new WCFM_Report_Analytics();
	$wcfm_report_analytics->chart_colors = apply_filters( 'wcfm_report_analytics_chart_colors', array(
				'view_count'       => '#C79810',
			) );
	$wcfm_report_analytics->calculate_current_range( '7day' );
}

?>

<div class="collapse wcfm-collapse" id="wcfm_order_details">

  <div class="wcfm-page-headig">
		<span class="wcfmfa fa-chalkboard"></span>
		<span class="wcfm-page-heading-text"><?php _e( 'Dashboard', 'wc-frontend-manager' ); ?></span>
		<?php do_action( 'wcfm_page_heading' ); ?>
	</div>
	<div class="wcfm-collapse-content">
		<div id="wcfm_page_load"></div>
		
		<?php do_action( 'begin_wcfm_dashboard' ); ?>
		
		<?php $WCFM->template->get_template( 'dashboard/wcfm-view-dashboard-welcome-box.php' ); ?>
		
		<?php if( apply_filters( 'wcfm_is_pref_stats_box', true ) ) { ?>
			<div class="wcfm_dashboard_stats">
				<?php if( $wcfm_is_allow_reports = apply_filters( 'wcfm_is_allow_reports', true ) ) { ?>
					<?php if( apply_filters( 'wcfm_sales_report_is_allow_gross_sales', true ) && apply_filters( 'wcfm_is_allow_stats_block_gross_sales', true ) ) { ?>
						<div class="wcfm_dashboard_stats_block">
							<a href="<?php echo get_wcfm_reports_url( 'month' ); ?>">
								<span class="wcfmfa fa-currency"><?php echo get_woocommerce_currency_symbol() ; ?></span>
								<div>
									<strong><?php echo apply_filters( 'wcfm_vendor_dashboard_gross_sales', wc_price( $gross_sales ) ); ?></strong><br />
									<?php _e( 'gross sales in this month', 'wc-frontend-manager' ); ?>
								</div>
							</a>
						</div>
					<?php } ?>
					<?php do_action( 'wcfm_dashboard_stats_block_after_gross_sales', $user_id ); ?>
					<?php if( apply_filters( 'wcfm_is_allow_view_commission', true ) && apply_filters( 'wcfm_is_allow_stats_block_commission', true ) ) { ?>
						<div class="wcfm_dashboard_stats_block">
							<a href="<?php echo get_wcfm_reports_url( ); ?>">
								<span class="wcfmfa fa-money fa-money-bill-alt"></span>
								<div>
									<strong><?php echo apply_filters( 'wcfm_vendor_dashboard_commission', wc_price( $earned ) ); ?></strong><br />
									<?php if( $admin_fee_mode ) { _e( 'admin fees in this month', 'wc-frontend-manager' ); } else { _e( 'earnings in this month', 'wc-frontend-manager' ); } ?>
								</div>
							</a>
						</div>
					<?php } ?>
					<?php do_action( 'wcfm_dashboard_stats_block_after_commission', $user_id ); ?>
					<?php if( apply_filters( 'wcfm_is_allow_stats_block_sold_item', true ) ) { ?>
						<div class="wcfm_dashboard_stats_block">
							<a href="<?php echo apply_filters( 'sales_by_product_report_url', get_wcfm_reports_url( ), '' ); ?>">
								<span class="wcfmfa fa-cube"></span>
								<div>
									<?php printf( _n( "<strong>%s item</strong>", "<strong>%s items</strong>", $total_sell, 'wc-frontend-manager' ), $total_sell ); ?>
									<br /><?php _e( 'sold in this month', 'wc-frontend-manager' ); ?>
								</div>
							</a>
						</div>
					<?php } ?>
					<?php do_action( 'wcfm_dashboard_stats_block_after_sold_item', $user_id ); ?>
				<?php } ?>
				<?php if( apply_filters( 'wcfm_is_allow_orders', true ) && apply_filters( 'wcfm_is_allow_stats_block_orders', true ) ) { ?>
					<div class="wcfm_dashboard_stats_block">
						<a href="<?php echo get_wcfm_orders_url( ); ?>">
							<span class="wcfmfa fa-cart-plus"></span>
							<div>
								<?php printf( _n( "<strong>%s order</strong>", "<strong>%s orders</strong>", $order_count, 'wc-frontend-manager' ), $order_count ); ?>
								<br /><?php _e( 'received in this month', 'wc-frontend-manager' ); ?>
							</div>
						</a>
					</div>
				<?php } ?>
				<?php do_action( 'wcfm_dashboard_stats_block_after_orders', $user_id ); ?>
			</div>
			<div class="wcfm-clearfix"></div>
		<?php } ?>
		<?php do_action( 'wcfm_after_dashboard_stats_box', $user_id ); ?>
		
		<?php if( $wcfm_is_allow_reports = apply_filters( 'wcfm_is_allow_reports', true ) ) { ?>
			<div class="wcfm_dashboard_wc_reports_sales">
				<div class="wcfm-container">
					<div id="wcfm_dashboard_wc_reports_expander_sales" class="wcfm-content">
						<div id="poststuff" class="woocommerce-reports-wide">
							<div class="postbox">
								<div class="inside">
									<a class="chart_holder_anchor" href="<?php echo get_wcfm_reports_url( 'month' ); ?>">
										<?php $wcfm_report_sales_by_date->get_main_chart(0); ?>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="wcfm-clearfix"></div>
		<?php } ?>
		
		<!-- collapsible -->
		<div class="wcfm_dashboard_wc_status">
			<div class="wcfm_dashboard_wc_status_data">
			
				
				<?php if ( !is_wcfm_analytics() || WCFM_Dependencies::wcfma_plugin_active_check() ) { ?>
					<div class="wcfm_dashboard_wcfm_product_stats">
						<div class="page_collapsible" id="wcfm_dashboard_wcfm_product_status"><span class="wcfmfa fa-cubes"></span><span class="dashboard_widget_head"><?php _e('Product Stats', 'wc-frontend-manager'); ?></span></div>
						<div class="wcfm-container">
							<div id="wcfm_dashboard_wcfm_product_stats_expander" class="wcfm-content">
								 <?php if ( current_user_can( 'edit_products' ) && apply_filters( 'wcfm_is_allow_manage_products', true ) ) { ?>
								 <a class="chart_holder_anchor" href="<?php echo get_wcfm_products_url( ); ?>">
								 <?php } ?>
									 <div id="product_stats-report"><canvas id="product_stats_report-canvas"></canvas></div>	
								 <?php if ( current_user_can( 'edit_products' ) && apply_filters( 'wcfm_is_allow_manage_products', true ) ) { ?>
								 </a>
								 <?php } ?>
							</div>
						</div>
					</div>
				<?php } ?>
				
				<?php do_action( 'after_wcfm_dashboard_product_stats' ); ?>
	
			</div>
			
			<?php do_action( 'after_wcfm_dashboard_left_col' ); ?>
			
			<div class="wcfm_dashboard_wc_status_graph">
			  
		
			  <?php if( apply_filters( 'wcfm_is_allow_reports', true ) && apply_filters( 'wcfm_is_allow_sales_by_product_reports', true ) ) { ?>
			  	
					<div class="wcfm_dashboard_wc_reports_pie">
						<div class="page_collapsible" id="wcfm_dashboard_wc_reports_pie"><span class="wcfmfa fa-chart-pie"></span><span class="dashboard_widget_head"><?php _e('Sales by Product', 'wc-frontend-manager'); ?></span></div>
						<div class="wcfm-container">
							<div id="wcfm_dashboard_wc_reports_expander_pie" class="wcfm-content">
								<a class="chart_holder_anchor" href="<?php echo apply_filters( 'sales_by_product_report_url',  get_wcfm_reports_url( ), ( $top_seller ) ? $top_seller->product_id : '' ); ?>">
										<div id="sales-piechart"><canvas id="sales-piechart-canvas"></canvas></div>
									</a>
							</div>
						</div>
					</div>
					
				  <?php do_action('after_wcfm_dashboard_sales_report'); ?>
				<?php } ?>
				
				<?php if ( is_wcfm_analytics() && WCFM_Dependencies::wcfma_plugin_active_check() ) { ?>
					<?php if ( $wcfm_is_allow_analytics = apply_filters( 'wcfm_is_allow_analytics', true ) ) { ?>
						<div class="wcfm_dashboard_wcfm_region_stats">
							<div class="page_collapsible" id="wcfm_dashboard_wcfm_region_status"><span class="wcfmfa fa-globe"></span><span class="dashboard_widget_head"><?php _e('Top Regions', 'wc-frontend-manager'); ?></span></div>
							<div class="wcfm-container">
								<div id="wcfm_dashboard_wcfm_region_stats_expander" class="wcfm-content">
									 <a class="chart_holder_anchor" href="<?php echo get_wcfm_analytics_url( 'month' ); ?>">
										 <div id="wcfm_world_map_analytics_view"></div>
										 <?php
										 global $WCFMa;
										 $WCFMa->library->world_map_analytics_data(); 
										 ?>
									 </a>
								</div>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
				
		
				
			</div>
			<?php do_action( 'after_wcfm_dashboard_right_col' ); ?>
		</div>
	</div>
</div>