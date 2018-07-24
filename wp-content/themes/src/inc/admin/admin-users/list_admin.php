<?php
$editable_roles = get_editable_roles();
unset($editable_roles['administrator']);
unset($editable_roles['editor']);
unset($editable_roles['author']);
unset($editable_roles['contributor']);
unset($editable_roles['subscriber']);
unset($editable_roles['customer']);
unset($editable_roles['employee']);



$args = array(
	'blog_id'      => $GLOBALS['blog_id'],
	'role'         => '',
	'role__in'     => array(),
	'role__not_in' => array('administrator', 'editor', 'author', 'contributor', 'subscriber', 'customer', 'employee'),
	'meta_key'     => '',
	'meta_value'   => '',
	'meta_compare' => '',
	'meta_query'   => array(),
	'date_query'   => array(),        
	'include'      => array(),
	'exclude'      => array(),
	'orderby'      => 'login',
	'order'        => 'ASC',
	'offset'       => '',
	'search'       => '',
	'number'       => '',
	'count_total'  => false,
	'fields'       => 'all',
	'who'          => ''
 ); 
$users = get_users( $args );


?>


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
				<th>User Name</th>
				<th>User Mobile</th>
				<th>User Email</th>
				<th>Created On</th>
				<th>Last Login</th>
				<th>Role</th>
				<th>Edit</th>
				<!-- <th>Delete</th> -->
			</tr>
		</thead>
		<tbody>
		<?php
			$i = 0;
			foreach ($users as $user_value) {
				$i++;
				$l_role = implode(', ', $user_value->roles);
		?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $user_value->data->user_login; ?></td>
				<td><?php echo get_user_meta($user_value->data->ID, 'mobile', true ); ?></td>
				<td><?php echo $user_value->data->user_email; ?></td>
				<td></td>
				<td></td>
				<td><?php echo $editable_roles[$l_role]['name']; ?></td>
				<td class="center">
					<span>
						<a class="action-icons c-edit user_edit" title="Edit" data-id="9" href="<?php echo menu_page_url( 'admin_users', 0 ).'&page_action=admin_edit&user_id='.$user_value->data->ID; ?>">Edit</a>
					</span>
				</td>
				<!-- <td class="center">
					<span><a class="action-icons c-delete user_delete" href="#" title="delete" data-id="11">Delete</a></span>
				</td> -->
			</tr>
		<?php
			}
		?>

		</tbody>
	</table>
</div>