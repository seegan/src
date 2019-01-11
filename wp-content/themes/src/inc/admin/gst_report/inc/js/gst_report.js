jQuery(document).ready(function (argument) {

 	jQuery('.return_report_print').on('click',function(){
     	var slap = jQuery('.slap').val();
     	 var bill_form = man_to_machine_date_js(jQuery('.bill_from').val());
        var bill_to = man_to_machine_date_js(jQuery('.bill_to').val());
        var datapass =   home_page.url+'return-report-print/?bill_form='+bill_form+'&bill_to='+bill_to + '&slap='+slap;

        // billing_list_single
        var thePopup = window.open( datapass, "Billing Wholesale Invoice","" );
        thePopup.print();  
    }); 


	jQuery('.accountant_download').on('click',function() {
        console.log("fdsfdf");
        var bill_form = man_to_machine_date_js(jQuery('.bill_from').val());
        var bill_to = man_to_machine_date_js(jQuery('.bill_to').val());
        var slap = jQuery('.slap').val();
        var datapass =   home_page.url+'acc-download/?bill_form='+bill_form+'&bill_to='+bill_to + '&slap='+slap;

        // billing_list_single
        var thePopup = window.open( datapass, "Download Report","" );
       
    });

     jQuery('.accountant_print').on('click',function(){
        var bill_form = jQuery('.bill_from').val();
        var bill_to = jQuery('.bill_to').val();
        var slap = jQuery('.slap').val();
        var datapass =   home_page.url+'acc-print/?bill_form='+bill_form+'&bill_to='+bill_to + '&slap='+slap;

        // billing_list_single
        var thePopup = window.open( datapass, "Billing Wholesale Invoice","" );
        thePopup.print();  
    });


     jQuery('.stock_download').on('click',function() {

       	var slap = jQuery('.slap').val(); 
        var bill_form = jQuery('.bill_from').val();
        var bill_to = jQuery('.bill_to').val();
        var datapass =   home_page.url+'report-download/?bill_form='+bill_form+'&bill_to='+bill_to + '&slap='+slap;

        // billing_list_single
        var thePopup = window.open( datapass, "Download Report","" );
       
    });

       jQuery('.return_report_download').on('click',function() {

        var slap = jQuery('.slap').val(); 
        var bill_form = jQuery('.bill_from').val();
        var bill_to = jQuery('.bill_to').val();
        var datapass =   home_page.url+'return-report-download/?bill_form='+bill_form+'&bill_to='+bill_to + '&slap='+slap;

        // billing_list_single
        var thePopup = window.open( datapass, "Download Report","" );
       
    });

     jQuery('.stock_print').on('click',function(){
     	var slap = jQuery('.slap').val();
     	var bill_form = jQuery('.bill_from').val();
        var bill_to = jQuery('.bill_to').val();
        var datapass =   home_page.url+'report-print/?bill_form='+bill_form+'&bill_to='+bill_to + '&slap='+slap;

        // billing_list_single
        var thePopup = window.open( datapass, "Billing Wholesale Invoice","");
        thePopup.print();  
    });
	


    jQuery('.cgst_report_filter .slab, .cgst_report_filter  #date_from, .cgst_report_filter  #date_to').live('change', function(){

        jQuery.ajax({
          type: "POST",
          url: frontendajax.ajaxurl,
          data: {
            data : jQuery('.cgst_report_filter :input').serialize(),
            action : 'cgst_sale_filter_list'
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



    jQuery('.igst_report_filter .slab, .igst_report_filter  #date_from, .igst_report_filter  #date_to').live('change', function(){

        jQuery.ajax({
          type: "POST",
          url: frontendajax.ajaxurl,
          data: {
            data : jQuery('.igst_report_filter :input').serialize(),
            action : 'igst_sale_filter_list'
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
    

    jQuery('.cgst_return_report_filter .slab, .cgst_return_report_filter  #date_from, .cgst_return_report_filter  #date_to').live('change', function(){

        jQuery.ajax({
          type: "POST",
          url: frontendajax.ajaxurl,
          data: {
            data : jQuery('.cgst_return_report_filter :input').serialize(),
            action : 'cgst_sale_return_filter_list'
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


    jQuery('.igst_return_report_filter .slab, .igst_return_report_filter  #date_from, .igst_return_report_filter  #date_to').live('change', function(){

        jQuery.ajax({
          type: "POST",
          url: frontendajax.ajaxurl,
          data: {
            data : jQuery('.igst_return_report_filter :input').serialize(),
            action : 'igst_sale_return_filter_list'
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



});