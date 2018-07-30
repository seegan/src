<?php
    $creditdebit = new creditdebit();
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
    <select name="ppage" class="ppage">
        <option value="5" <?php echo ($creditdebit->ppage == 5) ? 'selected' : '' ?>>5</option>
        <option value="10" <?php echo ($creditdebit->ppage == 10) ? 'selected' : '' ?>>10</option>
        <option value="20" <?php echo ($creditdebit->ppage == 20) ? 'selected' : '' ?>>20</option>
        <option value="50" <?php echo ($creditdebit->ppage == 50) ? 'selected' : '' ?>>50</option>
  </select>
    <input type="text" name="date" class="date" value="<?php echo $creditdebit->date; ?>" placeholder="Date">
    <input type="hidden" name="filter_action" class="filter_action" value="creditdebit_filter">

</div>


<div class="widget-content module table-simple creditdebit_filter">
<?php 
            include( get_template_directory().'/inc/admin/creditdebit/ajax_loading/creditdebit_list.php' );
?>
</div>

<script type="text/javascript">
    
jQuery(document).ready(function () {
    jQuery('.ppage').focus();


    jQuery(".ppage").live('keydown', function(e) { 
      var keyCode = e.keyCode || e.which; 

      if (event.shiftKey && event.keyCode == 9) { 
            e.preventDefault(); 
        // call custom function here
            jQuery('.last_list_view').focus();
        } else if(event.keyCode == 9){
            e.preventDefault(); 
            jQuery('.date').focus();
        } else {
         jQuery('.ppage').focus();
        }
    });


    jQuery(document).live('keydown', function(e){
        if(jQuery(document.activeElement).closest("#wpbody-content").length == 0) {
            var keyCode = e.keyCode || e.which; 
            if (keyCode == 9) { 
                e.preventDefault(); 
                jQuery('.ppage').focus();
            }
        }
    });

    
    jQuery('.filter-section input[type="text"]:last').live('keydown', function(e){

        if(jQuery('.jambo_table td a').length == 0 && jQuery(".next.page-numbers").length == 0 ) {

            
            if (event.shiftKey && event.keyCode == 9) { 
                e.preventDefault(); 
                // call custom function here
                 jQuery('.ppage').focus();
            } 
            else if ( event.keyCode == 9){
                e.preventDefault(); 
                // call custom function here
               jQuery('.ppage').focus();
            }
            else{

              
                jQuery('.filter-section input[type="text"]:last').focus();
            }
        }

    });


    jQuery('.last_list_view').live('keydown', function(e) { 

        if(jQuery(this).parent().parent().next('tr').length == 0 && jQuery(".next.page-numbers").length == 0) {
            var keyCode = e.keyCode || e.which; 
            if (event.shiftKey && event.keyCode == 9) { 
                e.preventDefault(); 
                // call custom function here
                 jQuery(this).parent().parent().find('.list_update').focus();
            } 
            else if ( event.keyCode == 9){
                e.preventDefault(); 
                // call custom function here
               jQuery('.ppage').focus();
            }
            else{

              
                jQuery(this).parent().parent().find('.last_list_view').focus();
            }
        }
    });

    jQuery(".next.page-numbers").live('keydown', function(e) { 
      var keyCode = e.keyCode || e.which; 

      if (keyCode == 9) { 
        e.preventDefault(); 
        // call custom function here
        jQuery('.ppage').focus()
      } 
    });

    
})    

</script>