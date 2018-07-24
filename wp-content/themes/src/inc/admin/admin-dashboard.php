<?php


function remove_dashboard_meta() {
/*	remove_action( 'welcome_panel', 'wp_welcome_panel' );*/
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');

}
add_action( 'admin_init', 'remove_dashboard_meta' ); 


function sales_statistics_widget( $post, $callback_args ) {
	include('report/sales-statistics-chart.php');
}
function sales_delivery_status_widget( $post, $callback_args ) {
	include('report/sales-delivery-status.php');
}
function stock_status_widget( $post, $callback_args ) {
	include('report/list-template/list-stock-detail.php');
}
function customer_status_widget( $post, $callback_args ) {
	include('report/customers-report.php');
}
function lot_status_chart_widget( $post, $callback_args ) {
	include('report/lot-chart.php');
}

function add_dashboard_widgets() {
	add_meta_box( 'my_sales_tatistics_widget', 'Sales Statistics', 'sales_statistics_widget', 'dashboard', 'normal', 'high' );
	add_meta_box( 'my_sales_delivery_status_widget', 'Sales Delivery Status', 'sales_delivery_status_widget', 'dashboard', 'side', 'high' );
	add_meta_box( 'my_stock_status_widget', 'Stock Status', 'stock_status_widget', 'dashboard', 'normal', 'low' );
	add_meta_box( 'lot_status_chart_widget', 'Top Sale', 'lot_status_chart_widget', 'dashboard', 'side', 'low' );
	add_meta_box( 'customer_status_widget', 'Customer List', 'customer_status_widget', 'dashboard', 'side', 'low' );
} 
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );






add_action( 'admin_footer', 'billing_dashboard_widget' );
function billing_dashboard_widget() {
	// Bail if not viewing the main dashboard page
	if ( get_current_screen()->base !== 'dashboard' ) {
		return;
	}
	include('report/billing-report.php');
}