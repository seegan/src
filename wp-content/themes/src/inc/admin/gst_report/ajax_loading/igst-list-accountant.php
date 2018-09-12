<?php
    if(isset($_POST['action']) && $_POST['action'] == 'stock_sale_filter_list') {
        $cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
        $ppage = $_POST['per_page'];
        $slab = isset($_GST['slab']) ? $_GET['slab'] : '-';

        $date_from = ( isset( $_POST['date_from'] ) && $_POST['date_from'] != '' )  ? $_POST['date_from'] : date('Y-m-d');
        $date_to = ( isset( $_POST['date_to'] ) && $_POST['date_to'] != '' )  ? $_POST['date_to'] : date('Y-m-d');
    } else {
        $cpage = 1;
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $slab = isset($_POST['slab']) ? $_POST['slab'] : '-';

        $date_from = ( isset( $_GET['date_from'] ) && $_GET['date_from'] != ''  ) ? $_GET['date_from']  : date('Y-m-d');
        $date_to = ( isset( $_GET['date_to'] ) && $_GET['date_to'] != '' ) ? $_GET['date_to']  : date('Y-m-d');

    }
    $con = false;
    $condition = '';

    if($slab != '-') {
        $condition .= " AND f.report_type  = '".$item_status."' ";
        $con = true;
    }
    $sale_condition = "( DATE(s.invoice_date) >= '".$date_from."' AND DATE(s.invoice_date) <= '".$date_to."') AND s.gst_to = 'igst' ";
    $return_condition = "( DATE(r.return_date) >= '".$date_from."' AND DATE(r.return_date) <= '".$date_to."') AND s.gst_to = 'igst' ";

    $result_args = array(
        'orderby_field' => 'f.igst',
        'page' => $cpage ,
        'order_by' => 'ASC',
        'items_per_page' => $ppage ,
        'condition'     => $condition,
        'sale_condition' => $sale_condition,
        'return_condition' => $return_condition,
    );
    $sales = $report->stock_report_pagination_gst($result_args);
?>
<style>
.pointer td{
    text-align: center;
}
.headings th {
    text-align: center;
}
</style>


        <?php if(isset($sales['s_result']->weight_s)) {?>
            <div class="x_content" style="width:100%;">
                <div class="table-responsive" style="width:400px;margin: 0 auto;margin-bottom:20px;">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th>Total Stock Sold Out</th>
                                <th>Total Taxless Amount</th>
                                <th>Total IGST(Rs)</th>
                                <th>Total COGS</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            <tr>
                                <td><?php echo $sales['s_result']->weight_s.' Kg'; ?></td>
                                <td><?php echo $sales['s_result']->taxless_s; ?></td>
                                <td><?php echo $sales['s_result']->igst_s; ?></td>
                                <td><?php echo $sales['s_result']->sale_s; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>


        <div class="x_content">
            <table class="display">
                <thead>
                    <tr>
                        <th rowspan="2" class="column-title">Sl. No</th>
                        <th rowspan="2" class="column-title">Sale Weight (Kg)</th>
                        <th rowspan="2" class="column-title">Taxless Amount</th>
                        <th style="border-bottom: none;" class="column-title" >RATE</th>  
                        <th style="border-bottom: none;" class="column-title" >AMOUNT</th>
                        <th rowspan="2" class="column-title"> Sale Value (Kg)</th>
                    </tr>
                    <tr class="text_bold text_center">
                      <th style="border-top: none;text-align: center;" class="column-title" >IGST(%)</th>
                      <th style="border-top: none;text-align: center;" class="column-title" >IGST</th>
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
                        <td><?php echo $s_value->tot_weight.' Kg'; ?></td>
                        <td><?php echo $s_value->tot_taxless; ?></td>
                        <td style="font-weight: bold;color:#1426ff;"><?php echo $s_value->igst; ?></td>
                        <td><?php echo $s_value->tot_igst; ?></td>
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


<script>
    jQuery(document).ready(function($) {
        $('#welcome-panel').after($('#custom-id').show());
    });
</script>




