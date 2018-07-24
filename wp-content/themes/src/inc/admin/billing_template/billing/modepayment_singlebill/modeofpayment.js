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
                    var str1            = '<tr class="payment_cheque"><td style="">' + Capital(type) + '<input type="hidden" name="pay_cheque" value="'+type+'" style="" class="pay_cheque"/></td><td style=""><input type="text" name="pay_amount_cheque" class="pay_amount_cheque" '+ readonly +' value="'+ jQuery('.fsub_total').val() +'" style="" onkeypress="return isNumberKey(event)"/><input type="hidden" name="payment_detail['+current_row+'][reference_screen]" value="billing_screen" /><input type="hidden" name="payment_detail['+current_row+'][reference_id]" value="'+ reference_id +'" /></td><td style="">'+today+'</td><td style=""><a  href="#" class="payment_sub_delete" style="">x</a></td></tr>';
                    jQuery('#bill_payment_tab_cheque').append(str1);  
                }
               
            } else {
                if(type == 'internet'){
                    var type_text   = 'Netbanking';
                } else {
                    var type_text = Capital(type);
                }
                var existing_count  = parseInt( jQuery('#bill_payment_tab tr').length );
                var current_row     = existing_count + 1;
                var str             = '<tr class="payment_table"><td style="padding:5px;">' + type_text + '<input type="hidden" name="payment_detail['+current_row+'][payment_type]" value="'+type+'" style="width:20px;" class="payment_type"/></td><td style="padding:5px;"><input type="text" name="payment_detail['+current_row+'][payment_amount]" class="payment_amount" data-paymenttype="'+type+'"  data-uniqueName="'+makeid()+'" value="" style="width: 74px;" onkeypress="return isNumberKey(event)"/><input type="hidden" name="payment_detail['+current_row+'][reference_screen]" value="billing_screen" /><input type="hidden" name="payment_detail['+current_row+'][reference_id]" value="'+ reference_id +'" /></td><td style="padding"5px;>'+today+'</td><td style="padding:5px;"><a  href="#" class="payment_sub_delete" style="">x</a></td></tr>';                
                jQuery('#bill_payment_tab').append(str);
            }
            payment_calculation();               
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
        payment_calculation();
        jQuery('.paid_amount').trigger('change');
        // jQuery('.payment_amount').trigger('change');
        var uniquename = jQuery(this).parent().parent().find('.payment_amount').data('uniquename');
        deleteDueCash(uniquename);
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
        var current_balance = payment_calculation();
        var amount          = parseFloat(jQuery(this).parent().parent().find('.payment_amount').val());
        var payment_type    = jQuery(this).parent().parent().find('.payment_type').val();
        var sub_tot = 0;
        if( payment_type == 'card' || payment_type == 'internet' ||  payment_type == 'cheque' ){
            if(current_balance >= 0) {
                
            } else {
                alert("Please Enter Amount as less than Total amount!!!");
                parseFloat(jQuery(this).parent().parent().find('.payment_amount').val(0));
                
            }
        }  
        payment_calculation();
        jQuery('.paid_amount').trigger('change');   
        //individualBillPaidCalculation();
        
    });

    jQuery('.cod_check').on('click',function(){
        if(jQuery('.cod_check:checked').val()=='cod'){
            jQuery('.cod_amount_div').css("display","block");
            payment_calculation();
        } else {
            jQuery('.cod_amount_div').css("display","none");
            jQuery('.cod_amount').val('0');
            
        }
    });
});




function payment_calculation(){
    var total           = parseFloat(jQuery('.final_total').val());
    var due             = parseFloat(jQuery('.balance_amount_val').val());
    var total_payment   = due + total;
    var paid_tot = 0;
    jQuery('.payment_table').each(function() {  
        var tot     = parseFloat(jQuery(this).find('.payment_amount').val());
        tot         = isNaN(tot) ? 0 : tot ;
        paid_tot    = paid_tot + tot;       
    });
   

    var total_pay     = total_payment - paid_tot;
    var cur_pay       = total - paid_tot;
    cur_pay = (cur_pay >= 0)? cur_pay : 0 ;
    jQuery('.pay_amount_cheque').val(cur_pay);
    jQuery('.cod_amount').val(cur_pay);
    jQuery('.paid_amount').val(paid_tot);
    jQuery('.paid_amount').trigger('change');
    return total_pay;
}


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



function deleteDueCash(uniquename){
    jQuery('tr.due_data').each(function(){
        jQuery(this).find('[ref-uniquename="'+uniquename+'"]').remove();
        var previous_paid = billBalancePaidIndividual(jQuery(this));
        jQuery(this).find('.paid_due').val(previous_paid);

    });
    //individualBillPaidCalculation();
}