jQuery(document).ready(function(){ 
    jQuery("#return_date" ).datepicker({dateFormat: "dd-mm-yy"});
});



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
