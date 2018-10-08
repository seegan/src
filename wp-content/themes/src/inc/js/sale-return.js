jQuery(document).ready(function(){ 
    jQuery("#return_date" ).datepicker({dateFormat: "dd-mm-yy"});




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


    jQuery('.return_table .sale_as').on('change', function () {
      returnAmtWeightCal(jQuery(this).parent().parent().parent().parent().parent().parent().parent());
      returnCheck(jQuery(this).parent().parent().parent().parent().parent().parent().parent())
    });
    jQuery('.return_table .user_enrty_weight').on('keyup', function(){
      returnCheck(jQuery(this).parent().parent().parent().parent());
      returnAmtWeightCal(jQuery(this).parent().parent().parent().parent());
     

    });
    jQuery('.return_table .amt_per_kg').on('keyup', function(){
      returnAmtWeightCal(jQuery(this).parent().parent());
    });
});

function returnCheck(selector = ''){
    var return_qty = parseFloat(selector.find('.user_enrty_weight').val());
    var return_qty_kg = (selector.find('.sale_as:checked').val() == 'kg') ? parseFloat(return_qty) : parseFloat(selector.find('.bag_weight').val() * return_qty);
    var return_avail = parseFloat(selector.find('.return_avail').val());
    if(return_qty_kg > return_avail ){
        alert('Available stock is '+ return_avail + 'Kg  !!! Enter Quantity as small as avalible stock!!!');
        selector.find('.user_enrty_weight').val(0);
    }
}

function  returnAmtWeightCal(selector = '') {

  var return_as = selector.find('.sale_as:checked').val();
  var return_weight = isNaN(parseFloat(selector.find('.user_enrty_weight').val())) ? 0.00 : parseFloat(selector.find('.user_enrty_weight').val());
  var bag_weight = isNaN(parseFloat(selector.find('.bag_weight').val())) ? 0.00 : parseFloat(selector.find('.bag_weight').val());

  if(return_as == 'bag') {
    return_weight = return_weight * bag_weight;
  }
  selector.find('.delivery_sale_as').text(toCapitalize(return_as));
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

