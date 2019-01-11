jQuery(document).ready(function(){ 
  jQuery("#delivery_date" ).datepicker({dateFormat: "dd-mm-yy"});





  jQuery('.delivery_list_filter #per_page, .delivery_list_filter #invoice_no, .delivery_list_filter #customer_name, .delivery_list_filter #customer_type, .delivery_list_filter #delivery_from, .delivery_list_filter #delivery_to').live('change', function(){

      var per_page = jQuery('#per_page').val();
      var invoice_no = jQuery('#invoice_no').val();
      var customer_name = jQuery('#customer_name').val();

      var customer_type = jQuery('#customer_type').val();
     
      var delivery_from = man_to_machine_date_js(jQuery('#delivery_from').val());
      var delivery_to = man_to_machine_date_js(jQuery('#delivery_to').val());


      jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            per_page : per_page,
            invoice_no : invoice_no,
            customer_name : customer_name,
            customer_type : customer_type,
            delivery_from : delivery_from,
            delivery_to : delivery_to,
            action : 'delivery_list_filter'
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



  jQuery('.user_enrty_weight').on('keyup', function () {
    returnCheckDelivery(jQuery(this).parent().parent().parent());
    deliveryWeightCal(jQuery(this).parent().parent().parent());
    
  });
  jQuery('.sale_as').on('change', function () {
    returnCheckDelivery(jQuery(this).parent().parent().parent().parent().parent().parent());
    deliveryWeightCal(jQuery(this).parent().parent().parent().parent().parent().parent());
  });


});
function returnCheckDelivery(selector = ''){
    var return_qty = parseFloat(selector.find('.user_enrty_weight').val());
    console.log(return_qty);
    var return_qty_kg = (selector.find('.sale_as:checked').val() == 'kg') ? parseFloat(return_qty) : parseFloat(selector.find('.bag_weight').val() * return_qty);
    console.log(return_qty_kg);
    var return_avail = parseFloat(selector.find('.delivery_balance').val());
    console.log(return_avail);
    if(return_qty_kg > return_avail ){
        alert('Available stock is '+ return_avail + 'Kg  !!! Enter Quantity as small as avalible stock!!!');
        selector.find('.user_enrty_weight').val(0);
    }
}
function deliveryWeightCal(selector = '') {
  var delivery_as = selector.find('.sale_as:checked').val();
  var delivery_weight = isNaN(parseFloat(selector.find('.user_enrty_weight').val())) ? 0.00 : parseFloat(selector.find('.user_enrty_weight').val());
  var bag_weight = isNaN(parseFloat(selector.find('.bag_weight').val())) ? 0.00 : parseFloat(selector.find('.bag_weight').val());

  if(delivery_as == 'bag') {
    delivery_weight = delivery_weight * bag_weight;
  }

  selector.find('.delivery_sale_as').text(toCapitalize(delivery_as));
  selector.find('.delivery_weight').val(delivery_weight);
}







jQuery('.delivery_item').live('click', function(){
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
          action : 'sale_delivery_aj',
          delivery_data : jQuery('#new_delivery :input').serialize(),
        },
        success: function (data) {
          jQuery('.bill-loader').css('display', 'none');
          var obj = jQuery.parseJSON(data);
          if(obj.success == 1) {
            window.location.replace('admin.php?page=bill_delivery&delivery_id='+obj.delivery_id+'&action=view');
          } else {
            alert('Something went wrong!');
          }
        }
    });   
  } else {
    alert('Please Add Atleast One Item!!! Empty Bill Can'+"'"+'t Submit');
  }

    

});


jQuery('.delivery_item_update').live('click', function(){
    jQuery('.bill-loader').css('display', 'block');
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
          action : 'sale_delivery_update',
          delivery_data : jQuery('#new_delivery :input').serialize(),
        },
        success: function (data) {
          jQuery('.bill-loader').css('display', 'none');
          var obj = jQuery.parseJSON(data);
          if(obj.success == 1) {
            window.location.replace('admin.php?page=bill_delivery&delivery_id='+obj.delivery_id+'&action=view');
          } else {
            alert('Something went wrong!');
          }
        }
    });

});



