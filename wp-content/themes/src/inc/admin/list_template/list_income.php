<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'income_list_filter') {
		$cpage = 1;
		$ppage = $_POST['per_page'];
		$entry_amount = $_POST['entry_amount'];
		$entry_description = $_POST['entry_description'];
		$entry_date_from = $_POST['entry_date_from'];
		$entry_date_to = $_POST['entry_date_to'];
	} else {
		$cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$entry_amount = isset( $_GET['entry_amount'] ) ? $_GET['entry_amount']  : '';
		$entry_description = isset( $_GET['entry_description'] ) ? $_GET['entry_description']  : '';
		$entry_date_from = isset( $_GET['entry_date_from'] ) ? $_GET['entry_date_from']  : '';
		$entry_date_to = isset( $_GET['entry_date_to'] ) ? $_GET['entry_date_to']  : '';
	}

	$amount_data = explode("-",$entry_amount);
	$price = isset($amount_data[0]) ? trim($amount_data[0]) : '';
	$price_to = isset($amount_data[1]) ? trim($amount_data[1]) : '';

    $con = false;
    $condition = '';


    if($price != '' && $price_to == '') {
   		if($con == false) {
    		$condition .= " AND cash_amount = ".$price." ";
    	} else {
    		$condition .= " AND cash_amount = ".$price." ";
    	}
    	$con = true;
    }

    if($price != '' && $price_to != '') {
   		if($con == false) {
    		$condition .= " AND ( cash_amount >= ".$price." AND cash_amount <= ".$price_to.") ";
    	} else {
    		$condition .= " AND ( cash_amount >= ".$price." AND cash_amount <= ".$price_to.") ";
    	}
    	$con = true;
    }


    if($entry_description != '') {
   		if($con == false) {
    		$condition .= " AND cash_description LIKE '".$entry_description."%' ";
    	} else {
    		$condition .= " AND cash_description LIKE '".$entry_description."%' ";
    	}
    	$con = true;
    }

    if($entry_date_from != '' && $entry_date_to == '') {
   		if($con == false) {
    		$condition .= " AND DATE(cash_date) >= '".$entry_date_from."' ";
    	} else {
    		$condition .= " AND DATE(cash_date) >= '".$entry_date_from."' ";
    	}
    	$con = true;
    }
    if($entry_date_from == '' && $entry_date_to != '') {
   		if($con == false) {
    		$condition .= " AND DATE(cash_date) <= '".$entry_date_to."' ";
    	} else {
    		$condition .= " AND DATE(cash_date) <= '".$entry_date_to."' ";
    	}
    	$con = true;
    }
    if($entry_date_from != '' && $entry_date_to != '') {
   		if($con == false) {
    		$condition .= " AND ( DATE(cash_date) >= '".$entry_date_from."' AND DATE(cash_date) <= '".$entry_date_to."' ) ";
    	} else {
    		$condition .= " AND ( DATE(cash_date) >= '".$entry_date_from."' AND DATE(cash_date) <= '".$entry_date_to."' ) ";
    	}
    	$con = true;
    }
    /*End Updated for filter 11/10/16*/



	$result_args = array(
		'orderby_field' => 'id',
		'page' => $cpage,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
		'condition' => $condition,
	);

	$income_list = income_list_pagination($result_args);

?>
	<table class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Date</th>
				<th>Description</th>
				<th>Amount</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if( count($income_list['result'])>0 ) {
				$start_count = $income_list['start_count'];
				foreach ($income_list['result'] as $income_list_value) {
					$start_count++;
		?>
			<tr id="employee-data-<?php echo $income_list_value->id; ?>">
				<td><?php echo $start_count; ?></td>
				<td><?php echo date('Y-m-d', strtotime($income_list_value->cash_date)); ?></td>
				<td><?php echo $income_list_value->cash_description; ?></td>
				<td><?php echo $income_list_value->cash_amount; ?></td>
				<td class="center">
					<span>
						<a class="action-icons c-edit edit_income" title="Edit" data-roll="<?php echo $start_count; ?>" data-id="<?php echo $income_list_value->id; ?>">Edit</a>
					</span>
					<span><a class="action-icons c-delete lot_delete" href="#" data-action="income_list" title="delete" data-roll="<?php echo $start_count; ?>" data-id="<?php echo $income_list_value->id; ?>" data-roll="1">Delete</a></span>
				</td>
			</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>

	<?php echo $income_list['pagination']; ?>