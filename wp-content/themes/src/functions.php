<?php
require get_template_directory() . '/inc/admin/functions.php';
require get_template_directory() . '/inc/admin/menu-functions.php';
require get_template_directory() . '/inc/admin/pagination-functions.php';

require get_template_directory() . '/inc/admin/functions/sales.php';
require get_template_directory() . '/inc/admin/functions/sale_delivery.php';
require get_template_directory() . '/inc/admin/functions/sale_return.php';

require get_template_directory() . '/inc/admin/admin-dashboard.php';
require get_template_directory() . '/inc/admin/report-functions.php';
require get_template_directory() . '/inc/admin/creditdebit/function.php';
require get_template_directory() . '/inc/admin/billing_template/billing/modepayment_singlebill/modeofpaymentfunction.php';


function src_global_var() {
    global $src_capabilities, $src_premissions;
	$src_capabilities = array( 
		'dashboard' => 'Dashboard', 
		'customers' => 'Customers',  
		'stocks' => array(
			'name' => 'Stocks',
			'data' => array(
				'lot_list' => 'Lot(s) List',
				'stock_list' => 'Stock List', 
			),
		),
		'sales_others' => array(
			'name' => 'Sales & Others',
			'data' => array(
				'purchase_sales' => 'Purchase & Sales', 
				'petty_cash' => 'Petty Cash', 
				'income_list' => 'Income List', 
			),
		),
		'employee' => array(
			'name' => 'Employee',
			'data' => array(
				'add_new_employee' => 'Add New Employee', 
				'employee_list' => 'Employee\'s List', 
				'attendance_list' => 'Attendance List', 
				'salary_list' => 'Salary List', 
			),
		),
		'admin_users' => array(
			'name' => 'Admin Users',
			'data' => array(
				'add_new_user' => 'Add New User', 
				'user_list' => 'User\'s List', 
			),

		),
		'sms_alert' => array(
			'name' => 'SMS Alert',
			'data' => array(
				'sms_to_customer' => 'SMS to Customer', 
				'sms_to_user' => 'SMS to User', 
			),
		),
		'reports' => 'Reports', 
		'settings' => 'Settings'
	);



	$src_premissions = array(
			'dashboard' => (is_super_admin()) ? 'manage_options' : 'dashboard',
			'customers' => (is_super_admin()) ? 'manage_options' : 'customers',
			'lot_list' => (is_super_admin()) ? 'manage_options' : 'lot_list',
			'stock_list' => (is_super_admin()) ? 'manage_options' : 'stock_list',
			'purchase_sales' => (is_super_admin()) ? 'manage_options' : 'purchase_sales',
			'petty_cash' => (is_super_admin()) ? 'manage_options' : 'petty_cash',
			'income_list' => (is_super_admin()) ? 'manage_options' : 'income_list',
			'add_new_employee' => (is_super_admin()) ? 'manage_options' : 'add_new_employee',
			'employee_list' => (is_super_admin()) ? 'manage_options' : 'employee_list',
			'attendance_list' => (is_super_admin()) ? 'manage_options' : 'attendance_list',
			'salary_list' => (is_super_admin()) ? 'manage_options' : 'salary_list',
			'add_new_user' => (is_super_admin()) ? 'manage_options' : 'add_new_user',
			'user_list' => (is_super_admin()) ? 'manage_options' : 'user_list',
			'sms_to_customer' => (is_super_admin()) ? 'manage_options' : 'sms_to_customer',
			'sms_to_user' => (is_super_admin()) ? 'manage_options' : 'sms_to_user',
			'reports' => (is_super_admin()) ? 'manage_options' : 'reports',
			'settings' => (is_super_admin()) ? 'manage_options' : 'settings',
		);

}
add_action( 'init', 'src_global_var' );


//create role capabilities
function custom_role_administrator() {
	global $src_capabilities;
	$admin_role = get_role( 'administrator' );

	$data = '';
	foreach ($src_capabilities as $key => $c_value) {
		if( is_array($c_value) ) {
			foreach ($c_value['data'] as $key_val => $name_value) {
				$data[] =  $key_val;
			}
		} else {
			$data[] = $key;
		}
	}
	foreach( $data as $cap ) {
	        $admin_role->add_cap( $cap );
	}

	if(!get_role('customer')) {
		add_role( 'customer', 'Customer', array( 'read' => true, 'level_0' => true ) );
	}
	if(!get_role('employee')) {
	    add_role( 'employee', 'Employee', array( 'read' => true, 'level_0' => true ) );
	}
}
add_action('switch_theme', 'custom_role_administrator');