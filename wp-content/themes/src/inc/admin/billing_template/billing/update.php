<?php
    $bill_no = isset($_GET['bill_no']) ? $_GET['bill_no'] : $_GET['inv_id'];
    $bill_data = getBillDetail($bill_no);
    $bill_return_data = getBillReturnDetail($bill_no);

    $rice_center_checked = '';
    $rice_mandy_checked = '';
    $counter_checked = '';
    if($bill_data['bill_data']->order_shop == 'rice_center') {
        $rice_center_checked = 'checked';
    } else if($bill_data['bill_data']->order_shop == 'rice_mandy') {
        $rice_mandy_checked = 'checked';
    }
    else {
        $counter_checked = 'checked';
    }

    $delivery_yes_checked = '';
    $delivery_no_checked = '';
    if($bill_data['bill_data']->delivery_avail == 1) {
        $delivery_yes_checked = 'checked';
    } else  {
        $delivery_no_checked = 'checked';
    }

    $customer_wholesale_checked = '';
    $customer_retail_checked = '';
    if($bill_data['bill_data']->customer_type == 'wholesale') {
        $customer_wholesale_checked = 'checked';
    } else {
        $customer_retail_checked = 'checked';
    }

    $cgst_checked = '';
    $igst_checked = '';
    $nogst_checked = '';
    if($bill_data['bill_data']->gst_to == 'cgst') {
        $cgst_checked = 'checked';
    }
    if($bill_data['bill_data']->gst_to == 'igst') {
        $igst_checked = 'checked';
    }
    if($bill_data['bill_data']->gst_to == 'no_gst') {
        $nogst_checked = 'checked';
    }


    $by_customer = 'display:none;';
    $by_counter = 'display:none;';
    $bill_by_customer = '';
    $bill_by_counter = '';
    if($bill_data['bill_data']->bill_from_to == 'customer') {
        $by_customer = 'display:block;';
        $bill_by_customer = 'checked';
    } else {
        $by_counter = 'display:block;';
        $bill_by_counter = 'checked';
    }
?>


<div class="form-grid">
    <form method="post" name="new_billing" id="new_billing" class="leftLabel" onsubmit="return false;">
        <ul>
            <li>
                <label class="fldTitle">Billing Date
                <abbr class="require" title="Required Field">*</abbr>
                </label>
                <div class="fieldwrap">
                    <span class="left">
                        <input type="text" name="billing_date" class="billing_date" value="<?php echo date("Y-m-d", strtotime($bill_data['bill_data']->invoice_date)); ?>" id="billing_date">
                    </span>
                    <span class="left">
                        <?php echo "<pre>"; var_dump(checkBillBalance($bill_data['bill_data']->id)); echo "</pre>"; ?>
                    <label class="fldTitle">Bill No</label>
                    <input type="hidden" name="billing_no" id="billing_no" autocomplete="off" value="<?php echo $bill_data['bill_data']->id; ?>">
                    <input type="text" disabled="" id="invoice_id" value="<?php echo $bill_data['bill_data']->invoice_id; ?>">
                    </span>
                </div>
            </li>
            <li>
                <legend class="choiceFld">Select the Shop<abbr title="Required Field" class="require">*</abbr></legend>
                <div class="fieldwrap input-uniform">
                    <span class="left">
                        <span>
                            <input type="radio" name="shop_name" value="rice_center" <?php echo $rice_center_checked; ?>>
                            <label class="choice">Saravana Rice Centre</label>
                        </span>
                        &nbsp;&nbsp;
                        <span>
                            <input type="radio" name="shop_name" value="rice_mandy" <?php echo $rice_mandy_checked; ?>>
                            <label class="choice">Saravana Rice Mandy</label>
                        </span>
                         <span>
                            <input type="radio" name="shop_name" value="counter" <?php echo $counter_checked; ?>>
                            <label class="choice">Counter</label>
                        </span>                    
                    </span>
                    <span class="left">
                        <legend class="choiceFld">GST Bill To</legend>
                        <div class="fieldwrap input-uniform">
                            <span>
                                <input type="radio" name="gst_type" value="cgst" class="gst_type" <?php echo $cgst_checked ?>><label class="choice">Tamilnadu</label>
                            </span>
                            &nbsp;&nbsp;                                   
                             <span>
                                <input type="radio" name="gst_type" value="igst" class="gst_type" <?php echo $igst_checked ?>><label class="choice">Other</label>
                            </span>
                             <span>
                                <input type="radio" name="gst_type" value="no_gst" class="gst_type" <?php echo $nogst_checked ?>><label class="choice">No GST</label>
                            </span>
                        </div>
                    </span>
                </div>
            </li>
            <li>
                <legend class="choiceFld">Home Delivery</legend>
                <div class="fieldwrap input-uniform">
                    <span>
                        <input type="radio" name="home_delivery" value="no" <?php echo $delivery_no_checked; ?> ><label class="choice">No</label>
                    </span>
                    &nbsp;&nbsp;                                   
                     <span>
                        <input type="radio" name="home_delivery" value="yes" <?php echo $delivery_yes_checked; ?> ><label class="choice">Yes</label>
                    </span>
                </div>
            </li>
            <li>
                <legend class="choiceFld">Bill By Name</legend>
                <div class="fieldwrap input-uniform">
                    <span>
                        <input type="radio" name="bill_by_name" value="no" <?php echo $bill_by_counter; ?> class="bill_by"><label class="choice">Counter</label>
                    </span>
                    &nbsp;&nbsp;
                     <span>
                        <input type="radio" name="bill_by_name" value="yes" <?php echo $bill_by_customer; ?> class="bill_by"><label class="choice">Customer Name</label>
                    </span>
                </div>
            </li>
            <li>
                <label id="customer" for="customer" class="fldTitle">Select the Customer
                    <abbr class="require" title="Required Field">*</abbr>
                </label>
                <div class="fieldwrap by-customer" style="<?php echo $by_customer; ?>">
                    <span class="left">
                        <select id="billing_customer" name="billing_customer" data-dvalue="<?php echo $bill_data['customer_data']->id; ?>" data-dtext="<?php echo $bill_data['customer_data']->name; ?>">
                            <option selected value="<?php echo $bill_data['customer_data']->id; ?>"><?php echo $bill_data['customer_data']->name; ?></option>
                        </select>
                    </span>
                    <span class="left append_cus_last_bill">
                    </span>
                </div>
                <div class="fieldwrap by-counter" style="<?php echo $by_counter ?>">
                    <span class="left">
                        <div class="align">
                            <div class="counter-cash">
                                Counter Cash
                            </div>
                        </div>           
                    </span>              
                </div> 
            </li>
            <li>
                <label id="customer_type" for="customer_type" class="fldTitle">Set the Customer Type</label>
                <div class="fieldwrap input-uniform">
                    <span class="left">
                        <span>
                            <input type="radio" name="customer_type" value="retail" <?php echo $customer_retail_checked ?>><label class="choice">Retail</label>
                        </span>
                        &nbsp;&nbsp;
                        <span>
                            <input type="radio" name="customer_type" value="wholesale" <?php echo $customer_wholesale_checked ?>><label class="choice">Wholesale</label>
                        </span>
                    </span>
                    <span class="left">
                        <ul class="icons-labeled ck_stk">
                            <li>
                                <a id="ck_stk_available"><span class="icon-block-black magnifying-glass-b"></span>Check Stock Availability</a>
                            </li>
                        </ul>
                        <div class="stock_ck_avail_box active-n">
                            <img src="<?php echo get_template_directory_uri(); ?>/inc/images/top_arr.png" class="top_arr_avail">
                            <div style="padding: 15px;">
                                <h2 style="margin-top:5px;">Check Stock Availability</h2>
                                <a href="#" style="float: right; margin-top: -40px;" id="close_check_availa_box"><img src="<?php echo get_template_directory_uri(); ?>/inc/images/x.png"></a>
                                <div style="width: 100%; border-bottom: 1px solid #ccc; padding: 5px 0px 15px 0px;" class="lot_search">
                                    <b>Filter :</b>&nbsp;
                                    <select name="search_lotn" id="search_lotn">
                                        <option value="-">Lot Name</option>
                                    </select>&nbsp;&nbsp;
                                    <select name="search_brandn" id="search_brandn">
                                        <option value="-">Brand Name</option>
                                    </select>&nbsp;&nbsp;
                                    <select name="search_stockn" id="search_stockn">
                                        <option value="-">Stock Name</option>
                                    </select>
                                    <!-- <input type="text" name="search_lot_rate" id="search_lot_rate" autocomplete="off" placeholder="Enter Rate"> -->&nbsp;&nbsp;
                                    <input name="search_avail_stock" type="button" value="Search" class="submit-button search_avail_stock">
                                    <img alt="Loader" src="<?php echo get_template_directory_uri(); ?>/inc/images/ajax-loader.gif" id="search_loader" style="display: none;">
                                </div>
                            </div>

                            <div class="load_stock_available" style="overflow-y: scroll; padding: 10px; height: 250px;">
                                <div class="module table-simple">
                                    <table class="display">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Lot Name</th>
                                                <th>Brand </th>
                                                <th>Stock Name</th>
                                                <th>Stock Balance (Kg)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="stock_search_filter">
                                            <tr>
                                                <td colspan="5">Search Details Search</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </span>

                </div>
            </li>

            <li>            
                <h1>
                    Ordered Item List
                </h1>
                <div class="retail-repeater group_retail">
                    <div data-repeater-list="group_retail" class="div-table">
                        <div class="div-table-row">
                            <div class="div-table-head" style="width: 75px;">S.No</div>
                            <div class="div-table-head" style="width: 160px;">Lot Number</div>
                            <div class="div-table-head" style="width: 50px;">Sale Option</div>
                            <div class="div-table-head" style="width: 240px;">Weight</div>
                            <div class="div-table-head" style="width: 150px;">Product Name</div>
                            <div class="div-table-head" style="width: 90px;">Unit Price (MRP)</div>
                            <div class="div-table-head" style="width: 100px;">Discounted price</div>
                            <div class="div-table-head" style="width: 100px;">Margin price</div>
                            <div class="div-table-head nogst_exclude" style="width: 70px;">Amount (Tax Less)</div>
                            <div class="div-table-head cgst_display">CGST</div>
                            <div class="div-table-head cgst_display" style="width: 50px;">CGST Value</div>
                            <div class="div-table-head cgst_display">SGST</div>
                            <div class="div-table-head cgst_display" style="width: 50px;">SGST Value</div>
                            <div class="div-table-head igst_display no_display">IGST</div>
                            <div class="div-table-head igst_display no_display" style="width: 50px;">IGST Value</div>
                            <div class="div-table-head total-price">Total</div>
                            <div class="div-table-head option-delete"></div>
                        </div>



                    <?php
                        if( isset($bill_data['bill_detail_data']) && $bill_data['bill_detail_data'] ) {
                            $i = 0;
                            foreach ($bill_data['bill_detail_data'] as $b_value) {
                                $i++;

                                $bill_type = $b_value->bill_type;
                                $bill_from = $b_value->bill_from;

                                $bill_type_original_active = '';
                                $bill_type_duplicate_active = '';

                                $bill_type_out_stock_active = '';
                                $bill_type_health_store_active = '';

                                $bill_type_original_checked = '';
                                $bill_type_duplicate_checked = '';

                                if($bill_type == 'original') {
                                    $bill_type_original_active = 'active';
                                    $bill_type_original_checked = 'checked';
                                } else {

                                    if($bill_from == 'health_store') {
                                        $bill_type_health_store_active = 'active';
                                    }
                                    if($bill_from == 'out_stock') {
                                        $bill_type_out_stock_active = 'active';
                                    }

                                    $bill_type_duplicate_active = 'active';
                                    $bill_type_duplicate_checked = 'checked';
                                }


                                $retail_sale_type_active  = '';
                                $wholesale_sale_type_active  = '';
                                $retail_sale_type_checked  = '';
                                $wholesale_sale_type_checked  = '';
                                $sale_type = $b_value->sale_type;
                                if($b_value->sale_type == 'wholesale') {
                                    $wholesale_sale_type_active  = 'active';
                                    $wholesale_sale_type_checked  = 'checked';
                                } else {
                                    $retail_sale_type_active  = 'active';
                                    $retail_sale_type_checked  = 'checked';
                                }


                                $slab_system = $b_value->slab_system;
                                $slab_yes_display = 'none';
                                $slab_no_display = 'none';
                                if($slab_system == 1) {
                                    $slab_yes_display = 'block';
                                } else {
                                    $slab_no_display = 'block';
                                }
                    ?>

                        <div data-repeater-item class="repeterin div-table-row <?php echo $bill_type; ?>" lot-id="<?php echo $b_value->lot_id; ?>" lot-number="<?php echo $b_value->lot_number; ?>" lot-bagweight="<?php echo $b_value->weight; ?>" lot-bagcons="<?php echo $b_value->bag_weight; ?>" lot-slabsys="<?php echo $b_value->slab_system; ?>" lot-type="<?php echo $b_value->lot_type; ?>" lot-brand="<?php echo $b_value->brand_name; ?>" lot-product="<?php echo $b_value->product_name; ?>" lot-parent="<?php echo $b_value->par_id; ?>" stock-avail="<?php echo $b_value->stock_bal; ?>" lotr-tot-weight="<?php echo $b_value->sale_weight; ?>" lotr-unit-price="<?php echo $b_value->unit_price; ?>" lotr-sale-price="<?php echo $b_value->sale_value; ?>" hsn-code="<?php echo $b_value->hsn_code; ?>" gst-percentage="<?php echo $b_value->igst_percentage; ?>">

                                <div class="div-table-col sale-rowno">

                                    <div class="type-container">
                                        <div class="type-bill-slider" style="position:absolute;">
                                            <div id="bill_round" data-stype="original" data-sstype="original" class="bill-slide-in <?php echo $bill_type_original_active; ?>"></div>
                                            <div id="bill_square" data-stype="duplicate" data-sstype="out_stock" class="bill-slide-in <?php echo $bill_type_out_stock_active; ?>"></div>
                                            <input type="radio" class="type_bill" name="type_bill" value="original" <?php echo $bill_type_original_checked; ?>>
                                            <input type="radio" class="type_bill" name="type_bill" value="duplicate" <?php echo $bill_type_duplicate_checked; ?>>


                                            <input type="hidden" name="type_bill_h" class="type_bill_h" value="<?php echo $bill_type ?>">
                                            <input type="hidden" name="type_bill_s" class="type_bill_s" value="<?php echo $bill_from ?>">
                                        </div>
                                    </div>

                                    <div class="rowno"><?php echo $i; ?></div>
                                </div>
                                <div class="div-table-col sale-lot-no">
                                    <input type="hidden" name="lot_parent" class="input_lot_parent" value="<?php echo $b_value->lot_parent_id; ?>">
                                    <input type="hidden" name="lot_slab" class="input_lot_slab" value="<?php echo $b_value->slab_system; ?>">
                                    <input type="hidden"  name="lot_number2" id="lot_number2" value="<?php echo $b_value->lot_id; ?>">
                                    <input type="hidden" name="bill_detail_id" id="bill_detail_id" value="<?php echo $b_value->sale_detail_id; ?>">
                                    <select  class="lot_id" name="lot_number" data-dvalue="<?php echo $b_value->lot_id; ?>" data-dtext="<?php echo $b_value->lot_number; ?>">
                                    </select>
                                </div>
                                <div class="div-table-col sale-sale-option">

                                    <div style="position:relative;">
                                      <div class="type-slider" style="position:absolute;">
                                        <div class="slide-in <?php echo $retail_sale_type_active; ?>" data-stype="retail">R</div>
                                        <div class="slide-in <?php echo $wholesale_sale_type_active; ?>" data-stype="wholesale">W</div>
                                        <input type="radio" class="sale_type" name="sale_type" value="retail" <?php echo $retail_sale_type_checked; ?>>
                                        <input type="radio" class="sale_type" name="sale_type" value="wholesale" <?php echo $wholesale_sale_type_checked; ?>>

                                        <input type="hidden" class="sale_type_h" name="sale_type_h" value="<?php echo $sale_type; ?>">
                                        
                                      </div>
                                    </div>

                                </div>
                                <div class="div-table-col sale-weight">

                                  <div class="weight-original-block">
                                    <div class="weight_cal_section">
                                        <input type="hidden" name="bagWeightInKg" class="bagWeightInKg" value="<?php echo $b_value->bag_weight; ?>" autocomplete="off" placeholder=""> 
                                        <div class="slab_system_no" style="display:<?php echo $slab_no_display ?>;">
                                            <input type="text" name="weight" class="weight" autocomplete="off" placeholder="" value="<?php echo $b_value->weight; ?>" readonly style="display: none;">
                                            <input type="text" name="unit_count" class="unit_count" autocomplete="off" placeholder="Count" style="width: 55px;" value="<?php echo ($b_value->sale_as == 'kg') ? $b_value->sale_weight : $b_value->bag_count; ?>">
                                            <input type="text" name="slab_no_total" class="total" autocomplete="off" placeholder="Weight" value="<?php echo $b_value->sale_weight; ?>" readonly style="display: none;">
                                        </div>
                                      <div class="slab_system_yes" style="display:<?php echo $slab_yes_display ?>;">
                                        <input type="text" name="slab_yes_total" class="total" autocomplete="off" placeholder="Weight" value="<?php echo ($b_value->sale_as == 'kg') ? $b_value->sale_weight : $b_value->bag_count; ?>" style="width: 55px;">
                                      </div>

                                    </div>
                                    <div class="weight_cal_tooltip">
                                      <div class="tooltip tootip-black" data-stockalert="1">
                                        <span class="tooltiptext">
                                            Slab System : <span class="slab_sys_txt">--</span>
                                            <hr class="tooltip-hr">
                                            Stock Avail : <span class="stock_weight_txt">--</span> kg
                                        </span>
                                      </div>
                                    </div>
                                    <div>
                                        <span class="">
                                            <span class="sale_as_name_kg">Kg  : <input type="radio" name="sale_as" class="sale_as" value="kg" <?php if($b_value->sale_as == 'kg') { echo 'checked'; } ?>></span>
                                            <span class="sale_as_name_bag">Bag :<input type="radio" name="sale_as" class="sale_as" value="bag" <?php if($b_value->sale_as == 'bag') { echo 'checked'; } ?> ></span>
                                        </span>
                                    </div>
                                    <div style="clear:both;"></div>
                                  </div>


                                  <div class="weight-duplicate-block">
                                    <div class="weight_cal_section">
                                      <div class="" style="display:block;">
                                        <input type="text" name="lot_duplicate_total" class="total duplicate_total" autocomplete="off" placeholder="Weight" value="<?php echo $b_value->sale_weight; ?>" style="width: 55px;">
                                      </div>
                                    </div>
                                    <div style="clear:both;"></div>
                                  </div>


                                </div>

                                <div class="div-table-col sale-brand" style="position:relative;">
                                    <div class="product_name_data" style="display: inline-block;"><?php echo $b_value->product_name; ?></div>
                                    (<div class="brand_name_data" style="display: inline-block;"><?php echo $b_value->brand_name; ?></div>)
                                    <div class="brand_checkbox" style="width: 20px;position: absolute;right: 0;top: 25%;">
                                        <input type="checkbox" name="brand_checkbox_input" class="brand_checkbox_input" value="<?php echo $b_value->brand_display; ?>" <?php echo ($b_value->brand_display == 1) ? 'checked' : ''; ?>>
                                    </div>
                                </div>
                                <div class="div-table-col unit-price-orig">
                                    <div class="unit-price-orig-txt"><?php echo $b_value->price_orig_hidden; ?></div>
                                    <div class="unit-price-orig-hidden">
                                        <input type="hidden" name="price_orig_hidden" value="<?php echo $b_value->price_orig_hidden; ?>">
                                    </div>
                                </div>
                                <div class="div-table-col sale-unit-price">
                                  <div class="sale_unit_price">
                                    <input type="text" name="unit_price_original" class="unit_price" value="<?php echo $b_value->unit_price; ?>">
                                    <input type="text" name="unit_price_duplicate" class="unit_price_input" value="<?php echo $b_value->unit_price; ?>">
                                  </div>
                                </div>
                                 <div class="div-table-col sale-margin-price">
                                  <div class="sale_margin_price_div">
                                    <?php echo $b_value->margin_price; ?>
                                  </div>
                                   <div class="sale_margin_price_div_hidden">
                                        <input type="hidden" name="sale_margin_price" class="margin_price" value="<?php echo $b_value->margin_price; ?>">
                                    </div>
                                </div>
                                <div class="div-table-col taxless-tot nogst_exclude">
                                  <div class="taxless_tot">
                                    <?php echo $b_value->taxless_amt; ?>
                                  </div>
                                  <input type="hidden" name="taxless_total" class="taxless_tot_class" value="<?php echo $b_value->taxless_amt; ?>">
                                </div>
                                <div class="div-table-col cgst-percentage cgst_display">
                                  <div class="cgst_percentage">
                                    <?php echo $b_value->cgst_percentage; ?>
                                  </div>
                                  <input type="hidden" name="cgst_per_total" class="cgst_per_tot_class" value="<?php echo $b_value->cgst_percentage; ?>">
                                </div>
                                <div class="div-table-col cgst-value cgst_display">
                                  <div class="cgst_value">
                                    <?php echo $b_value->cgst_value; ?>
                                  </div>
                                  <input type="hidden" name="cgst_val_total" class="cgst_val_tot_class" value="<?php echo $b_value->cgst_value; ?>">
                                </div>
                                <div class="div-table-col sgst-percentage cgst_display">
                                  <div class="sgst_percentage">
                                    <?php echo $b_value->sgst_percentage; ?>
                                  </div>
                                  <input type="hidden" name="sgst_per_total" class="sgst_per_tot_class" value="<?php echo $b_value->sgst_percentage; ?>">
                                </div>
                                <div class="div-table-col sgst-value cgst_display">
                                  <div class="sgst_value">
                                    <?php echo $b_value->sgst_value; ?>
                                  </div>
                                  <input type="hidden" name="sgst_val_total" class="sgst_val_tot_class" value="<?php echo $b_value->sgst_value; ?>">
                                </div>
                                <div class="div-table-col igst-percentage igst_display no_display">
                                  <div class="igst_percentage">
                                    <?php echo $b_value->igst_percentage; ?>
                                  </div>
                                  <input type="hidden" name="igst_per_total" class="igst_per_tot_class" value="<?php echo $b_value->igst_percentage; ?>">
                                </div>
                                <div class="div-table-col igst-value igst_display no_display">
                                  <div class="igst_value">
                                    <?php echo $b_value->igst_value; ?>
                                  </div>
                                  <input type="hidden" name="igst_val_total" class="igst_val_tot_class" value="<?php echo $b_value->igst_value; ?>">
                                </div>
                                <div class="div-table-col sale-price">
                                  <div class="sale_total_price">
                                    <input  type="text" name="total_price" class="total_price text-right" value="<?php echo $b_value->sale_value; ?>" readonly="">
                                  </div>
                                </div>
                                <div class="div-table-col sale-option">
                                    <a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
                                    <input type="hidden" value="Delete"/>
                                </div>
                        </div>
                    <?php
                            }
                        } else {
                    ?>

                        <div data-repeater-item class="repeterin div-table-row original">
                                <div class="div-table-col sale-rowno">
                                    <div class="type-container">
                                        <div class="type-bill-slider" style="position:absolute;">
                                            <div class="bill-slide-in active" id="bill_round" data-stype="original" data-sstype="original"></div>
                                            <div class="bill-slide-in" id="bill_square" data-stype="duplicate" data-sstype="out_stock"></div>
                                            <input type="radio" class="type_bill" name="type_bill" value="original" checked>
                                            <input type="radio" class="type_bill" name="type_bill" value="duplicate">
                                            <input type="hidden" name="type_bill_h" class="type_bill_h" value="original">
                                            <!-- For NST -->
                                            <input type="hidden" name="type_bill_s" class="type_bill_s" value="original">
                                        </div>
                                    </div>
                                    <div class="rowno">1</div>
                                </div>
                                <div class="div-table-col sale-lot-no">
                                    <input type="hidden" name="lot_parent" class="input_lot_parent" >
                                    <input type="hidden" name="lot_slab" class="input_lot_slab" value="0">
                                    <select name="lot_number" class="lot_id"></select>
                                </div>
                                <div class="div-table-col sale-sale-option">
                                    
                                    <div style="position:relative;">
                                      <div class="type-slider" style="position:absolute;">
                                        <div class="slide-in active" data-stype="retail">R</div>
                                        <div class="slide-in" data-stype="wholesale">W</div>
                                        <input type="radio" class="sale_type" name="sale_type" value="retail" checked>
                                        <input type="radio" class="sale_type" name="sale_type" value="wholesale">
                                        <input type="hidden" class="sale_type_h" name="sale_type_h" value="retail">
                                        
                                      </div>
                                    </div>

                                </div>
                                <div class="div-table-col sale-weight">

                                  <div class="weight-original-block">
                                    <div class="weight_cal_section">
                                        <input type="hidden" name="bagWeightInKg" class="bagWeightInKg" value="" autocomplete="off" placeholder=""> 
                                        <div class="slab_system_no">
                                            <input type="text" name="weight" class="weight" autocomplete="off" placeholder="" style="display: none;">
                                            <input type="text" name="unit_count" class="unit_count" autocomplete="off" placeholder="Count">
                                            <input type="text" name="slab_no_total" class="total" autocomplete="off" placeholder="Weight" style="display: none;">
                                        </div>
                                        <div class="slab_system_yes" style="display:none;">
                                            <input type="text" name="slab_yes_total" class="total" autocomplete="off" placeholder="Weight" style="width: 55px;">
                                        </div>

                                    </div>
                                    <div class="weight_cal_tooltip">
                                      <div class="tooltip tootip-black" data-stockalert="1">
                                        <span class="tooltiptext">
                                            Slab System : <span class="slab_sys_txt">--</span>
                                            <hr class="tooltip-hr">
                                            Stock Avail : <span class="stock_weight_txt">--</span> kg
                                        </span>
                                      </div>
                                    </div>
                                     <div>
                                        <span class="">
                                            <span class="sale_as_name_kg">  Kg  : <input type="radio" name="sale_as" class="sale_as" value="kg" checked></span>
                                            <span class="sale_as_name_bag"> Bag :<input type="radio" name="sale_as" class="sale_as" value="bag"></span>
                                        </span>
                                    </div>
                                    <div style="clear:both;"></div>
                                  </div>


                                  <div class="weight-duplicate-block">
                                    <div class="weight_cal_section">
                                      <div class="" style="display:block;">
                                        <input type="text" name="lot_duplicate_total" class="total duplicate_total" autocomplete="off" placeholder="Weight" value="0" style="width: 55px;">
                                      </div>

                                    </div>
                                    <div style="clear:both;"></div>
                                  </div>


                                </div>

                                <div class="div-table-col sale-brand" style="position:relative;">
                                    <div class="product_name_data" style="display: inline-block;"></div>
                                    (<div class="brand_name_data" style="display: inline-block;"></div>)
                                    <div class="brand_checkbox" style="width: 20px;position: absolute;right: 0;top: 25%;">
                                        <input type="checkbox" name="brand_checkbox_input" class="brand_checkbox_input" value="1" checked>
                                    </div>
                                </div>
                                <div class="div-table-col unit-price-orig">
                                    <div class="unit-price-orig-txt"></div>
                                    <div class="unit-price-orig-hidden">
                                        <input type="hidden" name="price_orig_hidden" value="">
                                    </div>
                                </div>
                                <div class="div-table-col sale-unit-price">
                                  <div class="sale_unit_price">
                                    <input type="text" name="unit_price_original" class="unit_price" value="0">
                                    <input type="text" name="unit_price_duplicate" class="unit_price_input" value="0">
                                  </div>
                                </div>
                                <div class="div-table-col sale-margin-price">
                                  <div class="sale_margin_price_div">
                                  </div>
                                   <div class="sale_margin_price_div_hidden">
                                        <input type="hidden" name="sale_margin_price" class="margin_price" value="0">
                                    </div>
                                </div>
                                <div class="div-table-col taxless-tot nogst_exclude">
                                  <div class="taxless_tot">
                                  </div>
                                  <input type="hidden" name="taxless_total" class="taxless_tot_class" value="0">
                                </div>
                                <div class="div-table-col cgst-percentage cgst_display">
                                  <div class="cgst_percentage">
                                  </div>
                                  <input type="hidden" name="cgst_per_total" class="cgst_per_tot_class" value="0">
                                </div>
                                <div class="div-table-col cgst-value cgst_display">
                                  <div class="cgst_value">
                                  </div>
                                  <input type="hidden" name="cgst_val_total" class="cgst_val_tot_class" value="0">
                                </div>
                                <div class="div-table-col sgst-percentage cgst_display">
                                  <div class="sgst_percentage">
                                  </div>
                                  <input type="hidden" name="sgst_per_total" class="sgst_per_tot_class" value="0">
                                </div>
                                <div class="div-table-col sgst-value cgst_display">
                                  <div class="sgst_value">
                                  </div>
                                  <input type="hidden" name="sgst_val_total" class="sgst_val_tot_class" value="0">
                                </div>
                                <div class="div-table-col igst-percentage igst_display no_display">
                                  <div class="igst_percentage">
                                  </div>
                                  <input type="hidden" name="igst_per_total" class="igst_per_tot_class" value="0">
                                </div>
                                <div class="div-table-col igst-value igst_display no_display">
                                  <div class="igst_value">
                                  </div>
                                  <input type="hidden" name="igst_val_total" class="igst_val_tot_class" value="0">
                                </div>
                                <div class="div-table-col sale-price">
                                  <div class="sale_total_price">
                                    <input  type="text" name="total_price" class="total_price text-right" value="0" readonly="">
                                  </div>
                                </div>
                                <div class="div-table-col sale-option">
                                    <a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
                                    <input type="hidden" value="Delete"/>
                                </div>
                        </div>
                    <?php
                        }

                    ?>
                    </div>


                    <div class="div-table">
                        <div class="div-table-row">
                            <div class="div-table-col total-block-extra"></div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col sale-unit-price" style="">
                                Actual Total
                            </div>
                            <div class="div-table-col sale-price total-price">
                                <div class="actual_total">
                                    <input  type="text" name="actual_price" class="actual_price text-right" value="<?php echo $bill_data['bill_data']->sale_value; ?>" readonly="">
                                </div>
                            </div>
                            <div class="div-table-col sale-option option-delete">
                            </div>
                        </div>
                        <!-- <div class="div-table-row">
                            <div class="div-table-col total-block-extra"></div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>                            
                            <div class="div-table-col sale-unit-price" style="">
                                Discount  (Rs)
                            </div>
                            <div class="div-table-col sale-price">
                                <div class="discount_total"> -->
                                    <input  type="hidden" name="discount" class="discount text-right" value="<?php echo $bill_data['bill_data']->sale_discount_price; ?>">
                                <!-- </div>                            
                            </div>
                            <div class="div-table-col sale-option">
                            </div>
                        </div> -->
                        <div class="div-table-row">
                            <div class="div-table-col total-block-extra"></div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col sale-unit-price" style="">
                                Card Swipping Fee   (RS)
                            </div>
                            <div class="div-table-col sale-price">
                                <div class="discount_total">
                                    <input  type="text" name="cardswip" class="cardswip text-right" value="<?php echo $bill_data['bill_data']->sale_card_swip; ?>">
                                </div>                            
                            </div>
                            <div class="div-table-col sale-option">
                            </div>
                        </div>
                        <div class="div-table-row">
                            <div class="div-table-col total-block-extra"></div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>
                            <div class="div-table-col total-block-extra">
                            </div>                            
                            <div class="div-table-col sale-unit-price" style="">
                                Total
                            </div>

                            <div class="div-table-col sale-price">
                                <div class="final_total_price">
                                    <input  type="text" name="final_total" class="final_total text-right" value="<?php echo $bill_data['bill_data']->sale_total; ?>" readonly="">
                                    <input  type="hidden" name="final_total_hidden" class="final_total_hidden text-right" value="<?php echo $bill_data['bill_data']->sale_total; ?>">
                                    <input  type="hidden" name="customer_due" class="customer_due" value="<?php echo checkBillBalance($bill_data['bill_data']->id); ?>">
                                </div>
                            </div>
                            <div class="div-table-col sale-option">
                            </div>
                        </div>
                    </div>

                    <ul class="icons-labeled">
                        <li><a data-repeater-create href="javascript:void(0);" id="add_new_price_range"><span class="icon-block-color add-c"></span>Add Price Range Retail Sale</a></li>
                    </ul>
                </div>
                <div style="clear:both;"></div>
    <?php include( get_template_directory().'/inc/admin/billing_template/billing/modepayment_singlebill/modeofpayment.php' );    ?> 

            </li>


            <li class="buttons bottom-round noboder">
                <div class="fieldwrap">
                    <input name="bill_update" type="button" value="Update Bill" class="submit-button bill_update">
                </div>
            </li>
        </ul>
    </form>
</div>


<div class="conform-box" style="display:none;">Chose the action!</div>

<script type="text/javascript">

    jQuery('.retail-repeater').repeater({
        defaultValues: {

          sale_type: ['retail'],
          type_bill: ['original'],
          brand_checkbox_input : 1,
          type_bill_h : 'original',
          sale_type_h : 'retail',
          total_price : 0,
          lot_duplicate_total : 0,
          unit_price_duplicate : 0,
          unit_price_original : 0,

          slab_no_total : 0,
          slab_yes_total : 0,

        },
        show: function () {
            var count = 1;
            jQuery('.retail-repeater .repeterin').each(function(){
                jQuery(this).find('.rowno').text(count);
                count++;
            });
            populate_select2(this, 'new');
            jQuery(this).slideDown();

            billTypeConversion(jQuery(this));
        },
        hide: function (deleteElement) {



            var current_sel = this;



            jQuery( ".conform-box" ).dialog({
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                    "Delete": function() {
                        jQuery(this).slideUp(deleteElement);
                        jQuery( this ).dialog( "close" );
                    },
                    Cancel: function() {
                        jQuery( this ).dialog( "close" );
                    }
                }
            });
            var count = 1;
            jQuery('.retail-repeater .repeterin').each(function(){ 
                jQuery(this).find('.rowno').text(count);
                count++;
            });


/*          if(confirm('Are you sure you want to delete this element?')) {
                jQuery(this).slideUp(deleteElement);
                var count = 1;
                jQuery('.retail-repeater .repeterin').each(function(){ 
                  jQuery(this).find('.rowno').text(count);
                  count++;
                })
            }*/
        },
        ready: function (setIndexes) {
            
        }
    });

    jQuery(document).ready(function(){ 
    //        populateBill();

        jQuery("#billing_date" ).datepicker({dateFormat: "yy-mm-dd"});
    });


function billTypeConversion(selector = '') {
    var main_bill_type = jQuery('input[type=radio][name=customer_type]:checked').val();
    jQuery(selector).find('.type-slider').find('.active').removeClass('active');
    jQuery(selector).find('.type-slider [data-stype="'+main_bill_type+'"]').addClass('active');
    jQuery(selector).find("input[type=radio][value="+ main_bill_type +"]").attr('checked', 'checked');
    jQuery(selector).find('.sale_type_h').val(main_bill_type);

    jQuery(selector).find('.type-bill-slider').find('.active').removeClass('active');
    jQuery(selector).find('.type-bill-slider [data-stype="original"]').addClass('active');
    jQuery(selector).find('.type-bill-slider .type_bill[value="original"]').attr('checked', 'checked');
    jQuery(selector).find('.type-bill-slider .type_bill_h').val('original');
    jQuery(selector).find('.type-bill-slider .type_bill_s').val('original');

    jQuery(selector).closest('.repeterin').removeClass('duplicate').addClass('original');

    var gst_type = jQuery('.gst_type:checked').val();
    callGSTChange(gst_type);

    jQuery(selector).find('.product_name_data, .brand_name_data, .unit-price-orig-txt, .taxless_tot, .cgst_percentage, .cgst_value, .sgst_percentage, .sgst_value, .igst_percentage, .igst_value').text('');
}



</script>