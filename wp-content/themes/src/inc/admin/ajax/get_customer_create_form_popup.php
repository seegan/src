<style type="text/css">
.gst_num_div{
	display:none;
}
</style>

<div class="form-grid">
	<form method="post" name="add_customer" id="add_customer" class="popup_form" onsubmit="return false;">
		<div class="form_detail">
			<label>Customer Name
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="customer_name" name="customer_name" class="customer_name" autocomplete="off">
		</div>
		<div class="form_detail">
			<label style="width: 115px;">Customer Mobile
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="customer_mobile" name="customer_mobile" onkeypress="return isNumberKey(event)" class="customer_mobile" pattern="[0-9]*" autocomplete="off">
		</div>
		<div class="form_detail" style="width: 95%;">
			<label>Customer Address</label>
			<textarea id="customer_address" name="customer_address"></textarea>
		</div>
		<div class="form_detail">
			<label style="width: 115px;">Alternative Mobile Number
			</label>
			<input type="text" id="customer_mobile1" name="customer_mobile1" onkeypress="return isNumberKey(event)" pattern="[0-9]*" autocomplete="off">
		</div>
		<div class="form_detail">
			<label>Type</label>
			<select name="customer_type" id="customer_type" class="customer_type">
				<option value="Retail">Retail</option>
				<option value="Wholesale">Wholesale</option>
				<option value="Bulk">Bulk</option>
			</select>
		</div>
		<div class="form_detail gst_num_div">
			<label style="width: 115px;">GST Number
			</label>
			<input type="text" id="gst_number" name="gst_number"  autocomplete="off" value="">
		</div>
		<div class="form_detail">
			<label>Payment Method</label>
			<div style="margin-top: 10px;">
				<input type="radio" name="payment_type" value="immediate" checked>Immediate 
				<input type="radio" name="payment_type" value="credit">Credit 
			</div>
		</div>
		<div class="form_detail">
			<label>Bill Title</label>
			<div style="">
				<input type="text" id="bill_title" name="bill_title" autocomplete="off" value="Original Tax Invoice">
			</div>
		</div>
		<div class="button_sub">
			<button type="submit" name="new_customer_list" id="btn_submit" class="submit-button">Submit</button>
		</div>
	</form>



</div>


<script type="text/javascript">
	jQuery('#add_customer .submit-button').click(function () {
		var customer_name    = jQuery('#add_customer #customer_name').val();
		var customer_mobile  = jQuery('#add_customer #customer_mobile').val();
		var customer_mobile1 = jQuery('#add_customer #customer_mobile1').val();
		var customer_address = jQuery('#add_customer #customer_address').val();
		var customer_type    = jQuery('#add_customer #customer_type').val();


		if(customer_name != '' && customer_mobile != '' && validatePhone(customer_mobile) ) {
			customer_create_submit_popup('post_customer_create_popup', jQuery('#billing_customer').length);
		} else {
			alert_popup('<span class="error_msg">Enter the mandatory fields!!!</span>', 'Alert!');
		}
	})


</script>