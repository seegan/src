jQuery('.popup-add-lot').live('click', function() { 
  create_popup('get_lot_create_form_popup', 'Add New Lot');
});

jQuery('a.lot_edit').live('click', function() {
  edit_popup('edit_lot_create_form_popup', 'Edit Lot', this);
});

  jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
  });
 


jQuery('a.lot_edit').live('click', function(e) {
    e.preventDefault();
    jQuery('#src_info_box').bPopup({
      modalClose: false,
      position: ['auto', 50] 
    });
});



jQuery('.bagweight .bag_weight').live('change', function() {
    var bag_weight_checked = jQuery('input[name=bag_weight]:checked').val();
    jQuery('input[name=slab_system]').val(bag_weight_checked);

   if(bag_weight_checked == '1') {
    //jQuery('.dummy_slot_number').css('display','block');

    jQuery('.group_retail').css('display','block');
    jQuery('.group_retail_no_slab').css('display','none');

    jQuery('.group_wholesale').css('display','block');
    jQuery('.wholesale_no_slab').css('display','none');
   }
   if(bag_weight_checked == '0') {
    //jQuery('.dummy_slot_number').css('display','none');

    jQuery('.group_retail').css('display','none');
    jQuery('.group_retail_no_slab').css('display','block');

    jQuery('.group_wholesale').css('display','none');
    jQuery('.wholesale_no_slab').css('display','block');

   }
});


jQuery('.bag_weight_total').live('change', function () {
  jQuery('.group_retail_no_slab .weight_from, .wholesale_no_slab .weight_from').val(1);
  jQuery('.group_retail_no_slab .weight_to, .wholesale_no_slab .weight_to').val(jQuery(this).val());

  jQuery('.retail_no_slab_dummy .weight_from, .wholesale_no_slab_dummy .weight_from').val(1);
  jQuery('.retail_no_slab_dummy .weight_to, .wholesale_no_slab_dummy .weight_to').val(jQuery(this).val());
});



jQuery('.slab .dummy_slab_system').live('change', function() {
   var slab_system_checked = jQuery('input[name=dummy_slab_system]:checked').val();


   if(slab_system_checked == '1') {
      jQuery('.group_retail_dummy').css('display','block');
      jQuery('.retail_no_slab_dummy').css('display','none');

      jQuery('.group_wholesale_dummy').css('display','block');
      jQuery('.wholesale_no_slab_dummy').css('display','none');

   }
   if(slab_system_checked == '0') {
      jQuery('.group_retail_dummy').css('display','none');
      jQuery('.retail_no_slab_dummy').css('display','block');

      jQuery('.group_wholesale_dummy').css('display','none');
      jQuery('.wholesale_no_slab_dummy').css('display','block');
   }
});

//Validation
jQuery('#add_lot').live('submit', function(e){

    jQuery( ".add_lot" ).validate({
          rules: {
              lot_number: {
                  required: true,
                  uniqueLot : true,
              },
              product_name : {
                  required: true,
              },
              weight : {
                required: true,
              },   
          },
          messages: {
              lot_number: {
                  required: 'Please Enter Lot Name!',
                  uniqueLot : 'Lot Number Already Exists!'
              },
              product_name : {
                  required: 'Please Select Product Name!',
              },
              weight: {
                required: "Please Select Weight!",
              },
          }
      });

});


 var response = true;
    jQuery.validator.addMethod(
          "uniqueLot", 
          function(value, element) {
              jQuery.ajax({
                type: "POST",
                dataType : "json",
                url: frontendajax.ajaxurl,
                data: {
                    action                : 'check_unique_lot',
                    lot_number            : value,
                    dummy_lot_number      : jQuery('#dummy_slot_number').val(),
                },
                success: function (msg) {

                    if( msg === 1 ) {
                        response = false;
                    } else {
                        response =  true;
                    }
                }
            });
              return response;
          }
      );
 


/*form submit*/
jQuery('#add_lot').live('submit', function(e){

    var valid = jQuery(".add_lot").valid();
    console.log(valid);
    if(valid) {
         lot_create_submit_popup('lot_create_submit_popup');
    } 
    e.preventDefault();   
    return false;
});


function lot_create_submit_popup(action = '', data = '') {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            data : jQuery("#add_lot").serialize(),
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
                    clear_main_popup();
                    jQuery('#src_info_box').bPopup().close();
                    alert_popup('<span class="success_msg">CLot Created!</span>', 'Success');   
                }
            } else {
                jQuery('.list_customers').html(data);
                clear_main_popup();
                jQuery('#src_info_box').bPopup().close();
                alert_popup('<span class="success_msg">Lot Created!</span>', 'Success'); 
            }
        }

    });
}



/*form edit*/


jQuery('#edit_lot').live('submit', function(e){
    var lot_number = jQuery('#lot_number').val();
    var brand_name = jQuery('#brand_name').val();
    var product_name = jQuery('#product_name').val();
    var weight = jQuery('#weight').val();
    var valid = jQuery(".edit_lot").valid();
    if(lot_number != '' && product_name != '' && weight != ''  && valid) {
         lot_update_submit_popup('lot_update_submit_popup');
    } else {
          e.preventDefault();
          return false;
    }
});


function lot_update_submit_popup(action = '', data = '') {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            data : jQuery("#edit_lot").serialize(),
            action : action
        },

        success: function (data) {
          var obj = jQuery.parseJSON(data);
          if(obj.success == 1) {
              clear_main_popup();
              jQuery('#src_info_box').bPopup().close();
              alert_popup('<span class="success_msg">Lot Updated!</span>', 'Success'); 

          } else {
              alert_popup('<span class="error_msg">Can\'t Edit this data, Try again!</span>', 'Error');  
          }
        }

    });
}

/*Updated for filter 11/10/16*/
jQuery('.lot_filter #per_page, .lot_filter #search_lot, .lot_filter #search_brand, .lot_filter #search_product').live('change', function(){

  var per_page = jQuery('#per_page').val();
  var lot_number = jQuery('#search_lot').val();
  var search_brand = jQuery('#search_brand').val();
  var search_product = jQuery('#search_product').val();



  jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
          per_page : per_page,
          lot_number : lot_number,
          search_brand : search_brand,
          search_product : search_product,
          action : 'lot_list_filter'
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
/*End Updated for filter 11/10/16*/



function pricePattern(product_name = 'R.R', price_type = 'retail') {

  var array_val = {
    'R.R' : {
        'retail' :    {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 1, '50' : 2},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 1, '50' : 2},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 1, '5' : 0.20, '30' : 0.30, '37' : 1, '50' : 2},
          'margin' :  {'0.1' : 1, '5' : 0.20, '30' : 0.30, '37' : 1, '50' : 2},
        }, 
      },
    'Idly' : {
        'retail' :    {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
      },
    'B.R' : {
        'retail' :    {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
      },
    'Wheat' : {
        'retail' :    {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
      },
    'R.R.(T)' : {
        'retail' :    {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
      },
    'Idly-IR 20' : {
        'retail' :    {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
      },
    'Basmati' : {
        'retail' :    {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
      },
    'Basmati (Loose)' : {
        'retail' :    {
          'range' : {0.1 : '1.99', 2 : '4.99', 5 : '10', 10.01 : '24.99', 25 : '100'},
          'diff' :  {'0.1' : 0.00, '2' : 0.50, '5' : 1.00, '10.01' : 2.00, '25' : 3},
          'margin' :  {'0.1' : 0.00, '2' : 0.50, '5' : 1.00, '10.01' : 2.00, '25' : 3},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '24.99', '25' : '49.99', '50' : '69.99', '70' : '99.99', '100' : '150'},
          'diff' :  {'0.1' : 0.00, '25' : 0.20, '50' : 0.30, '70' : 0.50, '100' : 1},
          'margin' :  {'0.1' : 0.00, '25' : 0.20, '50' : 0.30, '70' : 0.50, '100' : 1},
        }, 
      },
    'Zeragasamba (Loose)' : {
        'retail' :    {
          'range' : {'0.1' : '1.99', '2' : '4.99', '5' : '10', '10.1' : '24.99', '25' : '100'},
          'diff' :  {'0.1' : 0.00, '2' : 0.50, '5' : 1, '10.1' : 2, '25' : 3},
          'margin' :  {'0.1' : 0.00, '2' : 0.50, '5' : 1, '10.1' : 2, '25' : 3},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '24.99', '25' : '49.99', '50' : '69.99', '70' : '99.99', '100' : '150'},
          'diff' :  {'0.1' : 0.00, '25' : 0.20, '50' : 0.30, '70' : 0.50, '100' : 1},
          'margin' :  {'0.1' : 0.00, '25' : 0.20, '50' : 0.30, '70' : 0.50, '100' : 1},
        }, 
      },
    'R.H' : {
        'retail' :    {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
      },
    '25 KG B.R' : {
        'retail' :    {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
      },
    'Atta' : {
        'retail' :    {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
      },
    'Oil' : {
        'retail' :    {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
      },
    'Others' : {
        'retail' :    {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
        'wholesale' : {
          'range' : {'0.1' : '4.99', '5' : '29.99', '30' : '36.99', '37' : '49.99', '50' : '75'},
          'diff' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
          'margin' :  {'0.1' : 0.00, '5' : 0.20, '30' : 0.30, '37' : 0.50, '50' : 1},
        }, 
      },
  }

  return array_val[product_name][price_type];
}

function retailPriceRange(product_name = 'R.R', price_type = 'retail', selector = '', price_type_deep = 'retail_original') {

  var patten = pricePattern(product_name, price_type);
  var keys = Object.keys(patten.range).sort(function(a,b) { return a - b;});
  var data = [];
  var values = jQuery(selector).parent().find('.weight_from').map(function(){
    if(jQuery(this).val() != '') {
      return jQuery(this).val();
    }
  }).get();

  jQuery.each(keys, function( index, value ) {
    if(jQuery.inArray( value, values ) == -1) {
      data.from = value;
      data.to = patten['range'][value];
      return false;
    }
  });

  return data;
}


function wholesalePriceRange(product_name = 'R.R', price_type = 'wholesale', selector = '', price_type_deep = 'wholesale_original') {

  var patten = pricePattern(product_name, price_type);
  var keys = Object.keys(patten.range).sort(function(a,b) { return a - b;});
  var data = [];
  var values = jQuery(selector).parent().find('.weight_from').map(function(){
    if(jQuery(this).val() != '') {
      return jQuery(this).val();
    }
  }).get();

  jQuery.each(keys, function( index, value ) {
    if(jQuery.inArray( value, values ) == -1) {
      data.from = value;
      data.to = patten['range'][value];
      return false;
    }
  });

  return data;

}





function priceDifferent(product_name, price_type) { 
  var patten = pricePattern(product_name, price_type);
  var price_diff =  patten['diff'];
  return price_diff;
}
function marginDifferent(product_name, price_type) { 
  var patten = pricePattern(product_name, price_type);
  var margin_diff =  patten['margin'];
  return margin_diff;
}

function setPriceDifferent(product_name = 'R.R', price_type = 'retail', selector = '', weight ='', price_type_deep = 'retail_original') {
  if( price_type_deep == 'retail_original' || price_type_deep == 'wholesale_original' ) {
    var selling_price = parseFloat(jQuery('#src_info_box .basic_price').val());
  }
  if( price_type_deep == 'retail_dummy' || price_type_deep == 'wholesale_dummy' ) {
    var selling_price = parseFloat(jQuery('#src_info_box .dummy_basic_price').val());
  }

  var price_differents = priceDifferent(product_name, price_type);
  var current_diff = parseFloat(price_differents[weight]);
  var current_price = (selling_price - current_diff).toFixed(2);

  var margin_differents = marginDifferent(product_name, price_type);
  var margin_diff = parseFloat(margin_differents[weight]);
  var current_margin_price = (selling_price - margin_diff).toFixed(2);

  jQuery(selector).find('.price').val(current_price);
  jQuery(selector).find('.margin_price').val(current_margin_price);
}



jQuery('.basic_price').live('change', function(){
  var product_name = jQuery('.popup_form #product_name').val();
  jQuery('.retail-repeater.group_retail .repeterin').each(function(){
    var selector = this;
    var weight_from = jQuery(this).find('.weight_from').val();
    setPriceDifferent(product_name, 'retail', selector, weight_from, 'retail_original');
  });

  jQuery('.retail-wholesale.group_wholesale .repeterin').each(function(){
    var selector = this;
    var weight_from = jQuery(this).find('.weight_from').val();
    setPriceDifferent(product_name, 'wholesale', selector, weight_from, 'wholesale_original');
  });


});

jQuery('.dummy_basic_price').live('change', function(){
  var product_name = jQuery('.popup_form #product_name').val();
  jQuery('.retail-repeater-dummy.group_retail_dummy .repeterin').each(function(){
    var selector = this;
    var weight_from = jQuery(this).find('.weight_from').val();
    setPriceDifferent(product_name, 'retail', selector, weight_from, 'retail_dummy');
  });

  jQuery('.retail-wholesale-dummy.group_wholesale_dummy .repeterin').each(function(){
    var selector = this;
    var weight_from = jQuery(this).find('.weight_from').val();
    setPriceDifferent(product_name, 'wholesale', selector, weight_from, 'wholesale_dummy');
  });


});



//From Lot Submit button (tab and shif + tab action)
jQuery(document).on("keydown", "#edit_lot .submit-button, #add_lot .submit-button", function(e) {
  if(event.keyCode == 9) {
    if(event.shiftKey && event.keyCode == 9) {  
       e.preventDefault(); 
      jQuery('#edit_lot #add_new_price_range2, #add_lot #add_new_price_range2').focus();
    }
    else { 
      e.preventDefault(); 
      jQuery('#edit_lot #lot_number, #add_lot #lot_number').focus();
    }
  }
});

//From Lot Number (tab and shif + tab action)
jQuery(document).on("keydown", "#edit_lot #lot_number, #add_lot #lot_number", function(e) {
  var keyCode = e.keyCode || e.which; 
  if(event.shiftKey && event.keyCode == 9) {  
     e.preventDefault(); 
    jQuery('#edit_lot .submit-button, #add_lot .submit-button').focus();
  }
});



jQuery(document).on('keyup','#lot_number', function() { 
    this.value = this.value.toUpperCase();
    jQuery(this).val(this.value);
    jQuery('#brand_name').val(this.value).change();
});

jQuery(document).on('keyup','#brand_name', function() { 
    this.value = this.value.toUpperCase();
    jQuery(this).val(this.value);
});
jQuery(document).on('keyup','#dummy_brand_name', function() { 
    this.value = this.value.toUpperCase();
    jQuery(this).val(this.value);
});
jQuery(document).on('keyup','#dummy_slot_number', function() { 
    this.value = this.value.toUpperCase();
    jQuery(this).val(this.value);
    jQuery('#dummy_brand_name').val(this.value).change();
});



