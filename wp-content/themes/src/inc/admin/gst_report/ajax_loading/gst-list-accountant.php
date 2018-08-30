<?php
    $result_args = array(
        'orderby_field' => 'gst',
        'page' => $report->cpage,
        'order_by' => 'ASC',
        'items_per_page' => $report->ppage ,
        'condition' => '',
    );
    $stock_report = $report->stock_report_pagination_accountant($result_args);
    var_dump($stock_report);
?>
<style>
.pointer td{
    text-align: center;
}
.headings th {
    text-align: center;
}
</style>
        <div class="x_content" style="width:100%;">
            <div class="table-responsive" style="width:400px;margin: 0 auto;margin-bottom:20px;">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>Total Stock Sold Out</th>
                            <th>Total Taxless Amount</th>
                            <th>Total CGST(Rs)</th>
                            <th>Total SGST(Rs)</th>
                            <th>Total COGS</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <tr>
                            <td><?php echo $stock_report['s_result']->sold_qty; ?></td>
                            <td><?php echo $stock_report['s_result']->tot_amt; ?></td>
                            <td><?php echo $stock_report['s_result']->total_cgst; ?></td>
                            <td><?php echo $stock_report['s_result']->total_cgst; ?></td>
                            <td><?php echo $stock_report['s_result']->sub_tot; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th rowspan="2" >S.No</th>
                            <th rowspan="2" class="column-title">Number of  <br/>Goods Sold</th>
                            <th rowspan="2" class="column-title">Taxless Amount</th>
                            <th colspan="2" style="border-bottom: none;" class="column-title" >RATE</th>  
                            <th colspan="2" style="border-bottom: none;" class="column-title" >AMOUNT</th>
                           
                            <th rowspan="2" class="column-title">Cost Of <br/> Goods Sold(COGS)</th>                           
                        </tr>
                        <tr class="text_bold text_center">
                          <th style="border-top: none;text-align: center;" class="column-title" >CGST(%)</th>
                          <th style="border-top: none;text-align: center;" class="column-title" >SGST(%)</th>
                          <th style="border-top: none;text-align: center;" class="column-title" >CGST</th>
                          <th style="border-top: none;text-align: center;" class="column-title" >SGST</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                    <?php
                        if( isset($stock_report['result']) && $stock_report['result'] ) {
                            $i = $stock_report['start_count']+1;

                            foreach ($stock_report['result'] as $b_value) {
                                $bill_id = $b_value->id;
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo round($b_value->total_unit); ?></td>
                                    <td class=""><?php echo $b_value->amt; ?></td> 
                                    <td class=""><?php echo $b_value->gst; ?> </td>
                                    <td class=""><?php echo $b_value->gst; ?> </td>
                                    <td class=""><?php echo $b_value->cgst_value; ?></td>
                                    <td class=""><?php echo $b_value->cgst_value; ?></td>
                                    
                                    <td class=""><?php echo $b_value->total; ?></td>                               
                                </tr>
                    <?php
                                $i++;
                            }
                        }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>



        <div class="row">
            <div class="col-sm-7">
                <div class="paging_simple_numbers" id="datatable-fixed-header_paginate">
                    <?php
                    echo $stock_report['pagination'];
                    ?>
                </div>
            </div>
            <div class="col-sm-5">
                <?php  echo $stock_report['status_txt']; ?>
            </div>
        </div>


        
<script>
    jQuery(document).ready(function($) {
        $('#welcome-panel').after($('#custom-id').show());
    });
</script>




<!-- SELECT * from (
                    SELECT 
                    (sum(fin_tab.bal_cgst)) as cgst_value, 
                    (sum(fin_tab.bal_total)) as total, 
                    (sum(fin_tab.bal_unit)) as total_unit, 
                    (sum(fin_tab.bal_amt)) as amt,fin_tab.gst as gst 
                      
                    from (SELECT 
                            (case when return_table.return_cgst is null then sale_table.sale_cgst else sale_table.sale_cgst - return_table.return_cgst end ) as bal_cgst, 
                            (case when return_table.return_total is null then sale_table.sale_total else sale_table.sale_total - return_table.return_total end ) as bal_total,
                            (case when return_table.return_unit is null then sale_table.sale_unit else  sale_table.sale_unit - return_table.return_unit end) as bal_unit,
                            (case when return_table.return_amt is null then sale_table.sale_amt else sale_table.sale_amt - return_table.return_amt end ) as bal_amt,
                            sale_table.cgst as gst
                            FROM 
                            (
                            SELECT sale_details.cgst_percentage as cgst,
                                sum(sale_details.cgst_value) as sale_cgst, 
                                sum(sale_details.sgst_value) sale_sgst, 
                                sum(sale_details.sale_value) as sale_total, 
                                sum(sale_details.sale_weight) as sale_unit,
                                sum(sale_details.taxless_amt) as sale_amt FROM wp_sale as sale left join wp_sale_detail as sale_details on sale.`id`= sale_details.sale_id WHERE sale.active = 1 and sale_details.active = 1  group by sale_details.cgst_percentage
                            ) as sale_table 
                            left join
                            (
                             SELECT return_details.cgst as cgst,
                                sum(return_details.cgst_value) as return_cgst, 
                                sum(return_details.sgst_value) as return_sgst, 
                                sum(return_details.subtotal) as return_total ,
                                sum(return_details.return_weight) as return_unit,
                                sum(return_details.taxless_amount) as return_amt FROM wp_sale as sale left join wp_return_detail as return_details on sale.`id`= return_details.sale_id WHERE sale.active = 1 and return_details.active = 1 group by return_details.cgst
                            ) as return_table 
                            on sale_table.cgst = return_table.cgst ) as fin_tab GROUP by fin_tab.gst ) as report WHERE report.total_unit > 0 -->