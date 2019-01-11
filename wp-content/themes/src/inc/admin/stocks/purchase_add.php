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
            <a href="<?php echo menu_page_url('sales_others', 0); ?>" ><span class="icon-block-color coins-c"></span>Purchase List</a>
        </li>
    </ul>
</div>
<div class="widget-top">
    <h4>New Purchase</h4>
</div>

<div class="form-grid">
    <form method="post" class="inside_form">
        <div class="form_detail">
            <label>Name 
                <abbr class="require" title="Required Field">*</abbr>
            </label>
            <input type="text" id="lot_number" value="" name="lot_number">
        </div>
        <div class="form_detail">
            <label style="width: 115px;">Bill Number
            </label>
            <input type="text" name="product_name1">
        </div>
        <div class="form_detail">
            <label style="width: 115px;">Address
            </label>
            <textarea></textarea>
        </div>
        <div class="form_detail">
            <label style="width: 115px;">Bill Date
            </label>
            <input type="text" name="product_name1">
        </div>
        <div class="form_detail">
            <label style="width: 115px;">Phone Number
            </label>
            <input type="text" id="brand_name" name="brand_name" autocomplete="off" value="">
        </div>
        <div class="form_detail">
            <label style="width: 115px;">GST Number
            </label>
            <input type="text" id="brand_name" name="brand_name" autocomplete="off" value="">
        </div>
        <div class="form_detail">
            <label style="width: 115px;">Email
            </label>
            <input type="text" id="brand_name" name="brand_name" autocomplete="off" value="">
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
                                <th>Bag Weight (Kg)</th>
                                <th style="width: 300px;">Bags</th>
                                <th style="width: 100px;">Rate per Bag / Kg</th>
                                <th style="width: 200px;">Total Bags</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" id="pro_lot_number" name="lot_number">
                                    <input type="hidden" class="pro_hsncode" value="">
                                </td>
                                <td>   
                                    <span class="pro_bag_weight"></span>
                                    <input type="hidden" class="pro_bag_weight_hide" value="0">
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
                                <td>
                                    <span class="pro_rate">
                                        <input type="text" class="pro_rate_val" style="width:100px;">
                                    </span>
                                </td>
                                <td>
                                    <span class="pro_tot_bags"></span>
                                </td>
                                <td>
                                    <span class="pro_total">

                                    </span>
                                    <input type="hidden" class="pro_total_val" value="0">
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
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody class="purchase_row">
                        </tbody>
                        <tbody class="purchase_total">
                            <tr>
                                <td colspan="5"><div class="footer-txt">Sub Total</div></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5"><div class="footer-txt">Cash Discount</div></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5"><div class="footer-txt">Taxable Amount</div></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5"><div class="footer-txt">Total Gst Amount</div></td>
                                <td></td>
                            </tr>                            
                            <tr>
                                <td colspan="5"><div class="footer-txt">Grand Total</div></td>
                                <td></td>
                            </tr>
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
            <button type="submit" name="edit_customer_list" id="btn_submit" class="submit-button">Submit</button>
        </div>
    </form>
</div>




<script type="text/javascript">
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


    jQuery('.pro_bag_count, .purchase_as, .pro_rate_val').on('change',function () {
        calculateParticular();
    });

    jQuery('.add_item').on('click',function () {
        formPurchaseBill();
        clearParticular();
        jQuery('#pro_lot_number').focus();

    });

    function calculateParticular() {
        var bag_weight = isNaN(parseFloat(jQuery('.pro_bag_weight_hide').val())) ? 0.00 : parseFloat(jQuery('.pro_bag_weight_hide').val());
        var parchase_as = jQuery('.purchase_as:checked').val();
        var unit = isNaN(parseFloat(jQuery('.pro_bag_count').val())) ? 0.00 : parseFloat(jQuery('.pro_bag_count').val());
        var rate = isNaN(parseFloat(jQuery('.pro_rate_val').val())) ? 0.00 : parseFloat(jQuery('.pro_rate_val').val());
        var total_bags =  (parchase_as =='bag') ?  unit : (unit/bag_weight);
        jQuery('.pro_tot_bags').text(total_bags);
        jQuery('.pro_total').text((unit*rate).toFixed(2));
        jQuery('.pro_total_val').val((unit*rate).toFixed(2));

    }
    function formPurchaseBill() {
        var hsn = jQuery('.pro_hsncode').val();
        var description = jQuery('#pro_lot_number').val();
        var qty = jQuery('.pro_bag_count').val();
        var rate = jQuery('.pro_rate_val').val();
        var per = jQuery('.purchase_as:checked').val();
        var total =  jQuery('.pro_total_val').val();

        var row_tr = "<tr><td>"+hsn+"</td><td>"+description+"</td><td>"+qty+"</td><td>"+rate+"</td><td>"+per+"</td><td>"+total+"</td></tr>";
        jQuery('.purchase_row').append(row_tr);
        calculateTotal();
    }
    function clearParticular() {
        jQuery('#pro_lot_number').val('');
        jQuery('.pro_hsncode').val('');
        jQuery('.pro_bag_weight').text('');
        jQuery('.pro_bag_weight_hide').val('');
        jQuery('.pro_bag_count').val('');
        jQuery('.purchase_as[value=bag]').prop('checked', true);
        jQuery('.pro_rate_val').val('');
        jQuery('.pro_tot_bags').text('');
    }

    function calculateTotal() {
        
    }
</script>