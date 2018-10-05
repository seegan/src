<?php
$lot_id = isset( $_POST['id'] ) ? $_POST['id'] : 0;
$lot_details = get_lot($lot_id);

$original_slab_system = $lot_details['lot_data']->slab_system;
$original_bag_weight = $lot_details['lot_data']->bag_weight;

$dummy_slab_system = $lot_details['dummy_lot_data']->slab_system;

$gst_percentage = $lot_details['lot_data']->gst_percentage;


//echo "<pre>";
//var_dump($lot_details);
?>
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
	<form method="post" name="edit_lot" id="edit_lot" class="popup_form edit_lot" onsubmit="return false;">
		<input type="hidden" name="lot_id" value="<?php echo $lot_details['lot_original_id']; ?>">
		<input type="hidden" name="dummy_lot_id" value="<?php echo $lot_details['lot_dummy_id']; ?>">
		<div class="form_detail">
			<label>Enter Lot
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="lot_number" value="<?php echo $lot_details['lot_number']; ?>" name="lot_number">
		</div>
		<div class="form_detail">
			<label style="width: 115px;">Customer Bill Display Name
			</label>
			<input type="text" id="brand_name" name="brand_name" autocomplete="off" value="<?php echo $lot_details['lot_data']->brand_name; ?>">
		</div>
	<!-- 	<div class="form_detail">
			<label style="width: 115px;">Search Name
			</label>
			<span>
				<input type="text" id="search_name" name="search_name" autocomplete="off" value="<?php //echo $lot_details['lot_data']->search_name; ?>">
			</span>
		</div> -->
		<div class="form_detail">
			<label>Product Type
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<select name="product_name" id="product_name">
		        <option selected><?php echo $lot_details['lot_data']->product_name; ?></option>
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
		        <option>Atta</option>
		        <option>Oil</option>
		        <option>Others</option>
		    </select>  
		</div>

		<div class="form_detail"  id="product_name1"  style="display:none;">
			<label style="width: 115px;">Product Name
			</label>
			<input type="text" name="product_name1">
		</div>

		<div class="form_detail">
			<label style="width: 115px;">Bag Weight/Count
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<select name="weight" class="bag_weight_total" style="width:20%;">
				<option <?php echo ($lot_details['lot_data']->weight == 0.25) ? 'selected' : ''; ?> value="0.25">1/4</option>
				<option <?php echo ($lot_details['lot_data']->weight == 0.5) ? 'selected' : ''; ?> value="0.5">1/2</option>
				<option <?php echo ($lot_details['lot_data']->weight == 0.75) ? 'selected' : ''; ?> value="0.75">3/4</option>
				<option <?php echo ($lot_details['lot_data']->weight == 1) ? 'selected' : ''; ?> value="1">1</option>
				<option <?php echo ($lot_details['lot_data']->weight == 2) ? 'selected' : ''; ?> value="2">2</option>
				<option <?php echo ($lot_details['lot_data']->weight == 5) ? 'selected' : ''; ?> value="5">5</option>
				<option <?php echo ($lot_details['lot_data']->weight == 10) ? 'selected' : ''; ?> value="10">10</option>
				<option <?php echo ($lot_details['lot_data']->weight == 20) ? 'selected' : ''; ?> value="20">20</option>
				<option <?php echo ($lot_details['lot_data']->weight == 25) ? 'selected' : ''; ?> value="25">25</option>
				<option <?php echo ($lot_details['lot_data']->weight == 30) ? 'selected' : ''; ?> value="30">30</option>
				<option <?php echo ($lot_details['lot_data']->weight == 50) ? 'selected' : ''; ?> value="50">50</option>
				<option <?php echo ($lot_details['lot_data']->weight == 75) ? 'selected' : ''; ?> value="75">75</option>
			</select>
			<select style="width:30%;" name="bag_weight_type">
				<option <?php echo ($lot_details['lot_data']->unit_type == 'kg') ? 'selected' : ''; ?> value="kg">Kg</option>
				<option <?php echo ($lot_details['lot_data']->unit_type == 'pc') ? 'selected' : ''; ?> value="pc">Piece</option>
			</select>
		</div>
		<div class="form_detail">
			<label>
				Buying Price (Rs/Bag)
			</label>
			<div class="slab">
				<input type="text" name="buying_price" class="buying_price" id="buying_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $lot_details['lot_data']->buying_price; ?>">
			</div>
		</div>

		<div class="form_detail">
			<label>
				Stock Alert (Kg)
			</label>
			<div class="slab">
				<input type="text" name="stock_alert" class="stock_alert" onkeypress="return isNumberKey(event)" autocomplete="off" value="<?php echo $lot_details['lot_data']->stock_alert; ?>">
				<input type="hidden" name="slab_system" id="slab_system" value="<?php echo $original_bag_weight; ?>">
			</div>
		</div>
		<div class="form_detail">
			<label>
				HSN
			</label>
			<div class="slab">
				<input type="text" name="hsn_code" class="hsn_code" onkeypress="return isNumberKey(event)" autocomplete="off" value="<?php echo $lot_details['lot_data']->hsn_code; ?>">
			</div>
		</div>

		<div class="form_detail">
			<label style="width: 115px;">GST %
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<select name="gst_percentage">
				<option <?php echo ($gst_percentage == 0.00) ? 'selected' : ''; ?> value="0.00">0%</option>
				<option <?php echo ($gst_percentage == 5.00) ? 'selected' : ''; ?> value="5.00">5.00%</option>
				<option <?php echo ($gst_percentage == 12.00) ? 'selected' : ''; ?> value="12.00">12.00%</option>
				<option <?php echo ($gst_percentage == 18.00) ? 'selected' : ''; ?> value="18.00">18.00%</option>
				<option <?php echo ($gst_percentage == 28.00) ? 'selected' : ''; ?> value="28.00">28.00%</option>
			</select>
		</div>

		<div class="form_detail">
			<label>Slab System?
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<div style="float:right;margin-top: 10px;" class="bagweight">
				<input type="radio" name="bag_weight" class="bag_weight" value="1" <?php echo ($original_bag_weight == '1') ? 'checked' : ''; ?>>Yes(Kg)&nbsp;&nbsp;
				<input type="radio" name="bag_weight" class="bag_weight" value="0" <?php echo ($original_bag_weight == '1') ? '' : 'checked'; ?>>No(Bag)
			</div>
		</div>
		<div class="form_detail">
			<label>
				MRP
			</label>
			<div class="slab">
				<input type="text" name="basic_price" class="basic_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $lot_details['lot_data']->basic_price; ?>">
			</div>
		</div>

		<div style="clear:both;"></div>
		<div class="table-simple price_range" style="width: 97%;">
			<h3>Retail Sale Price Range</h3>


				<div class="retail-repeater group_retail" style="display:<?php echo ($original_slab_system == '1') ? 'block' : 'none'; ?>;">

				  	<div data-repeater-list="group_retail" class="div-table">
					    <div class="div-table-row">
						    <div class="div-table-head">S.No</div>
						    <div class="div-table-head">From Weight</div>
						    <div class="div-table-head">To Weight</div>
						    <div class="div-table-head">Discountant Price</div>
						    <div class="div-table-head">End Price</div>
						    <div class="div-table-head">Option</div>
						</div>

<?php
if( $lot_details['original_retail'] && $original_slab_system == '1' && count($lot_details['original_retail'])>0 ) {
	foreach ($lot_details['original_retail'] as $or_value) {
?>
				    	<div data-repeater-item class="repeterin div-table-row">
							<div class="div-table-col rowno">1</div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_from" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $or_value->weight_from; ?>">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_to" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $or_value->weight_to; ?>">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $or_value->price; ?>">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="margin_price" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $or_value->margin_price; ?>">
						    </div>
						    <div class="div-table-col">
						    	<a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
						    	<input type="hidden" value="Delete"/>
						    </div>
				        </div>
<?php
	}
} else {
?>
				    	<div data-repeater-item class="repeterin div-table-row">
							<div class="div-table-col rowno">1</div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_from" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_to" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="margin_price" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
						    	<input type="hidden" value="Delete"/>
						    </div>
				        </div>

<?php
}

?>
				    </div>

				    	<ul class="icons-labeled">
							<li><a data-repeater-create href="javascript:void(0);" id="add_new_price_range"><span class="icon-block-color add-c"></span>Add Price Range Retail Sale</a></li>
						</ul>
				</div>



				<div class="group_retail_no_slab" style="display:<?php echo ($original_slab_system == '1') ? 'none' : 'block'; ?>;">
				  	<div class="div-table">

					    <div class="div-table-row">
						    <div class="div-table-head" style="display:none;">From Weight</div>
						    <div class="div-table-head" style="display:none;">To Weight</div>
						    <div class="div-table-head">Bag Count</div>
						    <div class="div-table-head">Discountant Price/Bag</div>
						    <div class="div-table-head">End Price/Bag</div>
						</div>

<?php
if( $lot_details['original_retail'] && $original_slab_system != '1' && count($lot_details['original_retail'])>0 ) {
	foreach ($lot_details['original_retail'] as $orns_value) {
?>
				    	<div data-repeater-item class="repeterin div-table-row">
						    <div class="div-table-col" style="display:none;">
						    	<input type="text" name="weight_from_retail_no_slab" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $orns_value->weight_from; ?>">
						    </div>
						    <div class="div-table-col" style="display:none;">
						    	<input type="text" name="weight_to_retail_no_slab" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $orns_value->weight_to; ?>">
						    </div>
						    <div class="div-table-col">
						    	<div>1</div>
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price_retail_no_slab" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $orns_value->price; ?>" value="0.00">
						    </div>
						     <div class="div-table-col">
						    	<input type="text" name="margin_price_retail_no_slab" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $orns_value->margin_price; ?>" value="0.00">
						    </div>
				        </div>
<?php
	}
} else {
?>
				    	<div data-repeater-item class="repeterin div-table-row">
						    <div class="div-table-col" style="display:none;">
						    	<input type="text" name="weight_from_retail_no_slab" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="1">
						    </div>
						    <div class="div-table-col" style="display:none;">
						    	<input type="text" name="weight_to_retail_no_slab" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="5">
						    </div>
						    <div class="div-table-col">
						    	<div>1</div>
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price_retail_no_slab" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="0.00">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="margin_price_retail_no_slab" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="0.00">
						    </div>
				        </div>
<?php
}
?>
				    </div>
				</div>


			<h3>Wholesale Price Range</h3>

				<div class="retail-wholesale group_wholesale" style="display:<?php echo ($original_slab_system == '1') ? 'block' : 'none'; ?>;">
				  	<div data-repeater-list="group_wholesale" class="div-table">

					    <div class="div-table-row">
						    <div class="div-table-head">S.No</div>
						    <div class="div-table-head">From Weight</div>
						    <div class="div-table-head">To Weight</div>
						   	<div class="div-table-head">Discountant Price</div>
							<div class="div-table-head">End Price</div>
						    <div class="div-table-head">Option</div>
						</div>

<?php
if( $lot_details['original_wholesale'] && $original_slab_system == '1' && count($lot_details['original_wholesale'])>0 ) {
	foreach ($lot_details['original_wholesale'] as $ow_value) {
?>
				    	<div data-repeater-item class="repeterin div-table-row">
							<div class="div-table-col rowno">1</div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_from" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $ow_value->weight_from; ?>">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_to" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $ow_value->weight_to; ?>">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $ow_value->price; ?>">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="margin_price" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $ow_value->margin_price; ?>">
						    </div>
						    <div class="div-table-col">
						    	<a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
						    	<input type="hidden" value="Delete"/>
						    </div>
				        </div>
<?php
	}
} else {
?>
				    	<div data-repeater-item class="repeterin div-table-row">
							<div class="div-table-col rowno">1</div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_from" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_to" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						     <div class="div-table-col">
						    	<input type="text" name="margin_price" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
						    	<input type="hidden" value="Delete"/>
						    </div>
				        </div>

<?php
}

?>
				    </div>
						<ul class="icons-labeled">
							<li><a href="javascript:void(0);" id="add_new_price_range2" data-repeater-create><span class="icon-block-color add-c"></span>Add Price Range Wholesale</a></li>
						</ul>
				</div>

		
				<div class="wholesale_no_slab" style="display:<?php echo ($original_slab_system == '1') ? 'none' : 'block'; ?>;">
				  	<div class="div-table">

					    <div class="div-table-row">
						    <div class="div-table-head" style="display:none;">From Weight</div>
						    <div class="div-table-head" style="display:none;">To Weight</div>
						    <div class="div-table-head">Bag Count</div>
						   <div class="div-table-head">Discountant Price/Bag</div>
						    <div class="div-table-head">End Price/Bag</div>
						</div>
<?php
if( $lot_details['original_wholesale'] && $original_slab_system != '1' && count($lot_details['original_wholesale'])>0 ) {
	foreach ($lot_details['original_wholesale'] as $owns_value) {
?>
				    	<div data-repeater-item class="repeterin div-table-row">
						    <div class="div-table-col" style="display:none;">
						    	<input type="text" name="weight_from_wholesale_no_slab" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $owns_value->weight_from; ?>">
						    </div>
						    <div class="div-table-col" style="display:none;">
						    	<input type="text" name="weight_to_wholesale_no_slab" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $owns_value->weight_to; ?>">
						    </div>
						    <div class="div-table-col">
						    	<div>1</div>
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price_wholesale_no_slab" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $owns_value->price; ?>">
						    </div>
						     <div class="div-table-col">
						    	<input type="text" name="margin_price_wholesale_no_slab" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $owns_value->margin_price; ?>">
						    </div>
				        </div>
<?php
	}
} else {
?>
				    	<div data-repeater-item class="repeterin div-table-row">
						    <div class="div-table-col" style="display:none;">
						    	<input type="text" name="weight_from_wholesale_no_slab" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="1">
						    </div>
						    <div class="div-table-col" style="display:none;">
						    	<input type="text" name="weight_to_wholesale_no_slab" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="5">
						    </div>
						    <div class="div-table-col">
						    	<div>1</div>
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price_wholesale_no_slab" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="0.00">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="margin_price_wholesale_no_slab" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="0.00">
						    </div>
				        </div>
<?php
}
?>
				    </div>
				</div>

			</div>


			<div style="clear:both;"></div>

			<div class="dummy_slot_number" style="margin-top:20px;">
				<div class="form_detail">
					<label>Dummy Lot Number
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<input type="text" id="dummy_slot_number" name="dummy_slot_number" value="<?php echo ($lot_details['dummy_lot_data'] && $lot_details['dummy_lot_data']->lot_number) ? $lot_details['dummy_lot_data']->lot_number : ''; ?>" autocomplete="off">
				</div>
				<div class="form_detail">
					<label>
						Customer Bill Display Name
					</label>
					<div class="slab">
						<input type="text" name="dummy_brand_name" id="dummy_brand_name" autocomplete="off" value="<?php echo ($lot_details['dummy_lot_data'] && $lot_details['dummy_lot_data']->brand_name) ? $lot_details['dummy_lot_data']->brand_name : ''; ?>">
					</div>
				</div>
				<div class="form_detail">
					<label style="width: 115px;">Dummy Lot Search Name
					</label>
					<span>
						<input type="text" id="search_name_dummy" name="search_name_dummy" autocomplete="off" value="<?php echo ($lot_details['dummy_lot_data'] && $lot_details['dummy_lot_data']->brand_name) ? $lot_details['dummy_lot_data']->search_name : ''; ?>">
					</span>
				</div>
				<div class="form_detail">
					<label style="width: 115px;">Weight
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<select name="dummy_weight" class="dummy_bag_weight_total" style="width:20%;">
						<option <?php echo ($lot_details['dummy_lot_data']->weight == 0.25) ? 'selected' : ''; ?> value="0.25">1/4</option>
						<option <?php echo ($lot_details['dummy_lot_data']->weight == 0.5) ? 'selected' : ''; ?> value="0.5">1/2</option>
						<option <?php echo ($lot_details['dummy_lot_data']->weight == 0.75) ? 'selected' : ''; ?> value="0.75">3/4</option>
						<option <?php echo ($lot_details['dummy_lot_data']->weight == 1) ? 'selected' : ''; ?> value="1">1</option>
						<option <?php echo ($lot_details['dummy_lot_data']->weight == 2) ? 'selected' : ''; ?> value="2">2</option>
						<option <?php echo ($lot_details['dummy_lot_data']->weight == 5) ? 'selected' : ''; ?> value="5">5</option>
						<option <?php echo ($lot_details['dummy_lot_data']->weight == 10) ? 'selected' : ''; ?> value="10">10</option>
						<option <?php echo ($lot_details['dummy_lot_data']->weight == 20) ? 'selected' : ''; ?> value="20">20</option>
						<option <?php echo ($lot_details['dummy_lot_data']->weight == 25) ? 'selected' : ''; ?> value="25">25</option>
						<option <?php echo ($lot_details['dummy_lot_data']->weight == 30) ? 'selected' : ''; ?> value="30">30</option>
						<option <?php echo ($lot_details['dummy_lot_data']->weight == 50) ? 'selected' : ''; ?> value="50">50</option>
						<option <?php echo ($lot_details['dummy_lot_data']->weight == 75) ? 'selected' : ''; ?> value="75">75</option>
					</select>
					<select style="width:30%;" name="dummy_bag_weight_type">
						<option <?php echo ($lot_details['dummy_lot_data']->unit_type == 'kg') ? 'selected' : ''; ?> value="kg">Kg</option>
						<option <?php echo ($lot_details['dummy_lot_data']->unit_type == 'pc') ? 'selected' : ''; ?> value="pc">Piece</option>
					</select>
				</div>
				<div class="form_detail">
					<label>Slab System ?
						<abbr class="require" title="Required Field">*</abbr>
					</label>
					<div style="float:right;margin-top: 10px;" class="slab">
						<input type="radio" name="dummy_slab_system" class="dummy_slab_system" value="1" <?php echo (isset($lot_details['dummy_lot_data']->slab_system) && $dummy_slab_system == '1') ? 'checked' : '' ?>>Yes(Kg) &nbsp;&nbsp;
						<input type="radio" name="dummy_slab_system" class="dummy_slab_system" value="0" <?php echo (isset($lot_details['dummy_lot_data']->slab_system) && $dummy_slab_system == '1') ? '' : 'checked' ?>>No(Bag)
					</div>
				</div>
				<div class="form_detail">
					<label>
						MRP
					</label>
					<div class="slab">
						<input type="text" name="dummy_basic_price" class="dummy_basic_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $lot_details['dummy_lot_data']->basic_price; ?>">
					</div>
				</div>
				<div style="clear:both;"></div>
				<div class="table-simple price_range" style="width: 97%;">
					<h3>Retail Sale Price Range</h3>


					<div class="retail-repeater-dummy group_retail_dummy" style="display:<?php echo (isset($lot_details['dummy_lot_data']->slab_system) && $dummy_slab_system == '1') ? 'block' : 'none' ?>">
					  	<div data-repeater-list="group_dummy_retail" class="div-table">

						    <div class="div-table-row">
							    <div class="div-table-head">S.No</div>
							    <div class="div-table-head">From Weight</div>
							    <div class="div-table-head">To Weight</div>
							    <div class="div-table-head">Discount Price</div>
							    <div class="div-table-head">End Price</div>
							    <div class="div-table-head">Option</div>
							</div>
<?php
if( $lot_details['dummy_retail'] && $dummy_slab_system == '1' && count($lot_details['dummy_retail'])>0 ) {
	foreach ($lot_details['dummy_retail'] as $dr_value) {
?>
					    	<div data-repeater-item class="repeterin div-table-row">
								<div class="div-table-col rowno">1</div>
							    <div class="div-table-col">
							    	<input type="text" name="weight_from" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $dr_value->weight_from; ?>">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="weight_to" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $dr_value->weight_to; ?>">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="price" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $dr_value->price; ?>">
							    </div>
							     <div class="div-table-col">
							    	<input type="text" name="margin_price" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $dr_value->margin_price; ?>">
							    </div>
							    <div class="div-table-col">
							    	<a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
							    	<input type="hidden" value="Delete"/>
							    </div>
					        </div>
<?php
	}
} else {
?>
				    	<div data-repeater-item class="repeterin div-table-row">
							<div class="div-table-col rowno">1</div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_from" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_to" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						     <div class="div-table-col">
						    	<input type="text" name="margin_price" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
						    	<input type="hidden" value="Delete"/>
						    </div>
				        </div>

<?php
}

?>
					    </div>
					    	<ul class="icons-labeled">
								<li><a data-repeater-create href="javascript:void(0);" id="add_new_price_range"><span class="icon-block-color add-c"></span>Add Price Range Retail Sale</a></li>
							</ul>
					</div>

					<div class="retail_no_slab_dummy" style="display:<?php echo (isset($lot_details['dummy_lot_data']->slab_system) && $dummy_slab_system == '1') ? 'none' : 'block' ?>">
					  	<div class="div-table">

						    <div class="div-table-row">
						    	<div class="div-table-head">Bag Count</div>
							    <div class="div-table-head" style="display:none;">From Weight</div>
							    <div class="div-table-head" style="display:none;">To Weight</div>
							    <div class="div-table-head">Price/Bag</div>
							    <div class="div-table-head">End Price/Bag</div>
							</div>

<?php
if( $lot_details['dummy_retail'] && $dummy_slab_system != '1' && count($lot_details['dummy_retail'])>0 ) {
	foreach ($lot_details['dummy_retail'] as $drns_value) {
?>
					    	<div data-repeater-item class="repeterin div-table-row">
							    <div class="div-table-col" style="display:none;">
							    	<input type="text" name="bag_weight_from_retail_no_slab" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off"  value="<?php echo $drns_value->weight_from; ?>">
							    </div>
							    <div class="div-table-col" style="display:none;">
							    	<input type="text" name="bag_weight_to_retail_no_slab" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off"  value="<?php echo $drns_value->weight_to; ?>">
							    </div>
							    <div class="div-table-col">
						    		<div>1</div>
						    	</div>
							    <div class="div-table-col">
							    	<input type="text" name="bag_weight_price_retail_no_slab" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off"  value="<?php echo $drns_value->price; ?>">
							    </div>
							     <div class="div-table-col">
							    	<input type="text" name="bag_weight_margin_price_retail_no_slab" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off"  value="<?php echo $drns_value->margin_price; ?>">
							    </div>
					        </div>
<?php
	}
} else {
?>
					    	<div data-repeater-item class="repeterin div-table-row">
							    <div class="div-table-col" style="display:none;">
							    	<input type="text" name="bag_weight_from_retail_no_slab" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
							    </div>
							    <div class="div-table-col" style="display:none;">
							    	<input type="text" name="bag_weight_to_retail_no_slab" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
							    </div>
							    <div class="div-table-col">
						    		<div>1</div>
						    	</div>
							    <div class="div-table-col">
							    	<input type="text" name="bag_weight_price_retail_no_slab" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="0.00">
							    </div>
							     <div class="div-table-col">
							    	<input type="text" name="bag_weight_margin_price_retail_no_slab" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="0.00">
							    </div>
					        </div>
<?php	
}
?>

					    </div>
					</div>

					<h3>Wholesale Price Range</h3>
					<div class="retail-wholesale-dummy group_wholesale_dummy" style="display:<?php echo (isset($lot_details['dummy_lot_data']->slab_system) && $lot_details['dummy_lot_data']->slab_system == '1') ? 'block' : 'none' ?>">
					  	<div data-repeater-list="group_dummy_wholesale" class="div-table">

						    <div class="div-table-row">
							    <div class="div-table-head">S.No</div>
							    <div class="div-table-head">From Weight</div>
							    <div class="div-table-head">To Weight</div>
							    <div class="div-table-head">Discount Price</div>
							    <div class="div-table-head">End Price</div>
							    <div class="div-table-head">Option</div>
							</div>

<?php
if( $lot_details['dummy_wholesale'] && $dummy_slab_system == '1' && count($lot_details['dummy_wholesale'])>0 ) {
	foreach ($lot_details['dummy_wholesale'] as $dw_value) {
?>
					    	<div data-repeater-item class="repeterin div-table-row">
								<div class="div-table-col rowno">1</div>
							    <div class="div-table-col">
							    	<input type="text" name="weight_from" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $dw_value->weight_from; ?>">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="weight_to" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $dw_value->weight_to; ?>">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="price" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $dw_value->price; ?>">
							    </div>
							     <div class="div-table-col">
							    	<input type="text" name="margin_price" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $dw_value->margin_price; ?>">
							    </div>
							    <div class="div-table-col">
							    	<a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
							    	<input type="hidden" value="Delete"/>
							    </div>
					        </div>
<?php
	}
} else {
?>
				    	<div data-repeater-item class="repeterin div-table-row">
							<div class="div-table-col rowno">1</div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_from" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="weight_to" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<input type="text" name="price" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						     <div class="div-table-col">
						    	<input type="text" name="margin_price" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
						    </div>
						    <div class="div-table-col">
						    	<a href="#" data-repeater-delete style="font-size: 16px; font-weight: bold; color: #ff0000;" class="remove_price_range" data-id="2">x</a>
						    	<input type="hidden" value="Delete"/>
						    </div>
				        </div>

<?php
}

?>
					    </div>
							<ul class="icons-labeled">
								<li><a href="javascript:void(0);" id="add_new_price_range2" data-repeater-create><span class="icon-block-color add-c"></span>Add Price Range Wholesale</a></li>
							</ul>
					</div>


					<div class="wholesale_no_slab_dummy" style="display:<?php echo (isset($lot_details['dummy_lot_data']->slab_system) && $dummy_slab_system == '1') ? 'none' : 'block' ?>">
					  	<div class="div-table">

						    <div class="div-table-row">
							    <div class="div-table-head">Bag Count</div>
							    <div class="div-table-head" style="display:none;">From Weight</div>
							    <div class="div-table-head" style="display:none;">To Weight</div>
							    <div class="div-table-head">Price/Bag</div>
							    <div class="div-table-head">End Price/Bag</div>
							</div>
<?php
if( $lot_details['dummy_wholesale'] && $dummy_slab_system != '1' && count($lot_details['dummy_wholesale'])>0 ) {
	foreach ($lot_details['dummy_wholesale'] as $dwns_value) {
?>
					    	<div data-repeater-item class="repeterin div-table-row">
							    <div class="div-table-col" style="display:none;">
							    	<input type="text" name="bag_weight_from_wholesale_no_slab" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $dwns_value->weight_from; ?>">
							    </div>
							    <div class="div-table-col" style="display:none;">
							    	<input type="text" name="bag_weight_to_wholesale_no_slab" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $dwns_value->weight_to; ?>">
							    </div>
							    <div class="div-table-col">
						    		<div>1</div>
						    	</div>
							    <div class="div-table-col">
							    	<input type="text" name="bag_weight_price_wholesale_no_slab" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $dwns_value->price; ?>">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="bag_weight_margin_price_wholesale_no_slab" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $dwns_value->margin_price; ?>">
							    </div>
					        </div>
<?php
	}
} else {
?>

					    	<div data-repeater-item class="repeterin div-table-row">
							    <div class="div-table-col" style="display:none;">
							    	<input type="text" name="bag_weight_from_wholesale_no_slab" class="weight_from" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
							    </div>
							    <div class="div-table-col" style="display:none;">
							    	<input type="text" name="bag_weight_to_wholesale_no_slab" class="weight_to" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
							    </div>
							    <div class="div-table-col">
						    		<div>1</div>
						    	</div>
							    <div class="div-table-col">
							    	<input type="text" name="bag_weight_price_wholesale_no_slab" class="price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="0.00">
							    </div>
							    <div class="div-table-col">
							    	<input type="text" name="bag_weight_margin_price_wholesale_no_slab" class="margin_price" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="0.00">
							    </div>
					        </div>
<?php	
}
?>					        

					    </div>
					</div>



				</div>
			</div>



		<div class="button_sub">
			<button type="submit" name="edit_customer_list" id="btn_submit" class="submit-button">Submit</button>
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