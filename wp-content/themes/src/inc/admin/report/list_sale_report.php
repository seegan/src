<?php
    /*Updated for filter 11/10/16*/
    if(isset($_POST['action']) && $_POST['action'] == 'stock_sale_filter_list') {
        $ppage = $_POST['per_page'];
        $lot_number = $_POST['lot_number'];
        $search_brand = $_POST['search_brand'];
        $search_product = $_POST['search_product'];
        $item_status = $_POST['item_status'];
        $lot_type = $_POST['lot_type'];

        $date_from = isset($_POST['date_from']) ? $_POST['date_from'] : date('Y-m-d');
        $date_to = $_POST['date_to'];

    } else {
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
        $search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
        $search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
        $item_status = isset( $_GET['item_status'] ) ? $_GET['item_status']  : '-';
        $lot_type = isset( $_GET['lot_type'] ) ? $_GET['lot_type']  : '-';

        $date_from = isset( $_GET['date_from'] ) ? $_GET['date_from']  : date('d-m-Y');
        $date_to = isset( $_GET['date_to'] ) ? $_GET['date_to']  : date('d-m-Y');
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
    <input type="text" name="date_from" id="date_from" autocomplete="off" value="<?php echo $date_from; ?>" placeholder="Date From">
    <input type="text" name="date_to" id="date_to" autocomplete="off" value="<?php echo $date_to; ?>" placeholder="Date To">  
    <select name="bill_type"  id="bill_type">
        <option value="-" <?php echo ($bill_type == '-') ? 'selected' : ''; ?>>Sale From (All)</option>
        <option value="original" <?php echo ($bill_type == 'original') ? 'selected' : ''; ?>>SRC</option>
        <option value="duplicate" <?php echo ($bill_type == 'duplicate') ? 'selected' : ''; ?>>Out Side Store</option>
    </select>
    <select name="item_status" id="item_status">
        <option value="-" <?php echo ($item_status == '-') ? 'selected' : ''; ?>>Sale ( Less Return )</option>
        <option value="sale" <?php echo ($item_status == 'sale') ? 'selected' : ''; ?>>Sale Only</option>
        <option value="return" <?php echo ($item_status == 'return') ? 'selected' : ''; ?>>Return Only</option>
    </select>
    <select name="lot_type" id="lot_type">
        <option value="-" <?php echo ($lot_type == '-') ? 'selected' : ''; ?>>Lot ( Seperate )</option>
        <option value="combained" <?php echo ($lot_type == 'combained') ? 'selected' : ''; ?>>Lot ( Combained )</option>
        <option value="original" <?php echo ($lot_type == 'original') ? 'selected' : ''; ?>>Original Only</option>
        <option value="dummy" <?php echo ($lot_type == 'dummy') ? 'selected' : ''; ?>>Dummy Only</option>
    </select>
</div>
<div class="widget-content module table-simple list_customers">
<?php require( get_template_directory().'/inc/admin/report/list-template/list-sale-detail.php' ); ?>
</div>