<?php
	
	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'purchase_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$from = $_POST['from'];
		$to = $_POST['to'];

	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$from = isset( $_GET['from'] ) ? $_GET['from']  : '';
		$to = isset( $_GET['to'] ) ? $_GET['to']  : '';		
	}


    $con = false;
    $condition = '';
    if($from != '') {
    	if($con == false) {
    		$condition .= " AND lot_number LIKE '".$from."%' ";
    	} else {
    		$condition .= " AND lot_number LIKE '".$from."%' ";
    	}
    	$con = true;
    }
    if($to != '') {
   		if($con == false) {
    		$condition .= " AND brand_name LIKE '".$to."%' ";
    	} else {
    		$condition .= " AND brand_name LIKE '".$to."%' ";
    	}
    	$con = true;
    }
  
    

    /*End Updated for filter 11/10/16*/

	$result_args = array(
		'orderby_field' => 'id',
		'page' => $cpage ,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
		'condition' =>$condition,
	);
	$lots =purchase_list_pagination($result_args);
	
?>
	<table class="display">
		<thead>
			<tr>
				<th>Sl. No</th>
				<th>Name</th>
				<th>Mobile</th>
				<th>Bill Number</th>
				<th>Bill Date</th>
				<th>Total Amount</th>
				
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php  
			if(count($lots['result'])>0 ) {
				$start_count = $lots['start_count'];
				foreach ($lots['result'] as $lot_value) {
			$start_count++;
					
		?>
			<tr id="customer-data-<?php echo $lot_value->id; ?>">
				<td><?php echo $start_count; ?></td>
				<td><?php echo $lot_value->name; ?></td>
				<td><?php echo $lot_value->mobile; ?></td>
				<td><?php echo $lot_value->billno; ?></td>
				<td><?php echo $lot_value->billdate; ?></td>
				<td><?php echo $lot_value->grand_total; ?>
				</td>
				<td class="center">
					<span>
						<a class="list_update" title="View"  href="<?php echo admin_url('admin.php?page=purchase_list').'&purchase_id='.$lot_value->id.'&action=viewform'; ?>"  data-roll="<?php echo $start_count; ?>" data-id="<?php echo $lot_value->id; ?>">View Details</a>
					</span>&nbsp;<b>|</b>&nbsp;
					<span><a class="last_list_view" href="<?php echo admin_url('admin.php?page=purchase_list').'&purchase_id='.$lot_value->id.'&action=delete'; ?>" data-action="lots" title="delete" data-id="<?php echo $lot_value->id; ?>" data-roll="<?php echo $start_count; ?>">Delete</a></span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>
	<?php echo $lots['pagination']; ?>