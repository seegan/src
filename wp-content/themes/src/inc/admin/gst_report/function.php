<?php

require get_template_directory() . '/inc/admin/gst_report/class-report.php';

function load_report_scripts() {
	wp_enqueue_script( 'billing-scriptss', get_template_directory_uri() . '/inc/admin/gst_report/inc/js/gst_report.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_report_scripts' );
function stock_report() {
	$report = new report();
	include( get_template_directory().'/admin/report/ajax_loading/stock-list.php' );
	die();	
}
add_action( 'wp_ajax_stock_report', 'stock_report' );
add_action( 'wp_ajax_nopriv_stock_report', 'stock_report' );


function stock_report_acc() {
	$report = new report();
	include( get_template_directory().'/admin/report/ajax_loading/stock-list-accountant.php' );
	die();	
}
add_action( 'wp_ajax_stock_report_acc', 'stock_report_acc' );
add_action( 'wp_ajax_nopriv_stock_report_acc', 'stock_report_acc' );

function return_report() {
	$report = new report();
	include( get_template_directory().'/admin/report/ajax_loading/return-list.php' );
	die();	
}
add_action( 'wp_ajax_return_report', 'return_report' );
add_action( 'wp_ajax_nopriv_return_report', 'return_report' );



function cgst_sale_filter_list() {
	$report = new report();
	include('ajax_loading/cgst-list-accountant.php');
	die();
}
add_action( 'wp_ajax_cgst_sale_filter_list', 'cgst_sale_filter_list' );
add_action( 'wp_ajax_nopriv_cgst_sale_filter_list', 'cgst_sale_filter_list' );


function igst_sale_filter_list() {
	$report = new report();
	include('ajax_loading/igst-list-accountant.php');
	die();
}
add_action( 'wp_ajax_igst_sale_filter_list', 'igst_sale_filter_list' );
add_action( 'wp_ajax_nopriv_igst_sale_filter_list', 'igst_sale_filter_list' );


function cgst_sale_return_filter_list() {
	$report = new report();
	include('ajax_loading/cgst-return-report.php');
	die();
}
add_action( 'wp_ajax_cgst_sale_return_filter_list', 'cgst_sale_return_filter_list' );
add_action( 'wp_ajax_nopriv_cgst_sale_return_filter_list', 'cgst_sale_return_filter_list' );

function igst_sale_return_filter_list() {
	$report = new report();
	include('ajax_loading/igst-return-report.php');
	die();
}
add_action( 'wp_ajax_igst_sale_return_filter_list', 'igst_sale_return_filter_list' );
add_action( 'wp_ajax_nopriv_igst_sale_return_filter_list', 'igst_sale_return_filter_list' );




?>

