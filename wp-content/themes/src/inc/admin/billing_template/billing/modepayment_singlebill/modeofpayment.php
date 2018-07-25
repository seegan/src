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
    
</style>


 <div class="previous-payment-due">
    <div class="billing-structure">
        Payment Due From Previous Bills : <span class="due_bal"></span>
        <input type="hidden" name="due_bal_input" class="due_bal_input" id="due_bal_input" value="0"/>
		<br/>
		Customer Balance <span class="tot_due_txt"> <?php echo ( $bill_data && $bill_fdata ) ? $bill_fdata->tot_due_amt : 0;  ?></span>
		<input type="hidden" class="form-control tot_due" value="<?php echo ( $bill_data && $bill_fdata ) ? $bill_fdata->tot_due_amt : 0;  ?>" name="tot_due">
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
			// if($bill_data['ordered_data']) {
			// 	$i = 1;
			// 	foreach ($bill_pdata as $p_value) {
			// 		if($p_value->reference_screen == "due_screen"){ 
			// 			$readonly  = "readonly"; 
			// 			$display = "display:none";
			// 		} else{
			// 			$readonly  = "";
			// 			$display = "";
			// 		}
			// 		if($p_value->payment_type !='credit') {
			// 			if($p_value->payment_type == 'internet'){
			// 				$display_type = 'Netbanking';
			// 			}  else{
			// 				$display_type = ucfirst($p_value->payment_type);
			// 			}
			// 			echo '<tr  class="payment_table" >
			// 			<td style="padding:5px;">'.$display_type.' <input type="hidden" value="'.$p_value->payment_type.'" name="payment_detail['.$i.'][payment_type]" class="payment_type"  /> </td>
			// 			<td style="padding:5px;"><input type="text" '.$readonly.'  value ="'.$p_value->amount.'" name="payment_detail['.$i.'][payment_amount]" class="payment_amount" data-paymenttype="'.$p_value->payment_type.'" data-uniqueName="'.getToken().'" style="width: 74px;"/><input type="hidden" name="payment_detail['.$i.'][reference_screen]" value="'.$p_value->reference_screen.'" /><input type="hidden" name="payment_detail['.$i.'][reference_id]" value="'.$p_value->reference_id.'" /></td>
			// 			<td style="width: 204px;">'.$p_value->payment_date.'</td>
			// 			<td style="padding:5px;"><a href="#" style="'.$display.'" class="payment_sub_delete">x</a></td></tr>';
			// 		}
			// 		$i++;
			// 	}	
			// }
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
			// if($bill_data['ordered_data']) {
			// 	$i = 1;
			// 	foreach ($bill_pdata as $p_value) {
			// 		if($p_value->payment_type == 'credit'){ 
			// 			echo '<tr  class="payment_cheque" >
			// 			<td style="padding:5px;">'.ucfirst($p_value->payment_type).' <input type="hidden" value="'.$p_value->payment_type.'" name="pay_cheque" class="pay_cheque"  /> </td>
			// 			<td style="padding:5px;"><input type="text" value ="'.$p_value->amount.'" name="pay_amount_cheque" class="pay_amount_cheque" readonly style="width: 74px;"/><input type="hidden" name="reference_screen" value="'.$p_value->reference_screen.'" /><input type="hidden" name="reference_id" value="'.$p_value->reference_id.'" /></td>
			// 			<td style="width: 190px;">'.$p_value->payment_date.'</td>
			// 			<td style="padding:5px;width: 75px;"><a href="#"  class="payment_sub_delete">x</a></td></tr>';
			// 		}
			// 		$i++;
			// 	}	
			// }
		?>
	</tbody>
</table>

<br/>
<table class="payment_tab div-table-row">
	<thead>
		<th></th>
		<th></th>
		<th></th>
	</thead>
	<tbody class="bill_payment_tab_previous" id="bill_payment_tab_previous">
		<tr  class="" >
			<td style="padding:5px;">Pay From Prevoius </td>
			<td style="padding:5px;"><input type="text" value ="0" name="pay_pre_bal" class="pay_pre_bal" readonly style="width: 74px;"/></td>
		</tr>
		<tr  class="" >
			<td style="padding:5px;">COD <input type="checkbox" name="cod_check" class="cod_check" value="cod" <?php if($bill_fdata->cod_check == '1'){ echo 'checked'; } ?> /> </td>
			<td style="padding:5px;"><div class="cod_amount_div"></div><input type="text" name="cod_amount" style="width:60px;"  class="cod_amount" value="<?php echo ($bill_data && $bill_fdata ) ? $bill_fdata->cod_amount : '0'; ?>" readonly/></td>
		</tr>
		<tr style="font-weight:bold;">
		<td>To Pay:
			<input type="checkbox" name="to_pay_checkbox"  class="to_pay_checkbox" style="width: 20px;height: 18px;" >

		</td>
		<td>	
			<input type ="text" name="to_pay" class="to_pay" readonly value="0" style="width: 76px;"/>
		</td>
		
	</tr>
	<tr style="color:red;font-weight:bold;">
		
		<td>
			Balance:
		</td>
		<td>
			<input type="text" name="balance" class="balance" value="0" readonly style="width: 76px;"> 
		</td>
	</tr>
	</tbody>
</table>
<br/>



<br/>



