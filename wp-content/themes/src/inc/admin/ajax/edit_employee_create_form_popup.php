<?php
	$customer = false;

	if( isset($_POST['key']) && isset($_POST['action']) && isset($_POST['id']) && $_POST['key'] == 'edit_popup_content' && $_POST['action'] == 'edit_employee_create_form_popup' ) {
		$employee = get_employee($_POST['id']);
	}
?>

<div class="form-grid">
	<form method="post" name="edit_employee" id="edit_employee" class="popup_form" onsubmit="return false;">


		<div class="form_detail">
			<label>Employee Name
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="employee_name" name="employee_name" autocomplete="off" value="<?php echo ($employee) ? $employee->emp_name : ''; ?>">
		</div>
		<div class="form_detail">
			<label>Employee ID
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="employee_no" name="employee_no" autocomplete="off" value="<?php echo ($employee) ? 'EMP'.$employee->id : ''; ?>">
		</div>
		<div class="form_detail">
			<label style="width: 115px;">Employee Mobile
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="employee_mobile" name="employee_mobile" pattern="[0-9]*" autocomplete="off" value="<?php echo ($employee) ? $employee->emp_mobile : ''; ?>">
		</div>

		<div class="form_detail">
			<label>Status
			</label>
			<select type="text" id="employee_status" name="employee_status" autocomplete="off">
				<option value="1" <?php echo ($employee && $employee->emp_current_status == "1") ? 'selected' : ''; ?>>Working</option>
				<option value="0" <?php echo ($employee && $employee->emp_current_status == "0") ? 'selected' : ''; ?>>Releave</option>
			</select>
		</div>

		<div class="form_detail" style="width: 95%;">
			<label>Employee Address</label>
			<textarea id="employee_address" name="employee_address"><?php echo ($employee) ? $employee->emp_address : ''; ?></textarea>
		</div>
		<div class="form_detail" style="width: 95%;">
			<label>Date of Joining
				<abbr class="require" title="Required Field">*</abbr>
			</label>

			<input type="text" id="employee_joining" name="employee_joining" autocomplete="off" value="<?php echo ($employee) ? $employee->emp_joining : ''; ?>">
		</div>
		<div class="form_detail" style="width: 95%;">
			<label>Employee Salary
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="employee_salary" name="employee_salary" autocomplete="off" value="<?php echo ($employee) ? $employee->emp_salary : ''; ?>">
		</div>		

		<div class="button_sub">
			<input type="hidden" name="employee_id" id="employee_id" value="<?php echo $_POST['id']; ?>">
			<input type="hidden" name="roll_id" id="roll_id" value="<?php echo $_POST['roll_id']; ?>">
			<button type="submit" name="edit_employee_list" id="btn_submit" class="submit-button">Submit</button>
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