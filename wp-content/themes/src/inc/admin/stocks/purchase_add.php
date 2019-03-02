<style type="text/css">
    .inside_form .form_detail {
        width: 46%;
        float: left;
        margin: 0 10px 5px;
        height: 42px;
    }
    .particulars {
        margin: 0 10px 5px;
    }
    .particulars .part-in {
        margin: 10px;
    }

    .footer-txt {
        text-align: right;
    }
</style>
<div style="width: 100%;">
    <ul class="icons-labeled">
        <li>
            <a href="<?php echo menu_page_url('purchase_list', 0); ?>" ><span class="icon-block-color coins-c"></span>Purchase List</a>
        </li>
    </ul>
</div>
<div class="widget-top">
    <h4>New Purchase</h4>
</div>

<div class="form-grid">
    <form method="post" class="inside_form" id="purfrm">
        <div class="form_detail">
            <label>Name 
                <abbr class="require" title="Required Field">*</abbr>
            </label>
            <input type="text" id="pur_name" value="" name="pur_name" class="pur_name">
        </div>
        <div class="form_detail">
            <label style="width: 115px;">Bill Number
                 <abbr class="require" title="Required Field">*</abbr>
            </label>

            <input type="text" name="bill_number" class="bill_number">
        </div>
        <div class="form_detail">
            <label style="width: 115px;">Address
            </label>
            <textarea name="address" class="address"></textarea>
        </div>
        <div class="form_detail">
            <label style="width: 115px;">Bill Date
                <abbr class="require" title="Required Field">*</abbr>
            </label>
            <input type="text" name="bill_date" class="bill_date">
        </div>
        <div class="form_detail">
            <label style="width: 115px;">Phone Number
                <abbr class="require" title="Required Field">*</abbr>
            </label>
            <input type="text" id="phone" name="phone" class="phone" autocomplete="off" value="">
        </div>
        <div class="form_detail">
            <label style="width: 115px;">GST Number
            </label>
            <input type="text" id="gst_no" name="gst_no" class="gst_no" autocomplete="off" value="">
        </div>
        <div class="form_detail">
            <label style="width: 115px;">Email
            </label>
            <input type="text" id="email" name="email" autocomplete="off"  class="email" value="">
        </div>
        <div class="form_detail">
            <label style="width: 115px;">GST%
            </label>
            <div style="margin-top: 12px;">
                <select name="gst_percentage" class="gst_percentage">
                    <option value='0'>0%</option> 
                    <option value='5'>5%</option>
                    <option value='12'>12%</option>
                    <option value='18'>18%</option>
                    <option value='28'>28%</option>
                </select>
              <!--  <input type="radio" name="tax_from" value="notax">NO TAX
                <input type="radio" name="tax_from" value="cgst" checked>SGST
                <input type="radio" name="tax_from" value="igst">IGST-->
            </div>
        </div>
        <div style="clear:both;"></div>
        <div class="particulars">
            <div class="part-in">
                <h2>Particulars</h2>

                <div class="widget-content module table-simple">
                    <table class="display">
                        <thead>
                            <tr>
                                <th style="width: 300px;">Lot Number</th>
                                <th>Bag Weight (in Kg)</th>
                                <th style="width: 300px;">Total Bags/kg</th>
                                <th style="width: 100px;">Rate per Bag / Kg</th>
                                <th style="width: 200px;">Total Bags</th>
                                <th style="width: 200px;">Discount in %</th>
                                <th>Taxless Amount</th>
                                <th style="width: 100px;" colspan="2">CGST</th>
                                <th style="width: 100px;" colspan="2">SGST</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" id="pro_lot_number" name="lot_number">
                                    <input type="hidden" id="pro_lot_id" name="pro_lot_id">
                                    <input type="hidden" class="pro_hsncode" value="">
                                </td>
                                <td>   
                                    <span class="pro_bag_weight" style="display:none"></span>
                                    <input type="text" style="width:50px" class="pro_bag_weight_hide" value="0">
                                </td>
                                <td>
                                    <span>
                                        <input type="text" class="pro_bag_count" value="" style="width:100px;">
                                        <span class="pro_unit_text" style="font-size: 18px;font-weight: 900;">Bag</span>
                                        &nbsp;&nbsp;
                                    </span>
                                    <span class="pro_bag_kg">
                                        <span class="">
                                            <span class="sale_as_name_bag"><input type="radio" name="purchase_as" class="purchase_as" value="bag" checked> - Bag</span> | 
                                            <span class="sale_as_name_kg">Kg - <input type="radio" name="purchase_as" class="purchase_as" value="kg"></span>
                                        </span>
                                    </span>
                                </td>
                                <td >
                                    <span class="pro_rate">
                                        <input type="text" class="pro_rate_val" style="width:100px;">
                                    </span>
                                </td>
                                <td>
                                    <span class="pro_tot_bags"></span>
                                    <input type="hidden" class="pro_tot_bags_input" value="0">
                                </td> 
                                <td>  <input type="text" class="pro_inv_discount"  value='0' style="width:50px;"></td>
                                <td>
                                    <span class="pro_total">
                                    </span>
                                    <input type="hidden" class="pro_total_val" value="0">
                                </td>
                                <td>
                                    <span class="gst_per"></span>%
                                    <input type="hidden" class="gst_per" value="0">
                                </td>
                                <td>
                                   Rs. <span class="gst_per_value"></span>
                                    <input type="hidden" class="gst_per_value" value="0">
                                </td>
                                <td>
                                    <span class="gst_per"></span>%
                                    <input type="hidden" class="gst_per" value="0">
                                </td>
                                <td>
                                    Rs. <span class="gst_per_value"></span>
                                    <input type="hidden" class="gst_per_value" value="0">
                                </td>
                                 <td>
                                    Rs. <span class="tax_amt"></span>
                                    <input type="hidden" class="tax_amt" value="0">
                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <input style="float: right;" type="button" value="Add Item" class="add_item">
                </div>



                <h2>Added Items</h2>
                <div class="widget-content module table-simple">
                    <table class="display">
                        <thead>
                            <tr>
                                <th style="width: 300px;">HSN</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th style="width: 100px;">per</th>
                                <th>Taxless Amount</th>
                                <th>Tax Amount</th>
                                <th>Sub Amount</th>
                            </tr>
                        </thead>
                        <tbody class="purchase_row">
                        </tbody>
                        <tbody class="purchase_total">
                            <tr>
                                <td colspan="7"><div class="footer-txt">Sub Total</div></td>
                                <td style="width:100px"><input type="text" value="0" style="width:100px" name="subtotal_tot" readonly class="subtotal_tot" /></td>
                            </tr>
                            <tr>
                                <td colspan="7"><div class="footer-txt">Taxless Amount</div></td>
                                <td><input type="text" value="0" style="width:100px" name="taxlesstotal" class="taxlesstotal" /></td>
                            </tr>                            
                            <tr>
                                <td colspan="7"><div class="footer-txt">Cash Discount</div></td>
                                <td><input type="text" value="0" style="width:100px" name="discount" class="discount" /></td>
                            </tr>

                            <tr>
                                <td colspan="7"><div class="footer-txt">Total Gst Amount</div></td>
                                <td><input type="text" style="width:100px" value="0" name="gsttotal" class="gsttotal" /></td>
                            </tr>                            
                            <tr>
                                <td colspan="7"><div class="footer-txt">Grand Total</div></td>
                                <td><input type="text" style="width:100px" value="0" class="grandtotal"  name="grandtotal"  readonly/></td>
                            </tr>
                            <input type="hidden" name="lot_details" value="" class="lot_details">
                        </tbody>
                        <tfoot>
                            <tr>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>


        <div class="button_sub">
            <button type="submit" name="purchase_submit" id="" class="purchase_submit">Submit</button>
        </div>
    </form>
</div>




<script type="text/javascript">
jQuery('.purchase_submit').live('click', function(){
if(jQuery('#pur_name').val() != ''  && jQuery('.bill_number').val() != '' && jQuery('.bill_date').val() != '' && jQuery('.phone').val() != '' && validatePhone(jQuery('.phone').val()) ) {
    
    
                jQuery.ajax({
                    type: "POST",
                    url: frontendajax.ajaxurl,
                    data: {
                          data:jQuery('#purfrm').serialize(),
                          action : 'purchase_add_submit' 
                    },
                    success: function (data) {
                        alert(data);
                    }

            });
}  
else{
    alert("Enter Required Field....");
    return false;
}              

});


    jQuery( "#pro_lot_number" ).autocomplete ({
        source: function( request, response ) {
            jQuery.ajax({
                url: frontendajax.ajaxurl,
                type: 'POST',
                dataType: "json",
                showAutocompleteOnFocus : true,
                autoFocus: true,
                selectFirst: true,
                data: {
                    action: 'get_lot_data_billing',
                    search_key: request.term
                },
                success: function( data ) {
                    response(jQuery.map( data.items, function( item ) {
                        return {
                            id              : item.id,
                            value           : item.brand_name +'('+ item.product_name +')',
                            product_name    : item.brand_name,
                            product_brand   : item.product_name,
                            bag_weight      : item.weight,
                            hsn_code        : item.hsn_code,
                        }
                    }));
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {

            jQuery('#pro_lot_id').val(ui.item.id);
            jQuery('.pro_brand').text(ui.item.product_brand);
            jQuery('.pro_product').text(ui.item.product_name);
            jQuery('.pro_bag_weight').text(ui.item.bag_weight);
            jQuery('.pro_bag_weight_hide').val(ui.item.bag_weight);
            jQuery('.pro_hsncode').val(ui.item.hsn_code);

            calculateParticular();
        },
        response: function(event, ui) {
            if (ui.content.length == 1) { console.log(ui.content[0]);

                jQuery(this).val(ui.content[0].value);
                jQuery(this).autocomplete( "close" );

                jQuery('#pro_lot_id').val(ui.content[0].id);
                jQuery('.pro_brand').text(ui.content[0].product_brand);
                jQuery('.pro_product').text(ui.content[0].product_name);
                jQuery('.pro_bag_weight').text(ui.content[0].bag_weight);
                jQuery('.pro_bag_weight_hide').val(ui.content[0].bag_weight);
                jQuery('.pro_hsncode').val(ui.content[0].hsn_code);

                calculateParticular();
                jQuery('.pro_bag_count').focus();

            }
        }
    });

    jQuery('.pro_bag_count, .purchase_as, .pro_rate_val, .pro_inv_discount').on('change',function () {
        calculateParticular();
    });


    jQuery('.taxlesstotal, .discount, .gsttotal').on('change',function () {
       
         var taxlesstotal=jQuery('.taxlesstotal').val();
         var discount=jQuery('.discount').val();
         var gsttotal=jQuery('.gsttotal').val();
         var finalamt=parseFloat(taxlesstotal)-parseFloat(discount)+parseFloat(gsttotal);
         jQuery('.grandtotal').val(finalamt);

    });



  jQuery(".pro_bag_count").keypress(function (e) {    
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
       alert("Enter Numbers Only");       
               return false;
        }
   });
  jQuery(".phone").keypress(function (e) {    
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
       alert("Enter Numbers Only");       
               return false;
        }
   });
  
    jQuery('.add_item').on('click',function () {
        if((jQuery('#pro_lot_number').val()=='') ||(jQuery('#pro_lot_number').val()=='0')){
            alert('Enter Product name');jQuery('#pro_lot_number').focus();
            return false
        }
        if((jQuery('.pro_bag_count').val()=='') || (validatePhone(jQuery('.pro_bag_count').val())))
        {
            alert('Enter Valid Count');jQuery('.pro_bag_count').focus();
            return false
        }
        formPurchaseBill();
        clearParticular();
        jQuery('#pro_lot_number').focus();
    });

    function calculateParticular() {
        var bag_weight = isNaN(parseFloat(jQuery('.pro_bag_weight_hide').val())) ? 0.00 : parseFloat(jQuery('.pro_bag_weight_hide').val());
        var parchase_as = jQuery('.purchase_as:checked').val();
        var pro_inv_discount_amount = (jQuery('.pro_inv_discount').val()/100); 
        var gst_percentage= jQuery('.gst_percentage').val()/2; 
        var unit = isNaN(parseFloat(jQuery('.pro_bag_count').val())) ? 0.00 : parseFloat(jQuery('.pro_bag_count').val());
        var rate = isNaN(parseFloat(jQuery('.pro_rate_val').val())) ? 0.00 : parseFloat(jQuery('.pro_rate_val').val());        
        var total_bags =(parchase_as =='bag')?unit : (unit/bag_weight);
        jQuery('.pro_tot_bags').text(total_bags);
        jQuery('.pro_tot_bags_input').val(total_bags);
        pro_inv_discount_amount=pro_inv_discount_amount*(unit*rate);
        var pro_total=((unit*rate)-pro_inv_discount_amount).toFixed(2);
        var gst_value=pro_total*gst_percentage/100;
        jQuery('.gst_per').text(gst_percentage);jQuery('.gst_per').val(gst_percentage);
        jQuery('.gst_per_value').text(gst_value);jQuery('.gst_per_value').val(gst_value);
        jQuery('.pro_total').text(pro_total);jQuery('.pro_total_val').val(pro_total);
        jQuery('.tax_amt').text((parseFloat(pro_total)+parseFloat(gst_value*2)).toFixed(2));        
        jQuery('.tax_amt').val((parseFloat(pro_total)+parseFloat(gst_value*2)).toFixed(2));        
        
    }
    function formPurchaseBill() {
        var hsn = jQuery('.pro_hsncode').val();var taxlessamount=jQuery('.pro_total_val').val();
        var lot_id = jQuery('#pro_lot_id').val();
        var gst_per_value=parseFloat(jQuery('.gst_per_value').val())+parseFloat(jQuery('.gst_per_value').val());
        var description = jQuery('#pro_lot_number').val();
        var qty = jQuery('.pro_bag_count').val();
        var rate = jQuery('.pro_rate_val').val();
        var per = jQuery('.purchase_as:checked').val();
        var total =  jQuery('.tax_amt').val();
        var gst_percentage =  jQuery('.gst_percentage').val();

        var subtotal_tot=parseFloat(jQuery('.subtotal_tot').val())+parseFloat(total);
        jQuery('.subtotal_tot').val(subtotal_tot);

        var taxlesstotal=parseFloat(jQuery('.taxlesstotal').val())+parseFloat(taxlessamount);
        jQuery('.taxlesstotal').val(taxlesstotal);

        var gsttotal=parseFloat(jQuery('.gsttotal').val())+parseFloat(gst_per_value);
        jQuery('.gsttotal').val(gsttotal);

        var grandtotal=parseFloat(jQuery('.taxlesstotal').val())+parseFloat(jQuery('.gsttotal').val());
        jQuery('.grandtotal').val(grandtotal);
        if(jQuery('.lot_details').val()==''){
            var lot_details=lot_id+','+description+','+hsn+','+rate+','+per+','+gst_percentage+','+gst_per_value+','+taxlessamount+','+qty+','+total;
        }else{
        var lot_details=jQuery('.lot_details').val()+'~'+lot_id+','+description+','+hsn+','+rate+','+per+','+gst_percentage+','+gst_per_value+','+taxlessamount+','+qty+','+total;
    
        }
        
        jQuery('.lot_details').val(lot_details);
        var lot_id_hidden = '<input type="hidden" class="lot_id_hidden" value="'+jQuery('#pro_lot_id').val()+'">';
        var bag_count_hidden = '<input type="hidden" class="bag_count_hidden" value="'+jQuery('.pro_tot_bags_input').val()+'">';


        var row_tr = "<tr><td>"+hsn+lot_id_hidden+"</td><td>"+description+"</td><td>"+qty+bag_count_hidden+"</td><td>"+rate+"</td><td>"+per+"</td><td>"+taxlessamount+"</td><td>"+gst_per_value+"</td><td>"+total+"</td></tr>";
        jQuery('.purchase_row').append(row_tr);
        calculateTotal();
    }
    function clearParticular() {
        jQuery('#pro_lot_number').val(0);
        jQuery('.pro_hsncode').val('');
        jQuery('.pro_bag_weight').text('');
        jQuery('.pro_bag_weight_hide').val('');
        jQuery('.pro_bag_count').val('');
        jQuery('.purchase_as[value=bag]').prop('checked', true);
        jQuery('.pro_rate_val').val('');
        jQuery('.pro_tot_bags').text(0);
        jQuery('.pro_tot_bags_input').val(0);
    }
    function calculateTotal() {
        //pro_lot_id
    }
</script>

