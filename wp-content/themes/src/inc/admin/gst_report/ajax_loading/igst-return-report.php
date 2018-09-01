<?php
    $result_args = array(
        'orderby_field' => 'gst',
        'page' => $report->cpage,
        'order_by' => 'ASC',
        'items_per_page' => $report->ppage ,
        'condition' => '',
    );
    $stock_report = $report->return_report_pagination_gst($result_args);
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
                            <th>Total IGST(Rs)</th>
                            <th>Total COGS</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <tr>
                            <td><?php echo $stock_report['s_result']->sold_qty; ?></td>
                            <td><?php echo $stock_report['s_result']->tot_amt; ?></td>
                            <td><?php echo $stock_report['s_result']->total_cgst + $stock_report['s_result']->total_cgst; ?></td>
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
                            <th >S.No</th>
                            <th class="column-title">Goods Sold</th>
                            <th class="column-title">Taxless Amount</th>
                            <th style="border-bottom: none;" class="column-title" >IGST RATE</th>  
                            <th style="border-bottom: none;" class="column-title" >IGST AMOUNT</th>
                           
                            <th class="column-title">Cost Of <br/> Goods Sold(COGS)</th>                           
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
                                    <td class=""><?php echo $b_value->total_unit; ?></td>
                                    <td class=""><?php echo $b_value->amt; ?></td> 
                                    <td class=""><?php echo $b_value->gst; ?> </td>
                                    <td class=""><?php echo $b_value->cgst_value + $b_value->cgst_value; ?></td>
                                    
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


        
<script>
    jQuery(document).ready(function($) {
        $('#welcome-panel').after($('#custom-id').show());
    });
</script>

