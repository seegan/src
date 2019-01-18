<?php
add_action('admin_menu', 'admin_menu_register');

function admin_menu_register(){


	global $src_capabilities, $src_premissions;


	add_menu_page(
	    __( 'Stocks', 'src'),
	    'Stocks',
	    $src_premissions['lot_list'],
	    'stock',
	    'list_lots',
	    'dashicons-welcome-widgets-menus',
	    8
	);
	add_submenu_page('stock', 'Lot List', 'Lot List', $src_premissions['lot_list'], 'stock', 'list_lots' );
	add_submenu_page('stock', 'Stock List', 'Stock List', $src_premissions['stock_list'], 'list_stocks', 'list_stocks' );
	add_submenu_page('stock', 'Add Purchase', 'Add Purchase', $src_premissions['stock_list'], 'purchase_add', 'purchase_add' );
	add_submenu_page('stock', 'Add Product Type', 'Add Product Type', $src_premissions['stock_list'], 'ptype_add_list', 'ptype_add_list');


	add_menu_page(
	    __( 'Customers', 'src'),
	    'Customers',
	    $src_premissions['customers'],
	    'customer',
	    'list_customers',
	    'dashicons-groups',
	    8
	);
	add_menu_page(
	    __( 'Admin Users', 'src'),
	    'Admin Users',
	    $src_premissions['add_new_user'],
	    'admin_users',
	    'add_admin_users',
	    'dashicons-id',
	    9
	);


	add_submenu_page('admin_users', 'New Admin User', 'New Admin User', $src_premissions['add_new_user'], 'admin_users', 'add_admin_users' );
	add_submenu_page('admin_users', 'Admin Users List', 'Admin Users List', $src_premissions['user_list'], 'list_admin_users', 'list_admin_users' );
	add_submenu_page('admin_users', 'Admin Roles', 'Admin Roles', 'manage_options', 'list_role', 'list_admin_roles' );
	add_submenu_page('admin_users', 'Add Admin Roles', 'Add Admin Roles', 'manage_options', 'add_role', 'add_admin_roles' );

	add_menu_page(
	    __( 'Sales & Others', 'src'),
	    'Sales & Others',
	    $src_premissions['purchase_sales'],
	    'new_bill',
	    'new_bill',
	    'dashicons-list-view',
	    8
	);
	add_submenu_page('new_bill', 'New Billing', 'New Billing', $src_premissions['purchase_sales'], 'new_bill', 'new_bill' );
	add_submenu_page('new_bill', 'Billing List', 'Billing List', $src_premissions['purchase_sales'], 'sales_others', 'billing_list' );
	add_submenu_page('new_bill', 'Item Delivery', 'Item Delivery', $src_premissions['purchase_sales'], 'bill_delivery', 'bill_delivery' );
	add_submenu_page('new_bill', 'Delivery List', 'Delivery List', $src_premissions['purchase_sales'], 'delivery_list', 'delivery_list' );
	add_submenu_page('new_bill', 'Item Return', 'Item Return', $src_premissions['purchase_sales'], 'bill_return', 'bill_return' );
	add_submenu_page('new_bill', 'Return List', 'Return List', $src_premissions['purchase_sales'], 'return_list', 'return_list' );
	add_submenu_page('new_bill', 'Petty Cash', 'Petty Cash', $src_premissions['petty_cash'], 'petty_cash', 'petty_cash' );
	add_submenu_page('new_bill', 'Income List', 'Income List', $src_premissions['income_list'], 'income_list', 'income_list' );
	add_submenu_page('new_bill', 'Cancel Billing List', 'Cancel Billing List', $src_premissions['income_list'], 'cancel_billing_list', 'cancel_billing_list' );


	add_menu_page(
	    __( 'Employee List', 'src'),
	    'Employee',
	    $src_premissions['add_new_employee'],
	    'employee_list',
	    'employee_list',
	    'dashicons-businessman',
	    8
	);
	add_submenu_page('employee_list', 'Employee List', 'Employee List', $src_premissions['add_new_employee'], 'employee_list', 'employee_list' );
	add_submenu_page('employee_list', 'Attendance List', 'Attendance List', $src_premissions['attendance_list'], 'attendance_list', 'attendance_list' );
	add_submenu_page('employee_list', 'Salary List', 'Salary List', $src_premissions['salary_list'], 'salary_list', 'salary_list' );



	add_menu_page(
	    __( 'Stock Report', 'src'),
	    'Report',
	    $src_premissions['reports'],
	    'sale_report_list',
	    'sale_report_list',
	    'dashicons-clipboard',
	    9
	);
	add_submenu_page('sale_report_list', 'Sale Report', 'Sale Report', $src_premissions['reports'], 'sale_report_list', 'sale_report_list' );
	add_submenu_page('sale_report_list', 'Stock Balance', 'Stock Balance', $src_premissions['reports'], 'report_list', 'report_list' );
	add_menu_page(
	    __( 'GST Report', 'src'),
	    'GST Report',
	    $src_premissions['reports'],
	    'cgst_report',
	    'cgst_report',
	    'dashicons-clipboard',
	    9
	);
	add_submenu_page('cgst_report', 'SGST/CGST Report', 'SGST/CGST Report', $src_premissions['reports'], 'cgst_report', 'cgst_report' );
	add_submenu_page('cgst_report', 'IGST Report', 'IGST Report', $src_premissions['reports'], 'igst_report', 'igst_report' );

	add_menu_page(
	    __( 'Return Report', 'src'),
	    'Return Report',
	    $src_premissions['reports'],
	    'cgst_return_report',
	    'cgst_return_report',
	    'dashicons-clipboard',
	    10
	);
	add_submenu_page('cgst_return_report', 'SGST/CGST Report', 'SGST/CGST Report', $src_premissions['reports'], 'cgst_return_report', 'cgst_return_report' );
	add_submenu_page('cgst_return_report', 'IGST Report', 'IGST Report', $src_premissions['reports'], 'igst_return_report', 'igst_return_report' );

	add_menu_page(
	    __( 'Settings', 'src'),
	    'Settings',
	    $src_premissions['settings'],
	    'src_settings',
	    'src_settings',
	    'dashicons-clipboard',
	    9
	);
	add_submenu_page('src_settings', 'Settings', 'Settings', $src_premissions['settings'], 'src_settings', 'src_settings' );

	add_menu_page(
	    __( 'Bill Due', 'shc'),
	    'Bill Due',
	    $src_premissions['purchase_sales'],
	    'add_credit_debit',
	    'add_credit_debit',
	    'dashicons-id',
	    8
	);
	add_submenu_page('add_credit_debit', 'Pay Bill Due', 'Pay Bill Due', $src_premissions['purchase_sales'], 'add_credit_debit', 'add_credit_debit' );	
	add_submenu_page('add_credit_debit', 'Paid Bill Due List', 'Paid Bill Due List', $src_premissions['purchase_sales'], 'credit_debit', 'credit_debit' );

}






function list_lots() {
    require 'stocks/list_lots.php';
}
function list_stocks() {
    require 'stocks/list_stocks.php';	
}
function purchase_add() {
    require 'stocks/purchase_add.php';	
}
function ptype_add_list() {
    require 'stocks/ptype_add_list.php';	
}


function list_customers() {
    require 'customers/list_customers.php';
}


function add_admin_users() {
    require 'admin-users/add_admin.php';
}
function list_admin_users() {
    require 'admin-users/list_admin.php';
}

function add_admin_roles() {
    require 'admin-users/add_role.php';
}
function list_admin_roles() {
    require 'admin-users/list_role.php';
}



function billing_list() {
    require 'sales/list_billing.php';
}
function delivery_list() {
    require 'sales/list_delivery.php';
}
function return_list() {
    require 'sales/list_return.php';
}
function new_bill() {
	require 'sales/billing/billing.php';
}
function bill_delivery() {
	require 'sales/delivery_billing.php';
}
function bill_return() {
	require 'sales/return_billing.php';
}
function petty_cash() {
	require 'sales/petty_cash.php';
}
function income_list() {
	require 'sales/income_list.php';
}
function cancel_billing_list() {
    require 'sales/list_cancel_billing.php';
}


function employee_list() {
	require 'employee/list_employee.php';
}
function attendance_list() {
	require 'employee/list_attendance.php';
}
function salary_list() {
	require 'employee/list_salary.php';
}


function report_list() {
	require 'report/list_report.php';
}
function sale_report_list() {
	require 'report/list_sale_report.php';
}


//<---- credit debit --->
function credit_debit() {
    require 'creditdebit/listing/creditdebit_list.php';
}

function add_credit_debit() {
     require 'creditdebit/add_creditdebit.php';
}

//<------Gst Report----->
function igst_report(){
	require 'gst_report/listing/igst-list-accountant.php';
}
function cgst_report(){
	require 'gst_report/listing/cgst-list-accountant.php';
}

//<------ Gst Return  Report ------->
function igst_return_report(){
	require 'gst_report/listing/igst-return-report.php';
}

function cgst_return_report(){
	require 'gst_report/listing/cgst-return-report.php';
}





add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 11 );
function wp_admin_bar_my_custom_account_menu( $wp_admin_bar ) {
	$user_id = get_current_user_id();
	$current_user = wp_get_current_user();
	$profile_url = get_edit_profile_url( $user_id );

	if ( 0 != $user_id ) {
		/* Add the "My Account" menu */
		$avatar = get_avatar( $user_id, 28 );
		$howdy = sprintf( __('Welcome, %1$s'), $current_user->display_name );
		$class = empty( $avatar ) ? '' : 'with-avatar';

		$wp_admin_bar->add_menu( array(
		'id' => 'my-account',
		'parent' => 'top-secondary',
		'title' => $howdy . $avatar,
		'href' => $profile_url,
		'meta' => array(
		'class' => $class,
		),
		) );

	}
}

function my_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('updates');
    $wp_admin_bar->remove_menu('new-content');

}
add_action( 'wp_before_admin_bar_render', 'my_admin_bar_render' );




