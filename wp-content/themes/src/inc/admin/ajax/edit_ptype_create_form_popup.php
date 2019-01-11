<?php
$ptype_id = isset( $_POST['id'] ) ? $_POST['id'] : 0;
$ptype_details = get_ptype_data_by_id($ptype_id);
?>

<div class="form-grid">
	 <form method="post" name="edit_ptype" id="edit_ptype" class="popup_form" onsubmit="return false;">
	 	<input type="hidden" name="ptype_id" value="<?php echo $ptype_id; ?>" id="ptype_id">
		
		<div class="form_detail">
			<label>Product Name
			</label>
		<input type="text" id="product_name" name="product_name" autocomplete="off" tabIndex="-1"  value="<?php echo $ptype_details['name']; ?>">
		</div>
		<div class="button_sub">
			<button type="submit" name="edit_customer_list" id="btn_submit" class="submit-button">Submit</button>
		</div>
	</form>
</div>

<script type="text/javascript">

  

//From Stock Submit button (tab and shif + tab action)
jQuery(document).on("keydown", "#edit_ptype .submit-button, #add_ptype .submit-button", function(e) {
  if(event.keyCode == 9) {
    if(event.shiftKey && event.keyCode == 9) {  
       e.preventDefault(); 
      jQuery('#edit_ptype #product_name, #add_ptype #product_name').focus();
    }
    else { 
      e.preventDefault(); 
      jQuery('#product_name').select2('open');
    }
  }
});
jQuery(document).on("keydown", ".select2-search__field", function(e) {
  if(event.keyCode == 9) {
    console.log(jQuery(this));
    if(event.shiftKey && event.keyCode == 9) {  
       e.preventDefault(); 
       jQuery(this).parent().find('#edit_ptype #submit-button, #add_ptype #submit-button').focus();
    }
    else { 
      e.preventDefault(); 
      jQuery('#edit_ptype #product_name, #add_ptype #product_name').focus();
    }
  }
});

</script>