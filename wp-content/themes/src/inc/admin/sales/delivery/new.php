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


    <div class="widget-content module table-simple"  id="new_delivery" style="margin-top:40px;">

        <div style="margin-top:10px;margin-bottom:10px;">
            <div style="text-align:center;width: 320px;margin: 0 auto;">
                <span style="font-weight:bold;">Delivery Date:</span> <input type="text" name="delivery_date" class="delivery_date" value="<?php echo date("d-m-Y ", time()); ?>" id="delivery_date">
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
                    <th style="width:200px;">Now</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($sales && is_array($sales) && count($sales) > 0) {
                        $row_count = 1;
                        foreach ($sales as $s_value) {
                            $delivery_class = ($s_value->delivery_balance > 0 ) ? 'r_white' : 'r_green';
                            $delivery_disabled = ($s_value->delivery_balance > 0 ) ? '' : 'disabled';
                ?>
                    <tr class="<?php echo $delivery_class; ?>">
                        <td><?php echo $s_value->lot_id; ?></td>
                        <td><?php echo $s_value->lot_number; ?></td>
                        <td><?php echo $s_value->sale_weight; ?></td>
                        <td><?php echo $s_value->tot_delivered; ?></td>
                        <td><?php echo $s_value->tot_returned; ?></td>
                        <td><?php echo $s_value->delivery_balance; ?></td>
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
                                    <input type="text" value="" name="delivery_data[<?php echo $row_count; ?>][delivery_weight]" <?php echo $delivery_disabled; ?>>
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