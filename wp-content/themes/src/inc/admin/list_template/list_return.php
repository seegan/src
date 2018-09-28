<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'bill_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$invoice_no = $_POST['invoice_no'];
		$customer_name = $_POST['customer_name'];
		$bill_total = $_POST['bill_total'];
		
		$customer_type = $_POST['customer_type'];
		$shop = $_POST['shop'];
		$return = $_POST['return'];
		$payment_done = $_POST['payment_done'];

		$date_from = $_POST['date_from'];
		$date_to = $_POST['date_to'];
	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$invoice_no = isset( $_GET['invoice_no'] ) ? $_GET['invoice_no']  : '';
		$customer_name = isset( $_GET['customer_name'] ) ? $_GET['customer_name']  : '';
		$bill_total = isset( $_GET['bill_total'] ) ? $_GET['bill_total']  : '';
		
		$customer_type = isset( $_GET['customer_type'] ) ? $_GET['customer_type']  : '-';
		$shop = isset( $_GET['shop'] ) ? $_GET['shop']  : '-';
		$return = isset( $_GET['return'] ) ? $_GET['return']  : '-';
		$payment_done = isset( $_GET['payment_done'] ) ? $_GET['payment_done']  : '-';

		$date_from = isset( $_GET['date_from'] ) ? $_GET['date_from']  : '';
		$date_to = isset( $_GET['date_to'] ) ? $_GET['date_to']  : '';
	}

	$bill_data = explode("-",$bill_total);
	$price = isset($bill_data[0]) ? trim($bill_data[0]) : '';
	$price_to = isset($bill_data[1]) ? trim($bill_data[1]) : '';


    $con = false;
    $condition = '';
    if($invoice_no != '') {
    	if($con == false) {
    		$condition .= " AND s1.invoice_id = '".$invoice_no."' ";
    	} else {
    		$condition .= " AND s1.invoice_id = '".$invoice_no."' ";
    	}
    	$con = true;
    }
    if($customer_name != '') {
   		if($con == false) {
    		$condition .= " AND ( s1.name LIKE '".$customer_name."%' OR s1.mobile LIKE '".$customer_name."%' ) ";
    	} else {
    		$condition .= " AND ( s1.name LIKE '".$customer_name."%' OR s1.mobile LIKE '".$customer_name."%' ) ";
    	}
    	$con = true;
    }
    if($customer_type != '-') {
   		if($con == false) {
    		$condition .= " AND s1.type = '".$customer_type."' ";
    	} else {
    		$condition .= " AND s1.type = '".$customer_type."' ";
    	}
    	$con = true;
    }

    if($shop != '-') {
   		if($con == false) {
    		$condition .= " AND s1.order_shop = '".$shop."' ";
    	} else {
    		$condition .= " AND s1.order_shop = '".$shop."' ";
    	}
    	$con = true;
    }


    if($return != '-') {
   		if($con == false) {
    		$condition .= " AND s1.invoice_status = '".$return."' ";
    	} else {
    		$condition .= " AND s1.invoice_status = '".$return."' ";
    	}
    	$con = true;
    }

    if($payment_done != '-') {
   		if($con == false) {
    		$condition .= " AND s1.payment_done = '".$payment_done."' ";
    	} else {
    		$condition .= " AND s1.payment_done = '".$payment_done."' ";
    	}
    	$con = true;
    }

    if($price != '' && $price_to == '') {
   		if($con == false) {
    		$condition .= " AND s1.sale_total = ".$price." ";
    	} else {
    		$condition .= " AND s1.sale_total = ".$price." ";
    	}
    	$con = true;
    }

    if($price != '' && $price_to != '') {
   		if($con == false) {
    		$condition .= " AND ( s1.sale_total >= ".$price." AND s1.sale_total <= ".$price_to.") ";
    	} else {
    		$condition .= " AND ( s1.sale_total >= ".$price." AND s1.sale_total <= ".$price_to.") ";
    	}
    	$con = true;
    }

    if($date_from != '' && $date_to == '') {
   		if($con == false) {
    		$condition .= " AND DATE(s1.invoice_date) >= '".$date_to."' ";
    	} else {
    		$condition .= " AND DATE(s1.invoice_date) >= '".$date_to."' ";
    	}
    	$con = true;
    }
    if($date_from == '' && $date_to != '') {
   		if($con == false) {
    		$condition .= " AND DATE(s1.invoice_date) <= '".$date_from."' ";
    	} else {
    		$condition .= " AND DATE(s1.invoice_date) <= '".$date_from."' ";
    	}
    	$con = true;
    }
    if($date_from != '' && $date_to != '') {
   		if($con == false) {
    		$condition .= " AND ( DATE(s1.invoice_date) >= '".$date_from."' AND DATE(s1.invoice_date) <= '".$date_to."' ) ";
    	} else {
    		$condition .= " AND ( DATE(s1.invoice_date) >= '".$date_from."' AND DATE(s1.invoice_date) <= '".$date_to."' ) ";
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
				<td><?php echo $b_value->return_date; ?></td>
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
						<a class="list_update" href="<?php echo admin_url('admin.php?page=bill_return').'&return_id='.$b_value->return_id.'&action=update'; ?>" class="action-icons c-edit" data-bill-id="<?php echo $b_value->id; ?>" title="Edit">Edit</a>
					</span>
					<span><a class="action-icons c-delete return_delete last_list_view" href="#" title="delete" data-id="<?php //echo $stock_value->id; ?>" data-roll="1">Delete</a></span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>
	<?php echo $bills['pagination']; ?>