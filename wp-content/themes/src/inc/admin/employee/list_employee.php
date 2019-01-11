<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'employee_list_filter') {
		$ppage = $_POST['per_page'];
		$emp_no = $_POST['emp_no'];
		$emp_name = $_POST['emp_name'];
		$emp_mobile = $_POST['emp_mobile'];
		$emp_salary = $_POST['emp_salary'];
		$join_from = $_POST['join_from'];
		$join_to = $_POST['join_to'];
		$emp_status = $_POST['emp_status'];
	} else {
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$emp_no = isset( $_GET['emp_no'] ) ? $_GET['emp_no']  : '';
		$emp_name = isset( $_GET['emp_name'] ) ? $_GET['emp_name']  : '';
		$emp_mobile = isset( $_GET['emp_mobile'] ) ? $_GET['emp_mobile']  : '';
		$emp_salary = isset( $_GET['emp_salary'] ) ? $_GET['emp_salary']  : '';
		$join_from = isset( $_GET['join_from'] ) ? $_GET['join_from']  : '';
		$join_to = $_POST['join_to'];
		$emp_status = $_POST['emp_status'];
	}
	/*End Updated for filter 11/10/16*/
?>

<div style="width: 100%;">
	<ul class="icons-labeled">
		<li><a href="javascript:void(0);" id="my-button" class="popup-add-employee"><span class="icon-block-color add-c"></span>Add New Employee</a></li>
	</ul>
</div>
<div class="widget-top">
	<h4>Customer List</h4>
</div>

<div class="search_bar employee_filter">
	<label>Page :</label>
	<select name="per_page" id="per_page">
		<option value="5" <?php echo ($ppage == 5) ? 'selected' : ''; ?>>5</option>
		<option value="10" <?php echo ($ppage == 10) ? 'selected' : ''; ?>>10</option>
		<option value="15" <?php echo ($ppage == 15) ? 'selected' : ''; ?>>15</option>

		<option value="20" <?php echo ($ppage == 20) ? 'selected' : ''; ?>>20</option>
		<option value="50" <?php echo ($ppage == 50) ? 'selected' : ''; ?>>50</option>
		<option value="100" <?php echo ($ppage == 100) ? 'selected' : ''; ?>>100</option>
	</select>
	<input type="text" name="emp_no" id="emp_no" autocomplete="off" placeholder="Emplolyee Number" value="<?php echo $emp_no; ?>">
	<input type="text" name="emp_name" id="emp_name" autocomplete="off" placeholder="Employee Name" value="<?php echo $emp_name; ?>">
	<input type="text" name="emp_mobile" id="emp_mobile" autocomplete="off" placeholder="Employee Mobile" value="<?php echo $emp_mobile; ?>">
	<input type="text" name="emp_salary" id="emp_salary" autocomplete="off" placeholder="Employee Salary" value="<?php echo $emp_salary; ?>">
	<input type="text" name="join_from" id="join_from" autocomplete="off" placeholder="Join From" value="<?php echo $join_from ?>">
	<input type="text" name="join_to" id="join_to" autocomplete="off" placeholder="Join To" value="<?php echo $join_to ?>">

	<select name="emp_status" id="emp_status" style="height: 30px;">
		<option value="-">Employee Status</option>
		<option value="1" <?php echo ($emp_status == '1') ? 'selected' : ''; ?>>Working</option>
		<option value="0" <?php echo ($emp_status == '0') ? 'selected' : ''; ?>>Releave</option>
	</select>
</div>


<div class="widget-content module table-simple list_customers">
<?php include( get_template_directory().'/inc/admin/list_template/list_employee.php' ); ?>
</div>
<script type="text/javascript">
    
jQuery(document).ready(function () {
    jQuery('#per_page').focus();
    jQuery(document).live('keydown', function(e){
        if(jQuery(document.activeElement).closest("#wpbody-content").length == 0 && jQuery('#src_info_box').css('display') != 'block') {
            var keyCode = e.keyCode || e.which; 
            if (keyCode == 9) { 
                e.preventDefault(); 
                jQuery('#per_page').focus()
            }
        }
    });
    jQuery("#per_page").live('keydown', function(e) { 
        var keyCode = e.keyCode || e.which; 
        if (event.shiftKey && event.keyCode == 9) { 
            e.preventDefault(); 
            jQuery('.last_list_view').focus();
        } else if(event.keyCode == 9){
            e.preventDefault(); 
            jQuery('#emp_no').focus();
        } else {
         jQuery('#per_page').focus();
        }
    });
    jQuery('.lot_filter input[type="text"]:last').live('keydown', function(e){
        if(jQuery('.display td a').length == 0 && jQuery(".next.page-numbers").length == 0 ) {
            var keyCode = e.keyCode || e.which; 
            if (keyCode == 9) { 
                e.preventDefault(); 
                jQuery('#per_page').focus()
            }
        }
    });
   	jQuery('.last_list_view').live('keydown', function(e) { 
        if(jQuery(this).parent().parent().parent().next('tr').length == 0 && jQuery(".next.page-numbers").length == 0) {
            var keyCode = e.keyCode || e.which; 
            if (event.shiftKey && event.keyCode == 9) { 
                e.preventDefault(); 
                 jQuery(this).parent().parent().find('.list_update').focus();
            } 
            else if ( event.keyCode == 9){
                e.preventDefault(); 
                jQuery('#per_page').focus();
            }
            else {
                jQuery(this).parent().parent().find('.last_list_view').focus();
            } 
        }
    });
    jQuery(".next.page-numbers").live('keydown', function(e) { 
      var keyCode = e.keyCode || e.which; 
      if (keyCode == 9) { 
        e.preventDefault(); 
        jQuery('#per_page').focus()
      } 
    });   
})    

</script>