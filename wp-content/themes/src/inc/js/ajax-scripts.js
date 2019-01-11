function create_popup(action = '', title = '') {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            key : 'get_popup_content',
            action : action
        },
        success: function (data) {
            jQuery('#popup-title').html(title);
            clear_main_popup();
            jQuery('#popup-content').html(data);

            jQuery('.popup_form').find('#lot_number').focus();
            jQuery('.popup_form').find('.customer_name').focus();
        }
    });
}

function edit_popup(action= '', title = '', data = '') {

    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            key : 'edit_popup_content',
            action : action,
            id : jQuery(data).data('id'),
            roll_id : jQuery(data).data('roll'),
        },
        success: function (data) {
            jQuery('#popup-title').html(title);
            clear_main_popup();
            jQuery('#popup-content').html(data);

            jQuery('.popup_form').find('#lot_number').focus();
            jQuery('.popup_form').find('.customer_name').focus();
        }
    });

}



jQuery(document).ready(function(){

    jQuery("#search_lotn").select2({
        width: '123px',
        multiple: false,
        minimumInputLength: 1,
        allowClear: true,
        placeholder: "Search Lot Number",


        ajax: {
          type: 'POST',
          url: frontendajax.ajaxurl,
          delay: 250,
          dataType: 'json',
          data: function(params) {
            return {
              action: 'searchLotNumber', // search term
              page: 1,
              search_key: params.term,
            };
          },
          processResults: function(data) {
            var results = [];

            return {
                results: jQuery.map(data.items, function(obj) {
                    return { id: obj.id, lot_number:obj.lot_number};
                })
            };
          },
          cache: true
        },
        initSelection: function (element, callback) {
            callback({ id: '-', lot_number: 'Search Lot Number' });
        },
      templateResult: formatCustomerNamea,
      templateSelection: formatCustomerNamea
    }).on("select2:unselecting", function(e) {
    jQuery(this).data('state', 'unselected');
}); 




    jQuery("#search_brandn").select2({
        width: '123px',
        multiple: false,
        minimumInputLength: 1,
        allowClear: true,
        placeholder: "Search Brand Name",
        ajax: {
          type: 'POST',
          url: frontendajax.ajaxurl,
          delay: 250,
          dataType: 'json',
          data: function(params) {
            return {
              action: 'searchBrandName', // search term
              page: 1,
              search_key: params.term,
            };
          },
          processResults: function(data) {
            var results = [];

            return {
                results: jQuery.map(data.items, function(obj) {
                    return { id: obj.brand_name };
                })
            };
          },
          cache: true
        },
        initSelection: function (element, callback) {
            callback({ id: 'Search Brand Name' });
        },
      templateResult: formatCustomerNameb,
      templateSelection: formatCustomerNameb
    }); 



    jQuery("#search_stockn").select2({
        width: '123px',
        multiple: false,
        minimumInputLength: 1,
        allowClear: true,
        placeholder: "Search Stock Name",
        ajax: {
          type: 'POST',
          url: frontendajax.ajaxurl,
          delay: 250,
          dataType: 'json',
          data: function(params) {
            return {
              action: 'searchStockName', // search term
              page: 1,
              search_key: params.term,
            };
          },
          processResults: function(data) {
            var results = [];

            return {
                results: jQuery.map(data.items, function(obj) {
                    return { id: obj.product_name };
                })
            };
          },
          cache: true
        },
        initSelection: function (element, callback) {
            callback({ id: 'Search Stock Name' });
        },
      templateResult: formatCustomerNameb,
      templateSelection: formatCustomerNameb
    }); 


});



    function formatCustomerNamea (state) {
        if (!state.id) {
            return state.id;
        }
        var $state = jQuery(
        '<span>' +
          state.lot_number +
        '</span>'
        );
        return $state;
    };

    function formatCustomerNameb (state) {
        if (!state.id) {
            return state.id;
        }
        var $state = jQuery(
        '<span>' +
          state.id +
        '</span>'
        );
        return $state;
    };


jQuery('.search_avail_stock').live('click', function(){

    //console.log(jQuery('#search_lot_rate').val());
    jQuery('#search_loader').css('display','inline-block');

    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            action : 'stock_search_filter',
            lot_id : jQuery('#search_lotn').val(),
            brand_name : jQuery('#search_brandn').val(),
            stock_name : jQuery('#search_stockn').val()
        },
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if(obj.success == 1) {
                var html = '';
                var i = 1;
                jQuery.each(obj.items, function(key, val){
                    html += '<tr>';
                    html += '<td>'+i+'</td>';
                    html += '<td>'+val.lot_number+'</td>';
                    html += '<td>'+val.brand_name+'</td>';
                    html += '<td>'+val.product_name+'</td>';
                    html += '<td>'+val.bal_stock+'</td>';
                    html += '</tr>';

                    i++;
                })
            } else {
                    html += '<tr>';
                    html += '<td colspan="5">No Record Found</td>';
                    html += '</tr>';
            }

            jQuery('.stock_search_filter').html(html);
        }
    }).done(function(){
        jQuery('#search_loader').css('display','none');
    });
});



jQuery('.c-delete').live('click', function(){

    var data_id = jQuery(this).attr('data-id');
    var data_tb = jQuery(this).attr('data-action');

    jQuery( ".conform-box1" ).dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "Delete": function() {
              jQuery( this ).dialog( "close" );
              updateDeleteData(data_id, data_tb);
            },
            Cancel: function() {
                jQuery( this ).dialog( "close" );
            }
        }
    });
});
jQuery('.bill-delete').live('click', function(){

    var data_id = jQuery(this).attr('data-id');
    var data_tb = jQuery(this).attr('data-action');
     var data_user= jQuery(this).attr('data-user');

    jQuery( ".conform-box1" ).dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "Delete": function() {
              //jQuery( this ).dialog("close");
              updateDeleteData(data_id, data_tb,data_user, jQuery(this).find('#cancel_reason').val());
              jQuery( this ).dialog("close");
            
            },
            Cancel: function() {
                jQuery( this ).dialog( "close" );
            }
        }
    });
});

jQuery('.ptype_delete').live('click', function(){

    var data_id = jQuery(this).attr('data-id');
    var data_tb = jQuery(this).attr('data-action');
     var data_user= jQuery(this).attr('data-user');

    jQuery( ".conform-box1" ).dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "Delete": function() {
              jQuery( this ).dialog("close");
              updateDeleteData(data_id, data_tb,data_user);
            },
            Cancel: function() {
                jQuery( this ).dialog( "close" );
            }
        }
    });
});

function updateDeleteData(data_id, data_tb,data_user, cancel_reason) {
  jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
          data_id : data_id,
          data_tb : data_tb,
          cancel_reason : cancel_reason,
          action : 'src_delete_data',
      },
      success: function (data) {
          var obj = jQuery.parseJSON(data);
          location.reload();
      }
  });
}



function clear_main_popup_s() {
  jQuery('#popup-content-s').html('');              
}

function status_change_popup(action = '', title = '', selector) {
  var bill_id = jQuery(selector).parent().parent().find('.c-edit').attr('data-bill-id');
  jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
        bill_id : bill_id,
        key : 'get_popup_content',
        action : action
      },
      success: function (data) {
          jQuery('#popup-title-s').html(title);
          clear_main_popup_s();
          jQuery('#popup-content-s').html(data);
      }
  });
}