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
      initSelection: function (element, callback) {
          callback({ id: jQuery(element).attr('data-dvalue'), customer_name: jQuery(element).attr('data-dtext') });
      },
      templateResult: formatCustomerNameResult,
      templateSelection: formatCustomerName
  }).on("select2:select", function (e) {
    jQuery("input[name=customer_type][value='"+e.params.data.type+"']").attr('checked', 'checked');
    checkPaymentDue(e.params.data.id);


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

/*  jQuery('.print_bill').on('click',function(){
      var inv_id = jQuery(this).attr('data-inv-id');
      var datapass =   home_page.url+'invoice?inv_id='+inv_id;

      // billing_list_single
      var thePopup = window.open( datapass, "Customer Listing","scrollbars=yes,menubar=0,location=0,top=50,left=300,height=500,width=750" );
        thePopup.print();  
  });*/
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
  jQuery.ajax({
    type: "POST",
    dataType: "json",
    url: frontendajax.ajaxurl,
    data: {
      action      : 'check_balance_ajax',
      customer_id  : id,
    },
    success: function (data) 
    { 
      if(data.success) 
      {
        var data = data;
        var i = 1;
        jQuery.each( data, function(a,b) {
          if(b.invoice_id){
              var str1            = '<tr class="bill_payment"><td>'+b.invoice_id+'<input type="hidden" name="prev_pay['+i+'][id]" value="'+b.id+'"/></td><td style="">' + b.pay_to_bal + '<input type="hidden" name="prev_pay['+i+'][pay_to_bal]" value="'+b.pay_to_bal+'" style="" class="pay_to_bal"/></td><td style=""><input type="checkbox" name="prev_pay['+i+'][prev_bal_check]" class="prev_bal_check" /></tr>';
              jQuery('#bill_payment_in_bill').append(str1);  
//              payment_calculation();
              i++;
          }
           
      });

    
      } else{
          jQuery('#bill_payment_in_bill').remove();
        //  payment_calculation();
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
jQuery('.bill_update').live('click', function(){
  jQuery('.bill-loader').css('display', 'block');
  jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
        action : 'update_bill_last',
        bill_data : jQuery('#new_billing :input').serialize(),
      },
      success: function (data) {
          var obj = jQuery.parseJSON(data);
          if(obj.success == 1) {
            window.location.replace('admin.php?page=new_bill&bill_no='+obj.billing_no+'&action=invoice');
          } else {
            alert('Something went wrong!');
            jQuery('.bill-loader').css('display', 'none');
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




