
<style>
    .kg_display {
        display: none;
        font-size: 18px;
        font-weight: 900;
    }
    .bag_display {
        display: none;
        font-size: 18px;
        font-weight: 900;
    }
    input[type="radio"][readonly] {
        pointer-events: none;
    }
</style>

<div class="form-grid">
    <form method="post" name="new_billing" id="new_billing" class="leftLabel" onsubmit="return false;">
        <ul>
            <li>
                <label class="fldTitle">Billing Date
                <abbr class="require" title="Required Field">*</abbr>
                </label>
                <div class="fieldwrap">
                    <span class="left">
                        <input type="text" name="billing_date" class="billing_date" value="<?php echo date("Y-m-d", time()); ?>" id="billing_date">
                    </span>
                    <span class="left">
                    <label class="fldTitle">Bill No</label>
                    <input type="hidden" name="billing_no" id="billing_no" autocomplete="off" value="<?php echo $unlocked_val['id']; ?>">
                    <input type="text" value="<?php echo 'INV'.$unlocked_val['invoice_id']; ?>" disabled="" id="invoice_id">
                    </span>
                </div>
            </li>
            <li>
                <legend class="choiceFld">Select the Shop<abbr title="Required Field" class="require">*</abbr></legend>
                <div class="fieldwrap input-uniform">
                    <span class="left">
                        <span>
                            <input type="radio" name="shop_name" value="rice_center" checked><label class="choice">Saravana Rice Centre</label>
                        </span>
                        &nbsp;&nbsp;
                        <span>
                            <input type="radio" name="shop_name" value="rice_mandy"><label class="choice">Saravana Rice Mandy</label>
                        </span>
                                               
                    </span>
                    <span class="left">
                        <legend class="choiceFld">GST Bill To</legend>
                        <div class="fieldwrap input-uniform">
                            <span>
                                <input type="radio" name="gst_type" value="cgst" checked class="gst_type"><label class="choice">GST</label>
                            </span>
                            &nbsp;&nbsp;                                   
                             <span>
                                <input type="radio" name="gst_type" value="igst" class="gst_type"><label class="choice">IGST</label>
                            </span>
                            <!--  <span>
                                <input type="radio" name="gst_type" value="no_gst" class="gst_type"><label class="choice">No GST</label>
                            </span> -->
                        </div>
                    </span>
                </div>
            </li>
            
            <li>
                <legend class="choiceFld">Bill By Name</legend>
                <div class="fieldwrap input-uniform">
                    <span>
                        <input type="radio" name="bill_by_name" value="no" checked class="bill_by"><label class="choice">Counter</label>
                    </span>
                    &nbsp;&nbsp;                                   
                     <span>
                        <input type="radio" name="bill_by_name" value="yes" class="bill_by"><label class="choice">Customer Name</label>
                    </span>
                </div>
            </li>
            <li>
                <label id="customer" for="customer" class="fldTitle">Select the Customer
                    <abbr class="require" title="Required Field">*</abbr>
                </label>
                <div class="fieldwrap by-customer" style="display:none;">
                    <span class="left">
                        <div class="align">
                            <div class="customer-cash">
                                <div class="customer_old">
                                    <select id="billing_customer" name="billing_customer" class="billing_customer"></select>
                                </div>
                                <div class="customer_new">
                                    <input type="text" size="200" class="new_billing_customer" readonly/>
                                </div>
                                <div>
                                    <a class="new_user_a">New User</a>
                                    <a class="old_user_a">Old User</a>
                                    <input type="hidden" name="user_type" value="old" class="user_type" id="user_type" /> 
                                    <input type="hidden" name="customer_id_new" class="customer_id_new"> 
                                </div>
                            </div>
                        </div>           
                    </span>              
                </div>
                <div class="fieldwrap by-counter">
                    <span class="left">
                        <div class="align">
                            <div class="counter-cash">
                                Counter Sale
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
                            <input type="radio" name="customer_type" value="retail" checked><label class="choice">Retail Bill</label>
                        </span>
                        &nbsp;&nbsp;
                        <span>
                            <input type="radio" name="customer_type" value="wholesale"><label class="choice">Wholesale Bill</label>
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


                <div class="retail-repeater group_retail">
                    <div data-repeater-list="group_retail" class="div-table">

                        <div class="div-table-row">
                            <div class="div-table-head" style="width: 75px;">S.No</div>
                            <div class="div-table-head" style="width: 160px;">Lot Number</div>
                            <div class="div-table-head" style="width: 50px;">Sale Option</div>
                            <div class="div-table-head" style="width: 220px;">Weight</div>
                            <div class="div-table-head" style="width: 150px;">Product Name<br/>(Bill Display Name)</div>
                            <div class="div-table-head" style="width: 90px;">Unit Price (MRP)</div>
                            <div class="div-table-head" style="width: 100px;">Discounted price</div>
                            <div class="div-table-head" style="width: 100px;">End price</div>
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
                                <div class="div-table-col sale-lot-no" style="height:55px;">
                                    <input type="hidden" name="lot_parent" class="input_lot_parent"  value="0">
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
                                         <input type="hidden" name="hsn_code" class="hsn_code">
                                        <input type="hidden" name="bagWeightInKg" class="bagWeightInKg" autocomplete="off" placeholder=""> 
                                      <div class="slab_system_no" style="width: 100px;text-align:left;">
                                        <input type="text" name="weight" class="weight" autocomplete="off" placeholder="" readonly style="display: none;">
                                        <input type="text" name="unit_count" class="unit_count" autocomplete="off" placeholder="Count" style="width: 55px;">
                                        <input type="text" name="slab_no_total" class="total" autocomplete="off" placeholder="Weight KG" readonly style="display: none;"> 
                                        <span class="bag_display">Bag</span>
                                      </div>
                                      <div class="slab_system_yes" style="display:none;width: 100px;text-align:left;">
                                        <input type="text" name="slab_yes_total" class="total" autocomplete="off" placeholder="Weight" style="width: 55px;">
                                        <span class="kg_display">Kg</span>
                                        <span class="bag_display">Bag</span>
                                      </div>
                                    </div>

                                    <div style="padding-top:6px;">
                                        <span class="">
                                            <span class="sale_as_name_kg"><input type="radio" name="sale_as" class="sale_as" value="kg" checked> - Kg</span> | 
                                            <span class="sale_as_name_bag">Bag - <input type="radio" name="sale_as" class="sale_as" value="bag"></span>
                                        </span>
                                    </div>
                                
                                    <div style="clear:both;"></div>
                                  </div>

                                </div>

                                <div class="div-table-col sale-brand" style="position:relative;">


                                    <div class="weight_cal_tooltip" style="width:25px;float:left;">
                                        <div class="tooltip tootip-black" data-stockalert="1">
                                            <span class="tooltiptext">
                                                Slab System : <span class="slab_sys_txt">--</span>
                                                <hr class="tooltip-hr">
                                                Stock Avail : <span class="stock_weight_txt">--</span> kg
                                            </span>
                                        </div>
                                    </div>


                                    <div class="product_name_data" style="display: inline-block;"></div>
                                    (<div class="brand_name_data" style="display: inline-block;"></div>)
                                    <div class="brand_checkbox" style="width: 20px;position: absolute;right: 0;top: 25%;">
                                        <input type="checkbox" name="brand_checkbox_input" class="brand_checkbox_input" value="1" checked style="display:none;">
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
                                    <input type="hidden" name="unit_price_for_calc" class="unit_price_for_calc" value="0">
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
                                    <div>
                                        <a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
                                        <input type="hidden" value="Delete"/>                              
                                    </div>

                                </div>
                        </div>



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
                            <div class="div-table-col" style="">
                                Actual Total
                            </div>
                            <div class="div-table-col sale-price total-price">
                                <div class="actual_total">
                                    <input  type="text" name="actual_price" class="actual_price text-right" value="0.00" readonly="">
                                </div>
                            </div>
                            <div class="div-table-col option-delete">
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
                            <div class="div-table-col sale-unit-price" style=""> -->
                                <!-- Discount  (Rs) -->
                           <!--  </div>
                            <div class="div-table-col sale-price">
                                <div class="discount_total"> -->
                                    <input  type="hidden" name="discount" class="discount text-right" value="0.00">
                                <!-- </div>                            
                            </div>
                            <div class="div-table-col option-delete">
                            </div>
                        </div> -->
                        <div class="div-table-row" style="display:none">
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
                                    <input  type="text" name="cardswip" class="cardswip text-right" value="0.00">
                                </div>                            
                            </div>
                            <div class="div-table-col option-delete">
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
                            <div class="div-table-col" style="">
                                Sub Total
                            </div>
                            <div class="div-table-col sale-price">
                                <div class="final_total_price">
                                    <input  type="text" name="final_total" class="final_total text-right" value="0.00" readonly="">
                                    <input  type="hidden" name="final_total_hidden" class="final_total_hidden text-right" value="0.00">
                                </div>                             
                            </div>
                            <div class="div-table-col option-delete">
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
                            <div class="div-table-col" style="">
                                Round Off
                            </div>
                            <div class="div-table-col sale-price">
                                <div class="round_price">
                                    <input  type="text" name="round_off_text" class="round_off_text text-right" value="0.00" readonly="">
                                </div>                             
                            </div>
                            <div class="div-table-col option-delete">
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
                    <input name="bill_submit" type="button" value="Create Invoice" class="submit-button bill_submit">
                </div>
            </li>
        </ul>
    </form>
</div>




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
            if(confirm('Are you sure you want to delete this element?')) {
                jQuery(this).slideUp(deleteElement);

                var count = 1;
                jQuery('.retail-repeater .repeterin').each(function(){ 
                    jQuery(this).find('.rowno').text(count);
                    count++;
                    var gst_type = jQuery(this).val();
                    callGSTChange(gst_type);
                });
            }
        },
        ready: function (setIndexes) {
            
        }
    });



    jQuery(document).ready(function(){
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

}


jQuery(document).on("keydown", ".select2-search__field", function(e) {
  if(event.keyCode == 9) {
    if(event.shiftKey && event.keyCode == 9) {  
       e.preventDefault(); 
       jQuery('input[name="customer_type"]').focus();
    }
    else { 
      e.preventDefault();
      jQuery('#new_billing .unit_count').focus();
    }
  }
});

//From Stock Submit button (tab and shif + tab action)
jQuery(document).on("keydown", "#new_billing .submit-button", function(e) {
  if(event.keyCode == 9) {
    if(event.shiftKey && event.keyCode == 9) {  
       e.preventDefault(); 
      jQuery('#new_billing .delivery_need').focus();
    }
    else { 
      e.preventDefault(); 
      jQuery('.billing_date').focus();
    }
  }
});
jQuery(document).on("keydown", "#new_billing .billing_date", function(e) {
  if(event.keyCode == 9) {
    if(event.shiftKey && event.keyCode == 9) {  
       e.preventDefault(); 
      jQuery('#new_billing .submit-button').focus();
    }
    else { 
      e.preventDefault(); 
      jQuery('input[name="shop_name"]').focus();
    }
  }
});
</script>
