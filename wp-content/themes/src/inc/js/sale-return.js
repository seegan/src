jQuery(document).ready(function(){ 
    jQuery("#return_date" ).datepicker({dateFormat: "dd-mm-yy"});

/*Updated for filter 11/10/16*/
jQuery('.return_list_filter #per_page, .return_list_filter #invoice_no, .return_list_filter #customer_name, .return_list_filter #customer_type, .return_list_filter #return_from, .return_list_filter #return_to').live('change', function(){
    var per_page = jQuery('#per_page').val();
    var invoice_no = jQuery('#invoice_no').val();
    var customer_name = jQuery('#customer_name').val();
    var customer_type = jQuery('#customer_type').val();
  
    var return_from = man_to_machine_date_js(jQuery('#return_from').val());
    var return_to = man_to_machine_date_js(jQuery('#return_to').val());


    jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
          per_page : per_page,
          invoice_no : invoice_no,
          customer_name : customer_name,
          customer_type : customer_type,
          return_from : return_from,
          return_to : return_to,
          action : 'return_list_filter'
      },

      success: function (data) {

          if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
          replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
          replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

              var obj = jQuery.parseJSON(data);
              if(obj.success == 0) {
                  alert_popup('<span class="error_msg">Something Went Wrong! try again!</span>', 'Error');
              }
          } else {
              jQuery('.list_customers').html(data);
          }
      }
    });
});



    jQuery('.return_item').live('click', function(){
      var sum = 0;
      jQuery('.user_enrty_weight').each(function(){
        sum += parseFloat(jQuery(this).val());
      });
      if(sum > 0){
        jQuery('.bill-loader').css('display', 'block');
        jQuery.ajax({
            type: "POST",
            url: frontendajax.ajaxurl,
            data: {
              action : 'sale_return',
              return_data : jQuery('#new_return :input').serialize(),
            },
            success: function (data) {
              jQuery('.bill-loader').css('display', 'none');
              var obj = jQuery.parseJSON(data);
              if(obj.success == 1) {
                window.location.replace('admin.php?page=bill_return&return_id='+obj.return_id+'&action=view');
              } else {
                alert('Something went wrong!');
              }
            }
        });
      } else{
         alert('Please Add Atleast One Item!!! Empty Bill Can'+"'"+'t Submit');
      }

    });


    jQuery('.return_item_update').live('click', function(){
        var sum = 0;
        jQuery('.user_enrty_weight').each(function(){
          sum += parseFloat(jQuery(this).val());
        });
      if(sum > 0){
        jQuery('.bill-loader').css('display', 'block');
        jQuery.ajax({
            type: "POST",
            url: frontendajax.ajaxurl,
            data: {
              action : 'sale_return_update',
              return_data : jQuery('#new_return :input').serialize(),
            },
            success: function (data) {
              jQuery('.bill-loader').css('display', 'none');
              var obj = jQuery.parseJSON(data);
              if(obj.success == 1) {
                window.location.replace('admin.php?page=bill_return&return_id='+obj.return_id+'&action=view');
              } else {
                alert('Something went wrong!');
              }
            }
        });
      } else{
         alert('Please Add Atleast One Item!!! Empty Bill Can'+"'"+'t Submit');
      }

    });
    
});
jQuery(document).on('change','.user_enrty_weight_bag',function(){
    user_entry_function(jQuery(this).parent().parent().parent().parent().parent().parent());
    returnCheck(jQuery(this).parent().parent().parent().parent().parent().parent());
});

jQuery(document).on('change','.user_enrty_weight_kg',function(){
    user_entry_function(jQuery(this).parent().parent().parent().parent());
    returnCheck(jQuery(this).parent().parent().parent().parent());
});
function returnCheck(selector = ''){
    var return_qty_kg = isNaN(parseFloat(selector.find('.user_enrty_weight_kg').val()))? 0.00 : parseFloat(selector.find('.user_enrty_weight_kg').val()) ;
    var return_qty_bag = isNaN(parseFloat(selector.find('.user_enrty_weight_bag').val()))? 0.00 : parseFloat(selector.find('.user_enrty_weight_bag').val());
    var return_qty_kg = return_qty_kg +  parseFloat(selector.find('.bag_weight').val() * return_qty_bag);
    console.log(return_qty_kg);
    var return_avail = parseFloat(selector.find('.return_avail').val());
    if(return_qty_kg > return_avail ){
        alert('Available stock is '+ return_avail + 'Kg  !!! Enter Quantity as small as avalible stock!!!');
        selector.find('.user_enrty_weight').val(0);
        selector.find('.user_enrty_weight_kg').val(0);
        selector.find('.user_enrty_weight_bag').val(0);
    }
    returnAmtWeightCal(selector);
}
function user_entry_function(selector = ''){
  var return_weight = 0.00;
  var kg      = isNaN(parseFloat(selector.find('.user_enrty_weight_kg').val())) ? 0.00 : parseFloat(selector.find('.user_enrty_weight_kg').val()) ;  
  var bag     = isNaN(parseFloat(selector.find('.user_enrty_weight_bag').val())) ? 0.00 : parseFloat(selector.find('.user_enrty_weight_bag').val()) ;
  return_weight = kg + bag;
  selector.find('.user_enrty_weight').val(return_weight);
}



function  returnAmtWeightCal(selector = '') {

  //var return_as = selector.find('.sale_as:checked').val();
  var return_weight_kg = isNaN(parseFloat(selector.find('.user_enrty_weight_kg').val())) ? 0.00 : parseFloat(selector.find('.user_enrty_weight_kg').val());
  var return_weight_bag = isNaN(parseFloat(selector.find('.user_enrty_weight_bag').val())) ? 0.00 : parseFloat(selector.find('.user_enrty_weight_bag').val());
  var bag_weight = isNaN(parseFloat(selector.find('.bag_weight').val())) ? 0.00 : parseFloat(selector.find('.bag_weight').val());

    
    return_weight = return_weight_kg + return_weight_bag * bag_weight;

  //selector.find('.delivery_sale_as').text(toCapitalize(return_as));
  selector.find('.return_weight').val(return_weight);

  var gst_from = jQuery(document).find('.gst_from').val();
  var price_per_kg = selector.find('.amt_per_kg').val();

  var gst_percentage = selector.find('.gst_percentage').val();
  var return_price = return_weight*price_per_kg;

  var cgst_per = (parseFloat(gst_percentage) / 2).toFixed(2);
  var igst_per = parseFloat(gst_percentage).toFixed(2);

  var diviser         =  parseFloat(100) + parseFloat(gst_percentage);
  var tax_less_total  = (return_price *  100)/(diviser);
  tax_less_total      = tax_less_total.toFixed(2);
  var full_gst        = return_price - tax_less_total;

  var row_per_cgst    = (full_gst/2).toFixed(2);
  var row_per_sgst    = (full_gst/2).toFixed(2);
  var row_per_igst    = (row_per_cgst*2).toFixed(2);

  selector.find('.taxless_amt_txt').text(tax_less_total);
  selector.find('.taxless_amt').val(tax_less_total);

  selector.find('.cgst_txt').text(row_per_cgst);
  selector.find('.cgst_amt').val(row_per_cgst);

  selector.find('.igst_txt').text(row_per_igst);
  selector.find('.igst_amt').val(row_per_igst);

  return_price = return_price.toFixed(2);
  selector.find('.return_amt_txt').text(return_price);
  selector.find('.return_amt').val(return_price);

  updateReturnTotal();
}




function updateReturnTotal() {
  var total = parseFloat(0);
  var final_total;
  jQuery('.return_amt').each(function(){
    total = total + parseFloat(jQuery(this).val());
  });
  total = parseFloat(total);


//Decimal points
  var radixPos = String(total).indexOf('.');
  var decimal = String(total).slice(radixPos);
 decimal = parseFloat(decimal);
//Minus plus decimal points
if(decimal <= 0.49){ 
  var decimal_point = "-" + decimal; 
} else if( 1 > decimal  && decimal > 0.49 ){
   var decimal_point = "+" + (1 - decimal).toFixed(2); 
} else {
   var decimal_point = 0.00; 
}

//round off
  total = Math.round(total); 



  jQuery('.total_return_txt').text(total.toFixed(2));
  jQuery('.total_return').val(total.toFixed(2));

  jQuery('.return_round_off_txt').text(decimal_point);
  jQuery('.return_round_off').val(decimal_point);

  var previous_to_pay = parseFloat(jQuery('.previous_pay_to_bal').val());
  var current_to_pay = parseFloat(previous_to_pay + total);

  if(current_to_pay > 0){
    jQuery('.return_to_bal_text').text(current_to_pay.toFixed(2));
    jQuery('.return_to_bal').val(current_to_pay.toFixed(2));
    jQuery('.return_to_check').attr('readonly',false);
    jQuery('.return_alert').css('display','none');
  }
  else {
    jQuery('.return_to_bal_text').text(0);
    jQuery('.return_to_bal').val(0);
    jQuery('.return_to_check').attr('checked',false);
    jQuery('.return_to_check').attr('readonly',true);
    jQuery('.return_alert').css('display','block');
  }

}

