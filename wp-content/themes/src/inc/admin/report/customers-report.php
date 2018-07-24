<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'customer_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$customer_name = $_POST['customer_name'];
		$customer_mobile = $_POST['customer_mobile'];
		$customer_type = $_POST['customer_type'];
	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 10;
		$customer_name = isset( $_GET['customer_name'] ) ? $_GET['customer_name']  : '';
		$customer_mobile = isset( $_GET['customer_mobile'] ) ? $_GET['customer_mobile']  : '';
		$customer_type = isset( $_GET['customer_type'] ) ? $_GET['customer_type']  : '';
	}

    $con = false;
    $condition = '';
    if($customer_name != '') {
    	if($con == false) {
    		$condition .= " AND name LIKE '".$customer_name."%' ";
    	} else {
    		$condition .= " AND name LIKE '".$customer_name."%' ";
    	}
    	$con = true;
    }
    if($customer_mobile != '') {
   		if($con == false) {
    		$condition .= " AND mobile LIKE '".$customer_mobile."%' ";
    	} else {
    		$condition .= " AND mobile LIKE '".$customer_mobile."%' ";
    	}
    	$con = true;
    }
    if($customer_type != '' AND $customer_type != '-') {
   		if($con == false) {
    		$condition .= " AND type = '".$customer_type."' ";
    	} else {
    		$condition .= " AND type = '".$customer_type."' ";
    	}
    	$con = true;
    }

	/*End Updated for filter 11/10/16*/

	$result_args = array(
		'orderby_field' => 'id',
		'page' => $cpage ,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
		'condition' => $condition,
	);
	$customers = customer_list_pagination($result_args);

?>
<div class="widget-content module table-simple list_customers">
	<table class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Customer Name</th>
				<th>Customer Mobile</th>
				<th>Address</th>
				<th>Customer Type</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if( count($customers['result'])>0 ) {
				$start_count = $customers['start_count'];
				foreach ($customers['result'] as $customer_value) {
					$start_count++;
		?>
			<tr id="customer-data-<?php echo $customer_value->id; ?>">
				<td><?php echo $start_count; ?></td>
				<td><?php echo $customer_value->name; ?></td>
				<td><?php echo $customer_value->mobile; ?></td>
				<td><?php echo $customer_value->address; ?></td>
				<td><?php echo $customer_value->type; ?></td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>
</div>
<?php echo $customers['pagination']; ?>
<div style="clear:both;"></div>