<style type="text/css">
    
    .payment-detail-container, .previous-payment-due {
        /*float: left;*/
        margin-top: 20px;
        width:800px;
    }
    .previous-payment-due .billing-structure {
        border: 2px solid red;
        padding:20px;
    }
    input[type="checkbox"][readonly] {
	  pointer-events: none;
	}
    .payment_div {
    	width: 50%;
    	float: left;
    }
</style>
<?php  
	$current_due = 0;
	$customer_bal = false;
	$delivery_address =  false;
	if(isset($_GET['action']) && $_GET['action'] == 'update'){	
		$bill_id = $bill_data['bill_data']->id;
	} else {
		$bill_id = $unlocked_val['id'];
		$bill_data['bill_data'] = false;
	}
	if($bill_data['bill_data']){
		$bill_pdata = get_paymenttype($bill_data['bill_data']->id);
		$current_due = checkBillBalance($bill_id);
		$cod = 0.00;
		$pay_to = 0.00;
		if($current_due > 0 ) {
			$cod = $current_due;
			$pay_to = 0.00;
		}
		if($current_due < 0) {
			$cod = 0.00;
			$pay_to = (-1*$current_due);
		}
		$customer_bal = checkCustomerBalance($bill_data['customer_data']->id,'balance');
	}
	


?>

<div class = "payment_div">
	<div class="previous-payment-due">
    <div class="billing-structure">
    	<?php 
    	$cus_bal = checkCustomerBalance($bill_data['customer_data']->id, 'due', 'billing_screen', $bill_id, 'row')->actual_pending;
    	?>
    	Customer Previous Due : Rs. <span class="tot_customer_due_txt"><?php echo ($cus_bal) ? $cus_bal : 0.00; ?></span>
    	<br>
		Current bill Due : Rs. <span class="tot_due_txt"><?php echo $current_due;  ?></span>
		<input type="hidden" class="form-control tot_due" value="<?php echo $current_due;  ?>" name="tot_due">
    </div>
</div>
<br/>
<div class="payment-mode">
    <div class="payment-container-top">
        <div class="payment-span" style="width: 180%;">
        	<b>Mode Of Payment  :     </b>
        	<input type="hidden" name="bill_paid" class="bill_paid" value="0"/>
            <input type="checkbox" name="payment_cash[]" value="cash_content" class="payment_cash" data-paytype="cash"> Cash 
            <input type="checkbox" name="payment_cash[]" value="card_content" class="payment_cash" data-paytype="card"> Card 
            <input type="checkbox" name="payment_cash[]" value="cheque_content" class="payment_cash" data-paytype="cheque"> Cheque 
            <input type="checkbox" name="payment_cash[]" value="internet_content" class="payment_cash" data-paytype="internet"> Neft
            <input type="checkbox" name="payment_cash[]" value="credit_content" class="payment_cash" data-paytype="credit"> Credit  
            <!-- <input type="checkbox" name="payment_cash" value="credit"> Credit -->
        </div>
    </div>
</div>
<br/>
<br/>
<table class="payment_tab div-table-row">
	<thead>
		<th class="div-table-head">Payment Type</th>
		<th class="div-table-head">Amount</th>	
		<th class="div-table-head">Date</th>	
		<th class="div-table-head">Delete</th>
	</thead>
	<tbody class="bill_payment_tab" id="bill_payment_tab" style="width: 100%;">
		<?php 
			if($bill_data['bill_data']) {
				$i = 1;
				foreach ($bill_pdata as $p_value) {
					if($p_value->reference_screen == "due_screen"){ 
						$readonly  = "readonly"; 
						$display = "display:none";
					} else{
						$readonly  = "";
						$display = "";
					}
					if($p_value->payment_type !='credit') {
						if($p_value->payment_type == 'internet'){
							$display_type = 'Netbanking';
						}  else {
							$display_type = ucfirst($p_value->payment_type);
						}
						echo '<tr  class="payment_table" >
							<td style="padding:5px;">'.$display_type.' <input type="hidden" value="'.$p_value->payment_type.'" name="payment_detail['.$i.'][payment_type]" class="payment_type"  /> </td>
							<td style="padding:5px;"><input type="text" '.$readonly.'  value ="'.$p_value->amount.'" name="payment_detail['.$i.'][payment_amount]" class="payment_amount" data-paymenttype="'.$p_value->payment_type.'" data-uniqueName="'.getToken().'" style="width: 74px;" onkeypress="return isNumberKeyWithDot(event)"/><input type="hidden" name="payment_detail['.$i.'][reference_screen]" value="'.$p_value->reference_screen.'" /><input type="hidden" name="payment_detail['.$i.'][reference_id]" value="'.$p_value->reference_id.'" /><input type="hidden" name="payment_detail['.$i.'][unique_name]" value="'.getToken().'" /></td>
							<td style="width: 204px;">'.$p_value->payment_date.'</td>
							<td style="padding:5px;"><a href="#" style="'.$display.'" class="payment_sub_delete">x</a></td></tr>';
					}
					$i++;
				}	
			}
		?>
	</tbody>
</table>
<br>
<input type="hidden" class="previous_paid_total" value="<?php echo getBillPaymentTotal($bill_id); ?>">
<table class="payment_tab div-table-row">
	<thead>
		<th></th>
		<th></th>
		<th></th>
	</thead>
	<tbody class="bill_payment_tab_previous" id="bill_payment_tab_previous">
		<!-- <tr  class="" >
			<td style="padding:5px;">Pay From Prevoius </td>
			<td style="padding:5px;">
				<input type="text" value ="0" name="pay_pre_bal" class="pay_pre_bal" readonly style="width: 74px;"/>
			</td>
		</tr> -->
		<tr  class="" >
			<td style="padding:5px;">COD <input type="checkbox" name="cod_check" class="cod_check" value="cod" /> </td>
			<td style="padding:5px;"><div class="cod_amount_div"></div><input type="text" name="cod_amount" tabindex="-1" style="width:60px;"  class="cod_amount" value="<?php echo $cod; ?>" readonly/></td>
		</tr>
		<tr style="font-weight:bold;">
			<td>To Pay:
				<div style="display:none;"><input type="checkbox" name="to_pay_checkbox" tabindex="-1" checked  class="to_pay_checkbox"  style="width: 20px;height: 18px;" ></div>

			</td>
			<td>	
				<input type ="text" name="to_pay" class="to_pay" tabindex="-1" readonly value="<?php echo $pay_to; ?>" style="width: 76px;"/>
			</td>		
		</tr>
		<tr style="color:red;font-weight:bold;">
			<td>
				Balance:
			</td>
			<td>
				<input type="text" name="balance" tabindex="-1" class="balance" value="<?php echo $cod;  ?>" readonly style="width: 76px;"> 
			</td>
		</tr>
	</tbody>
</table>

<!-- Total values -->
<input type="hidden" name="payment_total" class="payment_total" value="<?php echo ( $bill_data['bill_data']) ? $bill_data['bill_data']->total_pay : 0;  ?>"/>
<input type="hidden" name="payment_total_without_pre" class="payment_total_without_pre" value="<?php echo ( $bill_data['bill_data']) ? $bill_data['bill_data']->total_pay_without_prec : 0;  ?>"/>
<br/>

</div>
 
 <div class="payment_div">
	<table class="payment_tab_current_screen div-table-row" <?php if($customer_bal && isset($bill_data['bill_data'])) { echo 'style="display:block"'; }  else { echo 'style="display:none;"'; }?>>
		<thead>
			<th>Invoice Id</th>
			<th>Amonut</th>
			<th>Paid</th>
		</thead>
		<tbody class="bill_payment_in_bill" id="bill_payment_in_bill">
		</tbody>
	</table>
	<br/>
	<br/>
	<div>
		
		<div>
			Home Delivery: 
			<?php if($bill_data['bill_data']) { 
				
				$is_delivery = $bill_data['bill_data']->delivery_avail;
				
				 ?>
				<input type="radio" name="delivery_need" value="0"  class="delivery_need" <?php if($is_delivery == '0'){ echo 'checked'; } ?>/> No
				<input type="radio" name="delivery_need" value="1"  class="delivery_need" <?php if($is_delivery == '1'){ echo 'checked'; } ?> /> Yes <br/><br/>
				<div class="delivery_display" <?php if($is_delivery == '0'){ echo 'style="display:none"'; } else { echo 'style="display:block"'; } ?>>
					
					<input type="text" name="delivery_name" class="delivery_name customer_check" placeholder="Name" value="<?php echo $bill_data['bill_data']->delivery_name; ?>" autocomplete="off"/><br/><br/>
					<input type="text" name="delivery_phone" class="delivery_phone" placeholder="Phone" value="<?php echo $bill_data['bill_data']->delivery_phone; ?>"  autocomplete="off"/><br/><br/>
					<textarea  placeholder="Address" name="delivery_address" class="delivery_address customer_check" style="width:70%;height: 70px;"><?php echo $bill_data['bill_data']->delivery_address; ?></textarea>	<br/><br/>
					<input type="text" name="delivery_boy" class="delivery_boy" placeholder="Delivery boy Name" value="<?php echo $bill_data['bill_data']->delivery_boy; ?>">
				</div>
			<?php } else { ?>
				<input type="radio" name="delivery_need" value="0" class="delivery_need" checked /> No
				<input type="radio" name="delivery_need" value="1" class="delivery_need" /> Yes <br/><br/>
				<div class="delivery_display" style="display:none;">
					<input type="text" name="delivery_name" class="delivery_name customer_check" placeholder="Name" /><br><br/>
					<input type="text" name="delivery_phone" class="delivery_phone" placeholder="Phone" onkeypress="return isNumberKeyDelivery(event)"/><br><br/>
					<textarea  placeholder="Address" name="delivery_address" class="delivery_address customer_check" style="width:70%;height: 70px;"></textarea><br><br/>
					<input type="text" name="delivery_boy" class="delivery_boy" placeholder="Delivery boy Name">
				</div>
			<?php } ?>
		</div>
	</div>
</div>




