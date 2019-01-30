<?php
 	/*Updated for filter 30.01.2019*/
   
	if(isset($_POST['action']) && $_POST['action'] == 'ptype_list_filter') {
		$ppage = $_POST['per_page'];
		$search_ptype = $_POST['search_ptype'];

	} else {
		$ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		$search_ptype = isset( $_GET['search_ptype'] ) ? $_GET['search_ptype']  : '';

	}

?>


<div style="width: 100%;">
<ul class="icons-labeled">
<li><a href="javascript:void(0);" id="my-button" class="popup-ptype"><span class="icon-block-color add-c"></span>Add Product Type</a></li>
</ul>
</div>
<div class="widget-top">
	<h4>Product Type List</h4>
</div>

<div class="search_bar ptype_filter">
	<label>Page :</label>
	<select name="per_page" id="per_page">
		<option value="5" <?php echo ($ppage == 5) ? 'selected' : ''; ?>>5</option>
		<option value="10" <?php echo ($ppage == 10) ? 'selected' : ''; ?>>10</option>
		<option value="15" <?php echo ($ppage == 15) ? 'selected' : ''; ?>>15</option>

		<option value="20" <?php echo ($ppage == 20) ? 'selected' : ''; ?>>20</option>
		<option value="50" <?php echo ($ppage == 50) ? 'selected' : ''; ?>>50</option>
		<option value="100" <?php echo ($ppage == 100) ? 'selected' : ''; ?>>100</option>
	</select>
	<!--<input type="text" name="lot_number" id="lot_number" autocomplete="off" placeholder="Search by Lot Number" value="<?php echo $lot_number; ?>">
	<input type="text" name="search_brand" id="search_brand" autocomplete="off" placeholder="Search by Brand" value="<?php echo $search_brand; ?>">-->
	<input type="text" name="search_ptype" id="search_ptype" autocomplete="off" placeholder="Search by Product Type Name" value="<?php echo $search_ptype; ?>">

</div>


<div class="widget-content module table-simple list_protype">
<?php include( get_template_directory().'/inc/admin/list_template/ptype_add_list.php' ); ?>
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
            jQuery('#search_ptype').focus();
        } else {
         jQuery('#per_page').focus();
        }
    });
    jQuery('.ptype_filter input[type="text"]:last').live('keydown', function(e){
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