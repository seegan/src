<?php
	$customer = false;
	if( isset($_POST['key']) && isset($_POST['action']) && isset($_POST['id']) && $_POST['key'] == 'edit_popup_content' && $_POST['action'] == 'edit_customer_create_form_popup' ) {
		$customer = get_customer($_POST['id']);
	}

	$immediate_payment = '';
	$credit_payment = '';	
	if($customer->payment_type == 'immediate') {
		$immediate_payment = 'checked';
	}
	if($customer->payment_type == 'credit') {
		$credit_payment = 'checked';
	}

?>
<div class="form-grid">
	<form method="post" name="edit_customer" id="edit_customer" class="popup_form" onsubmit="return false;">
		<div class="form_detail">
			<label>Customer Named
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="customer_name" name="customer_name" autocomplete="off" value="<?php echo ($customer) ? $customer->name : ''; ?>">
		</div>
		<div class="form_detail">
			<label style="width: 115px;">Customer Mobile
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="customer_mobile" name="customer_mobile" pattern="[0-9]*" autocomplete="off" value="<?php echo ($customer) ? $customer->mobile : ''; ?>">
		</div>
		<div class="form_detail">
			<label style="width: 115px;">Alternative Mobile Number
			</label>
			<input type="text" id="customer_mobile1" name="customer_mobile1" pattern="[0-9]*" autocomplete="off" value="<?php echo ($customer) ? $customer->mobile1 : ''; ?>">
		</div>
		<div class="form_detail" style="width: 95%;">
			<label>Customer Address</label>
			<textarea id="customer_address" name="customer_address"><?php echo ($customer) ? $customer->address : ''; ?></textarea>
		</div>
		<div class="form_detail">
			<label>Type</label>
			<select name="customer_type" id="customer_type" class="customer_type">
				<option value="Retail" <?php echo ($customer && $customer->type == 'Retail') ? 'selected' : ''; ?> >Retail</option>
				<option value="Wholesale" <?php echo ($customer && $customer->type == 'Wholesale') ? 'selected' : ''; ?>>Wholesale</option>
				<option value="Bulk" <?php echo ($customer && $customer->type == 'Bulk') ? 'selected' : ''; ?>>Bulk</option>
			</select>
		</div>
		<div class="form_detail">
			<label>Payment Method</label>
			<div style="margin-top:10px;">
				<input type="radio" name="payment_type" value="immediate" <?php echo $immediate_payment; ?>>Immediate 
				<input type="radio" name="payment_type" value="credit" <?php echo $credit_payment; ?>>Credit 
			</div>
		</div>
		<div class="button_sub">
			<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $_POST['id']; ?>">
			<input type="hidden" name="roll_id" id="roll_id" value="<?php echo $_POST['roll_id']; ?>">
			<button type="submit" name="edit_customer_list" id="btn_submit" class="submit-button">Submit</button>
		</div>
	</form>
</div>