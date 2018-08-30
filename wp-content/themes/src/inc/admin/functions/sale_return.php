<?php
function sale_return($value='')
{
	global $wpdb;
	$data['success'] = 0;
	$return_table 				= $wpdb->prefix. 'return';
	$return_detail_table 		= $wpdb->prefix. 'return_detail';
	$params = array();
	parse_str($_POST['return_data'], $params);

	$sale_id = $params['sale_id'];
	$return_date = man_to_machine_date($params['return_date']);	
	$pay_to_bal = ($params['return_to_check'])? $params['return_to_bal'] : 0;
	$return_data = array(
		'sale_id' => $sale_id, 
		'customer_id' => $params['customer_id'],
		'total_amount' => $params['total_return'],
		'key_amount' => $pay_to_bal,
		'gst_from'   => $params['gst_from'],
		'return_date' => $return_date,
		);
	$wpdb->insert($return_table,$return_data);

	$return_id = 0;
	if( $return_id = $wpdb->insert_id ) {
		$data['success'] = 1;
		$data['return_id'] = $return_id;
	}
	
	if(isset($params['return_data']) && $params['return_data']) {

		foreach ($params['return_data'] as $return) {
			if($return['return_weight'] > 0) {
				$return_details = array( 
					'return_id' => $return_id, 
					'sale_id'  => $sale_id, 
					'sale_detail_id' => $return['sale_detail'],
					'lot_id' => $return['return_lot'], 
					'bill_type' =>$return['bill_type'],
					'return_as' => $return['return_as'],
					'user_weight' => $return['user_unit'],
					'bag_weight' => $return['bag_weight'],
					'return_weight' => $return['return_weight'],
					'amt_per_kg'   =>  $return['amt_per_kg'],
					'taxless_amount'   =>  $return['taxless_amt'],
					'subtotal'   =>  $return['return_amt'],
					);

				$wpdb->insert($return_detail_table, $return_details);
				$details_id = $wpdb->insert_id;
				if($params['gst_from'] == 'cgst'){
					$gst = array(
					'cgst'   =>  $return['cgst_percentage'],
					'cgst_value'   =>  $return['cgst_amt'],
					'sgst'   =>  $return['sgst_percentage'],
					'sgst_value'   =>  $return['sgst_amt'],
					
						);
				} elseif ($params['gst_from'] == 'igst') {
					$gst= array(
						'igst'   		=>  $return['igst_percentage'],
						'igst_value'    =>  $return['igst_amt'],
						);
				} else {
					$gst = array();
				}
			$wpdb->update($return_detail_table, $gst, array('id' => $details_id));

				$query = "SELECT lot_parent_id, bill_type FROM wp_sale_detail WHERE id = '".$return['sale_detail']."' AND active = 1";
				$exist_data = $wpdb->get_row($query);
				if($exist_data->bill_type == 'original') {

					addReturn($exist_data->lot_parent_id, $return['return_weight']);
				}
			}

		}
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_sale_return', 'sale_return' );
add_action( 'wp_ajax_nopriv_sale_return', 'sale_return' );



function sale_return_update($value='')
{
	global $wpdb;
	$data['success'] = 0;
	$return_table 			= $wpdb->prefix. 'return';
	$return_detail_table 		= $wpdb->prefix. 'return_detail';
	$params = array();
	parse_str($_POST['return_data'], $params);

	$sale_id = $params['sale_id'];
	$return_date = man_to_machine_date($params['return_date']);
	$return_id = $params['return_id'];



	$pay_to_bal = ($params['return_to_check'])? $params['return_to_bal'] : 0;
	$return_data = array(
		'sale_id' => $sale_id, 
		'customer_id' => $params['customer_id'],
		'total_amount' => $params['total_return'],
		'gst_from'   => $params['gst_from'],
		'return_date' => $return_date,
		);

	$wpdb->update($return_table, $return_data, array('id' => $return_id));
	$sql_update = "UPDATE $return_table set key_amount = key_amount + $pay_to_bal WHERE id = $return_id";
	$wpdb->query($sql_update);
	
	if(isset($params['return_data']) && $params['return_data']) {
		foreach ($params['return_data'] as $return) {

			$query = "SELECT sd.lot_parent_id, sd.bill_type, rd.return_weight FROM wp_sale_detail as sd JOIN wp_return_detail as rd ON sd.id = rd.sale_detail_id WHERE sd.id = '".$return['sale_detail']."' AND rd.id = ".$return['return_detail_id']." AND sd.active = 1 AND rd.active = 1";
			$exist_data = $wpdb->get_row($query);

			$return_data = array( 
				'bill_type'			=>  $return['bill_type'],
				'return_weight' 	=>  $return['return_weight'],
				'amt_per_kg'   		=>  $return['amt_per_kg'],
				'taxless_amount'   	=>  $return['taxless_amt'],
				'subtotal'   		=>  $return['return_amt'],
				 );
			$wpdb->update($return_detail_table, $return_data, array('id' => $return['return_detail_id']));

			if($params['gst_from'] == 'cgst'){
					$gst = array(
					'cgst'   =>  $return['cgst_percentage'],
					'cgst_value'   =>  $return['cgst_amt'],
					'sgst'   =>  $return['sgst_percentage'],
					'sgst_value'   =>  $return['sgst_amt'],
					
						);
				} elseif ($params['gst_from'] == 'igst') {
					$gst= array(
						'igst'   		=>  $return['igst_percentage'],
						'igst_value'    =>  $return['igst_amt'],
						);
				} else {
					$gst = array();
				}
			$wpdb->update($return_detail_table, $gst, array('id' => $return['return_detail_id']));

			
			$actual_return = $exist_data->return_weight - $return['return_weight'];

			if($exist_data->bill_type == 'original') {
				lessReturn($exist_data->lot_parent_id, $actual_return);
			}

		}
	}

	$data['success'] = 1;
	$data['return_id'] = $return_id;

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_sale_return_update', 'sale_return_update' );
add_action( 'wp_ajax_nopriv_sale_return_update', 'sale_return_update' );
?>