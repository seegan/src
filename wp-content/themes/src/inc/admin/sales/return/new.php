<?php
    $invoice_id = '';
    $sale_id = 0;
    $financial_year = date('Y');
    $sales = false;

    if(isset($_GET['page']) && isset($_GET['financial_year']) && isset($_GET['inv_no'])  ) {
        $invoice_id = $_GET['inv_no'];
        $financial_year = $_GET['financial_year'];

        $sale_detail = getSaleDataByYearInvoice($financial_year, $invoice_id);
        $sale_id = ($sale_detail && isset($sale_detail->id)) ? $sale_detail->id : 0;
        $sales = getSalesList($sale_id);
    }

    $gst_from = $sale_detail->gst_to;
    $customer_id = $sale_detail->customer_id;

?>
<style type="text/css">
input[type="checkbox"][readonly] {
  pointer-events: none;
}
</style>
    <div style="width: 100%;">
        <ul class="icons-labeled">
            <li>
                <a href="<?php echo menu_page_url( 'sales_others', 0 ); ?>" ><span class="icon-block-color coins-c"></span>View Billing</a>
            </li>
            <li>
                <a href="<?php echo menu_page_url( 'new_bill', 0 ).'&bill_no='.$bill_no.'&action=invoice'; ?>" ><span class="icon-block-color invoice-c"></span>View Invoice</a>
            </li>
        </ul>
    </div>
    <div class="widget-top" style="height: 78px;">
        <h4>New Return</h4>
        <div>
            <form action="" method="GET">
                <input type="hidden" name="page" value="bill_return">
                <select name="financial_year">
                    <?php 
                        for ($i = 2010; $i < 2051; $i++) { 
                            if($financial_year == $i) {
                                echo "<option selected>".$i."</option>";
                            } else {
                                echo "<option >".$i."</option>";
                            }
                        }
                    ?>
                </select>
                <input type="text" name="inv_no" class="inv_no" value="<?php echo $invoice_id; ?>">
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>


    <div class="widget-content module table-simple"  id="new_return" style="margin-top:40px;">
        <div style="margin-top:10px;margin-bottom:10px;">
            <div style="text-align:center;width: 320px;margin: 0 auto;">
                <span style="font-weight:bold;">Return Date:</span> <input type="text" name="return_date" class="return_date" value="<?php echo date("d-m-Y ", time()); ?>" id="return_date">
            </div>
        </div>


        <input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>">
        <input type="hidden" name="gst_from" value="<?php echo $gst_from; ?>" class="gst_from">
        <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">

        <table class="display return_table">
            <thead>
                <tr>
                    <th rowspan="2">S.No</th>
                    <th rowspan="2">Product Name</th>
                    <th rowspan="2">Order Weight</th>
                    <th rowspan="2">Delivery Qty</th>
                    <th rowspan="2">Previous Return</th>
                    <th rowspan="2">Avail to Return</th>
                    <th rowspan="2">Return Qty</th>
                    <th rowspan="2">Sold Price (Per Kg)</th>
                    <th rowspan="2">Taxless Amt</th>
                    <?php 
                        if( $gst_from =='cgst' ) {
                            echo "<th colspan='2'>CGST</th>";
                            echo "<th colspan='2'>SGST</th>";
                        }
                    ?>
                    <?php 
                        if( $gst_from =='igst' ) {
                            echo "<th colspan='2'>IGST</th>";
                        }
                    ?>
                    <th rowspan="2">Sub total</th>
                </tr>
                <tr>
                    <?php 
                        if( $gst_from =='cgst' ) {
                    ?>
                    <th rowspan="2">Rate</th>
                    <th rowspan="2">Amt.</th>
                    <th rowspan="2">Rate</th>
                    <th rowspan="2">Amt.</th>
                    <?php 
                        }
                        if( $gst_from =='igst' ) {
                    ?>
                    <th rowspan="2">Rate</th>
                    <th rowspan="2">Amt.</th>
                    <?php
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php echo "<pre>";
                    if($sales && is_array($sales) && count($sales) > 0) {
                        $row_count = 1;
                        echo "<pre>";
                        foreach ($sales as $s_value) {

                            $bag_checked = ($s_value->sale_as == 'bag') ? 'checked' : '';
                            $kg_checked = ($s_value->sale_as == 'bag') ? '' : 'checked';
                            $bag_kg = ($s_value->sale_as == 'bag') ? 'bag' : 'kg';

                            $return_class = ($s_value->return_avail > 0 ) ? 'r_white' : 'r_red';
                            $return_disabled = ($s_value->return_avail <= 0 ) ? 'disabled' : '';

                            $amt_per_kg = ( $s_value->slab == 1 ) ? $s_value->unit_price : ($s_value->unit_price / $s_value->bag_weight );
                            if($gst_from == 'cgst') {
                                $gst_percentage = ($s_value->cgst_percentage * 2);
                            } else if($gst_from == 'igst') {
                                $gst_percentage = $s_value->igst_percentage;
                            } else {
                                $gst_percentage = 0;
                            }

                            $bag_weight = ($s_value->bag_weight) ? $s_value->bag_weight : 0.00;
                ?>
                    <tr class="<?php echo $return_class; ?>">
                        <td><?php echo $row_count; ?></td>
                        <td>
                            <?php echo $s_value->lot_number; ?>
                        </td>
                        <td>
                            <?php echo $s_value->sale_weight.'Kg ('.bagKgSplitter($s_value->sale_weight, $bag_weight).')'; ?>
                        </td>
                        <td>
                            <?php echo $s_value->tot_delivered.'Kg ('.bagKgSplitter($s_value->tot_delivered, $bag_weight).')'; ?>
                        </td>
                        <td>
                            <?php echo $s_value->tot_returned.'Kg ('.bagKgSplitter($s_value->tot_returned, $bag_weight).')'; ?>
                        </td>
                        <td>
                            <?php echo $s_value->return_avail.'Kg ('.bagKgSplitter($s_value->return_avail, $bag_weight).')'; ?>
                        </td>
                        <td>
                            <div>
                                <div style="float:left;">
                                    <div style="padding-top:6px;">
                                        <span class="">
                                            <span class="sale_as_name_kg"><input type="radio" class="sale_as" value="kg" <?php echo $kg_checked; ?> name="return_data[<?php echo $row_count; ?>][return_as]" <?php echo $return_disabled ?> > - Kg</span> | 
                                            <span class="sale_as_name_bag">Bag - <input type="radio" class="sale_as" value="bag" <?php echo $bag_checked; ?> name="return_data[<?php echo $row_count; ?>][return_as]" <?php echo $return_disabled ?> ></span>
                                        </span>
                                    </div>
                                </div>
                                <div style="float:left;width:100px;">
                                    <input type="hidden" value="0" name="return_data[<?php echo $row_count; ?>][return_weight]" class="return_weight">
                                    <input type="hidden" value="<?php echo $s_value->lot_id; ?>" name="return_data[<?php echo $row_count; ?>][return_lot]">
                                    <input type="hidden" name="return_data[<?php echo $row_count; ?>][sale_detail]" value="<?php echo $s_value->id; ?>">
                                    <input type="hidden" name="return_data[<?php echo $row_count; ?>][gst_percentage]" value="<?php echo $gst_percentage ?>" class="gst_percentage">
                                    <input type="hidden" name="return_data[<?php echo $row_count; ?>][bill_type]" value="<?php echo $s_value->bill_type; ?>" class="bill_type">


                                    <input type="text" value="0" class="user_enrty_weight" name="return_data[<?php echo $row_count; ?>][user_unit]" <?php echo $return_disabled; ?>>
                                    <input type="hidden" class="bag_weight" value="<?php echo $s_value->bag_weight; ?>" name="return_data[<?php echo $row_count; ?>][bag_weight]">
                                    <span class="delivery_sale_as" style="font-weight:bold;">
                                        <?php echo ucfirst($bag_kg); ?>
                                    </span>
                                </div>
                                <div style="clear:both;"></div>
                            </div>

                        </td>
                        <td>
                            <input type="text" style="width:100px;" name="return_data[<?php echo $row_count; ?>][amt_per_kg]" value="<?php echo $amt_per_kg; ?>" class="amt_per_kg" <?php echo $return_disabled ?>>
                        </td>
                        <td>
                            <div class="taxless_amt_txt">0.00</div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][taxless_amt]" class="taxless_amt" value="0.00">
                        </td>


                        <?php 
                            if( $gst_from =='cgst' ) {
                        ?>
                        <td>
                            <div class="cgst_percentage_txt"><?php echo sprintf("%.2f",$gst_percentage/2).'%'; ?></div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][cgst_percentage]" class="cgst_percentage" value="<?php echo $gst_percentage/2; ?>">
                        </td>
                        <td>
                            <div class="cgst_txt">0.00</div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][cgst_amt]" class="cgst_amt" value="0.00">
                        </td>
                        <td>
                            <div class="cgst_percentage_txt"><?php echo sprintf("%.2f",$gst_percentage/2).'%'; ?></div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][sgst_percentage]" class="cgst_percentage" value="<?php echo $gst_percentage/2; ?>">
                        </td>
                        <td>
                            <div class="cgst_txt">0.00</div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][sgst_amt]" class="cgst_amt" value="0.00">
                        </td>
                        <?php 
                            }
                            if( $gst_from =='igst' ) {
                        ?>
                        <td>
                            <div class="igst_percentage_txt"><?php echo sprintf("%.2f",$gst_percentage).'%'; ?></div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][igst_percentage]" class="igst_percentage" value="<?php echo $gst_percentage; ?>">
                        </td>
                        <td>
                            <div class="igst_txt">0.00</div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][igst_amt]" class="igst_amt" value="0.00">
                        </td>
                        <?php
                            }
                        ?>
                        <td>
                            <div class="return_amt_txt">0.00</div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][return_amt]" class="return_amt" value="0.00">
                        </td>
                    </tr>
                <?php
                            $row_count++;
                        }
                    }
                ?>
                <tr>
                    <td colspan="13"><div class="text-right">Total Return</div></td>
                    <td>
                        <div class="total_return_txt">0.00</div>
                        <input type="hidden" name="total_return" value="0.00" class="total_return">
                    </td>
                </tr>
                <tr>
                    <td colspan="13"><div class="text-right">Return To  <input type="checkbox" name="return_to_check" id="return_to_check" class="return_to_check"/></td></div>
                    <td>
                        <input type="hidden" class="previous_pay_to_bal" value="<?php echo (checkBillBalance($sale_id)*-1) ?>">
                        <div class="return_to_bal_text"><?php echo (checkBillBalance($sale_id)*-1) ?></div>
                        <input type="hidden" name="return_to_bal" value="<?php echo (checkBillBalance($sale_id)*-1) ?>" class="return_to_bal">
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top:10px;">
            <input type="button" value="Update Return" class="submit-button return_item">
        </div>
    </div>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('.inv_no').focus();
  });    


//From Stock Submit button (tab and shif + tab action)
jQuery(document).on("keydown", ".submit-button", function(e) {
  if(event.keyCode == 9) {
    if(event.shiftKey && event.keyCode == 9) { 
       e.preventDefault(); 
       jQuery('.return_to_check').focus();
    }
    else { 
      e.preventDefault(); 
      jQuery('.inv_no').focus();
    }
  }
});




jQuery(document).on("keydown", ".inv_no", function(e) {
  if(event.keyCode == 9) {
    if(event.shiftKey && event.keyCode == 9) {  
       e.preventDefault(); 
      jQuery('.submit-button').focus();
    }
    else { 
      e.preventDefault(); 
      jQuery('input[type="submit"]').focus();
    }
  }
});
</script>