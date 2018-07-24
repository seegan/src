<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'lot_list_filter') {
		$ppage = $_POST['per_page'];
		$lot_number = $_POST['lot_number'];
		$search_brand = $_POST['search_brand'];
		$search_product = $_POST['search_product'];
		$stock_total = $_POST['stock_total'];
		$sale_total = $_POST['sale_total'];
		$stock_bal = $_POST['stock_bal'];

        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];

	} else {
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
		$search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
		$search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
		$stock_total = isset( $_GET['stock_total'] ) ? $_GET['stock_total']  : '';
		$sale_total = isset( $_GET['sale_total'] ) ? $_GET['sale_total']  : '';
		$stock_bal = isset( $_GET['stock_bal'] ) ? $_GET['stock_bal']  : '';

        $date_from = isset( $_GET['date_from'] ) ? $_GET['date_from']  : '';
        $date_to = isset( $_GET['date_to'] ) ? $_GET['date_to']  : '';
	}
	/*End Updated for filter 11/10/16*/
?>



<div style="width: 100%;">
	<ul class="icons-labeled">
		
	</ul>
</div>
<div class="widget-top">
	<h4>Customer List</h4>
</div>

<div class="search_bar stock_report_filter">
	<label>Page :</label>
	<select name="per_page" id="per_page">
		<option value="5" <?php echo ($ppage == 5) ? 'selected' : ''; ?>>5</option>
		<option value="10" <?php echo ($ppage == 10) ? 'selected' : ''; ?>>10</option>
		<option value="15" <?php echo ($ppage == 15) ? 'selected' : ''; ?>>15</option>

		<option value="20" <?php echo ($ppage == 20) ? 'selected' : ''; ?>>20</option>
		<option value="50" <?php echo ($ppage == 50) ? 'selected' : ''; ?>>50</option>
		<option value="100" <?php echo ($ppage == 100) ? 'selected' : ''; ?>>100</option>
	</select>
	<input type="text" name="lot_number" id="lot_number" autocomplete="off" value="<?php echo $lot_number; ?>" placeholder="Lot Number">
	<input type="text" name="search_brand" id="search_brand" autocomplete="off" value="<?php echo $search_brand; ?>" placeholder="Brand Name">
	<input type="text" name="search_product" id="search_product" autocomplete="off" value="<?php echo $search_product; ?>" placeholder="Product Name">	
	<input type="text" name="stock_total" id="stock_total" autocomplete="off" value="<?php echo $stock_total; ?>" placeholder="Stock Total">
	<input type="text" name="sale_total" id="sale_total" autocomplete="off" value="<?php echo $sale_total; ?>" placeholder="Sale Total">
	<input type="text" name="stock_bal" id="stock_bal" autocomplete="off" value="<?php echo $stock_bal; ?>" placeholder="Stock Balance">	
</div>


<div class="widget-content module table-simple list_customers">
<?php require( get_template_directory().'/inc/admin/report/list-template/list-stock-detail.php' ); ?>
</div>