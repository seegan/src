<?php
    $delivery_id = (isset($_GET['delivery_id'])) ? $_GET['delivery_id'] : 0;
    $delivery_data = (isset($_GET['delivery_id'])) ? get_delivery_data($_GET['delivery_id']) : false;
?>
    <div style="width: 100%;">
        <ul class="icons-labeled">
            <li>
                <a href="<?php echo menu_page_url( 'bill_delivery', 0 ).'&delivery_id='.$delivery_id.'&action=view'; ?>" ><span class="icon-block-color coins-c"></span>View Delivery</a>
            </li>
            <li>
                <a href="<?php echo menu_page_url( 'new_bill', 0 ).'&bill_no='.$bill_no.'&action=invoice'; ?>" ><span class="icon-block-color invoice-c"></span>Print Delivery</a>
            </li>
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
            <div style="text-align:center;width: 320px;margin: 0 auto;">
                <span style="font-weight:bold;">Delivery Date:</span> <input type="text" name="delivery_date" class="delivery_date" value="<?php echo machine_to_man_date($delivery_data['delivery_data']->delivery_date); ?>" id="delivery_date">
            </div>
        </div>


        <input type="hidden" name="sale_id" value="<?php echo $delivery_data['delivery_data']->sale_id; ?>">
        <input type="hidden" name="delivery_id" value="<?php echo $delivery_id; ?>">
        <table class="display">
            <thead>
                <tr>
                    <th>Lot no</th>
                    <th style="width:200px;">Delivered</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($delivery_data && is_array($delivery_data['delivery_detail']) && count($delivery_data['delivery_detail']) > 0) {
                        $row_count = 1;
                        foreach ($delivery_data['delivery_detail'] as $s_value) {
                ?>
                    <tr>
                        <td><?php echo $s_value->lot_number; ?></td>
                        <td>
                            <div>
                                <div style="width: 30px;height: 30px;float:left;">
                                    <?php 
                                        if($s_value->slab == 1) {
                                            echo'<img style="width:100%;" src="'.get_template_directory_uri().'/inc/img/weight.png">';
                                        } else {
                                            echo'<img style="width:100%;" src="'.get_template_directory_uri().'/inc/img/bag.png">';
                                        }
                                    ?>
                                </div>
                                <div style="float:left;width:150px;">
                                    <input type="text" value="<?php echo $s_value->delivery_weight; ?>" onkeypress="return isNumberKeyWithDot(event)" name="delivery_data[<?php echo $row_count; ?>][delivery_weight]">
                                    <input type="hidden" value="<?php echo $s_value->lot_id; ?>" name="delivery_data[<?php echo $row_count; ?>][delivery_lot]">
                                    <input type="hidden" name="delivery_data[<?php echo $row_count; ?>][sale_detail]" value="<?php echo $s_value->sale_detail_id; ?>">
                                    <input type="hidden" name="delivery_data[<?php echo $row_count; ?>][delivery_detail_id]" value="<?php echo $s_value->id ?>">
                                </div>
                                <div style="clear:both;" class="">
                                </div>
                            </div>
                        </td>
                        <td>
                        	<span><a class="action-icons c-delete delivery_delete" href="#" title="delete" data-id="<?php echo $s_value->id; ?>" data-action="delivery_detail">Delete</a></span>
                        </td>
                    </tr>
                <?php
                            $row_count++;
                        }
                    }
                ?>
            </tbody>
        </table>

        <div style="margin-top:10px;">
            <input type="button" value="Update Delivery" class="submit-button delivery_item_update">
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