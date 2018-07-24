/*Updated for filter 11/10/16*/
jQuery('.stock_report_filter #per_page, .stock_report_filter #lot_number, .stock_report_filter #search_brand,   .stock_report_filter #search_product, .stock_report_filter #stock_total, .stock_report_filter #sale_total, .stock_report_filter #stock_bal').live('change', function(){

    var per_page = jQuery('#per_page').val();
    var lot_number = jQuery('#lot_number').val();
    var search_brand = jQuery('#search_brand').val();
    var search_product = jQuery('#search_product').val();
    var stock_total = jQuery('#stock_total').val();
    var sale_total = jQuery('#sale_total').val();

    var stock_bal = jQuery('#stock_bal').val();


    jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
          per_page : per_page,
          lot_number : lot_number,
          search_brand : search_brand,
          search_product : search_product,
          stock_total : stock_total,
          sale_total : sale_total,

          stock_bal : stock_bal,
          action : 'stock_report_list'
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





jQuery('.stock_sale_filter #per_page, .stock_sale_filter #lot_number, .stock_sale_filter #search_brand, .stock_sale_filter #search_product, .stock_sale_filter  #date_from, .stock_sale_filter  #date_to, .stock_sale_filter  #item_status, .stock_sale_filter  #bill_type').live('change', function(){

    var per_page = jQuery('#per_page').val();
    var lot_number = jQuery('#lot_number').val();
    var search_brand = jQuery('#search_brand').val();
    var search_product = jQuery('#search_product').val();
    var item_status = jQuery('#item_status').val();
    var bill_type = jQuery('#bill_type').val();

    var date_from = jQuery('#date_from').val();
    var date_to = jQuery('#date_to').val();

    jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
          per_page : per_page,
          lot_number : lot_number,
          search_brand : search_brand,
          search_product : search_product,
          item_status : item_status,
          bill_type : bill_type,
          
          date_from : date_from,
          date_to : date_to,

          action : 'stock_sale_filter_list'
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
/*End Updated for filter 11/10/16*/