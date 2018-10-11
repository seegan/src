<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'customer_list_filter') {
		$ppage = $_POST['per_page'];
		$customer_name = $_POST['customer_name'];
		$customer_mobile_list = $_POST['customer_mobile_list'];
		$customer_type = $_POST['customer_type'];
	} else {
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$customer_name = isset( $_GET['customer_name'] ) ? $_GET['customer_name']  : '';
		$customer_mobile_list = isset( $_GET['customer_mobile_list'] ) ? $_GET['customer_mobile_list']  : '';
		$customer_type = isset( $_GET['customer_type'] ) ? $_GET['customer_type']  : '';
	}
	/*End Updated for filter 11/10/16*/
?>
<div style="width: 100%;">
	<ul class="icons-labeled">
		<li><a href="javascript:void(0);" id="my-button" class="popup-add-customer"><span class="icon-block-color add-c"></span>Add New Customer</a></li>
	</ul>
</div>
<div class="widget-top">
	<h4>Customer List</h4>
</div>

<div class="search_bar customer_filter">
	<label>Page :</label>
	<select name="per_page" id="per_page">
		<option value="5" <?php echo ($ppage == 5) ? 'selected' : ''; ?>>5</option>
		<option value="10" <?php echo ($ppage == 10) ? 'selected' : ''; ?>>10</option>
		<option value="15" <?php echo ($ppage == 15) ? 'selected' : ''; ?>>15</option>

		<option value="20" <?php echo ($ppage == 20) ? 'selected' : ''; ?>>20</option>
		<option value="50" <?php echo ($ppage == 50) ? 'selected' : ''; ?>>50</option>
		<option value="100" <?php echo ($ppage == 100) ? 'selected' : ''; ?>>100</option>
	</select>
	<input type="text" name="customer_name" id="customer_name" autocomplete="off" placeholder="Customer Name" value="<?php echo $customer_name; ?>">
	<input type="text" name="customer_mobile_list" id="customer_mobile_list" autocomplete="off" placeholder="Mobile Number" value="<?php echo $customer_mobile_list; ?>">

	<select name="customer_type" id="customer_type" style="height: 30px;">
		<option value="-">Customer Type</option>
		<option value="Retail" <?php echo ($customer_type == 'Retail') ? 'selected' : ''; ?>>Retail</option>
		<option value="Wholesale" <?php echo ($customer_type == 'Wholesale') ? 'selected' : ''; ?>>Wholesale</option>
	</select>
    <select name="payment_status" id="payment_status" style="height: 30px;">
        <option value="-">Payment Status</option>
        <option value="1" <?php echo ($customer_type == '1') ? 'selected' : ''; ?>>Paid</option>
        <option value="0" <?php echo ($customer_type == '0') ? 'selected' : ''; ?>>Due</option>
    </select>
</div>


<div class="widget-content module table-simple list_customers">
<?php include( get_template_directory().'/inc/admin/list_template/list_customers.php' ); ?>
</div>

<script type="text/javascript">
    
jQuery(document).ready(function () {
    jQuery('#per_page').focus();
    jQuery(document).live('keydown', function(e){
        if(jQuery(document.activeElement).closest("#wpbody-content").length == 0 && jQuery('#src_info_box').css('display') != 'block') {
            var keyCode = e.keyCode || e.which; 
            if (keyCode == 9) { 
                e.preventDefault(); 
                jQuery('#per_page').focus()
            }
        }
    });
    jQuery("#per_page").live('keydown', function(e) { 
        var keyCode = e.keyCode || e.which; 
        if (event.shiftKey && event.keyCode == 9) { 
            e.preventDefault(); 
            jQuery('.last_list_view').focus();
        } else if(event.keyCode == 9){
            e.preventDefault(); 
            jQuery('#customer_name').focus();
        } else {
         jQuery('#per_page').focus();
        }
    });
    jQuery('.lot_filter input[type="text"]:last').live('keydown', function(e){
        if(jQuery('.display td a').length == 0 && jQuery(".next.page-numbers").length == 0 ) {
            var keyCode = e.keyCode || e.which; 
            if (keyCode == 9) { 
                e.preventDefault(); 
                jQuery('#per_page').focus()
            }
        }
    });
   	jQuery('.last_list_view').live('keydown', function(e) { 
        if(jQuery(this).parent().parent().parent().next('tr').length == 0 && jQuery(".next.page-numbers").length == 0) {
            var keyCode = e.keyCode || e.which; 
            if (event.shiftKey && event.keyCode == 9) { 
                e.preventDefault(); 
                 jQuery(this).parent().parent().find('.list_update').focus();
            } 
            else if ( event.keyCode == 9){
                e.preventDefault(); 
                jQuery('#per_page').focus();
            }
            else {
                jQuery(this).parent().parent().find('.last_list_view').focus();
            } 
        }
    });
    jQuery(".next.page-numbers").live('keydown', function(e) { 
      var keyCode = e.keyCode || e.which; 
      if (keyCode == 9) { 
        e.preventDefault(); 
        jQuery('#per_page').focus()
      } 
    });   
})    

</script>