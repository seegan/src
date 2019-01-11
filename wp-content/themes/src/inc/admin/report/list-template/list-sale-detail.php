<?php

    if(isset($_POST['action']) && $_POST['action'] == 'stock_sale_filter_list') {
        $cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
        $ppage = $_POST['per_page'];
        $lot_number = $_POST['lot_number'];
        $bill_type = $_POST['bill_type'];
        $item_status = $_POST['item_status'];
        $lot_type = $_POST['lot_type'];

        $date_from = ( isset( $_POST['date_from'] ) && $_POST['date_from'] != '' )  ? man_to_machine_date($_POST['date_from']) : date('Y-m-d');
        $date_to = ( isset( $_POST['date_to'] ) && $_POST['date_to'] != '' )  ? man_to_machine_date($_POST['date_to']) : date('Y-m-d');


        $search_brand = $_POST['search_brand'];
        $search_product = $_POST['search_product'];


    } else {
        $cpage = 1;
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
        $bill_type = isset( $_GET['bill_type'] ) ? $_GET['bill_type']  : '-';
        $item_status = isset( $_GET['item_status'] ) ? $_GET['item_status']  : '-';
        $lot_type = isset( $_GET['lot_type'] ) ? $_GET['lot_type']  : '-';

        $date_from = ( isset( $_GET['date_from'] ) && $_GET['date_from'] != ''  ) ? man_to_machine_date($_GET['date_from'])  : date('Y-m-d');
        $date_to = ( isset( $_GET['date_to'] ) && $_GET['date_to'] != '' ) ? man_to_machine_date($_GET['date_to'])  : date('Y-m-d');


        $search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
        $search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
    }
    $con = false;
    $condition = '';

    if($lot_number != '') {
        if($con == false) {
            $condition .= " AND f.lot_number = '".$lot_number."' ";
        } else {
            $condition .= " AND f.lot_number = '".$lot_number."' ";
        }
        $con = true;
    }
    if($bill_type != '-') {
        $condition .= " AND f.bill_type  = '".$bill_type."' ";
        $con = true;
    }
    if($item_status != '-') {
        $condition .= " AND f.report_type  = '".$item_status."' ";
        $con = true;
    }
    if($lot_type != '-') {
        if( $lot_type == 'original' ) {
            $condition .= " AND f.lot_type  = '".$lot_type."' ";
            $con = true;
        }
        if( $lot_type == 'dummy' ) {
            $condition .= " AND f.lot_type  = '".$lot_type."' ";
            $con = true;
        }
    }


    $sale_condition .= "( DATE(s.invoice_date) >= '".$date_from."' AND DATE(s.invoice_date) <= '".$date_to."') ";
    $return_condition .= "( DATE(r.return_date) >= '".$date_from."' AND DATE(r.return_date) <= '".$date_to."') ";

	$result_args = array(
		'orderby_field' => 'f.lot_id',
		'page' => $cpage ,
		'order_by' => 'DESC',
		'items_per_page' => $ppage ,
        'condition'     => $condition,
        'sale_condition' => $sale_condition,
		'return_condition' => $return_condition,
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
				<th rowspan="2" class="column-title">Parent Lot</th>
				<th rowspan="2" class="column-title">Product Name</th>
                <th rowspan="2" class="column-title">Sale From</th>
                <th rowspan="2" class="column-title">Sale Weight (Kg)</th>
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
                    $bill_from = ( isset($s_value->bill_type) && $s_value->bill_type == 'original' ) ? 'SRC' : 'Out Side Store';
                    $bill_from = ( $bill_type == '-' ) ? 'All' : $bill_from;
					$start_count++;
		?>
			<tr id="customer-data-<?php echo $s_value->sale_detail_id; ?>">
                <td><?php echo $start_count; ?></td>
                <td><?php echo $s_value->lot_number; ?></td>
				<td><?php echo $s_value->parent_lot_number; ?></td>
				<td><?php echo $s_value->product_name; ?></td>
                <td><?php echo $bill_from; ?></td>
                <td><?php echo bagKgSplitter($s_value->tot_weight, $s_value->parent_bag_weight, $s_value->unit_type); ?></td>
                <td><?php echo $s_value->tot_taxless; ?></td>
                <td><?php echo $s_value->igst; ?></td>
                <td><?php echo $s_value->cgst; ?></td>
                <td><?php echo $s_value->sgst; ?></td>
                <td><?php echo $s_value->tot_igst; ?></td>
                <td><?php echo $s_value->tot_cgst; ?></td>
                <td><?php echo $s_value->tot_sgst; ?></td>
                <td><?php echo $s_value->tot_amt; ?></td>
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

<script type="text/javascript">
    
jQuery(document).ready(function () {
    jQuery('#per_page').focus();
    
    jQuery("#per_page").live('keydown', function(e) { 
        var keyCode = e.keyCode || e.which; 
        if (event.shiftKey && event.keyCode == 9) { 
            e.preventDefault(); 
            jQuery('#lot_type').focus();
        } else if(event.keyCode == 9){
            e.preventDefault(); 
            jQuery('#lot_number').focus();
        } else {
         jQuery('#per_page').focus();
        }
    }); 
    jQuery("#lot_type").live('keydown', function(e) { 
        var keyCode = e.keyCode || e.which; 
        if (event.shiftKey && event.keyCode == 9) { 
            e.preventDefault(); 
            jQuery('#item_status').focus();
        } else if(event.keyCode == 9){
            e.preventDefault(); 
            jQuery('#per_page').focus();
        } else {
         jQuery('#lot_type').focus();
        }
    }); 
})    

</script>