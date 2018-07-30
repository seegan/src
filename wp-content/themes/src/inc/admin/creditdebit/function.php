<?php
require get_template_directory() . '/inc/admin/creditdebit/class-creditdebit.php';

function load_credit_scripts() {
	wp_enqueue_script( 'credit-script', get_template_directory_uri() . '/inc/admin/creditdebit/inc/creditdebit.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_credit_scripts' );

/*Ajax Functions*/
function create_creditdebit(){

	$current_user 		= wp_get_current_user();
	$current_nice_name 	= $current_user->user_nicename;

	$data['success'] 	= 0;
	$data['msg'] 		= 'Something Went Wrong Please Try Again!';
	$data['redirect'] 	= 0;

	global $wpdb;
	$credit_table 			=  $wpdb->prefix.'creditdebit';
	$payment_table_display 	=  $wpdb->prefix.'creditdebit_details';
	$payment_table 			=  $wpdb->prefix.'payment';	


	$params = array();
	parse_str($_POST['data'], $params);

	$credit_data = array(
		'date' 			=> $params['creditdebit_date'],
		'customer_id' 	=> $params['billing_customer_due'],
		// 'customer_name' => $params['creditdebit_customer'],
		'description' 	=> $params['description'],
		'due_amount' 	=> $params['total_due'],
		'to_pay_amt' 	=> $params['to_pay_amt'],
		);

	$wpdb->insert($credit_table, $credit_data);

	$create_id 			= $wpdb->insert_id;
	//$lot_add_update 	=  array('created_by'=>$current_nice_name);
	//$wpdb->update($credit_table, $lot_add_update, array('id' => $create_id));


//Insert Payment Type in credit Debit table

	foreach ($params['payment_detail'] as $value) {
		if(isset($value['payment_type'])){			
			$payment_data = 	array(
				'cd_id' 			=> $create_id,
				'payment_details'	=> '',
				'payment_date'		=> date('Y-m-d'),
				'customer_id'		=> $params['billing_customer_due'],
				'payment_type'		=> $value['payment_type'],
				'amount'			=> $value['payment_amount'],
							);
			$wpdb->insert($payment_table_display, $payment_data);
       }
	}


//Insert Payment Type
	foreach ($params['duepayAmount'] as $key => $value) {
			
		if($params['duepayAmount']!= 0){
			
				$insert_detail = array(
				'reference_id' 		=> $create_id,
				'reference_screen' 	=> 'due_screen',
				'sale_id' 			=> $params['dueId'][$key]['due'],
				'customer_id' 		=> $params['billing_customer_due'],
				'amount' 			=> $params['duepayAmount'][$key]['due'],
				'due_amount' 		=> $params['dueDueAmount'][$key]['due'],
				'payment_type' 		=> $params['duePaytype'][$key]['due'],
				'payment_date'      => date('Y-m-d'),
				);
				
		}
		$wpdb->insert($payment_table, $insert_detail);
	}

	if($wpdb->insert_id) {
		$data['success'] = 1;
		$data['msg'] 	= 'Due Created!';
		
		$data['redirect'] = network_admin_url( 'admin.php?page=credit_debit' );
	}


}
add_action( 'wp_ajax_create_creditdebit', 'create_creditdebit' );
add_action( 'wp_ajax_nopriv_create_creditdebit', 'create_creditdebit' );



function update_creditdebit(){
	$current_user 		= wp_get_current_user();
	$current_nice_name 	= $current_user->user_nicename;

	$data['success'] 	= 0;
	$data['msg'] 	= 'Product Not Exist Please Try Again!';
	$data['redirect'] 	= 0;
	global $wpdb;
	$params = array();
	parse_str($_POST['data'], $params);

	$creditdebit_id 		= $params['creditdebit_id'];
	$credit_table 			= $wpdb->prefix.'creditdebit';
	$payment_table_display 	= $wpdb->prefix.'creditdebit_details';
	$payment_table 			=  $wpdb->prefix.'payment';	

	$query = "SELECT * from ${credit_table} WHERE id = ${creditdebit_id} and date ='${creditdebit_date}' and customer_type = ${customer_type} and customer_id = ${customer_id} and  description = '${description}' and active='1'";
	
	if($creditdebit_id != '') {
		$credit_data = array(
			'date' 			=> $params['creditdebit_date'],
			'customer_name' => $params['creditdebit_customer'],
			'customer_id' 	=> $params['creditdebit_cus_id'],
			'customer_type' => $params['customer_type'],
			'due_amount' 	=> $params['total_due'],
			'description' 	=> $params['description'],
			'to_pay_amt' 	=> $params['to_pay_amt'],
			'modified_by' 	=> $current_nice_name
		);

		$wpdb->update($credit_table, $credit_data, array('id' => $creditdebit_id));
		$wpdb->update($payment_table_display, array('active' => 0), array('cd_id' => $creditdebit_id));	

		foreach ($params['payment_detail'] as $value) {
			if(isset($value['payment_type'])){
				$payment_data = 	array(
					'cd_id'  			=> $creditdebit_id,
					'payment_details'	=> '',
					'payment_date'		=> date('Y-m-d'),
					'customer_id'		=> $params['creditdebit_cus_id'],
					'payment_type'		=> $value['payment_type'],
					'amount'			=> $value['payment_amount'],
					);
				$wpdb->insert($payment_table_display, $payment_data);
	       }
		}

		$wpdb->update($payment_table, array('active' => 0), array('reference_id' => $creditdebit_id,'reference_screen' => 'due_screen'));	
		foreach ($params['duepayAmount'] as $key => $value) {

			if($params['duepayAmount']!= 0 && $params['duepayAmount']!= '0.00'){
				$insert_detail = array(
				'reference_id' 		=> $creditdebit_id,
				'reference_screen' 	=> 'due_screen',
				'sale_id' 			=> $params['dueId'][$key]['due'],
				'customer_id' 		=> $params['creditdebit_cus_id'],
				'amount' 			=> $params['duepayAmount'][$key]['due'],
				'due_amount' 		=> $params['dueDueAmount'][$key]['due'],
				'payment_type' 		=> $params['duePaytype'][$key]['due'],
				'payment_date'      => date('Y-m-d'),
				);					
			}
			$wpdb->insert($payment_table, $insert_detail);
		}

		$data['success'] = 1;
		$data['msg'] 	= 'Notes Updated!';
		$data['redirect'] = network_admin_url( 'admin.php?page=credit_debit' );	
	}
	

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_update_creditdebit', 'update_creditdebit' );
add_action( 'wp_ajax_nopriv_update_creditdebit', 'update_creditdebit' );


function get_creditdebit($credit_id = 0) {
    global $wpdb;
    $credit_tab 			= $wpdb->prefix.'creditdebit';
    $credit_tab_details 	= $wpdb->prefix.'creditdebit_details';
    $credit_payment 		= $wpdb->prefix.'payment';
    $query 					= "SELECT * FROM ${credit_tab} WHERE id = ${credit_id} and active = 1";
    $data['main_tab'] 		= $wpdb->get_row($query);
    $query1 				= "SELECT * FROM ${credit_tab_details} WHERE cd_id = ${credit_id} and active = 1";
    $data['sub_tab'] 		= $wpdb->get_results($query1);
    $query2 				= "SELECT * FROM ${credit_payment} WHERE reference_id = ${credit_id} and reference_screen='due_screen' and active = 1";
    $data['payment_tab'] 	= $wpdb->get_results($query2);
    return $data;
}
function get_Wscreditdebit($credit_id = 0) {
    global $wpdb;
    $credit_tab 			= $wpdb->prefix.'creditdebit';
    $credit_tab_details 	= $wpdb->prefix.'creditdebit_details';
    $credit_payment 		= $wpdb->prefix.'payment';
    $query 					= "SELECT * FROM ${credit_tab} WHERE id = ${credit_id} and active = 1";
    $data['main_tab'] 		= $wpdb->get_row($query);
    $query1 				= "SELECT * FROM ${credit_tab_details} WHERE cd_id = ${credit_id} and active = 1";
    $data['sub_tab'] 		= $wpdb->get_results($query1);
    $query2 				= "SELECT * FROM ${credit_payment} WHERE reference_id = ${credit_id} and reference_screen='due_screen' and active = 1";
    $data['payment_tab'] 	= $wpdb->get_results($query2);
    return $data;
}


function creditdebit_filter() {
	$creditdebit = new creditdebit();
	include( get_template_directory().'/inc/admin/creditdebit/ajax_loading/creditdebit_list.php' );
	die();	
}
add_action( 'wp_ajax_creditdebit_filter', 'creditdebit_filter' );
add_action( 'wp_ajax_nopriv_creditdebit_filter', 'creditdebit_filter' );



function get_creditdebit_cus() { 

	$data['success'] = 0;
	$data['msg'] = 'Something Went Wrong!';

	global $wpdb;
	$search = $_POST['search_key'];
	$type = $_POST['customer_type'];
	if($type == 'ws'){
		$table =  $wpdb->prefix.'customers';
	    $customPagHTML      = "";
	    $query              = "SELECT * FROM ${table} WHERE active = 1 AND ( company_name LIKE '%${search}%' OR customer_name LIKE '%${search}%' OR mobile LIKE '${search}%')";	
	}
	else{
		$table =  $wpdb->prefix.'customers';
	    $customPagHTML      = "";
	    $query              = "SELECT * FROM ${table} WHERE active = 1 AND (  name LIKE '%${search}%' OR mobile LIKE '${search}%')";	
	}
	$data['result'] = $wpdb->get_results($query);
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_get_creditdebit_cus', 'get_creditdebit_cus' );
add_action( 'wp_ajax_nopriv_get_creditdebit_cus', 'get_creditdebit_cus' );

function DuePaid($customer_id = 0){

	global $wpdb;

	$sale_table 		= $wpdb->prefix.'sale';
	$return_table 		= $wpdb->prefix.'return';
	$payment_table  	= $wpdb->prefix.'payment';
	$customer_table  	= $wpdb->prefix.'customers';
	//$cd_notes 		= $wpdb->prefix.'shc_cd_notes';
	
	$customer_id 		= ($_POST['id']) ? $_POST['id'] : $customer_id;
	$reference_id 		= ($_POST['reference_id'] != '') ? $_POST['reference_id'] : 0;
	$reference_screen 	= ($_POST['reference_screen'] != '') ? $_POST['reference_screen'] : '';
	// if($reference_id == 0){
	// 	$condition1 = "";
	// } else {
	// 	$condition1 = " AND reference_id  != ${reference_id}";
	// }
	// if($reference_screen == ''){
	// 	$condition = "";
	// } else {
	// 	$condition = "and reference_screen != '${reference_screen}'";
	// }
// 	$query = "SELECT full_table.cus_id as customer_id,full_table.name as customer_name,full_table.address,full_table.mobile,
// (case when  full_table.sale_id is null then 0.00 else full_table.sale_id end ) as sale_id,
// (case when  full_table.search_id is null then 0.00 else full_table.search_id end ) as search_id,
// (case when  full_table.year is null then 0.00 else full_table.year end ) as year,
// (case when  full_table.sale_total is null then 0.00 else full_table.sale_total end ) as sale_total,
// (case when  full_table.paid_amount is null then 0.00 else full_table.paid_amount end ) as paid_amount,
// (case when  full_table.key_amount is null then 0.00 else full_table.key_amount end ) as key_amount,
// (case when  full_table.return_ amount is null then 0.00 else full_table.return_amount end ) as return_amount,
// (case when  full_table.invoice_bill_bal is null then 0.00 else full_table.invoice_bill_bal end ) as invoice_bill_bal,
// (case when  full_table.return_bill_bal is null then 0.00 else full_table.return_bill_bal end ) as return_bill_bal,
// (case when  full_table.new_sale_total is null then 0.00 else full_table.new_sale_total end ) as new_sale_total,
// (case when  full_table.final_bal is null then 0.00 else full_table.final_bal end ) as final_bal
// from  
// ( 
//     SELECT * from (
//     SELECT id as cus_id,name,mobile,address FROM ${customer_table}  WHERE active = 1
// ) as customer
// left join 
// (
// 	SELECT tab.*,(tab.invoice_bill_bal - tab.return_bill_bal) as final_bal  from (
//     select final_tab.*, 
// (final_tab.sale_total- final_tab.paid_amount) as invoice_bill_bal,
// (final_tab.return_amount- final_tab.key_amount) as return_bill_bal,
// (final_tab.sale_total - final_tab.return_amount ) as new_sale_total
// from ( 
//     select bill_table.*,
// (case when return_tab.key_amount is null then 0.00 else return_tab.key_amount end) as key_amount,
// (case when return_tab.return_amount is null then 0.00 else return_tab.return_amount end) as return_amount
// from 
// (
//     SELECT sale.inv_id as sale_id,
//     sale.customer_id,
//     sale.search_id,
//     sale.year,sale.sale_total,
//     (case when payment.payment_amount is null then 0.00 else payment.payment_amount-sale.pay_to_bal end) as paid_amount 
//     from 
// (
//     SELECT id as inv_id,customer_id,
//     `inv_id` as search_id,
//     `financial_year` as year,
//     `sub_total` as sale_total,`pay_to_bal` FROM ${sale_table} WHERE`active`=1 
// )  as sale
// left join 
// ( 
//     select 	sale_id,sum(amount) as payment_amount from ${payment_table} WHERE active = 1 and payment_type!= 'credit' ${condition1} ${condition}  GROUP by sale_id
//  )  as payment
// on sale.inv_id = payment.sale_id
// ) as bill_table 
// left join 
// (
//     SELECT inv_id,key_amount,total_amount as return_amount from {$return_table} WHERE active =  1 
// ) 
// as return_tab 
// on bill_table.sale_id = return_tab.inv_id )
// as final_tab  
// ) as tab 
// )
// as full_sale_tab  
// on full_sale_tab.customer_id = customer.cus_id 
// ) as full_table
// where full_table.customer_id = ${customer_id} order by full_table.sale_id ASC "  ;
	$query = "SELECT sale.*,
(case when ret.return_sale is null then 0 ELSE ret.return_sale end ) as return_sale,
(case when  (sale.sale_total - ret.return_sale) is null then sale.sale_total else (sale.sale_total - ret.return_sale) end ) as final_sale_total,
(case when ret.return_amount is null then 0 ELSE ret.return_amount end ) as return_amount,
(case when payment.paid_amount is null then 0 ELSE payment.paid_amount end ) as paid_amount,
(
	sale.pay_to_bal
    +
    (case when ret.return_amount is null then 0 ELSE ret.return_amount end )
    +
    (case when  (sale.sale_total - ret.return_sale) is null then sale.sale_total else (sale.sale_total - ret.return_sale) end )
    -
    (case when payment.paid_amount is null then 0 ELSE payment.paid_amount end )
) as current_due

from 
(
    SELECT s.id as sale_id, s.customer_id, (s.sale_total) as sale_total,s.pay_to_bal, s.created_at as sale_date,s.invoice_id,s.financial_year FROM ${sale_table} as s WHERE s.customer_id = ${customer_id} and s.active = 1 
) as sale
left join 
(
    SELECT r.sale_id as sale_id,sum(r.total_amount) as return_sale,sum(r.key_amount) as return_amount FROM ${return_table} as r WHERE r.active = 1 and r.customer_id =${customer_id} GROUP by r.sale_id
) as ret
on sale.sale_id = ret.sale_id 

left join 

(
    SELECT p.sale_id as sale_id,sum(p.amount) as paid_amount FROM ${payment_table} as p WHERE p.customer_id = ${customer_id} and p.active = 1 and p.payment_type != 'credit' GROUP by p.sale_id
) as payment
on sale.sale_id = payment.sale_id WHERE

(
	sale.pay_to_bal
    +
    (case when ret.return_amount is null then 0 ELSE ret.return_amount end )
    +
    (case when  (sale.sale_total - ret.return_sale) is null then sale.sale_total else (sale.sale_total - ret.return_sale) end )
    -
    (case when payment.paid_amount is null then 0 ELSE payment.paid_amount end )
) > 0

order by sale.sale_id asc";

$data['due_data'] = $wpdb->get_results($query);
echo json_encode($data);
die();

}
add_action( 'wp_ajax_DuePaid', 'DuePaid');
add_action( 'wp_ajax_nopriv_DuePaid', 'DuePaid');


function DuePaidUpdate(){

	global $wpdb;
	$sale_table 		= $wpdb->prefix.'sale';
	$return_table 		= $wpdb->prefix.'return_items';
	$payment_table  	= $wpdb->prefix.'payment';
	$customer_table  	= $wpdb->prefix.'customers';
		//$cd_notes 		= $wpdb->prefix.'shc_cd_notes';	
	
	$customer_id 		= ($_POST['id']) ? $_POST['id'] : $customer_id;
	$reference_id 		= ($_POST['reference_id'] != '') ? $_POST['reference_id'] : 0;
	$reference_screen 	= ($_POST['reference_screen'] != '') ? $_POST['reference_screen'] : '';

	$query = "SELECT sale.*,
(case when ret.return_sale is null then 0 ELSE ret.return_sale end ) as return_sale,
(case when  (sale.sale_total - ret.return_sale) is null then sale.sale_total else (sale.sale_total - ret.return_sale) end ) as final_sale_total,
(case when ret.return_amount is null then 0 ELSE ret.return_amount end ) as return_amount,
(case when payment.paid_amount is null then 0 ELSE payment.paid_amount end ) as paid_amount,
(case when payment.due_paid is null then 0 ELSE payment.due_paid end ) as credit_paid,
(case when payment.bill_paid is null then 0 ELSE payment.bill_paid end ) as bill_paid,
(
	
    (case when ret.return_amount is null then 0 ELSE ret.return_amount end )
    +
    (case when  (sale.sale_total - ret.return_sale) is null then sale.sale_total else (sale.sale_total - ret.return_sale) end )
    -
    (case when payment.paid_amount is null then 0 ELSE payment.paid_amount end )
) as due_bal,
(
    (case when ret.return_amount is null then 0 ELSE ret.return_amount end )
    +
    (case when  (sale.sale_total - ret.return_sale) is null then sale.sale_total else (sale.sale_total - ret.return_sale) end )
    -
    (case when payment.paid_amount is null then 0 ELSE payment.paid_amount end )
    + 
    (case when payment.due_paid is null then 0 ELSE payment.due_paid end ) 
) as current_due,

(case when payment.reference_id is null then 0 ELSE payment.reference_id end ) as reference_id,
(case when payment.reference_screen is null then '' ELSE payment.reference_screen end ) as reference_screen
from 
 (
     SELECT p.sale_id as sale_id,sum(p.amount) as paid_amount,p.reference_id,p.reference_screen,
     sum(case when  (reference_screen= 'due_screen' and reference_id = ${reference_id})  then amount else 0 end ) as due_paid,
     sum(case when (reference_screen= 'due_screen' or reference_screen= 'billing_screen')   then amount else 0 end ) as bill_paid FROM ${payment_table} as p WHERE p.customer_id = ${customer_id} and p.active = 1 and p.payment_type != 'credit'  group by sale_id  ) as payment
left join 
( SELECT s.id as sale_id, s.customer_id, (s.sale_total) as sale_total,s.pay_to_bal, s.created_at as sale_date,s.invoice_id,s.financial_year FROM ${sale_table} as s WHERE s.customer_id = ${customer_id} and s.active = 1 
) as sale 
on sale.sale_id = payment.sale_id
left join 
(
    SELECT r.sale_id as sale_id,sum(r.total_amount) as return_sale,sum(r.key_amount) as return_amount FROM ${return_table} as r WHERE r.active = 1 and r.customer_id =${customer_id} GROUP by r.sale_id
) as ret
on payment.sale_id = ret.sale_id WHERE
(
	(case when ret.return_amount is null then 0 ELSE ret.return_amount end )
    +
    (case when  (sale.sale_total - ret.return_sale) is null then sale.sale_total else (sale.sale_total - ret.return_sale) end )
    -
    (case when payment.paid_amount is null then 0 ELSE payment.paid_amount end )
    + 
    (case when payment.due_paid is null then 0 ELSE payment.due_paid end ) 
) > 0

order by sale.sale_id asc ";
//var_dump($query);
$data['due_data'] = $wpdb->get_results($query);
echo json_encode($data);
die();

}
add_action( 'wp_ajax_DuePaidUpdate', 'DuePaidUpdate');
add_action( 'wp_ajax_nopriv_DuePaidUpdate', 'DuePaidUpdate');