
<?php 
	$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
	$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 10;
	$invoice_no = isset( $_GET['invoice_no'] ) ? $_GET['invoice_no']  : '';
	$customer_name = isset( $_GET['customer_name'] ) ? $_GET['customer_name']  : '';
	$bill_total = isset( $_GET['bill_total'] ) ? $_GET['bill_total']  : '';
	$customer_type = isset( $_GET['customer_type'] ) ? $_GET['customer_type']  : '-';
	$delivery = isset( $_GET['delivery'] ) ? $_GET['delivery']  : '-';

	$date_from = isset( $_GET['date_from'] ) ? $_GET['date_from']  : '';
	$date_to = isset( $_GET['date_to'] ) ? $_GET['date_to']  : '';


	$bill_data = explode("-",$bill_total);
	$price = isset($bill_data[0]) ? trim($bill_data[0]) : '';
	$price_to = isset($bill_data[1]) ? trim($bill_data[1]) : '';


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
    		$condition .= " AND c.type = '".$customer_type."' ";
    	} else {
    		$condition .= " AND c.type = '".$customer_type."' ";
    	}
    	$con = true;
    }

    if($delivery != '-') {
   		if($con == false) {
    		$condition .= " AND s.invoice_status = '".$delivery."' ";
    	} else {
    		$condition .= " AND s.invoice_status = '".$delivery."' ";
    	}
    	$con = true;
    }


    if($price != '' && $price_to == '') {
   		if($con == false) {
    		$condition .= " AND s.sale_total = ".$price." ";
    	} else {
    		$condition .= " AND s.sale_total = ".$price." ";
    	}
    	$con = true;
    }

    if($price != '' && $price_to != '') {
   		if($con == false) {
    		$condition .= " AND ( s.sale_total >= ".$price." AND s.sale_total <= ".$price_to.") ";
    	} else {
    		$condition .= " AND ( s.sale_total >= ".$price." AND s.sale_total <= ".$price_to.") ";
    	}
    	$con = true;
    }

    if($date_from != '' && $date_to == '') {
   		if($con == false) {
    		$condition .= " AND DATE(s.invoice_date) >= '".$date_to."' ";
    	} else {
    		$condition .= " AND DATE(s.invoice_date) >= '".$date_to."' ";
    	}
    	$con = true;
    }
    if($date_from == '' && $date_to != '') {
   		if($con == false) {
    		$condition .= " AND DATE(s.invoice_date) <= '".$date_from."' ";
    	} else {
    		$condition .= " AND DATE(s.invoice_date) <= '".$date_from."' ";
    	}
    	$con = true;
    }
    if($date_from != '' && $date_to != '') {
   		if($con == false) {
    		$condition .= " AND ( DATE(s.invoice_date) >= '".$date_from."' AND DATE(s.invoice_date) <= '".$date_to."' ) ";
    	} else {
    		$condition .= " AND ( DATE(s.invoice_date) >= '".$date_from."' AND DATE(s.invoice_date) <= '".$date_to."' ) ";
    	}
    	$con = true;
    }
    /*End Updated for filter 11/10/16*/


	$result_args = array(
		'orderby_field' => 's.id',
		'page' => $cpage ,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
		'condition' => $condition,
	);
	$bills = billing_list_pagination($result_args);


?>
<div class="widget-content module table-simple list_customers">
	<table class="display">
		<thead>
			<tr>
				<th>Bill No</th>
				<th>Date</th>
				<th>Customer</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if(isset($bills['result']) AND count($bills['result']) > 0 AND $bills){
				$start_count = $bills['start_count'];

				foreach ($bills['result'] as $b_value) {
					$start_count++;
		?>
			<tr id="customer-data-<?php echo $b_value->id; ?>">
				<td><?php echo $b_value->invoice_id; ?></td>
				<td><?php echo date('Y-m-d', strtotime($b_value->invoice_date)); ?></td>
				<td><?php echo $b_value->name; ?></td>
				<td><?php echo $b_value->invoice_status; ?></td>
			</tr>
		<?php
				}
			} else {
				echo "<tr><td colspan='12'>No Sale Made Today!</td></tr>";
			}
		?>
		</tbody>
	</table>
	<?php echo $bills['pagination']; ?>
	<div style="clear:both;"></div>
</div>








