<?php
 	/*Updated for filter 11/10/16*/
	if(isset($_POST['action']) && $_POST['action'] == 'income_list_filter') {
		$ppage = $_POST['per_page'];
		$entry_amount = $_POST['entry_amount'];
		$entry_description = $_POST['entry_description'];
		$entry_date_from = $_POST['entry_date_from'];
		$entry_date_to = $_POST['entry_date_to'];
	} else {
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$entry_amount = isset( $_GET['entry_amount'] ) ? $_GET['entry_amount']  : '';
		$entry_description = isset( $_GET['entry_description'] ) ? $_GET['entry_description']  : '';
		$entry_date_from = isset( $_GET['entry_date_from'] ) ? $_GET['entry_date_from']  : '';
		$entry_date_to = isset( $_GET['entry_date_to'] ) ? $_GET['entry_date_to']  : '';
	}
	/*End Updated for filter 11/10/16*/
?>

<div style="width: 100%;">
	<ul class="icons-labeled">
		<li><a href="javascript:void(0);" id="my-button" class="popup-add-income"><span class="icon-block-color add-c"></span>Add Income</a></li>
	</ul>
</div>
<div class="widget-top">
	<h4>New Billing</h4>
</div>


<div class="search_bar income_filter">
	<label>Page :</label>
	<select name="per_page" id="per_page">
		<option value="5" <?php echo ($ppage == 5) ? 'selected' : ''; ?>>5</option>
		<option value="10" <?php echo ($ppage == 10) ? 'selected' : ''; ?>>10</option>
		<option value="15" <?php echo ($ppage == 15) ? 'selected' : ''; ?>>15</option>

		<option value="20" <?php echo ($ppage == 20) ? 'selected' : ''; ?>>20</option>
		<option value="50" <?php echo ($ppage == 50) ? 'selected' : ''; ?>>50</option>
		<option value="100" <?php echo ($ppage == 100) ? 'selected' : ''; ?>>100</option>
	</select>
	<input type="text" name="entry_amount" id="entry_amount" autocomplete="off" placeholder="Search by Amount" value="<?php echo $entry_amount; ?>">
	<input type="text" name="entry_description" id="entry_description" autocomplete="off" placeholder="Search by Description" value="<?php echo $entry_description; ?>">
	<input type="text" name="entry_date_from" id="entry_date_from" autocomplete="off" placeholder="Date From" value="<?php echo $entry_date_from; ?>">
	<input type="text" name="entry_date_to" id="entry_date_to" autocomplete="off" placeholder="Date To" value="<?php echo $entry_date_to; ?>">
</div>
<div class="widget-content module table-simple list_customers">

<?php 
	include( get_template_directory().'/inc/admin/list_template/list_income.php' ); 
?>
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
            jQuery('#entry_amount').focus();
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