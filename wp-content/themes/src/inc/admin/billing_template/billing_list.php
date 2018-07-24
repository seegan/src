
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
		$delivery = $_POST['delivery'];
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
		$delivery = isset( $_GET['delivery'] ) ? $_GET['delivery']  : '-';
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


    if($delivery != '-') {
   		if($con == false) {
    		$condition .= " AND s1.invoice_status = '".$delivery."' ";
    	} else {
    		$condition .= " AND s1.invoice_status = '".$delivery."' ";
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

    $condition .= " AND s1.locked = 1 ";
    /*End Updated for filter 11/10/16*/


	$result_args = array(
		'orderby_field' => 's1.id',
		'page' => $cpage ,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
		'condition' => $condition,
	);
	$bills = billing_list_pagination_updated($result_args);

/*
echo "<pre>";
var_dump($bills);*/
?>
	<table class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Bill By</th>
				<th>Invoice No</th>
				<th>Bill Date</th>
				<th>Shop</th>
				<th>Customer Detail</th>
				<th>Discount</th>
				<th>Total</th>
				<th>Delivery</th>
				<th>Billing Details</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if(isset($bills['result']) AND $bills){
				$start_count = $bills['start_count'];

				foreach ($bills['result'] as $b_value) {
					$start_count++;

					if($b_value->invoice_status == 'pending') {
						$invoice_status = '<span class="c-pending">Waiting</span>';
					}
					if($b_value->invoice_status == 'process') {
						$invoice_status = '<span class="c-process">Process</span>';
					}
					if($b_value->invoice_status == 'delivered') {
						$invoice_status = '<span class="c-delivered">Delivered</span>';
					}
					$payment_done = ($b_value->payment_done == 0) ? '<div class="round-c payment-red"></div>' : '<div class="round-c payment-green"></div>';
		?>
			<tr id="customer-data-<?php echo $b_value->id; ?>">
				<td><?php echo $start_count; ?></td>
				<td><?php
					$made_by = get_userdata($b_value->made_by);
				 	echo ($made_by->user_login) ? $made_by->user_login : '-';
				?></td>
				<td style="position:relative;">
					<?php echo $b_value->invoice_id; ?>
					<?php echo $payment_done; ?>
				</td>
				<td><?php echo $b_value->invoice_date; ?></td>
				<td><?php echo $b_value->order_shop; ?></td>
				<td><?php echo $b_value->name.' ('.$b_value->mobile.')<br>('.$b_value->type .')'; ?></td>
				<td><?php echo $b_value->sale_discount_price; ?></td>
				<td>
					<?php echo 'Sale Total : '.$b_value->sale_total; ?><br>
					<?php echo 'Paid : '.$b_value->paid_total; ?><br>
					<?php echo 'To Be Paid : '.$b_value->to_be_paid; ?><br>

				</td>
				<td class="d-status" data-status-id="<?php echo $b_value->id; ?>"><?php echo $invoice_status; ?></td>
				<td>
					<a href="<?php echo admin_url('admin.php?page=new_bill').'&bill_no='.$b_value->id.'&action=invoice'; ?>">Billing Detail
					</a>
				</td>
				<td class="center">
					<span>
						<a href="<?php echo admin_url('admin.php?page=new_bill').'&bill_no='.$b_value->id.'&action=update'; ?>" class="action-icons c-edit" data-bill-id="<?php echo $b_value->id; ?>" title="Edit">Edit</a>
					</span>
					<span><a class="action-icons c-delete lot_delete" href="#" title="delete" data-id="<?php //echo $stock_value->id; ?>" data-roll="1">Delete</a></span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>
	<?php echo $bills['pagination']; ?>