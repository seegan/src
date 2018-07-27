<?php 
function PaymentCreate($payment_detail = '',$payment_credit = '',$credit_amount = '',$invoice_id = '',$customer_id = '',$paytobalance = ''){

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


	$payfromprevious_data = array(
		'reference_screen' 	=> 'billing_screen',
		'sale_id'  			=> $invoice_id,
		'payment_date'		=> date('Y-m-d'),
		'customer_id'		=> $customer_id,
		'payment_type'		=> 'payfromprevious',
		'amount'			=> $paytobalance,
		);
	$wpdb->insert($payfromprevious_data, $payment_data);




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
	$credit_table 	= $wpdb->prefix.'creditdebit';
	$query 			= "SELECT * FROM {$credit_table} WHERE `active`=1 and `customer_id`= {$id} ORDER by `id` desc LIMIT 1";

	if( $data = $wpdb->get_row( $query, ARRAY_A  ) ) {
		echo json_encode($data); 
	} else {
		return false;
	}
	die();
}
add_action( 'wp_ajax_check_balance_ajax', 'check_balance_ajax' );
add_action( 'wp_ajax_nopriv_check_balance_ajax', 'check_balance_ajax' );


function check_balance($customer_id = 0) {

	global $wpdb;
	$credit_table 			= $wpdb->prefix.'creditdebit';
	$query 					= "SELECT balance FROM {$credit_table} WHERE active=1 and customer_id= {$customer_id} ORDER by id desc LIMIT 1";
	$getbalance 			= $wpdb->get_row( $query);
	$balance = ($getbalance && isset($getbalance->balance)) ? $getbalance->balance : 0;
	return $balance;
	
}





function AddOtherPayments($due_bal_input = 0, $codCheck = 0,$cod_amount = 0,$paymentCheck = 0,$to_pay = 0,$balance = 0,$sale_id = 0,$total_pay_without_prec = 0 ,$total_pay =0){
	global $wpdb;
	$sale_table = $wpdb->prefix.'sale';

	$data_update = array(
		'previous_due' 	=> $due_bal_input,
		'cod_check' 	=> $codCheck,
		'cod_amount' 	=> $cod_amount,
		'to_pay_check' 	=> $paymentCheck,
		'to_pay' 		=> $to_pay,
		'balance' 		=> $balance,
		'total_pay_without_prec' 		=> $total_pay_without_prec,
		'total_pay' 		=> $total_pay,
		);
	$wpdb->update($sale_table,$data_update,array('id'=>$sale_id));
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

?>