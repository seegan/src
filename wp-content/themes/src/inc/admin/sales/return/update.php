<?php
    $return_id = (isset($_GET['return_id'])) ? $_GET['return_id'] : 0;
    $return_data = (isset($_GET['return_id'])) ? get_return_data($_GET['return_id']) : false;

?>
    <div style="width: 100%;">
        <ul class="icons-labeled">
            <li>
                <a href="<?php echo menu_page_url( 'bill_return', 0 ).'&return_id='.$return_id.'&action=view'; ?>" ><span class="icon-block-color coins-c"></span>View Return</a>
            </li>
            <li>
                <a href="<?php echo menu_page_url( 'new_bill', 0 ).'&bill_no='.$bill_no.'&action=invoice'; ?>" ><span class="icon-block-color invoice-c"></span>Print Return</a>
            </li>
        </ul>
    </div>
    <div class="widget-top" style="height: 78px;">
        <h4>Update Return</h4>
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
                <input type="text" name="inv_no" value="<?php echo $invoice_id; ?>">
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>


    <div class="widget-content module table-simple"  id="new_return" style="margin-top:40px;">

        <div style="margin-top:10px;margin-bottom:10px;">
            <div style="text-align:center;width: 320px;margin: 0 auto;">
                <span style="font-weight:bold;">Return Date:</span> <input type="text" name="return_date" class="return_date" value="<?php echo machine_to_man_date($return_data['return_data']->return_date); ?>" id="return_date">
            </div>
        </div>


        <input type="hidden" name="sale_id" value="<?php echo $return_data['return_data']->sale_id; ?>">
        <input type="hidden" name="return_id" value="<?php echo $return_id; ?>">
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
                    if($return_data && is_array($return_data['return_detail']) && count($return_data['return_detail']) > 0) {
                        $row_count = 1;
                        foreach ($return_data['return_detail'] as $s_value) {
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
                                    <input type="text" value="<?php echo $s_value->return_weight; ?>" name="return_data[<?php echo $row_count; ?>][return_weight]">
                                    <input type="hidden" value="<?php echo $s_value->lot_id; ?>" name="return_data[<?php echo $row_count; ?>][return_lot]">
                                    <input type="hidden" name="return_data[<?php echo $row_count; ?>][sale_detail]" value="<?php echo $s_value->sale_detail_id; ?>">
                                    <input type="hidden" name="return_data[<?php echo $row_count; ?>][return_detail_id]" value="<?php echo $s_value->id ?>">
                                </div>
                                <div style="clear:both;" class="">
                                </div>
                            </div>
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
            </tbody>
        </table>

        <div style="margin-top:10px;">
            <input type="button" value="Update Return" class="submit-button return_item_update">
        </div>

    </div>

    <!-- SELECT rd.sale_id, rd.lot_id, sum(rd.return_weight) as return_weight FROM wp_return as r JOIN wp_return_detail as rd ON r.id = rd.return_id WHERE r.sale_id = 21 and r.active = 1 and rd.active= 1 group by rd.lot_id -->
    
    <!-- SELECT * FROM wp_sale_detail as sd WHERE sd.sale_id = 21 and sd.active = 1 -->
