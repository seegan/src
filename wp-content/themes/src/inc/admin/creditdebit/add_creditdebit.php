
<style>

 .payment_cash_cd{
	width: 10px !important;
    height: 16px !important;	
}
.payment_sub_delete_cd{
	font-size: 16px;
    font-weight: bold;
    color: #ff0000;
}
.payment_sub_delete_cd:focus {
	font-size: 24px;
    font-weight: bold;
    color: #ff0000;
    cursor: pointer; 
    cursor: hand;
}

</style>


<?php
$lot = false;
if(isset($_GET['id']) && $credit_debit = get_creditdebit($_GET['id']) ) {
	$credit_id = $_GET['id'];
}
var_dump($credit_debit);
?>
<div class="widget-top">
	<h4>Add New Admin User</h4>
</div>
<div class="widget-content module">
	<div class="form-grid">
		<form method="post" name="create_creditdebit" id="create_creditdebit" class="leftLabel creditdebit_submit">
			<input type="hidden" value="off" name="form_submit_prevent" class="form_submit_prevent_credit" id="form_submit_prevent_credit"/>
			<input type="hidden" id="creditdebit_id" name="creditdebit_id" class="form-control col-md-7 col-xs-12 creditdebit_id" autocomplete="off" value="<?php echo ($credit_debit) ? $credit_id : '0'; ?>">
			<input type="hidden" id="creditdebit_cus_id" name="creditdebit_cus_id" class="form-control col-md-7 col-xs-12 creditdebit_cus_id" value="<?php echo ($credit_debit) ? $credit_debit['main_tab']->customer_id : '0'; ?>">
			<input type="hidden" id="creditdebit_screen" name="creditdebit_screen" class="form-control col-md-7 col-xs-12 creditdebit_screen" value="<?php echo ($credit_debit) ? 'due_screen': ''; ?>">
			<ul>
				<li>
					<label class="fldTitle">Customer Name
						<abbr class="require" title="Required Field">*</abbr>
						<option selected value="<?php echo ($credit_debit) ? $credit_debit['main_tab']->customer_id : '';  ?>"><?php echo ($credit_debit) ? $credit_debit['main_tab']->name : '';  ?></option>
					</label>
					<div class="fieldwrap">
						<span class="left">
							<select name="billing_customer_due" id="billing_customer_due" class="billing_customer_due">
								<option></option>
							</select>
						</span>
					</div>
				</li>
				<li>
					<label class="fldTitle">Description
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<div class="fieldwrap">
						<span class="left">
							<textarea name="description" id="description" class="description" style="border: 2px solid rgb(238, 238, 238);"><?php echo ($credit_debit) ? $credit_debit['main_tab']->description : '';  ?></textarea>
						</span>
					</div>
				</li>
				<li>
					<label class="fldTitle">Date
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<div class="fieldwrap">
						<span class="left">
							<input type="text" id="creditdebit_date" name="creditdebit_date"  class="form-control col-md-7 col-xs-12 creditdebit_date" autocomplete="off" value="<?php echo ($credit_debit) ? $credit_debit['main_tab']->date : date("Y-m-d"); ?>">
						</span>
					</div>
				</li>
				<li>
					<label class="fldTitle">Due Amount
					</label>
					<div class="fieldwrap">
						<span class="left">
							<input type="hidden" id="total_due" name="total_due"  class="form-control col-md-7 col-xs-12 total_due" value="<?php echo ($credit_debit) ? $credit_debit['main_tab']->due_amount : 0; ?>"/>
						</span>
					</div>
				</li>
				<li>
					<label class="fldTitle">
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<div class="fieldwrap">
						<span class="left">
							<div class="payment-mode">
			                    <div class="payment-container-top">
			                        <div class="payment-span" style="">
			                        	<b>Mode Of Payment <span class="required">*</span> :     </b>
			                            <input type="checkbox" name="payment_cash[]" value="cash" class="payment_cash_cd" data-paytype="cash"> Cash 
			                            <input type="checkbox" name="payment_cash[]" value="card" class="payment_cash_cd" data-paytype="card"> Card 
			                            <input type="checkbox" name="payment_cash[]" value="cheque" class="payment_cash_cd" data-paytype="cheque"> Cheque 
			                            <input type="checkbox" name="payment_cash[]" value="internet" class="payment_cash_cd" data-paytype="internet"> Neft
			                            <!-- <input type="checkbox" name="payment_cash" value="credit"> Credit -->
			                        </div>
			                    </div>
			                </div>
	            		
		            		<table class="payment_tab_cd" >
		            			<thead>
		            				<th style="padding:5px;">Payment Type</th>
		            				<th style="padding:5px;">Amount</th>
		            				<th style="padding:5px;">Date</th>	
		            				<th style="padding:5px;">Delete</th>	
		            				
		            			</thead>
								<tbody class="bill_payment_tab_cd" id="bill_payment_tab_cd" style="width: 100%;">
									<?php 
										if($credit_debit) {
											$i = 1;
											foreach ($credit_debit['sub_tab'] as $p_value) {
													if($p_value->payment_type !='credit') { 
														echo '<tr  class="payment_table_cd" >
														<td style="padding:5px;">'.ucfirst($p_value->payment_type).' <input type="hidden" value="'.$p_value->payment_type.'" name="payment_detail['.$i.'][payment_type]" class="payment_type_cd"  /> </td>
														<td style="padding:5px;"><input type="text" value ="'.$p_value->amount.'" name="payment_detail['.$i.'][payment_amount]" class="payment_amount_cd" data-paymenttype="'.$p_value->payment_type.'" data-uniqueName="'.getToken().'" style="width: 74px;" onkeypress="return isNumberKey(event)"/></td>
														<td style="padding:5px;">'.$p_value->payment_date.'</td>
														<td style="padding:5px;"><a href="#" class="payment_sub_delete_cd">x</a></td></tr>';
													}
												$i++;
											}	
										}
									?>
								</tbody>
		            		</table>
						</span>
					</div>
				</li>
				<li>
					<label class="fldTitle">
					</label>
					<div class="fieldwrap">
						<span class="left">
							<table class="table">
	            			<thead>
	            				<th style="padding:5px;width:98px;">Invoice Id</th>
	            				<th style="padding:5px;">Balance</th>
	            				<th style="padding:5px;">Amount</th>
	            				<th style="padding:5px;">Payment type</th>
	            			</thead>
	            			<tbody class="due_tab_cd" id="due_tab_cd" style="width: 100%;">

	            			</tbody>
	            		</table>
	            		
	            		</span>
					</div>
				</li>
				<li>
					<label class="fldTitle">To Pay:
					</label>
					<div class="fieldwrap">
						<span class="left">
							<span class="current_bal_txt_cd"><?php echo ( $credit_debit ) ? $credit_debit['main_tab']->to_pay_amt : 0;  ?></span>
									<input type="hidden" name="to_pay_amt" class="to_pay_amt_cd"  value="<?php echo ( $credit_debit ) ? $credit_debit['main_tab']->to_pay_amt : 0;  ?>"> 
						</span>
					</div>
				</li>
				<li class="buttons bottom-round noboder">
					<div class="fieldwrap">
						<input type="submit" value="Submit" class="submit-button credit_submit">
						<?php 
							if(  $credit_debit ) {
								echo '<input type="hidden" name="creditdebit_id" value="'.$credit_id.'">';
								echo '<input type="hidden" name="action" class="creditdebit_action" value="update_creditdebit">';
							} else {
								echo '<input type="hidden" name="action" class="creditdebit_action" value="create_creditdebit">';
							}
						?>

					</div>
				</li>
			</ul>
		</form>
	</div>
</div>


<?php 
if(isset($_GET['id'])){
echo "<script language='javascript'>
  jQuery(document).ready(function (argument) { 
    duePaidCusCd('".$credit_debit['main_tab']->customer_id."');
  });
 
</script>";
}
?>