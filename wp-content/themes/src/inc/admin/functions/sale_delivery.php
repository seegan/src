<?php
function sale_delivery_aj($value='', $delivery_boy='') {
	global $wpdb;
	$data['success'] = 0;
	$delivery_table 			= $wpdb->prefix. 'delivery';
	$delivery_detail_table 		= $wpdb->prefix. 'delivery_detail';
	$params = array();
	parse_str($_POST['delivery_data'], $params);

	$sale_id = $params['sale_id'];
	$delivery_boy = $params['delivery_boy'];

	$delivery_date = man_to_machine_date($params['delivery_date']);

	$wpdb->insert($delivery_table, array('sale_id' => $sale_id, 'delivery_boy' => $delivery_boy,  'delivery_date' => $delivery_date));
	$delivery_id = 0;
	if($delivery_id = $wpdb->insert_id) {
		$data['success'] = 1;
		$data['delivery_id'] = $delivery_id;
	}

	if(isset($params['delivery_data']) && $params['delivery_data']) {
		foreach ($params['delivery_data'] as $delivery) {
			if($delivery['delivery_weight'] > 0) {
				$delivery_data = array( 'delivery_id' => $delivery_id, 'sale_id' => $sale_id, 'sale_detail_id' => $delivery['sale_detail'],'lot_id' => $delivery['delivery_lot'], 'delivery_as' => $delivery['delivery_as'], 'user_weight' => $delivery['user_unit'], 'bag_weight' => $delivery['bag_weight'], 'delivery_weight' => $delivery['delivery_weight'] );
				$wpdb->insert($delivery_detail_table, $delivery_data);			
			}
		}
	}
	checkDeliveryAndUpdate($sale_id);


	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_sale_delivery_aj', 'sale_delivery_aj' );
add_action( 'wp_ajax_nopriv_sale_delivery_aj', 'sale_delivery_aj' );

function sale_delivery_update($value='')
{
	global $wpdb;
	$data['success'] = 0;
	$delivery_table 			= $wpdb->prefix. 'delivery';
	$delivery_detail_table 		= $wpdb->prefix. 'delivery_detail';
	$params = array();
	parse_str($_POST['delivery_data'], $params);

	$sale_id = $params['sale_id'];
	$delivery_date = man_to_machine_date($params['delivery_date']);
	$delivery_id = $params['delivery_id'];
	$wpdb->update($delivery_table, array('delivery_date' => $delivery_date), array('id' => $delivery_id));

	if(isset($params['delivery_data']) && $params['delivery_data']) {
		foreach ($params['delivery_data'] as $delivery) {
			$delivery_data = array( 'delivery_weight' => $delivery['delivery_weight'] );
			$wpdb->update($delivery_detail_table, $delivery_data, array('id' => $delivery['delivery_detail_id']));			
		}
	}

	checkDeliveryAndUpdate($sale_id);

	$data['success'] = 1;
	$data['delivery_id'] = $delivery_id;

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_sale_delivery_update', 'sale_delivery_update' );
add_action( 'wp_ajax_nopriv_sale_delivery_update', 'sale_delivery_update' );


function sale_delivery($delivery_data, $delivery_boy = '') {
	global $wpdb;
	$data['success'] = 0;
	$delivery_table 			= $wpdb->prefix. 'delivery';
	$delivery_detail_table 		= $wpdb->prefix. 'delivery_detail';

	$sale_id = $delivery_data['sale_id'];

	$delivery_date = date('Y-m-d');
	$wpdb->insert($delivery_table, array('sale_id' => $sale_id, 'delivery_boy' => $delivery_boy, 'delivery_date' => $delivery_date));

	$delivery_id = 0;
	if($delivery_id = $wpdb->insert_id) {
		$data['success'] = 1;
		$data['delivery_id'] = $delivery_id;
	}

	if(isset($delivery_data['delivery_data']) && count($delivery_data['delivery_data'])>0) {
		foreach ($delivery_data['delivery_data'] as $delivery) {
			if( $delivery->delivery_balance > 0) {
				$delivery_data = array( 'delivery_id' => $delivery_id, 'sale_id' => $sale_id, 'sale_detail_id' => $delivery->id,'lot_id' => $delivery->lot_id, 'delivery_weight' => $delivery->delivery_balance );
				$wpdb->insert($delivery_detail_table, $delivery_data);
			}

		}
	}
	checkDeliveryAndUpdate($sale_id);
	return $data;
}

function delveryall_aj() {
	$ret_data['success'] = 0;
	$sale_id   = $_POST['bill_no'];
	$delivery_boy   = $_POST['delivery_boy'];
	$sales = getSalesList($sale_id);
	if($sales && is_array($sales) && count($sales)>0) {
		$data['sale_id'] = $sale_id;
		$data['delivery_data'] = $sales;
		$ret_data = sale_delivery($data, $delivery_boy);
	}
	echo json_encode($ret_data);
	die();
}
add_action( 'wp_ajax_delveryall_aj', 'delveryall_aj');
add_action( 'wp_ajax_nopriv_delveryall_aj', 'delveryall_aj');



function checkDeliveryAndUpdate($sale_id) {
	global $wpdb;
	$sale_table 			= $wpdb->prefix. 'sale';
	$sales = getSalesList($sale_id);
	if($sales && is_array($sales)) {
		$bal = 0;
		if(count($sales)>0) {
			foreach ($sales as $delivery) {
				if( $delivery->delivery_balance > 0) {
					$bal = $bal + $delivery->delivery_balance;
				}
			}
		}
		$delivered = ($bal == 0) ? 1 : 0;
		$wpdb->update($sale_table, array('is_delivered' => $delivered), array('id'=>$sale_id));
	}
}


?>