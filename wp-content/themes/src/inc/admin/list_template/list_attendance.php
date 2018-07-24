<?php

	if(isset($_POST['action']) && $_POST['action'] == 'attendance_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$emp_no = $_POST['emp_no'];
		$emp_name = $_POST['emp_name'];
		$attendance_date = ($_POST['attendance_date'] != '') ? $_POST['attendance_date'] : date("Y-m-d", time());
		$attendance_status = $_POST['attendance_status'];
	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$emp_no = isset( $_GET['emp_no'] ) ? $_GET['emp_no']  : '';
		$emp_name = isset( $_GET['emp_name'] ) ? $_GET['emp_name']  : '';
		$attendance_date = isset( $_GET['attendance_date'] ) ? $_GET['attendance_date']  : date("Y-m-d", time());
		$attendance_status = isset( $_GET['attendance_status'] ) ? $_GET['attendance_status']  : '-';
	}

    $con = false;
    $condition = '';
    if($emp_no != '') {
    	if($con == false) {
    		$condition .= " AND ff.employee_id LIKE '".$emp_no."%' ";
    	} else {
    		$condition .= " AND ff.employee_id LIKE '".$emp_no."%' ";
    	}
    	$con = true;
    }
    if($emp_name != '') {
   		if($con == false) {
    		$condition .= " AND ff.emp_name LIKE '".$emp_name."%' ";
    	} else {
    		$condition .= " AND ff.emp_name LIKE '".$emp_name."%' ";
    	}
    	$con = true;
    }

    if($attendance_status != '-' ) {
   		if($con == false) {
    		$condition .= " AND ff.att = '".$attendance_status."' ";
    	} else {
    		$condition .= " AND ff.att = '".$attendance_status."' ";
    	}
    	$con = true;
    }
    /*End Updated for filter 11/10/16*/


	$result_args = array(
		'orderby_field' => 'id',
		'page' => $cpage ,
		'order_by' => 'ASC',
		'items_per_page' => $ppage ,
		'condition' => $condition,
		'attendance_date' => $attendance_date,
	);

	$employee = employee_attendance_list_pagination($result_args);

?>
	<table class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Employee No</th>
				<th>Name</th>
				<th>Date</th>
				<th>Attendance</th>
				<th>Action</th>
				<th>History</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if( count($employee['result'])>0 ) {
				$start_count = $employee['start_count'];
				foreach ($employee['result'] as $employees_value) {
					$start_count++;

					$attendance_today =  '-';
					if($employees_value->attendance_today === "0") {
						$attendance_today =  'Absent';
					}
					if($employees_value->attendance_today === "1") {
						$attendance_today =  'Present';
					}
		?>
			<tr id="employee-data-<?php echo $employees_value->id; ?>">
				<td><?php echo $start_count; ?></td>
				<td><?php echo 'EMP'.$employees_value->id; ?></td>
				<td><?php echo $employees_value->emp_name; ?></td>
				<td><?php echo $attendance_date; ?></td>
				<td><div class="attendance_val"><?php echo $attendance_today; ?></div></td>
				<td>
					<select name="attendance_type" class="atten_type mark_attendance" data-attdate="<?php echo $attendance_date; ?>" data-empid="<?php echo $employees_value->id; ?>" >
						<option value="-" <?php echo ($attendance_today === '-') ? 'selected' : '' ?> >Mark Attendance</option>
						<option value="1" <?php echo ($attendance_today === 'Present') ? 'selected' : '' ?> >Present</option>
						<option value="0" <?php echo ($attendance_today === 'Absent') ? 'selected' : '' ?> >Absent</option>
					</select>
				</td>
				<td><a href="<?php echo admin_url('admin.php?page=attendance_list').'&action=attendance_detail&emp_id='.$employees_value->id; ?>">Attendance History</a></td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>
	<?php echo $employee['pagination']; ?>