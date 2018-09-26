<style type="text/css">
#lot_number-error{
	    width: 170px;
	    margin-top: -6px;
	    color: #dc1919;
}
#product_name-error{
	    width: 170px;
	    margin-top: -6px;
	    color: #dc1919;
}
</style>
<div class="form-grid">
	<form method="post" name="add_lot" id="add_lot" class="popup_form add_lot" onsubmit="return false;">
		<div class="form_detail">
			<label>Enter Lot
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<span>
				<input type="text" id="lot_number" name="lot_number" autocomplete="off">
			</span>
			
		</div>
		<div class="form_detail">
			<label style="width: 115px;"> Customer Bill Display Name
			</label>
			<span>
				<input type="text" id="brand_name" name="brand_name" autocomplete="off">
			</span>
		</div>
		<!-- <div class="form_detail">
			<label style="width: 115px;">Search Name
			</label>
			<span>
				<input type="text" id="search_name" name="search_name" autocomplete="off">
			</span>
		</div> -->
		<div class="form_detail">
			<label>Product Type
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<select name="product_name" id="product_name">
		        <option>R.R</option>
		        <option>Idly</option>
		        <option>B.R</option>
		        <option>Wheat</option>
		        <option>R.R.(T)</option>
		        <option>Idly-IR 20</option>
		        <option>Basmati</option>
		        <option>Basmati (Loose)</option>
		        <option>Zeragasamba (Loose)</option>
		        <option>R.H</option>
		        <option>25 KG B.R</option>
		        <option>Others</option>
		    </select> 
		        
		</div>
		<div class="form_detail" id="product_name1" style="display:none;">
			<label style="width: 115px;">Product Name
			</label>
			<input type="text" name="product_name1">
		</div>
		<div class="form_detail">
			<label style="width: 115px;">Weight
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<select name="weight" class="bag_weight_total">
				<option value="5">5kg</option>
				<option value="10">10kg</option>
				<option value="20">20kg</option>
				<option value="25">25kg</option>
				<option value="50">50kg</option>
				<option value="75">75kg</option>
			</select>
		</div>
		<div class="form_detail">
			<label>
				Buying Price (Rs/Bag)
			</label>
			<div class="slab">
				<input type="text" name="buying_price" class="buying_price" id="buying_price" autocomplete="off" value="<?php echo $lot_details['lot_data']->buying_price; ?>">
			</div>
		</div>
		<div class="form_detail">
			<label>
				Stock Alert (Kg)
			</label>
			<div class="slab">
				<input type="text" name="stock_alert" class="stock_alert" autocomplete="off" value="1">
				<input type="hidden" name="slab_system" id="slab_system" value="0">
			</div>
		</div>

		<div class="form_detail">
			<label style="width: 115px;">GST %
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<select name="gst_percentage">
				<option value="0.00">0%</option>
				<option value="5.00">5.00%</option>
				<option value="12.00">12.00%</option>
				<option value="18.00">18.00%</option>
				<option value="28.00">28.00%</option>
			</select>
		</div>
		<div class="form_detail">
			<label>
				HSN
			</label>
			<div class="slab">
				<input type="text" name="hsn_code" class="hsn_code" autocomplete="off" value="">
			</div>
		</div>
		<div class="form_detail">
			<label>Slab System?
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<div style="float:right;margin-top: 10px;" class="bagweight">
				<input type="radio" name="bag_weight" class="bag_weight" value="1">Yes(Kg)&nbsp;&nbsp;
				<input type="radio" name="bag_weight" class="bag_weight" value="0" checked>No(Bag)
			</div>
		</div>
		<div class="form_detail">
			<label>
				MRP
			</label>
			<div class="slab">
				<input type="text" name="basic_price" class="basic_price" autocomplete="off" value="0.00">
			</div>
		</div>

		<div style="clear:both;"></div>
		<div class="table-simple price_range" style="width: 97%;">
			<h3>Retail Sale Price Range</h3>


				<div class="retail-repeater group_retail"  style="display:none;">
				  	<div data-repeater-list="group_retail" class="div-table">

					    <div class="div-table-row">
						    <div class="div-table-head">S.No</div>
						    <div class="div-table-head">From Weight</div>
						    <div class="div-table-head">To Weight</div>
							<div class="div-table-head">Discountant Price</div>
							<div class="div-table-head">End Price</div>
						    <div class="div-table-head">Option</div>
						</div>

				    	<div data-repeater-item class="repeterin div-table-row">
							<div class="div-table-col rowno">1</div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_from" class="weight_from" autocomplete="off" value="0.1">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_to" class="weight_to" autocomplete="off" value="4.99">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price" class="price" autocomplete="off" value="0.00">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="margin_price" class="margin_price" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
						    	<input type="hidden" value="Delete"/>
						    </div>
				        </div>
				    </div>
				    	<ul class="icons-labeled">
							<li><a data-repeater-create href="javascript:void(0);" id="add_new_price_range"><span class="icon-block-color add-c"></span>Add Price Range Retail Sale</a></li>
						</ul>
				</div>



				<div class="group_retail_no_slab">
				  	<div class="div-table">

					    <div class="div-table-row">
						    <div class="div-table-head" style="display:none;">From Weight</div>
						    <div class="div-table-head" style="display:none;">To Weight</div>
						    <div class="div-table-head">Bag Count</div>
						    <div class="div-table-head">Price/Bag</div>
						    <div class="div-table-head">End Price/Bag</div>
						</div>

				    	<div data-repeater-item class="repeterin div-table-row">
						    <div class="div-table-col" style="display: none;">
						    	<input type="text" name="weight_from_retail_no_slab" class="weight_from" autocomplete="off" value="1">
						    </div>
						    <div class="div-table-col" style="display: none;">
						    	<input type="text" name="weight_to_retail_no_slab" class="weight_to" autocomplete="off" value="5">
						    </div>
						    <div class="div-table-col">
						    	<div>1</div>
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price_retail_no_slab" class="price" autocomplete="off" value="0.00">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="margin_price_retail_no_slab" class="margin_price" autocomplete="off" value="0.00">
						    </div>
				        </div>

				    </div>
				</div>


			<h3>Wholesale Price Range</h3>

				<div class="retail-wholesale group_wholesale"  style="display:none;">
				  	<div data-repeater-list="group_wholesale" class="div-table">

					    <div class="div-table-row">
						    <div class="div-table-head">S.No</div>
						    <div class="div-table-head">From Weight</div>
						    <div class="div-table-head">To Weight</div>
							<div class="div-table-head">Discountant Price</div>
							<div class="div-table-head">End Price</div>
						    <div class="div-table-head">Option</div>
						</div>

				    	<div data-repeater-item class="repeterin div-table-row">
							<div class="div-table-col rowno">1</div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_from" class="weight_from" autocomplete="off" value="0.1">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_to" class="weight_to" autocomplete="off" value="4.99">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price" class="price" autocomplete="off" value="0.00">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="margin_price" class="margin_price" autocomplete="off" value="0.00">
						    </div>
						    <div class="div-table-col">
						    	<a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
						    	<input type="hidden" value="Delete"/>
						    </div>
				        </div>

				    </div>
						<ul class="icons-labeled">
							<li><a href="javascript:void(0);" id="add_new_price_range2" data-repeater-create><span class="icon-block-color add-c"></span>Add Price Range Wholesale</a></li>
						</ul>
				</div>

		
				<div class="wholesale_no_slab">
				  	<div class="div-table">

					    <div class="div-table-row">
						    <div class="div-table-head" style="display:none;">From Weight</div>
						    <div class="div-table-head" style="display:none;">To Weight</div>
						    <div class="div-table-head">Bag Count</div>
						    <div class="div-table-head">Discountant Price/Bag</div>
						    <div class="div-table-head">End Price/Bag</div>
						</div>

				    	<div data-repeater-item class="repeterin div-table-row">
						    <div class="div-table-col" style="display: none;">
						    	<input type="text" name="weight_from_wholesale_no_slab" class="weight_from" autocomplete="off" value="1">
						    </div>
						    <div class="div-table-col" style="display: none;">
						    	<input type="text" name="weight_to_wholesale_no_slab" class="weight_to" autocomplete="off" value="5">
						    </div>
						    <div class="div-table-col">
						    	<div>1</div>
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price_wholesale_no_slab" class="price" autocomplete="off" value="0.00">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="margin_price_wholesale_no_slab" class="margin_price" autocomplete="off" value="0.00">
						    </div>
				        </div>
				    </div>
				</div>
			</div>


			<div style="clear:both;"></div>


			<div class="dummy_slot_number" style="margin-top:20px;">
				<h2 style="text-align:center;">Dummy Lot Data</h2>
				<div class="form_detail">
					<label>Dummy Lot (Search)
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<input type="text" id="dummy_slot_number" name="dummy_slot_number" autocomplete="off">
				</div>
				<div class="form_detail">
					<label>
						Customer Bill Display Name
					</label>
					<div class="slab">
						<input type="text" name="dummy_brand_name" id="dummy_brand_name" autocomplete="off">
					</div>
				</div>
				<div class="form_detail">
					<label style="width: 115px;">Dummy Lot Search Name
					</label>
					<span>
						<input type="text" id="search_name_dummy" name="search_name_dummy" autocomplete="off">
					</span>
				</div>
				<div class="form_detail">
					<label>Slab System ?
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<div style="float:right;margin-top: 10px;" class="slab">
						<input type="radio" name="dummy_slab_system" class="dummy_slab_system" value="1" checked>Yes(Kg)&nbsp;&nbsp;
						<input type="radio" name="dummy_slab_system" class="dummy_slab_system" value="0">No(Bag)
					</div>
				</div>
				<div class="form_detail">
					<label>
						Selling Price(Rs/Kg)
					</label>
					<div class="slab">
						<input type="text" name="dummy_basic_price" class="dummy_basic_price" autocomplete="off">
					</div>
				</div>
				<div style="clear:both;"></div>
				<div class="table-simple price_range" style="width: 97%;">
					<h3>Retail Sale Price Range</h3>


					<div class="retail-repeater-dummy group_retail_dummy">
					  	<div data-repeater-list="group_dummy_retail" class="div-table">

						    <div class="div-table-row">
							    <div class="div-table-head">S.No</div>
							    <div class="div-table-head">From Weight</div>
							    <div class="div-table-head">To Weight</div>
							    <div class="div-table-head">Discount Price</div>
							    <div class="div-table-head">End Price</div>
							    <div class="div-table-head">Option</div>
							</div>

					    	<div data-repeater-item class="repeterin div-table-row">
								<div class="div-table-col rowno">1</div>
							    <div class="div-table-col">
							    	<input type="text" name="weight_from" class="weight_from" autocomplete="off" value="0.1">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="weight_to" class="weight_to" autocomplete="off" value="4.99">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="price" class="price" autocomplete="off" value="0.00">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="margin_price" class="margin_price" autocomplete="off"  value="0.00">
							    </div>
							    <div class="div-table-col">
							    	<a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
							    	<input type="hidden" value="Delete"/>
							    </div>
					        </div>

					    </div>
					    	<ul class="icons-labeled">
								<li><a data-repeater-create href="javascript:void(0);" id="add_new_price_range"><span class="icon-block-color add-c"></span>Add Price Range Retail Sale</a></li>
							</ul>
					</div>

					<div class="retail_no_slab_dummy" style="display:none;">
					  	<div class="div-table">
						    <div class="div-table-row">
							    <div class="div-table-head" style="display:none;">From Weight</div>
							    <div class="div-table-head" style="display:none;">To Weight</div>
							    <div class="div-table-head">Bag Count</div>
							    <div class="div-table-head">Price/Bag</div>
							    <div class="div-table-head">End Price/Bag</div>
							</div>

					    	<div data-repeater-item class="repeterin div-table-row">
							    <div class="div-table-col" style="display: none;">
							    	<input type="text" name="bag_weight_from_retail_no_slab" class="weight_from" autocomplete="off" value="1">
							    </div>
							    <div class="div-table-col" style="display: none;">
							    	<input type="text" name="bag_weight_to_retail_no_slab" class="weight_to" autocomplete="off" value="5">
							    </div>
							    <div class="div-table-col">
							    	<div>1</div>
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="bag_weight_price_retail_no_slab" class="price" autocomplete="off" value="0.00">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="bag_weight_margin_price_retail_no_slab" class="margin_price" autocomplete="off" value="0.00">
							    </div>
					        </div>
					    </div>
					</div>

					<h3>Wholesale Price Range</h3>
					<div class="retail-wholesale-dummy group_wholesale_dummy">
					  	<div data-repeater-list="group_dummy_wholesale" class="div-table">

						    <div class="div-table-row">
							    <div class="div-table-head">S.No</div>
							    <div class="div-table-head">From Weight</div>
							    <div class="div-table-head">To Weight</div>
							    <div class="div-table-head">Discount Price</div>
							    <div class="div-table-head">End Price</div>
							    <div class="div-table-head">Option</div>
							</div>

					    	<div data-repeater-item class="repeterin div-table-row">
								<div class="div-table-col rowno">1</div>
							    <div class="div-table-col">
							    	<input type="text" name="weight_from" class="weight_from" autocomplete="off" value="0.1">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="weight_to" class="weight_to" autocomplete="off" value="4.99">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="price" class="price" autocomplete="off" value="0.00">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="margin_price" class="margin_price" autocomplete="off" value="0.00">
							    </div>
							    <div class="div-table-col">
							    	<a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
							    	<input type="hidden" value="Delete"/>
							    </div>
					        </div>

					    </div>
							<ul class="icons-labeled">
								<li><a href="javascript:void(0);" id="add_new_price_range2" data-repeater-create><span class="icon-block-color add-c"></span>Add Price Range Wholesale</a></li>
							</ul>
					</div>


					<div class="wholesale_no_slab_dummy" style="display:none;">
					  	<div class="div-table">

						    <div class="div-table-row">
							    <div class="div-table-head" style="display:none;">From Weight</div>
							    <div class="div-table-head" style="display:none;">To Weight</div>
							    <div class="div-table-head">Bag Count</div>
							    <div class="div-table-head">Price/Bag</div>
							    <div class="div-table-head">End Price/Bag</div>
							</div>

					    	<div data-repeater-item class="repeterin div-table-row">
							    <div class="div-table-col" style="display: none;">
							    	<input type="text" name="bag_weight_from_wholesale_no_slab" class="weight_from" autocomplete="off" value="1">
							    </div>
							    <div class="div-table-col" style="display: none;">
							    	<input type="text" name="bag_weight_to_wholesale_no_slab" class="weight_to" autocomplete="off" value="5">
							    </div>
							    <div class="div-table-col">
							    	<div>1</div>
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="bag_weight_price_wholesale_no_slab" class="price" autocomplete="off" value="0.00">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="bag_weight_margin_price_wholesale_no_slab" class="margin_price" autocomplete="off" value="0.00">
							    </div>
					        </div>

					    </div>
					</div>



				</div>
			</div>



		<div class="button_sub">
			<button type="submit" name="new_customer_list" id="btn_submit" class="submit-button">Submit</button>
		</div>
	</form>



</div>


<script type="text/javascript">
  
    jQuery('.retail-repeater').repeater({
        defaultValues: {
            'textarea-input': 'foo',
            'text-input': 'bar',
            'select-input': 'B',
            'checkbox-input': ['A', 'B'],
            'radio-input': 'B'
        },
        show: function () {
          var count = 1;
          jQuery('.retail-repeater .repeterin').each(function(){
            jQuery(this).find('.rowno').text(count);
            count++;
          })
          jQuery(this).slideDown();
          var from_to = retailPriceRange(jQuery('.popup_form #product_name').val(), 'retail', this, 'retail_original');
          jQuery(this).find('.weight_from').val(from_to.from);
          jQuery(this).find('.weight_to').val(from_to.to);
          setPriceDifferent(jQuery('.popup_form #product_name').val(), 'retail', this, from_to.from, 'retail_original');



        },
        hide: function (deleteElement) {
            if(confirm('Are you sure you want to delete this element?')) {
                jQuery(this).slideUp(deleteElement);
                var count = 1;
                jQuery('.retail-repeater .repeterin').each(function(){ 
                  jQuery(this).find('.rowno').text(count);
                  count++;
                })
            }
        },
        ready: function (setIndexes) {

        }
    });

    jQuery('.retail-wholesale').repeater({
        defaultValues: {
            'textarea-input': 'foo',
            'text-input': 'bar',
            'select-input': 'B',
            'checkbox-input': ['A', 'B'],
            'radio-input': 'B'
        },
        show: function () {
          var count = 1;
          jQuery('.retail-wholesale .repeterin').each(function(){
            jQuery(this).find('.rowno').text(count);
            count++;
          })
          jQuery(this).slideDown();

          var from_to = wholesalePriceRange(jQuery('.popup_form #product_name').val(), 'wholesale', this, 'wholesale_original');
          jQuery(this).find('.weight_from').val(from_to.from);
          jQuery(this).find('.weight_to').val(from_to.to);
          setPriceDifferent(jQuery('.popup_form #product_name').val(), 'wholesale', this, from_to.from, 'wholesale_original');

        },
        hide: function (deleteElement) {
            if(confirm('Are you sure you want to delete this element?')) {
                jQuery(this).slideUp(deleteElement);
                var count = 1;
                jQuery('.retail-wholesale .repeterin').each(function(){ 
                  jQuery(this).find('.rowno').text(count);
                  count++;
                })
                
            }
        },
        ready: function (setIndexes) {
        }
    });







    /*second set*/

    jQuery('.retail-repeater-dummy').repeater({
        defaultValues: {
            'textarea-input': 'foo',
            'text-input': 'bar',
            'select-input': 'B',
            'checkbox-input': ['A', 'B'],
            'radio-input': 'B'
        },
        show: function () {
			var count = 1;
			jQuery('.retail-repeater-dummy .repeterin').each(function(){
			jQuery(this).find('.rowno').text(count);
				count++;
			})
          	jQuery(this).slideDown();

			var from_to = retailPriceRange(jQuery('.popup_form #product_name').val(), 'retail', this, 'retail_dummy');
			jQuery(this).find('.weight_from').val(from_to.from);
			jQuery(this).find('.weight_to').val(from_to.to);
			setPriceDifferent(jQuery('.popup_form #product_name').val(), 'retail', this, from_to.from, 'retail_dummy');


        },
        hide: function (deleteElement) {
            if(confirm('Are you sure you want to delete this element?')) {
                jQuery(this).slideUp(deleteElement);
                var count = 1;
                jQuery('.retail-repeater-dummy .repeterin').each(function(){ 
                  jQuery(this).find('.rowno').text(count);
                  count++;
                })
                
            }
        },
        ready: function (setIndexes) {

        }
    });

    jQuery('.retail-wholesale-dummy').repeater({
        defaultValues: {
            'textarea-input': 'foo',
            'text-input': 'bar',
            'select-input': 'B',
            'checkbox-input': ['A', 'B'],
            'radio-input': 'B'
        },
        show: function () {
          	var count = 1;
          	jQuery('.retail-wholesale-dummy .repeterin').each(function(){
            	jQuery(this).find('.rowno').text(count);
            	count++;
          	})
          	jQuery(this).slideDown();

			var from_to = retailPriceRange(jQuery('.popup_form #product_name').val(), 'wholesale', this, 'wholesale_dummy');
			jQuery(this).find('.weight_from').val(from_to.from);
			jQuery(this).find('.weight_to').val(from_to.to);
			setPriceDifferent(jQuery('.popup_form #product_name').val(), 'wholesale', this, from_to.from, 'wholesale_dummy');

        },
        hide: function (deleteElement) {
            if(confirm('Are you sure you want to delete this element?')) {
                jQuery(this).slideUp(deleteElement);
                var count = 1;
                jQuery('.retail-wholesale-dummy .repeterin').each(function(){ 
                  jQuery(this).find('.rowno').text(count);
                  count++;
                })
                
            }
        },
        ready: function (setIndexes) {
        }
    });

</script>