<?php 
$option_name='lot_quantityweight_values';
$opt = get_option($option_name);
?>


<div class="widget-top">
	<h4>Add Lot Quantity/Weight(Kg)</h4>
</div>
<div class="widget-content module">
	<div class="form-grid">
		<form method="post" name="new_lot_quantity" id="new_lot_quantity" class="leftLabel">
			<input type="hidden" name="user_id" value="<?php  echo $user = get_current_user_id();?>" id="user_id">
           <input type="hidden" name="pt_id" value="lot_quantityweight_values" id="pt_id">
			<ul>
				<li>
					<label class="fldTitle">Lot Quantity/weight(Kg)<br/> [use comma for separate Quantity/weight]
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<div class="fieldwrap">
						<span class="left">
							<textarea id="lot_quantity" name="lot_quantity" onkeypress="return numericValidation(this,event);" style="height: 82px;width:401px;"><?php echo $opt;?></textarea>
						</span>
					</div>
				</li>
				
				<li class="buttons bottom-round noboder">
					<div class="fieldwrap">
						<input type="hidden" name="action" value="<?php echo ($user) ? 'admin_update' : 'admin_create' ?>">
						<input name="add_lot_quantity" type="submit" value="Submit" class="submit-button">
					</div>
				</li>
			</ul>
		</form>
	</div>
</div>
<script type="text/javascript">

		function numericValidation(evt)
		{
		         var charCode = (evt.which) ? evt.which : event.keyCode
		         
		         if (charCode > 31 && (charCode < 48 || charCode > 57 ) && charCode != 44)
		             return false;
		         return true;
		}


	jQuery('#new_lot_quantity .submit-button').click(function () {

		var lot_quantity = jQuery('#new_lot_quantity #lot_quantity').val();	
		var user_id    = jQuery('#new_lot_quantity #user_id').val();
		var pt_id    = jQuery('#new_lot_quantity #pt_id').val();	

  //remove multiple commas
  	var lot_quantity = lot_quantity.toString();
    lot_quantity= lot_quantity.replace(/,,+/g, ',');
    //alert(lot_quantity);

		if(lot_quantity != '') {
						jQuery.ajax({
				        type: "POST",
				        url: frontendajax.ajaxurl,
				        data: {
					    		 user_id : user_id,
					    		 pt_id : pt_id,
						         lot_quantity : lot_quantity,
						         action : 'new_lot_quantity_weight'
				        },
				        success: function (data) 
				        {
					            var obj = jQuery.parseJSON(data);
				                if(obj.success == 0) {
				                    alert_popup('<span class="error_msg">Something Went Wrong! try again!</span>', 'Error');
				                     return false;
				                } else {
				                    clear_main_popup();
				                    jQuery('#src_info_box').bPopup().close();
				                    //alert_popup('<span class="success_msg">Lot Quantity Created!</span>', 'Success'); 
				                    
				                     var r = confirm('Lot Quantity Created Successfully... '); 
										  if (r == true) {
										    window.location.replace('admin.php?page=stock'); 
										  } else {
										    window.location.replace('admin.php?page=src_settings'); 
										  }
				                     
				                }
				        }
				    });

			
		} else {
				 alert_popup('<span class="error_msg">Enter the mandatory fields!!!</span>', 'Alert!');
			 	 return false;
		}
	})
 </script>
     