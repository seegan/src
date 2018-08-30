jQuery(document).ready(function(){

  jQuery('#billing_customer').select2({
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
              action: 'get_customer_name', // search term
              page: 1,
              search_key: params.term,
            };
          },
          processResults: function(data) {
            var results = [];
            return {
                results: jQuery.map(data.result, function(obj) {
                    return { id: obj.id, customer_name: obj.name, mobile: obj.mobile, type: obj.type.toLowerCase() };
                })
            };
          },
          cache: true
      },
      templateResult: formatCustomerNameResult,
      templateSelection: formatCustomerName
  }).on("select2:select", function (e) {
    jQuery("input[name=customer_type][value='"+e.params.data.type+"']").attr('checked', 'checked');
    checkPaymentDue(e.params.data.id);
    generateDeliveryAddress(e.params.data.id);

  });


  jQuery('.bill_by').click(function(){
    var bill_by = jQuery('.bill_by:checked').val();
    if(bill_by == 'yes') {
      jQuery('.by-customer').css('display','block');
      jQuery('.by-counter').css('display','none');
    } else {
      jQuery('.by-counter').css('display','block');
      jQuery('.by-customer').css('display','none');
    }
  });

  jQuery('.gst_type').on('change', function(){
    var gst_type = jQuery(this).val();
    callGSTChange(gst_type);
  });

  jQuery('.billing_date').on('change', function(){
    var bill_date = jQuery(this).val();
    jQuery.ajax({
      type: "POST",
      dataType: "json",
      url: frontendajax.ajaxurl,
      data: {
        action      : 'generateInvoice_aj',
        bill_date  : bill_date,
      },
      success: function (data) {
        jQuery('#invoice_id').val('INV'+data.invoice_id);
        jQuery('#billing_no').val(data.id);

      }
    });
  });






  jQuery('.customer_info_bar .deliveried_all').on('change', function () {
    if(this.checked) {
      var returnVal = confirm("Are you sure?");
      jQuery(this).prop("checked", returnVal); 
      if(returnVal) {
        jQuery.ajax({
          type: "POST",
          dataType: "json",
          url: frontendajax.ajaxurl,
          data: {
            action     : 'delveryall_aj',
            bill_no  : jQuery('.delivery_bill_no').val(),
          },
          success: function (data) {

          }
        });
      }     
    }
  });

});

function callGSTChange(gst_type='') {
  if(gst_type == 'cgst') {
    jQuery('.cgst_display').removeClass('no_display');
    jQuery('.nogst_exclude').removeClass('no_display');
    jQuery('.igst_display').addClass('no_display');
  }
  if(gst_type == 'igst') {
    jQuery('.igst_display').removeClass('no_display');
    jQuery('.nogst_exclude').removeClass('no_display');
    jQuery('.cgst_display').addClass('no_display');
  }
  if(gst_type == 'no_gst') {
    jQuery('.cgst_display').addClass('no_display');
    jQuery('.igst_display').addClass('no_display');
    jQuery('.nogst_exclude').addClass('no_display');
  }
}

function formatCustomerName (state) {
  if (!state.id) {
    return state.id;
  }
  var $state = jQuery(
    '<span>' +
      state.customer_name +
    '</span>'
  );
  return $state;
};

function formatCustomerNameResult(data) {
  if (!data.id) { // adjust for custom placeholder values
    return 'Searching ...';
  }
  var $state = jQuery(
    '<span>Name : ' +
      data.customer_name +
    '</span>' +
    '<br><span> Mobile : ' +
      data.mobile +
    '</span>'
  );
  return $state;
}


function checkPaymentDue(id = 0) {
  customerBalance(id);

  var sale_id = jQuery('#billing_no').val();
  jQuery.ajax({
    type: "POST",
    dataType: "json",
    url: frontendajax.ajaxurl,
    data: {
      action      : 'getCustomerBillBalance',
      customer_id  : id,
    },
    success: function (data) { 
    
      if(data.success == 1) 
      {
        jQuery('.payment_tab_current_screen').css('display','block');
        var i = 1;
        jQuery.each( data.result, function(a,b) {
          if(b.invoice_id && b.id != sale_id){
              var str1            = '<tr class="bill_payment"><td>'+b.invoice_id+'<input type="hidden" name="prev_pay['+i+'][id]" value="'+b.id+'" class="prev_pay_id"/></td><td style="">' + Math.abs(b.customer_pending) + '<input type="hidden" name="prev_pay['+i+'][pay_to_bal]" value="'+ Math.abs(b.customer_pending)+'" style="" class="pay_to_bal"/></td><td style=""><input type="checkbox" name="prev_pay['+i+'][prev_bal_check]" class="prev_bal_check" /></tr>';
              jQuery('#bill_payment_in_bill').append(str1);  
              //payment_calculation();
              i++;
          }
           
        });
      } else{
          jQuery('#bill_payment_in_bill').remove();
          jQuery('.payment_tab_current_screen').css('display','none');
      }
    }

  });
}

function customerBalance(customer_id = 0){
    jQuery.ajax({
        type: "POST",
        dataType : "json",
        url: frontendajax.ajaxurl,
        data: {
            id      : customer_id,
            action  :'customer_balance'
        },
          success: function (data) {
            jQuery('.due_bal').text(data.final_bal);
            jQuery('.due_bal_input').val(data.final_bal);
            //rowCalculate();

        }
    });
}

jQuery('.bill_submit').live('click', function(){
    jQuery('.bill-loader').css('display', 'block');
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
          action : 'update_bill',
          bill_data : jQuery('#new_billing :input').serialize(),
        },
        success: function (data) {
          var obj = jQuery.parseJSON(data);
          if(obj.success == 1) {
            window.location.replace('admin.php?page=new_bill&bill_no='+obj.billing_no+'&action=invoice');
          } else {
            jQuery('.bill-loader').css('display', 'none');
            alert('Something went wrong!');
          }
        }
    });
});

jQuery('#ck_stk_available').live('click', function(){
  if(jQuery('.stock_ck_avail_box').hasClass('active') == true) {
    jQuery('.stock_ck_avail_box').removeClass('active');
    jQuery('.stock_ck_avail_box').addClass('active-n');
  } else {
    jQuery('.stock_ck_avail_box').removeClass('active-n');
    jQuery('.stock_ck_avail_box').addClass('active');
  }
});

jQuery('#close_check_availa_box').live('click', function(){
  jQuery('.stock_ck_avail_box').removeClass('active');
  jQuery('.stock_ck_avail_box').addClass('active-n');
});

  //New Old User Change inside Bill
  jQuery('.new_user_a').live('click', function() {
    jQuery('.new_user_a,.customer_old').css('display', 'none');
    jQuery('.old_user_a,.customer_new').css('display', 'block');
    jQuery('.popup-add-customer').trigger('click');
    jQuery('.user_type').val('new'); 
  });

  jQuery('.old_user_a').live('click', function() {
    jQuery('.new_user_a,.customer_old').css('display', 'block');
    jQuery('.new_user, .old_user_a,.customer_new').css('display', 'none');
    jQuery('.user_type').val('old');
  });
