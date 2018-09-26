<?php
	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'stock_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$lot_number = $_POST['lot_number'];
		$search_brand = $_POST['search_brand'];
		$search_product = $_POST['search_product'];
		$search_from = $_POST['search_from'];
		$search_to = $_POST['search_to'];
	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
		$search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
		$search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
		$search_from = isset( $_GET['search_from'] ) ? $_GET['search_from']  : '';
		$search_to = isset( $_GET['search_to'] ) ? $_GET['search_to']  : '';
	}


    $con = false;
    $condition = '';
    if($lot_number != '') {
    	if($con == false) {
    		$condition .= " AND l.lot_number LIKE '".$lot_number."%' ";
    	} else {
    		$condition .= " AND l.lot_number LIKE '".$lot_number."%' ";
    	}
    	$con = true;
    }
    if($search_brand != '') {
   		if($con == false) {
    		$condition .= " AND l.brand_name LIKE '".$search_brand."%' ";
    	} else {
    		$condition .= " AND l.brand_name LIKE '".$search_brand."%' ";
    	}
    	$con = true;
    }
    if($search_product != '') {
   		if($con == false) {
    		$condition .= " AND l.product_name LIKE '".$search_product."%' ";
    	} else {
    		$condition .= " AND l.product_name LIKE '".$search_product."%' ";
    	}
    	$con = true;
    }

    if($search_from != '' && $search_to == '') {
   		if($con == false) {
    		$condition .= " AND DATE(s.created_at) >= '".$search_from."' ";
    	} else {
    		$condition .= " AND DATE(s.created_at) >= '".$search_from."' ";
    	}
    	$con = true;
    }
    if($search_from == '' && $search_to != '') {
   		if($con == false) {
    		$condition .= " AND DATE(s.created_at) <= '".$search_to."' ";
    	} else {
    		$condition .= " AND DATE(s.created_at) <= '".$search_to."' ";
    	}
    	$con = true;
    }
    if($search_from != '' && $search_to != '') {
   		if($con == false) {
    		$condition .= " AND ( DATE(s.created_at) >= '".$search_from."' AND DATE(s.created_at) <= '".$search_to."' ) ";
    	} else {
    		$condition .= " AND ( DATE(s.created_at) >= '".$search_from."' AND DATE(s.created_at) <= '".$search_to."' ) ";
    	}
    	$con = true;
    }
    /*End Updated for filter 11/10/16*/


	$result_args = array(
		'orderby_field' => 's.id',
		'page' => $cpage,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
		'condition' => $condition,
	);
	$stocks = stock_list_pagination($result_args);
?>
	<table class="display">
		<thead>
			<tr>
				<th>Stock ID</th>
				<th>Lot Number</th>
				<th>Brand</th>
				<th>Product Name</th>
				<th>Stock Weight</th>
				<th>Stock Count</th>
				<th>Stock Updated</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if( count($stocks['result'])>0 ) {
				foreach ($stocks['result'] as $stock_value) {
		?>
			<tr id="customer-data-<?php echo $stock_value->id; ?>">
				<td><?php echo $stock_value->id; ?></td>
				<td><?php echo $stock_value->lot_number; ?></td>
				<td><?php echo $stock_value->brand_name; ?></td>
				<td><?php echo $stock_value->product_name; ?></td>
				<td><?php echo $stock_value->total_weight; ?> Kg</td>
				<td><?php echo $stock_value->bags_count; ?></td>
				<td><?php echo $stock_value->created_at; ?></td>
				<td class="center">
					<span>
						<a class="action-icons c-edit stock_edit list_update" title="Edit" href="#" data-roll="12" data-id="<?php echo $stock_value->id; ?>">Edit</a>
					</span>
					<span><a class="action-icons c-delete lot_delete last_list_view" href="#" data-action="stock" title="delete" data-id="<?php echo $stock_value->id; ?>" data-roll="1">Delete</a></span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>
	<?php echo $stocks['pagination']; ?>