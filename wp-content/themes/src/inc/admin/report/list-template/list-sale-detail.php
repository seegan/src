<?php

    if(isset($_POST['action']) && $_POST['action'] == 'stock_sale_filter_list') {
        $cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
        $ppage = $_POST['per_page'];
        $lot_number = $_POST['lot_number'];
        $search_brand = $_POST['search_brand'];
        $search_product = $_POST['search_product'];
        $item_status = $_POST['item_status'];
        $bill_type = $_POST['bill_type'];

        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
    } else {
        $cpage = 1;
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
        $search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
        $search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
        $item_status = isset( $_GET['item_status'] ) ? $_GET['item_status']  : '-';
        $bill_type = isset( $_GET['bill_type'] ) ? $_GET['bill_type']  : '-';

        $date_from = isset( $_GET['date_from'] ) ? $_GET['date_from']  : '';
        $date_to = isset( $_GET['date_to'] ) ? $_GET['date_to']  : '';
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
    		$condition .= " AND l.product_name  LIKE '".$search_product."%' ";
    	} else {
    		$condition .= " AND l.product_name  LIKE '".$search_product."%' ";
    	}
    	$con = true;
    }

    if($item_status != '-') {
        if($con == false) {
            $condition .= " AND sale.item_status  = '".$item_status."' ";
        } else {
            $condition .= " AND sale.item_status  = '".$item_status."' ";
        }
        $con = true;
    }
    if($bill_type != '-') {

        if($con == false) {

            if($bill_type == 'original' || $bill_type == 'duplicate') {
                $condition .= " AND sale.bill_type  = '".$bill_type."' ";
            }
            if($bill_type == 'out_stock') {
                $condition .= " AND sale.bill_from  = '".$bill_type."' ";
            }
            if($bill_type == 'health_store') {
                $condition .= " AND sale.bill_from  = '".$bill_type."' ";
            }            
            if($bill_type == 'rice_center') {
                $condition .= " AND sale.bill_from  = '".$bill_type."' ";
            } 
            if($bill_type == 'rice_mandy') {
                $condition .= " AND sale.bill_from  = '".$bill_type."' ";
            } 
            
        } else {

            if($bill_type == 'original' || $bill_type == 'duplicate') {
                $condition .= " AND sale.bill_type  = '".$bill_type."' ";
            }
            if($bill_type == 'out_stock') {
                $condition .= " AND sale.bill_from  = '".$bill_type."' ";
            }
            if($bill_type == 'health_store') {
                $condition .= " AND sale.bill_from  = '".$bill_type."' ";
            }            
            if($bill_type == 'rice_center') {
                $condition .= " AND sale.bill_from  = '".$bill_type."' ";
            } 
            if($bill_type == 'rice_mandy') {
                $condition .= " AND sale.bill_from  = '".$bill_type."' ";
            } 
        }
        $con = true;
    }

    if($date_from != '' && $date_to == '') {
        if($con == false) {
            $condition .= " AND DATE(sale.invoice_date) >= '".$date_from."' ";
        } else {
            $condition .= " AND DATE(sale.invoice_date) >= '".$date_from."' ";
        }
        $con = true;
    }
    if($date_from == '' && $date_to != '') {
        if($con == false) {
            $condition .= " AND DATE(sale.invoice_date) <= '".$date_to."' ";
        } else {
            $condition .= " AND DATE(sale.invoice_date) <= '".$date_to."' ";
        }
        $con = true;
    }
    if($date_from != '' && $date_to != '') {
   		if($con == false) {
    		$condition .= " AND ( DATE(sale.invoice_date) >= '".$date_from."' AND DATE(sale.invoice_date) <= '".$date_to."') ";
    	} else {
    		$condition .= " AND ( DATE(sale.invoice_date) >= '".$date_from."' AND DATE(sale.invoice_date) <= '".$date_to."') ";
    	}
    	$con = true;
    }

    if($date_from != '' && $date_to == '') {
        if($con == false) {
            $condition_return .= " AND DATE(return_tab.return_date) >= '".$date_from."' ";
        } else {
            $condition_return .= " AND DATE(return_tab.return_date) >= '".$date_from."' ";
        }
        $con = true;
    }
    if($date_from == '' && $date_to != '') {
        if($con == false) {
            $condition_return .= " AND DATE(return_tab.return_date) <= '".$date_to."' ";
        } else {
            $condition_return .= " AND DATE(return_tab.return_date) <= '".$date_to."' ";
        }
        $con = true;
    }
    if($date_from != '' && $date_to != '') {
        if($con == false) {
            $condition_return .= " AND ( DATE(return_tab.return_date) >= '".$date_from."' AND DATE(return_tab.return_date) <= '".$date_to."') ";
        } else {
            $condition_return .= " AND ( DATE(return_tab.return_date) >= '".$date_from."' AND DATE(return_tab.return_date) <= '".$date_to."') ";
        }
        $con = true;
    }



    /*End Updated for filter 11/10/16*/


	$result_args = array(
		'orderby_field' => 'full_sale.invoice_date',
		'page' => $cpage ,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
        'condition' => $condition,
		'condition_return' => $condition_return,
	);

	$sales = sale_detail_list_pagination($result_args);


?>
<?php if(isset($sales['s_result']->weight_s)) {?>
    <div class="module table-simple" style="width:400px;margin: 0 auto;margin-bottom:20px;">
        <table class="display">
            <thead>
                <tr>
                    <th>Sale Weight (Kg)</th>
                    <th>Sale Value (Rs)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $sales['s_result']->weight_s; ?></td>
                    <td><?php echo $sales['s_result']->sale_s; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
<?php } ?>

<div class="widget-content module table-simple list_customers">
	<table class="display">
		<thead>
			<tr>
                <th rowspan="2" class="column-title">Sl. No</th>
				<th rowspan="2" class="column-title">Lot Number</th>
                <th rowspan="2" class="column-title">Brand Name</th>
				<th rowspan="2" class="column-title">Product Name</th>
                <th rowspan="2" class="column-title">Item Status</th>
                <th rowspan="2" class="column-title">Bill Type</th>
                <th rowspan="2" class="column-title">Stock Weight (Kg)</th>
                <th rowspan="2" class="column-title">Taxless Amount</th>
                <th colspan="3" style="border-bottom: none;" class="column-title" >RATE</th>  
                <th colspan="3" style="border-bottom: none;" class="column-title" >AMOUNT</th>
				
                <th rowspan="2" class="column-title"> Sale Value (Kg)</th>
			</tr>
            <tr class="text_bold text_center">
              <th style="border-top: none;text-align: center;" class="column-title" >IGST(%)</th>
              <th style="border-top: none;text-align: center;" class="column-title" >CGST(%)</th>
              <th style="border-top: none;text-align: center;" class="column-title" >SGGST(%)</th>
              <th style="border-top: none;text-align: center;" class="column-title" >IGST</th>
              <th style="border-top: none;text-align: center;" class="column-title" >CGST</th>
              <th style="border-top: none;text-align: center;" class="column-title" >SGST</th>
            </tr>
		</thead>
		<tbody>
		<?php
			if(isset($sales['result']) AND count($sales['result']) > 0 AND $sales){
				$start_count = $sales['start_count'];

				foreach ($sales['result'] as $s_value) {
					$start_count++;
		?>
			<tr id="customer-data-<?php echo $s_value->sale_detail_id; ?>">
                <td><?php echo $start_count; ?></td>
				<td><?php echo $s_value->lot_number; ?></td>
				<td><?php echo $s_value->brand_name; ?></td>
				<td><?php echo $s_value->product_name; ?></td>
				<td><?php echo $s_value->item_status; ?></td>
                <td><?php echo $s_value->bill_type; ?></td>
                <td><?php echo $s_value->final_tot_weight.'Kg ('.bagKgSplitter($s_value->final_tot_weight, $s_value->bag_weight).')'; ?></td>
                <td><?php echo $s_value->taxless_amount; ?></td>
                <td><?php echo $s_value->igst; ?></td>            
                <td><?php echo $s_value->cgst; ?></td>    
                <td><?php echo $s_value->sgst; ?></td>
                <td><?php echo $s_value->igst_amount; ?></td>
                <td><?php echo $s_value->cgst_amount; ?></td>
                <td><?php echo $s_value->sgst_amount; ?></td>
                
                <td><?php echo $s_value->final_tot_sale_value; ?></td>
			</tr>
		<?php
				}
			} else {
				echo "<tr><td colspan='12'>No Sale Made Today!</td></tr>";
			}
		?>
		</tbody>
	</table>
	<?php echo $sales['pagination']; ?>
	<div style="clear:both;"></div>
</div>