<?php
    /*Updated for filter 11/10/16*/
    if(isset($_POST['action']) && $_POST['action'] == 'stock_sale_filter_list') {
        $ppage = $_POST['per_page'];
        $lot_number = $_POST['lot_number'];
        $search_brand = $_POST['search_brand'];
        $search_product = $_POST['search_product'];
        $item_status = $_POST['item_status'];
        $bill_type = $_POST['bill_type'];

        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];

    } else {
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
        $search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
        $search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
        $item_status = isset( $_GET['item_status'] ) ? $_GET['item_status']  : '-';
        $bill_type = isset( $_GET['bill_type'] ) ? $_GET['bill_type']  : '-';

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

<div class="search_bar stock_sale_filter">

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
    <input type="text" name="date_from" id="date_from" autocomplete="off" value="<?php echo $date_from; ?>" placeholder="Date From">
    <input type="text" name="date_to" id="date_to" autocomplete="off" value="<?php echo $date_to; ?>" placeholder="Date To">   

    <select name="item_status" id="item_status">
        <option value="-" <?php echo ($item_status == '-') ? 'selected' : ''; ?>>Item Status</option>
        <option value="open" <?php echo ($item_status == 'open') ? 'selected' : ''; ?>>Open</option>
        <option value="delivered" <?php echo ($item_status == 'delivered') ? 'selected' : ''; ?>>Delivered</option>
        <option value="return" <?php echo ($item_status == 'return') ? 'selected' : ''; ?>>Return</option>
    </select>

    <select name="bill_type" id="bill_type">
        <option value="-" <?php echo ($bill_type == '-') ? 'selected' : ''; ?>>Bill Type</option>
        <option value="original" <?php echo ($bill_type == 'original') ? 'selected' : ''; ?>>Original</option>
        <option value="duplicate" <?php echo ($bill_type == 'duplicate') ? 'selected' : ''; ?>>Duplicate</option>
        <option value="out_stock" <?php echo ($bill_type == 'out_stock') ? 'selected' : ''; ?>>Out Stock</option>
        <option value="rice_center" <?php echo ($bill_type == 'rice_center') ? 'selected' : ''; ?>>Rice Center</option>
        <option value="rice_mandy" <?php echo ($bill_type == 'rice_mandy') ? 'selected' : ''; ?>>Rice Mandy</option>
    </select>  

</div>


<div class="widget-content module table-simple list_customers">
<?php require( get_template_directory().'/inc/admin/report/list-template/list-sale-detail.php' ); ?>
</div>