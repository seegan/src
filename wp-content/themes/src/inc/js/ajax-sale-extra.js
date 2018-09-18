
/*Updated for filter 11/10/16*/
jQuery('.billing_list_filter #per_page, .billing_list_filter #invoice_no, .billing_list_filter #customer_name, .billing_list_filter #bill_total, .billing_list_filter #customer_type, .billing_list_filter #shop, .billing_list_filter #delivery, .billing_list_filter #payment_done, .billing_list_filter #date_from, .billing_list_filter #date_to').live('change', function(){

    var per_page = jQuery('#per_page').val();
    var invoice_no = jQuery('#invoice_no').val();
    var customer_name = jQuery('#customer_name').val();
    var bill_total = jQuery('#bill_total').val();
    var customer_type = jQuery('#customer_type').val();
    //var shop = jQuery('#shop').val();
    //var delivery = jQuery('#delivery').val();
    //var payment_done = jQuery('#payment_done').val();
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
          //shop : shop,
          //delivery : delivery,
          //payment_done : payment_done,
          date_from : date_from,
          date_to : date_to,
          action : 'bill_list_filter'
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
    jQuery("#date_from" ).datepicker({dateFormat: "yy-mm-dd"});
    jQuery("#date_to" ).datepicker({dateFormat: "yy-mm-dd"});
});
/*End Updated for filter 11/10/16*/

jQuery('.popup-add-petty-cash').live('click', function() {
    create_popup('get_petty_cash_create_form_popup', 'Add New Customer');
});

jQuery('.popup-add-income').live('click', function() {
    create_popup('get_income_create_form_popup', 'Add New Customer');
});

function petty_cash_create_submit_popup(action = '', data = '') {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            key : 'post_popup_content',
            data : jQuery("#add_petty_cash").serialize(),
            action : action
        },
        success: function (data) {

            if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
            replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
            replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

                var obj = jQuery.parseJSON(data);
                if(obj.success == 0) {
                    alert_popup('<span class="error_msg">Something Went Wrong! try again!</span>', 'Error');
                } else {
                    clear_main_popup();
                    jQuery('#src_info_box').bPopup().close();
                    alert_popup('<span class="success_msg">Salary Updated!</span>', 'Success');   
                }
            } else {
                jQuery('.list_customers').html(data);
                clear_main_popup();
                jQuery('#src_info_box').bPopup().close();
                alert_popup('<span class="success_msg">Salary Updated!</span>', 'Success'); 
            }
        }
    });
}


function income_create_submit_popup(action = '', data = '') {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            key : 'post_popup_content',
            data : jQuery("#add_income").serialize(),
            action : action
        },
        success: function (data) {

            if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
            replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
            replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

                var obj = jQuery.parseJSON(data);
                if(obj.success == 0) {
                    alert_popup('<span class="error_msg">Something Went Wrong! try again!</span>', 'Error');
                } else {
                    clear_main_popup();
                    jQuery('#src_info_box').bPopup().close();
                    alert_popup('<span class="success_msg">Salary Updated!</span>', 'Success');   
                }
            } else {
                jQuery('.list_customers').html(data);
                clear_main_popup();
                jQuery('#src_info_box').bPopup().close();
                alert_popup('<span class="success_msg">Salary Updated!</span>', 'Success'); 
            }
        }
    });
}




jQuery('a.edit_petty_cash').live('click', function(e) {
    e.preventDefault();
    jQuery('#src_info_box').bPopup();
}, function() {
  setTimeout(function() {
      jQuery('#src_info_box').bPopup().reposition();
  }, 200);
});

jQuery('a.edit_petty_cash').live('click', function() {
  edit_popup('edit_petty_cash_create_form_popup', 'Edit Lot', this);
});




jQuery('a.edit_income').live('click', function(e) {
    e.preventDefault();
    jQuery('#src_info_box').bPopup();
}, function() {
  setTimeout(function() {
      jQuery('#src_info_box').bPopup().reposition();
  }, 200);
});

jQuery('a.edit_income').live('click', function() {
  edit_popup('edit_income_create_form_popup', 'Edit Lot', this);
});






jQuery('#edit_petty_cash').live('submit', function(){
    var cash_date = jQuery('#cash_date').val();
    var cash_description = jQuery('#cash_description').val();
    var cash_amount = jQuery('#cash_amount').val();
    var id = jQuery('#id').val();

    if( cash_date != '' && cash_amount != '' ) {
         petty_cash_update_submit_popup('petty_cash_update_submit_popup');
    } else {
         alert_popup('<span class="error_msg">Enter the mandatory fields!!</span>', 'Alert!');
    }
});
function petty_cash_update_submit_popup(action = '', data = '') {

    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            data : jQuery("#edit_petty_cash").serialize(),
            action : action
        },

        success: function (data) {
                var obj = jQuery.parseJSON(data);
                if(obj.success == 1) {
                    var update_row = "#employee-data-"+obj.id;
                    jQuery(update_row).html(obj.content);
                    clear_main_popup();
                    jQuery('#src_info_box').bPopup().close();
                    alert_popup('<span class="success_msg">Petty Cash data updated!</span>', 'Success'); 

                } else {
                    alert_popup('<span class="error_msg">Can\'t Edit this data try again!</span>', 'Error');  
                }
        }

    });
}


jQuery('#edit_income').live('submit', function(){
    var cash_date = jQuery('#cash_date').val();
    var cash_description = jQuery('#cash_description').val();
    var cash_amount = jQuery('#cash_amount').val();
    var id = jQuery('#id').val();

    if( cash_date != '' && cash_amount != '' ) {
         income_update_submit_popup('income_update_submit_popup');
    } else {
         alert_popup('<span class="error_msg">Enter the mandatory fields!!</span>', 'Alert!');
    }
});
function income_update_submit_popup(action = '', data = '') {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            data : jQuery("#edit_income").serialize(),
            action : action
        },

        success: function (data) {
                var obj = jQuery.parseJSON(data);
                if(obj.success == 1) {
                    var update_row = "#employee-data-"+obj.id;
                    jQuery(update_row).html(obj.content);
                    clear_main_popup();
                    jQuery('#src_info_box').bPopup().close();
                    alert_popup('<span class="success_msg">Petty Cash data updated!</span>', 'Success'); 

                } else {
                    alert_popup('<span class="error_msg">Can\'t Edit this data try again!</span>', 'Error');  
                }
        }

    });
}







/*Updated for filter 11/10/16*/
jQuery('.petty_cash_filter #per_page, .petty_cash_filter #entry_amount, .petty_cash_filter #entry_description, .petty_cash_filter #entry_date_from, .petty_cash_filter #entry_date_to').live('change', function(){

    var per_page = jQuery('#per_page').val();
    var entry_amount = jQuery('#entry_amount').val();
    var entry_description = jQuery('#entry_description').val();
    var entry_date_from = jQuery('#entry_date_from').val();
    var entry_date_to = jQuery('#entry_date_to').val();


    jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
          per_page : per_page,
          entry_amount : entry_amount,
          entry_description : entry_description,
          entry_date_from : entry_date_from,
          entry_date_to : entry_date_to,
          action : 'petty_cash_list_filter'
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
    jQuery("#entry_date_from" ).datepicker({dateFormat: "yy-mm-dd"});
    jQuery("#entry_date_to" ).datepicker({dateFormat: "yy-mm-dd"});
});




jQuery('.income_filter #per_page, .income_filter #entry_amount, .income_filter #entry_description, .income_filter #entry_date_from, .income_filter #entry_date_to').live('change', function(){


    var per_page = jQuery('#per_page').val();
    var entry_amount = jQuery('#entry_amount').val();
    var entry_description = jQuery('#entry_description').val();
    var entry_date_from = jQuery('#entry_date_from').val();
    var entry_date_to = jQuery('#entry_date_to').val();


    jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
          per_page : per_page,
          entry_amount : entry_amount,
          entry_description : entry_description,
          entry_date_from : entry_date_from,
          entry_date_to : entry_date_to,
          action : 'income_list_filter'
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
    jQuery("#entry_date_from" ).datepicker({dateFormat: "yy-mm-dd"});
    jQuery("#entry_date_to" ).datepicker({dateFormat: "yy-mm-dd"});
});

/*End Updated for filter 11/10/16*/

