jQuery(document).ready(function(){
  jQuery('.repeterin').each(function(){
    populate_select2(this, 'old');
  });
});


function populate_select2(this_data = '', v) {

  jQuery(this_data).find('.lot_id').select2({
      allowClear: true,
      width: '100%',
      multiple: false,
      minimumInputLength: 1,
      ajax: {
          type: 'POST',
          url: frontendajax.ajaxurl,
          delay: 250,
          dataType: 'json',
          data: function(params) {
            return {
              action: 'get_lot_data_billing', // search term
              page: 1,
              search_key: params.term,
            };
          },
          processResults: function(data) {
            var results = [];
            return {
                results: jQuery.map(data.items, function(obj) {
                    return { id: obj.id, lot_number:obj.lot_number, brand_name: obj.brand_name, product_name:obj.product_name, weight:obj.weight,  slab_system: obj.slab_system, lot_type: obj.lot_type, parent_id: obj.parent_id, par_id:obj.par_id, stock_bal:obj.stock_bal, basic_price:obj.basic_price, stock_alert:obj.stock_alert, hsn_code:obj.hsn_code, gst_percentage:obj.gst_percentage };
                })
            };
          },
          cache: true
      },
    initSelection: function (element, callback) {
        if(v == 'old') {
          callback({ id: jQuery(element).attr('data-dvalue'), lot_number: jQuery(element).attr('data-dtext') });
        } else {
          callback({ id: '', lot_number: '' });
        }
    },

      templateResult: formatState,
      templateSelection: formatState
  }).on("select2:select", function (e) {

      jQuery(this).parent().parent().find('.slab_system_yes input').val('');
      jQuery(this).parent().parent().find('.slab_system_no input').val('');
      jQuery(this).parent().parent().find('.sale_unit_price input').val(0);
      jQuery(this).parent().parent().find('.sale_total_price input').val(0);
      jQuery(this).parent().parent().find('.bagWeightInKg').val(e.params.data.weight);
      

      jQuery(this).parent().parent().attr('lot-id', e.params.data.id);
      jQuery(this).parent().parent().attr('lot-number', e.params.data.lot_number);
      jQuery(this).parent().parent().attr('lot-bagweight', e.params.data.weight);
      jQuery(this).parent().parent().attr('lot-slabsys', e.params.data.slab_system);
      jQuery(this).parent().parent().attr('lot-type', e.params.data.lot_type);
      jQuery(this).parent().parent().attr('lot-brand', e.params.data.brand_name);
      jQuery(this).parent().parent().attr('lot-product', e.params.data.product_name);
      jQuery(this).parent().parent().attr('lot-parent', e.params.data.par_id);
      jQuery(this).parent().parent().attr('stock-avail', e.params.data.stock_bal);
      jQuery(this).parent().parent().attr('hsn-code', e.params.data.hsn_code);
      jQuery(this).parent().parent().attr('gst-percentage', e.params.data.gst_percentage);

      jQuery(this).parent().parent().find('.input_lot_parent').val(e.params.data.par_id);

      jQuery(this).parent().parent().find('.brand_name_data').html(e.params.data.brand_name);
      jQuery(this).parent().parent().find('.product_name_data').html(e.params.data.product_name);
      jQuery(this).parent().parent().find('.unit-price-orig-txt').html(e.params.data.basic_price);
      jQuery(this).parent().parent().find('.unit-price-orig-hidden input').val(e.params.data.basic_price);

      if(e.params.data.slab_system == 1) {
            jQuery(this).parent().parent().find('.slab_system_no').css('display', 'none');
            jQuery(this).parent().parent().find('.slab_system_yes').css('display', 'block');
            jQuery(this).parent().parent().find('.input_lot_slab').val(1);
            jQuery(this).parent().parent().find('.total').val((e.params.data.weight)*1 );
      } else {
            jQuery(this).parent().parent().find('.slab_system_yes').css('display', 'none');
            jQuery(this).parent().parent().find('.slab_system_no').css('display', 'block');
            jQuery(this).parent().parent().find('.input_lot_slab').val(0);

            jQuery(this).parent().parent().find('.weight').val(e.params.data.weight);
            jQuery(this).parent().parent().find('.unit_count').val(1);
            jQuery(this).parent().parent().find('.total').val(e.params.data.weight);
      }
      


        var preSelect = '';
        if(e.params.data.slab_system == 0){
            jQuery(this).parent().parent().find('.sale_as[value="bag"]').prop("checked", true);
            jQuery(this).parent().parent().find('.sale_as').attr("disabled", true);
            preSelect = 'bag';
        }   else {
            jQuery(this).parent().parent().find('.sale_as[value="kg"]').prop("checked", true);
            jQuery(this).parent().parent().find('.sale_as').attr("disabled", false);
            preSelect = 'kg';
        }
        //console.log(jQuery(this).parent().parent().parent().find('input[name="sale_as"][value="'+preSelect +'"]').prop('checked', true));





        //Tooltip Update
        jQuery(this).parent().parent().find('.tooltip').attr('data-stockalert', e.params.data.stock_alert);
        var slab_sys_txt = (e.params.data.slab_system == 1) ? 'yes' : 'no';
        jQuery(this).parent().parent().find('.slab_sys_txt').text(slab_sys_txt);
        jQuery(this).parent().parent().find('.stock_weight_txt').text(e.params.data.stock_bal);


        updateBalanceStock(e.params.data.par_id, e.params.data.stock_bal, e.params.data.stock_alert);

        triggerTotalCalculate(jQuery(this).parent().parent());
    //console.log(jQuery(this).parent().parent())
    //console.log(e.params.data); 

  });

}

function formatState (state) {
  if (!state.id) {
    return state.id;
  }
  var $state = jQuery(
    '<span>' +
      state.lot_number +
    '</span>'
  );
  return $state;
};


//total change trigger
jQuery('.total').live('change', function(){
  var par_id = jQuery(this).parent().parent().parent().parent().parent().attr('lot-parent');
  var stock_bal = jQuery(this).parent().parent().parent().parent().parent().attr('stock-avail');
  var stock_alert = jQuery(this).parent().parent().parent().parent().parent().find('.tooltip').attr('data-stockalert');
  updateBalanceStock(par_id, stock_bal, stock_alert);

  triggerTotalCalculate(jQuery(this).parent().parent().parent().parent().parent());

});

jQuery('.sale_type').live('change', function() {
  /*total calculate on type change*/
  triggerTotalCalculate(jQuery(this).parent().parent().parent().parent());
});

jQuery('.type_bill').live('change', function() {
  /*total calculate on type change*/
  if(jQuery(this).val() == 'original') {
    jQuery(this).parent().parent().parent().parent().removeClass('duplicate');
    jQuery(this).parent().parent().parent().parent().addClass('original');
  } else {
    jQuery(this).parent().parent().parent().parent().removeClass('original');
    jQuery(this).parent().parent().parent().parent().addClass('duplicate');
  }
  triggerTotalCalculate(jQuery(this).parent().parent().parent().parent());
});

jQuery('.type-slider .slide-in').live('click', function(){
  jQuery(this).parent().find('.active').removeClass('active');
  jQuery(this).addClass('active');

  jQuery(this).parent().parent().find("input[type=radio][value="+ jQuery(this).attr('data-stype') +"]").attr('checked', 'checked');
  jQuery(this).parent().parent().find("input[type=radio][value="+ jQuery(this).attr('data-stype') +"]").change();

  jQuery(this).parent().parent().find('.sale_type_h').val(jQuery(this).attr('data-stype'));
});

jQuery('.type-bill-slider .bill-slide-in').live('click', function(){
  jQuery(this).parent().find('.active').removeClass('active');
  jQuery(this).addClass('active');

  jQuery(this).parent().parent().find("input[type=radio][value="+ jQuery(this).attr('data-stype') +"]").attr('checked', 'checked');
  jQuery(this).parent().parent().find("input[type=radio][value="+ jQuery(this).attr('data-stype') +"]").change();

  jQuery(this).parent().parent().find('.type_bill_h').val(jQuery(this).attr('data-stype'));
  jQuery(this).parent().parent().find('.type_bill_s').val(jQuery(this).attr('data-sstype'));
});

//Trigger total when unit price change
jQuery('.unit_price, .unit_price_input').live('change', function(){
  var total_unit = jQuery(this).val();
  var selector = jQuery(this).parent().parent().parent();
//Compare with margin price
  var unit_price = isNaN(parseFloat(jQuery(this).val())) ? 0 : parseFloat(jQuery(this).val());

  var margin_price = isNaN(parseFloat(jQuery(this).parent().parent().parent().find('.margin_price').val())) ? 0 : parseFloat(jQuery(this).parent().parent().parent().find('.margin_price').val());


  if( jQuery(selector).find('.type_bill:radio:checked').val() == 'original' ) {
    if(jQuery(selector).attr('lot-slabsys') == 1) {
      var total_weight = jQuery(selector).find('.slab_system_yes .total').val();
    } else {
      var total_weight = jQuery(selector).find('.slab_system_no .unit_count').val();
    }
  } else {
    var total_weight = jQuery(selector).find('.duplicate_total').val();
  }

  if(unit_price < margin_price){
    alert("Discountant Price dose not less than Margin Price!!!");
    jQuery(this).val(margin_price);
  }
  calculateGST(selector);
});

//unit count change trigger if slab system yes
jQuery('.slab_system_no .unit_count').live('change', function(){
  var bag_count = jQuery(this).val();
  var bag_weight = jQuery(this).parent().find('.weight').val();
  jQuery(this).parent().find('.total').val(bag_count * bag_weight);
  jQuery(this).parent().find('.total').change();
});

function calculateGST(selector) {
  var lot_id = jQuery(selector).attr('lot-id');
  var gst_percentage = jQuery(selector).attr('gst-percentage');
  var sale_type = jQuery(selector).find('.sale_type:checked').val();

  if(jQuery(selector).attr('lot-slabsys') == 1) {
    if(jQuery(selector).find('.sale_as[value="kg"]').attr("checked")) {
      var total_weight = jQuery(selector).find('.slab_system_yes .total').val();
    }
    else{
      var total_weight = jQuery(selector).find('.slab_system_yes .total').val() * jQuery(selector).find('.bagWeightInKg').val();
    }
  } else {
    var total_weight = jQuery(selector).find('.slab_system_no .unit_count').val();
  }
  
  if(jQuery(selector).find('.type_bill:radio:checked').val() == 'duplicate') {
    var total_weight = jQuery(selector).find('.duplicate_total').val();
    var unit_price = jQuery(selector).find('.unit_price_input').val();
  } else {
    var unit_price = jQuery(selector).find('.sale_unit_price .unit_price').val();
  }

  var row_total = total_weight*unit_price;
  var cgst_per = (parseFloat(gst_percentage) / 2).toFixed(2);
  var igst_per = parseFloat(gst_percentage).toFixed(2);

  var diviser         =  parseFloat(100) + parseFloat(gst_percentage) ;
  var tax_less_total  = (row_total *  100)/(diviser);
  var full_gst        = row_total - tax_less_total;

  var row_per_cgst    = (full_gst/2).toFixed(2);
  var row_per_sgst    = (full_gst/2).toFixed(2);
  var row_per_igst    = (row_per_cgst*2).toFixed(2);

  tax_less_total = tax_less_total.toFixed(2);

  row_total = row_total.toFixed(2);
  jQuery(selector).find('.sale_total_price .total_price').val(row_total);

  jQuery(selector).find('.taxless_tot').text(tax_less_total);
  jQuery(selector).find('.taxless_tot_class').val(tax_less_total);

  jQuery(selector).find('.cgst_percentage').text(cgst_per+'%');
  jQuery(selector).find('.cgst_per_tot_class').val(cgst_per);

  jQuery(selector).find('.cgst_value').text(row_per_cgst);
  jQuery(selector).find('.cgst_val_tot_class').val(row_per_cgst);

  jQuery(selector).find('.sgst_percentage').text(cgst_per+'%');
  jQuery(selector).find('.sgst_per_tot_class').val(cgst_per);

  jQuery(selector).find('.sgst_value').text(row_per_sgst);
  jQuery(selector).find('.sgst_val_tot_class').val(row_per_sgst);

  jQuery(selector).find('.igst_percentage').text(igst_per+'%');
  jQuery(selector).find('.igst_per_tot_class').val(igst_per);

  jQuery(selector).find('.igst_value').text(row_per_igst);
  jQuery(selector).find('.igst_val_tot_class').val(row_per_igst);

  updateSaleTotal();
}

/*To Update Balance stock*/
function updateBalanceStock(par_id, total_stock, stock_alert) {

  var used_stock = 0;
  jQuery('[lot-parent="'+par_id+'"].repeterin').each(function(){
    if(jQuery(this).attr('lot-slabsys') == 1) {

      used_stock = parseFloat(used_stock) + parseFloat(jQuery(this).find('.slab_system_yes .total').val(), 10) ;

    } else {
      used_stock = parseFloat(used_stock) + parseFloat(jQuery(this).find('.slab_system_no .total').val(), 10) ;
    }
  });

  var avail_stock = parseFloat(total_stock) - parseFloat(used_stock);
  var tootip_stock_avail_class = '';
  if(avail_stock > stock_alert) {
    tootip_stock_avail_class = 'tootip-black';
  } else if(1 <= avail_stock) {
    tootip_stock_avail_class = 'tootip-yellow';
  } else {
    tootip_stock_avail_class = 'tootip-red';
  }

  jQuery('[lot-parent="'+par_id+'"].repeterin').each(function(){
    jQuery(this).find('.weight_cal_tooltip .tooltip').removeClass('tootip-black tootip-yellow tootip-red').addClass(tootip_stock_avail_class);
    jQuery(this).find('.weight_cal_tooltip .tooltip').find('.stock_weight_txt').text(avail_stock)
  });

}

function triggerTotalCalculate(selector) {

  jQuery('.bill-loader').css('display', 'block');
  var lot_id = jQuery(selector).attr('lot-id');
  var sale_type = jQuery(selector).find('.sale_type:checked').val();
  if(jQuery(selector).attr('lot-slabsys') == 1) {
    if(jQuery(selector).find('.sale_as[value="kg"]').attr("checked")) {
      var total_weight = jQuery(selector).find('.slab_system_yes .total').val();
    }
    else{
      var total_weight = jQuery(selector).find('.slab_system_yes .total').val() * jQuery(selector).find('.bagWeightInKg').val();
    }
  } else {
    var total_weight = jQuery(selector).find('.slab_system_no .total').val();
  }
  
  if(jQuery(selector).find('.type_bill:radio:checked').val() == 'duplicate') {
    var tot_weight = jQuery(selector).find('.duplicate_total').val();
    var unit_price = jQuery(selector).find('.unit_price_input').val();

    calculateGST(selector);
    jQuery('.bill-loader').css('display', 'none');
  } else {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
          action : 'get_price_weight_based',
          lot_id : lot_id,
          sale_type : sale_type,
          total_weight : total_weight,
        },
        success: function (data) {
          var obj = jQuery.parseJSON(data);
          if(obj.success == 1) {
            jQuery(selector).find('.sale_unit_price .unit_price').val(obj.price_detail.price);
            jQuery(selector).find('.sale_margin_price_div_hidden .margin_price').val(obj.price_detail.margin_price);
            jQuery(selector).find('.sale_margin_price_div').text(obj.price_detail.margin_price);
            calculateGST(selector);
          }
          jQuery('.bill-loader').css('display', 'none');
        }
    });
  }
}

function updateSaleTotal() {
  var total = parseFloat(0);
  var discount = parseFloat(jQuery('.discount').val());
  var cardswip = parseFloat(jQuery('.cardswip').val());
  var final_total;

  jQuery('.total_price').each(function(){
    total = total + parseFloat(jQuery(this).val());
  });

  total = total.toFixed(2);
  jQuery('.actual_price').val(total);

  final_total1 = total - discount;
  final_total = (cardswip + final_total1).toFixed(2);

  jQuery('.final_total').val(final_total).change();
//  PayFromPrevoius(final_total,jQuery('.due_bal_input').val());
//    payment_calculation();
    jQuery('.payment_amount').trigger('change');
}

jQuery('.sale_as').live('change',function(){
    triggerTotalCalculate(jQuery(this).parent().parent().parent().parent().parent().parent());

});


jQuery('.discount, .cardswip').live('change', function(){
  updateSaleTotal();
});
