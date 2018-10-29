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
        $customer = getcustomerDetail($sale_detail->customer_id);
    }

    $gst_from = $sale_detail->gst_to;
    $customer_id = $sale_detail->customer_id;

?>
<style type="text/css">
input[type="checkbox"][readonly] {
  pointer-events: none;
}
.return_alert{
    position: absolute;
    width: 100%;
    margin-top: 10px; 
}
.return_alert_text{
    position: relative;
    font-size:20px;
    text-align: center;
    color: red;
    font-weight: bold;
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
                <select name="financial_year" class="financial_year">
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
                <input type="text" name="inv_no" class="inv_no" autocomplete="off" onkeypress="return isNumberKey(event)" value="<?php echo $invoice_id; ?>">
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

        <div class="info_bar">
            <div class="customer_info_bar">

            <?php
                if($customer) {
            ?>
                <h4>Customer Information</h4>
                <ul>
                    <li><span>Name : </span><?php echo $customer->name; ?> </li>
                    <li><span>Mobile : </span><?php echo $customer->mobile; ?></li>
                    <li><span>Billing Address : </span><?php echo $customer->Address; ?></li>
                </ul>
            <?php
                }
            ?>
            </div>
            <div class="bill_info_bar">
                <ul>
                    <li><span>Bill No : </span> <?php echo $sale_detail->invoice_id; ?></li>
                    <li><span>Bill Date : </span> <?php echo $sale_detail->invoice_date;  ?></li>
                </ul>
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
                    <th>Rate</th>
                    <th>Amt.</th>
                    <th>Rate</th>
                    <th>Amt.</th>
                    <?php 
                        }
                        if( $gst_from =='igst' ) {
                    ?>
                    <th>Rate</th>
                    <th>Amt.</th>
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
                            <?php 
                            echo bagKgSplitter($s_value->sale_weight, $bag_weight, $s_value->unit_type); ?>
                        </td>
                        <td>
                            <?php echo bagKgSplitter($s_value->tot_delivered, $bag_weight, $s_value->unit_type); ?>
                        </td>
                        <td>
                            <?php echo bagKgSplitter($s_value->tot_returned, $bag_weight, $s_value->unit_type); ?>
                        </td>
                        <td>
                            <input type="hidden" class="return_avail" value="<?php echo $s_value->return_avail; ?>">
                            <?php echo bagKgSplitter($s_value->return_avail, $bag_weight, $s_value->unit_type); ?>
                        </td>
                        <td>
                            <div>
                                <div style="float:left;">
                                    <div style="">
                                        <span class="">
                                             <input type="text" onkeypress="return isNumberKeyWithDot(event)" class="user_enrty_weight_bag" name="return_data[<?php echo $row_count; ?>][user_unit_bag]" placeholder="Bag" <?php echo $return_disabled; ?>/> <b>Bag</b>
                                            <!-- <span class="sale_as_name_kg"><input type="radio" class="sale_as" value="kg" <?php echo $kg_checked; ?> name="return_data[<?php echo $row_count; ?>][return_as]" <?php echo $return_disabled ?> > - Kg</span> | 
                                            <span class="sale_as_name_bag">Bag - <input type="radio" class="sale_as" value="bag" <?php echo $bag_checked; ?> name="return_data[<?php echo $row_count; ?>][return_as]" <?php echo $return_disabled ?> ></span> -->
                                        </span>
                                    </div>
                                </div>
                                <div style="float:left;">
                                    <input type="hidden" value="0" name="return_data[<?php echo $row_count; ?>][return_weight]" class="return_weight">
                                    <input type="hidden" value="<?php echo $s_value->lot_id; ?>" name="return_data[<?php echo $row_count; ?>][return_lot]">
                                    <input type="hidden" name="return_data[<?php echo $row_count; ?>][sale_detail]" value="<?php echo $s_value->id; ?>">
                                    <input type="hidden" name="return_data[<?php echo $row_count; ?>][gst_percentage]" value="<?php echo $gst_percentage ?>" class="gst_percentage">
                                    <input type="hidden" name="return_data[<?php echo $row_count; ?>][bill_type]" value="<?php echo $s_value->bill_type; ?>" class="bill_type"> 

                                    <input type="text"  onkeypress="return isNumberKeyWithDot(event)" class="user_enrty_weight_kg" name="return_data[<?php echo $row_count; ?>][user_unit_kg]" placeholder="Kg" <?php echo $return_disabled; ?>/> <b>Kg</b>
                                    
                                   


                                    <input type="hidden"  class="user_enrty_weight" name="return_data[<?php echo $row_count; ?>][user_unit]" value="0" >
                                    <input type="hidden" class="bag_weight" value="<?php echo $s_value->bag_weight; ?>" name="return_data[<?php echo $row_count; ?>][bag_weight]">
                                   
                                    <!-- <span class="delivery_sale_as" style="font-weight:bold;">
                                        <?php echo ucfirst($bag_kg); ?>
                                    </span> -->
                                </div>
                                <div style="clear:both;"></div>
                            </div>

                        </td>
                        <td>
                            <input type="text" style="width:100px;" onkeypress="return isNumberKeyWithDot(event)" name="return_data[<?php echo $row_count; ?>][amt_per_kg]" value="<?php echo $amt_per_kg; ?>" class="amt_per_kg" <?php echo $return_disabled ?> readonly>
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
                    <td colspan="<?php if( $gst_from =='cgst' ) { echo '13'; } else if($gst_from == 'igst') { echo '11'; } else { echo '9'; } ?>"><div class="text-right">Round Off</div></td>
                    <td>
                        <div class="return_round_off_txt">0.00</div>
                        <input type="hidden" name="return_round_off" value="0.00" class="return_round_off">
                    </td>
                </tr>
                <tr>
                    <td colspan="<?php if( $gst_from =='cgst' ) { echo '13'; } else if($gst_from == 'igst') { echo '11'; } else { echo '9'; } ?>"><div class="text-right">Total Return</div></td>
                    <td>
                        <div class="total_return_txt">0.00</div>
                        <input type="hidden" name="total_return" value="0.00" class="total_return">
                    </td>
                </tr>
                <tr> <?php $readonly = (checkBillBalance($sale_id)*-1) > 0 ? '' : 'readonly'; ?>
                    <td colspan="<?php if( $gst_from =='cgst' ) { echo '13'; } else if($gst_from == 'igst') { echo '11'; } else { echo '9'; } ?>"><div class="text-right">Return To  <input type="checkbox" name="return_to_check" id="return_to_check" class="return_to_check" <?php echo $readonly; ?>/></td></div>
                    <td>
                        <input type="hidden" class="previous_pay_to_bal" value="<?php echo (checkBillBalance($sale_id)*-1) ?>">
                        <div class="return_to_bal_text"><?php echo (checkBillBalance($sale_id)*-1) > 0 ? (checkBillBalance($sale_id)*-1) : 0;  ?></div>
                        <input type="hidden" name="return_to_bal" value="<?php echo (checkBillBalance($sale_id)*-1) ?>" class="return_to_bal">
                    </td>
                </tr>
            </tbody>
        </table>
        <?php $display  = 'style="display:none"';
         //$display = (checkBillBalance($sale_id)*-1) > 0 ? '' : 'style="display:block"'; ?>
        <div class="return_alert" <?php echo $display; ?>>
            <div class="return_alert_text">
                 Product purchase on Credit.Do not Pay back!!!
            </div>
        </div>
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
    if(event.keyCode == 9 && !event.shiftKey) {
        e.preventDefault(); 
        jQuery('.financial_year').focus();
    }
});


jQuery(document).on("keydown", ".financial_year", function(e) {
  if(event.keyCode == 9) {
    if(event.shiftKey && event.keyCode == 9) {  
        e.preventDefault(); 
        jQuery('.submit-button').focus();
    }
    else { 
        e.preventDefault(); 
        jQuery('.inv_no').focus();
    }
  }
});
</script>