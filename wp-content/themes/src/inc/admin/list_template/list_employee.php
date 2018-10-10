<?php

	if(isset($_POST['action']) && $_POST['action'] == 'employee_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$emp_no = $_POST['emp_no'];
		$emp_name = $_POST['emp_name'];
		$emp_mobile = $_POST['emp_mobile'];
		$emp_salary = $_POST['emp_salary'];
		$join_from = $_POST['join_from'];
		$join_to = $_POST['join_to'];
		$emp_status = $_POST['emp_status'];
	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$emp_no = isset( $_GET['emp_no'] ) ? $_GET['emp_no']  : '';
		$emp_name = isset( $_GET['emp_name'] ) ? $_GET['emp_name']  : '';
		$emp_mobile = isset( $_GET['emp_mobile'] ) ? $_GET['emp_mobile']  : '';
		$emp_salary = isset( $_GET['emp_salary'] ) ? $_GET['emp_salary']  : '';
		$join_from = isset( $_GET['join_from'] ) ? $_GET['join_from']  : '';
		$join_to = $_POST['join_to'];
		$emp_status = $_POST['emp_status'];
	}


    $con = false;
    $condition = '';
    if($emp_no != '') {
    	if($con == false) {
    		$condition .= " AND e.employee_id LIKE '".$emp_no."%' ";
    	} else {
    		$condition .= " AND e.employee_id LIKE '".$emp_no."%' ";
    	}
    	$con = true;
    }
    if($emp_name != '') {
   		if($con == false) {
    		$condition .= " AND e.emp_name LIKE '".$emp_name."%' ";
    	} else {
    		$condition .= " AND e.emp_name LIKE '".$emp_name."%' ";
    	}
    	$con = true;
    }
    if($emp_mobile != '') {
   		if($con == false) {
    		$condition .= " AND e.emp_mobile LIKE '".$emp_mobile."%' ";
    	} else {
    		$condition .= " AND e.emp_mobile LIKE '".$emp_mobile."%' ";
    	}
    	$con = true;
    }

    if($emp_salary != '') {
   		if($con == false) {
    		$condition .= " AND e.emp_salary LIKE '".$emp_salary."%' ";
    	} else {
    		$condition .= " AND e.emp_salary LIKE '".$emp_salary."%' ";
    	}
    	$con = true;
    }
    if($emp_status != '' AND $emp_status != '-') {
   		if($con == false) {
    		$condition .= " AND e.emp_current_status LIKE ".$emp_status." ";
    	} else {
    		$condition .= " AND e.emp_current_status LIKE ".$emp_status." ";
    	}
    	$con = true;
    }

    if($join_from != '' && $join_to == '') {
   		if($con == false) {
    		$condition .= " AND DATE(e.emp_joining) >= '".$join_from."' ";
    	} else {
    		$condition .= " AND DATE(e.emp_joining) >= '".$join_from."' ";
    	}
    	$con = true;
    }
    if($join_from == '' && $join_to != '') {
   		if($con == false) {
    		$condition .= " AND DATE(e.emp_joining) <= '".$join_to."' ";
    	} else {
    		$condition .= " AND DATE(e.emp_joining) <= '".$join_to."' ";
    	}
    	$con = true;
    }
    if($join_from != '' && $join_to != '') {
   		if($con == false) {
    		$condition .= " AND ( DATE(e.emp_joining) >= '".$join_from."' AND DATE(e.emp_joining) <= '".$join_to."' ) ";
    	} else {
    		$condition .= " AND ( DATE(e.emp_joining) >= '".$join_from."' AND DATE(e.emp_joining) <= '".$join_to."' ) ";
    	}
    	$con = true;
    }
    /*End Updated for filter 11/10/16*/



	$result_args = array(
		'orderby_field' => 'e.id',
		'page' => $cpage ,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
		'condition' => $condition,
	);

	$employee = employee_list_pagination($result_args);

?>
	<table class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Employee No</th>
				<th>Name</th>
				<th>Mobile</th>
				<th>Salary</th>
				<th>Address</th>
				<th>Joining Date</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if( count($employee['result'])>0 ) {
				$start_count = $employee['start_count'];
				foreach ($employee['result'] as $employees_value) {
					$start_count++;
		?>
			<tr id="employee-data-<?php echo $employees_value->id; ?>">
				<td><?php echo $start_count; ?></td>
				<td><?php echo 'EMP'.$employees_value->id; ?></td>
				<td><?php echo $employees_value->emp_name; ?></td>
				<td><?php echo $employees_value->emp_mobile; ?></td>
				<td><?php echo $employees_value->emp_salary; ?></td>
				<td><?php echo $employees_value->emp_address; ?></td>
				<td><?php echo machine_to_man_date($employees_value->emp_joining); ?></td>
				<td><?php echo ($employees_value->emp_current_status == 1) ? 'Working' : 'Releave'; ?></td>
				<td class="center">
					<span>
						<a class="action-icons c-edit employee_edit list_update"  href="#" title="Edit" data-roll="<?php echo $start_count; ?>" data-id="<?php echo $employees_value->id; ?>">Edit</a>
					</span>
					<span><a class="action-icons c-delete user_delete last_list_view" href="#" title="delete" data-action="employees" data-roll="<?php echo $start_count; ?>" data-id="<?php echo $employees_value->id; ?>" data-roll="1">Delete</a></span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>

	<?php echo $employee['pagination']; ?>