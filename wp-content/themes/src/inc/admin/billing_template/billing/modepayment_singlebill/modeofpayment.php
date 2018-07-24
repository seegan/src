



<div class="billing-structure">Due Amount:<span class="balance_amount"></span><br/>
	<input type="hidden" value="<?php echo ( $bill_data && $bill_fdata ) ? $bill_fdata->prev_bal : 0;  ?>" name="balance_amount_val" class="balance_amount_val"/>
	<input type="hidden" class="form-control return_amt" value="<?php echo ( $bill_data && $bill_fdata ) ? $bill_fdata->tot_due_amt : 0;  ?>" name="return_amt">
	Total Due Balance <span class="return_amt_txt"><?php echo ( $bill_data && $bill_fdata ) ? $bill_fdata->tot_due_amt : 0;  ?></span>
</div>





											
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
            <input type="checkbox" name="payment_cash[]" value="payto_content" class="payment_cash" data-paytype="payto"> Pay to  
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
			if($bill_data['ordered_data']) {
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
						}  else{
							$display_type = ucfirst($p_value->payment_type);
						}
						echo '<tr  class="payment_table" >
						<td style="padding:5px;">'.$display_type.' <input type="hidden" value="'.$p_value->payment_type.'" name="payment_detail['.$i.'][payment_type]" class="payment_type"  /> </td>
						<td style="padding:5px;"><input type="text" '.$readonly.'  value ="'.$p_value->amount.'" name="payment_detail['.$i.'][payment_amount]" class="payment_amount" data-paymenttype="'.$p_value->payment_type.'" data-uniqueName="'.getToken().'" style="width: 74px;"/><input type="hidden" name="payment_detail['.$i.'][reference_screen]" value="'.$p_value->reference_screen.'" /><input type="hidden" name="payment_detail['.$i.'][reference_id]" value="'.$p_value->reference_id.'" /></td>
						<td style="width: 204px;">'.$p_value->payment_date.'</td>
						<td style="padding:5px;"><a href="#" style="'.$display.'" class="payment_sub_delete">x</a></td></tr>';
					}
					$i++;
				}	
			}
		?>
	</tbody>
</table>
<br/>
<table class="payment_tab div-table-row">
	<thead>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
	</thead>
	<tbody class="bill_payment_tab_cheque" id="bill_payment_tab_cheque">
		<?php 
			if($bill_data['ordered_data']) {
				$i = 1;
				foreach ($bill_pdata as $p_value) {
					if($p_value->payment_type == 'credit'){ 
						echo '<tr  class="payment_cheque" >
						<td style="padding:5px;">'.ucfirst($p_value->payment_type).' <input type="hidden" value="'.$p_value->payment_type.'" name="pay_cheque" class="pay_cheque"  /> </td>
						<td style="padding:5px;"><input type="text" value ="'.$p_value->amount.'" name="pay_amount_cheque" class="pay_amount_cheque" readonly style="width: 74px;"/><input type="hidden" name="reference_screen" value="'.$p_value->reference_screen.'" /><input type="hidden" name="reference_id" value="'.$p_value->reference_id.'" /></td>
						<td style="width: 190px;">'.$p_value->payment_date.'</td>
						<td style="padding:5px;width: 75px;"><a href="#"  class="payment_sub_delete">x</a></td></tr>';
					}
					$i++;
				}	
			}
		?>
	</tbody>
</table>

<br/>

<div class="cash_on_delivery">
	<div class="cash_on_delivery_in">
		<div style="width: 20%; float:left">
			COD 										
		 <input type="checkbox" name="cod_check" class="cod_check" value="cod" <?php if($bill_fdata->cod_check == '1'){ echo 'checked'; } ?>/>
		</div>
		
		<div class="cod_amount_div" <?php if($bill_data && $bill_fdata){
				if($bill_fdata->cod_check == '1') { echo 'style=display:block;width: 20%; float:right;'; } else { echo 'style=display:none;width: 20%; float:right'; }
			} else{ echo 'style=width: 20%; float:right'; }  ?>>

			<input type="text" name="cod_amount" style="width:60px;"  class="cod_amount" tabindex="-1"  value="<?php echo ($bill_data && $bill_fdata ) ? $bill_fdata->cod_amount : '0'; ?>" readonly />
		</div>										
	</div>
</div>


<br/>
<table class="div-table-row">

	<tr style="font-weight:bold;">
		<th>To Pay:
			<input type="checkbox" name="cur_bal_check_box"  class="cur_bal_check_box" style="width: 20px;height: 18px;" <?php if($bill_data && $bill_fdata){ $paid = $bill_fdata->pay_to_check; if($paid == '1' ){ echo 'checked'; }  } else { echo 'checked'; } ?>>

		</th>
		<td>
			<div class="col-xs-12 col-md-8 col-lg-6 form-group has-feedback nopadding">
				<span class="current_bal_txt"><?php echo ( $bill_data && $bill_fdata ) ? $bill_fdata->pay_to_bal : 0;  ?></span>
				<input type="hidden" name="current_bal" class="current_bal"  value="<?php echo ( $bill_data && $bill_fdata ) ? $bill_fdata->pay_to_bal : 0;  ?>"> 
				
				<!-- <span class="fa fa-inr form-control-feedback right" aria-hidden="true"></span> -->
			</div>
		</td>
	</tr>
	<tr style="color:red;font-weight:bold;">
		
		<th>Balance:
		</th>
		<td>
			<div class="col-xs-12 col-md-8 col-lg-6 form-group has-feedback nopadding">
				<span class="balance_pay"></span>
				
				
				<!-- <span class="fa fa-inr form-control-feedback right" aria-hidden="true"></span> -->
			</div>
		</td>
	</tr>
</table>


