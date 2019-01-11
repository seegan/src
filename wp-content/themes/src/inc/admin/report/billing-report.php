

	<div id="custom-id" class="welcome-panel" style="display: none;">
		<div class="welcome-panel-content">


<?php

	$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
	$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 10;
	$invoice_no = isset( $_GET['invoice_no'] ) ? $_GET['invoice_no']  : '';
	$customer_name = isset( $_GET['customer_name'] ) ? $_GET['customer_name']  : '';
	$bill_total = isset( $_GET['bill_total'] ) ? $_GET['bill_total']  : '';
	$customer_type = isset( $_GET['customer_type'] ) ? $_GET['customer_type']  : '-';
	$delivery = isset( $_GET['delivery'] ) ? $_GET['delivery']  : '-';

	$date_from = isset( $_GET['date_from'] ) ? $_GET['date_from']  : date('Y-m-d', time());
	$date_to = isset( $_GET['date_to'] ) ? $_GET['date_to']  : date('Y-m-d', time());


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

/*echo "<pre>";
var_dump($bills);*/
?>
<div class="widget-content module table-simple list_customers">
	<table class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Bill By</th>
				<th>Invoice No</th>
				<th>Bill Date</th>
				<th>Shop</th>
				<th>Customer Detail</th>
				<th>Customer Type</th>
				<th>Discount</th>
				<th>Total</th>
				<th>Delivery</th>
				<th>Billing Details</th>
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
				<td><?php echo $start_count; ?></td>
				<td><?php 
					$made_by = get_userdata($b_value->made_by);
				 	echo ($made_by->user_login) ? $made_by->user_login : '-';
				?></td>
				<td><?php echo $b_value->invoice_id; ?></td>
				<td><?php echo $b_value->invoice_date; ?></td>
				<td><?php echo $b_value->order_shop; ?></td>
				<td><?php echo $b_value->name.' ('.$b_value->mobile.')'; ?></td>
				<td><?php echo $b_value->type; ?></td>
				<td><?php echo $b_value->sale_discount_price; ?></td>
				<td><?php echo $b_value->sale_total; ?></td>
				<td><?php echo $b_value->invoice_status; ?></td>
				<td><a href="<?php echo admin_url('admin.php?page=new_bill').'&bill_no='.$b_value->id.'&action=invoice'; ?>">Billing Detail</a></td>
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
</div>














		</div>
	</div>
	<script>
		jQuery(document).ready(function($) {
			$('#welcome-panel').after($('#custom-id').show());
		});
	</script>
