<?php 
    if( isset($_GET['action']) && $_GET['action'] == 'view' ) {
        include( get_template_directory().'/inc/admin/sales/delivery/view.php' );
    } else if( isset($_GET['action']) && $_GET['action'] == 'update') {
        include( get_template_directory().'/inc/admin/sales/delivery/update.php' );
    } else {
        include( get_template_directory().'/inc/admin/sales/delivery/new.php' );
    }
?>