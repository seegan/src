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
?>
    <div style="width: 100%;">
        <ul class="icons-labeled">
            <li>
                <a href="<?php echo menu_page_url( 'sales_others', 0 ); ?>" ><span class="icon-block-color coins-c"></span>View Billing List</a>
            </li>
            <?php
            if($sale_id) {
                ?>
                    <li>
                        <a href="<?php echo menu_page_url( 'new_bill', 0 ).'&bill_no='.$sale_id.'&action=invoice'; ?>" ><span class="icon-block-color invoice-c"></span>View Invoice</a>
                    </li>
                <?php
            }
            ?>

        </ul>
    </div>
    <div class="widget-top" style="height: 78px;">
        <h4>New Delivery</h4>
        <div>
            <form action="" method="GET">
                <input type="hidden" name="page" value="bill_delivery">
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

    <div class="widget-content module table-simple"  id="new_delivery" style="margin-top:40px;">

        <div style="margin-top:10px;margin-bottom:10px;">
            <div style="text-align:center;width: 640px;margin: 0 auto;">
                <span style="font-weight:bold;">Delivery Date:</span> <input type="text" name="delivery_date" class="delivery_date" value="<?php echo date("d-m-Y ", time()); ?>" id="delivery_date" style="width: 200px;">
                <span style="font-weight:bold;">Delivery Boy:</span> <input type="text" name="delivery_boy" class="delivery_boy" value="<?php echo $sale_detail->delivery_boy; ?>" id="delivery_date" style="width: 200px;">
            </div>
        </div>

        <input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>">
        <table class="display">
            <thead>
                <tr>
                    <th>Lot no</th>
                    <th>Product Name</th>
                    <th>Order Weight</th>
                    <th>Delivered</th>
                    <th>Returned</th>
                    <th>Delivery Pending</th>
                    <th style="width:280px;">Now</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($sales && is_array($sales) && count($sales) > 0) {
                        $row_count = 1;
                        foreach ($sales as $s_value) {
                            $bag_checked = ($s_value->sale_as == 'bag') ? 'checked' : '';
                            $kg_checked = ($s_value->sale_as == 'bag') ? '' : 'checked';
                            $bag_kg = ($s_value->sale_as == 'bag') ? 'bag' : 'kg';

                            $delivery_class = ($s_value->delivery_balance > 0 ) ? 'r_white' : 'r_green';
                            $delivery_disabled = ($s_value->delivery_balance > 0 ) ? '' : 'disabled';

                            $bag_weight = ($s_value->bag_weight) ? $s_value->bag_weight : 0.00;
                ?>
                    <tr class="<?php echo $delivery_class; ?>">
                        <td><?php echo $s_value->lot_id; ?></td>
                        <td><?php echo $s_value->lot_number; ?></td>
                        <td><?php echo bagKgSplitter($s_value->sale_weight, $bag_weight, $s_value->unit_type); ?></td>
                        <td><?php echo bagKgSplitter($s_value->tot_delivered, $bag_weight, $s_value->unit_type); ?></td>
                        <td><?php echo bagKgSplitter($s_value->tot_returned, $bag_weight, $s_value->unit_type); ?></td>
                        <td>
                            <?php echo bagKgSplitter($s_value->delivery_balance, $bag_weight, $s_value->unit_type); ?>
                                
                            </td>
                        <td>
                            <div>
                                <div style="float:left;">
                                    <div style="padding-top:6px;">
                                        <span class="">
                                            <span class="sale_as_name_kg"><input type="radio" class="sale_as" value="kg" <?php echo $kg_checked; ?> name="delivery_data[<?php echo $row_count; ?>][delivery_as]" <?php echo $delivery_disabled ?> > - Kg</span> | 
                                            <span class="sale_as_name_bag">Bag - <input type="radio" class="sale_as" value="bag" <?php echo $bag_checked; ?> name="delivery_data[<?php echo $row_count; ?>][delivery_as]" <?php echo $delivery_disabled ?> ></span>
                                        </span>
                                    </div>
                                </div>
                                <div style="float:left;width:100px;">
                                    <input type="hidden" name="delivery_balance" class="delivery_balance" value="<?php echo $s_value->delivery_balance ?>">
                                    <input type="text" value="0" class="user_enrty_weight" onkeypress="return isNumberKeyWithDot(event)" name="delivery_data[<?php echo $row_count; ?>][user_unit]" <?php echo $delivery_disabled ?> >
                                    <input type="hidden" class="bag_weight" value="<?php echo $s_value->bag_weight; ?>" name="delivery_data[<?php echo $row_count; ?>][bag_weight]">
                                    <span class="delivery_sale_as" style="font-weight:bold;">
                                        <?php echo ucfirst($bag_kg); ?>
                                    </span>
                                    <input type="hidden" value="" class="delivery_weight" name="delivery_data[<?php echo $row_count; ?>][delivery_weight]" <?php echo $delivery_disabled; ?>>
                                    <input type="hidden" value="<?php echo $s_value->lot_id; ?>" name="delivery_data[<?php echo $row_count; ?>][delivery_lot]">
                                    <input type="hidden" name="delivery_data[<?php echo $row_count; ?>][sale_detail]" value="<?php echo $s_value->id; ?>">
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                        </td>
                        <td><?php echo $s_value->sale_value; ?></td>
                    </tr>
                <?php
                            $row_count++;
                        }
                    }
                ?>
            </tbody>
        </table>

        <div style="margin-top:10px;">
            <input type="button" value="Update Delivery" class="submit-button delivery_item">
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