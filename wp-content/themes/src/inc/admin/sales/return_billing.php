<?php 
    if( isset($_GET['action']) && $_GET['action'] == 'view' ) {
        include( get_template_directory().'/inc/admin/sales/return/view.php' );
    } else if( isset($_GET['action']) && $_GET['action'] == 'update') {
        include( get_template_directory().'/inc/admin/sales/return/update.php' );
    } else {
        include( get_template_directory().'/inc/admin/sales/return/new.php' );
    }
?>