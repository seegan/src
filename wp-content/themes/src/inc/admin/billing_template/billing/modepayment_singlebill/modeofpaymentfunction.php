<?php 
function PaymentCreate($payment_detail = '',$invoice_id = '',$customer_id = ''){
	var_dump($data);
	var_dump($payment_detail);
	die();
global $wpdb;
$payment_table = $wpdb->prefix.'wp_payment';
foreach ($params['payment_detail'] as $value) {
	if(isset($value['payment_type'])){			
		$payment_data = 	array(
			'reference_id' 		=> $value['reference_id'],
			'reference_screen' 	=> $value['reference_screen'],
			'uniquename' 		=> $value['uniquename'],
			'sale_id'  			=> $invoice_id,
			'payment_date'		=> date('Y-m-d'),
			'customer_id'		=> $customer_id,
			'payment_type'		=> $value['payment_type'],
			'amount'			=> $value['payment_amount'],
						);
		$wpdb->insert($payment_table, $payment_data);
   }
}
foreach ($params['payment_cash'] as $view) {
	if($view == 'credit_content'){
		$payment_data = 	array(
			'reference_id' 		=> $value['reference_id'],
			'reference_screen' 	=> $value['reference_screen'],
			'sale_id'  			=> $data['id'],
			'search_id'			=> $data['inv_id'],
			'year'				=> $data['year'],
			'payment_details'	=> '',
			'payment_date'		=> date('Y-m-d'),
			'customer_id'		=> $customer_id,
			'payment_type'		=> $params['pay_cheque'],
			'amount'			=> $params['pay_amount_cheque'],
			'pay_to' 			=> $pay_to_bal,
						);
		$wpdb->insert($payment_table, $payment_data);

	}		
}

}

function PaymentUpdate($payment_detail = '',$invoice_id = '',$customer_id = ''){
	global $wpdb;
	$payment_table = $wpdb->prefix.'wp_payment';
	$wpdb->update($payment_table, array('active' => 0), array('sale_id' => $data['id']));

	//$wpdb->update($payment_table_display, array('active' => 0), array('sale_id' => $data['id']));	

	foreach ($params['payment_detail'] as $value) {
		if(isset($value['payment_type'])){
			$payment_data = 	array(
				'reference_id' 		=> $value['reference_id'],
				'reference_screen' 	=> $value['reference_screen'],
				'sale_id'  			=> $data['id'],
				'search_id'			=> $data['inv_id'],
				'year'				=> $data['year'],
				'payment_details'	=> '',
				'payment_date'		=> date('Y-m-d'),
				'customer_id'		=> $customer_id,
				'payment_type'		=> $value['payment_type'],
				'amount'			=> $value['payment_amount'],
				'pay_to' 			=> $pay_to_bal,
				);
			$wpdb->insert($payment_table, $payment_data);
       }
	}
	if(isset($params['pay_amount_cheque'])) {
			$payment_data = 	array(
				'reference_id' 		=> $params['reference_id'],
				'reference_screen' 	=> $params['reference_screen'],
				'sale_id'  			=> $data['id'],
				'search_id'			=> $data['inv_id'],
				'year'				=> $data['year'],
				'payment_details'	=> '',
				'payment_date'		=> date('Y-m-d'),
				'customer_id'		=> $customer_id,
				'payment_type'		=> $params['pay_cheque'],
				'amount'			=> $params['pay_amount_cheque'],
				'pay_to' 			=> $pay_to_bal,
				);
			$wpdb->insert($payment_table, $payment_data);

	}
}

function check_balance_new() {

	global $wpdb;
	$id = $_POST['customer_id'];

	$sale_table = $wpdb->prefix.'sale';
	$credit_table = $wpdb->prefix.'credit';
	$debit_table = $wpdb->prefix.'debit';
	$query = "	SELECT * FROM {$credit_table} WHERE active = 1 
	union 
	SELECT * FROM {$credit_table} WHERE active = 1
    ORDER BY `modified_at` DESC LIMIT 1";

	if( $data = $wpdb->get_row( $query, ARRAY_A  ) ) {
		echo json_encode($data); 
	} else {
		return false;
	}
	die();
}
add_action( 'wp_ajax_check_balance_new', 'check_balance_new' );
add_action( 'wp_ajax_nopriv_check_balance_new', 'check_balance_new' );


?>