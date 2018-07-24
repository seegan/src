<?php
function sale_delivery($value='') {
	global $wpdb;
	$data['success'] = 0;
	$delivery_table 			= $wpdb->prefix. 'delivery';
	$delivery_detail_table 		= $wpdb->prefix. 'delivery_detail';
	$params = array();
	parse_str($_POST['delivery_data'], $params);

	$sale_id = $params['sale_id'];
	$delivery_date = man_to_machine_date($params['delivery_date']);

	$wpdb->insert($delivery_table, array('sale_id' => $sale_id, 'delivery_date' => $delivery_date));
	
	$delivery_id = 0;
	if($delivery_id = $wpdb->insert_id) {
		$data['success'] = 1;
		$data['delivery_id'] = $delivery_id;
	}


	if(isset($params['delivery_data']) && $params['delivery_data']) {
		foreach ($params['delivery_data'] as $delivery) {
			if($delivery['delivery_weight'] > 0) {
				$delivery_data = array( 'delivery_id' => $delivery_id, 'sale_id' => $sale_id, 'sale_detail_id' => $delivery['sale_detail'],'lot_id' => $delivery['delivery_lot'], 'delivery_weight' => $delivery['delivery_weight'] );
				$wpdb->insert($delivery_detail_table, $delivery_data);			
			}

		}
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_sale_delivery', 'sale_delivery' );
add_action( 'wp_ajax_nopriv_sale_delivery', 'sale_delivery' );



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

	$data['success'] = 1;
	$data['delivery_id'] = $delivery_id;

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_sale_delivery_update', 'sale_delivery_update' );
add_action( 'wp_ajax_nopriv_sale_delivery_update', 'sale_delivery_update' );
?>