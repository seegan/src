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
 	$pay_to_bal = ($paymentCheck) ? $to_pay : 0;
 	$data_update = "UPDATE $sale_table SET cod_check = $codCheck, cod_amount = $cod_amount, pay_to_check = $paymentCheck, pay_to_bal = pay_to_bal+$pay_to_bal, balance = $balance WHERE id = $sale_id";
	$wpdb->query($data_update);
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

	$customer_id 	= $_POST['id'];
	$bill_id 	= $_POST['bill_id'];
	$data = checkCustomerBalance($customer_id, 'due', 'billing_screen', $bill_id, 'row');
	echo json_encode($data);
	die();

}
add_action( 'wp_ajax_customer_balance', 'customer_balance' );
add_action( 'wp_ajax_nopriv_customer_balance', 'customer_balance' );

function addPaytoIntoBill(){
	global $wpdb;
	$sale_table = $wpdb->prefix.'sale';
	$sale_id   		= $_POST['sale_id'];
	$pay_to_bal 	= $_POST['pay_to_bal'];
	$query 			= "UPDATE ${sale_table} set pay_to_bal = pay_to_bal + $pay_to_bal where id = $sale_id and active = 1";
	$exists 		= $wpdb->query($query);
	$data = ($exists)? 1 : 0 ;
 	echo json_encode($data);
 	die();
}

add_action( 'wp_ajax_addPaytoIntoBill', 'addPaytoIntoBill');
add_action( 'wp_ajax_nopriv_addPaytoIntoBill', 'addPaytoIntoBill');

function getCustomerAddress(){
	global $wpdb;

	$customer_table = $wpdb->prefix.'customers';
	$customer_id = $_POST['customer_id'];
	$query 	= "SELECT * from $customer_table where id = $customer_id and active = 1";
	if($data['results'] = $wpdb->get_row($query)){
		$data['success'] = 1;
	}  else{
		$data['success'] = 0;
	}
	echo json_encode($data);
	die();
}

add_action( 'wp_ajax_getCustomerAddress', 'getCustomerAddress');
add_action( 'wp_ajax_nopriv_getCustomerAddress', 'getCustomerAddress');


function mainDeliveryAdd($sale_id=0,$date=''){
	global $wpdb;
	$delivery_table = $wpdb->prefix.'delivery';
	$insert 		= $wpdb->insert($delivery_table, array('sale_id'=>$sale_id,'delivery_date'=>$date));
	if($insert){
		$delivery_id = $wpdb->insert_id;
		deliveryDetailsAdd($sale_id,$delivery_id);
		checkDeliveryAndUpdate($sale_id);
	} 
	return true;
}
function deliveryDetailsAdd($sale_id = 0,$delivery_id =0) {	
	global $wpdb;
	$sale_details = $wpdb->prefix.'sale_detail';
	$delivery_details = $wpdb->prefix.'delivery_detail';
	$query = "SELECT id,lot_id,sale_weight from {$sale_details} where sale_id ={$sale_id} and active =1";
	$results = $wpdb->get_results($query);
	foreach ($results as $getvalue) {
		$details = array(
			'delivery_id' 		=>	$delivery_id,
			'sale_id'     		=>	$sale_id,
			'sale_detail_id' 	=> $getvalue->id,
			'lot_id'            => $getvalue->lot_id,
			'delivery_weight'   => $getvalue->sale_weight,
			);
		$wpdb->insert($delivery_details,$details);
	}
}

?>