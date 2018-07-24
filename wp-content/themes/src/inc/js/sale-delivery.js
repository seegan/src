jQuery(document).ready(function(){ 
  jQuery("#delivery_date" ).datepicker({dateFormat: "dd-mm-yy"});





  jQuery('.delivery_list_filter #per_page, .delivery_list_filter #invoice_no, .delivery_list_filter #customer_name, .delivery_list_filter #bill_total, .delivery_list_filter #customer_type, .delivery_list_filter #shop, .delivery_list_filter #delivery, .delivery_list_filter #payment_done, .delivery_list_filter #date_from, .delivery_list_filter #date_to').live('change', function(){

      var per_page = jQuery('#per_page').val();
      var invoice_no = jQuery('#invoice_no').val();
      var customer_name = jQuery('#customer_name').val();
      var bill_total = jQuery('#bill_total').val();
      var customer_type = jQuery('#customer_type').val();
      var shop = jQuery('#shop').val();
      var delivery = jQuery('#delivery').val();
      var payment_done = jQuery('#payment_done').val();
      var date_from = jQuery('#date_from').val();
      var date_to = jQuery('#date_to').val();


      jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            per_page : per_page,
            invoice_no : invoice_no,
            customer_name : customer_name,
            bill_total : bill_total,
            customer_type : customer_type,
            shop : shop,
            delivery : delivery,
            payment_done : payment_done,
            date_from : date_from,
            date_to : date_to,
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




});



jQuery('.delivery_item').live('click', function(){
    jQuery('.bill-loader').css('display', 'block');
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
          action : 'sale_delivery',
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



