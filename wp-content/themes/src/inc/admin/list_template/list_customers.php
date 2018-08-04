<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'customer_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$customer_name = $_POST['customer_name'];
		$customer_mobile = $_POST['customer_mobile'];
		$customer_type = $_POST['customer_type'];
	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$customer_name = isset( $_GET['customer_name'] ) ? $_GET['customer_name']  : '';
		$customer_mobile = isset( $_GET['customer_mobile'] ) ? $_GET['customer_mobile']  : '';
		$customer_type = isset( $_GET['customer_type'] ) ? $_GET['customer_type']  : '';
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
    if($customer_mobile != '') {
   		if($con == false) {
    		$condition .= " AND mobile LIKE '".$customer_mobile."%' ";
    	} else {
    		$condition .= " AND mobile LIKE '".$customer_mobile."%' ";
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
				<th>S.No</th>
				<th>Customer Name</th>
				<th>Address</th>
				<th>Customer Type</th>
				<th>Gst Number</th>
				<th>Payment Type</th>
				<th>Purchase Value</th>
				<th>Total Paid</th>
				<th>Payment Due</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if( count($customers['result'])>0 ) {
				$start_count = $customers['start_count'];
				foreach ($customers['result'] as $customer_value) {
					$start_count++;
		?>
			<tr id="customer-data-<?php echo $customer_value->id; ?>">
				<td><?php echo $start_count; ?></td>
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
				<td class="center">
					<span>
						<a class="action-icons c-edit customer_edit" title="Edit" data-roll="<?php echo $start_count; ?>" data-id="<?php echo $customer_value->id; ?>">Edit</a>
					</span>
					<span><a class="action-icons c-delete user_delete" href="#" data-action="customers" title="delete" data-id="<?php echo $customer_value->id; ?>" data-roll="<?php echo $start_count; ?>">Delete</a></span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>

	<?php echo $customers['pagination']; ?>