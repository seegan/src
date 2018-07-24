<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'bill_list_filter') {
		$ppage = $_POST['per_page'];
		$invoice_no = $_POST['invoice_no'];
		$customer_name = $_POST['customer_name'];
		$bill_total = $_POST['bill_total'];
		
		$customer_type = $_POST['customer_type'];
		$shop = $_POST['shop'];
		$delivery = $_POST['delivery'];
		$payment_done = $_POST['payment_done'];

		$date_from = $_POST['date_from'];
		$date_to = $_POST['date_to'];
	} else {
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$invoice_no = isset( $_GET['invoice_no'] ) ? $_GET['invoice_no']  : '';
		$customer_name = isset( $_GET['customer_name'] ) ? $_GET['customer_name']  : '';
		$bill_total = isset( $_GET['bill_total'] ) ? $_GET['bill_total']  : '';
		
		$customer_type = isset( $_GET['customer_type'] ) ? $_GET['customer_type']  : '-';
		$shop = isset( $_GET['shop'] ) ? $_GET['shop']  : '-';
		$delivery = isset( $_GET['delivery'] ) ? $_GET['delivery']  : '-';
		$payment_done = isset( $_GET['payment_done'] ) ? $_GET['payment_done']  : '-';

		$date_from = isset( $_GET['date_from'] ) ? $_GET['date_from']  : '';
		$date_to = isset( $_GET['date_to'] ) ? $_GET['date_to']  : '';
	}
	/*End Updated for filter 11/10/16*/
?>

<div style="width: 100%;">
	<ul class="icons-labeled">
		<li><a href="<?php menu_page_url( 'new_bill', 1 ); ?>" ><span class="icon-block-color add-c"></span>Add New Billing</a></li>
	</ul>
</div>
<div class="widget-top">
	<h4>New Billing</h4>
</div>


<div class="search_bar billing_list_filter">
	<label>Page :</label>
	<select name="per_page" id="per_page">
		<option value="5" <?php echo ($ppage == 5) ? 'selected' : ''; ?>>5</option>
		<option value="10" <?php echo ($ppage == 10) ? 'selected' : ''; ?>>10</option>
		<option value="15" <?php echo ($ppage == 15) ? 'selected' : ''; ?>>15</option>

		<option value="20" <?php echo ($ppage == 20) ? 'selected' : ''; ?>>20</option>
		<option value="50" <?php echo ($ppage == 50) ? 'selected' : ''; ?>>50</option>
		<option value="100" <?php echo ($ppage == 100) ? 'selected' : ''; ?>>100</option>
	</select>
	<input type="text" name="invoice_no" id="invoice_no" autocomplete="off" placeholder="Invoice Number" value="<?php echo $invoice_no; ?>">
	<input type="text" name="customer_name" id="customer_name" autocomplete="off" placeholder="Customer Name or Mobile" value="<?php echo $customer_name; ?>">
	<input type="text" name="bill_total" id="bill_total" autocomplete="off" placeholder="Bill amount" value="<?php echo $bill_total; ?>">
	<input type="text" name="date_from" id="date_from" autocomplete="off" placeholder="Bill From" value="<?php echo $date_from; ?>">
	<input type="text" name="date_to" id="date_to" autocomplete="off" placeholder="Bill to" value="<?php echo $date_to; ?>">
	<select name="customer_type" id="customer_type">
		<option value="-" <?php echo ($customer_type === '-') ? 'selected' : ''; ?>>Select Type</option>
		<option value="Retail" <?php echo ($customer_type === 'Retail') ? 'selected' : ''; ?>>Retail</option>
		<option value="Wholesale" <?php echo ($customer_type === 'Wholesale') ? 'selected' : ''; ?>>Wholesale</option>		
	</select>
	<select name="shop" id="shop">
		<option value="-" <?php echo ($shop === '-') ? 'selected' : ''; ?>>Shop</option>
		<option value="rice_center" <?php echo ($shop === 'rice_center') ? 'selected' : ''; ?>>Saravana Rice Centre</option>
		<option value="rice_mandy" <?php echo ($shop === 'rice_mandy') ? 'selected' : ''; ?>>Saravana Rice Mandy</option>
		<option value="counter" <?php echo ($shop === 'counter') ? 'selected' : ''; ?>>Counter</option>
	</select>
	<select name="delivery" id="delivery">
		<option value="-" <?php echo ($delivery === '-') ? 'selected' : ''; ?>>Delivery Status</option>
		<option value="delivered" <?php echo ($delivery === 'delivered') ? 'selected' : ''; ?>>Delivered</option>
		<option value="pending" <?php echo ($delivery === 'pending') ? 'selected' : ''; ?>>Pending</option>
		<option value="canceled" <?php echo ($delivery === 'canceled') ? 'selected' : ''; ?>>Canceled</option>
	</select>

	<select name="payment_done" id="payment_done">
		<option value="-" <?php echo ($payment_done === '-') ? 'selected' : ''; ?>>Payment Status</option>
		<option value="1" <?php echo ($payment_done === '1') ? 'selected' : ''; ?>>Completed</option>
		<option value="0" <?php echo ($payment_done === '0') ? 'selected' : ''; ?>>Pending</option>
	</select>

</div>
<div class="widget-content module table-simple list_customers">
<?php 

    if( 1 == 1 ) {
		include( get_template_directory().'/inc/admin/billing_template/billing_list.php' ); 
    } else {
    	//include( get_template_directory().'/inc/admin/billing_template/add_billing.php' ); 
    }
	
?>
</div>