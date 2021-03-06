<?php
function customer_list_pagination($args ) {

    global $wpdb;
    $table =  $wpdb->prefix.'customers';
    $payment_history_table = $wpdb->prefix.'payment_history';
    $sale_table = $wpdb->prefix.'sale';

    $customPagHTML      = "";


$query              =  "SELECT s.*,
( CASE
 WHEN (s1.actual_sale) IS NULL 
 THEN 0.00
 ELSE (s1.actual_sale)
END ) as sale_total,

( CASE
 WHEN (s1.actual_paid) IS NULL 
 THEN 0.00
 ELSE (s1.actual_paid)
END ) as paid_total,
(
 CASE
 WHEN (s1.customer_pending) IS NULL 
 THEN 0.00
 ELSE (s1.customer_pending)
END 
) as payment_due


FROM wp_customers s LEFT JOIN 
(
   SELECT 
        s.id,
        s.customer_id,
        ( CASE WHEN sum(s.sale_total) IS NULL THEN 0.00 ELSE sum(s.sale_total) END ) as sale_total,
        ( CASE WHEN (payment.total_paid) IS NULL THEN 0.00 ELSE payment.total_paid END ) as total_paid,
        ( CASE WHEN (ret.return_total) IS NULL THEN 0.00 ELSE ret.return_total END ) as return_total,
        ( CASE WHEN sum(s.pay_to_bal) IS NULL THEN 0.00 ELSE SUM(s.pay_to_bal) END ) as sale_to_pay,
        ( CASE WHEN (ret.return_to_pay) IS NULL THEN 0.00 ELSE ret.return_to_pay END ) as return_to_pay,
        ( ( CASE WHEN sum(s.sale_total) IS NULL THEN 0.00 ELSE sum(s.sale_total) END ) - ( CASE WHEN ret.return_total IS NULL THEN 0.00 ELSE ret.return_total END ) ) as actual_sale,
        ( ( CASE WHEN payment.total_paid IS NULL THEN 0.00 ELSE payment.total_paid END ) - ( ( CASE WHEN sum(s.pay_to_bal) IS NULL THEN 0.00 ELSE sum(s.pay_to_bal) END ) + ( CASE WHEN ret.return_to_pay IS NULL THEN 0.00 ELSE ret.return_to_pay END )) ) as actual_paid,
        (
            ( ( CASE WHEN sum(s.sale_total) IS NULL THEN 0.00 ELSE sum(s.sale_total) END ) - ( CASE WHEN ret.return_total IS NULL THEN 0.00 ELSE ret.return_total END ) )
            -
            ( ( CASE WHEN payment.total_paid IS NULL THEN 0.00 ELSE payment.total_paid END ) - ( ( CASE WHEN sum(s.pay_to_bal) IS NULL THEN 0.00 ELSE sum(s.pay_to_bal) END ) + ( CASE WHEN ret.return_to_pay IS NULL THEN 0.00 ELSE ret.return_to_pay END )) )
        ) as customer_pending 
        FROM
        wp_sale as s 
        LEFT JOIN 
        ( 
            SELECT 
            ( CASE WHEN (p.amount) IS NULL THEN 0.00 ELSE SUM(p.amount) END ) as total_paid,
            p.sale_id as payment_sale_id,p.customer_id
            FROM wp_payment as p WHERE p.payment_type != 'credit' AND p.active = 1 GROUP BY p.customer_id
        ) as payment
        ON s.customer_id = payment.customer_id
        LEFT JOIN 
        (
            SELECT 
            ( CASE WHEN SUM(r.total_amount) IS NULL THEN 0.00 ELSE SUM(r.total_amount) END ) as return_total, 
            ( CASE WHEN SUM(r.key_amount) IS NULL THEN 0.00 ELSE SUM(r.key_amount) END ) as return_to_pay,
            r.sale_id as return_sale_id,r.customer_id
            FROM wp_return as r WHERE r.active = 1 GROUP BY r.customer_id
        ) as ret
        ON s.customer_id = ret.customer_id  GROUP BY s.customer_id
) as s1 ON s.id = s1.customer_id WHERE active = 1  ${args['condition']}";

    //$query              = "SELECT * FROM ${table} WHERE active = 1 ${args['condition']}";
    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']     = $wpdb->get_results( $query . " ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );
// echo "<pre>";
// var_dump( $query . " ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']} ");
    $totalPage          = ceil($total / $args['items_per_page']);
    
    /*Updated for filter 11/10/16*/

    if(isset($_POST['action']) && $_POST['action'] == 'customer_list_filter') {
        $ppage = $_POST['per_page'];
        $customer_name = $_POST['customer_name'];
        $customer_mobile_list = $_POST['customer_mobile_list'];
        $customer_type = $_POST['customer_type'];
        $payment_status = $_POST['payment_status'];
    } else {
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $customer_name = isset( $_GET['customer_name'] ) ? $_GET['customer_name']  : '';
        $customer_mobile_list = isset( $_GET['customer_mobile_list'] ) ? $_GET['customer_mobile_list']  : '';
        $customer_type = isset( $_GET['customer_type'] ) ? $_GET['customer_type']  : '';
        $payment_status = isset( $_GET['payment_status'] ) ? $_GET['payment_status']  : '';
    }

    $page_arg = [];
    if($customer_name != '') {
        $page_arg['customer_name'] = $customer_name;
    }
    if($customer_mobile != '') {
        $page_arg['customer_mobile_list'] = $customer_mobile_list;
    }
    if($customer_type != '-') {
        $page_arg['customer_type'] = $customer_type;
    }
    if($payment_status != '-') {
        $page_arg['payment_status'] = $payment_status;
    }
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];
    /*End Updated for filter 11/10/16*/
    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=customer')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}

function purchase_list_pagination($args ) {

    global $wpdb;
    $table =  $wpdb->prefix.'purshase';
    $customPagHTML      = "";

    $query              = "SELECT * FROM ${table} WHERE status= 1 ${args['condition']}";
    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;
  $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}";
    $data['result'] = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);

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

    $page_arg = [];
    if($from != '') {
        $page_arg['from'] = $from;
    }
    if($to != '') {
        $page_arg['to'] = $to;
    }
   
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];

    /*End Updated for filter 11/10/16*/


    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));
        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=purchase_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}

function employee_list_pagination($args ) {

    global $wpdb;
    $table =  $wpdb->prefix.'employees';
    $customPagHTML      = "";
    $query              = "SELECT * FROM ( SELECT *, CONCAT('EMP', id) as employee_id FROM ${table} ) as e  WHERE e.active = 1 ${args['condition']}";
    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']         = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);

    /*Updated for filter 11/10/16*/

    if(isset($_POST['action']) && $_POST['action'] == 'employee_list_filter') {
        $ppage = $_POST['per_page'];
        $emp_no = $_POST['emp_no'];
        $emp_name = $_POST['emp_name'];
        $emp_mobile = $_POST['emp_mobile'];
        $emp_salary = $_POST['emp_salary'];
        $join_from = $_POST['join_from'];
        $join_to = $_POST['join_to'];
        $emp_status = $_POST['emp_status'];
    } else {
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $emp_no = isset( $_GET['emp_no'] ) ? $_GET['emp_no']  : '';
        $emp_name = isset( $_GET['emp_name'] ) ? $_GET['emp_name']  : '';
        $emp_mobile = isset( $_GET['emp_mobile'] ) ? $_GET['emp_mobile']  : '';
        $emp_salary = isset( $_GET['emp_salary'] ) ? $_GET['emp_salary']  : '';
        $join_from = isset( $_GET['join_from'] ) ? $_GET['join_from']  : '';
        $join_to = $_POST['join_to'];
        $emp_status = $_POST['emp_status'];
    }

    $page_arg = [];
    if($emp_no != '') {
        $page_arg['emp_no'] = $emp_no;
    }
    if($emp_name != '') {
        $page_arg['emp_name'] = $emp_name;
    }
    if($emp_mobile != '') {
        $page_arg['emp_mobile'] = $emp_mobile;
    }
    if($emp_salary != '') {
        $page_arg['emp_salary'] = $emp_salary;
    }
    if($join_from != '') {
        $page_arg['join_from'] = $join_from;
    }
    if($join_to != '') {
        $page_arg['join_to'] = $join_to;
    }

    if($emp_status != '-') {
        $page_arg['customer_type'] = $emp_status;
    }
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];

    /*End Updated for filter 11/10/16*/


    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));
        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=employee_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}


function employee_attendance_list_pagination($args ) {

    global $wpdb;
    $table =  $wpdb->prefix.'employees';
    $attendance_table = $wpdb->prefix.'employee_attendance';
    $customPagHTML      = "";
    $attendance_date = $args['attendance_date'];

    $query = " SELECT ff.* from ( SELECT f.*, (CASE WHEN f.attendance_today IS Null THEN 0 ELSE f.attendance_today END) as att from ( SELECT e.*, CONCAT('EMP', id) as employee_id, (SELECT ea.emp_attendance FROM ${attendance_table} ea WHERE ea.emp_id = e.id AND DATE(ea.attendance_date) = '${attendance_date}' AND active = 1 LIMIT 1 ) AS attendance_today FROM ${table} AS e WHERE DATE(e.emp_joining) <= '${attendance_date}' ) as f ) as ff WHERE ff.active = 1 ${args['condition']}";

    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";


    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']         = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);


    /*Updated for filter 11/10/16*/

    if(isset($_POST['action']) && $_POST['action'] == 'attendance_list_filter') {
        $ppage = $_POST['per_page'];
        $emp_no = $_POST['emp_no'];
        $emp_name = $_POST['emp_name'];
        $attendance_date = ($_POST['attendance_date'] != '') ? $_POST['attendance_date'] : date("Y-m-d", time());
        $attendance_status = $_POST['attendance_status'];
    } else {
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $emp_no = isset( $_GET['emp_no'] ) ? $_GET['emp_no']  : '';
        $emp_name = isset( $_GET['emp_name'] ) ? $_GET['emp_name']  : '';
        $attendance_date = isset( $_GET['attendance_date'] ) ? $_GET['attendance_date']  : date("Y-m-d", time());
        $attendance_status = isset( $_GET['attendance_status'] ) ? $_GET['attendance_status']  : '-';
    }

    $page_arg = [];
    if($emp_no != '') {
        $page_arg['emp_no'] = $emp_no;
    }
    if($emp_name != '') {
        $page_arg['emp_name'] = $emp_name;
    }
    if($emp_mobile != '') {
        $page_arg['attendance_date'] = $attendance_date;
    }
    if($emp_status != '-') {
        $page_arg['attendance_status'] = $attendance_status;
    }
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];

    /*End Updated for filter 11/10/16*/


    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));
        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=attendance_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}


function lot_list_pagination( $args ) {

    global $wpdb;
    $table =  $wpdb->prefix.'lots';
    $customPagHTML      = "";
    $query              = "SELECT * FROM ${table} WHERE active = 1 ${args['condition']}";
    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']         = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);



    /*Updated for filter 11/10/16*/

    if(isset($_POST['action']) && $_POST['action'] == 'lot_list_filter') {
        $ppage = $_POST['per_page'];
        $lot_number = $_POST['lot_number'];
        $search_brand = $_POST['search_brand'];
        $search_product = $_POST['search_product'];
    } else {
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
        $search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
        $search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
    }

    $page_arg = [];
    if($lot_number != '') {
        $page_arg['lot_number'] = $lot_number;
    }
    if($search_brand != '') {
        $page_arg['search_brand'] = $search_brand;
    }
    if($search_product != '') {
        $page_arg['search_product'] = $search_product;
    }
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];

    /*End Updated for filter 11/10/16*/

    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=stock')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}

function ptype_list_pagination( $args ) {

    global $wpdb;
    $table =  $wpdb->prefix.'product_type';
    $customPagHTML      = "";
    $query              = "SELECT * FROM ${table} WHERE active = 1 ${args['condition']}";
    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;
//echo  $query . " ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}";
    $data['result']         = $wpdb->get_results( $query . " ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);



      if(isset($_POST['action']) && $_POST['action'] == 'ptype_list_filter') {
        $ppage = $_POST['per_page'];
        $search_product = $_POST['search_product'];
    } else {
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
    }

    $page_arg = [];
   
    if($search_product != '') {
        $page_arg['search_product'] = $search_product;
    }
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];

  

    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=ptype_add_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}

function stock_list_pagination( $args ) {

    global $wpdb;
    $table =  $wpdb->prefix.'stock';
    $lot_table =  $wpdb->prefix.'lots';
    $customPagHTML      = "";
    $query              = "SELECT s.*, l.lot_number, l.brand_name, l.product_name FROM ${table} as s JOIN ${lot_table} as l ON s.lot_id = l.id  WHERE s.active = 1 AND l.active = 1 AND l.lot_type = 'original' ${args['condition']}";

    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']         = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);

    /*Updated for filter 11/10/16*/

    if(isset($_POST['action']) && $_POST['action'] == 'stock_list_filter') {
        $ppage = $_POST['per_page'];
        $lot_number = $_POST['lot_number'];
        $search_brand = $_POST['search_brand'];
        $search_product = $_POST['search_product'];
        $search_from = $_POST['search_from'];
        $search_to = $_POST['search_to'];
    } else {
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
        $search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
        $search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
        $search_from = isset( $_GET['search_from'] ) ? $_GET['search_from']  : '';
        $search_to = isset( $_GET['search_to'] ) ? $_GET['search_to']  : '';        
    }

    $page_arg = [];
    if($lot_number != '') {
        $page_arg['lot_number'] = $lot_number;
    }
    if($search_brand != '') {
        $page_arg['search_brand'] = $search_brand;
    }
    if($search_product != '') {
        $page_arg['search_product'] = $search_product;
    }
    if($search_from != '') {
        $page_arg['search_from'] = $search_from;
    }
    if($search_to != '') {
        $page_arg['search_to'] = $search_to;
    }
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];

    /*End Updated for filter 11/10/16*/


    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg, admin_url('admin.php?page=list_stocks')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}





function billing_list_pagination( $args ) {

    global $wpdb;
    $sale_table =  $wpdb->prefix.'sale';
    $customers_table =  $wpdb->prefix.'customers';
    $customPagHTML      = "";
    $query = "SELECT s.*, c.name, c.type, c.mobile FROM ${sale_table} as s LEFT JOIN ${customers_table} as c ON s.customer_id = c.id WHERE s.active = 1 ${args['condition']}";
    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";

    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']         = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);


    /*Updated for filter 11/10/16*/

    if(isset($_POST['action']) && $_POST['action'] == 'bill_list_filter') {
        $ppage = $_POST['per_page'];
        $invoice_no = $_POST['invoice_no'];
        $customer_name = $_POST['customer_name'];
        $bill_total = $_POST['bill_total'];
        
        $customer_type = $_POST['customer_type'];
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
        $delivery = isset( $_GET['delivery'] ) ? $_GET['delivery']  : '-';
        $payment_done = isset( $_GET['payment_done'] ) ? $_GET['payment_done']  : '-';

        $date_from = isset( $_GET['date_from'] ) ? $_GET['date_from']  : '';
        $date_to = isset( $_GET['date_to'] ) ? $_GET['date_to']  : '';
    }

    $page_arg = [];
    if($invoice_no != '') {
        $page_arg['invoice_no'] = $invoice_no;
    }
    if($customer_name != '') {
        $page_arg['customer_name'] = $customer_name;
    }
    if($bill_total != '') {
        $page_arg['bill_total'] = $bill_total;
    }
    if($customer_type != '-') {
        $page_arg['customer_type'] = $customer_type;
    }
    if($delivery != '-') {
        $page_arg['delivery'] = $delivery;
    }
    if($payment_done != '-') {
        $page_arg['payment_done'] = $payment_done;
    }
    if($date_from != '') {
        $page_arg['date_from'] = $date_from;
    }
    if($date_to != '') {
        $page_arg['date_to'] = $date_to;
    }    
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];



    /*End Updated for filter 11/10/16*/


    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=sales_others')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}



function billing_list_pagination_updated( $args ) {

    global $wpdb;
    $sale_table =  $wpdb->prefix.'sale';
    $sale_detail = $wpdb->prefix.'sale_detail';
    $customers_table =  $wpdb->prefix.'customers';
    $payment = $wpdb->prefix.'payment';
    $return = $wpdb->prefix.'return';
    $customPagHTML      = "";


$query = "SELECT full_table.*,
(case when return_tab.return_amount is null then 0 else return_tab.return_amount end) as return_amount
from ( SELECT bill.*, 
(case when payment.cash_amount is null then '-' else payment.cash_amount-bill.pay_to_bal end) as cash_amount,
(case when payment.card_amount is null then '-' else payment.card_amount end) as card_amount,
(case when payment.cheque_amount is null then '-' else payment.cheque_amount end) as cheque_amount,
(case when payment.net_banking_amount is null then '-' else payment.net_banking_amount end) as net_banking_amount
from (SELECT s1.*, 
((CASE WHEN s2.paid_total IS NULL THEN 0.00 ELSE s2.paid_total END) - s1.pay_to_bal) as paid_total, 
( s1.sale_total - (CASE WHEN s2.paid_total IS NULL THEN 0.00 ELSE s2.paid_total END ) ) as to_be_paid
FROM 
( 
    SELECT s.*, c.name, c.type, c.mobile FROM (
        SELECT s_in.*,
        (case when sale_details.margin_rate is null then 0 else sale_details.margin_rate end) as margin_rate 
        from 
        {$sale_table} as s_in 
        left join 
        (
            SELECT sale_id,
            sum(case when unit_price = margin_price then 1 else 0 end) as margin_rate
            from 
            {$sale_detail} 
            WHERE active = 1 GROUP by sale_id
        ) as 
        sale_details 
        on s_in.id = sale_details.sale_id 
    )  as s   
    LEFT JOIN 
    wp_customers as c 
    ON s.customer_id = c.id 
) as s1 
LEFT JOIN 
(
    
    SELECT s.id as sale_id, s.customer_id, s.sale_total, ph.paid_total FROM {$sale_table} as s 
    JOIN ( 
        SELECT p.sale_id, SUM(p.amount) as paid_total FROM {$payment} as p WHERE p.active = 1 GROUP BY p.sale_id 
    ) as ph 
    ON s.id = ph.sale_id WHERE s.active = 1
) as s2 
ON s1.id = s2.sale_id 
WHERE s1.active = 1 AND s1.locked = 1 )  as bill left join 
(
SELECT sale_id,
sum(case when payment_type = 'cash' then amount else '-' end) as cash_amount,
sum(case when payment_type = 'card' then amount else '-' end) as card_amount,
sum(case when payment_type = 'cheque' then amount else '-' end) as cheque_amount,
sum(case when payment_type = 'net_banking' then amount else '-' end) as net_banking_amount
FROM ${payment} WHERE active=1 GROUP by sale_id
 ) as payment on bill.id = payment.sale_id ) as full_table 
 left join 
 (
 SELECT sum(key_amount) as return_amount,sale_id 
from ${return} GROUP by sale_id
) as 
return_tab 
on return_tab.sale_id = full_table.id where full_table.active = 1  ${args['condition']}";
// echo "<pre>";
// var_dump($query);
//Sale table
    $total_amount       = "SELECT sum(cash_amount) as cash_amount,sum(card_amount) as card_amount,sum(cheque_amount) as cheque_amount,sum(net_banking_amount) as net_banking_amount,sum(sale_total) as sale_total FROM (${query})  AS combined_table";
    $data['s_result']   = $wpdb->get_row( $total_amount );

    //Return Table
     $total_return      = "SELECT sum(return_amount) as return_amount FROM (${query})  AS combined_table";
    $data['r_result']   = $wpdb->get_row( $total_return );

    //Total Margin price 
    $margin_query       = "SELECT sale_id,unit_price,margin_price,sum(case when unit_price = margin_price then 1 else 0 end ) as margin_rate FROM ${sale_table} GROUP by sale_id";
    $data['m_result']   = $wpdb->get_row($margin_query);


    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";

    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']     = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);


    /*Updated for filter 11/10/16*/

    if(isset($_POST['action']) && $_POST['action'] == 'bill_list_filter') {
        $ppage = $_POST['per_page'];
        $invoice_no = $_POST['invoice_no'];
        $customer_name = $_POST['customer_name'];
        $bill_total = $_POST['bill_total'];
        
        $customer_type = $_POST['customer_type'];
        //$shop = $_POST['shop'];
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
        //$shop = isset( $_GET['shop'] ) ? $_GET['shop']  : '-';
        $delivery = isset( $_GET['delivery'] ) ? $_GET['delivery']  : '-';
        $payment_done = isset( $_GET['payment_done'] ) ? $_GET['payment_done']  : '-';

        $date_from = isset( $_GET['date_from'] ) ? $_GET['date_from']  : '';
        $date_to = isset( $_GET['date_to'] ) ? $_GET['date_to']  : '';
    }

    $page_arg = [];
    if($invoice_no != '') {
        $page_arg['invoice_no'] = $invoice_no;
    }
    if($customer_name != '') {
        $page_arg['customer_name'] = $customer_name;
    }
    if($bill_total != '') {
        $page_arg['bill_total'] = $bill_total;
    }
    if($customer_type != '-') {
        $page_arg['customer_type'] = $customer_type;
    }
    // if($shop != '-') {
    //     $page_arg['shop'] = $shop;
    // }
    if($delivery != '-') {
        $page_arg['delivery'] = $delivery;
    }
    if($payment_done != '-') {
        $page_arg['payment_done'] = $payment_done;
    }
    if($date_from != '') {
        $page_arg['date_from'] = $date_from;
    }
    if($date_to != '') {
        $page_arg['date_to'] = $date_to;
    }    
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];



    /*End Updated for filter 11/10/16*/


    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=sales_others')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }
    
    $data['pagination'] = $customPagHTML;
    return $data;
}


function billing_list_pagination_updated_cancel( $args ) {

    global $wpdb;
    $sale_table =  $wpdb->prefix.'sale';
    $sale_detail = $wpdb->prefix.'sale_detail';
    $customers_table =  $wpdb->prefix.'customers';
    $payment = $wpdb->prefix.'payment';
    $return = $wpdb->prefix.'return';
    $customPagHTML      = "";


$query = "SELECT full_table.*,
(case when return_tab.return_amount is null then 0 else return_tab.return_amount end) as return_amount
from ( SELECT bill.*, 
(case when payment.cash_amount is null then '-' else payment.cash_amount-bill.pay_to_bal end) as cash_amount,
(case when payment.card_amount is null then '-' else payment.card_amount end) as card_amount,
(case when payment.cheque_amount is null then '-' else payment.cheque_amount end) as cheque_amount,
(case when payment.net_banking_amount is null then '-' else payment.net_banking_amount end) as net_banking_amount
from (SELECT s1.*, 
((CASE WHEN s2.paid_total IS NULL THEN 0.00 ELSE s2.paid_total END) - s1.pay_to_bal) as paid_total, 
( s1.sale_total - (CASE WHEN s2.paid_total IS NULL THEN 0.00 ELSE s2.paid_total END ) ) as to_be_paid
FROM 
( 
    SELECT s.*, c.name, c.type, c.mobile FROM (
        SELECT s_in.*,
        (case when sale_details.margin_rate is null then 0 else sale_details.margin_rate end) as margin_rate 
        from 
        {$sale_table} as s_in 
        left join 
        (
            SELECT sale_id,
            sum(case when unit_price = margin_price then 1 else 0 end) as margin_rate
            from 
            {$sale_detail} 
            WHERE active = 0 GROUP by sale_id
        ) as 
        sale_details 
        on s_in.id = sale_details.sale_id 
    )  as s   
    LEFT JOIN 
    wp_customers as c 
    ON s.customer_id = c.id 
) as s1 
LEFT JOIN 
(
    
    SELECT s.id as sale_id, s.customer_id, s.sale_total, ph.paid_total FROM {$sale_table} as s 
    JOIN ( 
        SELECT p.sale_id, SUM(p.amount) as paid_total FROM {$payment} as p WHERE p.active = 0 GROUP BY p.sale_id 
    ) as ph 
    ON s.id = ph.sale_id WHERE s.active = 0
) as s2 
ON s1.id = s2.sale_id 
WHERE s1.active = 0 )  as bill left join 
(
SELECT sale_id,
sum(case when payment_type = 'cash' then amount else '-' end) as cash_amount,
sum(case when payment_type = 'card' then amount else '-' end) as card_amount,
sum(case when payment_type = 'cheque' then amount else '-' end) as cheque_amount,
sum(case when payment_type = 'net_banking' then amount else '-' end) as net_banking_amount
FROM ${payment} WHERE active=0 GROUP by sale_id
 ) as payment on bill.id = payment.sale_id ) as full_table 
 left join 
 (
 SELECT sum(key_amount) as return_amount,sale_id 
from ${return} GROUP by sale_id
) as 
return_tab 
on return_tab.sale_id = full_table.id where full_table.active = 0  ${args['condition']}";
// echo "<pre>";
// var_dump($query);
//Sale table
    $total_amount       = "SELECT sum(cash_amount) as cash_amount,sum(card_amount) as card_amount,sum(cheque_amount) as cheque_amount,sum(net_banking_amount) as net_banking_amount,sum(sale_total) as sale_total FROM (${query})  AS combined_table";
    $data['s_result']   = $wpdb->get_row( $total_amount );

    //Return Table
     $total_return      = "SELECT sum(return_amount) as return_amount FROM (${query})  AS combined_table";
    $data['r_result']   = $wpdb->get_row( $total_return );

    //Total Margin price 
    $margin_query       = "SELECT sale_id,unit_price,margin_price,sum(case when unit_price = margin_price then 1 else 0 end ) as margin_rate FROM ${sale_table} GROUP by sale_id";
    $data['m_result']   = $wpdb->get_row($margin_query);


    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";

    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']     = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);


    /*Updated for filter 11/10/16*/

    if(isset($_POST['action']) && $_POST['action'] == 'cancel_bill_list_filter') {
        $ppage = $_POST['per_page'];
        $invoice_no = $_POST['invoice_no'];
        $customer_name = $_POST['customer_name'];
        $bill_total = $_POST['bill_total'];
        
        $customer_type = $_POST['customer_type'];
        //$shop = $_POST['shop'];
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
        //$shop = isset( $_GET['shop'] ) ? $_GET['shop']  : '-';
        $delivery = isset( $_GET['delivery'] ) ? $_GET['delivery']  : '-';
        $payment_done = isset( $_GET['payment_done'] ) ? $_GET['payment_done']  : '-';

        $date_from = isset( $_GET['date_from'] ) ? $_GET['date_from']  : '';
        $date_to = isset( $_GET['date_to'] ) ? $_GET['date_to']  : '';
    }

    $page_arg = [];
    if($invoice_no != '') {
        $page_arg['invoice_no'] = $invoice_no;
    }
    if($customer_name != '') {
        $page_arg['customer_name'] = $customer_name;
    }
    if($bill_total != '') {
        $page_arg['bill_total'] = $bill_total;
    }
    if($customer_type != '-') {
        $page_arg['customer_type'] = $customer_type;
    }
    // if($shop != '-') {
    //     $page_arg['shop'] = $shop;
    // }
    if($delivery != '-') {
        $page_arg['delivery'] = $delivery;
    }
    if($payment_done != '-') {
        $page_arg['payment_done'] = $payment_done;
    }
    if($date_from != '') {
        $page_arg['date_from'] = $date_from;
    }
    if($date_to != '') {
        $page_arg['date_to'] = $date_to;
    }    
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];



    /*End Updated for filter 11/10/16*/


    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=cancel_billing_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }
    
    $data['pagination'] = $customPagHTML;
    return $data;
}




function delivery_list_pagination( $args ) {

    global $wpdb;
    $sale_table =  $wpdb->prefix.'sale';
    $customers_table =  $wpdb->prefix.'customers';
    $delivery_table = $wpdb->prefix.'delivery';
    $customPagHTML      = "";


    $query = "SELECT d.id as delivery_id, d.delivery_date, s.id as sale_id, s.invoice_id, s.financial_year, s.customer_id, c.name as customer_name,c.mobile, s.order_shop, s.bill_from_to, s.customer_type FROM ${delivery_table} as d JOIN ${sale_table} as s ON d.sale_id = s.id LEFT JOIN ${customers_table} as c ON s.customer_id = c.id where d.active=1 ${args['condition']}";


    //$query = "SELECT s.*, c.name, c.type, c.mobile FROM ${sale_table} as s LEFT JOIN ${customers_table} as c ON s.customer_id = c.id WHERE s.active = 1 ${args['condition']}";
    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";

    $total              = $wpdb->get_var( $total_query );

    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']     = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);

    /*Updated for filter 11/10/16*/

    if(isset($_POST['action']) && $_POST['action'] == 'delivery_list_filter') {
        $ppage          = $_POST['per_page'];
        $invoice_no     = $_POST['invoice_no'];
        $customer_name  = $_POST['customer_name'];
        
        $customer_type  = $_POST['customer_type'];

        $delivery_from  = $_POST['delivery_from'];
        $delivery_to    = $_POST['delivery_to'];
    } else {
        $ppage          = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $invoice_no     = isset( $_GET['invoice_no'] ) ? $_GET['invoice_no']  : '';
        $customer_name  = isset( $_GET['customer_name'] ) ? $_GET['customer_name']  : '';

        $customer_type  = isset( $_GET['customer_type'] ) ? $_GET['customer_type']  : '-';

        $delivery_from  = isset( $_GET['delivery_from'] ) ? $_GET['delivery_from']  : '';
        $delivery_to    = isset( $_GET['delivery_to'] ) ? $_GET['delivery_to']  : '';
    }

    $page_arg = [];
    if($invoice_no != '') {
        $page_arg['invoice_no'] = $invoice_no;
    }
    if($customer_name != '') {
        $page_arg['customer_name'] = $customer_name;
    }
   
    if($customer_type != '-') {
        $page_arg['customer_type'] = $customer_type;
    }

    if($delivery_from != '') {
        $page_arg['delivery_from'] = $delivery_from;
    }
    if($delivery_to != '') {
        $page_arg['delivery_to'] = $delivery_to;
    }    
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];



    /*End Updated for filter 11/10/16*/


    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=delivery_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}




function return_list_pagination( $args ) {

    global $wpdb;
    $sale_table =  $wpdb->prefix.'sale';
    $customers_table =  $wpdb->prefix.'customers';
    $return_table = $wpdb->prefix.'return';
    $customPagHTML      = "";


    $query = "SELECT r.id as return_id, r.return_date, s.id as sale_id, s.invoice_id, s.financial_year, s.customer_id, c.name as customer_name,c.mobile as mobile, s.order_shop, s.bill_from_to, s.customer_type FROM ${return_table} as r JOIN ${sale_table} as s ON r.sale_id = s.id LEFT JOIN ${customers_table} as c ON s.customer_id = c.id WHERE r.active=1 ${args['condition']}";

    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";

    $total              = $wpdb->get_var( $total_query );

    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']     = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );
    $totalPage         = ceil($total / $args['items_per_page']);


    /*Updated for filter 11/10/16*/

    if(isset($_POST['action']) && $_POST['action'] == 'return_list_filter') {
        $ppage = $_POST['per_page'];
        $invoice_no = $_POST['invoice_no'];
        $customer_name = $_POST['customer_name'];
        $customer_type = $_POST['customer_type'];
        $return_from = $_POST['return_from'];
        $return_to = $_POST['return_to'];
    } else {
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $invoice_no = isset( $_GET['invoice_no'] ) ? $_GET['invoice_no']  : '';
        $customer_name = isset( $_GET['customer_name'] ) ? $_GET['customer_name']  : '';
        $customer_type = isset( $_GET['customer_type'] ) ? $_GET['customer_type']  : '-';
        $return_from = isset( $_GET['return_from'] ) ? $_GET['return_from']  : '';
        $return_to = isset( $_GET['return_to'] ) ? $_GET['return_to']  : '';
    }

    $page_arg = [];
    if($invoice_no != '') {
        $page_arg['invoice_no'] = $invoice_no;
    }
    if($customer_name != '') {
        $page_arg['customer_name'] = $customer_name;
    }
    if($customer_type != '-') {
        $page_arg['customer_type'] = $customer_type;
    }
    if($return_from != '') {
        $page_arg['return_from'] = $date_from;
    }
    if($return_to != '') {
        $page_arg['return_to'] = $date_to;
    }    
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];



    /*End Updated for filter 11/10/16*/


    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=return_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}





function employee_salary_list_pagination( $args ) {

    global $wpdb;
    $employee_table =  $wpdb->prefix.'employees';
    $salary_table =  $wpdb->prefix.'employee_salary';
    $customPagHTML      = "";
    $query = "SELECT f.* from ( SELECT es.*, CONCAT('EMP', es.emp_id) as employee_no, e.emp_name, e.emp_mobile, e.emp_current_status from ${salary_table} es join (SELECT max(s1.id) as latest_sal FROM ${salary_table} s1 GROUP BY s1.emp_id) as l ON es.id = l.latest_sal 
    join ${employee_table} e on e.id = es.emp_id ) as f WHERE f.active = 1 ${args['condition']}";

    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";


    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']         = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );
    $totalPage         = ceil($total / $args['items_per_page']);


    /*Updated for filter 11/10/16*/
    if(isset($_POST['action']) && $_POST['action'] == 'salary_list_filter') {
        $ppage              = $_POST['per_page'];
        $emp_no             = $_POST['emp_no'];
        $emp_name           = $_POST['emp_name'];
        $emp_mobile         = $_POST['emp_mobile'];

        $employee_status    = $_POST['attendance_status'];
    } else {
        $ppage              = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $emp_no             = isset( $_GET['emp_no'] ) ? $_GET['emp_no']  : '';
        $emp_name           = isset( $_GET['emp_name'] ) ? $_GET['emp_name']  : '';
        $emp_mobile         = isset( $_GET['emp_mobile'] ) ? $_GET['emp_mobile']  : '';
        $employee_status    = isset( $_GET['attendance_status'] ) ? $_GET['attendance_status']  : '-';
    }

    $page_arg = [];
    if($emp_no != '') {
        $page_arg['emp_no'] = $emp_no;
    }
    if($emp_name != '') {
        $page_arg['emp_name'] = $emp_name;
    }
    if($search_product != '') {
        $page_arg['search_product'] = $search_product;
    }
    if($emp_mobile != '') {
        $page_arg['emp_mobile'] = $emp_mobile;
    }
    if($employee_status != '-') {
        $page_arg['employee_status'] = $employee_status;
    }
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];
    /*END Updated for filter 11/10/16*/

    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=salary_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}




function petty_cash_list_pagination( $args ) {

    global $wpdb;
    $table =  $wpdb->prefix.'petty_cash';
    $customPagHTML      = "";
    $query              = "SELECT * FROM ${table} WHERE active = 1 ${args['condition']}";
    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']         = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);


    /*END Updated for filter 11/10/16*/
    if(isset($_POST['action']) && $_POST['action'] == 'petty_cash_list_filter') {
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

    $page_arg = [];
    if($entry_amount != '') {
        $page_arg['entry_amount'] = $entry_amount;
    }
    if($entry_description != '') {
        $page_arg['entry_description'] = $entry_description;
    }
    if($entry_date_from != '') {
        $page_arg['entry_date_from'] = $entry_date_from;
    }
    if($entry_date_to != '') {
        $page_arg['entry_date_to'] = $entry_date_to;
    }
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];
    /*END Updated for filter 11/10/16*/


    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=petty_cash')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}

function income_list_pagination( $args ) {

    global $wpdb;
    $table =  $wpdb->prefix.'income_list';
    $customPagHTML      = "";
    $query              = "SELECT * FROM ${table} WHERE active = 1 ${args['condition']}";
    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']         = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);


    /*END Updated for filter 11/10/16*/
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

    $page_arg = [];
    if($entry_amount != '') {
        $page_arg['entry_amount'] = $entry_amount;
    }
    if($entry_description != '') {
        $page_arg['entry_description'] = $entry_description;
    }
    if($entry_date_from != '') {
        $page_arg['entry_date_from'] = $entry_date_from;
    }
    if($entry_date_to != '') {
        $page_arg['entry_date_to'] = $entry_date_to;
    }
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];
    /*END Updated for filter 11/10/16*/

    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=income_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}



function employee_salary_detail_pagination( $args ) {

    global $wpdb;
    $employee_table =  $wpdb->prefix.'employees';
    $employee_salary =  $wpdb->prefix.'employee_salary';
    $customPagHTML      = "";
    
    $query              = "SELECT es.*, e.emp_name, e.emp_mobile, CONCAT('EMP', es.emp_id) as empp_id FROM ${employee_salary} es JOIN ${employee_table} e ON es.emp_id = e.id WHERE es.active = 1 ${args['condition']}";
    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";

    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']         = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);

    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( array('cpage' => '%#%', 'ppage' => $args['items_per_page'] ) , admin_url('admin.php?page=salary_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}




function employee_attendance_detail_pagination( $args ) {

    global $wpdb;
    $employee_table =  $wpdb->prefix.'employees';
    $employee_attendance =  $wpdb->prefix.'employee_attendance';
    $customPagHTML      = "";
    
    $query              = "SELECT ea.*, e.emp_name, e.emp_mobile, CONCAT('EMP', e.id) as empp_id,
CASE 
 WHEN ea.emp_attendance = 1
 THEN 'Present'
 ELSE 'Absent' END as attendance
     FROM ${employee_attendance} ea JOIN ${employee_table} e ON ea.emp_id = e.id WHERE ea.active = 1 ${args['condition']}";
    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";

    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']         = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);

    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));
        
        $pagination = paginate_links( array(
                'base' => add_query_arg( array('cpage' => '%#%', 'ppage' => $args['items_per_page'] ) , admin_url('admin.php?page=salary_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}

function stock_detail_list_pagination( $args ) {

    global $wpdb;
    $lots_table = $wpdb->prefix. 'lots';
    $sale_detail = $wpdb->prefix.'sale_detail';
    $stock_detail = $wpdb->prefix.'stock';
    $customPagHTML      = "";
    $query              = "SELECT * FROM ( SELECT lot.*, ( (CASE WHEN sale.sale_total THEN sale.sale_total ELSE 0 END) - (CASE WHEN return_data.return_weight THEN return_data.return_weight ELSE 0 END) )  as sale_tot, (CASE WHEN stock.stock_total THEN stock.stock_total ELSE 0 END) stock_tot,     (CASE WHEN return_data.return_weight THEN return_data.return_weight ELSE 0 END) return_tot,
    
        ( (CASE WHEN stock.stock_total THEN stock.stock_total ELSE 0 END) - ( (CASE WHEN sale.sale_total THEN sale.sale_total ELSE 0 END) - (CASE WHEN return_data.return_weight THEN return_data.return_weight ELSE 0 END) )  ) as bal_stock,
        ( CASE WHEN (
            ( (CASE WHEN stock.stock_total THEN stock.stock_total ELSE 0 END) - ( (CASE WHEN sale.sale_total THEN sale.sale_total ELSE 0 END) - (CASE WHEN return_data.return_weight THEN return_data.return_weight ELSE 0 END) )  ) < lot.stock_alert
        ) THEN 0 ELSE 1 END ) as in_alert


    FROM 
    (
        SELECT l.id, l.lot_number, l.brand_name, l.product_name, l.weight as bag_weight, l.stock_alert, l.unit_type, 
        (CASE 
            WHEN l.parent_id = 0 
            THEN l.id
            ELSE l.parent_id
         END ) as parent_id
        FROM ${lots_table} l WHERE l.active = 1
    ) 
    lot LEFT JOIN 
    (
        SELECT s.lot_parent_id as sale_lot_id, SUM(s.sale_weight) as sale_total FROM ${sale_detail} s WHERE s.active = 1 AND s.bill_type = 'original' AND s.item_status = 'open' GROUP BY s.lot_parent_id
    ) 
    sale ON lot.parent_id = sale.sale_lot_id LEFT JOIN 
    (
        SELECT s1.lot_id as stock_lot_id, SUM(s1.total_weight) as stock_total FROM ${stock_detail} s1 WHERE s1.active = 1 GROUP BY s1.lot_id    
    ) 
    stock ON lot.parent_id = stock.stock_lot_id 

    LEFT JOIN 
    (
        SELECT ( CASE WHEN l.parent_id = 0 THEN l.id ELSE l.parent_id END ) as lot_id, SUM(rr.return_weight) as return_weight FROM ( SELECT rd.lot_id, rd.return_weight from wp_return as r JOIN wp_return_detail as rd ON r.id = rd.return_id WHERE r.active = 1 AND rd.active = 1) as rr JOIN wp_lots as l ON l.id = rr.lot_id GROUP BY ( CASE WHEN l.parent_id = 0 THEN l.id ELSE l.parent_id END )
    ) as 
    return_data ON lot.parent_id = return_data.lot_id


    ) as lo  WHERE lo.id = lo.parent_id  ${args['condition']} 
    ";

    $input = array_combine($args['orderby_field'], $args['order_by']);
    $output = implode(', ', array_map(
        function ($v, $k) { return sprintf("%s %s", $k, $v); },
        $input,
        array_keys($input)
    ));


    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']     = $wpdb->get_results( $query . "ORDER BY $output LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);


    /*END Updated for filter 11/10/16*/

    if(isset($_POST['action']) && $_POST['action'] == 'stock_report_list') {
        $ppage = $_POST['per_page'];
        $lot_number = $_POST['lot_number'];
        $search_brand = $_POST['search_brand'];
        $search_product = $_POST['search_product'];
        $stock_total = $_POST['stock_total'];
        $sale_total = $_POST['sale_total'];
        $stock_bal = $_POST['stock_bal'];
    } else {
        $ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $lot_number = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
        $search_brand = isset( $_GET['search_brand'] ) ? $_GET['search_brand']  : '';
        $search_product = isset( $_GET['search_product'] ) ? $_GET['search_product']  : '';
        $stock_total = isset( $_GET['stock_total'] ) ? $_GET['stock_total']  : '';
        $sale_total = isset( $_GET['sale_total'] ) ? $_GET['sale_total']  : '';
        $stock_bal = isset( $_GET['stock_bal'] ) ? $_GET['stock_bal']  : '';
    }


    $page_arg = [];
    if($lot_number != '') {
        $page_arg['lot_number'] = $lot_number;
    }
    if($search_brand != '') {
        $page_arg['search_brand'] = $search_brand;
    }
    if($search_product != '') {
        $page_arg['search_product'] = $search_product;
    }
    if($stock_total != '') {
        $page_arg['stock_total'] = $stock_total;
    }
    if($sale_total != '') {
        $page_arg['sale_total'] = $sale_total;
    }
    if($stock_bal != '') {
        $page_arg['stock_bal'] = $stock_bal;
    }
    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];
    /*END Updated for filter 11/10/16*/

    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=report_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;
}





function sale_detail_list_pagination($args) {

    global $wpdb;
    $lots_table = $wpdb->prefix. 'lots';
    $sale_table = $wpdb->prefix.'sale';
    $sale_detail = $wpdb->prefix.'sale_detail';
    $customPagHTML      = "";

$query = "SELECT f.*, 
l.weight as parent_bag_weight, 
l.lot_number as parent_lot_number,
l.unit_type,
sum(f.weight) as tot_weight, sum(taxless_amt) as tot_taxless, sum(f.amt) as tot_amt, sum(f.cgst_value) as tot_cgst, sum(f.sgst_value) as tot_sgst, sum(f.igst_value) as tot_igst FROM wp_lots as l JOIN 

(
    (
        SELECT 
            l.id as lot_id, 
            l.lot_number, 
            l.brand_name, 
            l.product_name, 
            (CASE WHEN l.parent_id = 0 THEN l.id ELSE l.parent_id END) as parent_id,
            sd.sale_as as bag_kg, 
            sd.bag_weight, 
            sd.sale_weight as weight, 
            sd.sale_value as amt, 
            sd.bill_type, 
            sd.lot_type, 
            sd.made_by, 
            sd.taxless_amt, 
            sd.cgst_percentage as cgst, 
            sd.sgst_percentage as sgst, 
            sd.igst_percentage as igst, 
            (CASE WHEN s.gst_to = 'cgst' THEN sd.cgst_value ELSE 0.00 END) as cgst_value, 
            (CASE WHEN s.gst_to = 'cgst' THEN sd.sgst_value ELSE 0.00 END) as sgst_value, 
            (CASE WHEN s.gst_to = 'igst' THEN sd.igst_value ELSE 0.00 END) as igst_value, 
            'sale' as report_type,
            s.gst_to as gst_type
        FROM wp_sale as s 
        LEFT JOIN wp_sale_detail as sd 
        ON s.id = sd.sale_id 
        LEFT JOIN wp_lots as l 
        ON l.id = sd.lot_id 
        WHERE ${args['sale_condition']} AND s.active = 1 AND sd.active = 1
    )

    UNION ALL
    
    (
        SELECT 
            l.id as lot_id, 
            l.lot_number, 
            l.brand_name, 
            l.product_name, 
            (CASE WHEN l.parent_id = 0 THEN l.id ELSE l.parent_id END) as parent_id,
            rd.return_as as bag_kg,
            rd.bag_weight,
            -(rd.return_weight) as weight, 
            -(rd.subtotal) as amt,
            rd.bill_type, 
            l.lot_type,
            rd.made_by, 
            -(rd.taxless_amount) as taxless_amt,
            rd.cgst as cgst, 
            rd.sgst as sgst, 
            rd.igst as igst, 
            (CASE WHEN s.gst_to = 'cgst' THEN -(rd.cgst_value) ELSE 0.00 END) as cgst_value, 
            (CASE WHEN s.gst_to = 'cgst' THEN -(rd.sgst_value) ELSE 0.00 END) as sgst_value, 
            (CASE WHEN s.gst_to = 'igst' THEN -(rd.igst_value) ELSE 0.00 END) as igst_value,
            'return' as report_type,
             s.gst_to as gst_type
        FROM wp_return as r 
        LEFT JOIN wp_return_detail as rd
        ON r.id = rd.return_id 
        LEFT JOIN wp_lots as l 
        ON l.id = rd.lot_id 
        LEFT JOIN wp_sale as s 
        ON s.id = r.sale_id
        WHERE ${args['return_condition']} AND r.active = 1 AND rd.active = 1 AND s.active = 1
    )
    
) as f 

ON l.id = f.parent_id

WHERE 1=1 ${args['condition']} GROUP BY f.lot_id ";


    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";

    $status_query        = "SELECT SUM(combined_table.tot_weight) as weight_s, SUM(combined_table.tot_amt) as sale_s  FROM (${query}) AS combined_table";
    $data['s_result']         = $wpdb->get_row( $status_query );

    $total              = $wpdb->get_var( $total_query );
    $page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']     = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($total / $args['items_per_page']);

    /*END Updated for filter 11/10/16*/

    if(isset($_POST['action']) && $_POST['action'] == 'stock_sale_filter_list') {
        $ppage          = $_POST['per_page'];
        $lot_number     = $_POST['lot_number'];
        $date_from      = $_POST['date_from'];
        $date_to        = $_POST['date_to'];
        $bill_type      = $_POST['bill_type'];
        $item_status    = $_POST['item_status'];
        $lot_type       = $_POST['lot_type'];
    } else {
        $ppage              = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $lot_number         = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
        $date_from          = isset( $_GET['date_from'] ) ? $_GET['date_from']  : '';
        $date_to            = isset( $_GET['date_to'] ) ? $_GET['date_to']  : '';
        $bill_type          = isset( $_GET['bill_type'] ) ? $_GET['bill_type']  : '-';
        $item_status        = isset( $_GET['item_status'] ) ? $_GET['item_status']  : '-';
        $lot_type           = isset( $_GET['lot_type'] ) ? $_GET['lot_type']  : '-';
    }


    $page_arg = [];


    if($lot_number != '') {
        $page_arg['lot_number'] = $lot_number;
    }
    if($date_from != '') {
        $page_arg['date_from'] = $date_from;
    }
    if($date_to != '') {
        $page_arg['date_to'] = $date_to;
    }
    if($bill_type != '-') {
        $page_arg['bill_type'] = $bill_type;
    }
    if($item_status != '-') {
        $page_arg['item_status'] = $item_status;
    }
    if($lot_type != '-') {
        $page_arg['lot_type'] = $lot_type;
    }



    $page_arg['cpage'] = '%#%';
    $page_arg['ppage'] = $args['items_per_page'];
    /*END Updated for filter 11/10/16*/

    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=sale_report_list')),
                'format' => '',
                'type' => 'array',
                'prev_text' => __('prev'),
                'next_text' => __('next'),
                'total' => $totalPage,
                'current' => $page
                )
            );
        if ( ! empty( $pagination ) ) : 
            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
            foreach ($pagination as $key => $page_link ) {
                if( strpos( $page_link, 'current' ) !== false ) {
                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
                } else {
                    $customPagHTML .=  '<li>'.$page_link.'</li>';
                }
            }
            $customPagHTML .=  '</ul>';
        endif;
    }

    $data['pagination'] = $customPagHTML;
    return $data;

}











function getStatusCount() {

    global $wpdb;
    $lots_table = $wpdb->prefix. 'lots';
    $sale_detail = $wpdb->prefix.'sale_detail';
    $stock_table = $wpdb->prefix.'stock';
    $customers_table = $wpdb->prefix.'customers';
    $employees_table = $wpdb->prefix.'employees';


    $customPagHTML      = "";

    $count_query = "SELECT avl.avail_stock, unavl.unavail_stock, cus.tot_customers, emp.tot_employees FROM ( SELECT count(1) as     avail_stock FROM ( SELECT * FROM (SELECT lot.*, (CASE WHEN sale.sale_total THEN sale.sale_total ELSE 0 END)  as sale_tot, ( CASE WHEN stock.stock_total THEN stock.stock_total ELSE 0 END) stock_tot,
    
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
            SELECT s.lot_parent_id as sale_lot_id, SUM(s.sale_weight) as sale_total FROM ${sale_detail} s WHERE s.active = 1 AND s.bill_type = 'original' AND s.item_status = 'open' GROUP BY s.lot_parent_id
        ) 
        sale ON lot.parent_id = sale.sale_lot_id LEFT JOIN 
        (
            SELECT s1.lot_id as stock_lot_id, SUM(s1.total_weight) as stock_total FROM ${stock_table} s1 WHERE s1.active = 1 GROUP BY s1.lot_id    
        ) 
        stock ON lot.parent_id = stock.stock_lot_id ) as lo  WHERE lo.id = lo.parent_id ) as avail_stock 

        WHERE avail_stock.bal_stock > 0
    ) as avl 

    JOIN

    ( SELECT count(1) as unavail_stock FROM ( SELECT * FROM (SELECT lot.*, (CASE WHEN sale.sale_total THEN sale.sale_total ELSE 0 END)  as sale_tot, (CASE WHEN stock.stock_total THEN stock.stock_total ELSE 0 END) stock_tot,
        
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
            SELECT s.lot_parent_id as sale_lot_id, SUM(s.sale_weight) as sale_total FROM ${sale_detail} s WHERE s.active = 1 AND s.bill_type = 'original' AND s.item_status = 'open' GROUP BY s.lot_parent_id
        ) 
        sale ON lot.parent_id = sale.sale_lot_id LEFT JOIN 
        (
            SELECT s1.lot_id as stock_lot_id, SUM(s1.total_weight) as stock_total FROM ${stock_table} s1 WHERE s1.active = 1 GROUP BY s1.lot_id    
        ) 
        stock ON lot.parent_id = stock.stock_lot_id ) as lo  WHERE lo.id = lo.parent_id ) as avail_stock 

        WHERE avail_stock.bal_stock <= 0
    ) as unavl 

    ON 1 = 1
    JOIN
    ( SELECT count(1) as tot_customers FROM ${customers_table} c WHERE c.active = 1 ) cus

    ON 1 = 1
    JOIN
    ( SELECT count(1) as tot_employees FROM ${employees_table} e WHERE e.active = 1 AND e.emp_current_status = 1 ) as emp";

    $data['result']         = $wpdb->get_row( $count_query );

    return $data;
}


// SELECT full_table.*,
// (case when return_tab.return_amount is null then 0 else return_tab.return_amount end) as return_amount
// from ( SELECT bill.*, 
// (case when payment.cash_amount is null then '-' else payment.cash_amount-bill.pay_to_bal end) as cash_amount,
// (case when payment.card_amount is null then '-' else payment.card_amount end) as card_amount,
// (case when payment.cheque_amount is null then '-' else payment.cheque_amount end) as cheque_amount,
// (case when payment.net_banking_amount is null then '-' else payment.net_banking_amount end) as net_banking_amount
// from (SELECT s1.*, 
// ((CASE WHEN s2.paid_total IS NULL THEN 0.00 ELSE s2.paid_total END) - s1.pay_to_bal) as paid_total, 
// ( s1.sale_total - (CASE WHEN s2.paid_total IS NULL THEN 0.00 ELSE s2.paid_total END ) ) as to_be_paid 
// FROM 
// ( 
//     SELECT s.*, c.name, c.type, c.mobile FROM wp_sale as s 
//     LEFT JOIN 
//     wp_customers as c 
//     ON s.customer_id = c.id 
// ) as s1 
// LEFT JOIN 
// (
//     SELECT s.id as sale_id, s.customer_id, s.sale_total, ph.paid_total FROM wp_sale as s 
//     JOIN ( 
//         SELECT p.sale_id, SUM(p.amount) as paid_total FROM wp_payment as p WHERE p.active = 1 GROUP BY p.sale_id 
//     ) as ph 
//     ON s.id = ph.sale_id WHERE s.active = 1 
// ) as s2 
// ON s1.id = s2.sale_id 
// WHERE s1.active = 1 AND s1.locked = 1 )  as bill left join 
// (
// SELECT sale_id,
// sum(case when payment_type = 'cash' then amount else '-' end) as cash_amount,
// sum(case when payment_type = 'card' then amount else '-' end) as card_amount,
// sum(case when payment_type = 'cheque' then amount else '-' end) as cheque_amount,
// sum(case when payment_type = 'net_banking' then amount else '-' end) as net_banking_amount
// FROM wp_payment WHERE active=1 GROUP by sale_id
//  ) as payment on bill.id = payment.sale_id ) as full_table 
//  left join 
//  (
//  SELECT sum(key_amount) as return_amount,sale_id 
// from wp_return GROUP by sale_id
// ) as 
// return_tab 
// on return_tab.sale_id = full_table.id where full_table.active = 1   AND full_table.locked = 1

// SELECT full_table.*,
// (case when return_tab.return_amount is null then 0 else return_tab.return_amount end) as return_amount
// from ( SELECT bill.*, 
// (case when payment.cash_amount is null then '-' else payment.cash_amount-bill.pay_to_bal end) as cash_amount,
// (case when payment.card_amount is null then '-' else payment.card_amount end) as card_amount,
// (case when payment.cheque_amount is null then '-' else payment.cheque_amount end) as cheque_amount,
// (case when payment.net_banking_amount is null then '-' else payment.net_banking_amount end) as net_banking_amount
// from (SELECT s1.*, 
// ((CASE WHEN s2.paid_total IS NULL THEN 0.00 ELSE s2.paid_total END) - s1.pay_to_bal) as paid_total, 
// ( s1.sale_total - (CASE WHEN s2.paid_total IS NULL THEN 0.00 ELSE s2.paid_total END ) ) as to_be_paid,
//       (case when s1.margin_rate is null then 0 else s1.margin_rate end) as margin_rate
// FROM 
// ( 
//     SELECT s.*, c.name, c.type, c.mobile FROM 
//     (
//         SELECT s_in.*,
//         (case when sale_details.margin_rate is null then 0 else sale_details.margin_rate end) as margin_rate 
//         from 
//         wp_sale as s_in 
//         left join 
//         (
//             SELECT sale_id,
//             sum(case when unit_price = margin_price then 1 else 0 end) as margin_rate 
//             from 
//             wp_sale_detail 
//             WHERE active = 1 GROUP by sale_id
//         ) as 
//         ale_details 
//         on s_in.id = sale_details.sale_id 
//     )  as s 
//     LEFT JOIN 
//     wp_customers as c 
//     ON s.customer_id = c.id
// ) as s1 
// LEFT JOIN 
// (

//     SELECT s.id as sale_id, s.customer_id, s.sale_total, ph.paid_total FROM wp_sale as s 
//     JOIN ( 
//         SELECT p.sale_id, SUM(p.amount) as paid_total FROM wp_payment as p WHERE p.active = 1 GROUP BY p.sale_id 
//     ) as ph 
//     ON s.id = ph.sale_id WHERE s.active = 1
// ) as s2 
// ON s1.id = s2.sale_id 
// WHERE s1.active = 1 AND s1.locked = 1 )  as bill left join 
// (
// SELECT sale_id,
// sum(case when payment_type = 'cash' then amount else '-' end) as cash_amount,
// sum(case when payment_type = 'card' then amount else '-' end) as card_amount,
// sum(case when payment_type = 'cheque' then amount else '-' end) as cheque_amount,
// sum(case when payment_type = 'net_banking' then amount else '-' end) as net_banking_amount
// FROM wp_payment WHERE active=1 GROUP by sale_id
//  ) as payment on bill.id = payment.sale_id ) as full_table 
//  left join 
//  (
//  SELECT sum(key_amount) as return_amount,sale_id 
// from wp_return GROUP by sale_id
// ) as 
// return_tab 
// on return_tab.sale_id = full_table.id where full_table.active = 1   AND full_table.locked = 1
?>