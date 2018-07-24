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
				<th>Brand Name</th>
				<th>Product Name</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
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
				<td class="center">
					<span>
						<a class="action-icons c-edit lot_edit" title="Edit"  data-roll="<?php echo $start_count; ?>" data-id="<?php echo $lot_value->id; ?>">Edit</a>
					</span>
					<span><a class="action-icons c-delete lot_delete" href="#" data-action="lots" title="delete" data-id="<?php echo $lot_value->id; ?>" data-roll="<?php echo $start_count; ?>">Delete</a></span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>
	<?php echo $lots['pagination']; ?>