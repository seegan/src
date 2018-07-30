<?php 
function PaymentCreate($payment_detail = '',$payment_credit = '',$credit_amount = '',$invoice_id = '',$customer_id = '',$duepaid = ''){

global $wpdb;
$payment_table = $wpdb->prefix.'payment';
if($payment_detail){
	foreach ($payment_detail as $value) {
		if(isset($value['payment_type'])){			
			$payment_data = 	array(
				'reference_id' 		=> $value['reference_id'],
				'reference_screen' 	=> $value['reference_screen'],
				'uniquename' 		=> $value['unique_name'],
				'sale_id'  			=> $invoice_id,
				'payment_date'		=> date('Y-m-d'),
				'customer_id'		=> $customer_id,
				'payment_type'		=> $value['payment_type'],
				'amount'			=> $value['payment_amount'],
							);
			$wpdb->insert($payment_table, $payment_data);
	
	   }

	}
}
if($payment_detail){ 
	foreach ($payment_credit as $view) {
		if($view == 'credit_content'){
			$payment_data = 	array(
		  		'reference_id' 		=> $value['reference_id'],
				'reference_screen' 	=> $value['reference_screen'],
				'sale_id'  			=> $invoice_id,
				'payment_date'		=> date('Y-m-d'),
				'customer_id'		=> $customer_id,
				'payment_type'		=> 'credit',
				'amount'			=> $credit_amount,
							);
			$wpdb->insert($payment_table, $payment_data);

		}		
	}

}

if($duepaid){

	foreach ($duepaid as $due) {
		if($due['prev_bal_check']){

			updateDueCheck($due['id']);
		}
	}

}

	// $payfromprevious_data = array(
	// 	'reference_screen' 	=> 'billing_screen',
	// 	'sale_id'  			=> $invoice_id,
	// 	'payment_date'		=> date('Y-m-d'),
	// 	'customer_id'		=> $customer_id,
	// 	'payment_type'		=> 'payfromprevious',
	// 	'amount'			=> $paytobalance,
	// 	);
	// $wpdb->insert($payfromprevious_data, $payment_data);




}

function PaymentUpdate($payment_detail = '',$payment_credit = '',$credit_amount = '',$invoice_id = '',$customer_id = 0,$paytobalance = ''){
	global $wpdb;
	$payment_table = $wpdb->prefix.'payment';
	$update_data = $wpdb->update($payment_table,array('active'=> 0),array('sale_id'=> $invoice_id));
	if($payment_detail){
		foreach ($payment_detail as $value) {
			if(isset($value['payment_type'])){			
				$payment_data = 	array(
					'reference_id' 		=> $value['reference_id'],
					'reference_screen' 	=> $value['reference_screen'],
					'uniquename' 		=> $value['unique_name'],
					'sale_id'  			=> $invoice_id,
					'payment_date'		=> date('Y-m-d'),
					'customer_id'		=> $customer_id,
					'payment_type'		=> $value['payment_type'],
					'amount'			=> $value['payment_amount'],
								);
				$wpdb->insert($payment_table, $payment_data);
			
		   }

		}
	}

	if($payment_detail){ 
		foreach ($payment_credit as $view) {
			if($view == 'credit_content'){
				$payment_data = 	array(
			  		'reference_id' 		=> $value['reference_id'],
					'reference_screen' 	=> $value['reference_screen'],
					'sale_id'  			=> $invoice_id,
					'payment_date'		=> date('Y-m-d'),
					'customer_id'		=> $customer_id,
					'payment_type'		=> 'credit',
					'amount'			=> $credit_amount,
								);
				$wpdb->insert($payment_table, $payment_data);

			}		
		}

	}

	if($duepaid){

		foreach ($duepaid as $due) {
			if($due['prev_bal_check']){
				updateDueCheck($due['id']);
			}
		}

	}

		
}

function check_balance_ajax() {

	global $wpdb;
	$data['success'] = 0;
	$id = $_POST['customer_id'];
	$sale_table 	= $wpdb->prefix.'sale';
	$query 			= "SELECT pay_to_bal,pay_to_check,id,invoice_id  FROM {$sale_table} WHERE customer_id={$id} and pay_to_check = 0 and active=1 and pay_to_bal>0";
	$data = $wpdb->get_results( $query);
	if($data){
		$data['success'] = 1;	
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_check_balance_ajax', 'check_balance_ajax' );
add_action( 'wp_ajax_nopriv_check_balance_ajax', 'check_balance_ajax' );
function check_balance_ajax2() {

	global $wpdb;
	$data['success'] = 0;
	$id = $_POST['customer_id'];
	$sale_table 	= $wpdb->prefix.'sale';
	$return_table 	= $wpdb->prefix.'return';
	$query 			= "SELECT pay_to_bal as amount,customer_id ,pay_to_check as tick ,id as sale_id,invoice_id as display_id,'s' as pay_form   FROM {$sale_table} WHERE customer_id={$id} and pay_to_check = 0 and active=1 and pay_to_bal>0 
						UNION  all
						SELECT total_amount as amount,customer_id,sale_id,return_to_check as tick,sale_id,sale_id as display_id, 'r' as pay_form from  {$return_table} WHERE return_to_check = 0 and active = 1 and customer_id = {$id}
						as ret_tab";
						// var_dump($query);
	$data = $wpdb->get_results( $query);
	if($data){
		$data['success'] = 1;	
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_check_balance_ajax2', 'check_balance_ajax2' );
add_action( 'wp_ajax_nopriv_check_balance_ajax2', 'check_balance_ajax2' );

function getBalance($customer_id = 0) {

	global $wpdb;
	$credit_table 			= $wpdb->prefix.'sale';
	$query 					= "SELECT pay_to_bal,pay_to_check,id  FROM $credit_table WHERE active=1 and customer_id=${customer_id} and pay_to_check = 0 and pay_to_bal>0";
	$getbalance 			= $wpdb->get_row( $query);
	$balance = ($getbalance && isset($getbalance->balance)) ? $getbalance->balance : 0;
	return $balance;
	
}





function AddOtherPayments($codCheck = 0,$cod_amount = 0,$paymentCheck = 0,$to_pay = 0,$balance = 0,$sale_id = 0){
	global $wpdb;
	$sale_table = $wpdb->prefix.'sale';

	$data_update = array(
		'cod_check' 		=> $codCheck,
		'cod_amount' 		=> $cod_amount,
		'pay_to_check' 		=> $paymentCheck,
		'pay_to_bal' 		=> $to_pay,
		'balance' 			=> $balance,
		);
	$wpdb->update($sale_table,$data_update,array('id'=>$sale_id));
	// var_dump($wpdb->last_query);
	// die();
}



function addCredit($credit_data = array()){
	global $wpdb;
	$credit_table 	= $wpdb->prefix.'creditdebit';
	$wpdb->insert($credit_table, $credit_data);
}



function addDebit($payment_key = 0,$customer_id = 0,$sale_id = 0,$payment_amt = 0,$balance = 0,$transaction_order = 0){
	global $wpdb;
	$data_insert = array(
		'payment_key' 			=> $payment_key,
		'customer_id' 			=> $customer_id,
		'sale_id' 				=> $sale_id,
		'payment_amt' 			=> $payment_amt,
		'balance' 				=> $balance,
		'transaction_order' 	=> $transaction_order,
		);
}



function get_paymenttype($id = 0){
	global $wpdb;
	$payment_table = $wpdb->prefix.'payment';
	$query = "SELECT * from {$payment_table} WHERE sale_id = {$id} and  active = 1";
	return $data['paymentType'] = $wpdb->get_results($query);

}


function updateDueCheck($id = 0){
	global  $wpdb;
	$table = $wpdb->prefix.'sale';
	$wpdb->update($table,array('pay_to_check' =>1),array('id'=>$id));
	return true;
}
function customer_balance() {

	global $wpdb;
	$customer_id 	= $_POST['id'];
	$sale_table 	= $wpdb->prefix.'sale';
	$return_table 	= $wpdb->prefix.'return';
	$payment_table  = $wpdb->prefix.'payment';
	$customer_table = $wpdb->prefix.'customers';

	$query = "SELECT cus_full_detail.customer_id,
cus_full_detail.customer_name,
cus_full_detail.address,
cus_full_detail.mobile,
sum(cus_full_detail.new_sale_total) as new_sale_total,
sum(cus_full_detail.final_bal) as final_bal
FROM (
	SELECT full_table.cus_id as customer_id,full_table.name as customer_name,full_table.address,full_table.mobile,
(case when  full_table.sale_id is null then 0.00 else full_table.sale_id end ) as sale_id,
(case when  full_table.sale_total is null then 0.00 else full_table.sale_total end ) as sale_total,
(case when  full_table.paid_amount is null then 0.00 else full_table.paid_amount end ) as paid_amount,
(case when  full_table.key_amount is null then 0.00 else full_table.key_amount end ) as key_amount,
(case when  full_table.return_amount is null then 0.00 else full_table.return_amount end ) as return_amount,
(case when  full_table.invoice_bill_bal is null then 0.00 else full_table.invoice_bill_bal end ) as invoice_bill_bal,
(case when  full_table.return_bill_bal is null then 0.00 else full_table.return_bill_bal end ) as return_bill_bal,
(case when  full_table.new_sale_total is null then 0.00 else full_table.new_sale_total end ) as new_sale_total,
(case when  full_table.final_bal is null then 0.00 else full_table.final_bal end ) as final_bal
from  
( 
    select * from (
    SELECT id as cus_id,name,mobile,address FROM ${customer_table}  WHERE active = 1
) as customer
left join 
(
	SELECT tab.*,(tab.invoice_bill_bal - tab.return_bill_bal) as final_bal  from (
    select final_tab.*, 
(final_tab.sale_total- final_tab.paid_amount) as invoice_bill_bal,
(final_tab.return_amount- final_tab.key_amount) as return_bill_bal,
(final_tab.sale_total - final_tab.return_amount ) as new_sale_total
from ( 
    select bill_table.*,
(case when return_tab.key_amount is null then 0.00 else return_tab.key_amount end) as key_amount,
(case when return_tab.return_amount is null then 0.00 else return_tab.return_amount end) as return_amount
from 
(
    SELECT sale.inv_id as sale_id,
    sale.customer_id,
    sale.search_id,
    sale.year,sale.sale_total,
    (case when payment.payment_amount is null then 0.00 else payment.payment_amount-sale.pay_to_bal end) as paid_amount 
    from 
(
    SELECT id as inv_id,customer_id,
    invoice_id as search_id,
    financial_year as year,
    sale_total as sale_total,(case when pay_to_check = 1 then pay_to_bal else 0 end) as pay_to_bal FROM ${sale_table} WHERE active=1 
)  as sale
left join 
( 
    select 	sale_id,sum(amount) as payment_amount from ${payment_table} WHERE active = 1 and payment_type!= 'credit' GROUP by sale_id
 )  as payment
on sale.inv_id = payment.sale_id
) as bill_table 
left join 
(
    SELECT id as inv_id,key_amount,total_amount as return_amount from {$return_table} WHERE active = 1
) 
as return_tab 
on bill_table.sale_id = return_tab.inv_id )
as final_tab  
) as tab 
)
as full_sale_tab  
on full_sale_tab.customer_id = customer.cus_id 
) as full_table
order by full_table.sale_id ASC )
as cus_full_detail where cus_full_detail.customer_id = ${customer_id}  GROUP by cus_full_detail.customer_id ";

    $data = $wpdb->get_row($query);

	echo json_encode($data);
	die();

}
add_action( 'wp_ajax_customer_balance', 'customer_balance' );
add_action( 'wp_ajax_nopriv_customer_balance', 'customer_balance' );

?>