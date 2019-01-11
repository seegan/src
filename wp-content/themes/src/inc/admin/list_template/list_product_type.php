<?php
	
	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'ptype_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$search_product = $_POST['search_product'];
	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
	}


    $con = false;
    $condition = '';
    if($search_product != '') {
   		if($con == false) {
    		$condition .= " AND name LIKE '".$search_product."%' ";
    	} else {
    		$condition .= " AND name LIKE '".$search_product."%' ";
    	}
    	$con = true;
    }

    /*End Updated for filter 11/10/16*/

	$result_args = array(
		'orderby_field' => 'id',
		'page' => $cpage ,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
		'condition' => 'AND active=1 '.$condition,
	);
	$ptype =ptype_list_pagination($result_args);
?>
	<table class="display">
		<thead>
			<tr>
				<th>Sl. No</th>
				<th>Product Type</th>
				<th>Date</th>
				<th>Created by</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php //print_r($lots['result'] );
			if( count($ptype['result'])>0 ) {
				$start_count = $ptype['start_count'];
				foreach ($ptype['result'] as $ptype_value) {
			$start_count++;
					
		?>
			<tr id="customer-data-<?php echo $lot_value->ID; ?>">
				<td><?php echo $start_count; ?></td>
				<td><?php echo $ptype_value->name; ?></td>
				<td><?php  echo machine_to_man_date($ptype_value->date); ?></td>
				<td><?php 					
					 $made_by = get_userdata($ptype_value->createdby);
				 	echo ($made_by->user_login) ? $made_by->user_login : '-'; ?></td>

				<td class="center">
					<input type="hidden" name="user_id" value="<?php  echo $user = get_current_user_id();?>" id="user_id">
					<span>
						<a class="action-icons c-edit ptype_edit list_update" title="Edit"  href="#"  data-roll="<?php echo $start_count; ?>" data-id="<?php echo $ptype_value->ID; ?>">Edit</a>
					</span>
					<span><a class="action-icons c-delete ptype_delete last_list_view" href="#" data-action="product_type" title="delete" data-id="<?php echo $ptype_value->ID; ?>" data-roll="<?php echo $start_count; ?>" data-user="<?php  echo $user = get_current_user_id();?>">Delete</a></span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>
	<?php echo $ptype['pagination']; ?>