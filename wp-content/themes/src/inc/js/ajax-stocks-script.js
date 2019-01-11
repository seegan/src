jQuery('.popup-add-stock').live('click', function() { 
    create_popup('get_stock_create_form_popup', 'Add New Stock');
});

jQuery('a.stock_edit').live('click', function() {
    edit_popup('edit_stock_create_form_popup', 'Edit Stock', this);
});


 jQuery(document).on('focus', '.select2', function (e) {
  if (e.originalEvent) {
    jQuery(this).prev('select').select2('open');    
  } 
});  

jQuery('a.stock_edit').live('click', function(e) {
    e.preventDefault();
    jQuery('#src_info_box').bPopup({
      modalClose: false,
    });
}, function() {
  setTimeout(function() {
      jQuery('#src_info_box').bPopup({
        modalClose: false,
      }).reposition();
  }, 200);
});





/*form submit*/
jQuery('#add_stock').live('submit', function(){
    var lot_id = jQuery('#lot_id').val();
    var stock_count = jQuery('#count').val();
var user_id = jQuery('#user_id').val();

    if(lot_id != '' && stock_count != '' && stock_count > 0) {

         stock_create_submit_popup('stock_create_submit_popup',lot_id,stock_count,user_id);
    } else {
         alert_popup('<span class="error_msg">Enter the mandatory fields!!</span>', 'Alert!');
    }
});


function stock_create_submit_popup(action = '', lot_id = '',stock_count='',user_id='') {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            lot_id : lot_id,
            stock_count : stock_count,
             user_id : user_id,
            action : action
        },
        success: function (data) {

            if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
            replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
            replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

                var obj = jQuery.parseJSON(data);alert(data);
                if(obj.success == 0) {
                    alert_popup('<span class="error_msg">Something Went Wrong! try again!</span>', 'Error');
                } else {
                    clear_main_popup();
                    jQuery('#src_info_box').bPopup().close();
                    alert_popup('<span class="success_msg">Stock Created!</span>', 'Success');   
                }
            } else {
                jQuery('.list_customers').html(data);
                clear_main_popup();
                jQuery('#src_info_box').bPopup().close();
                alert_popup('<span class="success_msg">Stock Created!</span>', 'Success'); 
            }
        }

    });
}



jQuery('#edit_stock').live('submit', function(){
    var stock_id = jQuery('#stock_id').val();
    var count = jQuery('#count').val();
    if(stock_id != '' && count != '' && count > 0 ) {
         stock_update_submit_popup('stock_update_submit_popup');
    } else {
         alert_popup('<span class="error_msg">Enter the mandatory fields!!</span>', 'Alert!');
    }
});


function stock_update_submit_popup(action = '', data = '') {
    var stock_id = jQuery('#stock_id').val();
    var count = jQuery('#count').val();
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            stock_id : stock_id,
            stock_count : count,
            action : action,
        },
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if(obj.success == 1) {
                var update_row = "#customer-data-"+obj.id;

                console.log(update_row);
                jQuery(update_row).html(obj.content);
                clear_main_popup();
                jQuery('#src_info_box').bPopup().close();
                alert_popup('<span class="success_msg">Stock Updated!</span>', 'Success'); 

            } else {
                alert_popup('<span class="error_msg">'+obj.msg+'</span>', 'Error');  
            }
        }

    });
}



/*Updated for filter 11/10/16*/
jQuery('.stock_filter #per_page, .stock_filter #lot_number, .stock_filter #search_brand, .stock_filter #search_product, .stock_filter #search_from, .stock_filter #search_to').live('change', function(){

    var per_page = jQuery('#per_page').val();
    var lot_number = jQuery('#lot_number').val();
    var search_brand = jQuery('#search_brand').val();
    var search_product = jQuery('#search_product').val();
    var search_from = man_to_machine_date_js(jQuery('#search_from').val());
    var search_to = man_to_machine_date_js(jQuery('#search_to').val());


    jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
          per_page : per_page,
          lot_number : lot_number,
          search_brand : search_brand,
          search_product : search_product,
          search_from : search_from,
          search_to : search_to,
          action : 'stock_list_filter'
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






jQuery(document).ready(function(){
    jQuery("#search_from" ).datepicker({dateFormat: "dd-mm-yy"});
    jQuery("#search_to" ).datepicker({dateFormat: "dd-mm-yy"});
});
/*End Updated for filter 11/10/16*/




