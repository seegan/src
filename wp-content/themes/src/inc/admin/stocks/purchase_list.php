<?php
global $wpdb;
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'purchase_list_filter') {
		$ppage = $_POST['per_page'];
		$from = $_POST['from'];
		$to = $_POST['to'];		
	} else {
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$from = isset( $_GET['from'] ) ? $_GET['from']  : '';
		$to = isset( $_GET['to'] ) ? $_GET['to']  : '';		
	}
	/*End Updated for filter 11/10/16*/
?>




<?php    


if(isset($_GET['action']) && $_GET['action']=='viewform') {
?>
<div style="width: 100%;">
    <ul class="icons-labeled">
        <li>
            <a href="<?php echo menu_page_url('purchase_list', 0); ?>" ><span class="icon-block-color coins-c"></span>Purchase List</a>
        </li>
        <li>
            <input type="button" onclick="printDiv('printableArea1')" value="print" />
        </li>
    </ul>
</div>

<div id="printableArea1" class="widget-content module table-simple list_customers">
<?php require( get_template_directory().'/inc/admin/stocks/purchase_view.php' ); ?>
</div>
<?php
}
else{
if(isset($_GET['action']) && $_GET['action']=='delete') {

     $table=$wpdb->prefix.'purshase';
     $table1=$wpdb->prefix.'purchase_details';
     $id=$_GET['purchase_id'];
     $wpdb->update($table, array('status' => '0'), array('id' =>  $id,'status' => '1'));    
     $wpdb->update($table1, array('status' => '0'), array('purchase_id' =>  $id,'status' => '1'));  

}

    ?>


<div style="width: 100%;">
    <ul class="icons-labeled">
        <li>
            <a href="<?php echo menu_page_url('purchase_add', 0); ?>" ><span class="icon-block-color coins-c"></span>New Purchase </a>
        </li>
        <li>
            <input type="button" onclick="printDiv('printableArea')" value="print" />
        </li>
    </ul>
</div>
<div class="widget-top">
	<h4>Purchase List</h4>
</div>


<div class="search_bar purchase_list_filter">
	<label>Page :</label>
	<select name="per_page" id="per_page">
		<option value="5" <?php echo ($ppage == 5) ? 'selected' : ''; ?>>5</option>
		<option value="10" <?php echo ($ppage == 10) ? 'selected' : ''; ?>>10</option>
		<option value="15" <?php echo ($ppage == 15) ? 'selected' : ''; ?>>15</option>

		<option value="20" <?php echo ($ppage == 20) ? 'selected' : ''; ?>>20</option>
		<option value="50" <?php echo ($ppage == 50) ? 'selected' : ''; ?>>50</option>
		<option value="100" <?php echo ($ppage == 100) ? 'selected' : ''; ?>>100</option>
	</select>
	<label>From :</label>
	
<input type="text" name="date_from" id="date_from" autocomplete="off" placeholder="Bill From" value="" class="hasDatepicker">
	<label>To :</label>
	<input type="text" name="to" id="date_to" class="hasDatepicker" autocomplete="off" value="<?php echo $to; ?>">

	<!--<label>Product Name :</label>
	<input type="text" name="search_product" id="search_product" autocomplete="off" value="<?php echo $search_product; ?>">	-->
</div>


<div id="printableArea" class="widget-content module table-simple list_customers">
<?php require( get_template_directory().'/inc/admin/list_template/list_purchase.php' ); ?>
</div>


<?php }?>
<script type="text/javascript">

function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

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
            jQuery('#search_lot').focus();
        } else {
         jQuery('#per_page').focus();
        }
    });
    jQuery('.purchase_list_filter input[type="text"]:last').live('keydown', function(e){
        if(jQuery('.display td a').length == 0 && jQuery(".next.page-numbers").length == 0 ) {
            var keyCode = e.keyCode || e.which; 
            if (keyCode == 9) { 
                e.preventDefault(); 
                // call custom function here
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