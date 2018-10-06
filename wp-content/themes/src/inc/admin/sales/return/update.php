<?php
    $return_id = (isset($_GET['return_id'])) ? $_GET['return_id'] : 0;
    $return_data = (isset($_GET['return_id'])) ? get_return_data($_GET['return_id']) : false;

?>
    <div style="width: 100%;">
        <ul class="icons-labeled">
            <li>
                <a href="<?php echo menu_page_url( 'bill_return', 0 ).'&return_id='.$return_id.'&action=view'; ?>" ><span class="icon-block-color coins-c"></span>View Return</a>
            </li>
            <!-- <li>
                <a href="<?php //echo menu_page_url( 'bill_return', 0 ).'&return_id='.$bill_no.'&action=invoice'; ?>" ><span class="icon-block-color invoice-c"></span>Print Return</a>
            </li> -->
        </ul>
    </div>
    <div class="widget-top" style="">
        <h4>Update Return</h4>
        <div style="font-size: 21px;"><?php echo 'Return ID : GR'.$return_id; ?></div>
        <div style="font-size: 21px;"><?php echo 'Invoice ID : '.$return_data['return_data']->sale_id; ?></div>
    </div>


    <div class="widget-content module table-simple"  id="new_return" style="margin-top:40px;">

        <div style="margin-top:10px;margin-bottom:10px;">
            <div style="text-align:center;width: 320px;margin: 0 auto;">
                <span style="font-weight:bold;">Return Date:</span> <input type="text" name="return_date" class="return_date" value="<?php echo machine_to_man_date($return_data['return_data']->return_date); ?>" id="return_date">
            </div>
        </div>


        <input type="hidden" name="gst_from" value="<?php echo $gst_from = $return_data['return_data']->gst_from; ?>" class="gst_from">
        <input type="hidden" name="customer_id" value="<?php echo $return_data['return_data']->sale_id; ?>">
        <input type="hidden" name="sale_id" value="<?php echo $return_data['return_data']->sale_id; ?>">
        <input type="hidden" name="return_id" value="<?php echo $return_id; ?>">
        <table class="display return_table">
            <thead>
                <tr>
                    <th rowspan="2">S.No</th>
                    <th rowspan="2">Product Name</th>
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
                    <th rowspan="2">Action</th>
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
                <?php
                    if($return_data && is_array($return_data['return_detail']) && count($return_data['return_detail']) > 0) {
                        $row_count = 1;
                        foreach ($return_data['return_detail'] as $s_value) {
                            if($gst_from == 'cgst') {
                                $gst_percentage = ($s_value->cgst * 2);
                            } else if($gst_from == 'igst') {
                                $gst_percentage = $s_value->igst;
                            } else {
                                $gst_percentage = 0;
                            }
                ?>
                    <tr>
                        <td><?php echo $row_count; ?></td>
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
                                    <input type="text" value="<?php echo $s_value->return_weight; ?>" onkeypress="return isNumberKeyWithDot(event)"  class="return_weight" name="return_data[<?php echo $row_count; ?>][return_weight]">
                                    <input type="hidden" value="<?php echo $s_value->lot_id; ?>" name="return_data[<?php echo $row_count; ?>][return_lot]">
                                    <input type="hidden" name="return_data[<?php echo $row_count; ?>][sale_detail]" value="<?php echo $s_value->sale_detail_id; ?>">
                                     <input type="hidden" name="return_data[<?php echo $row_count; ?>][gst_percentage]" value="<?php echo $gst_percentage; ?>" class="gst_percentage">
                                    <input type="hidden" name="return_data[<?php echo $row_count; ?>][return_detail_id]" value="<?php echo $s_value->id ?>">
                                </div>
                                <div style="clear:both;" class="">
                                </div>
                            </div>
                        </td>
                         <td><?php echo $s_value->amt_per_kg; ?><input type="hidden" name="return_data[<?php echo $row_count; ?>][amt_per_kg]" class="amt_per_kg" value="<?php echo $s_value->amt_per_kg; ?>"></td>
                        <td>
                            <div class="taxless_amt_txt"><?php echo $s_value->taxless_amount; ?></div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][taxless_amt]" class="taxless_amt" value="<?php echo $s_value->taxless_amount; ?>">
                        </td>


                        <?php 
                            if( $gst_from =='cgst' ) {
                        ?>
                        <td>
                            <div class="cgst_percentage_txt"><?php echo $s_value->cgst.'%'; ?></div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][cgst_percentage]" class="cgst_percentage" value="<?php echo $s_value->cgst; ?>">
                        </td>
                        <td>
                            <div class="cgst_txt"><?php echo $s_value->cgst_value; ?></div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][cgst_amt]" class="cgst_amt" value="<?php echo $s_value->cgst_value; ?>">
                        </td>
                        <td>
                            <div class="cgst_percentage_txt"><?php echo $s_value->sgst.'%'; ?></div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][sgst_percentage]" class="cgst_percentage" value="<?php echo $s_value->sgst; ?>">
                        </td>
                        <td>
                            <div class="cgst_txt"><?php echo $s_value->sgst_value; ?></div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][sgst_amt]" class="cgst_amt" value="<?php echo $s_value->sgst_value; ?>">
                        </td>
                        <?php 
                            }
                            if( $gst_from =='igst' ) {
                        ?>
                        <td>
                            <div class="igst_percentage_txt"><?php echo $s_value->igst.'%'; ?></div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][igst_percentage]" class="igst_percentage" value="<?php echo $s_value->igst; ?>">
                        </td>
                        <td>
                            <div class="igst_txt"><?php echo $s_value->igst_value; ?></div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][igst_amt]" class="igst_amt" value="<?php echo $s_value->igst_value; ?>">
                        </td>
                        <?php
                            }
                        ?>
                        <td>
                            <div class="return_amt_txt"><?php echo $s_value->subtotal; ?></div>
                            <input type="hidden" name="return_data[<?php echo $row_count; ?>][return_amt]" class="return_amt" value="<?php echo $s_value->subtotal; ?>">
                        </td>
                        <td>
                            <span><a class="action-icons c-delete return_delete" href="#" title="delete" data-id="<?php echo $s_value->id; ?>" data-action="return_detail">Delete</a></span>
                        </td>
                    </tr>
                <?php
                            $row_count++;
                        }
                    }
                ?>
                <tr>
                    <td colspan="<?php if( $gst_from =='cgst' ) { echo '10'; } else if( $gst_from =='igst' ) { echo '8'; } else{ echo '6'; } ?>"><div class="text-right">Round Off</div></td>
                    <td>
                        <div class="return_round_off_txt"><?php echo $return_data['return_data']->round_off_value; ?></div>
                        <input type="hidden" name="return_round_off" value="<?php echo $return_data['return_data']->round_off_value; ?>" class="return_round_off">
                    </td>
                </tr>
                 <tr>
                    <td colspan="<?php if( $gst_from =='cgst' ) { echo '10'; } else if( $gst_from =='igst' ) { echo '8'; } else{ echo '6'; } ?>"><div class="text-right">Total Return</div></td>
                    <td>
                        <div class="total_return_txt"><?php echo $return_data['return_data']->total_amount; ?></div>
                        <input type="hidden" name="total_return" value="<?php echo $return_data['return_data']->total_amount; ?>" class="total_return">
                    </td>
                </tr>
                <tr> <?php $readonly = (checkBillBalance($sale_id)*-1) >= 0 ? '' : 'readonly'; ?>
                    <td colspan="<?php if( $gst_from =='cgst' ) { echo '10'; } else if( $gst_from =='igst' ) { echo '8'; } else{ echo '6'; } ?>"><div class="text-right">Return To  <input type="checkbox" name="return_to_check" id="return_to_check" class="return_to_check" <?php echo $readonly; ?>/></td></div>
                    <td> 
                        <input type="hidden" class="previous_pay_to_bal" value="<?php echo (checkBillBalance($sale_id)*-1) ?>">
                        <div class="return_to_bal_text"><?php echo (checkBillBalance($sale_id)*-1) ?></div>
                        <input type="hidden" name="return_to_bal" value="<?php echo (checkBillBalance($sale_id)*-1) ?>" class="return_to_bal">
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top:10px;">
            <input type="button" value="Update Return" class="submit-button return_item_update">
        </div>

    </div>

    <!-- SELECT rd.sale_id, rd.lot_id, sum(rd.return_weight) as return_weight FROM wp_return as r JOIN wp_return_detail as rd ON r.id = rd.return_id WHERE r.sale_id = 21 and r.active = 1 and rd.active= 1 group by rd.lot_id -->
    
    <!-- SELECT * FROM wp_sale_detail as sd WHERE sd.sale_id = 21 and sd.active = 1 -->
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('.return_weight').focus();
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
      jQuery('.return_weight').focus();
    }
  }
});




jQuery(document).on("keydown", ".return_weight", function(e) {
  if(event.keyCode == 9) {
    if(event.shiftKey && event.keyCode == 9) {  
       e.preventDefault(); 
       jQuery('.submit-button').focus();
      
    }
    else { 
      e.preventDefault(); 
      jQuery('.return_delete').focus();
    }
  }
});
</script>