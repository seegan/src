<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'return_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$invoice_no = $_POST['invoice_no'];
		$customer_name = $_POST['customer_name'];
		$customer_type = $_POST['customer_type'];
		$return_from = $_POST['return_from'];
		$return_to = $_POST['return_to'];
	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$invoice_no = isset( $_GET['invoice_no'] ) ? $_GET['invoice_no']  : '';
		$customer_name = isset( $_GET['customer_name'] ) ? $_GET['customer_name']  : '';
		$customer_type = isset( $_GET['customer_type'] ) ? $_GET['customer_type']  : '-';
		$return_from = isset( $_GET['return_from'] ) ? $_GET['return_from']  : '';
		$return_to = isset( $_GET['return_to'] ) ? $_GET['return_to']  : '';
	}

    $con = false;
    $condition = '';
    if($invoice_no != '') {
    	if($con == false) {
    		$condition .= " AND s.invoice_id = '".$invoice_no."' ";
    	} else {
    		$condition .= " AND s.invoice_id = '".$invoice_no."' ";
    	}
    	$con = true;
    }
    if($customer_name != '') {
   		if($con == false) {
    		$condition .= " AND ( c.name LIKE '".$customer_name."%' OR c.mobile LIKE '".$customer_name."%' ) ";
    	} else {
    		$condition .= " AND ( c.name LIKE '".$customer_name."%' OR c.mobile LIKE '".$customer_name."%' ) ";
    	}
    	$con = true;
    }
    if($customer_type != '-') {
   		if($con == false) {
    		$condition .= " AND s.customer_type = '".$customer_type."' ";
    	} else {
    		$condition .= " AND s.customer_type = '".$customer_type."' ";
    	}
    	$con = true;
    }


    if($return_from != '' && $return_to == '') {
   		if($con == false) {
    		$condition .= " AND DATE(r.return_date) >= '".$return_to."' ";
    	} else {
    		$condition .= " AND DATE(r.return_date) >= '".$return_to."' ";
    	}
    	$con = true;
    }
    if($return_from == '' && $return_to != '') {
   		if($con == false) {
    		$condition .= " AND DATE(r.return_date) <= '".$return_from."' ";
    	} else {
    		$condition .= " AND DATE(r.return_date) <= '".$return_from."' ";
    	}
    	$con = true;
    }
    if($return_from != '' && $return_to != '') {
   		if($con == false) {
    		$condition .= " AND ( DATE(r.return_date) >= '".$return_from."' AND DATE(r.return_date) <= '".$return_to."' ) ";
    	} else {
    		$condition .= " AND ( DATE(r.return_date) >= '".$return_from."' AND DATE(r.return_date) <= '".$return_to."' ) ";
    	}
    	$con = true;
    }

    $condition .= " AND s.locked = 1 ";
    /*End Updated for filter 11/10/16*/


	$result_args = array(
		'orderby_field' => 'r.id',
		'page' => $cpage ,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
		'condition' => $condition,
	);
	$bills = return_list_pagination($result_args);
?>
	<table class="display">
		<thead>
			<tr>
				<th>Bill No</th>
                <th>Year</th>
				<th>Return Id</th>
				<th>Delivery Date</th>
				<th>Customer</th>
				<th>Bill type</th>
				<th>Detail</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if(isset($bills['result']) AND $bills){
				$start_count = $bills['start_count'];

				foreach ($bills['result'] as $b_value) {
					$start_count++;
		?>
			<tr id="return-data-<?php echo $b_value->return_id; ?>">
                <td><?php echo $b_value->invoice_id; ?></td>
				<td><?php echo $b_value->financial_year; ?></td>
                <td><?php echo 'GR'.$b_value->return_id; ?></td>
				<td><?php echo machine_to_man_date($b_value->return_date); ?></td>
				<td>
					<?php
						$customer_name = ($b_value->customer_id != 0) ? $b_value->customer_name : 'Counter Sale';
						echo $customer_name;
					?>
				</td>
				<td><?php echo ucfirst($b_value->customer_type); ?></td>
				<td>
					<a href="<?php echo admin_url('admin.php?page=bill_return').'&return_id='.$b_value->return_id.'&action=view'; ?>">Return Detail
					</a> | 
                    <a href="<?php echo menu_page_url( 'bill_return', 0 ).'&return_id='.$b_value->return_id.'&action=view&triger=print'; ?>">Print Return
                    </a>
				</td>
				<td class="center">
					<span>
						<a class="action-icons c-edit list_update " href="<?php echo admin_url('admin.php?page=bill_return').'&return_id='.$b_value->return_id.'&action=update'; ?>" class="action-icons c-edit" data-bill-id="<?php echo $b_value->id; ?>" title="Edit">Edit</a>
					</span>
					<span><a class="action-icons c-delete return_delete last_list_view" href="#" title="delete" data-action="return" data-id="<?php echo $b_value->return_id; ?>" data-roll="1">Delete</a></span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>
	<?php echo $bills['pagination']; ?>