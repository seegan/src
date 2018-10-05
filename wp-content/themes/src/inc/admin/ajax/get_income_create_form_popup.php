<style type="text/css">
	.select2-container {
	    z-index: 9998;
	}
	.select2-dropdown {
		width: 220px !important;
	}
</style>
<div class="form-grid">
	<form method="post" name="add_income" id="add_income" class="popup_form" onsubmit="return false;">
		<div class="form_detail">
			<label>Date
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<div style="float:left;width: 138px;">
		        <input type="text" id="cash_date" name="cash_date" style="width:100%;">
		    </div>
		</div>

		<div class="form_detail" style="width: 95%;">
			<label>Description</label>
			<textarea id="cash_description" name="cash_description"></textarea>
		</div>

		<div class="form_detail">
			<label>Amount
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<div style="float:left;width: 138px;">
		        <input type="text" id="cash_amount" name="cash_amount" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" style="width:100%;">
		    </div>

			
		</div>
		<div class="button_sub">
			<button type="submit" name="new_customer_list" id="btn_submit" class="submit-button">Submit</button>
		</div>
	</form>



</div>


<script type="text/javascript">
	jQuery('#add_income .submit-button').click(function () {
		var cash_date = jQuery('#cash_date').val();
		var cash_amount = jQuery('#cash_amount').val();

		if(cash_date != '' || cash_amount != '' ) {
			income_create_submit_popup('post_income_create_popup', 'ddf');
		} else {
			alert_popup('<span class="error_msg">Enter the mandatory fields!!</span>', 'Alert!');
		}
	});


	jQuery(document).ready(function(){
        jQuery("#cash_date" ).datepicker({dateFormat: "yy-mm-dd"});
    })


</script>