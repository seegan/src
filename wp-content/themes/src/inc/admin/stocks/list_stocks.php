<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'stock_list_filter') {
		$ppage = $_POST['per_page'];
		$lot_number = $_POST['lot_number'];
		$search_brand = $_POST['search_brand'];
		$search_product = $_POST['search_product'];
		$search_from = $_POST['search_from'];
		$search_to = $_POST['search_to'];
	} else {
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
		$search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
		$search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
		$search_from = isset( $_GET['search_from'] ) ? $_GET['search_from']  : '';
		$search_to = isset( $_GET['search_to'] ) ? $_GET['search_to']  : '';
	}
	/*End Updated for filter 11/10/16*/
?>


<div style="width: 100%;">
	<ul class="icons-labeled">
		<li><a href="javascript:void(0);" id="my-button" class="popup-add-stock"><span class="icon-block-color add-c"></span>Add New Stock</a></li>
	</ul>
</div>
<div class="widget-top">
	<h4>Customer List</h4>
</div>

<div class="search_bar stock_filter">
	<label>Page :</label>
	<select name="per_page" id="per_page">
		<option value="5" <?php echo ($ppage == 5) ? 'selected' : ''; ?>>5</option>
		<option value="10" <?php echo ($ppage == 10) ? 'selected' : ''; ?>>10</option>
		<option value="15" <?php echo ($ppage == 15) ? 'selected' : ''; ?>>15</option>

		<option value="20" <?php echo ($ppage == 20) ? 'selected' : ''; ?>>20</option>
		<option value="50" <?php echo ($ppage == 50) ? 'selected' : ''; ?>>50</option>
		<option value="100" <?php echo ($ppage == 100) ? 'selected' : ''; ?>>100</option>
	</select>
	<input type="text" name="lot_number" id="lot_number" autocomplete="off" placeholder="Search by Lot Number" value="<?php echo $lot_number; ?>">
	<input type="text" name="search_brand" id="search_brand" autocomplete="off" placeholder="Search by Brand" value="<?php echo $search_brand; ?>">
	<input type="text" name="search_product" id="search_product" autocomplete="off" placeholder="Search by Product" value="<?php echo $search_product; ?>">
	<input type="text" name="search_from" id="search_from" autocomplete="off" placeholder="Stock Update From" value="<?php echo $search_from; ?>">
	<input type="text" name="search_to" id="search_to" autocomplete="off" placeholder="Stock Update To" value="<?php echo $search_to ?>">
</div>


<div class="widget-content module table-simple list_customers">
<?php include( get_template_directory().'/inc/admin/list_template/list_stocks.php' ); ?>
</div>