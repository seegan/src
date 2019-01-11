<?php
$editable_roles = get_editable_roles();
unset($editable_roles['administrator']);
unset($editable_roles['editor']);
unset($editable_roles['author']);
unset($editable_roles['contributor']);
unset($editable_roles['subscriber']);
unset($editable_roles['customer']);
unset($editable_roles['employee']);

$user = false;
if(isset($_GET['page_action']) AND $_GET['page_action'] == 'admin_edit' AND isset($_GET['user_id']) ) {
	$user_id = $_GET['user_id'];
	$user = get_userdata($user_id);

	$current_role = implode(', ', $user->roles);
}

if(isset($_POST['action']) && $_POST['action'] == 'admin_update') {
	$user_name = $_POST['user_name'];
	$password = $_POST['password'];
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
	$user_role = $_POST['role'];

	$u = new WP_User( $user_id );
	$u->remove_role( $current_role );

	wp_update_user(array('ID' => $user_id,'role' => $user_role));
	update_user_meta($user_id, 'mobile', $mobile);

}

if(isset($_POST['action']) AND $_POST['action'] == 'admin_create') {
	$user_name = $_POST['user_name'];
	$password = $_POST['password'];
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
	$user_role = $_POST['role'];

	$user_id = username_exists( $user_name );
	if ( !$user_id and email_exists($user_email) == false ) {
		$user_id = wp_create_user( $user_name, $password, $email ); 
		wp_update_user(array('ID' => $user_id,'role' => $user_role));
		update_user_meta($user_id, 'mobile', $mobile);

		$html .= '<div class="notice notice-success is-dismissible"><p><strong>User Created!</strong></p></div>';
	} else {
		$html .= '<div class="notice notice-error is-dismissible"><p><strong>Username Already Exist!</strong></p></div>';
	}
}
echo $html;
?>

<div class="widget-top">
	<h4>Add New Admin User</h4>
</div>
<div class="widget-content module">
	<div class="form-grid">
		<form method="post" name="new_user" id="new_user" class="leftLabel">
			<ul>
				<li>
					<label class="fldTitle">User Name (Login Name)
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<div class="fieldwrap">
						<span class="left">
							<input type="text" name="user_name" id="user_name" required="" <?php echo ($user) ? 'readonly' : ''; ?> value="<?php echo ($user) ? $user->data->user_login : '';  ?>">
						</span>
					</div>
				</li>
				<li>
					<label class="fldTitle">Password
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<div class="fieldwrap">
						<span class="left">
							<input type="text" name="password" id="password" required="" value="">
						</span>
					</div>
				</li>
				<li>
					<label class="fldTitle">Mobile
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<div class="fieldwrap">
						<span class="left">
							<input type="text" name="mobile" id="mobile" required="" value="<?php echo get_user_meta($user->data->ID, 'mobile', true ); ?>">
						</span>
					</div>
				</li>
				<li>
					<label class="fldTitle">Email
					</label>
					<div class="fieldwrap">
						<span class="left">
							<input type="text" name="email" id="email" value="<?php echo ($user) ? $user->data->user_email : '';  ?>">
						</span>
					</div>
				</li>
				<li>
					<label class="fldTitle">User Role
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<div class="fieldwrap">
						<span class="left">
							<select name="role" data-placeholder="Choose a Role..." class="chosen-select" style="width:350px;" tabindex="2">
								<?php
								$selected = '';
								foreach ($editable_roles as $key => $role_value) {

									if($user && $current_role === $key) {
										$selected = 'selected';
									} else {
										$selected = '';
									}
									echo '<option '.$selected.'  value="'.$key.'">'.$role_value['name'].'</option>';
								}
								?>
							</select>
						</span>
					</div>
				</li>
				<li class="buttons bottom-round noboder">
					<div class="fieldwrap">
						<input type="hidden" name="action" value="<?php echo ($user) ? 'admin_update' : 'admin_create' ?>">
						<input name="add_user" type="submit" value="Submit" class="submit-button">
					</div>
				</li>
			</ul>
		</form>
	</div>
</div>

<script type="text/javascript">

jQuery(".chosen-select").select2();


	//jQuery(".chosen-select").chosen();
</script>