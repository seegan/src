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
        totalPayment();
        jQuery('.paid_amount').trigger('change');
        var uniquename = jQuery(this).parent().parent().find('.payment_amount').data('uniquename');
        deleteDueCash(uniquename);
        PaymentChange(jQuery('.final_total').val(),jQuery('.customer_due').val());
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
        console.log(current_balance);
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
        totalPayment();
        jQuery('.paid_amount').trigger('change');   
        PaymentChange(jQuery('.final_total').val(),jQuery('.customer_due').val());
        
    });

    jQuery('.cod_check').on('click',function(){
        PaymentChange(jQuery('.final_total').val(),jQuery('.customer_due').val());
    });






});


function payment_calculation(){

    var prev_total          = isNaN(parseFloat(jQuery('.final_total_hidden').val())) ? 0 : parseFloat(jQuery('.final_total_hidden').val());
    var current_bill_due    = isNaN(parseFloat(jQuery('.customer_due').val())) ? 0 : parseFloat(jQuery('.customer_due').val());
    var current_total       = isNaN(parseFloat(jQuery('.final_total').val())) ? 0 : parseFloat(jQuery('.final_total').val());
    var actual_total        = current_total- prev_total;
    var pay_amount          = actual_total + current_bill_due;

    // var total           = isNaN(parseFloat(jQuery('.final_total').val())) ? 0 : parseFloat(jQuery('.final_total').val());
    // var due             = isNaN(parseFloat(jQuery('.due_bal_input').val())) ? 0 : parseFloat(jQuery('.due_bal_input').val());
    //var total_payment   = due + total;
    var paid_tot = 0;
    jQuery('.payment_table').each(function() {  
        var tot     = parseFloat(jQuery(this).find('.payment_amount').val());
        tot         = isNaN(tot) ? 0 : tot ;
        paid_tot    = paid_tot + tot;       
    });
   

    var total_pay     = pay_amount - paid_tot;
    var cur_pay       = pay_amount - paid_tot;
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



function isNumberKey(evt)
   {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode < 48 || charCode > 57))
         return false;

      return true;
   }

// function PayFromPrevoius(sale = 0,due = 0){
//     due = isNaN(parseFloat(due))? 0 : parseFloat(due);
//     sale = isNaN(parseFloat(sale))? 0 : parseFloat(sale);

//     var Total_balance = parseFloat(due) - parseFloat(sale);

//     jQuery('.tot_due_txt').text(Total_balance);
//     jQuery('.tot_due').val(Total_balance);
// //Balance
//     jQuery('.balance').val(Total_balance);
//     var pre_bal = 0;
//     if(Total_balance > 0){


// //Cod Checked
//         jQuery('.cod_check').attr('checked',false);
//         jQuery('.cod_check').attr('readonly',true);
//         jQuery('.cod_amount').val(0);


// //To pay

//         jQuery('.to_pay_checkbox').attr('readonly',false);
//         jQuery('.to_pay').val(Total_balance);



// //All payment mode enable readonly
//         jQuery('.payment_cash').attr('readonly',true);
//         jQuery('.payment_table').remove();
//         pre_bal = sale;
//     } else {

// //Cod unChecked
//         jQuery('.cod_check').attr('readonly',false);
//         jQuery('.cod_amount').val(Math.abs(Total_balance));

// //To pay
//         jQuery('.to_pay_checkbox').attr('checked',false);
//         jQuery('.to_pay_checkbox').attr('readonly',true);
//         jQuery('.to_pay').val(0);

// //all payment mode disable readonly
//         jQuery('.payment_cash').attr('readonly',false);
//         pre_bal = (due > 0) ? due: 0;   

//     }
// //    jQuery('.pay_pre_bal').val(pre_bal);
// }

function PaymentChange(sale = 0,due = 0){

    due = isNaN(parseFloat(due)) ? 0 : parseFloat(due);
    sale = isNaN(parseFloat(sale)) ? 0 : parseFloat(sale);
    var paid_tot = 0;
    jQuery('.payment_table').each(function() {  
        var tot     = parseFloat(jQuery(this).find('.payment_amount').val());
        tot         = isNaN(tot) ? 0 : tot ;
        paid_tot    = paid_tot + tot;       
    });
    var Total_balance_new = ( parseFloat(due) + paid_tot ) - parseFloat(sale);
    //Balance
    jQuery('.balance').val(Total_balance_new);
    jQuery('.tot_due_txt').text(Total_balance_new);
    jQuery('.tot_due').val(Total_balance_new);
    var pre_bal = 0;
    if(Total_balance_new > 0){


//Cod Checked
        jQuery('.cod_check').attr('checked',false);
        jQuery('.cod_check').attr('readonly',true);
        jQuery('.cod_amount').val(0);

//To pay

        jQuery('.to_pay_checkbox').attr('readonly',false);
        jQuery('.to_pay').val(Total_balance_new);

    } else {

//Cod unChecked
        jQuery('.cod_check').attr('readonly',false);
        jQuery('.cod_amount').val(Math.abs(Total_balance_new));

//To pay
        jQuery('.to_pay_checkbox').attr('checked',false);
        jQuery('.to_pay_checkbox').attr('readonly',true);
        jQuery('.to_pay').val(0);


    }

}
//for display total
function totalPayment(){
    var paid_tot = 0;
    jQuery('.payment_table').each(function() {  
        var tot     = parseFloat(jQuery(this).find('.payment_amount').val());
        tot         = isNaN(tot) ? 0 : tot ;
        paid_tot    = paid_tot + tot;       
    });
    // var pay_pre_bal = parseFloat(jQuery('.pay_pre_bal').val());
    // jQuery('.payment_total_without_pre').val(paid_tot);
    // jQuery('.payment_total').val(paid_tot + pay_pre_bal);
}