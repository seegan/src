<?php
$stock_id = isset( $_POST['id'] ) ? $_POST['id'] : 0;
$stock_details = get_stock_data_by_id($stock_id);
?>

<div class="form-grid">
	 <form method="post" name="edit_stock" id="edit_stock" class="popup_form" onsubmit="return false;">
		<div class="form_detail">
			<label>Select Lot Number
				<abbr class="require" title="Required Field">*</abbr>
			</label>
      <div style="float:left;width: 138px;">
        <select class="lot_id" id="lot_id" required>
          <option selected value="<?php echo $stock_details['lot_id'] ?>"><?php echo $stock_details['lot_number'] ?></option>
        </select>
      </div>

		</div>
		<div class="form_detail">
			<label style="width: 115px;">Brand Name 
			</label>
			<input type="text" id="brand_name" autocomplete="off" tabIndex="-1" disabled style="color: #000;background: rgba(0, 0, 0, 0.17);" readonly value="<?php echo $stock_details['brand_name']; ?>">
		</div>
		<div class="form_detail">
			<label>Product Name
			</label>
			<input type="text" id="product_name" autocomplete="off" tabIndex="-1" disabled style="color: #000;background: rgba(0, 0, 0, 0.17);" readonly value="<?php echo $stock_details['product_name']; ?>">
		</div>
		<div class="form_detail">
			<label style="width: 115px;">Stock Weight
			</label>
      <input type="text" id="weight" autocomplete="off" tabIndex="-1" disabled style="color: #000;background: rgba(0, 0, 0, 0.17);" readonly value="<?php echo $stock_details['total_weight']; ?>">
		</div>
    <div class="form_detail">
      <label style="width: 115px;">Bag
        <abbr class="require" title="Required Field">*</abbr>
      </label>
      <input type="text" id="count" name="stock_count" required autocomplete="off" value="<?php echo $stock_details['bags_count']; ?>" style="color: #000;">

      <input type="hidden" name="stock_id" value="<?php echo $stock_details['id']; ?>" id="stock_id">
    </div>



		<div class="button_sub">
			<button type="submit" name="edit_customer_list" id="btn_submit" class="submit-button">Submit</button>
		</div>
	</form>
</div>

<script type="text/javascript">

  jQuery(".lot_id").select2({
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
              action: 'get_lot_data', // search term
              page: 1,
              search_key: params.term,
            };
          },
          processResults: function(data) {
            var results = [];

            return {
                results: jQuery.map(data.items, function(obj) {
                    return { id: obj.id, lot_number:obj.lot_number, brand_name: obj.brand_name, product_name:obj.product_name, weight:obj.weight };
                })
            };
          },
          cache: true
      },
      initSelection: function (element, callback) {
          callback({ id: jQuery(element).val(), lot_number: jQuery(element).find(':selected').text() });
      },
      templateResult: formatStateStockCreate,
      templateSelection: formatStateStockCreate
  }).on("select2:select", function (e) { 
      jQuery('#brand_name').val(e.params.data.brand_name);
      jQuery('#product_name').val(e.params.data.product_name);
      jQuery('#weight').val(e.params.data.weight+' kg');
      jQuery('#count').focus();

    console.log(e.params); 
  });

jQuery('#lot_id').select2('open');

    function formatStateStockCreate (state) {
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

//From Stock Submit button (tab and shif + tab action)
jQuery(document).on("keydown", "#edit_stock .submit-button, #add_stock .submit-button", function(e) {
  if(event.keyCode == 9) {
    if(event.shiftKey && event.keyCode == 9) {  
       e.preventDefault(); 
      jQuery('#edit_stock #count, #add_stock #count').focus();
    }
    else { 
      e.preventDefault(); 
      jQuery('#lot_id').select2('open');
    }
  }
});
jQuery(document).on("keydown", ".select2-search__field", function(e) {
  if(event.keyCode == 9) {
    console.log(jQuery(this));
    if(event.shiftKey && event.keyCode == 9) {  
       e.preventDefault(); 
       jQuery(this).parent().find('#edit_stock #submit-button, #add_stock #submit-button').focus();
    }
    else { 
      e.preventDefault(); 
      jQuery('#edit_stock #count, #add_stock #count').focus();
    }
  }
});

</script>