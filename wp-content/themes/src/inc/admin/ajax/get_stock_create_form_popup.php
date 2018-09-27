<?php
$lot_id = isset( $_POST['id'] ) ? $_POST['id'] : 0;
$lot_details = get_lot($lot_id);

$original_slab_system = $lot_details['lot_data']->slab_system;
$original_bag_weight = $lot_details['lot_data']->bag_weight;

$dummy_slab_system = $lot_details['dummy_lot_data']->slab_system;



//echo "<pre>";
//var_dump($lot_details);
?>

<div class="form-grid">
	 <form method="post" name="add_stock" id="add_stock" class="popup_form" onsubmit="return false;">
		<div class="form_detail">
			<label>Slect Lot Number
				<abbr class="require" title="Required Field">*</abbr>
			</label>
      <div style="float:left;width: 138px;">
        <select class="lot_id" id="lot_id" required>
        </select>
      </div>

		</div>
		<div class="form_detail">
			<label style="width: 115px;">Brand Name 
			</label>
			<input type="text" id="brand_name" autocomplete="off" value="" tabIndex="-1" disabled style="color: #000;background: rgba(0, 0, 0, 0.17);" readonly>
		</div>
		<div class="form_detail">
			<label>Product Name
			</label>
			<input type="text" id="product_name" autocomplete="off" value="" tabIndex="-1" disabled style="color: #000;background: rgba(0, 0, 0, 0.17);" readonly>
		</div>
		<div class="form_detail">
			<label style="width: 115px;">Weight
			</label>
      <input type="text" id="weight" autocomplete="off" value="" tabIndex="-1" disabled style="color: #000;background: rgba(0, 0, 0, 0.17);" readonly>
		</div>
    <div class="form_detail">
      <label style="width: 115px;">Bag
        <abbr class="require" title="Required Field">*</abbr>
      </label>
      <input type="text" id="count" name="stock_count" class="count" required autocomplete="off" value="" style="color: #000;">
    </div>

		<div class="form_detail">
			<label>
				
			</label>
			<div style="float:right;margin-top: 10px;margin-right: 25px;" class="slab">
				<input type="hidden" name="slab_system" id="slab_system" value="">
			</div>
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
      templateResult: formatStateStockCreate,
      templateSelection: formatStateStockCreate
  }).on("select2:select", function (e) { 
      jQuery('#brand_name').val(e.params.data.brand_name);
      jQuery('#product_name').val(e.params.data.product_name);
      jQuery('#weight').val(e.params.data.weight+' kg');
      jQuery('#count').focus();
    console.log(e.params); 
  });


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



</script>