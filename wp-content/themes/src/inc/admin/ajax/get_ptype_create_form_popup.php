<?php
$lot_id = isset( $_POST['pt_id'] ) ? $_POST['pt_id'] : 0;
$lot_details = get_lot($lot_id);

$original_slab_system = $lot_details['lot_data']->slab_system;
$original_bag_weight = $lot_details['lot_data']->bag_weight;

$dummy_slab_system = $lot_details['dummy_lot_data']->slab_system;



//echo "<pre>";
//var_dump($lot_details);
?>

<div class="form-grid">
	 <form method="post" name="add_ptype" id="add_ptype" class="popup_form" onsubmit="return false;">
     <input type="hidden" name="user_id" value="<?php  echo $user = get_current_user_id();?>" id="user_id">
      <input type="hidden" name="pt_id" value="" id="pt_id">
		
		
		<div class="form_detail">
			<label>Product Type
			</label>
			<input type="text" id="product_type" autocomplete="off" value="" tabIndex="-1" required autocomplete="off" style="color: #000;" >
		</div>

		<div class="button_sub">
			<button type="submit" name="edit_customer_list" id="btn_submit11" class="submit-button">Submit</button>
		</div>
	</form>
</div>


<script type="text/javascript">
 
 //From ptype Submit button (tab and shif + tab action)
jQuery(document).on("keydown", "#edit_ptype .submit-button1, #add_ptype .submit-button1", function(e) {
  if(event.keyCode == 9) {
    if(event.shiftKey && event.keyCode == 9) {  
       e.preventDefault(); 
      jQuery('#edit_ptype #product_type, #add_ptype #product_type').focus();
    }
    else { 
      e.preventDefault(); 
      jQuery('#lot_id').select2('open');
    }
  }
});


</script>