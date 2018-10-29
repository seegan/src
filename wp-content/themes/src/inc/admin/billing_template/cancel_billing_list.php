
<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'cancel_bill_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$invoice_no = $_POST['invoice_no'];
		$customer_name = $_POST['customer_name'];
		$bill_total = $_POST['bill_total'];
		
		$customer_type = $_POST['customer_type'];
		//$shop = $_POST['shop'];
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
		//$shop = isset( $_GET['shop'] ) ? $_GET['shop']  : '-';
		$delivery = isset( $_GET['delivery'] ) ? $_GET['delivery']  : '-';
		$payment_done = isset( $_GET['payment_done'] ) ? $_GET['payment_done']  : '-';

		$date_from = isset( $_GET['date_from'] ) ? $_GET['date_from']  : '';
		$date_to = isset( $_GET['date_to'] ) ? $_GET['date_to']  : '';
	}

	$bill_data = explode("-",$bill_total);
	$price     = isset($bill_data[0]) ? trim($bill_data[0]) : '';
	$price_to  = isset($bill_data[1]) ? trim($bill_data[1]) : '';


    $con = false;
    $condition = '';
    if($invoice_no != '') {
    	if($con == false) {
    		$condition .= " AND full_table.invoice_id = '".$invoice_no."' ";
    	} else {
    		$condition .= " AND full_table.invoice_id = '".$invoice_no."' ";
    	}
    	$con = true;
    }
    if($customer_name != '') {
   		if($con == false) {
    		$condition .= " AND ( full_table.name LIKE '".$customer_name."%' OR full_table.mobile LIKE '".$customer_name."%' ) ";
    	} else {
    		$condition .= " AND ( full_table.name LIKE '".$customer_name."%' OR full_table.mobile LIKE '".$customer_name."%' ) ";
    	}
    	$con = true;
    }
    if($customer_type != '-') {
   		if($con == false) {
    		$condition .= " AND full_table.type = '".$customer_type."' ";
    	} else {
    		$condition .= " AND full_table.type = '".$customer_type."' ";
    	}
    	$con = true;
    }

    // if($shop != '-') {
   	// 	if($con == false) {
    // 		$condition .= " AND full_table.order_shop = '".$shop."' ";
    // 	} else {
    // 		$condition .= " AND full_table.order_shop = '".$shop."' ";
    // 	}
    // 	$con = true;
    // }


    if($delivery != '-') {
   		if($con == false) {
    		$condition .= " AND full_table.is_delivered = '".$delivery."' ";
    	} else {
    		$condition .= " AND full_table.is_delivered = '".$delivery."' ";
    	}
    	$con = true;
    }

    if($payment_done != '-') {
   		if($con == false) {
            if($payment_done == '0'){
                $condition .= " AND full_table.to_be_paid > 0 ";  
            } else {
                 $condition .= " AND full_table.to_be_paid <= 0 ";  
            }
    		
    	} else {
    		if($payment_done == '0'){
                $condition .= " AND full_table.to_be_paid > 0 ";  
            } else {
                 $condition .= " AND full_table.to_be_paid <= 0 ";  
            }
    	}
    	$con = true;
    }

    if($price != '' && $price_to == '') {
   		if($con == false) {
    		$condition .= " AND full_table.sale_total > ".$price." ";
    	} else {
    		$condition .= " AND full_table.sale_total > ".$price." ";
    	}
    	$con = true;
    }

    if($price != '' && $price_to != '') {
   		if($con == false) {
    		$condition .= " AND ( full_table.sale_total >= ".$price." AND full_table.sale_total <= ".$price_to.") ";
    	} else {
    		$condition .= " AND ( full_table.sale_total >= ".$price." AND full_table.sale_total <= ".$price_to.") ";
    	}
    	$con = true;
    }

    if($date_from != '' && $date_to == '') {
   		if($con == false) {
    		$condition .= " AND DATE(full_table.invoice_date) >= '".$date_to."' ";
    	} else {
    		$condition .= " AND DATE(full_table.invoice_date) >= '".$date_to."' ";
    	}
    	$con = true;
    }
    if($date_from == '' && $date_to != '') {
   		if($con == false) {
    		$condition .= " AND DATE(full_table.invoice_date) <= '".$date_from."' ";
    	} else {
    		$condition .= " AND DATE(full_table.invoice_date) <= '".$date_from."' ";
    	}
    	$con = true;
    }
    if($date_from != '' && $date_to != '') {
   		if($con == false) {
    		$condition .= " AND ( DATE(full_table.invoice_date) >= '".$date_from."' AND DATE(full_table.invoice_date) <= '".$date_to."' ) ";
    	} else {
    		$condition .= " AND ( DATE(full_table.invoice_date) >= '".$date_from."' AND DATE(full_table.invoice_date) <= '".$date_to."' ) ";
    	}
    	$con = true;
    }

    $condition .= " AND full_table.locked = 1 ";
    /*End Updated for filter 11/10/16*/


	$result_args = array(
		'orderby_field'  	=> 'full_table.id',
		'page' 				=> $cpage ,
		'order_by' 			=> 'DESC',
		'items_per_page' 	=> $ppage ,
		'condition' 		=> $condition,
	);
	$bills_cancel = billing_list_pagination_updated_cancel($result_args);
?>
	<div>
		<div class="x_content" style="width:20%;float:left">
            <div class="table-responsive bill_tab">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th><br>Total <br> Return</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <tr>
                            <td><?php echo $bills_cancel['r_result']->return_amount; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
    	</div>
    	<div class="x_content" style="float:left;">
            <div class="table-responsive" style="width:800px;margin: 0 auto;margin-bottom:20px;">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>Total Cash</th>
                            <th>Total Card</th>
                            <th>Total Cheque</th>
                            <th>Total Internet<br>Banking</th>
                            <th>Total Credit</th>
                            <th>Total Sale</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <tr>
                            <td><?php echo $bills_cancel['s_result']->cash_amount; ?></td>
                            <td><?php echo $bills_cancel['s_result']->card_amount; ?></td>
                            <td><?php echo $bills_cancel['s_result']->cheque_amount; ?></td>
                            <td><?php echo $bills_cancel['s_result']->net_banking_amount; ?></td>
                            <td><?php echo $bills_cancel['s_result']->sale_total - ($bills_cancel['s_result']->cash_amount + $bills_cancel['s_result']->card_amount + $bills_cancel['s_result']->cheque_amount + $bills_cancel['s_result']->net_banking_amount); ?></td>
                            <td><?php echo $bills_cancel['s_result']->sale_total; ?></td>
                           
                        </tr>
                    </tbody>
                </table>
            </div>
    	</div>
	</div>
    	
	<table class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Bill By</th>
				<th>Invoice No</th>
				<th>Bill Date</th>
				<th>Shop</th>
				<th>Customer Detail</th>
				<th>Payment Type</th>
				<th>Total</th>
				<th>Delivery</th>
				<th>Payment</th>
				<th>Wholesale Rate</th>
				<th>Billing Details</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if(isset($bills_cancel['result']) AND $bills_cancel){
				$start_count = $bills_cancel['start_count'];

				foreach ($bills_cancel['result'] as $b_value) {
					$start_count++;
				
					if($b_value->is_delivered == 0) {
						$invoice_status = '<span class="c-process">Pending</span>';
					}
					if($b_value->is_delivered == 1) {
						$invoice_status = '<span class="c-delivered">Delivered</span>';
					}	
					$payment_done = ($b_value->to_be_paid > 0) ? '<span class="c-process">Incomplete</span>' : '<span class="c-delivered">Completed</span>';
                    $margin_rate = ($b_value->margin_rate > 0) ? '<span class="w-wsrate">End Price</span>' : '<span class="w-normal">Normal Price</span>';
		?>
			<tr id="customer-data-<?php echo $b_value->id; ?>">
				<td><?php echo $start_count; ?></td>
				<td><?php
					$made_by = get_userdata($b_value->made_by);
				 	echo ($made_by->user_login) ? $made_by->user_login : '-';
				?></td>
				<td>
					<?php echo $b_value->invoice_id; ?>
				</td>
				<td><?php echo machine_to_man_date($b_value->invoice_date); ?></td>
				<td><?php echo $b_value->order_shop; ?></td>
				<td><?php echo $b_value->name.' ('.$b_value->mobile.')<br>('.$b_value->type .')'; ?></td>
				<td><?php 
					if($b_value->cash_amount > 0)  {
						echo 'Cash :'.$b_value->cash_amount.'<br>'; 
					}
					if($b_value->card_amount > 0)  {
						echo 'Card :'.$b_value->card_amount.'<br>'; 
					}
					if($b_value->cheque_amount > 0)  {
						echo 'Cheque :'.$b_value->cheque_amount.'<br>'; 
					} 
					if($b_value->net_banking_amount > 0)  {
						echo 'Internet :'.$b_value->net_banking_amount.'<br>'; 
					}
					if($b_value->to_be_paid > 0)  {
						echo 'Credit :'.$b_value->to_be_paid.'<br>'; 
					} ?> 
				</td>

				<td>
					<?php echo 'Sale Total : '.$b_value->sale_total; ?>
					<?php // echo 'Paid : '.$b_value->paid_total.'<br>'; ?>
					<?php //echo 'To Be Paid : '.$b_value->to_be_paid.'<br>'; ?>

				</td>

				<td class="d-status" data-status-id="<?php echo $b_value->id; ?>"><?php echo $invoice_status; ?></td>
				<td class="d-status" style="position:relative;"> <?php echo $payment_done; ?></td>
				<td class="d-status" style="position:relative;"> <?php echo $margin_rate; ?></td>
				<td>
					<a href="<?php echo admin_url('admin.php?page=new_bill').'&bill_no='.$b_value->id.'&action=invoice&view_from=cancel_billing_list'; ?>">Billing Detail
					</a>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>
	<?php echo $bills['pagination']; 
	?>