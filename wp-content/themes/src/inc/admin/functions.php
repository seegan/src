<?php

function hide_update_notice()
{
    remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action( 'admin_head', 'hide_update_notice', 1 );


function my_footer_shh() {
/*	remove_filter( 'update_footer', 'core_update_footer' ); 
	remove_submenu_page( 'index.php', 'update-core.php' );
	remove_menu_page( 'jetpack' );                    //Jetpack* 
	remove_menu_page( 'edit.php' );                   //Posts
	remove_menu_page( 'upload.php' );                 //Media
	remove_menu_page( 'edit.php?post_type=page' );    //Pages
	remove_menu_page( 'edit-comments.php' );          //Comments
	remove_menu_page( 'themes.php' );                 //Appearance
	remove_menu_page( 'plugins.php' );                //Plugins
	remove_menu_page( 'users.php' );                  //Users
	remove_menu_page( 'tools.php' );                  //Tools
	remove_menu_page( 'options-general.php' );        //Settings*/
}
add_action( 'admin_menu', 'my_footer_shh' );



wp_enqueue_style( 'jquery-ui', get_template_directory_uri() . '/inc/css/jquery-ui.css' );
wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/inc/css/admin-css.css' );

wp_enqueue_script( 'shortcut_script',  get_template_directory_uri() . '/inc/js/shortcut.js', array('jquery'), false, false );
wp_enqueue_script( 'bpopup', get_template_directory_uri() . '/inc/js/jquery.bpopup.min.js', array('jquery'), false, false );
wp_enqueue_script( 'custom', get_template_directory_uri() . '/inc/js/script.js', array('jquery'), false, false );
wp_enqueue_script( 'jquery-ui-js', get_template_directory_uri() . '/inc/js/jquery-ui.js', array('jquery'), false, false );

wp_localize_script( 'custom', 'home_page', array( 'url' => home_url( '/' ), 'new_billing' => admin_url('admin.php?page=new_bill'), 'billing_list' => admin_url('admin.php?page=sales_others') ));

wp_enqueue_script( 'jquery-canvas-js', get_template_directory_uri() . '/inc/js/jquery.canvasjs.min.js', array('jquery'), false, false );


// Admin footer modification
function remove_footer_admin() 
{
	$count_data = getStatusCount();
	$avail_stock = isset($count_data['result']->avail_stock) ? $count_data['result']->avail_stock : 0;
	$unavail_stock = isset($count_data['result']->unavail_stock) ? $count_data['result']->unavail_stock : 0;
	$tot_customers = isset($count_data['result']->tot_customers) ? $count_data['result']->tot_customers : 0;
	$tot_employees = isset($count_data['result']->tot_employees) ? $count_data['result']->tot_employees : 0;

?>
<div class="conform-box1" style="display:none;">Choose the action!</div>
<span id="footer-thankyou">
	<div id="footer-wrap" class="">
		<div id="footer">
			<div class="footer-container">
				<div class="footer-nav">
					<ul>
						<li>
							<a href="<?php echo admin_url('admin.php?page=employee_list')?>">
								<span class="footer-button new-user"></span>Users
								<span class="zero-count"><?php echo $tot_employees; ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo admin_url('admin.php?page=customer')?>">
								<span class="footer-button new-task"></span> Customer
								<span class="user-counter"><?php echo $tot_customers; ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo admin_url('admin.php?page=report_list')?>">
								<span class="footer-button new-order"></span>Available Stocks 
								<span class="ticket-counter"><?php echo $avail_stock; ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo admin_url('admin.php?page=report_list')?>">
								<span class="footer-button open-tickets"></span>Unavailable Stocks 
								<span class="task-counter"><?php echo $unavail_stock; ?></span>
							</a>
						</li>
					</ul>
				</div>
			<div class="copyright">
			© 2016 Billing Admin Panel. All rights reserved
			</div>
			</div>
		<div id="goTop" style="display: none;" class="">
		<a href="#" class="tip-top">Top</a>
		</div>
		</div>
	</div>
</span>
<?php
}
add_filter('admin_footer_text', 'remove_footer_admin');

add_action('admin_footer', 'src_admin_confirm_box');
function src_admin_confirm_box() {
?>
<div class="bill-loader">
	<div class="loader-bill-conatainer">
		<img src="<?php echo get_template_directory_uri().'/inc/img/loader.gif' ?>">
	</div>
</div>

<button id="my-button" style="display:none;">POP IT UP</button>
	<div id="src_info_box" style="display:none;">
		<div class="src-container">
			<div class="src_info_headder">
				<h4 id="popup-title"></h4>
				<div class="src-close">
					<a href="javascript:void(0);" class="simplemodal-close exit-modal">x</a>
				</div>
			</div>
			<div id="popup-content" style="padding:10px;">
				
			</div>
			<button id="my-button1" style="display:none;"></button>
		</div>
	</div>

	<div id="src_info_box_alert" style="display:none;">
		<div class="src-container_alert">
			<div class="src_info_headder_alert">
				<h4 id="popup-title_alert">dfdfgdg</h4>
				<div class="src-close_alert">
					<a href="javascript:void(0);" class="simplemodal-close exit-modal">x</a>
				</div>
			</div>
			<div id="popup-content_alert" style="padding:20px;">
				<div class="err_message" style="display:none;">
					Enter the mandatory fields!!
				</div>
				<div class="succ_message" style="display:none;">
					Enter the mandatory fields!!
				</div>
			</div>

			<div class="buttons">
				<span class="icon-wrap-lb" id="pop_cancel" style="display: none;">
					<a href="#" class="no simplemodal-close" title="Icon Title">
						<span class="icon-block-color cross-c"></span>Cancel
					</a>
				</span>
				<span class="icon-wrap-lb">
					<a href="javascript:void(0)" class="yes" title="Ok">
						<span class="icon-block-color accept-c"></span>Ok
					</a>
				</span>
			</div>
		</div>
	</div>

	<div id="src_info_box_s" style="display:none;">
		<div class="src-container-s">
			<div class="src_info_headder">
				<h4 id="popup-title-s"></h4>
				<div class="src-close-s">
					<a href="javascript:void(0);" class="simplemodal-close exit-modal">x</a>
				</div>
			</div>
			<div id="popup-content-s" style="padding:10px;">
				
			</div>
		</div>
	</div>

<script>
	jQuery('#my-button, .my-button').bind('click', function(e) {
	    e.preventDefault();
	    jQuery('#src_info_box').bPopup({
	    	modalClose: false,
	    	position: ['auto', 50] 
	    });

	});

	jQuery('.d-status span').live('click', function(e) {
	    e.preventDefault();
	    jQuery('#src_info_box_s').bPopup({
	    	modalClose: false,
	    	position: ['auto', 50] 
	    });
	});

	jQuery('#my-button1').bind('click', function(e) {
	    e.preventDefault();
	    jQuery('#src_info_box_alert').bPopup();
	}); 
	

	jQuery('.src-close').bind('click', function(e) {
	    jQuery('#src_info_box').bPopup().close();
	});
	jQuery('.src-close_alert, .src-container_alert .buttons').bind('click', function(e) {
	    jQuery('#src_info_box_alert').bPopup().close();
	});
	jQuery('.src-close-s').bind('click', function(e) {
	    jQuery('#src_info_box_s').bPopup().close();
	});


</script>
<?php
	echo $html;
}



	// Alternative solution for loading scripts only in plugin page
	if( (is_admin() ) && (isset($_GET['page'])) /*&& ( $_GET['page'] == 'admin_users' )*/ )   { 
	    // Register scripts and styles
	    add_action('admin_init', 'wp_script_init');
	}  

  	function wp_script_init() {

	  	wp_enqueue_style( 'src-select2', get_template_directory_uri() . '/inc/js/select2/dist/css/select2.min.css' );  
	  	wp_enqueue_style( 'src-chosen-css', get_template_directory_uri() . '/inc/css/chosen.css' ); 

	    wp_enqueue_script( 'src-chosen', get_template_directory_uri() . '/inc/js/chosen.jquery.js', array('jquery'), false, false );
	    wp_enqueue_script( 'src-ajax-chosen', get_template_directory_uri() . '/inc/js/ajax-chosen.js', array('jquery'), false, false );

	    wp_enqueue_script( 'src-select2', get_template_directory_uri() . '/inc/js/select2/dist/js/select2.full.min.js', array('jquery'), false, false );


		wp_enqueue_script( 'repeater_script',  get_template_directory_uri() . '/inc/js/jquery.repeater.js', array('jquery'), false, false );


		wp_enqueue_script( 'validate-js', get_template_directory_uri() . '/inc/js/jquery.validate.js', array('jquery'), false, false );
		wp_enqueue_script( 'ajax_customer_script',  get_template_directory_uri() . '/inc/js/ajax-customer-script.js', array('jquery'), false, false );
		wp_enqueue_script( 'ajax_lots_script',  get_template_directory_uri() . '/inc/js/ajax-lots-script.js', array('jquery'), false, false );
		wp_enqueue_script( 'ajax_stocks_script',  get_template_directory_uri() . '/inc/js/ajax-stocks-script.js', array('jquery'), false, false );


/*		if( isset($_GET['page']) && isset($_GET['action']) && $_GET['page'] == 'new_billing' ) {
			if($_GET['action'] == 'update') {
				wp_enqueue_script( 'ajax_sale_logic',  get_template_directory_uri() . '/inc/js/ajax-sale-logic-script-update.js', array('jquery'), false, false );
				wp_enqueue_script( 'ajax_billing_script',  get_template_directory_uri() . '/inc/js/ajax-billing-script-update.js', array('jquery'), false, false );
			} else {
				wp_enqueue_script( 'ajax_sale_logic',  get_template_directory_uri() . '/inc/js/ajax-sale-logic-script.js', array('jquery'), false, false );
				wp_enqueue_script( 'ajax_billing_script',  get_template_directory_uri() . '/inc/js/ajax-billing-script.js', array('jquery'), false, false );				
			}
		}*/







		if( isset($_GET['page']) && $_GET['page'] == 'new_bill' ) {
			if(isset($_GET['action']) && $_GET['action'] == 'update') {
				wp_enqueue_script( 'sale-logic-script',  get_template_directory_uri() . '/inc/js/sale/update/sale-logic.js', array('jquery'), false, false );
				wp_enqueue_script( 'sale-script',  get_template_directory_uri() . '/inc/js/sale/update/sale.js', array('jquery'), false, false );
			} else {
				wp_enqueue_script( 'sale-logic-script',  get_template_directory_uri() . '/inc/js/sale/new/sale-logic.js', array('jquery'), false, false );
				wp_enqueue_script( 'sale-script',  get_template_directory_uri() . '/inc/js/sale/new/sale.js', array('jquery'), false, false );
			}
		}




		if( isset($_GET['page']) && $_GET['page'] == 'bill_delivery' ) {
			wp_enqueue_script( 'sale_delivery',  get_template_directory_uri() . '/inc/js/sale-delivery.js', array('jquery'), false, false );
		}
		if( isset($_GET['page']) && $_GET['page'] == 'bill_return' ) {
			wp_enqueue_script( 'sale_return',  get_template_directory_uri() . '/inc/js/sale-return.js', array('jquery'), false, false );
		}
		wp_enqueue_script( 'ajax_sale_extra_script',  get_template_directory_uri() . '/inc/js/ajax-sale-extra.js', array('jquery'), false, false );
		wp_enqueue_script( 'ajax_employee_script',  get_template_directory_uri() . '/inc/js/ajax-employee-script.js', array('jquery'), false, false );
		wp_enqueue_script( 'ajax_report_script',  get_template_directory_uri() . '/inc/js/ajax-report.js', array('jquery'), false, false );
		wp_enqueue_script( 'ajax_custom_script',  get_template_directory_uri() . '/inc/js/ajax-scripts.js', array('jquery'), false, false );
		wp_enqueue_script( 'ajax_payment_script',  get_template_directory_uri() . '/inc/admin/billing_template/billing/modepayment_singlebill/modeofpayment.js', array('jquery'), false, false );
		wp_localize_script( 'ajax_custom_script', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

	}


 function get_customers( $args = array() ) {
	global $wpdb;
	$customer_table = $wpdb->prefix. 'customers';
	$query = "SELECT * FROM {$customer_table}";
	$data['customers'] = $wpdb->get_results( $query );
	return $data;
}

function get_customer($customer_id = 0) {
	global $wpdb;

	$customer_table = $wpdb->prefix. 'customers';
	$query = "SELECT * FROM {$customer_table} WHERE id=".$customer_id;

	return $wpdb->get_row( $query );
}



function get_customer_create_form_popup(){
	include('ajax/get_customer_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_get_customer_create_form_popup', 'get_customer_create_form_popup' );
add_action( 'wp_ajax_nopriv_get_customer_create_form_popup', 'get_customer_create_form_popup' );

function edit_customer_create_form_popup(){
	include('ajax/edit_customer_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_edit_customer_create_form_popup', 'edit_customer_create_form_popup' );
add_action( 'wp_ajax_nopriv_edit_customer_create_form_popup', 'edit_customer_create_form_popup' );

function post_customer_create_popup(){
	global $wpdb;
	$data['success'] = 0;
	$params = array();
	parse_str($_POST['data'], $params);

	$length = (isset($_POST['length']) && $_POST['length'] == 1) ? true : false;

	$customer_table = $wpdb->prefix. 'customers';
	$wpdb->insert($customer_table, array(
	    'name' => esc_attr($params['customer_name']),
	    'mobile' => esc_attr($params['customer_mobile']),
	    'mobile1' => esc_attr($params['customer_mobile1']),
	    'address' => esc_attr($params['customer_address']),
	    'type' => esc_attr($params['customer_type']),
	    'payment_type' => esc_attr($params['payment_type']),
	    'created_at' => date( 'Y-m-d H:i:s', current_time( 'timestamp' ) )
	));
	if($wpdb->insert_id) {
		$data['success'] = 1;
		if(!$length) {
			include( get_template_directory().'/inc/admin/list_template/list_customers.php' );
			die();
		} else {
			$data['customer_name'] = esc_attr($params['customer_name']);
			$data['id'] = $wpdb->insert_id;

			echo json_encode($data, JSON_PRETTY_PRINT);
			die();
		}

	} else {
		echo json_encode($data, JSON_PRETTY_PRINT);
		die();
	}

}
add_action( 'wp_ajax_post_customer_create_popup', 'post_customer_create_popup' );
add_action( 'wp_ajax_nopriv_post_customer_create_popup', 'post_customer_create_popup' );

function post_customer_edit_popup(){
	global $wpdb;
	$data['success'] = 0;
	$params = array();
	parse_str($_POST['data'], $params);

	$customer_table = $wpdb->prefix. 'customers';
	if ( $wpdb->update($customer_table, array(
	    'name' => esc_attr($params['customer_name']),
	    'mobile' => esc_attr($params['customer_mobile']),
	    'mobile1' => esc_attr($params['customer_mobile1']),
	    'address' => esc_attr($params['customer_address']),
	    'type' => esc_attr($params['customer_type']),
	    'payment_type' => esc_attr($params['payment_type'])
	), array( 'id' => $params['customer_id'] ) ) ) {
		$data['roll_id'] = ( isset($params['roll_id']) && $params['roll_id'] != '') ? $params['roll_id'] : '';
		$data['success'] = 1;
		$data['id'] = $params['customer_id'];

		$content = '';
		$content .= "<td>".$params['roll_id']."</td>";
		$content .= "<td>".$params['customer_name']."</td>";
		$content .= "<td>".$params['customer_mobile']."</td>";
		$content .= "<td>".$params['customer_mobile1']."</td>";
		$content .= "<td>".$params['customer_address']."</td>";
		$content .= "<td>".$params['customer_type']."</td>";
		$content .= "<td class='center'>";
		$content .= "<span><a class='action-icons c-edit customer_edit' title='Edit' data-roll='".$params['roll_id']."' data-id='".$params['customer_id']."'>Edit</a></span>";
		$content .= "<span><a class='action-icons c-delete user_delete' href='#' title='delete' data-id='".$params['customer_id']."' data-roll='".$params['roll_id']."'>Delete</a>";
		$content .= "</span>";
		$content .= "</td>";

		$data['content'] = $content;
	}
	echo json_encode($data, JSON_PRETTY_PRINT);
	die();

}
add_action( 'wp_ajax_post_customer_edit_popup', 'post_customer_edit_popup' );
add_action( 'wp_ajax_nopriv_post_customer_edit_popup', 'post_customer_edit_popup' );






function get_employee($employee_id = 0) {
	global $wpdb;

	$employee_table = $wpdb->prefix. 'employees';
	$query = "SELECT * FROM {$employee_table} WHERE id=".$employee_id;

	return $wpdb->get_row( $query );
}



function get_employee_create_form_popup(){
	include('ajax/get_employee_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_get_employee_create_form_popup', 'get_employee_create_form_popup' );
add_action( 'wp_ajax_nopriv_get_employee_create_form_popup', 'get_employee_create_form_popup' );


function post_employee_create_popup(){
	global $wpdb;
	$data['success'] = 0;
	$params = array();
	parse_str($_POST['data'], $params);

/*	echo "<pre>";
	var_dump($params); die();*/
	$employee_table = $wpdb->prefix. 'employees';
	$wpdb->insert($employee_table, array(
	    'emp_name' 			=> esc_attr($params['employee_name']),
	    'emp_mobile' 		=> esc_attr($params['employee_mobile']),
	    'emp_address' 		=> esc_attr($params['employee_address']),
	    'emp_salary' 		=> esc_attr($params['employee_salary']),
	   	'emp_joining' 		=> esc_attr($params['employee_joining']),
	    'emp_created_at' 	=> date( 'Y-m-d H:i:s', current_time( 'timestamp' ) ),
	));
	if($wpdb->insert_id) {
		include( get_template_directory().'/inc/admin/list_template/list_employee.php' );
		die();
	} else {
		$data['sds'] = $wpdb->last_query;
		echo json_encode($data, JSON_PRETTY_PRINT);
		die();
	}

}
add_action( 'wp_ajax_post_employee_create_popup', 'post_employee_create_popup' );
add_action( 'wp_ajax_nopriv_post_employee_create_popup', 'post_employee_create_popup' );

function edit_employee_create_form_popup(){
	include('ajax/edit_employee_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_edit_employee_create_form_popup', 'edit_employee_create_form_popup' );
add_action( 'wp_ajax_nopriv_edit_employee_create_form_popup', 'edit_employee_create_form_popup' );



function post_employee_edit_popup(){
	global $wpdb;
	$data['success'] = 0;
	$params = array();
	parse_str($_POST['data'], $params);


	$employee_table = $wpdb->prefix. 'employees';
	if ( $wpdb->update($employee_table, array(
	    'emp_name' => esc_attr($params['employee_name']),
	    'emp_mobile' => esc_attr($params['employee_mobile']),
	    'emp_address' => esc_attr($params['employee_address']),
	    'emp_salary' => esc_attr($params['employee_salary']),
	   	'emp_joining' => esc_attr($params['employee_joining']),
	    'emp_created_at' => date( 'Y-m-d H:i:s', current_time( 'timestamp' ) ),
	   	'emp_current_status' => $params['employee_status'],
	), array( 'id' => $params['employee_id'] ) ) ) {
		$data['roll_id'] = ( isset($params['roll_id']) && $params['roll_id'] != '') ? $params['roll_id'] : '';
		$data['success'] = 1;
		$data['id'] = $params['employee_id'];
		$work_status = ($params['employee_status'] == 1) ? 'Working' : 'Releave';



		$content = '';
		$content .= "<td>".$params['roll_id']."</td>";
		$content .= "<td>".$params['employee_no']."</td>";
		$content .= "<td>".$params['employee_name']."</td>";
		$content .= "<td>".$params['employee_mobile']."</td>";
		$content .= "<td>".$params['employee_salary']."</td>";		
		$content .= "<td>".$params['employee_address']."</td>";
		$content .= "<td>".$params['employee_joining']."</td>";
		$content .= "<td>".$work_status."</td>";
		$content .= "<td class='center'>";
		$content .= "<span><a class='action-icons c-edit employee_edit' title='Edit' data-roll='".$params['roll_id']."' data-id='".$params['employee_id']."'>Edit</a></span>";
		$content .= "<span><a class='action-icons c-delete user_delete' href='#' title='delete' data-id='".$params['employee_id']."' data-roll='".$params['roll_id']."'>Delete</a>";
		$content .= "</span>";
		$content .= "</td>";

		$data['content'] = $content;
	}
	echo json_encode($data, JSON_PRETTY_PRINT);
	die();

}
add_action( 'wp_ajax_post_employee_edit_popup', 'post_employee_edit_popup' );
add_action( 'wp_ajax_nopriv_post_employee_edit_popup', 'post_employee_edit_popup' );











function get_lot_create_form_popup() {
	include('ajax/get_lot_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_get_lot_create_form_popup', 'get_lot_create_form_popup' );
add_action( 'wp_ajax_nopriv_get_lot_create_form_popup', 'get_lot_create_form_popup' );


function edit_lot_create_form_popup() {
	include('ajax/edit_lot_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_edit_lot_create_form_popup', 'edit_lot_create_form_popup' );
add_action( 'wp_ajax_nopriv_edit_lot_create_form_popup', 'edit_lot_create_form_popup' );



function get_lot($lot_id = 0) { 
	global $wpdb;


	$data['lot_original_id'] 	= false;
	$data['lot_number'] 		= false;
	$data['buying_price'] 		= false;
	$data['lot_data'] 			= false;
	$data['original_retail'] 	= false;
	$data['original_wholesale'] = false;
	$data['lot_dummy_id'] 		= false;
	$data['dummy_lot_data'] 	= false;
	$data['dummy_retail'] 		= false;
	$data['dummy_wholesale'] 	= false;



	$lot_table = $wpdb->prefix. 'lots';
	$lot_detail_table = $wpdb->prefix. 'lots_detail';

	$query = "SELECT * FROM {$lot_table} where id = ".$lot_id." AND active = 1";
	
	if ($lot_data = $wpdb->get_row( $wpdb->prepare( $query ) ) ) {
		$lot_id   = $lot_data->id;
		$data['lot_original_id'] = $lot_id;

		$lot_original = $lot_data->lot_number;
		$data['lot_number'] = $lot_original;

		$data['lot_data'] = $lot_data;

		$query_original_retail = "SELECT * FROM {$lot_detail_table} where lot_id = ".$lot_id." AND sale_type = 'retail' AND active = 1";
		$data['original_retail'] = $wpdb->get_results( $wpdb->prepare( $query_original_retail ) );

		$query_original_wholesale = "SELECT * FROM {$lot_detail_table} where lot_id = ".$lot_id." AND sale_type = 'wholesale' AND active = 1";
		$data['original_wholesale'] = $wpdb->get_results( $wpdb->prepare( $query_original_wholesale ) );

		$query_dummy = "SELECT * FROM {$lot_table} where parent_id = '".$lot_id."' AND active = 1";


			//var_dump($query_dummy); die();


		if ($dummy_data = $wpdb->get_row( $wpdb->prepare( $query_dummy ) ) ) {

			$dummy_lot_id = $dummy_data->id;
			$data['lot_dummy_id']   = $dummy_lot_id;
			$data['dummy_lot_data'] = $dummy_data;

			$query_dummy_retail     = "SELECT * FROM {$lot_detail_table} where lot_id = ".$dummy_lot_id." AND sale_type = 'retail' AND active = 1";
			$data['dummy_retail']   = $wpdb->get_results( $wpdb->prepare( $query_dummy_retail ) );


			$query_dummy_wholesale   = "SELECT * FROM {$lot_detail_table} where lot_id = ".$dummy_lot_id." AND sale_type = 'wholesale' AND active = 1";
			$data['dummy_wholesale'] = $wpdb->get_results( $wpdb->prepare( $query_dummy_wholesale ) );
		}
	}

	return $data;

}



/* Lot Create */
function lot_create_submit_popup() {

	global $wpdb;
	$data['success'] = 0;
	$data['msg'] = 'Something Went Wrong!!';

	$params = array();
	parse_str($_POST['data'], $params);

	$stock_alert = $params['stock_alert'];
	$basic_price = $params['basic_price'];
	$dummy_basic_price = $params['dummy_basic_price'];

	$hsn_code = $params['hsn_code'];
	$gst_percentage = $params['gst_percentage'];

	$lot_number = $params['lot_number'];
	$dummy_lot_number = $params['dummy_slot_number'];

	$brand_name = $params['brand_name'];
	$dummy_brand_name = $params['dummy_brand_name'];
	
	$product_name = ($params['product_name'] == 'Others') ? $params['product_name1'] : $params['product_name'];
	$weight = $params['weight'];
	
	$slab_system_original = $params['slab_system'];
	$slab_system_dummy = $params['dummy_slab_system'];

	$buying_price = $params['buying_price'];

	$lots_table = $wpdb->prefix. 'lots';


	$query = "SELECT * FROM {$lots_table} WHERE ( lot_number = '".$lot_number."' OR lot_number = '".$dummy_lot_number."' ) AND active = 1";

	$result_exist = $wpdb->get_row( $query );

	if(!$result_exist) {


		$lot_original = array(
				'lot_number'   		=> $lot_number,
				'brand_name'   		=> $brand_name,
				'product_name' 		=> $product_name,
				'weight'       		=> $weight,
				'lot_type'     		=> 'original',
				'slab_system'  		=> $slab_system_original,
				'parent_id'    		=> 0,
				'stock_alert'  		=> $stock_alert,
				'basic_price'  		=> $basic_price,
				'buying_price' 		=> $buying_price,
				'hsn_code' 			=> $hsn_code,
				'gst_percentage'	=> $gst_percentage,
			);
		$wpdb->insert($lots_table, $lot_original);
		$lot_id = $wpdb->insert_id;



		if($lot_id) {

			$lots_detail_table = $wpdb->prefix. 'lots_detail';

			//For Slab system yes (Retail Original lot)
			if($slab_system_original == 1 && isset( $params['group_retail']) && count($params['group_retail'])>0) {
				foreach ($params['group_retail'] as $ssor_value) {
					$lot_detail = array(
							'lot_id' 		=> $lot_id,
							'lot_number' 	=> $lot_number,
							'weight_from' 	=> $ssor_value['weight_from'],
							'weight_to' 	=> $ssor_value['weight_to'],
							'price' 		=> $ssor_value['price'],
							'margin_price' 	=> $ssor_value['margin_price'],
							'lot_type' 		=> 'original',
							'sale_type' 	=> 'retail'
						);
					$wpdb->insert($lots_detail_table, $lot_detail);
				}
			}

			//For Slab system no (Retail Original lot)
			if($slab_system_original == 0 && isset( $params['weight_from_retail_no_slab']) && isset( $params['weight_to_retail_no_slab']) && isset( $params['price_retail_no_slab']) && $params['weight_from_retail_no_slab'] != '' && $params['weight_to_retail_no_slab'] != '' && $params['price_retail_no_slab'] != '' ) {
				$lot_detail = array(
						'lot_id' => $lot_id,
						'lot_number' => $lot_number,
						'weight_from' => $params['weight_from_retail_no_slab'],
						'weight_to' => $params['weight_to_retail_no_slab'],
						'price' => $params['price_retail_no_slab'],
						'margin_price' => $params['margin_price_retail_no_slab'],
						'lot_type' => 'original',
						'sale_type' => 'retail'
					);
				$wpdb->insert($lots_detail_table, $lot_detail);
			}

			//For Slab system yes (Wholesale Original lot)
			if($slab_system_original == 1 && isset( $params['group_wholesale']) && count($params['group_wholesale'])>0) {
				foreach ($params['group_wholesale'] as $ssow_value) {
					$lot_detail = array(
							'lot_id' => $lot_id,
							'lot_number' => $lot_number,
							'weight_from' => $ssow_value['weight_from'],
							'weight_to' => $ssow_value['weight_to'],
							'price' => $ssow_value['price'],
							'margin_price' => $ssow_value['margin_price'],
							'lot_type' => 'original',
							'sale_type' => 'wholesale'
						);
					$wpdb->insert($lots_detail_table, $lot_detail);
				}
			}



			//For Slab system no (Wholesale Original lot)
			if($slab_system_original == 0 && isset( $params['weight_from_wholesale_no_slab']) && isset( $params['weight_to_wholesale_no_slab']) && isset( $params['price_wholesale_no_slab'])&& $params['weight_from_wholesale_no_slab'] != '' && $params['weight_to_wholesale_no_slab'] != '' && $params['price_wholesale_no_slab'] != '' ) {
				$lot_detail = array(
						'lot_id' => $lot_id,
						'lot_number' => $lot_number,
						'weight_from' => $params['weight_from_wholesale_no_slab'],
						'weight_to' => $params['weight_to_wholesale_no_slab'],
						'price' => $params['price_wholesale_no_slab'],
						'margin_price' => $params['margin_price_wholesale_no_slab'],
						'lot_type' => 'original',
						'sale_type' => 'wholesale'
					);
				$wpdb->insert($lots_detail_table, $lot_detail);
			}

			if($dummy_lot_number != '' ) {

				$lot_dummy = array(
					'lot_number' 	=> $dummy_lot_number,
					'brand_name' 	=> $dummy_brand_name,
					'product_name' 	=> $product_name,
					'weight' 		=> $weight,
					'lot_type' 		=> 'dummy',
					'slab_system' 	=> $slab_system_dummy,
					'parent_id' 	=> $lot_id,
					'stock_alert' 	=> $stock_alert,
					'basic_price' 	=> $dummy_basic_price,
					'buying_price' 	=> $buying_price,
					'hsn_code' 			=> $hsn_code,
					'gst_percentage'	=> $gst_percentage,
				);
				$wpdb->insert($lots_table, $lot_dummy);
				$dummy_lot_id = $wpdb->insert_id;



				//For Slab system yes (Retail Dummy lot)
				if($slab_system_dummy == 1 && isset( $params['group_dummy_retail']) && count($params['group_dummy_retail'])>0) {
					foreach ($params['group_dummy_retail'] as $ssdr_value) {
						$lot_detail = array(
								'lot_id' => $dummy_lot_id,
								'lot_number' => $dummy_lot_number,
								'weight_from' => $ssdr_value['weight_from'],
								'weight_to' => $ssdr_value['weight_to'],
								'price' => $ssdr_value['price'],
								'margin_price' => $ssdr_value['margin_price'],
								'lot_type' => 'dummy',
								'sale_type' => 'retail'
							);
						$wpdb->insert($lots_detail_table, $lot_detail);
					}
				}

				//For Slab system no (Retail Dummy lot)
				if($slab_system_dummy == 0 && isset( $params['bag_weight_from_retail_no_slab']) && isset( $params['bag_weight_to_retail_no_slab']) && isset( $params['bag_weight_price_retail_no_slab'])&& $params['bag_weight_from_retail_no_slab'] != '' && $params['bag_weight_to_retail_no_slab'] != '' && $params['bag_weight_price_retail_no_slab'] != '' ) {
					$lot_detail = array(
							'lot_id' => $dummy_lot_id,
							'lot_number' => $dummy_lot_number,
							'weight_from' => $params['bag_weight_from_retail_no_slab'],
							'weight_to' => $params['bag_weight_to_retail_no_slab'],
							'price' => $params['bag_weight_price_retail_no_slab'],
							'margin_price' => $params['bag_weight_margin_price_retail_no_slab'],
							'lot_type' => 'dummy',
							'sale_type' => 'retail'
						);
					$wpdb->insert($lots_detail_table, $lot_detail);
				}

				//For Slab system yes (Wholesale Dummy lot)
				if($slab_system_dummy == 1 && isset( $params['group_dummy_wholesale']) && count($params['group_dummy_wholesale'])>0) {
					foreach ($params['group_dummy_wholesale'] as $ssdw_value) {
						$lot_detail = array(
								'lot_id' => $dummy_lot_id,
								'lot_number' => $dummy_lot_number,
								'weight_from' => $ssdw_value['weight_from'],
								'weight_to' => $ssdw_value['weight_to'],
								'price' => $ssdw_value['price'],
								'margin_price' => $ssdw_value['margin_price'],
								'lot_type' => 'dummy',
								'sale_type' => 'wholesale'
							);
						$wpdb->insert($lots_detail_table, $lot_detail);
					}
				}

				//For Slab system no (Wholesale Dummy lot)
				if($slab_system_dummy == 0 && isset( $params['bag_weight_from_wholesale_no_slab']) && isset( $params['bag_weight_to_wholesale_no_slab']) && isset( $params['bag_weight_price_wholesale_no_slab'])&& $params['bag_weight_from_wholesale_no_slab'] != '' && $params['bag_weight_to_wholesale_no_slab'] != '' && $params['bag_weight_price_wholesale_no_slab'] != '' ) {

					$lot_detail = array(
							'lot_id' 		=> $dummy_lot_id,
							'lot_number' 	=> $dummy_lot_number,
							'weight_from' 	=> $params['bag_weight_from_wholesale_no_slab'],
							'weight_to' 	=> $params['bag_weight_to_wholesale_no_slab'],
							'price' 		=> $params['bag_weight_price_wholesale_no_slab'],
							'margin_price' 	=> $params['bag_weight_margin_price_wholesale_no_slab'],
							'lot_type' 		=> 'dummy',
							'sale_type' 	=> 'wholesale'
						);
					$wpdb->insert($lots_detail_table, $lot_detail);
				}
			}
		}

	} else {
		$data['msg'] = 'Lot Number Already Exist!';
	}


	if( isset($lot_id) && $lot_id ) {
		include( get_template_directory().'/inc/admin/list_template/list_lots.php' );
		die();
	} else {
		echo json_encode($data, JSON_PRETTY_PRINT);
		die();
	}
}
add_action( 'wp_ajax_lot_create_submit_popup', 'lot_create_submit_popup' );
add_action( 'wp_ajax_nopriv_lot_create_submit_popup', 'lot_create_submit_popup' );


function lot_update_submit_popup() {

	global $wpdb;
	$data['success'] = 0;
	$data['msg'] = 'Something Went Wrong!!';

	$params = array();
	parse_str($_POST['data'], $params);
	$stock_alert = $params['stock_alert'];
	$basic_price = $params['basic_price'];
	$dummy_basic_price = $params['dummy_basic_price'];

	$hsn_code = $params['hsn_code'];
	$gst_percentage = $params['gst_percentage'];

	$lot_number = $params['lot_number'];
	$lot_id = $params['lot_id'];

	$dummy_lot_number = $params['dummy_slot_number'];
	$dummy_lot_id = $params['dummy_lot_id'];

	$brand_name = $params['brand_name'];
	$product_name = ($params['product_name'] == 'Others') ? $params['product_name1'] : $params['product_name'];
	$weight = $params['weight'];

	$slab_system_original = $params['slab_system'];
	$slab_system_dummy = $params['dummy_slab_system'];

	$buying_price = $params['buying_price'];
	$lots_table = $wpdb->prefix. 'lots';
	$lots_detail_table = $wpdb->prefix. 'lots_detail';

	$query = "SELECT * FROM {$lots_table} WHERE id = ".$lot_id." AND lot_number = '".$lot_number."' AND active = 1";
	$result_exist = $wpdb->get_row( $query );
	$dummy_query = "SELECT * FROM {$lots_table} WHERE parent_id = '".$lot_id."' AND lot_type = 'dummy' AND active = 1";

	if( $dummy_exist = $wpdb->get_row( $dummy_query ) ) {
		$wpdb->update($lots_table, array( 'active' => 0 ), array( 'id' => $dummy_exist->id) );
		$wpdb->update($lots_detail_table, array( 'active' => 0 ), array( 'lot_id' => $dummy_exist->id) );
	}

	if($result_exist) {
		$wpdb->update($lots_detail_table, array( 'active' => 0 ), array( 'lot_id' => $lot_id) );

		$lot_original = array(
				'brand_name' => $brand_name,
				'product_name' => $product_name,
				'weight' => $weight,
				'lot_type' => 'original',
				'slab_system' => $slab_system_original,
				'parent_id' => 0,
				'stock_alert' => $stock_alert,
				'basic_price' => $basic_price,
				'buying_price' => $buying_price,
				'hsn_code' 			=> $hsn_code,
				'gst_percentage'	=> $gst_percentage,

			);
		$wpdb->update($lots_table, $lot_original, array( 'id' => $lot_id) );

		//For Slab system yes (Retail Original lot)
		if($slab_system_original == 1 && isset( $params['group_retail']) && count($params['group_retail'])>0) {
			foreach ($params['group_retail'] as $ssor_value) {
				$lot_detail = array(
						'lot_id' => $lot_id,
						'lot_number' => $lot_number,
						'weight_from' => $ssor_value['weight_from'],
						'weight_to' => $ssor_value['weight_to'],
						'price' => $ssor_value['price'],
						'margin_price' => $ssor_value['margin_price'],
						'lot_type' => 'original',
						'sale_type' => 'retail'
					);
				$wpdb->insert($lots_detail_table, $lot_detail);
			}
		}

		//For Slab system no (Retail Original lot)
		if($slab_system_original == 0 && isset( $params['weight_from_retail_no_slab']) && isset( $params['weight_to_retail_no_slab']) && isset( $params['price_retail_no_slab']) && $params['weight_from_retail_no_slab'] != '' && $params['weight_to_retail_no_slab'] != '' && $params['price_retail_no_slab'] != '' ) {
			$lot_detail = array(
					'lot_id' => $lot_id,
					'lot_number' => $lot_number,
					'weight_from' => $params['weight_from_retail_no_slab'],
					'weight_to' => $params['weight_to_retail_no_slab'],
					'price' => $params['price_retail_no_slab'],
					'margin_price' => $params['margin_price_retail_no_slab'],
					'lot_type' => 'original',
					'sale_type' => 'retail'
				);
			$wpdb->insert($lots_detail_table, $lot_detail);
		}

		//For Slab system yes (Wholesale Original lot)
		if($slab_system_original == 1 && isset( $params['group_wholesale']) && count($params['group_wholesale'])>0) {
			foreach ($params['group_wholesale'] as $ssow_value) {
				$lot_detail = array(
						'lot_id' => $lot_id,
						'lot_number' => $lot_number,
						'weight_from' => $ssow_value['weight_from'],
						'weight_to' => $ssow_value['weight_to'],
						'price' => $ssow_value['price'],
						'margin_price' => $ssow_value['margin_price'],
						'lot_type' => 'original',
						'sale_type' => 'wholesale'
					);
				$wpdb->insert($lots_detail_table, $lot_detail);
			}
		}

		//For Slab system no (Wholesale Original lot)
		if($slab_system_original == 0 && isset( $params['weight_from_wholesale_no_slab']) && isset( $params['weight_to_wholesale_no_slab']) && isset( $params['price_wholesale_no_slab'])&& $params['weight_from_wholesale_no_slab'] != '' && $params['weight_to_wholesale_no_slab'] != '' && $params['price_wholesale_no_slab'] != '' ) {
			$lot_detail = array(
					'lot_id' => $lot_id,
					'lot_number' => $lot_number,
					'weight_from' => $params['weight_from_wholesale_no_slab'],
					'weight_to' => $params['weight_to_wholesale_no_slab'],
					'price' => $params['price_wholesale_no_slab'],
					'margin_price' => $params['margin_price_wholesale_no_slab'],
					'lot_type' => 'original',
					'sale_type' => 'wholesale'
				);
			$wpdb->insert($lots_detail_table, $lot_detail);
		}
 
		if($dummy_lot_number != '' ) {

			$lot_dummy = array(
					'lot_number' 		=> $dummy_lot_number,
					'brand_name' 		=> $brand_name,
					'product_name' 		=> $product_name,
					'weight' 			=> $weight,
					'lot_type' 			=> 'dummy',
					'slab_system' 		=> $slab_system_dummy,
					'parent_id' 		=> $lot_id,
					'stock_alert' 		=> $stock_alert,
					'basic_price' 		=> $dummy_basic_price,
					'buying_price' 		=> $buying_price,
					'hsn_code' 			=> $hsn_code,
					'gst_percentage'	=> $gst_percentage,					
					'active' 			=> 1,
				);
			if($dummy_exist) {
				$wpdb->update($lots_table, $lot_dummy, array('id' => $dummy_exist->id ));
				$dummy_lot_id = $dummy_exist->id;
			} else {
				$wpdb->insert($lots_table, $lot_dummy);
				$dummy_lot_id = $wpdb->insert_id;
			}

			//For Slab system yes (Retail Dummy lot)
			if($slab_system_dummy == 1 && isset( $params['group_dummy_retail']) && count($params['group_dummy_retail'])>0) {
				foreach ($params['group_dummy_retail'] as $ssdr_value) {
					$lot_detail = array(
							'lot_id' => $dummy_lot_id,
							'lot_number' => $dummy_lot_number,
							'weight_from' => $ssdr_value['weight_from'],
							'weight_to' => $ssdr_value['weight_to'],
							'price' => $ssdr_value['price'],
							'margin_price' => $ssdr_value['margin_price'],
							'lot_type' => 'dummy',
							'sale_type' => 'retail'
						);
					$wpdb->insert($lots_detail_table, $lot_detail);
				}
			}


			//For Slab system no (Retail Dummy lot)
			if($slab_system_dummy == 0 && isset( $params['bag_weight_from_retail_no_slab']) && isset( $params['bag_weight_to_retail_no_slab']) && isset( $params['bag_weight_price_retail_no_slab'])&& $params['bag_weight_from_retail_no_slab'] != '' && $params['bag_weight_to_retail_no_slab'] != '' && $params['bag_weight_price_retail_no_slab'] != '' ) {
				$lot_detail = array(
						'lot_id' => $dummy_lot_id,
						'lot_number' => $dummy_lot_number,
						'weight_from' => $params['bag_weight_from_retail_no_slab'],
						'weight_to' => $params['bag_weight_to_retail_no_slab'],
						'price' => $params['bag_weight_price_retail_no_slab'],
						'margin_price' => $params['bag_weight_margin_price_retail_no_slab'],
						'lot_type' => 'dummy',
						'sale_type' => 'retail'
					);
				$wpdb->insert($lots_detail_table, $lot_detail);
			}

			//For Slab system yes (Wholesale Dummy lot)
			if($slab_system_dummy == 1 && isset( $params['group_dummy_wholesale']) && count($params['group_dummy_wholesale'])>0) {
				foreach ($params['group_dummy_wholesale'] as $ssdw_value) {
					$lot_detail = array(
							'lot_id' => $dummy_lot_id,
							'lot_number' => $dummy_lot_number,
							'weight_from' => $ssdw_value['weight_from'],
							'weight_to' => $ssdw_value['weight_to'],
							'price' => $ssdw_value['price'],
							'margin_price' => $ssdw_value['margin_price'],
							'lot_type' => 'dummy',
							'sale_type' => 'wholesale'
						);
					$wpdb->insert($lots_detail_table, $lot_detail);
				}
			}

			//For Slab system no (Wholesale Dummy lot)
			if($slab_system_dummy == 0 && isset( $params['bag_weight_from_wholesale_no_slab']) && isset( $params['bag_weight_to_wholesale_no_slab']) && isset( $params['bag_weight_price_wholesale_no_slab'])&& $params['bag_weight_from_wholesale_no_slab'] != '' && $params['bag_weight_to_wholesale_no_slab'] != '' && $params['bag_weight_price_wholesale_no_slab'] != '' ) { 

				$lot_detail = array(
						'lot_id' => $dummy_lot_id,
						'lot_number' => $dummy_lot_number,
						'weight_from' => $params['bag_weight_from_wholesale_no_slab'],
						'weight_to' => $params['bag_weight_to_wholesale_no_slab'],
						'price' => $params['bag_weight_price_wholesale_no_slab'],
						'margin_price' => $params['bag_weight_margin_price_wholesale_no_slab'],
						'lot_type' => 'dummy',
						'sale_type' => 'wholesale'
					);
				$wpdb->insert($lots_detail_table, $lot_detail);
			}

		}

		$data['success'] = 1;
		$data['msg'] = 'Lot Updated!';

	} else {
		$data['msg'] = 'Lot Number Not Exist to Edit!';
	}
	echo json_encode($data, JSON_PRETTY_PRINT);
	die();
}
add_action( 'wp_ajax_lot_update_submit_popup', 'lot_update_submit_popup' );
add_action( 'wp_ajax_nopriv_lot_update_submit_popup', 'lot_update_submit_popup' );








function get_stock_create_form_popup(){
	include('ajax/get_stock_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_get_stock_create_form_popup', 'get_stock_create_form_popup' );
add_action( 'wp_ajax_nopriv_get_stock_create_form_popup', 'get_stock_create_form_popup' );


function edit_stock_create_form_popup(){
	include('ajax/edit_stock_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_edit_stock_create_form_popup', 'edit_stock_create_form_popup' );
add_action( 'wp_ajax_nopriv_edit_stock_create_form_popup', 'edit_stock_create_form_popup' );


function get_lot_data() {
	global $wpdb;
	$data['success'] = 0;
	$lots_table = $wpdb->prefix. 'lots';
	$search_term = $_POST['search_key'];

	$query = "SELECT * FROM {$lots_table} WHERE lot_number like '%${search_term}%' AND lot_type = 'original' AND active = 1";

	if( $data['items'] = $wpdb->get_results( $query, ARRAY_A ) ) {
		$data['success'] = 1;
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_get_lot_data', 'get_lot_data' );
add_action( 'wp_ajax_nopriv_get_lot_data', 'get_lot_data' );


function get_lot_data_billing() {
	global $wpdb;
	$data['success'] = 0;
	$lots_table = $wpdb->prefix. 'lots';
	$lots_sale_detail_table = $wpdb->prefix. 'sale_detail';
	$stock_table = $wpdb->prefix. 'stock';
	$search_term = $_POST['search_key'];

/*	$query ="
	    SELECT qwe.*, SUM(st.total_weight) as stock_bal from 
	    (    
	        SELECT *,
	        case WHEN l.parent_id  = 0 Then l.id ELSE l.parent_id  END as par_id
	        FROM ${lots_table} as l WHERE lot_number like '%${search_term}%' AND active = 1
	    ) as qwe JOIN ${stock_table} as st ON st.lot_id = qwe.par_id WHERE st.active=1 GROUP BY qwe.id
	    ";
*/

	$query = "

SELECT tt1.*, (tt1.stock_total - tt1.sale_total)as stock_bal  from 
(

select *,
( case WHEN l.parent_id = 0 Then l.id ELSE l.parent_id END ) as par_id,
( SELECT  
 ( case WHEN SUM(total_weight)  Then SUM(total_weight) ELSE 0 END ) 
 from ${stock_table} s where s.active = 1 AND s.lot_id = ( case WHEN l.parent_id = 0 Then l.id ELSE l.parent_id END ) ) as stock_total, 
    
( SELECT 
 ( case WHEN SUM(sale_weight)  Then SUM(sale_weight) ELSE 0 END ) 
 from ${lots_sale_detail_table} sd where sd.active = 1 AND sd.bill_type = 'original' AND sd.lot_parent_id = ( case WHEN l.parent_id = 0 Then l.id ELSE l.parent_id END ) ) as sale_total
from ${lots_table} as l WHERE lot_number LIKE '%${search_term}%' AND active = 1 

) as tt1";



	if( $data['items'] = $wpdb->get_results( $query, ARRAY_A ) ) {
		$data['success'] = 1;
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_get_lot_data_billing', 'get_lot_data_billing' );
add_action( 'wp_ajax_nopriv_get_lot_data_billing', 'get_lot_data_billing' );


function stock_create_submit_popup() {
	global $wpdb;

	$data['success'] = 0;
	$data['msg'] = 'Something went wrong! Try again';
	if( isset( $_POST['lot_id'] ) && isset( $_POST['stock_count'] )  ){
		$lot_id = $_POST['lot_id'];
		$count = $_POST['stock_count'];

		$lot_detail = get_lot( $lot_id );

		if( isset($lot_detail['lot_data']) && $lot_detail['lot_data'] ) {
			$bag_weight = $lot_detail['lot_data']->weight;

			$stock_table = $wpdb->prefix. 'stock';
			$lots_table = $wpdb->prefix. 'lots';

			$stock_detail = array(
					'lot_id' => $lot_id,
					'bags_count' => $count,
					'bag_weight' => $bag_weight,
					'total_weight' => ($count * $bag_weight),
				);
			$wpdb->insert($stock_table, $stock_detail);


			$weight = $count * $bag_weight;
			//Update stock total in lot table
			addStock($lot_id, $weight);


			if($stock_id = $wpdb->insert_id)  {
				include( get_template_directory().'/inc/admin/list_template/list_stocks.php' );
				die();
			}
		}
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_stock_create_submit_popup', 'stock_create_submit_popup' );
add_action( 'wp_ajax_nopriv_stock_create_submit_popup', 'stock_create_submit_popup' );


function get_stock_data_by_id($stock_id = 0) {
	global $wpdb;
	$stock_table = $wpdb->prefix. 'stock';
	$lot_table = $wpdb->prefix. 'lots';

	$query = "SELECT s.*, l.lot_number, l.brand_name, l.product_name FROM ${stock_table} as s JOIN ${lot_table} as l ON s.lot_id = l.id  WHERE s.active = 1 AND l.active = 1 AND l.lot_type = 'original' AND s.id = ".$stock_id;

	return $wpdb->get_row( $query, ARRAY_A );
	die();
}

function stock_update_submit_popup($stock_id = 0) {
	$data['success'] = 0;
	$data['msg'] = 'No changes happend!';

	if(isset($_POST['stock_id']) && isset($_POST['stock_count']) && $_POST['stock_id'] != '' && $_POST['stock_count'] != '' ) {
		
		global $wpdb;
		$stock_table = $wpdb->prefix. 'stock';
		$lot_table = $wpdb->prefix. 'lots';
		$stock_id = $_POST['stock_id'];
		$stock_count = $_POST['stock_count'];
		$lots_table = $wpdb->prefix. 'lots';

	
		$query = "SELECT s.*, l.lot_number, l.brand_name, l.product_name, l.weight FROM ${stock_table} as s JOIN ${lot_table} as l ON s.lot_id = l.id  WHERE s.active = 1 AND l.active = 1 AND l.lot_type = 'original' AND s.id = ".$stock_id;
		if( $stock_detail = $wpdb->get_row($query) ) {

			$old_weight = $stock_detail->total_weight;
			$new_weight = $stock_detail->weight * $stock_count;

			//Update stock total in lot table
			$stock_now = $new_weight - $old_weight;
			addStock($stock_detail->lot_id, $stock_now);

			$sql = "UPDATE $stock_table SET bags_count = $stock_count , total_weight = ( $stock_detail->weight * $stock_count)  WHERE id = $stock_id";


			if( $wpdb->query($sql) ) {

				$wpdb->query($sql_update);

				$stock_detail_final = $wpdb->get_row($query);

				$data['success'] = 1;
				$data['msg'] = 'Stock Updated';
				$data['id'] = $stock_id;


				$content .= '<td>'.$stock_detail_final->id.'</td>';
				$content .= '<td>'.$stock_detail_final->lot_number.'</td>';
				$content .= '<td>'.$stock_detail_final->brand_name.'</td>';
				$content .= '<td>'.$stock_detail_final->product_name.'</td>';
				$content .= '<td>'.$stock_detail_final->total_weight.' Kg</td>';
				$content .= '<td>'.$stock_detail_final->bags_count.'</td>';
				$content .= '<td>'.$stock_detail_final->modified_at.'</td>';
				$content .= '<td class="center">';
				$content .= '<span>';
				$content .= '<a class="action-icons c-edit stock_edit" title="Edit" data-roll="12" data-id="'.$stock_detail_final->id.'">Edit</a>';
				$content .= '</span>';
				$content .= '<span><a class="action-icons c-delete lot_delete" href="#" title="delete" data-id="'.$stock_detail_final->id.'" data-roll="1">Delete</a></span>';
				$content .= '</td>';
				$content .= '</tr>';




				$data['content'] = $content;

			}

		}
	}


	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_stock_update_submit_popup', 'stock_update_submit_popup' );
add_action( 'wp_ajax_nopriv_stock_update_submit_popup', 'stock_update_submit_popup' );



function get_price_weight_based() {

	$data['success'] = 0;
	$data['msg'] = 'No data!';

	if(isset($_POST['lot_id']) && isset($_POST['sale_type']) && isset($_POST['total_weight']) ) {
		$lot_id = $_POST['lot_id'];
		$sale_type = $_POST['sale_type'];
		$total_weight = $_POST['total_weight'];

		global $wpdb;
		$lot_table = $wpdb->prefix. 'lots_detail';


		$query = "
( select *
from     ${lot_table}
where    weight_to >= ${total_weight} 
    AND lot_id = ${lot_id} 
    AND sale_type = '${sale_type}'
    AND active = 1
order by weight_to asc
limit 1
)
union
(
select   *
from     ${lot_table}
where    weight_to < ${total_weight}
    AND lot_id = ${lot_id} 
    AND sale_type = '${sale_type}'
    AND active = 1
order by weight_to desc
limit 1
)
order by weight_to DESC, abs(weight_to - ${total_weight}) ASC
limit 1";

		$data['price_detail'] = $wpdb->get_row($query);
		$data['success'] = 1;

	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_get_price_weight_based', 'get_price_weight_based' );
add_action( 'wp_ajax_nopriv_get_price_weight_based', 'get_price_weight_based' );


function get_customer_name() {

	$data['success'] = 0;
	$data['msg'] = 'Something Went Wrong!';

	global $wpdb;
	$search = $_POST['search_key'];
	$table =  $wpdb->prefix.'customers';
    $customPagHTML      = "";
    $query              = "SELECT * FROM ${table} WHERE active = 1 AND ( name LIKE '%${search}%' OR mobile LIKE '${search}%')";
	
	$data['result'] = $wpdb->get_results($query);
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_get_customer_name', 'get_customer_name' );
add_action( 'wp_ajax_nopriv_get_customer_name', 'get_customer_name' );



function create_bill_invoice() {

	$data['success'] = 0;
	$data['msg'] = 'Something Went Wrong!';

	global $wpdb;
	$sale_table =  $wpdb->prefix.'sale';

	$bill_date  = $_POST['bill_date'];
	$center  = $_POST['center'];
	$customer_id  = $_POST['customer_id'];

	$wpdb->insert($sale_table, array(
	    'customer_id' => esc_attr($customer_id),
	    'order_shop' => esc_attr($center),
	    'invoice_date' => esc_attr($bill_date),
	    'made_by' => get_current_user_id(),
	    'active'    => 1
	));
	if($bill_id = $wpdb->insert_id) {

		$invoice_id = 'INV'.$bill_id;
		$wpdb->update($sale_table, array( 'invoice_id' => $invoice_id ), array( 'id' => $bill_id) );
		$data['success'] = 1;
		$data['msg'] = 'Invoice Generated!';
		$data['invoice_id'] = $invoice_id;
		$data['bill_id'] = $bill_id;
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_bill_invoice', 'create_bill_invoice' );
add_action( 'wp_ajax_nopriv_create_bill_invoice', 'create_bill_invoice' );



function update_bill(){
	$data['success'] = 0;
	$data['billing_no'] = 0;
	$params = array();
	parse_str($_POST['bill_data'], $params);

	global $wpdb;
	$lots_table = $wpdb->prefix. 'lots';
	$stock_table = $wpdb->prefix. 'stock';
	$sales_table = $wpdb->prefix. 'sale';

//	$payment_history = $wpdb->prefix. 'payment_history';
	$installment_table = $wpdb->prefix. 'payment_installment';
	$lots_sale_detail_table = $wpdb->prefix. 'sale_detail';

	$stock_not_avail = array();

	$billing_date 	= $params['billing_date'];
	$billing_no 	= $params['billing_no'];

	$shop_name 		= $params['shop_name'];
	$gst_type 		= $params['gst_type'];
	$home_delivery 	= $params['home_delivery'];

	if($params['bill_by_name'] == 'no') {
		$billing_customer = 0;
		$bill_from_to = 'counter';
	} else {
		$bill_from_to = 'customer';
		if($params['user_type'] == 'old') {
			$billing_customer = $params['billing_customer'];
		} else {
			$billing_customer = $params['customer_id_new'];
		}
	}
	
	$customer_type = $params['customer_type'];

	$actual_total = $params['actual_price'];
	$discount = $params['discount'];
	$cardswip = $params['cardswip'];
	$final_total = $params['final_total'];

	$payment_done = ( $params['payment_done'] && $params['payment_done'] == 'on' ) ? 1 : 0; 

	foreach ($params['group_retail'] as $s_key => $s_value) {

		$token_id = getToken($lots_sale_detail_table);	
		$brand_display = 0;
		if(isset($s_value['brand_checkbox_input'])) {
			$brand_display = 1;
		}

		if($s_value['lot_number'])
		{
			//Combain lot and dummy lot and skip duplicate
			if($s_value['lot_parent'] && $s_value['type_bill_h'] == 'original') {
				$saleAs 		= isset($s_value['sale_as']) ? $s_value['sale_as'] : '' ;

				$bagWeightInKg 	= $s_value['bagWeightInKg'];
	
				if($s_value['lot_slab'] == 1) {
					$weight = ($saleAs == 'kg') ? $s_value['slab_yes_total'] : ($bagWeightInKg * $s_value['slab_yes_total']);
					$bag_count = ($saleAs == 'kg') ? $s_value['slab_yes_total'] : $s_value['slab_yes_total'];
					$bag_weight = $bagWeightInKg;
					$slab = 1;
				} else {
					$weight = ($saleAs == 'kg') ? $s_value['unit_count'] : ($bagWeightInKg * $s_value['unit_count']);
					$bag_count = ($saleAs == 'kg') ? ($s_value['unit_count'] / $bagWeightInKg) : $s_value['unit_count'];
					$bag_weight = $bagWeightInKg;
					$slab = 0;
				}

				//Original lot
				if($s_value['lot_number'] == $s_value['lot_parent']) {
					$update_sale[] = array('id' => $token_id,'bill_type' => 'original', 'bill_from' => $shop_name, 'lot_type' => 'real', 'lot_id' => $s_value['lot_number'], 'lot_parent_id' => $s_value['lot_parent'], 'sale_type' => $s_value['sale_type_h'],'slab' => $slab, 'sale_as'=> $saleAs, 'bag_count' => $bag_count, 'bag_weight' => $bag_weight, 'sale_weight' => $weight, 'unit_price' => $s_value['unit_price_original'], 'margin_price'=>$s_value['sale_margin_price'], 'sale_value' => $s_value['total_price'], 'sale_id' => $billing_no, 'made_by' => get_current_user_id(), 'price_orig_hidden' => $s_value['price_orig_hidden'], 'brand_display' => $brand_display, 'taxless_amt' => $s_value['taxless_total'], 'cgst_percentage' => $s_value['cgst_per_total'], 'sgst_percentage' => $s_value['sgst_per_total'], 'igst_percentage' => $s_value['igst_per_total'], 'cgst_value' => $s_value['cgst_val_total'], 'sgst_value' => $s_value['sgst_val_total'], 'igst_value' => $s_value['igst_val_total'] );
				} else { //Dummy Lot
					$update_sale[] = array('id' => $token_id,'bill_type' => 'original', 'bill_from' => $shop_name, 'lot_type' => 'dummy', 'lot_id' => $s_value['lot_number'], 'lot_parent_id' => $s_value['lot_parent'], 'sale_type' => $s_value['sale_type_h'],'slab' => $slab, 'sale_as'=> $saleAs, 'bag_count' => $bag_count, 'bag_weight' => $bag_weight, 'sale_weight' => $weight, 'unit_price' => $s_value['unit_price_original'], 'margin_price'=>$s_value['sale_margin_price'], 'sale_value' => $s_value['total_price'], 'sale_id' => $billing_no, 'made_by' => get_current_user_id(), 'price_orig_hidden' => $s_value['price_orig_hidden'], 'brand_display' => $brand_display, 'taxless_amt' => $s_value['taxless_total'], 'cgst_percentage' => $s_value['cgst_per_total'], 'sgst_percentage' => $s_value['sgst_per_total'], 'igst_percentage' => $s_value['igst_per_total'], 'cgst_value' => $s_value['cgst_val_total'], 'sgst_value' => $s_value['sgst_val_total'], 'igst_value' => $s_value['igst_val_total'] );
				}


			} else {
				$bag_count   = 0.00;
				$bag_weight  = 0.00;
				$slab        = 1;

				$update_sale[] = array('id' => $token_id,'bill_type' => 'duplicate', 'bill_from' => $s_value['type_bill_s'], 'lot_type' => '-', 'lot_id' => $s_value['lot_number'], 'lot_parent_id' => $s_value['lot_parent'], 'sale_type' => '-','slab' => $slab, 'sale_as'=> $saleAs, 'bag_count' => $bag_count, 'bag_weight' => $bag_weight, 'sale_weight' => $s_value['lot_duplicate_total'], 'unit_price' => $s_value['unit_price_duplicate'], 'margin_price'=>$s_value['sale_margin_price'], 'sale_value' => $s_value['total_price'], 'sale_id' => $billing_no, 'made_by' => get_current_user_id(), 'price_orig_hidden' => $s_value['price_orig_hidden'], 'brand_display' => $brand_display, 'taxless_amt' => $s_value['taxless_total'], 'cgst_percentage' => $s_value['cgst_per_total'], 'sgst_percentage' => $s_value['sgst_per_total'], 'igst_percentage' => $s_value['igst_per_total'], 'cgst_value' => $s_value['cgst_val_total'], 'sgst_value' => $s_value['sgst_val_total'], 'igst_value' => $s_value['igst_val_total'] );
			}
		}
	}



	if( 1 == 1 && $billing_no && $billing_no!=0 ) {

		$data['success'] = 1;
		$data['billing_no'] = $billing_no;

		//Update Sales table
		$wpdb->update($sales_table, 
			array(
				'locked' => 1,
			    'customer_id' => $billing_customer,
			    'order_shop' => $shop_name,
			    'bill_from_to' => $bill_from_to,
			    'customer_type' => $customer_type,
			    'sale_value' => $actual_total,
			    'sale_discount_price' => $discount,
			    'sale_card_swip' => $cardswip,
			    'sale_tax' => 0.00,
			    'sale_total' => $final_total,
			    'invoice_date' => $billing_date,
			    'delivery_avail' => $home_delivery,
			    'gst_to' => $gst_type,
			    'payment_done' => $payment_done,
			    'last_update_by' => get_current_user_id(),

			), array( 
				'id' => $billing_no 
			)
		);




		//Mode of payment
		PaymentCreate($params['payment_detail'],$params['payment_cash'],$params['pay_amount_cheque'], $billing_no,$billing_customer,$params['prev_pay']);
		

		//Other Payments(COD,PREV_BAL,TO PAY and Balance)
		$codCheck = isset($params['cod_check'])? 1 : 0;
		$paymentCheck = isset($params['to_pay_checkbox'])? 1 : 0;
		AddOtherPayments($codCheck, $params['cod_amount'],$paymentCheck,$params['to_pay'],$params['balance'],$billing_no);

		$previous_data_query = "SELECT * FROM ${lots_sale_detail_table} WHERE sale_id = $billing_no AND active = 1";
		$previous_data = $wpdb->get_results($previous_data_query);
		if($previous_data && count($previous_data)>0) {
			foreach ($previous_data as $p_value) {
				$sale_weight = $p_value->sale_weight;
				$lot_id = $p_value->lot_parent_id;

				if($p_value->bill_type == 'original') {
					lessSale($lot_id, $sale_weight);
				}
			}
		}


		//Remove old sale details
		$wpdb->update($lots_sale_detail_table, 
			array(
			    'active' => 0,
			), array( 
				'sale_id' => $billing_no 
			) 
		);

		foreach ($update_sale as $a_key => $a_value) {
			$wpdb->insert($lots_sale_detail_table, $a_value);

			if($a_value['bill_type'] == 'original') {
				addSale($a_value['lot_parent_id'], $a_value['sale_weight']);
			}
		}
	}

	echo json_encode($data);
	die();

}
add_action( 'wp_ajax_update_bill', 'update_bill' );
add_action( 'wp_ajax_nopriv_update_bill', 'update_bill' );







function update_bill_last(){

	$params = array();
	parse_str($_POST['bill_data'], $params);

	$data['success'] = 0;
	$data['billing_no'] = 0;
	$payment_done = ( $params['payment_done'] && $params['payment_done'] == 'on' ) ? 1 : 0; 

	foreach ($params['group_retail'] as $r_key => $r_value) {

		//Combain lot and dummy lot and skip duplicate
		if($r_value['lot_parent'] && $r_value['type_bill'] == 'original') {
			$weight = ($r_value['lot_slab'] == 1) ? $r_value['slab_yes_total'] : $r_value['slab_no_total'];
			
			if(isset($data[$r_value['lot_parent']])) {
				$data[$r_value['lot_parent']] = (float)$data[$r_value['lot_parent']] + $weight;
			} else {
				$data[$r_value['lot_parent']] = (float)$weight;
			}
		}
	}

	global $wpdb;
	$lots_table 			= $wpdb->prefix. 'lots';
	$stock_table 			= $wpdb->prefix. 'stock';
	$sales_table 			= $wpdb->prefix. 'sale';
	$lots_sale_detail_table = $wpdb->prefix. 'sale_detail';
	$payment_history 		= $wpdb->prefix. 'payment_history';
	$installment_table 		= $wpdb->prefix. 'payment_installment';
	$stock_not_avail 		= array();

	$billing_date 			= $params['billing_date'];
	$billing_no 			= $params['billing_no'];
	$shop_name 				= $params['shop_name'];
	$gst_type = $params['gst_type'];
	$home_delivery = $params['home_delivery'];

	if($params['bill_by_name'] == 'no') {
		$billing_customer = 0;
		$bill_from_to = 'counter';
	} else {
		$bill_from_to = 'customer';
		$billing_customer = $params['billing_customer'];
	}
	
	$customer_type 	= $params['customer_type'];
	$actual_total   = $params['actual_price'];
	$discount 		= $params['discount'];
	$cardswip 		= $params['cardswip'];
	$final_total 	= $params['final_total'];

	$payment_done 	= ( $params['payment_done'] && $params['payment_done'] == 'on' ) ? 1 : 0; 

	//To check and form stock availablity result
	foreach ($data as $p_key => $p_value) {

		$query = "
		SELECT tt1.*, (tt1.stock_total - tt1.sale_total)as stock_bal  from 
		(

		select *,
		( case WHEN l.parent_id = 0 Then l.id ELSE l.parent_id END ) as par_id,
		( SELECT  
		 ( case WHEN SUM(total_weight)  Then SUM(total_weight) ELSE 0 END ) 
		 from ${stock_table} s where s.active = 1 AND s.lot_id = ( case WHEN l.parent_id = 0 Then l.id ELSE l.parent_id END ) ) as stock_total, 
		    
		( SELECT 
		 ( case WHEN SUM(sale_weight)  Then SUM(sale_weight) ELSE 0 END ) 
		 from ${lots_sale_detail_table} sd where sd.active = 1 AND sd.bill_type = 'original' AND sd.lot_parent_id = ( case WHEN l.parent_id = 0 Then l.id ELSE l.parent_id END ) ) as sale_total
		from ${lots_table} as l WHERE id = ${p_key} AND active = 1 

		) as tt1";

		$d_data = $wpdb->get_row( $query, ARRAY_A );

		if($p_value > $d_data['stock_bal']) {
			$stock_not_avail[$p_key] = 'Stock Not Avail!';
		}
	}



	foreach ($params['group_retail'] as $s_key => $s_value) {

		$brand_display = 0;
		if(isset($s_value['brand_checkbox_input'])) {
			$brand_display = 1;
		}

		if( ( $s_value['lot_number'] || $s_value['lot_number2'] ) && $s_value['lot_parent']  != '' )
		{

			if(!$s_value['lot_number']) {
				$final_lot_number = $s_value['lot_number2'];
			} else {
				$final_lot_number = $s_value['lot_number'];
			}


			if(isset($s_value['bill_detail_id']) && $s_value['bill_detail_id'] != '') {
				$bill_detail_id = $s_value['bill_detail_id'];
			} else {
				$bill_detail_id = getToken($lots_sale_detail_table);
			}
				
	
			//Combain lot and dummy lot and skip duplicate
			if($s_value['lot_parent'] && $s_value['type_bill_h'] == 'original') {
				$saleAs 		= isset($s_value['sale_as']) ? $s_value['sale_as'] : '' ;
				$bagWeightInKg 	= $s_value['bagWeightInKg'];



				if($s_value['lot_slab'] == 1) {
					$weight = ($saleAs == 'kg') ? $s_value['slab_yes_total'] : ($bagWeightInKg * $s_value['slab_yes_total']);
					$bag_count = ($saleAs == 'kg') ? ($s_value['slab_yes_total'] / $bagWeightInKg) : $s_value['slab_yes_total'];
					$bag_weight = $bagWeightInKg;
					$slab = 1;
				} else {
					$weight = ($saleAs == 'kg') ? $s_value['unit_count'] : ($bagWeightInKg * $s_value['unit_count']);
					$bag_count = ($saleAs == 'kg') ? ($s_value['unit_count'] / $bagWeightInKg) : $s_value['unit_count'];
					$bag_weight = $bagWeightInKg;
					$slab = 0;
				}

				//Original lot
				if( ($s_value['lot_number'] == $s_value['lot_parent']) OR ($s_value['lot_number2'] == $s_value['lot_parent']) ) {
					$update_sale[] = array('id'=>$bill_detail_id,'bill_type' => 'original', 'bill_from' => $shop_name, 'home_delivery' => $home_delivery,  'lot_type' => 'real', 'lot_id' => $final_lot_number, 'lot_parent_id' => $s_value['lot_parent'], 'sale_type' => $s_value['sale_type_h'],'slab' => $slab, 'sale_as'=>$saleAs, 'bag_count' => $bag_count, 'bag_weight' => $bag_weight , 'sale_weight' => $weight, 'unit_price' => $s_value['unit_price_original'], 'margin_price'=>$s_value['sale_margin_price'], 'sale_value' => $s_value['total_price'], 'sale_id' => $billing_no, 'made_by' => get_current_user_id(), 'price_orig_hidden' => $s_value['price_orig_hidden'], 'brand_display' => $brand_display, 'taxless_amt' => $s_value['taxless_total'], 'cgst_percentage' => $s_value['cgst_per_total'], 'sgst_percentage' => $s_value['sgst_per_total'], 'igst_percentage' => $s_value['igst_per_total'], 'cgst_value' => $s_value['cgst_val_total'], 'sgst_value' => $s_value['sgst_val_total'], 'igst_value' => $s_value['igst_val_total'] );
				} else { //Dummy Lot
					$update_sale[] = array('id'=>$bill_detail_id,'bill_type' => 'original', 'bill_from' => $shop_name, 'home_delivery' => $home_delivery, 'lot_type' => 'dummy', 'lot_id' => $final_lot_number, 'lot_parent_id' => $s_value['lot_parent'], 'sale_type' => $s_value['sale_type_h'],'slab' => $slab, 'sale_as'=>$saleAs, 'bag_count' => $bag_count, 'bag_weight' => $bag_weight , 'sale_weight' => $weight, 'unit_price' => $s_value['unit_price_original'], 'margin_price'=>$s_value['sale_margin_price'], 'sale_value' => $s_value['total_price'], 'sale_id' => $billing_no, 'made_by' => get_current_user_id(), 'price_orig_hidden' => $s_value['price_orig_hidden'], 'brand_display' => $brand_display, 'taxless_amt' => $s_value['taxless_total'], 'cgst_percentage' => $s_value['cgst_per_total'], 'sgst_percentage' => $s_value['sgst_per_total'], 'igst_percentage' => $s_value['igst_per_total'], 'cgst_value' => $s_value['cgst_val_total'], 'sgst_value' => $s_value['sgst_val_total'], 'igst_value' => $s_value['igst_val_total'] );
				}

			} else {

				$bag_count = 0.00;
				$bag_weight = 0.00;
				$slab = 1;

				$update_sale[] = array('id'=>$bill_detail_id,'bill_type' => 'duplicate', 'bill_from' => $s_value['type_bill_s'], 'home_delivery' => $home_delivery, 'lot_type' => '-', 'lot_id' => $final_lot_number, 'lot_parent_id' => $s_value['lot_parent'], 'sale_type' => '-','slab' => $slab, 'sale_as'=>$saleAs, 'bag_count' => $bag_count, 'bag_weight' => $bag_weight , 'sale_weight' => $s_value['lot_duplicate_total'], 'unit_price' => $s_value['unit_price_duplicate'], 'margin_price'=>$s_value['sale_margin_price'],  'sale_value' => $s_value['total_price'], 'sale_id' => $billing_no, 'made_by' => get_current_user_id(), 'price_orig_hidden' => $s_value['price_orig_hidden'], 'brand_display' => $brand_display, 'taxless_amt' => $s_value['taxless_total'], 'cgst_percentage' => $s_value['cgst_per_total'], 'sgst_percentage' => $s_value['sgst_per_total'], 'igst_percentage' => $s_value['igst_per_total'], 'cgst_value' => $s_value['cgst_val_total'], 'sgst_value' => $s_value['sgst_val_total'], 'igst_value' => $s_value['igst_val_total'] );
			}
// var_dump($update_sale);
// die();
		}
	}


	if(1 == 1 && $billing_no && $billing_no != 0) {

		$data['success'] = 1;
		$data['billing_no'] = $billing_no;

		//Update Sales table
		$wpdb->update($sales_table, 
			array(
			    'customer_id' => $billing_customer,
			    'order_shop' => $shop_name,
			    'bill_from_to' => $bill_from_to,
			    'customer_type' => $customer_type,
			    'sale_value' => $actual_total,
			    'sale_discount_price' => $discount,
			    'sale_card_swip' => $cardswip,
			    'sale_tax' => 0.00,
			    'sale_total' => $final_total,
			    'invoice_date' => $billing_date,
			    'delivery_avail' => $home_delivery,
			    'gst_to' => $gst_type,
			    'payment_done' => $payment_done,
			    'last_update_by' => get_current_user_id(),

			), array( 
				'id' => $billing_no 
			) 
		);



//Update in all Payments

		// $payment_total = $params['payment_total_without_pre'];

		//Mode of payment
		PaymentUpdate($params['payment_detail'],$params['payment_cash'],$params['pay_amount_cheque'], $billing_no,$billing_customer,$params['pay_pre_bal']);
		

		//Other Payments(COD,PREV_BAL,TO PAY and Balance)
		$codCheck = isset($params['cod_check'])? 1 : 0;
		$paymentCheck = isset($params['to_pay_checkbox'])? 1 : 0;
		AddOtherPayments($codCheck, $params['cod_amount'],$paymentCheck,$params['to_pay'],$params['balance'],$billing_no);


		$previous_data_query = "SELECT * FROM ${lots_sale_detail_table} WHERE sale_id = $billing_no AND active = 1";
		$previous_data = $wpdb->get_results($previous_data_query);
		if($previous_data && count($previous_data)>0) {
			foreach ($previous_data as $p_value) {
				$sale_weight = $p_value->sale_weight;
				$lot_id = $p_value->lot_parent_id;

				if($p_value->bill_type == 'original') {
					lessSale($lot_id, $sale_weight);
				}

			}
		}


		//Remove old sale details
		$wpdb->update($lots_sale_detail_table, 
			array(
			    'active' => 0,
			), array( 
				'sale_id' => $billing_no 
			) 
		);
	
		//Insert new sale detail
		foreach ($update_sale as $a_key => $a_value) {
			$wpdb->insert($lots_sale_detail_table, $a_value);

			if($a_value['bill_type'] == 'original') {
				addSale($a_value['lot_parent_id'], $a_value['sale_weight']);
			}
			
		}		

	}

	echo json_encode($data);
	die();

}
add_action( 'wp_ajax_update_bill_last', 'update_bill_last' );
add_action( 'wp_ajax_nopriv_update_bill_last', 'update_bill_last' );









function getBillDetail($bill_no = 0){
	$data['success'] = 0;
	global $wpdb;
	$sale_detail_table = 	$wpdb->prefix.'sale_detail';
	$sales_table = 	$wpdb->prefix.'sale';
	$stock_table = 	$wpdb->prefix.'stock';
	$customer_table = $wpdb->prefix.'customers';
	$payment_history = $wpdb->prefix.'payment_history';
	$payment_installment = $wpdb->prefix.'payment_installment';


	$bill_query              = "SELECT * FROM ${sales_table} WHERE id = '${bill_no}' OR invoice_id = '${bill_no}'";
	$data['bill_data'] = $wpdb->get_row($bill_query);

	if($data['bill_data']) {

		$data['success'] = 1;
		$customer_id = isset($data['bill_data']->customer_id) ? $data['bill_data']->customer_id : 0;
		$data['customer_data'] =  getCustomerDetail($customer_id);
		

		$bill_id = $data['bill_data']->id;
		$bill_detail_query = "SELECT *, sdo.id as sale_detail_id FROM wp_sale_detail sdo

JOIN (

SELECT tt1.*, (tt1.stock_total - tt1.sale_total) as stock_bal from ( select *, ( case WHEN l.parent_id = 0 Then l.id ELSE l.parent_id END ) as par_id, ( SELECT ( case WHEN SUM(total_weight) Then SUM(total_weight) ELSE 0 END ) from wp_stock s where s.active = 1 AND s.lot_id = ( case WHEN l.parent_id = 0 Then l.id ELSE l.parent_id END ) ) as stock_total, ( SELECT ( case WHEN SUM(sale_weight) Then SUM(sale_weight) ELSE 0 END ) from wp_sale_detail sd where sd.active = 1 AND sd.bill_type = 'original' AND sd.lot_parent_id = ( case WHEN l.parent_id = 0 Then l.id ELSE l.parent_id END ) ) as sale_total from wp_lots as l WHERE  active = 1 ) as tt1
) as lt ON lt.par_id = sdo.lot_parent_id WHERE sdo.sale_id = ${bill_id} AND sdo.lot_id = lt.id AND sdo.active=1";


	$data['bill_detail_data'] = $wpdb->get_results($bill_detail_query);
	$data['payment_history'] = $wpdb->get_row("SELECT * FROM ${payment_history} WHERE sale_id = ${bill_no} AND active = 1");


	$data['cash_payment'] = $wpdb->get_results("SELECT * FROM ${payment_installment} WHERE sale_id = ${bill_no} AND payment_method ='cash_payment' AND active = 1");
	$data['card_payment'] = $wpdb->get_results("SELECT * FROM ${payment_installment} WHERE sale_id = ${bill_no} AND payment_method ='card_payment' AND active = 1");
	$data['neft_content'] = $wpdb->get_results("SELECT * FROM ${payment_installment} WHERE sale_id = ${bill_no} AND payment_method ='neft_content' AND active = 1");
	$data['cheque_content'] = $wpdb->get_results("SELECT * FROM ${payment_installment} WHERE sale_id = ${bill_no} AND payment_method ='cheque_content' AND active = 1");
	} else {
		$data['msg'] = 'Bill Not Found';
	}
	return $data;
}

function getBillReturnDetail($bill_no = 0) {
	$data['success'] = 0;
	global $wpdb;
	$sale_detail_table = 	$wpdb->prefix.'sale_detail';
	$sales_table = 	$wpdb->prefix.'sale';
	$stock_table = 	$wpdb->prefix.'stock';
	$customer_table = $wpdb->prefix.'customers';


	$bill_query              = "SELECT * FROM ${sales_table} WHERE id = '${bill_no}' OR invoice_id = '${bill_no}'";
	$bill_data = $wpdb->get_row($bill_query);

	if($bill_data) {

		$data['success'] = 1;
		

		$bill_id = $bill_data->id;
		$bill_detail_query = "SELECT *, sdo.id as sale_detail_id FROM wp_sale_detail sdo

JOIN (

SELECT tt1.*, (tt1.stock_total - tt1.sale_total)as stock_bal from ( select *, ( case WHEN l.parent_id = 0 Then l.id ELSE l.parent_id END ) as par_id, ( SELECT ( case WHEN SUM(total_weight) Then SUM(total_weight) ELSE 0 END ) from wp_stock s where s.active = 1 AND s.lot_id = ( case WHEN l.parent_id = 0 Then l.id ELSE l.parent_id END ) ) as stock_total, ( SELECT ( case WHEN SUM(sale_weight) Then SUM(sale_weight) ELSE 0 END ) from wp_sale_detail sd where sd.active = 1 AND sd.bill_type = 'original' AND sd.lot_parent_id = ( case WHEN l.parent_id = 0 Then l.id ELSE l.parent_id END ) ) as sale_total from wp_lots as l WHERE  active = 1 ) as tt1
    
) as lt ON lt.par_id = sdo.lot_parent_id WHERE sdo.sale_id = ${bill_id} AND sdo.lot_id = lt.id AND sdo.item_status = 'return'";

	$data['bill_detail_data'] = $wpdb->get_results($bill_detail_query);

	} else {
		$data['msg'] = 'Bill Not Found';
	}

	return $data;
}


function getCustomerDetail($customer_id = 0) {
	global $wpdb;
	$customer_table = $wpdb->prefix.'customers';
	$customer_query = "SELECT * FROM ${customer_table} WHERE id = ${customer_id}";
	return $wpdb->get_row($customer_query);
}


function mark_attendance() {
	$data['success'] = 0;

	global $wpdb;
	$attendance_table = $wpdb->prefix.'employee_attendance';


	$date = $_POST['attendance_date'];
	$emp_id = $_POST['emp_id'];
	$attendance = $_POST['attendance'];

	$wpdb->update($attendance_table, array(
	    'active' => 0,
	), array( 'emp_id' => $emp_id, 'attendance_date' => $date ) );

	if($attendance != '-') {
		$wpdb->insert($attendance_table, array(
		    'emp_id' => esc_attr($emp_id),
		    'emp_attendance' => esc_attr($attendance),
		    'attendance_date' => esc_attr($date),
		    'active' => 1,
		));
	}

	$data['success'] = 1;
	$data['attendance'] = $attendance;

	echo json_encode($data);
	die();

}
add_action( 'wp_ajax_mark_attendance', 'mark_attendance' );
add_action( 'wp_ajax_nopriv_mark_attendance', 'mark_attendance' );










function get_salary_create_form_popup(){
	include('ajax/get_salary_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_get_salary_create_form_popup', 'get_salary_create_form_popup' );
add_action( 'wp_ajax_nopriv_get_salary_create_form_popup', 'get_salary_create_form_popup' );


function edit_salary_create_form_popup(){
	include('ajax/edit_salary_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_edit_salary_create_form_popup', 'edit_salary_create_form_popup' );
add_action( 'wp_ajax_nopriv_edit_salary_create_form_popup', 'edit_salary_create_form_popup' );



function get_employee_by_id($id=0) {
	global $wpdb;
	$employee_table = $wpdb->prefix. 'employees';
	$search_term = $_POST['search_key'];

	$query = "SELECT * from ${employee_table}  WHERE id = ${id} AND active = 1";

	if( $data = $wpdb->get_row( $query, ARRAY_A ) ) {
		return $data;
	} else {
		return false;
	}

}

function get_employee_data() {
	global $wpdb;
	$data['success'] = 0;
	$employee_table = $wpdb->prefix. 'employees';
	$search_term = $_POST['search_key'];

	$query = "SELECT * from ( SELECT *, CONCAT('EMP', id) as employee_no from ${employee_table} ) e WHERE ( e.emp_name like '${search_term}%' OR e.emp_mobile like '${search_term}%' OR e.employee_no like '${search_term}%' ) AND e.active = 1";

	if( $data['items'] = $wpdb->get_results( $query, ARRAY_A ) ) {
		$data['success'] = 1;
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_get_employee_data', 'get_employee_data' );
add_action( 'wp_ajax_nopriv_get_employee_data', 'get_employee_data' );



function post_salary_create_popup(){
	global $wpdb;
	$data['success'] = 0;
	$params = array();
	parse_str($_POST['data'], $params);




	$salary_table = $wpdb->prefix. 'employee_salary';

	if($params['pay_in'] == 'salary') {

		$sal_data['emp_id'] = esc_attr($params['emp_name']);
		$sal_data['sal_status'] = esc_attr($params['pay_in']);	
		$sal_data['sal_update_date'] = esc_attr($params['salary_date']);
		$sal_data['amount'] = esc_attr($params['salary_pay']);
		$sal_data['remark'] = 'sal';

		$wpdb->insert($salary_table, $sal_data);

		$sal_adv_data['emp_id'] = $sal_data['emp_id'];
		$sal_adv_data['sal_status'] = 'advance';
		$sal_adv_data['sal_update_date'] = $sal_data['sal_update_date'];
		$sal_adv_data['amount'] = esc_attr($params['adv_hand']);
		$sal_adv_data['remark'] = 'adv_prv';

		$wpdb->insert($salary_table, $sal_adv_data);

		/*$in_data['from_advance'] = 0;
		if(isset($params['sal_from_adv']) && $params['sal_from_adv'] == 'on') {
			$in_data['from_advance'] = 1;
		}*/


	} else {

		$adv_data['emp_id'] = esc_attr($params['emp_name']);
		$adv_data['sal_status'] = esc_attr($params['pay_in']);	
		$adv_data['sal_update_date'] = esc_attr($params['salary_date']);
		$adv_data['amount'] = esc_attr($params['salary_advance']);	
		$adv_data['remark'] = 'adv';
		
		$wpdb->insert($salary_table, $adv_data);
	}

	if($wpdb->insert_id) {
		include( get_template_directory().'/inc/admin/list_template/list_salary.php' );
		die();
	} else {
		echo json_encode($data, JSON_PRETTY_PRINT);
		die();
	}

}
add_action( 'wp_ajax_post_salary_create_popup', 'post_salary_create_popup' );
add_action( 'wp_ajax_nopriv_post_salary_create_popup', 'post_salary_create_popup' );





function get_petty_cash_create_form_popup(){
	include('ajax/get_petty_cash_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_get_petty_cash_create_form_popup', 'get_petty_cash_create_form_popup' );
add_action( 'wp_ajax_nopriv_get_petty_cash_create_form_popup', 'get_petty_cash_create_form_popup' );

function edit_petty_cash_create_form_popup(){
	include('ajax/edit_petty_cash_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_edit_petty_cash_create_form_popup', 'edit_petty_cash_create_form_popup' );
add_action( 'wp_ajax_nopriv_edit_petty_cash_create_form_popup', 'edit_petty_cash_create_form_popup' );





function get_income_create_form_popup(){
	include('ajax/get_income_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_get_income_create_form_popup', 'get_income_create_form_popup' );
add_action( 'wp_ajax_nopriv_get_income_create_form_popup', 'get_income_create_form_popup' );

function edit_income_create_form_popup(){
	include('ajax/edit_income_create_form_popup.php');
	die();
}
add_action( 'wp_ajax_edit_income_create_form_popup', 'edit_income_create_form_popup' );
add_action( 'wp_ajax_nopriv_edit_income_create_form_popup', 'edit_income_create_form_popup' );





function post_petty_cash_create_popup(){
	global $wpdb;
	$data['success'] = 0;
	$params = array();
	parse_str($_POST['data'], $params);


	$customer_table = $wpdb->prefix. 'petty_cash';
	$wpdb->insert($customer_table, array(
	    'cash_date' => esc_attr($params['cash_date']),
	    'cash_amount' => esc_attr($params['cash_amount']),
	    'cash_description' => esc_attr($params['cash_description']),
	));
	if($wpdb->insert_id) {
		include( get_template_directory().'/inc/admin/list_template/list_petty_cash.php' );
		die();
	} else {
		echo json_encode($data, JSON_PRETTY_PRINT);
		die();
	}

}
add_action( 'wp_ajax_post_petty_cash_create_popup', 'post_petty_cash_create_popup' );
add_action( 'wp_ajax_nopriv_post_petty_cash_create_popup', 'post_petty_cash_create_popup' );


function post_income_create_popup(){
	global $wpdb;
	$data['success'] = 0;
	$params = array();
	parse_str($_POST['data'], $params);

	$customer_table = $wpdb->prefix. 'income_list';
	$wpdb->insert($customer_table, array(
	    'cash_date' => esc_attr($params['cash_date']),
	    'cash_amount' => esc_attr($params['cash_amount']),
	    'cash_description' => esc_attr($params['cash_description']),
	));
	if($wpdb->insert_id) {
		include( get_template_directory().'/inc/admin/list_template/list_income.php' );
		die();
	} else {
		echo json_encode($data, JSON_PRETTY_PRINT);
		die();
	}

}
add_action( 'wp_ajax_post_income_create_popup', 'post_income_create_popup' );
add_action( 'wp_ajax_nopriv_post_income_create_popup', 'post_income_create_popup' );


function getPettyCash($id = 0) {
	global $wpdb;

	$petty_cash_table = $wpdb->prefix. 'petty_cash';
	$query = "SELECT * FROM {$petty_cash_table} WHERE id=".$id;

	return $wpdb->get_row( $query );
}

function getIncome($id = 0) {
	global $wpdb;

	$income_list_table = $wpdb->prefix. 'income_list';
	$query = "SELECT * FROM {$income_list_table} WHERE id=".$id;

	return $wpdb->get_row( $query );
}



function petty_cash_update_submit_popup($stock_id = 0) {

	global $wpdb;
	$data['success'] = 0;
	$params = array();
	parse_str($_POST['data'], $params);

	$pretty_cash_table = $wpdb->prefix. 'petty_cash';
	if( $wpdb->update($pretty_cash_table, array(
	    'cash_date' => esc_attr($params['cash_date']),
	    'cash_amount' => esc_attr($params['cash_amount']),
	    'cash_description' => esc_attr($params['cash_description']),
	), array('id' => $params['id'])) ) {




		$data['roll_id'] = ( isset($params['roll_id']) && $params['roll_id'] != '') ? $params['roll_id'] : '';
		$data['success'] = 1;
		$data['id'] = $params['id'];


		$content = '';
		$content .= '<td>'.$params['roll_id'].'</td>';
		$content .= '<td>'.date('Y-m-d', strtotime($params['cash_date'])).'</td>';
		$content .= '<td>'.$params['cash_description'].'</td>';
		$content .= '<td>'.$params['cash_amount'].'</td>';
		$content .= '<td class="center">';
		$content .= '<span>';
		$content .= '<a class="action-icons c-edit edit_petty_cash" title="Edit" data-roll="'.$params['roll_id'].'" data-id="'.$params['id'].'">Edit</a>';
		$content .= '</span>';
		$content .= '<span><a class="action-icons c-delete lot_delete" href="#" title="delete" data-id="'.$params['id'].'" data-roll="'.$params['roll_id'].'">Delete</a></span>';
		$content .= '</td>';

		$data['content'] = $content;


	}

	echo json_encode($data, JSON_PRETTY_PRINT);
	die();

}
add_action( 'wp_ajax_petty_cash_update_submit_popup', 'petty_cash_update_submit_popup' );
add_action( 'wp_ajax_nopriv_petty_cash_update_submit_popup', 'petty_cash_update_submit_popup' );



function income_update_submit_popup($stock_id = 0) {

	global $wpdb;
	$data['success'] = 0;
	$params = array();
	parse_str($_POST['data'], $params);

	$pretty_cash_table = $wpdb->prefix. 'income_list';
	if( $wpdb->update($pretty_cash_table, array(
	    'cash_date' => esc_attr($params['cash_date']),
	    'cash_amount' => esc_attr($params['cash_amount']),
	    'cash_description' => esc_attr($params['cash_description']),
	), array('id' => $params['id'])) ) {




		$data['roll_id'] = ( isset($params['roll_id']) && $params['roll_id'] != '') ? $params['roll_id'] : '';
		$data['success'] = 1;
		$data['id'] = $params['id'];


		$content = '';
		$content .= '<td>'.$params['roll_id'].'</td>';
		$content .= '<td>'.date('Y-m-d', strtotime($params['cash_date'])).'</td>';
		$content .= '<td>'.$params['cash_description'].'</td>';
		$content .= '<td>'.$params['cash_amount'].'</td>';
		$content .= '<td class="center">';
		$content .= '<span>';
		$content .= '<a class="action-icons c-edit edit_petty_cash" title="Edit" data-roll="'.$params['roll_id'].'" data-id="'.$params['id'].'">Edit</a>';
		$content .= '</span>';
		$content .= '<span><a class="action-icons c-delete lot_delete" href="#" title="delete" data-id="'.$params['id'].'" data-roll="'.$params['roll_id'].'">Delete</a></span>';
		$content .= '</td>';

		$data['content'] = $content;


	}

	echo json_encode($data, JSON_PRETTY_PRINT);
	die();

}
add_action( 'wp_ajax_income_update_submit_popup', 'income_update_submit_popup' );
add_action( 'wp_ajax_nopriv_income_update_submit_popup', 'income_update_submit_popup' );





function searchLotNumber() {
	global $wpdb;
	$data['success'] = 0;
	$lots_table = $wpdb->prefix. 'lots';
	$search_term = $_POST['search_key'];

	$query = "SELECT * FROM {$lots_table} WHERE lot_number like '%${search_term}%' AND active = 1";

	if( $data['items'] = $wpdb->get_results( $query, ARRAY_A ) ) {
		$data['success'] = 1;
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_searchLotNumber', 'searchLotNumber' );
add_action( 'wp_ajax_nopriv_searchLotNumber', 'searchLotNumber' );


function searchBrandName() {
	global $wpdb;
	$data['success'] = 0;
	$lots_table = $wpdb->prefix. 'lots';
	$search_term = $_POST['search_key'];

	$query = "SELECT brand_name FROM {$lots_table} WHERE active = 1 AND brand_name like '%${search_term}%' GROUP BY brand_name";
	if( $data['items'] = $wpdb->get_results( $query, ARRAY_A ) ) {
		$data['success'] = 1;
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_searchBrandName', 'searchBrandName' );
add_action( 'wp_ajax_nopriv_searchBrandName', 'searchBrandName' );

function searchStockName() {
	global $wpdb;
	$data['success'] = 0;
	$lots_table = $wpdb->prefix. 'lots';
	$search_term = $_POST['search_key'];

	$query = "SELECT product_name FROM {$lots_table} WHERE active = 1 AND product_name like '%${search_term}%' GROUP BY product_name";
	if( $data['items'] = $wpdb->get_results( $query, ARRAY_A ) ) {
		$data['success'] = 1;
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_searchStockName', 'searchStockName' );
add_action( 'wp_ajax_nopriv_searchStockName', 'searchStockName' );




function stock_search_filter() {
	global $wpdb;
	$data['success'] = 0;
	$lots_table = $wpdb->prefix. 'lots';
	$sale_detail = $wpdb->prefix.'sale_detail';
	$stock_detail = $wpdb->prefix.'stock';
	$search_term = $_POST['search_key'];

    $con = false;
    $condition = '';
    if( isset($_POST['lot_id']) && $_POST['lot_id'] != '' && $_POST['lot_id']!='-') {
    	if($con == false) {
    		$condition .= "WHERE lot.id = ".$_POST['lot_id']." ";
    	} else {
    		$condition .= "AND lot.id = ".$_POST['lot_id']." ";
    	}
    	$con = true;
    }
    if( isset($_POST['brand_name']) && $_POST['brand_name']!='' && $_POST['brand_name']!='-') {
   		if($con == false) {
    		$condition .= "WHERE lot.brand_name = '".$_POST['brand_name']."' ";
    	} else {
    		$condition .= "AND lot.brand_name = '".$_POST['brand_name']."' ";
    	}
    	$con = true;
    }
    if( isset($_POST['stock_name']) && $_POST['stock_name']!='' && $_POST['stock_name']!='-') {
   		if($con == false) {
    		$condition .= "WHERE lot.product_name = '".$_POST['stock_name']."' ";
    	} else {
    		$condition .= "AND lot.product_name = '".$_POST['stock_name']."' ";
    	}
    	$con = true;
    }


	$query = "SELECT lot.*, (CASE WHEN sale.sale_total THEN sale.sale_total ELSE 0 END)  as sale_tot, (CASE WHEN stock.stock_total THEN stock.stock_total ELSE 0 END) stock_tot,
    
    ( (CASE WHEN stock.stock_total THEN stock.stock_total ELSE 0 END) - (CASE WHEN sale.sale_total THEN sale.sale_total ELSE 0 END)  ) as bal_stock
    
    
    FROM 
    (
        SELECT l.id, l.lot_number, l.brand_name, l.product_name,  
        (CASE 
            WHEN l.parent_id = 0 
            THEN l.id
            ELSE l.parent_id
         END ) as parent_id
        FROM ${lots_table} l WHERE l.active = 1
    ) 
    lot LEFT JOIN 
    (
        SELECT s.lot_parent_id as sale_lot_id, SUM(s.sale_weight) as sale_total FROM ${sale_detail} s WHERE s.active = 1 AND s.bill_type = 'original' AND item_status = 'open' GROUP BY s.lot_parent_id
    ) 
    sale ON lot.parent_id = sale.sale_lot_id LEFT JOIN 
    (
        SELECT s1.lot_id as stock_lot_id, SUM(s1.total_weight) as stock_total FROM ${stock_detail} s1 WHERE s1.active = 1 GROUP BY s1.lot_id    
    ) 
    stock ON lot.parent_id = stock.stock_lot_id ".$condition;

	if( $data['items'] = $wpdb->get_results( $query, ARRAY_A ) ) {
		$data['success'] = 1;
	}

	echo json_encode($data);
	die();


}
add_action( 'wp_ajax_stock_search_filter', 'stock_search_filter' );
add_action( 'wp_ajax_nopriv_stock_search_filter', 'stock_search_filter' );

/*    SELECT lot.*, (CASE WHEN sale.sale_total THEN sale.sale_total ELSE 0 END)  as stock_tot, (CASE WHEN stock.stock_total THEN stock.stock_total ELSE 0 END) stock_tot,
    
    ( (CASE WHEN stock.stock_total THEN stock.stock_total ELSE 0 END) - (CASE WHEN sale.sale_total THEN sale.sale_total ELSE 0 END)  ) as stock_total
    
    
    FROM 
    (
        SELECT l.id, l.lot_number, l.brand_name, l.product_name,  
        (CASE 
            WHEN l.parent_id = 0 
            THEN l.id
            ELSE l.parent_id
         END ) as parent_id
        FROM wp_lots l WHERE l.active = 1
    ) 
    lot LEFT JOIN 
    (
        SELECT s.lot_parent_id as sale_lot_id, SUM(s.sale_weight) as sale_total FROM wp_sale_detail s WHERE s.active = 1 AND s.bill_type = 'original' AND item_status = 'open' GROUP BY s.lot_parent_id
    ) 
    sale ON lot.parent_id = sale.sale_lot_id LEFT JOIN 
    (
        SELECT s1.lot_id as stock_lot_id, SUM(s1.total_weight) as stock_total FROM wp_stock s1 WHERE s1.active = 1 GROUP BY s1.lot_id    
    ) 
    stock ON lot.parent_id = stock.stock_lot_id
*/


function src_delete_data() {
	global $wpdb;
	$table_post = $_POST['data_tb'];
	$data_id = $_POST['data_id'];
	$data['success'] = 1;
	$table = $wpdb->prefix.$table_post;

	$wpdb->update(
		$table,
		array(
			'active' => 0,
		),
		array( 'id' => $data_id ), 
		array( 
			'%d'
		),
		array( '%d' )
	);

	if($table_post == 'stock') {
		$sql = "SELECT * FROM $table WHERE id = $data_id";
		$existing_data = $wpdb->get_row( $sql );
		$lot_id = $existing_data->lot_id;
		$old_weight = $existing_data->total_weight;
		lessStock($lot_id ,$old_weight);
	}

	if($table_post == 'return_detail') {
		$sql = "SELECT rd.return_weight,  sd.lot_parent_id  FROM $table as rd JOIN wp_sale_detail as sd ON rd.sale_detail_id = sd.id WHERE rd.id = $data_id AND sd.active = 1";
		$existing_data = $wpdb->get_row( $sql );
		$lot_id = $existing_data->lot_parent_id;
		$old_weight = $existing_data->return_weight;
		lessReturn($lot_id ,$old_weight);
	}


	echo json_encode($data, JSON_PRETTY_PRINT);
	die();

}
add_action( 'wp_ajax_src_delete_data', 'src_delete_data' );
add_action( 'wp_ajax_nopriv_src_delete_data', 'src_delete_data' );



function lot_list_filter() {
	include( get_template_directory().'/inc/admin/list_template/list_lots.php' );
	die();
}
add_action( 'wp_ajax_lot_list_filter', 'lot_list_filter' );
add_action( 'wp_ajax_nopriv_lot_list_filter', 'lot_list_filter' );

function stock_list_filter() {
	include( get_template_directory().'/inc/admin/list_template/list_stocks.php' );
	die();
}
add_action( 'wp_ajax_stock_list_filter', 'stock_list_filter' );
add_action( 'wp_ajax_nopriv_stock_list_filter', 'stock_list_filter' );

function customer_list_filter() {
	include( get_template_directory().'/inc/admin/list_template/list_customers.php' );
	die();
}
add_action( 'wp_ajax_customer_list_filter', 'customer_list_filter' );
add_action( 'wp_ajax_nopriv_customer_list_filter', 'customer_list_filter' );

function employee_list_filter() {
	include( get_template_directory().'/inc/admin/list_template/list_employee.php' );
	die();
}
add_action( 'wp_ajax_employee_list_filter', 'employee_list_filter' );
add_action( 'wp_ajax_nopriv_employee_list_filter', 'employee_list_filter' );

function attendance_list_filter() {
	include( get_template_directory().'/inc/admin/list_template/list_attendance.php' );
	die();
}
add_action( 'wp_ajax_attendance_list_filter', 'attendance_list_filter' );
add_action( 'wp_ajax_nopriv_attendance_list_filter', 'attendance_list_filter' );


function salary_list_filter() {
	include( get_template_directory().'/inc/admin/list_template/list_salary.php' );
	die();
}
add_action( 'wp_ajax_salary_list_filter', 'salary_list_filter' );
add_action( 'wp_ajax_nopriv_salary_list_filter', 'salary_list_filter' );


function bill_list_filter() {
	include( get_template_directory().'/inc/admin/billing_template/billing_list.php' );
	die();
}
add_action( 'wp_ajax_bill_list_filter', 'bill_list_filter' );
add_action( 'wp_ajax_nopriv_bill_list_filter', 'bill_list_filter' );

function delivery_list_filter() {
	include( get_template_directory().'/inc/admin/list_template/list_delivery.php' );
	die();
}
add_action( 'wp_ajax_delivery_list_filter', 'delivery_list_filter' );
add_action( 'wp_ajax_nopriv_delivery_list_filter', 'delivery_list_filter' );

function petty_cash_list_filter() {
	include( get_template_directory().'/inc/admin/list_template/list_petty_cash.php' );
	die();
}
add_action( 'wp_ajax_petty_cash_list_filter', 'petty_cash_list_filter' );
add_action( 'wp_ajax_nopriv_petty_cash_list_filter', 'petty_cash_list_filter' );


function income_list_filter() {
	include( get_template_directory().'/inc/admin/list_template/list_income.php' );
	die();
}
add_action( 'wp_ajax_income_list_filter', 'income_list_filter' );
add_action( 'wp_ajax_nopriv_income_list_filter', 'income_list_filter' );

function stock_report_list() {
	include( get_template_directory().'/inc/admin/report/list-template/list-stock-detail.php' );
	die();
}
add_action( 'wp_ajax_stock_report_list', 'stock_report_list' );
add_action( 'wp_ajax_nopriv_stock_report_list', 'stock_report_list' );

function stock_sale_filter_list() {
	include( get_template_directory().'/inc/admin/report/list-template/list-sale-detail.php' );
	die();
}
add_action( 'wp_ajax_stock_sale_filter_list', 'stock_sale_filter_list' );
add_action( 'wp_ajax_nopriv_stock_sale_filter_list', 'stock_sale_filter_list' );



function getBillStatus($bill_id) {
	global $wpdb;

	$sale_table = $wpdb->prefix.'sale';
	$query = "SELECT invoice_status FROM {$sale_table} WHERE id=".$bill_id;
	if($res = $wpdb->get_row( $query, OBJECT )) {
		return $res->invoice_status;
	}
	return false;
}

function update_delivery_status_create_form_popup($stock_id = 0) {

	global $wpdb;
	$bill_id = $_POST['bill_id'];
	$bill_status = getBillStatus($bill_id);

	$pending_status = '';
	$process_status = '';
	$delivered_status = '';

	if($bill_status == 'pending') {
		$pending_status = 'selected';
	}
	if($bill_status == 'process') {
		$process_status = 'selected';
	}
	if($bill_status == 'delivered') {
		$delivered_status = 'selected';
	}



	echo "<div style='margin-top: 15px;'>";
	echo "<input type='hidden' id='bill_id_hidden' value='".$bill_id."'>";
	echo "<div style='float:left;width:50%;'>Status</div>";
	echo "</div>";
	echo "<div style='float:left;width:50%;'>";
	echo "<select style='width:100%;' class='sale_status'>";
	echo "<option ".$pending_status." value='pending'>Waiting</option>";
	echo "<option ".$process_status." value='process'>Process</option>";
	echo "<option ".$delivered_status." value='delivered'>Delivered</option>";
	echo "</select>";
	echo "</div>";
	echo "<div style='clear:both;'></div>";
	echo "<div class='button_sub' style='margin-top: 10px;width:inherit;'>";
	echo "<button type='submit' id='update_sale_status' class='submit-button' style='margin-right: 0;float: right;'>Submit</button>";
	echo "</div>";
	echo "</div>";
	die();

}
add_action( 'wp_ajax_update_delivery_status_create_form_popup', 'update_delivery_status_create_form_popup' );
add_action( 'wp_ajax_nopriv_update_delivery_status_create_form_popup', 'update_delivery_status_create_form_popup' );



function update_sale_status() {

	global $wpdb;
	$sale_status = $_POST['sale_status'];
	$sale_id = $_POST['sale_id'];
	$sale_table = $wpdb->prefix. 'sale';
	$data['success'] = 0;

	if($sale_status == 'pending' || $sale_status == 'process' || $sale_status == 'delivered') {

		$wpdb->update( 
			$sale_table, 
			array( 
				'invoice_status' => strtolower($sale_status),
			), 
			array( 'id' => $sale_id ), 
			array( 
				'%s'
			), 
			array( '%d' ) 
		);


		if($sale_status == 'pending') {
			$data['invoice_status'] = '<span class="c-pending">Waiting</span>';
		}
		if($sale_status == 'process') {
			$data['invoice_status'] = '<span class="c-process">Process</span>';
		}
		if($sale_status == 'delivered') {
			$data['invoice_status'] = '<span class="c-delivered">Delivered</span>';
		}

		$data['success'] = 1;
	}

	echo json_encode($data, JSON_PRETTY_PRINT);
	die();
}
add_action( 'wp_ajax_update_sale_status', 'update_sale_status' );
add_action( 'wp_ajax_nopriv_update_sale_status', 'update_sale_status' );



function get_salery_pay_details($emp_id = 0, $pay_date = 0 ) {


	global $wpdb;
	$data['success'] = 0;
	$employee_table = $wpdb->prefix. 'employees';
	$employee_salary_table = $wpdb->prefix.'employee_salary';

	if( isset($_POST['employee_id'] ) && isset( $_POST['pay_date'] ) ) {
		$emp_id = ( isset($_POST['employee_id'] ) ) ? $_POST['employee_id'] : 0;
		$pay_date = ( isset($_POST['pay_date'] ) ) ? $_POST['pay_date'] : date("Y-m-d");
	} else {
		$emp_id = ( $emp_id != 0 ) ? $emp_id : 0;
		$pay_date = ( $pay_date != 0 ) ? $pay_date : date("Y-m-d");
	}



	//Payment Salary

	$paid_query = "SELECT * FROM ( SELECT e.id as emp_id, e.emp_salary, e.emp_joining, e.emp_current_status, ( CASE WHEN es.sal_status IS NULL THEN 'fresh' ELSE es.sal_status END ) AS sal_status, ( CASE WHEN es.sal_update_date IS NULL THEN e.emp_joining ELSE es.sal_update_date END ) AS sal_update_date, ( CASE WHEN es.amount IS NULL THEN 0.00 ELSE es.amount END ) AS amount, ( CASE WHEN es.active IS NULL THEN 1 ELSE es.active END ) AS active from ".$employee_salary_table." as es RIGHT JOIN ".$employee_table." as e ON e.id = es.emp_id WHERE e.active = 1 AND e.id= ".$emp_id." ) as tot WHERE ( tot.sal_status ='salary' OR tot.sal_status = 'fresh' ) ORDER BY tot.sal_update_date DESC ";

	$pay_data = $wpdb->get_results( $paid_query );

	if(count($pay_data) == 1) {

		$data['last_paid_amount'] = 0.00;
		$data['salary_per_day'] = $pay_data[0]->emp_salary;
		$data['last_paid_date'] = $pay_data[0]->sal_update_date;

		if($pay_data[0]->active != 0 ) {
			$data['last_paid_amount'] = $pay_data[0]->amount;
		}

	} else {

		$data['last_paid_amount'] = 0.00;
		foreach ($pay_data as $p_value) {

			$data['salary_per_day'] = $p_value->emp_salary;
			$data['last_paid_date'] = $p_value->emp_joining;

			if($p_value->active == 1) {

				$data['last_paid_amount'] = $p_value->amount;
				$data['salary_per_day'] = $p_value->emp_salary;
				$data['last_paid_date'] = $p_value->sal_update_date;

				break;
			}
		}
	}


	//Payment Advance

	$adv_paid_query = "SELECT * FROM ( SELECT e.id as emp_id, e.emp_salary, e.emp_joining, e.emp_current_status, ( CASE WHEN es.sal_status IS NULL THEN 'fresh' ELSE es.sal_status END ) AS sal_status, ( CASE WHEN es.sal_update_date IS NULL THEN e.emp_joining ELSE es.sal_update_date END ) AS sal_update_date, ( CASE WHEN es.amount IS NULL THEN 0.00 ELSE es.amount END ) AS amount, ( CASE WHEN es.active IS NULL THEN 1 ELSE es.active END ) AS active from ".$employee_salary_table." as es RIGHT JOIN ".$employee_table." as e ON e.id = es.emp_id WHERE e.active = 1 AND e.id= ".$emp_id." ) as tot WHERE ( tot.sal_status ='advance' OR tot.sal_status = 'fresh' ) ORDER BY tot.sal_update_date DESC ";

	$adv_pay_data = $wpdb->get_results( $adv_paid_query );

//var_dump($adv_pay_data);

	if(count($adv_pay_data) == 1) {

		$data['adv_last_paid_amount'] = 0.00;
		$data['adv_last_paid_date'] = $adv_pay_data[0]->sal_update_date;

		if($pay_data[0]->active != 0 ) {
			$data['adv_last_paid_amount'] = $adv_pay_data[0]->amount;
		}

	} else {

		$data['adv_last_paid_amount'] = 0.00;
		foreach ($adv_pay_data as $a_key => $a_value) {

			$advdiff =  strtotime($a_value->sal_update_date) - strtotime($data['last_paid_date']);
			$advDiffDays = floor($advdiff / (60 * 60 * 24));

			$data['adv_last_paid_date'] = $a_value->emp_joining;

			if($a_value->active == 1 && $advDiffDays >= 0) {

				$data['adv'][$a_key]['adv_last_paid_amount'] = $a_value->amount;
				$data['adv'][$a_key]['adv_last_paid_date'] = $a_value->sal_update_date;

				$data['adv_last_paid_amount'] = $data['adv_last_paid_amount'] + $a_value->amount;

			}
		}
	}


	$datediff = strtotime($pay_date) - strtotime($data['last_paid_date']);


	$data['workingDaysFromLastPaid'] = floor($datediff / (60 * 60 * 24));
	$data['working_salary'] = $data['workingDaysFromLastPaid'] * $data['salary_per_day'];

	$data['success'] = 1;

	if(isset( $_POST['ajax'] ) && $_POST['ajax'] == 'ajax') {
		echo json_encode($data);
		die();
	} else {
		return $data;
	}


}
add_action( 'wp_ajax_get_salery_pay_details', 'get_salery_pay_details' );
add_action( 'wp_ajax_nopriv_get_salery_pay_details', 'get_salery_pay_details' );




function generateInvoice_aj() {
    $date = $_POST['bill_date'];
    $invoice_data = generateInvoice($date);
   	echo json_encode($invoice_data); 
    die();
}
add_action( 'wp_ajax_generateInvoice_aj', 'generateInvoice_aj' );
add_action( 'wp_ajax_nopriv_generateInvoice_aj', 'generateInvoice_aj' );



function generateInvoice($date) {
	global $wpdb;
	$table =  $wpdb->prefix.'sale';
	$year = date('Y', strtotime($date));
	$financial_year = getFinancialYear($date);
	$query  = "SELECT * FROM ${table} WHERE locked = 0 AND financial_year = ${financial_year} ORDER BY id DESC LIMIT 1";

	$inv_result = $wpdb->get_row($query);

	if( $inv_result = $wpdb->get_row($query) ) {
		$data['id'] 			= $inv_result->id;
		$data['invoice_id'] 	= $inv_result->invoice_id;
		$data['financial_year'] = $inv_result->financial_year;
	} else {
		$query_table = "SELECT invoice_id, financial_year FROM ${table} WHERE financial_year = ${financial_year} order by id DESC LIMIT 1";
		if($query_year = $wpdb->get_row($query_table)) {

			$final_yr_table = $query_year->financial_year;
			$inv_id = $query_year->invoice_id;

			if($financial_year == $final_yr_table) {
				$data['invoice_id'] = $inv_id + 1;
				$data['financial_year'] = $financial_year;
			} else {
				$data['invoice_id'] = '1';
				$data['financial_year'] = $financial_year;
			}
		} else {
			$data['invoice_id'] = '1';
			$data['financial_year'] = $financial_year;
		}

		$wpdb->insert($table, array('active' => 1, 'financial_year' =>$financial_year, 'invoice_id'=>$data['invoice_id'] ));
		$data['id'] = $wpdb->insert_id;
	}
	return $data;
}






function get_delivery_data($delivery_id = 0) {
	global $wpdb;
	$delivery_table =  $wpdb->prefix.'delivery';
	$delivery_detail_table =  $wpdb->prefix.'delivery_detail';
	$lot_table =  $wpdb->prefix.'lots';
	$sale_detail_table =  $wpdb->prefix.'sale_detail';

	$query  = "SELECT * FROM ${delivery_table} WHERE id = {$delivery_id} ORDER BY delivery_date DESC LIMIT 1";
	$delivery_data = $wpdb->get_row($query);
	$data['delivery_data'] = false;
	$data['delivery_detail'] = false;

	if($delivery_data) {
		$data['delivery_data'] = $delivery_data;
		$detail_query = "SELECT dd.id, dd.delivery_weight, dd.sale_detail_id, dd.lot_id, l.lot_number, sd.slab FROM ${delivery_detail_table} as dd JOIN ${lot_table} as l ON dd.lot_id = l.id JOIN ${sale_detail_table} as sd ON dd.sale_detail_id = sd.id WHERE dd.delivery_id = {$delivery_id} AND dd.active = 1 AND sd.active=1";
		$data['delivery_detail'] = $wpdb->get_results($detail_query);
	}
	return $data;
}

function get_return_data($return_id = 0) {
	global $wpdb;
	$return_table =  $wpdb->prefix.'return';
	$return_detail_table =  $wpdb->prefix.'return_detail';
	$lot_table =  $wpdb->prefix.'lots';
	$sale_detail_table =  $wpdb->prefix.'sale_detail';

	$query  = "SELECT * FROM ${return_table} WHERE id = {$return_id} ORDER BY return_date DESC LIMIT 1";
	$return_data = $wpdb->get_row($query);
	$data['return_data'] = false;
	$data['return_detail'] = false;

	if($return_data) {
		$data['return_data'] = $return_data;
		$detail_query = "SELECT rd.id, rd.return_weight, rd.sale_detail_id, rd.lot_id, l.lot_number, sd.slab FROM ${return_detail_table} as rd JOIN ${lot_table} as l ON rd.lot_id = l.id JOIN ${sale_detail_table} as sd ON rd.sale_detail_id = sd.id WHERE rd.return_id = {$return_id} AND rd.active = 1 AND sd.active=1";
		
		$data['return_detail'] = $wpdb->get_results($detail_query);
	}
	return $data;
}






function getFinancialYear( $current_date = '' ) {
	$month 	= date('m', strtotime($current_date));
	$year 	= date('Y', strtotime($current_date));
	if( $month >= 4 ) {
		$financial_year = $year;
	} else {
		$financial_year = ( $year - 1 );
	}
	return $financial_year;
}


function crypto_rand_secure($min, $max) {
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

function getToken($table =0) {	
	global $wpdb; 
    $token_exists = false;
    do{
    	$token = generateToken();
    	$token_exists = $wpdb->get_row("SELECT id from ${table} WHERE id = '${token}'");
    } while($token_exists);

    return $token;
}

function generateToken() {
	$month = date("m");
	$year = date("Y");
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < 7; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }
	$token = $month.$year.$token;
	return $token;
}

function man_to_machine_date($date = '') {
	$data = date("Y-m-d H:i:s", strtotime($date));
	return $data;
}
function machine_to_man_date($date = '') {
	$data = date("d-m-Y", strtotime($date));
	return $data;
}
function splitCurrency($price = 0.00) {
	$datas = explode( '.', $price );
	$data['rs'] = (isset($datas[0])) ? $datas[0] : 0;
	$data['ps'] = (isset($datas[1])) ? $datas[1] : 00;
	return $data;
}
function convert_number_to_words_full($number) {
    $n_substr = splitCurrency($number);
    $rs = $n_substr['rs'];
    $ps = $n_substr['ps'];
    $con = '';
    $ps_txt = '';
    $rs_txt = '';


    $rs_txt = convert_number_to_words($rs);

    if($ps && $ps != '00' ) {
      $con = ' and ';
      if(strlen($ps) < 2) {
      	$ps = $ps.'0';
      }
      $ps_txt = convert_number_to_words($ps).' Paisa';
    } 

    return $rs_txt . $con . $ps_txt .' Only';
}

function convert_number_to_words($num) {
	if (strlen($num) > 9) {
		return 'overflow';
	}
	$num = '000000000'.$num;

	$a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
	$b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

	preg_match('/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/', substr($num,-9), $numbers);

	$str = '';


	$first = ($a[intval($numbers[1])]) ? $a[intval($numbers[1])] : ($b[$numbers[1][0]].' '.$a[$numbers[1][1]]);
	$str .= ($numbers[1] != 0) ? ($second . 'crore ') : '';

	$second = ($a[intval($numbers[2])]) ? $a[intval($numbers[2])] : ($b[$numbers[2][0]].' '.$a[$numbers[2][1]]);
	$str .= ($numbers[2] != 0) ? ($second . 'lakh ') : '';

	$third = ($a[intval($numbers[3])]) ? $a[intval($numbers[3])] : ($b[$numbers[3][0]].' '.$a[$numbers[3][1]]);
	$str .= ($numbers[3] != 0) ? ($third . 'thousand ') : '';

	$fourth = ($a[intval($numbers[4])]) ? $a[intval($numbers[4])] : ($b[$numbers[4][0]].' '.$a[$numbers[4][1]]);
	$str .= ($numbers[4] != 0) ? ($fourth . 'hundred ') : '';

	$fifth = (($str != '') ? 'and ' : '');
	$fifth .= ($a[intval($numbers[5])]) ? $a[intval($numbers[5])] : ($b[$numbers[5][0]].' '.$a[$numbers[5][1]]);
	$str .= ($numbers[5] != 0) ? $fifth : '';


    return $str;

}

function gst_group_cgst($id = 0) {
	global $wpdb;
	$sale_table_detail 	= $wpdb->prefix. 'sale_detail';
	$sale_table       	= $wpdb->prefix. 'sale';

	$query = "SELECT sale_details.cgst_percentage,sale_details.igst_percentage, 
	 sum(sale_details.cgst_value) as sale_cgst,
	 sum(sale_details.igst_value) as sale_igst, 
	 sum(sale_details.sgst_value) sale_sgst, 
	 sum(sale_details.sale_value) as sale_total, 
	 sum(sale_details.sale_weight) as sale_unit,
	sum(sale_details.taxless_amt) as sale_amt FROM ${sale_table} as sale 
	left join ${sale_table_detail} as sale_details on sale.`id`= sale_details.sale_id WHERE sale.active = 1 and sale_details.active = 1 and sale.id = ${id} group by sale_details.cgst_percentage";
	
	$data['gst_data'] 		= $wpdb->get_results($query);
	
	return $data;

}

function gst_group_igst($id = 0) {
	global $wpdb;
	$sale_table_detail 	= $wpdb->prefix. 'sale_detail';
	$sale_table       	= $wpdb->prefix. 'sale';


	$query_igst ="SELECT sale_details.igst_percentage, 
	 sum(sale_details.igst_value) as sale_igst, 
	 sum(sale_details.sale_value) as sale_total, 
	 sum(sale_details.sale_weight) as sale_unit,
	sum(sale_details.taxless_amt) as sale_amt FROM ${sale_table} as sale 
	left join ${sale_table_detail} as sale_details on sale.`id`= sale_details.sale_id WHERE sale.active = 1 and sale_details.active = 1 and sale.id = ${id} group by sale_details.igst_percentage";

	$data['gst_data']	= $wpdb->get_results($query_igst);
	return $data;

}

function kgToBagConversion($kg = 0,$bag_weight = 0){
	if($kg >= $bag_weight){
		$divide = $kg/$bag_weight;
		return $divide;
	} else{
		return false;
	}
}



function check_unique_lot() {
	global $wpdb;
	$lot_number 		= $_POST['lot_number'];
	$dummy_lot_number 	= $_POST['dummy_lot_number'];
	$lots_table 		= $wpdb->prefix. 'lots';
	$query 				= "SELECT * FROM {$lots_table} WHERE ( lot_number = '".$lot_number."' OR lot_number = '".$dummy_lot_number."' ) AND active = 1";
	$result_exist 		= $wpdb->get_row( $query );
	if($result_exist) {
    	$data = 1;
    } else {
    	$data = 0;
    }
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_check_unique_lot', 'check_unique_lot' );
add_action( 'wp_ajax_nopriv_check_unique_lot', 'check_unique_lot' );




function checkBillBalance($bill_id = 0) {

	global $wpdb;

	$query = "SELECT 

	( CASE WHEN (s.sale_total) IS NULL THEN 0.00 ELSE SUM(s.sale_total) END ) as sale_total,
	( CASE WHEN (payment.total_paid) IS NULL THEN 0.00 ELSE SUM(payment.total_paid) END ) as total_paid,
	( CASE WHEN (ret.return_total) IS NULL THEN 0.00 ELSE SUM(ret.return_total) END ) as return_total,
	( CASE WHEN (s.pay_to_bal) IS NULL THEN 0.00 ELSE SUM(s.pay_to_bal) END ) as pay_to_bal,
	( CASE WHEN (ret.return_to_pay) IS NULL THEN 0.00 ELSE SUM(ret.return_to_pay) END ) as return_to_pay,
	( ( CASE WHEN (s.sale_total) IS NULL THEN 0.00 ELSE SUM(s.sale_total) END ) - ( CASE WHEN (ret.return_total) IS NULL THEN 0.00 ELSE SUM(ret.return_total) END ) ) as actual_sale,
	( ( CASE WHEN (payment.total_paid) IS NULL THEN 0.00 ELSE SUM(payment.total_paid) END ) - ( ( CASE WHEN (s.pay_to_bal) IS NULL THEN 0.00 ELSE SUM(s.pay_to_bal) END ) + ( CASE WHEN (ret.return_to_pay) IS NULL THEN 0.00 ELSE SUM(ret.return_to_pay) END )) ) as actual_paid
	FROM wp_sale as s 

	LEFT JOIN 
	( 
		SELECT  
	  	( CASE WHEN (p.amount) IS NULL THEN 0.00 ELSE SUM(p.amount) END ) as total_paid,
	  	p.sale_id as payment_sale_id
	  	FROM wp_payment as p WHERE p.payment_type != 'credit' AND p.active = 1 AND p.sale_id = $bill_id
	) as payment
	ON s.id = payment.payment_sale_id
	LEFT JOIN 
	(
	  	SELECT 
	  	( CASE WHEN SUM(r.total_amount) IS NULL THEN 0.00 ELSE SUM(r.total_amount) END ) as return_total, 
	  	( CASE WHEN SUM(r.key_amount) IS NULL THEN 0.00 ELSE SUM(r.key_amount) END ) as return_to_pay,
	  	r.sale_id as return_sale_id
	  	FROM wp_return as r WHERE r.active = 1 AND r.sale_id = $bill_id
	) as ret
	ON s.id = ret.return_sale_id WHERE s.id = $bill_id";


	$data = $wpdb->get_row($query);

	$balance = $data->actual_sale - $data->actual_paid;
	return $balance;

}

function getBillPaymentTotal($bill_id = 0) {

	global $wpdb;
	$query = "SELECT  
	  	( CASE WHEN (p.amount) IS NULL THEN 0.00 ELSE SUM(p.amount) END ) as total_paid
	  	FROM wp_payment as p WHERE p.payment_type != 'credit' AND p.active = 1 AND p.sale_id = $bill_id";
	$data = $wpdb->get_row($query);
	return $data->total_paid;
}






function checkCustomerBalance($customer_id = 0, $condition = 'full', $current_screen = 'full', $ref_id = 0) {

	if( $condition == 'full' ) {
		$cond = '';
	}
	if( $condition == 'due' ) {
		$cond = 'AND full_table.customer_pending > 0';
	}
	if( $condition == 'balance' ) {
		$cond = 'AND full_table.customer_pending < 0';
	}



	$query = "SELECT * FROM
	(
		SELECT 
		s.id,
	    s.customer_id,
	    s.invoice_id,
	    s.financial_year,

	    ( CASE WHEN (s.sale_total) IS NULL THEN 0.00 ELSE s.sale_total END ) as sale_total,
	    ( CASE WHEN (payment.total_paid) IS NULL THEN 0.00 ELSE payment.total_paid END ) as total_paid,
	    ( CASE WHEN (ret.return_total) IS NULL THEN 0.00 ELSE ret.return_total END ) as return_total,
		( CASE WHEN (s.pay_to_bal) IS NULL THEN 0.00 ELSE SUM(s.pay_to_bal) END ) as sale_to_pay,
	    ( CASE WHEN (ret.return_to_pay) IS NULL THEN 0.00 ELSE ret.return_to_pay END ) as return_to_pay,
		( ( CASE WHEN s.sale_total IS NULL THEN 0.00 ELSE s.sale_total END ) - ( CASE WHEN ret.return_total IS NULL THEN 0.00 ELSE ret.return_total END ) ) as actual_sale,
		( ( CASE WHEN payment.total_paid IS NULL THEN 0.00 ELSE payment.total_paid END ) - ( ( CASE WHEN s.pay_to_bal IS NULL THEN 0.00 ELSE s.pay_to_bal END ) + ( CASE WHEN ret.return_to_pay IS NULL THEN 0.00 ELSE ret.return_to_pay END )) ) as actual_paid,
	    (
	    	( ( CASE WHEN s.sale_total IS NULL THEN 0.00 ELSE s.sale_total END ) - ( CASE WHEN ret.return_total IS NULL THEN 0.00 ELSE ret.return_total END ) )
	        -
	        ( ( CASE WHEN payment.total_paid IS NULL THEN 0.00 ELSE payment.total_paid END ) - ( ( CASE WHEN s.pay_to_bal IS NULL THEN 0.00 ELSE s.pay_to_bal END ) + ( CASE WHEN ret.return_to_pay IS NULL THEN 0.00 ELSE ret.return_to_pay END )) )
	    ) as customer_pending,

	    ( CASE WHEN (screen.current_screen_paid) IS NULL THEN 0.00 ELSE SUM(screen.current_screen_paid) END ) as current_screen_paid
	    
	    FROM
		wp_sale as s 
	    
		LEFT JOIN 
		( 
			SELECT  
		  	( CASE WHEN (p.amount) IS NULL THEN 0.00 ELSE SUM(p.amount) END ) as total_paid,
		  	p.sale_id as payment_sale_id
		  	FROM wp_payment as p WHERE p.payment_type != 'credit' AND p.active = 1 AND p.customer_id = $customer_id GROUP BY p.sale_id
		) as payment
		ON s.id = payment.payment_sale_id

		LEFT JOIN 
		( 
			SELECT  
		  	( CASE WHEN (scr.amount) IS NULL THEN 0.00 ELSE SUM(scr.amount) END ) as current_screen_paid,
		  	scr.sale_id as screen_sale_id
		  	FROM wp_payment as scr WHERE scr.payment_type != 'credit' AND scr.reference_screen = '$current_screen'  AND reference_id = $ref_id AND scr.active = 1 AND scr.customer_id = $customer_id GROUP BY scr.sale_id
		) as screen
		ON s.id = screen.screen_sale_id


		LEFT JOIN 
		(
		  	SELECT 
		  	( CASE WHEN SUM(r.total_amount) IS NULL THEN 0.00 ELSE SUM(r.total_amount) END ) as return_total, 
		  	( CASE WHEN SUM(r.key_amount) IS NULL THEN 0.00 ELSE SUM(r.key_amount) END ) as return_to_pay,
		  	r.sale_id as return_sale_id
		  	FROM wp_return as r WHERE r.active = 1 AND r.customer_id = $customer_id GROUP BY r.sale_id
		) as ret
		ON s.id = ret.return_sale_id WHERE s.customer_id = $customer_id GROUP BY s.id
	) as full_table WHERE 1 = 1 $cond";


	global $wpdb;
	$data = $wpdb->get_results($query);


	return $data;
}



function checkCustomerBalanceAjax() {
	$customer_id = isset($_POST['id'] ) ? $_POST['id'] : '';
	$reference_id = isset($_POST['reference_id'] ) ? $_POST['reference_id'] : 0;
	$reference_screen = isset($_POST['reference_screen'] ) ? $_POST['reference_screen'] : 'full';


	$data = checkCustomerBalance($customer_id, 'due', $reference_screen, $reference_id);
	echo json_encode($data);
	die();
}

add_action( 'wp_ajax_checkCustomerBalanceAjax', 'checkCustomerBalanceAjax');
add_action( 'wp_ajax_nopriv_checkCustomerBalanceAjax', 'checkCustomerBalanceAjax');




function lessStock($lot_id = 0, $stock_count = 0) {
	global $wpdb;
	$lots_table = $wpdb->prefix. 'lots';
	$sql_update = "UPDATE $lots_table SET stock_balance = stock_balance - $stock_count  WHERE id = $lot_id";
	$wpdb->query($sql_update);
}
function addStock($lot_id = 0, $stock_count = 0) {
	global $wpdb;
	$lots_table = $wpdb->prefix. 'lots';
	$sql_update = "UPDATE $lots_table SET stock_balance = stock_balance + $stock_count  WHERE id = $lot_id";
	$wpdb->query($sql_update);
}
function lessSale($lot_id = 0, $sale_count = 0) {
	global $wpdb;
	$lots_table = $wpdb->prefix. 'lots';
	$sql_update = "UPDATE $lots_table SET sale_balance = sale_balance - $sale_count  WHERE id = $lot_id";
	$wpdb->query($sql_update);
}
function addSale($lot_id = 0, $sale_count = 0) {
	global $wpdb;
	$lots_table = $wpdb->prefix. 'lots';
	$sql_update = "UPDATE $lots_table SET sale_balance = sale_balance + $sale_count  WHERE id = $lot_id";
	$wpdb->query($sql_update);
}
function lessReturn($lot_id = 0, $return_count = 0) {
	global $wpdb;
	$lots_table = $wpdb->prefix. 'lots';
	$sql_update = "UPDATE $lots_table SET return_balance = return_balance - $return_count  WHERE id = $lot_id";
	$wpdb->query($sql_update);
}
function addReturn($lot_id = 0, $return_count = 0) {
	global $wpdb;
	$lots_table = $wpdb->prefix. 'lots';
	$sql_update = "UPDATE $lots_table SET return_balance = return_balance + $return_count  WHERE id = $lot_id";
	$wpdb->query($sql_update);
}


