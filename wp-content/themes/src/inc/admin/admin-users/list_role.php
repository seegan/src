<?php
$editable_roles = get_editable_roles();
unset($editable_roles['administrator']);
unset($editable_roles['editor']);
unset($editable_roles['author']);
unset($editable_roles['contributor']);
unset($editable_roles['subscriber']);
unset($editable_roles['customer']);
unset($editable_roles['employee']);

global $src_capabilities;


$capabilities_order = '';
foreach ($src_capabilities as $cap_key => $cap_value) {

	if(is_array($cap_value)) {
		foreach ($cap_value['data'] as $sub_key => $sub_value) {
			$capabilities_order[$sub_key] = $sub_value;
		}
	} else {
		$capabilities_order[$cap_key] = $cap_value;
	}
	
}
//var_dump($src_capabilities);

/*echo "<pre>";
var_dump($editable_roles);*/
?>

<style type="text/css">

</style>

<div class="search_bar">
<!-- 	<label>Page :</label>
	<select name="per_page" id="per_page">
		<option value="20">20</option>
		<option value="50">50</option>
		<option value="100">100</option>
	</select>
	<label>Search by User :</label>
	<input type="text" name="search_user" id="search_user" autocomplete="off">
	<label>Status</label> -->
</div>


<div class="widget-content module table-simple">
	<table class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Role Name</th>
				<th>Capabilities</th>
				<th>Edit</th>
				<!-- <th>Delete</th> -->
			</tr>
		</thead>
		<tbody>
		<?php
			$i = 1;
			foreach ($editable_roles as $role_key => $role_value) {
		?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $role_value['name']; ?></td>
				<td>
					<?php
						$j = 1;
						$sep = ' ';
						$cap_total = count($role_value['capabilities']);
						foreach ($role_value['capabilities'] as $key => $value) {

							if($capabilities_order[$key]) {
								if($j  < $cap_total) {
									$sep = ', ';
								} else {
									$sep = '';
								}
								echo $capabilities_order[$key].$sep;
							}
							$j++;
						}
					?>
				</td>
				<td class="center">
					<span>
						<a class="action-icons c-edit user_edit" href="<?php echo menu_page_url( 'add_role', 0 ).'&capability='.$role_key; ?>" title="Edit" data-id="9">Edit</a>
					</span>
				</td>
				<!-- <td class="center">
					<span><a class="action-icons c-delete user_delete" href="#" title="delete" data-id="11">Delete</a></span>
				</td> -->
			</tr>
		<?php
				$i++;
			}
		?>
		</tbody>
	</table>
</div>