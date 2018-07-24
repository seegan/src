<div class="form-grid">
	<form method="post" name="add_employee" id="add_employee" class="popup_form" onsubmit="return false;">


		<div class="form_detail">
			<label>Employee Name
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="employee_name" name="employee_name" autocomplete="off">
		</div>
		<div class="form_detail">
			<label>Employee ID
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="employee_id" name="employee_id" autocomplete="off">
		</div>
		<div class="form_detail">
			<label style="width: 115px;">Employee Mobile
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="employee_mobile" name="employee_mobile" pattern="[0-9]*" autocomplete="off">
		</div>
		<div class="form_detail" style="width: 95%;">
			<label>Employee Address</label>
			<textarea id="employee_address" name="employee_address"></textarea>
		</div>
		<div class="form_detail" style="width: 95%;">
			<label>Date of Joining
				<abbr class="require" title="Required Field">*</abbr>
			</label>

			<input type="text" id="employee_joining" name="employee_joining" autocomplete="off" value="<?php echo date("Y-m-d", time()); ?>">
		</div>
		<div class="form_detail" style="width: 95%;">
			<label>Employee Salary
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="employee_salary" name="employee_salary" autocomplete="off">
		</div>		
		<div class="button_sub">
			<button type="submit" name="new_employee_list" id="btn_submit" class="submit-button">Submit</button>
		</div>
	</form>



</div>


<script type="text/javascript">
	jQuery('#add_employee .submit-button').click(function () {
		var employee_name = jQuery('#employee_name').val();
		var employee_mobile = jQuery('#employee_mobile').val();
		var employee_address = jQuery('#employee_address').val();
		var employee_joining = jQuery('#employee_joining').val();
		var employee_salary = jQuery('#employee_salary').val();

		if(employee_name != '' && employee_mobile != '' && validatePhone(employee_mobile) && employee_joining!='' && employee_salary!='' )
		{
			employee_create_submit_popup('post_employee_create_popup', 'ddf');
		} else {
			alert_popup('<span class="error_msg">Enter the mandatory fields!!</span>', 'Alert!');
		}
	});

	jQuery(document).ready(function(){
        jQuery("#employee_joining" ).datepicker({dateFormat: "yy-mm-dd"});
    })
</script>