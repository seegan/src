jQuery(document).ready(function(){


  jQuery('#billing_customer_due').select2({
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
    jQuery("#due_tab_cd").empty();
     duePaidCusCd(e.params.data.id);  
    jQuery('.description').focus();

  });

  jQuery('.filter-section :input').on('change', function(){
        var filter_action   = jQuery('.filter_action').val();
        var container_class = '.'+filter_action;

        jQuery.ajax({
            type: "POST",
            url: frontendajax.ajaxurl,
            data: {
                action : filter_action,
                data : jQuery('.filter-section :input').serialize()
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
                    jQuery(container_class).html(data);
                }
            }
        });
    });
    jQuery('#billing_customer_due').select2('open');
    jQuery(".credit_submit").on('keydown',  function(e) { 
      var keyCode = e.keyCode || e.which; 
       if(event.shiftKey && event.keyCode == 9) {  
         e.preventDefault(); 
        jQuery('.payment_sub_delete_cd').focus();
      }
      else if (keyCode == 9) { 
        e.preventDefault(); 
        jQuery('.billing_customer_due').focus();
      } 
      else {
        jQuery('.credit_submit').focus();
      }
    });

  jQuery(document).on("keydown", ".select2-search__field", function(e) {
    if(event.keyCode == 9) {
      if(event.shiftKey && event.keyCode == 9) {  
         e.preventDefault(); 
         jQuery('.credit_submit').focus();
      }
      else { 
        e.preventDefault();
        jQuery('.description').focus();
      }
    }
  });

    jQuery.validator.setDefaults({
      debug: true,
      success: "valid"
    });

  jQuery(".customer_type").on('change',function(){
    jQuery( ".creditdebit_customer").val('');
    jQuery( "#creditdebit_cus_id").val(0);
  });




	
jQuery("#create_creditdebit").bind('submit', function (e) {
    var length_type = jQuery('#bill_payment_tab_cd tr').length;
    var prevent = jQuery(".form_submit_prevent_credit").val();
    if( prevent == "off" && length_type > 0) {
        jQuery(".form_submit_prevent_credit").val('on');
        jQuery('#lightbox').css('display','block');
        jQuery.ajax({
            type: "POST",
            dataType : "json",
             url: frontendajax.ajaxurl,
            data: {
              action : jQuery('.creditdebit_action').val(),
              data : jQuery('#create_creditdebit :input').serialize()
            },
            success: function (data) {
                    window.location.replace('admin.php?page=credit_debit');
                jQuery("#create_creditdebit")[0].reset();
            }
        });
    } else{
        alert('Please fill all mandatory fields!!!');
    }
    e.preventDefault();
    return false;
});



//<-------Delete------->

jQuery('.delete-creditdebit').live( "click", function() {
    if(confirm('Are you sure you want to delete this element?')){
        var data=jQuery(this).attr("data-id");
        var type=jQuery(this).attr("data-type");
       
        window.location.replace('admin.php?page=credit_debit&delete_id='+data+'&action=delete&type='+type);
    }
});
  //<-------End Delete------->

  //<----- Payment type JS------>
jQuery('.payment_cash_cd').live('click',function(){
    var today = jQuery('#creditdebit_date').val(); 
    jQuery('.payment_tab_cd').css('display','block');
    if(jQuery(this).is(':checked')) {
        var type            = jQuery(this).attr('data-paytype'); 
        var existing_count  = parseInt( jQuery('#bill_payment_tab_cd tr').length );
        var current_row     = existing_count + 1;
        if(type == 'internet'){
                var type_text   = 'Netbanking';
            } else{
                var type_text = Capital(type);
            }
        var str             = '<tr class="payment_table_cd"><td style="padding:5px;">' + type_text + '<input type="hidden" name="payment_detail['+current_row+'][payment_type]" value="'+type+'" style="width:20px;" class="payment_type_cd"/></td><td style="padding:5px;"><input type="text" name="payment_detail['+current_row+'][payment_amount]" class="payment_amount_cd" data-paymenttype="'+type+'"  data-uniqueName="'+makeid()+'" value="" style="width: 74px;" onkeypress="return isNumberKeyWithDot(event)"/></td><td style="padding"5px;>'+today+'</td><td style="padding:5px;"><a  href="#" class="payment_sub_delete_cd" style="">x</a></td></tr>';                
        jQuery('#bill_payment_tab_cd').append(str);    
    }
 });
jQuery('.payment_amount_cd').live('keydown', function(e){
    var keyCode = e.keyCode || e.which; 
    if (keyCode == 38) { 
        e.preventDefault();
        jQuery('.payment_cash_cd').focus();
    }
});
jQuery('.payment_cash_cd').live('keydown', function(e){
    var keyCode = e.keyCode || e.which; 
    if (keyCode == 40) { 
        e.preventDefault();
        jQuery('.payment_amount_cd').focus();
    }
});

jQuery('.payment_amount_cd').live('change',function(){
    var current_balance = payment_calculation_cd();
    var amount          = parseFloat(jQuery(this).parent().parent().find('.payment_amount_cd').val());
    var payment_type    = jQuery(this).parent().parent().find('.payment_type_cd').val();
    var sub_tot = 0;
    if(payment_type == 'cash' || payment_type == 'card' ){
        if(amount == '0'){
            alert("This mode of payment value should not be zero!!!");
            parseFloat(jQuery(this).parent().parent().find('.payment_amount_cd').val('1'));  
        }
    } 
    if(current_balance < 0 && payment_type!= 'cash') {
        alert("Please Enter Amount as less than Due amount!!!");
        parseFloat(jQuery(this).parent().parent().find('.payment_amount_cd').val(''));      
    }      
    individualBillPaidCalculationCd();
    calPayto();

});
jQuery('.payment_sub_delete_cd').live('click',function(e){
    var sub_tot     = 0;
    if (confirm('Are you sure want to delete?')) {
        jQuery(this).parent().parent().remove();
    }
    e.preventDefault();
    jQuery('.payment_amount_cd').focus();

    var uniquename = jQuery(this).parent().parent().find('.payment_amount_cd').data('uniquename');
    deleteDueCashCd(uniquename);  
});





});

function payment_calculation_cd(){
    var total_due   = parseFloat(jQuery('.total_due').val());
    var paid_tot = 0;
    jQuery('.payment_table_cd').each(function() {  
        var tot     = parseFloat(jQuery(this).find('.payment_amount_cd').val());
        tot         = isNaN(tot) ? 0 : tot ;
        paid_tot    = paid_tot + tot;       
    });
    var total_pay     = total_due - paid_tot;
    return total_pay;
}

function duePaidCusCd(customer = 0){
  
        var action = 'checkCustomerBalanceAjax';
        jQuery.ajax({
            type: "POST",
            dataType : "json",
            url: frontendajax.ajaxurl,
            data: {
                id                  : customer,
                action              : action,
                reference_id        : jQuery('.creditdebit_id').val(),
                reference_screen    : jQuery('.creditdebit_screen').val(),
            },
            success: function (data) {
                var total_due = parseFloat(0);
                if(data){
                    jQuery.each( data, function(a,b) { 
                      var existing_count  = parseInt( jQuery('#due_tab_cd tr').length );
                      var current_row     = existing_count + 1; 
                      var customer_pending    = parseFloat(b.customer_pending);
                      var current_screen_paid = parseFloat(b.current_screen_paid);
                      var current_screen_pending = current_screen_paid + customer_pending;

                      if(current_screen_paid >0 && customer_pending < 0) {
                        current_screen_pending = current_screen_paid;
                      }

                      if(current_screen_paid > 0 || customer_pending > 0) {
                        var tab_data = '<tr class="due_data_cd"><td style="padding:5px;">' + b.id + '<input type="hidden" name="due_detail['+current_row+'][due_id]" value="'+b.id+'" style="width:20px;" class="due_id_cd"/><input type="hidden" name="due_detail['+current_row+'][due_search_id]" value="'+b.invoice_id+'" style="width:20px;" class="due_search_id_cd"/><input type="hidden" name="due_detail['+current_row+'][due_year]" value="'+b.financial_year+'" style="width:20px;" class="due_year_cd"/><input type="hidden" name="due_detail['+current_row+'][type_payment]" class="type_payment_cd" value="due"/></td><td style="padding:5px;"><span class="actual_due">' + customer_pending + '</span><input type="hidden" name="due_detail['+current_row+'][due_amount]" value="'+current_screen_pending+'" style="width:20px;" class="due_amount_cd"/></td><td style="padding:5px;"><input type="text" name="due_detail['+current_row+'][paid_due]" class="paid_due_cd" tabindex="-1" value="" readonly style="width: 74px;" onkeypress="return isNumberKeyWithDot(event)"/><input type="hidden" name="paid_due_hidden" class="paid_due_hidden_cd" value="0"/></td><td><table class="duePaymentType_cd"></table></td></tr>';
                        jQuery('#due_tab_cd').append(tab_data);
                      }
                      total_due = current_screen_pending + total_due;

                    }); 
                jQuery('.total_due_text').text(total_due);                 
                jQuery('.total_due').val(total_due); 
                setTimeout( function(){ 
                    individualBillPaidCalculationCd();
                }  , 50 );

                } else{
                    jQuery("#due_tab_cd").empty();
                }
            }
        });

}




function deleteDueCashCd(uniquename){
    jQuery('tr.due_data_cd').each(function(){
        jQuery(this).find('[ref-uniquename="'+uniquename+'"]').remove();
        var previous_paid = billBalancePaidIndividualCd(jQuery(this));
        jQuery(this).find('.paid_due_cd').val(previous_paid);
    });
    individualBillPaidCalculationCd();
    calPayto();
}

function individualBillPaidCalculationCd(){

    jQuery('.payment_amount_cd').each(function(){

        var pay_type        = jQuery(this).data('paymenttype');
        if(pay_type == 'internet'){
            var type_text   = 'Netbanking';
        } else{
            var type_text = Capital(pay_type);
        }
        var uniquename      = jQuery(this).data('uniquename');
        var current_pay     = isNaN(parseFloat(jQuery(this).val())) ? 0 : parseFloat(jQuery(this).val());
        var pay_now         = current_pay;       
        //loop 1 bal
        var bal = current_pay;
        jQuery('tr.due_data_cd').find('[ref-uniquename="'+uniquename+'"]').remove();
        //LOOP 2
        jQuery('tr.due_data_cd').each(function(){
            //Delete code here
            var id                      = jQuery(this).find('.due_id_cd').val();
            var inv_id                  = jQuery(this).find('.due_search_id_cd').val();
            var year                    = jQuery(this).find('.due_year_cd').val();
            var due_amount              = jQuery(this).find('.due_amount_cd').val();
            var type_payment            = jQuery(this).find('.type_payment_cd').val();
            var previous_paid           = billBalancePaidIndividualCd(jQuery(this));     
            var bill_due                = jQuery(this).find('.due_amount_cd').val() ? parseFloat(jQuery(this).find('.due_amount_cd').val()) : 0;
            var due_paid                = jQuery(this).find('.paid_due_hidden_cd').val() ? parseFloat(jQuery(this).find('.paid_due_hidden_cd').val()) : 0;
            due_paid                    = due_paid+previous_paid;          
            var current_row_pay_total   = bal+due_paid;
            if(bill_due >= current_row_pay_total) {

                jQuery(this).find('.paid_due_cd').val(current_row_pay_total);
                dueRowBalanceChange(jQuery(this));
                if(bal != 0) {
                  var str = '<tr class="aa" ref-uniquename="'+uniquename+'"><td class="ab">'+ type_text +' - ' + bal +'<input type="hidden" readonly ref-uniquename="'+uniquename+'" ref-paytype="'+pay_type+'" class="row_cash_paid_cd" tabindex="-1" name="duepayAmount[]['+type_payment+']" value="'+bal+'"></td><input type="hidden" name="duepayUniquename[]['+type_payment+']" value="'+uniquename+'"/><input type="hidden" name="duePaytype[]['+type_payment+']" value="'+pay_type+'" readonly/><input type="hidden" name="dueId[]['+type_payment+']" value="'+id+'"/><input type="hidden" name="dueYear[]['+type_payment+']" value="'+year+'"/><input type="hidden" name="dueInvid[]['+type_payment+']" value="'+inv_id+'"/><input type="hidden" name="dueDueAmount[]['+type_payment+']" value="'+due_amount+'"/></tr>';
                  jQuery(this).find('.duePaymentType_cd').append(str);
                }
                bal = 0;
            } else {
                var current_pay = ((bill_due - due_paid));
                jQuery(this).find('.paid_due_cd').val(bill_due);
                dueRowBalanceChange(jQuery(this));
                if(current_pay != 0 ){
                    var str = '<tr class="aa" ref-uniquename="'+uniquename+'"><td class="ab">'+ type_text +' - ' + current_pay +'<input type="hidden" readonly ref-uniquename="'+uniquename+'" ref-paytype="'+pay_type+'" class="row_cash_paid_cd" tabindex="-1" name="duepayAmount[]['+type_payment+']" value="'+current_pay+'"></td><input type="hidden" name="duepayUniquename[]['+type_payment+']" value="'+uniquename+'"/><input type="hidden" name="duePaytype[]['+type_payment+']" value="'+pay_type+'" readonly/><input type="hidden" name="dueId[]['+type_payment+']" value="'+id+'"/><input type="hidden" name="dueYear[]['+type_payment+']" value="'+year+'"/><input type="hidden" name="dueInvid[]['+type_payment+']" value="'+inv_id+'"/><input type="hidden" name="dueDueAmount[]['+type_payment+']" value="'+due_amount+'"/></tr>';
                    jQuery(this).find('.duePaymentType_cd').append(str);    
                }
                bal = bal-current_pay;
            }
           
        });  
    }); 
  calPayto();
}

function dueRowBalanceChange(selector = '') {
  var due_from_screen = parseFloat(jQuery(selector).find('.due_amount_cd').val());
  var paid_due = parseFloat(jQuery(selector).find('.paid_due_cd').val());
  var actual_due = due_from_screen-paid_due;
  jQuery(selector).find('.actual_due').text(actual_due);
}




function billBalancePaidIndividualCd(selector) {
    var sum = 0;
    jQuery(selector).find('.row_cash_paid_cd').each(function(){
        sum += parseFloat(this.value);
    });
    return sum;
}
function calPayto(){
    var due_amount = parseFloat(jQuery('.total_due').val());
    var payto = 0;
    var paid_amt = 0;
    jQuery('.payment_amount_cd').each(function(){ 
        paid_amt += isNaN(parseFloat(jQuery(this).val())) ? 0 : parseFloat(jQuery(this).val());;
    });
    if(due_amount < paid_amt){
       payto = paid_amt-due_amount;
       jQuery('.to_pay_amt_cd').val(payto);
       jQuery('.current_bal_txt_cd').text(payto);
       jQuery('.total_due_text').text(0);
    } else{
        current_due = due_amount - paid_amt;
        jQuery('.to_pay_amt_cd').val(0);
        jQuery('.current_bal_txt_cd').text(0);
        jQuery('.total_due_text').text(current_due);
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

function clearPopup() {
    jQuery('.popup_header').html('');
    jQuery('.popup_container').html('');
}

jQuery(document).ready(function(){
    jQuery(".creditdebit_date" ).datepicker({dateFormat: "dd-mm-yy"});
    jQuery(".date").datepicker({dateFormat: "dd-mm-yy"});
});