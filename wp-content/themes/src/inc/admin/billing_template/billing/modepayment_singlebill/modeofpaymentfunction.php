<?php 
function PaymentCreate($payment_detail = '',$duepaid = '',$payment_credit = '',$credit_amount = '',$invoice_id = '',$customer_id = '',$paytobalance = ''){

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
	$update_data = $wpdb->update($payment_table,array('active'=> 0),array('sale_id'=> $invoice_id,'payment_type' => 'credit'));
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
	$update_data = $wpdb->update($payment_table,array('active'=> 0),array('sale_id'=> $invoice_id,'payment_type' => 'payfromprevious'));

		$payfromprevious_data = array(
			'reference_screen' 	=> 'billing_screen',
			'sale_id'  			=> $invoice_id,
			'payment_date'		=> date('Y-m-d'),
			'customer_id'		=> $customer_id,
			'payment_type'		=> 'payfromprevious',
			'amount'			=> $paytobalance,
			);
		$wpdb->insert($payment_table, $payfromprevious_data);
}

function check_balance_ajax() {

	global $wpdb;
	$id = $_POST['customer_id'];
	$sale_table 	= $wpdb->prefix.'sale';
	$query 			= "SELECT pay_to_bal,pay_to_check,id,invoice_id  FROM {$sale_table} WHERE customer_id={$id} and pay_to_check = 0 and active=1";
	$data = $wpdb->get_results( $query);
	echo json_encode($data); 
	// var_dump($query);
	die();
}
add_action( 'wp_ajax_check_balance_ajax', 'check_balance_ajax' );
add_action( 'wp_ajax_nopriv_check_balance_ajax', 'check_balance_ajax' );


function getBalance($customer_id = 0) {

	global $wpdb;
	$credit_table 			= $wpdb->prefix.'sale';
	$query 					= "SELECT pay_to_bal,pay_to_check,id  FROM $credit_table WHERE active=1 and customer_id=${customer_id} and pay_to_check = 0";
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
	$query = "SELECT * from {$payment_table} WHERE sale_id = {$id} and reference_screen = 'billing_screen' and active = 1";
	return $data['paymentType'] = $wpdb->get_results($query);

}

// function getToken()
// {	
//     $token = "";
//     $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
//     $max = strlen($codeAlphabet); // edited

//     for ($i=0; $i < 50; $i++) {
//         $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
//     }

//     return $token;
// }
function prevBalance($type = '',$sale_id = 0){
	global $wpdb;
	$credit_table 			= $wpdb->prefix.'creditdebit';
	$query 					= "SELECT payment_amt FROM {$credit_table} WHERE sale_id =${sale_id} and payment_key ='${type}' order by id DESC limit 1";
	$getbalance 			= $wpdb->get_row( $query);
	$payment_amt = ($getbalance && isset($getbalance->payment_amt)) ? $getbalance->payment_amt : 0;
	return $payment_amt;

}
function updateDueCheck($id = 0){
	global  $wpdb;
	$table = $wpdb->prefix.'sale';
	$wpdb->update($table,array('pay_to_check' =>1),array('id'=>$id));
	return true;
}
?>