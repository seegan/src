<?php
	$result_args = array(
		'orderby_field' => 'id',
		'page' => isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1 ,
		'order_by' => 'ASC',
		'items_per_page' => isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20 ,
		'condition' => 'AND ea.emp_id='.$_GET['emp_id'].' ',
	);

	$employee_attendance = employee_attendance_detail_pagination($result_args);
?>
	<table class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Date</th>
				<th>Attendance</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if( count($employee_attendance['result'])>0 ) {
				$start_count = $employee_attendance['start_count'];
				foreach ($employee_attendance['result'] as $attendance_value) {
					$start_count++;
		?>
			<tr id="employee-data-<?php echo $attendance_value->id; ?>">
				<td><?php echo $start_count; ?></td>
				<td><?php echo date('Y-m-d', strtotime($attendance_value->attendance_date) ); ?></td>
				<td><?php echo $attendance_value->attendance; ?></td>
				
				<!-- <td class="center">
					<span>
						<a class="action-icons c-edit salary_edit" title="Edit" data-roll="12" data-id="">Edit</a>
					</span>
				</td> -->
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>

	<?php echo $employee_attendance['pagination']; ?>