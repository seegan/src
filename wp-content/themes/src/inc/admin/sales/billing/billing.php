<?php
    if( isset($_GET['action']) && $_GET['action'] == 'update' && ( isset($_GET['inv_id']) || isset($_GET['bill_no']) ) ) {
    	$bill_no = isset($_GET['bill_no']) ? $_GET['bill_no'] : $_GET['inv_id'];
    ?>
		<div style="width: 100%;">
			<ul class="icons-labeled">
				<li>
					<a href="<?php echo menu_page_url( 'sales_others', 0 ); ?>" ><span class="icon-block-color coins-c"></span>View Billing</a>
				</li>
				<li>
					<a href="<?php echo menu_page_url( 'new_bill', 0 ).'&bill_no='.$bill_no.'&action=invoice'; ?>" ><span class="icon-block-color invoice-c"></span>View Invoice</a>
				</li>
			</ul>
		</div>
		<div class="widget-top">
			<h4>New Billing</h4>
		</div>
		<div class="widget-content module table-simple add_billing">
    <?php
			include( get_template_directory().'/inc/admin/billing_template/billing/update.php' );
	?>
		</div>
	<?php
    } else if( isset($_GET['action']) && $_GET['action'] == 'invoice' && ( isset($_GET['inv_id']) || isset($_GET['bill_no']) ) ) {
    	$bill_no = isset($_GET['bill_no']) ? $_GET['bill_no'] : $_GET['inv_id'];
    ?>
		<div style="width: 100%;">
			<ul class="icons-labeled" style="width:280px;float:left;">
				<li>
					<a href="<?php echo menu_page_url( 'sales_others', 0 ); ?>" ><span class="icon-block-color coins-c"></span>View Billing</a>
				</li>
				<li>
					<a href="<?php echo menu_page_url( 'new_bill', 0 ); ?>" ><span class="icon-block-color add-c"></span>Add New Billing</a>
				</li>
			</ul>
			<ul class="icons-labeled" style="width:250px;float:right;">
				<li>
					<a class="print_bill" onclick="window.print();"><span class="icon-block-black print-c"></span>Print</a>
				</li>
				<li>
					<a href="<?php echo menu_page_url( 'new_bill', 0 ).'&bill_no='.$bill_no.'&action=update'; ?>" ><span class="icon-block-color updatebill-c"></span>Update Bill</a>
				</li>
			</ul>
			<div style="clear:both;"></div>
		</div>
		<div class="widget-top">
			<h4>New Billing</h4>
		</div>
		<!-- <div class="widget-content module table-simple list_customers"> -->
		<div class="widget-content module add_billing">
    <?php
    		include( get_template_directory().'/inc/admin/billing_template/billing/invoice.php' ); 
	?>
		</div>
	<?php
    } else {
    ?>

		<div style="width: 100%;">
			<ul class="icons-labeled">
				<li>
					<a href="<?php echo menu_page_url( 'sales_others', 0 ); ?>" ><span class="icon-block-color coins-c"></span>View Billing</a>
				</li>
				<li>
					<a href="javascript:void(0);" id="my-button" class="popup-add-customer"><span class="icon-block-color add-c"></span>Add New Customer</a>
				</li>
			</ul>
		</div>
		<div class="widget-top">
			<h4>New Billing</h4>
		</div>
		<!-- <div class="widget-content module table-simple list_customers"> -->
		<div class="widget-content module table-simple add_billing">
    <?php
    	$date = date("Y/m/d");
    	$unlocked_val = generateInvoice($date);
    	include( get_template_directory().'/inc/admin/billing_template/billing/new.php' ); 
    ?>
    	</div>
    <?php
    }
	
?>
