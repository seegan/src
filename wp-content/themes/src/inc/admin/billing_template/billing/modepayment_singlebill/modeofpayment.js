jQuery(document).ready(function (argument) {
    jQuery('.payment_cash').live('click',function(){ 
        var today = jQuery('.billing_date').val(); 
        var reference_id = jQuery('#billing_no').val(); 
        jQuery('.payment_tab').css('display','block');
        if(jQuery(this).is(':checked')) {
            var type            = jQuery(this).attr('data-paytype');  
            if(type == 'credit'){  
                var readonly        = 'readonly';
                var existing_count  = parseInt( jQuery('#bill_payment_tab_cheque tr').length );
                var current_row     = existing_count + 1;
                if(current_row == 1){
                    var str1            = '<tr class="payment_cheque"><td style="">' + Capital(type) + '<input type="hidden" name="pay_cheque" value="'+type+'" style="" class="pay_cheque"/></td><td style=""><input type="text" name="pay_amount_cheque" class="pay_amount_cheque" '+ readonly +' value="'+ jQuery('.fsub_total').val() +'" style="width: 106px;" onkeypress="return isNumberKey(event)"/><input type="hidden" name="payment_detail['+current_row+'][reference_screen]" value="billing_screen" /><input type="hidden" name="payment_detail['+current_row+'][reference_id]" value="'+ reference_id +'" /><input type="hidden" name="payment_detail['+current_row+'][unique_name]" value="'+ makeid() +'" /></td><td style="">'+today+'</td><td style=""><a  href="#" class="payment_sub_delete" style="">x</a></td></tr>';
                    jQuery('#bill_payment_tab_cheque').append(str1);  
                }
               
            } 
             else {
                if(type == 'internet'){
                    var type_text   = 'Netbanking';
                } else {
                    var type_text = Capital(type);
                }

                var existing_count  = parseInt( jQuery('#bill_payment_tab tr').length );
                var current_row     = existing_count + 1;
                var str             = '<tr class="payment_table"><td style="padding:5px;">' + type_text + '<input type="hidden" name="payment_detail['+current_row+'][payment_type]" value="'+type+'" style="width:20px;" class="payment_type"/></td><td style="padding:5px;"><input type="text" name="payment_detail['+current_row+'][payment_amount]" class="payment_amount" data-paymenttype="'+type+'"  data-uniqueName="'+makeid()+'" value="" style="width: 74px;" onkeypress="return isNumberKey(event)"/><input type="hidden" name="payment_detail['+current_row+'][reference_screen]" value="billing_screen" /><input type="hidden" name="payment_detail['+current_row+'][unique_name]" value="'+ makeid() +'" /><input type="hidden" name="payment_detail['+current_row+'][reference_id]" value="'+ reference_id +'" /></td><td style="padding"5px;>'+today+'</td><td style="padding:5px;"><a  href="#" class="payment_sub_delete" style="">x</a></td></tr>';                
                jQuery('#bill_payment_tab').append(str);
            }
            paymentOperations();               
        }
     });


    jQuery('.payment_sub_delete').live('click',function(e){
        var sub_tot     = 0;
        if (confirm('Are you sure want to delete?')) {
            jQuery(this).parent().parent().remove();
        }
        e.preventDefault();
        var existing_count  = parseInt( jQuery('#bill_payment_tab tr').length );
        if(existing_count >= 1){
            jQuery('.payment_amount').focus();
        } else{
            jQuery('.payment_cash').focus();
        }
        jQuery('.paid_amount').trigger('change');
        paymentOperations();
    });
    jQuery('.payment_cash').live('keydown', function(e){
        var keyCode = e.keyCode || e.which; 
        if (keyCode == 40) { 
            e.preventDefault();
            jQuery('.payment_amount').focus();
        }
    });

    jQuery('.payment_amount').live('keydown', function(e){
        var keyCode = e.keyCode || e.which; 
        if (keyCode == 38) { 
            e.preventDefault();
            jQuery('.payment_cash').focus();
        }
    });


    jQuery('.payment_amount').live('change',function(){
        paymentOperations(jQuery(this).parent().parent());
    });






});


function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 50; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function Capital(str){
    str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
    return str;
}




function isNumberKey(evt) {
  var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31
        && (charCode < 48 || charCode > 57))
         return false;

    return true;
}


function totalPayment(){
    var paid_tot = 0.00;
    jQuery('.payment_table').each(function() {  
        var tot     = parseFloat(jQuery(this).find('.payment_amount').val());
        tot         = isNaN(tot) ? 0.00 : tot ;
        paid_tot    = paid_tot + tot;       
    });
    var previous_paid = isNaN(parseFloat(jQuery('.previous_paid_total').val())) ? 0.00 : parseFloat(jQuery('.previous_paid_total').val());
    var current_paid = paid_tot - previous_paid;
    return current_paid;
}

function currentDue() {
    var final_total  = isNaN(parseFloat(jQuery('.final_total').val())) ? 0.00 : parseFloat(jQuery('.final_total').val());
    var final_total_hidden = isNaN(parseFloat(jQuery('.final_total_hidden').val())) ? 0.00 : parseFloat(jQuery('.final_total_hidden').val());
    var current_due = isNaN(parseFloat(jQuery('.current_due').val())) ? 0.00 : parseFloat(jQuery('.current_due').val());


    var current_due = (final_total - final_total_hidden) + current_due;

    return current_due;
}

function paymentOperations(selector = false) {


    var total_paid = totalPayment();
    var current_due = currentDue();

    var due_after_pay = total_paid - current_due;

    if(selector != false) {
        var payment_type    = jQuery(selector).find('.payment_type').val();
        if( payment_type == 'card' || payment_type == 'internet' ||  payment_type == 'cheque' ){
            if(due_after_pay > 0) {
                alert("Please Enter Amount as less than Total amount!!!");
                parseFloat(jQuery(selector).find('.payment_amount').val(0));
                paymentOperations();
                return true;
            }
        }
    }
    var current_bill_bal = (current_due - total_paid).toFixed(2);

    if(current_bill_bal > 0) {
        jQuery('.to_pay').val(0);
        jQuery('.cod_amount').val(current_bill_bal);
        jQuery('.balance').val(current_bill_bal);
    } else {
        jQuery('.cod_amount').val(0);
        jQuery('.balance').val(0);
        jQuery('.to_pay').val(Math.abs(current_bill_bal));
    }

}
