<?php
global $src_capabilities;

$current_cap = '';
if(isset($_GET['capability'])) {

	$current_cap = get_role($_GET['capability']);
	$editable_roles = get_editable_roles();

}

if(isset($_POST['action']) && $_POST['action'] == 'update_roles') {

	$capabilities = array();

	if($_POST['main_menu']) {
		foreach ($_POST['main_menu'] as $cap_value) {
			if($src_capabilities[$cap_value]) {
				if(is_array($src_capabilities[$cap_value])) {
					foreach ($src_capabilities[$cap_value]['data'] as $cap_key => $c_value) {
						$capabilities[] = $cap_key;
					}
				} else {
					$capabilities[] = $cap_value;
				}
			} else {
				$capabilities[] = $cap_value;
			}
		}
	}


	$new_cap = array_unique($capabilities);  
	$new_cap[] = 'read';

	$new_fliped1 = array_flip($new_cap);
	$new_fliped2 = $current_cap->capabilities;

	$new_data 		= array_diff_key($new_fliped1, $new_fliped2);
	$delete_data 	= array_diff_key($new_fliped2, $new_fliped1);


	if( count($new_data) > 0) {
		foreach ($new_data as $n_key => $n_value) {
			$current_cap->add_cap( $n_key );
		}
	}
	if( count($delete_data) > 0) {
		foreach ($delete_data as $d_key => $d_value) {
			$current_cap->remove_cap( $d_key );
		}
	}
}

if(isset($_POST['action']) && $_POST['action'] == 'create_roles') {

	$role_name 	=  	$_POST['role_name'];
	$role_slug 	= 	$_POST['role_slug'];

	$grant_true		= true;
	$grant_false 	= false;	

	foreach ($_POST['main_menu'] as $cap_value) {
		if($src_capabilities[$cap_value]) {

			if(is_array($src_capabilities[$cap_value])) {
				foreach ($src_capabilities[$cap_value]['data'] as $cap_key => $c_value) {
					$capabilities[] = $cap_key;
				}
			} else {
				$capabilities[] = $cap_value;
			}
		} else {
			$capabilities[] = $cap_value;
		}
	}
	$new_cap = array_unique($capabilities); 
	$new_cap[] = 'read';


/*    global $wp_roles;
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    $adm = $wp_roles->get_role('editor');
    //Adding a 'new_role' with all admin caps
    $wp_roles->add_role('new_role', 'My Custom Role', $adm->capabilities);
*/

	$new_role = add_role( $role_slug, __( $role_name ) );
	if ( null !== $new_role ) {
		foreach ($new_cap as  $cap_value) {
			$new_role->add_cap( $cap_value, $grant_true );
		}
		$html .= '<div class="notice notice-success is-dismissible"><p><strong>Roll Created!</strong></p></div>';
	} else {
		$html .= '<div class="notice notice-error is-dismissible"><p><strong>Something Went Wrong!</strong></p></div>';
	}


echo $html;
}

?>
<div class="widget-top">
	<h4>Add New User</h4>
</div>




<div class="widget-content module">
<div class="form-grid">
<form method="post" name="new_user" id="new_user" class="leftLabel">
<ul>


		<li>
			<label class="fldTitle">Role Name
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<div class="fieldwrap">
				<span class="left">
					<input type="text" name="role_name" id="role_name" required="" <?php echo ( isset($_GET['capability']) ) ? 'readonly' : '' ?> value="<?php echo ( isset($_GET['capability']) ) ? $editable_roles[$current_cap->name]['name'] : '' ?>">
				</span>
			</div>
		</li>
		<li>
			<label class="fldTitle">Role Slug
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<div class="fieldwrap">
				<span class="left">
					<input type="text" name="role_slug" id="role_slug" required="" <?php echo ( isset($_GET['capability']) ) ? 'readonly' : '' ?> value="<?php echo $current_cap->name ?>">
				</span>
			</div>
		</li>


	<li>
		<label class="fldTitle">Role Permission
			<abbr class="require" title="Required Field">*</abbr>
		</label>

		<div class="fieldwrap">
		<span class="left">
			<ul class="permission_modules input-uniform">

<?php


foreach ($src_capabilities as $r_key => $r_value) {

	if(is_array($r_value)) {

		echo '<li class="main_menu" style="border-bottom: 1px solid #ddd;">';
			echo '<div class="checker">';
			echo '	<span class="main_span">';
			echo '		<input type="checkbox" name="main_menu[]" value="'.$r_key.'" style="opacity: 0;" class="main_role">';
			echo '	</span>';
			echo '</div>';
			echo '<strong>'.$r_value['name'].'</strong>';

		foreach ($r_value['data'] as $d_key => $d_value) {
			if( isset( $current_cap->capabilities[$d_key] ) && $current_cap->capabilities[$d_key] ) {
				$checked = 'checked';
			} else {
				$checked = '';
			}
			echo '<ul>';
			echo '	<li class="sub_menu_li">';
			echo '		<div class="checker">';
			echo '			<span class="'.$checked.'">';
			echo '				<input type="checkbox" name="main_menu[]" value="'.$d_key.'" style="opacity: 0;" class="sub_role" '.$checked.'>';
			echo '			</span>';
			echo '		</div>';
			echo 		$d_value;
			echo '	</li>';
			echo '</ul>';
		}
		echo '</li>';
	} else {

		if( isset( $current_cap->capabilities[$r_key] ) && $current_cap->capabilities[$r_key] ) {
			$checked = 'checked';
		} else {
			$checked = '';
		}
		echo '<li class="main_menu" style="border-bottom: 1px solid #ddd;">';
		echo '	<div class="checker">';
		echo '		<span class="'.$checked.'">';
		echo '			<input type="checkbox" name="main_menu[]" value="'.$r_key.'" style="opacity: 0;" class="main_role" '.$checked.'>';
		echo '		</span>';
		echo '	</div>';
		echo '	<strong>'.$r_value.'</strong>';
		echo '</li>';

	}
}

?>
			</ul>
		</span>
		</div>





		</li>
		<li class="buttons bottom-round noboder">
			<div class="fieldwrap">
				<input name="add_user" type="submit" value="Submit" class="submit-button">
			</div>
		</li>
	</ul>
	<?php 
		if(isset( $_GET['capability']) && $edit_cap = $_GET['capability']) {
			echo '<input type="hidden" name="action" value="update_roles">';
		} else {
			echo '<input type="hidden" name="action" value="create_roles">';
		}
	?>
	
</form>
</div>
</div>

<script type="text/javascript">


jQuery(document).ready(function(){
	jQuery('.permission_modules li.main_menu').each(function(c, main) {
		jQuery(main).find('ul li.sub_menu_li .checker .checked input').each(function(c, sub) {

			sub_checked = jQuery(sub).prop( "checked" );
           	sub_check(sub, sub_checked)
		});
		
	});
})

	jQuery("#role_name").keyup(function(){
	    var Text = jQuery(this).val();
	    Text = slugify(Text);
	    jQuery("#role_slug").val(Text);
	});



	var main_checked, sub_checked, main_block;
	jQuery('.main_menu input').click(function(){
		if(jQuery(this).hasClass('main_role')) {
			main_checked = jQuery(this).prop( "checked" );
           	main_check(this, main_checked);
        }

		if(jQuery(this).hasClass('sub_role')) {
			sub_checked = jQuery(this).prop( "checked" );
           	sub_check(this, sub_checked);
        }
	});



function main_check(data, checked) {
   main_block = jQuery(data).parent().parent().parent();

   if(checked) {
   		jQuery(main_block).find('input:checkbox').attr('checked','checked');
		jQuery(data).parent().parent().find('span').addClass('checked');
   } else {
   		jQuery(main_block).find('input:checkbox').removeAttr('checked');
		jQuery(data).parent().parent().find('span').removeClass('checked');
   }

   jQuery( jQuery(main_block).find('ul li') ).each(function() {
   		if(checked){
   			jQuery(this).find('span').addClass('checked');
   		} else {
   			jQuery(this).find('span').removeClass('checked');
   		}
   		
   });
   
}

function sub_check(data, checked) {

	main_block = jQuery(data).parent().parent().parent().parent().parent();

    if(checked) {
		jQuery(data).parent().parent().find('span').addClass('checked');
  	} else {
		jQuery(data).parent().parent().find('span').removeClass('checked');
   	}


   	var is_checked = true;
   	jQuery(jQuery(main_block).find('ul li span')).each(function() {
		if( !jQuery(this).find('input:checkbox').prop( "checked" ) ) {
			is_checked = false;
		}
   	});


	if(is_checked) {
		jQuery(main_block).find('.main_span').addClass('checked');
		jQuery(main_block).find('.main_span input:checkbox').attr('checked','checked')
	} else {
		jQuery(main_block).find('.main_span').removeClass('checked');
		jQuery(main_block).find('.main_span input:checkbox').removeAttr('checked')
	}

}

/*	jQuery('.main_menu input').click(function(){
		console.log(jQuery(this).val());
	})*/
</script>