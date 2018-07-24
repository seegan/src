<?php
	$result_args = array(
		'orderby_field' => 'id',
		'page' => isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1 ,
		'order_by' => 'ASC',
		'items_per_page' => isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20 ,
		'condition' => 'AND es.emp_id='.$_GET['emp_id'].' AND es.remark != "adv_prv" ',
	);

	$employee_salary = employee_salary_detail_pagination($result_args);


?>
	<table class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Employee No</th>
				<th>Employee Name</th>
				<th>Paid Date</th>
				<th>Salary / Advance</th>
				<th>Paid Salary</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if( count($employee_salary['result'])>0 ) {
				$start_count = $employee_salary['start_count'];
				foreach ($employee_salary['result'] as $salary_value) {
					$start_count++;
		?>
			<tr id="employee-data-<?php echo $salary_value->id; ?>">
				<td><?php echo $start_count; ?></td>
				<td><?php echo $salary_value->empp_id; ?></td>
				<td><?php echo $salary_value->emp_name; ?></td>
				<td><?php echo $salary_value->sal_update_date; ?></td>
				<td><?php echo $salary_value->sal_status; ?></td>
				<td><?php echo $salary_value->amount; ?></td>
				
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

	<?php echo $employee_salary['pagination']; ?>