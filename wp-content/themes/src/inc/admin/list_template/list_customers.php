<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'customer_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$customer_name = $_POST['customer_name'];
		$customer_mobile_list = $_POST['customer_mobile_list'];
		$customer_type = $_POST['customer_type'];
		$payment_status = $_POST['payment_status'];
	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$customer_name = isset( $_GET['customer_name'] ) ? $_GET['customer_name']  : '';
		$customer_mobile_list = isset( $_GET['customer_mobile_list'] ) ? $_GET['customer_mobile_list']  : '';
		$customer_type = isset( $_GET['customer_type'] ) ? $_GET['customer_type']  : '';
		$payment_status = isset( $_GET['payment_status'] ) ? $_GET['payment_status']  : '';
	}

    $con = false;
    $condition = '';
    if($customer_name != '') {
    	if($con == false) {
    		$condition .= " AND name LIKE '".$customer_name."%' ";
    	} else {
    		$condition .= " AND name LIKE '".$customer_name."%' ";
    	}
    	$con = true;
    }
    if($customer_mobile_list != '') {
   		if($con == false) {
    		$condition .= " AND mobile LIKE '".$customer_mobile_list."%' ";
    	} else {
    		$condition .= " AND mobile LIKE '".$customer_mobile_list."%' ";
    	}
    	$con = true;
    }
    if($customer_type != '' AND $customer_type != '-') {
   		if($con == false) {
    		$condition .= " AND type = '".$customer_type."' ";
    	} else {
    		$condition .= " AND type = '".$customer_type."' ";
    	}
    	$con = true;
    }

     if($payment_status != '' AND $payment_status != '-') {
   		if($con == false) {
   			if($payment_status == 0){
   				$condition .= " AND ( CASE WHEN (s1.customer_pending) IS NULL THEN 0.00 ELSE (s1.customer_pending) END ) > 0 AND ( CASE WHEN (s1.actual_sale) IS NULL THEN 0.00 ELSE (s1.actual_sale) END ) > 0 ";
   			} else {
   				$condition .= " AND ( CASE WHEN (s1.customer_pending) IS NULL THEN 0.00 ELSE (s1.customer_pending) END ) = 0 AND ( CASE WHEN (s1.actual_sale) IS NULL THEN 0.00 ELSE (s1.actual_sale) END ) > 0 ";
   			}
    		
    	} else {
    		if($payment_status == 0){
   				$condition .= " AND ( CASE WHEN (s1.customer_pending) IS NULL THEN 0.00 ELSE (s1.customer_pending) END ) > 0 AND ( CASE WHEN (s1.actual_sale) IS NULL THEN 0.00 ELSE (s1.actual_sale) END ) > 0 ";
   			} else {
   				$condition .= " AND ( CASE WHEN (s1.customer_pending) IS NULL THEN 0.00 ELSE (s1.customer_pending) END ) = 0 AND ( CASE WHEN (s1.actual_sale) IS NULL THEN 0.00 ELSE (s1.actual_sale) END ) > 0 ";
   			}
    	}
    	$con = true;
    }

var_dump($condition);
	/*End Updated for filter 11/10/16*/

	$result_args = array(
		'orderby_field' => 'id',
		'page' => $cpage ,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
		'condition' => $condition,
	);
	$customers = customer_list_pagination($result_args);

?>
	<table class="display">
		<thead>
			<tr>
				<!--<th>S.No</th>-->
				<th>Customer Name /<br>Phone Number</th>
				<th>Address</th>
				<th>Customer Type</th>
				<th>Gst Number</th>
				<th>Payment Type</th>
				<th>Purchase Value</th>
				<th>Paid Amout</th>
				<th>Due Amout</th>
				<th>Payment</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if( count($customers['result'])>0 ) {
				$start_count = $customers['start_count'];
				foreach ($customers['result'] as $customer_value) {
					$sale  = ($customer_value->payment_due == 0 && $customer_value->sale_total == 0 ) ? '<span class="c-notpurchase">Not Buy</span>' : '<span class="c-delivered">PAID</span>';
					$payment_done = ($customer_value->payment_due > 0 && $customer_value->sale_total > 0  ) ? '<span class="c-process">DUE</span>' : $sale ;
					$start_count++;
		?>
			<tr id="customer-data-<?php echo $customer_value->id; ?>">
				<!--<td><?php echo $start_count; ?></td>-->
				<td>
					<?php echo $customer_value->name; ?><br>
					(<?php echo $customer_value->mobile; ?>)
				</td>
				<td><?php echo $customer_value->address; ?></td>
				<td><?php echo $customer_value->type; ?></td>
				<td><?php echo $customer_value->gst_number; ?></td>
				<td><?php echo ucfirst( $customer_value->payment_type ); ?></td>
				<td><?php echo $customer_value->sale_total; ?></td>
				<td><?php echo $customer_value->paid_total; ?></td>
				<td><?php echo $customer_value->payment_due; ?></td>
				<td class="d-status" style="position:relative;"><?php echo $payment_done; ?></td>
				<td class="center">
					<span>
						<a class="action-icons c-edit customer_edit list_update" title="Edit" href="#" data-roll="<?php echo $start_count; ?>" data-id="<?php echo $customer_value->id; ?>">Edit</a>
					</span>
					<span><a class="action-icons c-delete user_delete last_list_view" href="#" data-action="customers" title="delete" data-id="<?php echo $customer_value->id; ?>" data-roll="<?php echo $start_count; ?>">Delete</a></span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>

	<?php echo $customers['pagination']; ?>