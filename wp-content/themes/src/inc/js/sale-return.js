jQuery(document).ready(function(){ 
    jQuery("#return_date" ).datepicker({dateFormat: "dd-mm-yy"});




    jQuery('.return_item').live('click', function(){
        jQuery('.bill-loader').css('display', 'block');
        jQuery.ajax({
            type: "POST",
            url: frontendajax.ajaxurl,
            data: {
              action : 'sale_return',
              return_data : jQuery('#new_return :input').serialize(),
            },
            success: function (data) {
              jQuery('.bill-loader').css('display', 'none');
              var obj = jQuery.parseJSON(data);
              if(obj.success == 1) {
                window.location.replace('admin.php?page=bill_return&return_id='+obj.return_id+'&action=view');
              } else {
                alert('Something went wrong!');
              }
            }
        });

    });


    jQuery('.return_item_update').live('click', function(){
        jQuery('.bill-loader').css('display', 'block');
        jQuery.ajax({
            type: "POST",
            url: frontendajax.ajaxurl,
            data: {
              action : 'sale_return_update',
              return_data : jQuery('#new_return :input').serialize(),
            },
            success: function (data) {
              jQuery('.bill-loader').css('display', 'none');
              var obj = jQuery.parseJSON(data);
              if(obj.success == 1) {
                window.location.replace('admin.php?page=bill_return&return_id='+obj.return_id+'&action=view');
              } else {
                alert('Something went wrong!');
              }
            }
        });

    });




    jQuery('.return_table .return_weight').on('change', function () {

      var gst_from = jQuery('.gst_from').val();

      var return_weight = jQuery(this).val();
      var selector = jQuery(this).parent().parent().parent().parent();
      var price_per_kg = jQuery(selector).find('.amt_per_kg').val();
      var gst_percentage = jQuery(selector).find('.gst_percentage').val();

      var return_price = return_weight*price_per_kg;

      var cgst_per = (parseFloat(gst_percentage) / 2).toFixed(2);
      var igst_per = parseFloat(gst_percentage).toFixed(2);

      var diviser         =  parseFloat(100) + parseFloat(gst_percentage) ;
      var tax_less_total  = (return_price *  100)/(diviser);
      tax_less_total      = tax_less_total.toFixed(2);
      var full_gst        = return_price - tax_less_total;

      var row_per_cgst    = (full_gst/2).toFixed(2);
      var row_per_sgst    = (full_gst/2).toFixed(2);
      var row_per_igst    = (row_per_cgst*2).toFixed(2);

      jQuery(selector).find('.taxless_amt_txt').text(tax_less_total);
      jQuery(selector).find('.taxless_amt').val(tax_less_total);

      jQuery(selector).find('.cgst_txt').text(row_per_cgst);
      jQuery(selector).find('.cgst_amt').val(row_per_cgst);

      jQuery(selector).find('.igst_txt').text(row_per_igst);
      jQuery(selector).find('.igst_amt').val(row_per_igst);

      return_price = return_price.toFixed(2);
      jQuery(selector).find('.return_amt_txt').text(return_price);
      jQuery(selector).find('.return_amt').val(return_price);

      updateReturnTotal();
    })
});


function updateReturnTotal() {
  var total = parseFloat(0);
  var final_total;
  jQuery('.return_amt').each(function(){
    total = total + parseFloat(jQuery(this).val());
  });
  total = total.toFixed(2);

  jQuery('.total_return_txt').text(total);
  jQuery('.total_return').val(total);
}

