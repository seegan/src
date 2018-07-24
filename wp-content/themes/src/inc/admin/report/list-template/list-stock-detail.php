<?php

    if(isset($_POST['action']) && $_POST['action'] == 'stock_report_list') {
        $cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
        $ppage = $_POST['per_page'];
        $lot_number = $_POST['lot_number'];
        $search_brand = $_POST['search_brand'];
        $search_product = $_POST['search_product'];
        $stock_total = $_POST['stock_total'];
        $sale_total = $_POST['sale_total'];
        $stock_bal = $_POST['stock_bal'];
    } else {
        $cpage = 1;
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
        $search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
        $search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
        $stock_total = isset( $_GET['stock_total'] ) ? $_GET['stock_total']  : '';
        $sale_total = isset( $_GET['sale_total'] ) ? $_GET['sale_total']  : '';
        $stock_bal = isset( $_GET['stock_bal'] ) ? $_GET['stock_bal']  : '';
    }


    $stock_total = explode("-",$stock_total);
    $stock_total_from = isset($stock_total[0]) ? trim($stock_total[0]) : '';
    $stock_total_to = isset($stock_total[1]) ? trim($stock_total[1]) : '';

	$sale_total = explode("-",$sale_total);
	$sale_total_from = isset($sale_total[0]) ? trim($sale_total[0]) : '';
	$sale_total_to = isset($sale_total[1]) ? trim($sale_total[1]) : '';

    $stock_bal = explode("-",$stock_bal);
    $stock_bal_from = isset($stock_bal[0]) ? trim($stock_bal[0]) : '';
    $stock_bal_to = isset($stock_bal[1]) ? trim($stock_bal[1]) : '';



    $con = false;
    $condition = '';
    if($lot_number != '') {
    	if($con == false) {
    		$condition .= " AND lo.lot_number LIKE '".$lot_number."%' ";
    	} else {
    		$condition .= " AND lo.lot_number LIKE '".$lot_number."%' ";
    	}
    	$con = true;
    }
    if($search_brand != '') {
   		if($con == false) {
    		$condition .= " AND lo.brand_name LIKE '".$search_brand."%' ";
    	} else {
    		$condition .= " AND lo.brand_name LIKE '".$search_brand."%' ";
    	}
    	$con = true;
    }
    if($search_product != '') {
   		if($con == false) {
    		$condition .= " AND lo.product_name  LIKE '".$search_product."%' ";
    	} else {
    		$condition .= " AND lo.product_name  LIKE '".$search_product."%' ";
    	}
    	$con = true;
    }



    if($stock_total_from != '' && $stock_total_to == '') {
        if($con == false) {
            $condition .= " AND lo.stock_tot >= '".$stock_total_from."' ";
        } else {
            $condition .= " AND lo.stock_tot >= '".$stock_total_from."' ";
        }
        $con = true;
    }
    if($stock_total_from == '' && $stock_total_to != '') {
        if($con == false) {
            $condition .= " AND lo.stock_tot <= '".$stock_total_to."' ";
        } else {
            $condition .= " AND lo.stock_tot <= '".$stock_total_to."' ";
        }
        $con = true;
    }
    if($stock_total_from != '' && $stock_total_to != '') {
   		if($con == false) {
    		$condition .= " AND ( lo.stock_tot >= ".$stock_total_from." AND lo.stock_tot <= ".$stock_total_to.") ";
    	} else {
    		$condition .= " AND ( lo.stock_tot >= ".$stock_total_from." AND lo.stock_tot <= ".$stock_total_to.") ";
    	}
    	$con = true;
    }


    if($sale_total_from != '' && $sale_total_to == '') {
        if($con == false) {
            $condition .= " AND lo.sale_tot >= '".$sale_total_from."' ";
        } else {
            $condition .= " AND lo.sale_tot >= '".$sale_total_from."' ";
        }
        $con = true;
    }
    if($sale_total_from == '' && $sale_total_to != '') {
        if($con == false) {
            $condition .= " AND lo.sale_tot <= '".$sale_total_to."' ";
        } else {
            $condition .= " AND lo.sale_tot <= '".$sale_total_to."' ";
        }
        $con = true;
    }
    if($sale_total_from != '' && $sale_total_to != '') {
        if($con == false) {
            $condition .= " AND ( lo.sale_tot >= ".$sale_total_from." AND lo.sale_tot <= ".$sale_total_to.") ";
        } else {
            $condition .= " AND ( lo.sale_tot >= ".$sale_total_from." AND lo.sale_tot <= ".$sale_total_to.") ";
        }
        $con = true;
    }



    if($stock_bal_from != '' && $stock_bal_to == '') {
        if($con == false) {
            $condition .= " AND lo.sale_tot >= '".$stock_bal_from."' ";
        } else {
            $condition .= " AND lo.sale_tot >= '".$stock_bal_from."' ";
        }
        $con = true;
    }
    if($stock_bal_from == '' && $stock_bal_to != '') {
        if($con == false) {
            $condition .= " AND lo.sale_tot <= '".$stock_bal_to."' ";
        } else {
            $condition .= " AND lo.sale_tot <= '".$stock_bal_to."' ";
        }
        $con = true;
    }
    if($stock_bal_from != '' && $stock_bal_to != '') {
        if($con == false) {
            $condition .= " AND ( lo.bal_stock >= ".$stock_bal_from." AND lo.bal_stock <= ".$stock_bal_to.") ";
        } else {
            $condition .= " AND ( lo.bal_stock >= ".$stock_bal_from." AND lo.bal_stock <= ".$stock_bal_to.") ";
        }
        $con = true;
    }


    /*End Updated for filter 11/10/16*/


	$result_args = array(
		'orderby_field' => 'lo.id',
		'page' => $cpage ,
		'order_by' => 'ASC',
		'items_per_page' => $ppage ,
		'condition' => $condition,
	);
	$stocks = stock_detail_list_pagination($result_args);

?>
<div class="widget-content module table-simple list_customers">
	<table class="display">
		<thead>
			<tr>
                <th>Sl. No</th>
				<th>Lot No</th>
				<th>Brand Name</th>
				<th>Product Name</th>
				<th>Stock Total (Kg)</th>
				<th>Sale Total (Kg)</th>
				<th>Stock Balance (Kg)</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if(isset($stocks['result']) AND count($stocks['result']) > 0 AND $stocks){
				$start_count = $stocks['start_count'];

				foreach ($stocks['result'] as $s_value) {
					$start_count++;
		?>
			<tr id="customer-data-<?php echo $s_value->id; ?>">
                <td><?php echo $start_count; ?></td>
				<td><?php echo $s_value->lot_number; ?></td>
				<td><?php echo $s_value->brand_name; ?></td>
				<td><?php echo $s_value->product_name; ?></td>
				<td><?php echo $s_value->stock_tot; ?></td>
				<td><?php echo $s_value->sale_tot; ?></td>
				<td><?php echo $s_value->bal_stock; ?></td>
			</tr>
		<?php
				}
			} else {
				echo "<tr><td colspan='12'>No Sale Made Today!</td></tr>";
			}
		?>
		</tbody>
	</table>
	<?php echo $stocks['pagination']; ?>
	<div style="clear:both;"></div>
</div>








