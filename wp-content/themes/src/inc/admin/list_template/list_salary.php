<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'salary_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$emp_no = $_POST['emp_no'];
		$emp_name = $_POST['emp_name'];
		$emp_mobile = $_POST['emp_mobile'];

		$employee_status = $_POST['attendance_status'];
	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$emp_no = isset( $_GET['emp_no'] ) ? $_GET['emp_no']  : '';
		$emp_name = isset( $_GET['emp_name'] ) ? $_GET['emp_name']  : '';
		$emp_mobile = isset( $_GET['emp_mobile'] ) ? $_GET['emp_mobile']  : '';
		$employee_status = isset( $_GET['attendance_status'] ) ? $_GET['attendance_status']  : '-';
	}

    $con = false;
    $condition = '';
    if($emp_no != '') {
    	if($con == false) {
    		$condition .= " AND f.employee_no LIKE '".$emp_no."%' ";
    	} else {
    		$condition .= " AND f.employee_no LIKE '".$emp_no."%' ";
    	}
    	$con = true;
    }
    if($emp_name != '') {
   		if($con == false) {
    		$condition .= " AND f.emp_name LIKE '".$emp_name."%' ";
    	} else {
    		$condition .= " AND f.emp_name LIKE '".$emp_name."%' ";
    	}
    	$con = true;
    }
    if($emp_mobile != '') {
   		if($con == false) {
    		$condition .= " AND f.emp_mobile LIKE '".$emp_mobile."%' ";
    	} else {
    		$condition .= " AND f.emp_mobile LIKE '".$emp_mobile."%' ";
    	}
    	$con = true;
    }

    if($employee_status != '-') {
   		if($con == false) {
    		$condition .= " AND f.emp_current_status = '".$employee_status."' ";
    	} else {
    		$condition .= " AND f.emp_current_status = '".$employee_status."' ";
    	}
    	$con = true;
    }
    /*End Updated for filter 11/10/16*/

	$result_args = array(
		'orderby_field' => 'id',
		'page' => $cpage,
		'order_by' => 'ASC',
		'items_per_page' => $ppage ,
		'condition' => $condition,
	);

	$employee_salary = employee_salary_list_pagination($result_args);

?>
	<table class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Employee No</th>
				<th>Name</th>
				<th>Mobile</th>
				<th>Status</th>
				<th>Salary History</th>
				<th>Update</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if( count($employee_salary['result'])>0 ) {
				$start_count = $employee_salary['start_count'];
				foreach ($employee_salary['result'] as $salary_value) {
					$start_count++;
					
					$emp_status =  '-';
					if($salary_value->emp_current_status === "0") {
						$current_status =  'Releave';
					}
					if($salary_value->emp_current_status === "1") {
						$current_status =  'Working';
					}
		?>
			<tr id="employee-data-<?php echo $salary_value->emp_id; ?>">
				<td><?php echo $start_count; ?></td>
				<td><?php echo $salary_value->employee_no; ?></td>
				<td><?php echo $salary_value->emp_name; ?></td>
				<td><?php echo $salary_value->emp_mobile; ?></td>
				<td><?php echo $current_status; ?></td>
				<td>
					<a href="<?php echo admin_url('admin.php?page=salary_list').'&action=salary_detail&emp_id='.$salary_value->emp_id; ?>">
						Salary History
					</a>
				</td>
				<td class="center">
					<span>
						<a class="action-icons c-edit salary_edit" title="Edit" data-roll="<?php echo $start_count; ?>" data-id="<?php echo $salary_value->emp_id; ?>">
							Edit
						</a>
					</span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>

	<?php echo $employee_salary['pagination']; ?>