<?php
	
	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'lot_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$lot_number = $_POST['lot_number'];
		$search_brand = $_POST['search_brand'];
		$search_product = $_POST['search_product'];
	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
		$search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
		$search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
	}


    $con = false;
    $condition = '';
    if($lot_number != '') {
    	if($con == false) {
    		$condition .= " AND lot_number LIKE '".$lot_number."%' ";
    	} else {
    		$condition .= " AND lot_number LIKE '".$lot_number."%' ";
    	}
    	$con = true;
    }
    if($search_brand != '') {
   		if($con == false) {
    		$condition .= " AND brand_name LIKE '".$search_brand."%' ";
    	} else {
    		$condition .= " AND brand_name LIKE '".$search_brand."%' ";
    	}
    	$con = true;
    }
    if($search_product != '') {
   		if($con == false) {
    		$condition .= " AND product_name LIKE '".$search_product."%' ";
    	} else {
    		$condition .= " AND product_name LIKE '".$search_product."%' ";
    	}
    	$con = true;
    }

    /*End Updated for filter 11/10/16*/

	$result_args = array(
		'orderby_field' => 'id',
		'page' => $cpage ,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
		'condition' => 'AND lot_type="original" '.$condition,
	);
	$lots = lot_list_pagination($result_args);
?>
	<table class="display">
		<thead>
			<tr>
				<th>Sl. No</th>
				<th>Lot Number</th>
				<th>Display Name</th>
				<th>Product Name</th>
				<th style="width: 150px;">Last Added Stock (Bag)</th>
				<th style="width: 150px;">Add Stock (Bag)</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php //print_r($lots['result'] );
			if( count($lots['result'])>0 ) {
				$start_count = $lots['start_count'];
				foreach ($lots['result'] as $lot_value) {
			$start_count++;
					
		?>
			<tr id="customer-data-<?php echo $lot_value->id; ?>">
				<td><?php echo $start_count; ?></td>
				<td><?php echo $lot_value->lot_number; ?></td>
				<td><?php echo $lot_value->brand_name; ?></td>
				<td><?php echo $lot_value->product_name; ?></td>
				<td><?php  echo $c=get_last_insert_stock_count($lot_value->id); ?></td>
				<td>
					<span>
						<a class="add_stock_list" title="Add"  href="#"  data-roll="<?php echo $start_count; ?>" data-id="<?php echo $lot_value->id; ?>">Add Stock</a>
					</span>
					<span class="add_stock_display" style="display: none">
						<input type="hidden" name="user_id" value="<?php  echo $user = get_current_user_id();?>" id="user_id">
						<input type="hidden" name="lot_id" class="lot_id" value="<?php echo $lot_value->id; ?>">
						<input type="hidden" name="user_id" value="<?php  echo $user = get_current_user_id();?>" id="user_id">
					    <input type="text" name="add_stock_input" onkeypress="return isNumberKey(event)" class="add_stock_input" id="add_stock_input" style="width: 70px;">
					    <input type="button" name="Add" value="Add" user_id="<?php  echo $user = get_current_user_id();?>" class="add_stock_button" id="add_stock_button">
					</span>
				</td>
				<td class="center">
					<span>
						<a class="action-icons c-edit lot_edit list_update" title="Edit"  href="#"  data-roll="<?php echo $start_count; ?>" data-id="<?php echo $lot_value->id; ?>">Edit</a>
					</span>
					<span><a class="action-icons c-delete lot_delete last_list_view" href="#" data-action="lots" title="delete" data-id="<?php echo $lot_value->id; ?>" data-roll="<?php echo $start_count; ?>">Delete</a></span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>
	<?php echo $lots['pagination']; ?>