<?php
function sale_return($value='')
{
	global $wpdb;
	$data['success'] = 0;
	$return_table 			= $wpdb->prefix. 'return';
	$return_detail_table 		= $wpdb->prefix. 'return_detail';
	$params = array();
	parse_str($_POST['return_data'], $params);

	$sale_id = $params['sale_id'];
	$return_date = man_to_machine_date($params['return_date']);

	$wpdb->insert($return_table, array('sale_id' => $sale_id, 'return_date' => $return_date));

	$return_id = 0;
	if( $return_id = $wpdb->insert_id ) {
		$data['success'] = 1;
		$data['return_id'] = $return_id;
	}
	
	if(isset($params['return_data']) && $params['return_data']) {
		foreach ($params['return_data'] as $return) {
			if($return['return_weight'] > 0) {
				$return_data = array( 'return_id' => $return_id, 'sale_id' => $sale_id, 'sale_detail_id' => $return['sale_detail'],'lot_id' => $return['return_lot'], 'return_weight' => $return['return_weight'] );
				$wpdb->insert($return_detail_table, $return_data);			
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
	$wpdb->update($return_table, array('return_date' => $return_date), array('id' => $return_id));

	
	if(isset($params['return_data']) && $params['return_data']) {
		foreach ($params['return_data'] as $return) {
			$return_data = array( 'return_weight' => $return['return_weight'] );
			$wpdb->update($return_detail_table, $return_data, array('id' => $return['return_detail_id']));			
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