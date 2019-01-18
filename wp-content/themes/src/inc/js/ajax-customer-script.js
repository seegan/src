
jQuery(document).on('change','#add_customer .customer_type',function(){
    var type = jQuery(this).val();

    if(type == 'Wholesale'){
        jQuery('.gst_num_div').css('display','block');
        // console.log(jQuery('.gst_num_div').css('display','block'));
        // console.log(type);
    } else {
        jQuery('.gst_num_div').css('display','none');
    }
    
});


jQuery(document).on('change','#edit_customer .customer_type',function(){
    var type = jQuery(this).val();

    if(type == 'Wholesale'){
        jQuery('.gst_num_div').css('display','block');
        // console.log(jQuery('.gst_num_div').css('display','block'));
        // console.log(type);
    } else {
        jQuery('.gst_num_div').css('display','none');
    }
    
});



jQuery('a.customer_edit').live('click', function(e) {
    e.preventDefault();
    jQuery('#src_info_box').bPopup({
        modalClose: false
    });
});

jQuery('#edit_customer .submit-button').live('click',function () {
    var customer_name = jQuery('#edit_customer #customer_name').val();
    var customer_mobile = jQuery('#edit_customer #customer_mobile').val();
    var customer_address = jQuery('#edit_customer #customer_address').val();
    var customer_type = jQuery('#edit_customer #customer_type').val();
    var customer_id = jQuery('#edit_customer #customer_id').val();

    if(customer_id != '' && customer_name != '' && customer_mobile != '' && validatePhone(customer_mobile) ) {
        customer_edit_submit_popup('post_customer_edit_popup', 'dummy');
    } else {
        alert_popup('<span class="error_msg">Enter the mandatory fields!!</span>', 'Alert!');
    }
});



jQuery('.popup-add-customer').live('click', function() {
    create_popup('get_customer_create_form_popup', 'Add New Customer');
});
jQuery('a.customer_edit').live('click', function() {
    customer_edit_popup('edit_customer_create_form_popup', 'Edit Customer', this);
});


function customer_edit_popup(action= '', title = '', data = '') {

    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            key : 'edit_popup_content',
            action : action,
            id : jQuery(data).data('id'),
            roll_id : jQuery(data).data('roll'),
        },
        success: function (data) {
            jQuery('#popup-title').html(title);
            clear_main_popup();
            jQuery('#popup-content').html(data);
        }
    });
}



function customer_create_submit_popup(action = '', length = 0) {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
        	key : 'post_popup_content',
			data : jQuery("#add_customer").serialize(),
            length : length,
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
                    jQuery('.customer_id_new').val(obj.id);
                    jQuery('.new_billing_customer').val(obj.customer_name);

                    if(jQuery('#billing_no').val() == '') {
                        generateBill(obj.id);
                        checkPaymentDue(obj.id);
                    }
                    

                    clear_main_popup();
                    jQuery('#src_info_box').bPopup().close();
                    alert_popup('<span class="success_msg">Customer Account Created!</span>', 'Success'); 
                }
            } else {

                jQuery('.list_customers').html(data);
                console.log(data.id);
                clear_main_popup();
                jQuery('#src_info_box').bPopup().close();
                alert_popup('<span class="success_msg">Customer Account Created!</span>', 'Success');
                

            }
        }
    });
}


function customer_edit_submit_popup(action = '', data = '') {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            key : 'edit_popup_content',
            data : jQuery("#edit_customer").serialize(),
            action : action
        },
        success: function (data) {
                var obj = jQuery.parseJSON(data);
                if(obj.success == 1) {
                    var update_row = "#customer-data-"+obj.id;
                    jQuery(update_row).html(obj.content);
                    clear_main_popup();
                    jQuery('#src_info_box').bPopup().close();
                    alert_popup('<span class="success_msg">Customer Updated!</span>', 'Success'); 

                } else {
                    alert_popup('<span class="error_msg">Can\'t Edit this data try again!</span>', 'Error');  
                }
        }
    });
}






function validatePhone(txtPhone) {
    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    if (filter.test(txtPhone)) {
        return true;
    }
    else {
        return false;
    }
}

function clear_main_popup() {
	jQuery('#popup-content').html('');   
    jQuery('#popup-content-s').html('');          	
}

function clear_alert_popup() {
	jQuery('#popup-title_alert').html('');
	jQuery('#popup-content_alert .err_message').html('');           	
}

function alert_popup(msg = '', title = '') {
	clear_alert_popup();
	jQuery('#popup-title_alert').html(title);
    if(title == 'Error') {
        jQuery('#popup-content_alert .succ_message').css('display','none');
        jQuery('#popup-content_alert .err_message').css('display','block');

        jQuery('#popup-content_alert .err_message').html(msg);

    }
    if(title = 'Success') {
        jQuery('#popup-content_alert .succ_message').css('display','block');
        jQuery('#popup-content_alert .err_message').css('display','none');

        jQuery('#popup-content_alert .succ_message').html(msg);
    }

	jQuery('#my-button1').click();
}



/*Updated for filter 11/10/16*/
jQuery('.customer_filter #per_page, .customer_filter #customer_name, .customer_filter #customer_mobile_list,.customer_filter #payment_status, .customer_filter #customer_type').live('change', function(){

    var per_page = jQuery('#per_page').val();
    var customer_name = jQuery('#customer_name').val();
    var customer_mobile_list = jQuery('#customer_mobile_list').val();
    var customer_type = jQuery('#customer_type').val();
    var payment_status = jQuery('#payment_status').val();


    jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
          per_page : per_page,
          customer_name : customer_name,
          customer_mobile_list : customer_mobile_list,
          customer_type : customer_type,
          payment_status : payment_status,
          action : 'customer_list_filter'
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

jQuery(document).on('change','#customer_mobile,.billing_mobile',function(){
    var customer_id = (typeof(jQuery('.customer_id').val()) != "undefined" && jQuery('.customer_id').val() !== null )? jQuery('.customer_id').val() : 0 ;
    jQuery.ajax({
        type:"POST",
        url : frontendajax.ajaxurl,
        dataType : "json",
        data : {
            action          : 'PhoneNumberDuplication_ajax',
            phone           : jQuery(this).val(),
            customer_id     : customer_id,
        },
        success : function(data){
            if(data){ console.log(data);
                alert('Phone number Already Exists!');
                jQuery('.customer_mobile').val('');
                jQuery('.billing_mobile').val('');
            }
        }
    });
});

jQuery(document).ready(function(){
    jQuery("#search_from" ).datepicker({dateFormat: "dd-mm-yy"});
    jQuery("#search_to" ).datepicker({dateFormat: "dd-mm-yy"});
});
/*End Updated for filter 11/10/16*/




//From Lot Submit button (tab and shif + tab action)
jQuery(document).on("keydown", "#add_customer .submit-button, #edit_customer .submit-button", function(e) {
  if(event.keyCode == 9) {
    if(event.shiftKey && event.keyCode == 9) {  
       e.preventDefault(); 
      jQuery('input[name ="payment_type"]').focus();
    }
    else { 
      e.preventDefault(); 
      jQuery('#edit_customer #customer_name, #add_customer #customer_name').focus();
    }
  }
});

//From Lot Number (tab and shif + tab action)
jQuery(document).on("keydown", "#edit_customer #customer_name, #add_customer #customer_name", function(e) {
  var keyCode = e.keyCode || e.which; 
  if(event.shiftKey && event.keyCode == 9) {  
     e.preventDefault(); 
    jQuery('#edit_customer .submit-button, #add_customer .submit-button').focus();
  }
});


function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if ((charCode < 48 || charCode > 57))
     return false;

  return true;
}



function isNumberKeyWithDot(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31
        && (charCode < 48 || charCode > 57))
         return false;

    return true;
}
