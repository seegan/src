<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'lot_list_filter') {
		$ppage = $_POST['per_page'];
		$lot_number = $_POST['lot_number'];
		$search_brand = $_POST['search_brand'];
		$search_product = $_POST['search_product'];
	} else {
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
		$search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
		$search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
	}
	/*End Updated for filter 11/10/16*/
?>



<div style="width: 100%;">
	<ul class="icons-labeled">
		<li><a href="javascript:void(0);" id="my-button" class="popup-add-lot"><span class="icon-block-color add-c"></span>Add New Lot</a></li>
	</ul>
</div>
<div class="widget-top">
	<h4>Customer List</h4>
</div>

<div class="search_bar lot_filter">
	<label>Page :</label>
	<select name="per_page" id="per_page">
		<option value="5" <?php echo ($ppage == 5) ? 'selected' : ''; ?>>5</option>
		<option value="10" <?php echo ($ppage == 10) ? 'selected' : ''; ?>>10</option>
		<option value="15" <?php echo ($ppage == 15) ? 'selected' : ''; ?>>15</option>

		<option value="20" <?php echo ($ppage == 20) ? 'selected' : ''; ?>>20</option>
		<option value="50" <?php echo ($ppage == 50) ? 'selected' : ''; ?>>50</option>
		<option value="100" <?php echo ($ppage == 100) ? 'selected' : ''; ?>>100</option>
	</select>
	<label>Lot Number :</label>
	<input type="text" name="search_lot" id="search_lot" autocomplete="off" value="<?php echo $lot_number; ?>">

	<label>Brand Name :</label>
	<input type="text" name="search_brand" id="search_brand" autocomplete="off" value="<?php echo $search_brand; ?>">

	<label>Product Name :</label>
	<input type="text" name="search_product" id="search_product" autocomplete="off" value="<?php echo $search_product; ?>">	
</div>


<div class="widget-content module table-simple list_customers">
<?php require( get_template_directory().'/inc/admin/list_template/list_lots.php' ); ?>
</div>

<script type="text/javascript">
	jQuery('#product_name').live('change', function() {
		if(jQuery(this).val() == 'Others') {
			jQuery('#product_name1').css('display','block');
		} else {
			jQuery('#product_name1').css('display','none');
		}
	})
</script>