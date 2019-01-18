<?php
	class report {
 
		function __construct() {

		    if( isset($_POST['action'])) {
		    	$params = array();
				parse_str($_POST['data'], $params);
		        $this->cpage  = 1;
		        $this->ppage  = isset($params['ppage']) ? $params['ppage'] : 5;
		        $this->bill_from = isset($params['bill_from']) ? man_to_machine_date($params['bill_from']) : date('Y-m-01');
		        $this->bill_to = isset($params['bill_to']) ? man_to_machine_date($params['bill_to']) : date('Y-m-t');
		        $this->slab    = isset($params['slab']) ? $params['slab'] :'-' ;
		    }  
		    else {
		        $this->cpage 		= isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		        $this->ppage 		= isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 5;
		        $this->bill_from 	= isset( $_GET['bill_from'] ) ? man_to_machine_date($_GET['bill_from'])  : date('Y-m-d');
		        $this->bill_to 		= isset( $_GET['bill_to'] ) ? man_to_machine_date($_GET['bill_to'])  : date('Y-m-d');
		        $this->slab   		= isset( $_GET['slab'] ) ? $_GET['slab']  : '-';
		    }
		}





		function stock_report_pagination_gst( $args ) {
		    global $wpdb;
		    $lots_table = $wpdb->prefix. 'lots';
		    $sale_table = $wpdb->prefix.'sale';
		    $sale_detail = $wpdb->prefix.'sale_detail';
		    $customPagHTML      = "";

			$query = "SELECT f.*, 
l.weight as parent_bag_weight, 
l.lot_number as parent_lot_number,
l.hsn_code,
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
            s.gst_to as gst_type,
            DATE(s.invoice_date) as invoice_date
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
            s.gst_to as gst_type,
            DATE(s.invoice_date) as invoice_date
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
WHERE 1=1 ${args['condition']} GROUP BY ${args['orderby_field']} ";

/*$w = 45.5;
$h = 177.8 / 100;
var_dump( $w / ($h * $h) );

$iw = 100;
$ih = 6.4;
var_dump( ($iw / ($ih * $ih)) * 703  );*/


    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";

    $status_query        = "SELECT SUM(combined_table.tot_weight) as weight_s, SUM(combined_table.tot_taxless) as taxless_s, SUM(combined_table.tot_cgst) as cgst_s, SUM(combined_table.tot_sgst) as sgst_s, SUM(combined_table.tot_igst) as igst_s, SUM(combined_table.tot_amt) as sale_s  FROM (${query}) AS combined_table";
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
        $date_from      = man_to_machine_date($_POST['date_from']);
        $date_to        = man_to_machine_date($_POST['date_to']);
        $bill_type      = $_POST['bill_type'];
        $item_status    = $_POST['item_status'];
        $lot_type       = $_POST['lot_type'];
    } else {
        $ppage              = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $lot_number         = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
        $date_from          = isset( $_GET['date_from'] ) ? man_to_machine_date($_GET['date_from'])  : '';
        $date_to            = isset( $_GET['date_to'] ) ? man_to_machine_date($_GET['date_to'])  : '';
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
	
	function return_report_pagination_gst( $args ) {
		    global $wpdb;
		    $lots_table = $wpdb->prefix. 'lots';
		    $sale_table = $wpdb->prefix.'sale';
		    $sale_detail = $wpdb->prefix.'sale_detail';
		    $customPagHTML      = "";
		    
			$query = "SELECT f.*, 
l.weight as parent_bag_weight, 
l.lot_number as parent_lot_number,
l.hsn_code,
sum(f.weight) as tot_weight, sum(taxless_amt) as tot_taxless, sum(f.amt) as tot_amt, sum(f.cgst_value) as tot_cgst, sum(f.sgst_value) as tot_sgst, sum(f.igst_value) as tot_igst FROM wp_lots as l JOIN 

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
) as f 

ON l.id = f.parent_id

WHERE 1=1 ${args['condition']} GROUP BY ${args['orderby_field']} ";


    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";

    $status_query        = "SELECT SUM(combined_table.tot_weight) as weight_s, SUM(combined_table.tot_taxless) as taxless_s, SUM(combined_table.tot_cgst) as cgst_s, SUM(combined_table.tot_sgst) as sgst_s, SUM(combined_table.tot_igst) as igst_s, SUM(combined_table.tot_amt) as sale_s  FROM (${query}) AS combined_table";
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
        $date_from      = man_to_machine_date($_POST['date_from']);
        $date_to        = man_to_machine_date($_POST['date_to']);
        $bill_type      = $_POST['bill_type'];
        $item_status    = $_POST['item_status'];
        $lot_type       = $_POST['lot_type'];
    } else {
        $ppage              = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
        $lot_number         = isset( $_GET['lot_number'] ) ? $_GET['lot_number']  : '';
        $date_from          = isset( $_GET['date_from'] ) ? man_to_machine_date($_GET['date_from'])  : '';
        $date_to            = isset( $_GET['date_to'] ) ? man_to_machine_date($_GET['date_to'])  : '';
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


function stock_report_pagination_accountant( $args ) {
    global $wpdb;
    $sale = $wpdb->prefix.'sale';
    $sale_details =  $wpdb->prefix.'sale_detail';
    $return_table = $wpdb->prefix.'return_items_details';
    $customPagHTML      = "";

	$page_arg = [];
	$page_arg['ppage'] = $args['items_per_page'];
	$page_arg['bill_from'] = $this->bill_from;
	$page_arg['bill_to'] = $this->bill_to;
	$page_arg['slap'] = $this->slap;
    $page_arg['cpage'] = '%#%';

    $condition = '';  
    
    if($this->bill_from != '' && $this->bill_to != '') {
    	$condition .= " AND DATE(sale.modified_at) >= DATE('".$this->bill_from."') AND DATE(sale.modified_at) <= DATE('".$this->bill_to."')";
    } else if($this->bill_from != '' || $this->bill_to != '') {
    	if($this->bill_from != '') {
    		$condition .= " AND DATE(sale.modified_at) >= DATE('".$this->bill_from."') AND DATE(sale.modified_at) <= DATE('".$this->bill_from."')";
    	} else {
    		$condition .= " AND DATE(sale.modified_at) >= DATE('".$this->bill_to."') AND DATE(sale.modified_at) <= DATE('".$this->bill_to."')";
    	}
    }

    if($this->slap != '') {
    	$condition_final .= "AND report.gst = ".$this->slap;
    }
    $query 				= "SELECT * from (
    		SELECT 
			(sum(fin_tab.bal_cgst)) as cgst_value, 
			(sum(fin_tab.bal_total)) as total, 
			(sum(fin_tab.bal_unit)) as total_unit, 
			(sum(fin_tab.bal_amt)) as amt,fin_tab.gst as gst 
		      
			from (SELECT 
					(case when return_table.return_cgst is null then sale_table.sale_cgst else sale_table.sale_cgst - return_table.return_cgst end ) as bal_cgst, 
					(case when return_table.return_total is null then sale_table.sale_total else sale_table.sale_total - return_table.return_total end ) as bal_total,
					(case when return_table.return_unit is null then sale_table.sale_unit else  sale_table.sale_unit - return_table.return_unit end) as bal_unit,
					(case when return_table.return_amt is null then sale_table.sale_amt else sale_table.sale_amt - return_table.return_amt end ) as bal_amt,
					sale_table.cgst as gst
					FROM 
					(
					SELECT sale_details.cgst,
					    sum(sale_details.cgst_value) as sale_cgst, 
					    sum(sale_details.sgst_value) sale_sgst, 
					    sum(sale_details.sub_total) as sale_total, 
					    sum(sale_details.sale_unit) as sale_unit,
					    sum(sale_details.amt) as sale_amt FROM ${sale} as sale left join ${sale_details} as sale_details on sale.`id`= sale_details.sale_id WHERE sale.active = 1 and sale_details.active = 1 ${condition} group by sale_details.cgst
					) as sale_table 
					left join
					(
					 SELECT return_details.cgst,
					    sum(return_details.cgst_value) as return_cgst, 
					    sum(return_details.sgst_value) as return_sgst, 
					    sum(return_details.sub_total) as return_total ,
					    sum(return_details.return_unit) as return_unit,
					    sum(return_details.amt) as return_amt FROM ${sale} as sale left join ${return_table} as return_details on sale.`id`= return_details.sale_id WHERE sale.active = 1 and return_details.active = 1 ${condition} group by return_details.cgst
					) as return_table 
					on sale_table.cgst = return_table.cgst
		union all 
		                	SELECT 
(case when ws_return_table.return_cgst is null then ws_sale_table.sale_cgst else ws_sale_table.sale_cgst - ws_return_table.return_cgst end ) as bal_cgst, 
(case when ws_return_table.return_total is null then ws_sale_table.sale_total else ws_sale_table.sale_total - ws_return_table.return_total end ) as bal_total,
(case when ws_return_table.return_unit is null then ws_sale_table.sale_unit else  ws_sale_table.sale_unit - ws_return_table.return_unit end) as bal_unit,
(case when ws_return_table.return_amt is null then ws_sale_table.sale_amt else ws_sale_table.sale_amt - ws_return_table.return_amt end ) as bal_amt,
					ws_sale_table.cgst as gst
					FROM 
					(
					SELECT ws_sale_details.cgst,
					    sum(ws_sale_details.cgst_value) as sale_cgst, 
					    sum(ws_sale_details.sgst_value) sale_sgst, 
					    sum(ws_sale_details.sub_total) as sale_total, 
					    sum(ws_sale_details.sale_unit) as sale_unit,
					    sum(ws_sale_details.amt) as sale_amt FROM ${ws_sale} as sale left join ${ws_sale_details} as ws_sale_details on sale.`id`= ws_sale_details.sale_id WHERE sale.active = 1 and ws_sale_details.active = 1 ${condition} group by ws_sale_details.cgst
					) as ws_sale_table 
					left join
					(
					 SELECT ws_return_details.cgst,
					    sum(ws_return_details.cgst_value) as return_cgst, 
					    sum(ws_return_details.sgst_value) as return_sgst, 
					    sum(ws_return_details.sub_total) as return_total ,
					    sum(ws_return_details.return_unit) as return_unit,
					    sum(ws_return_details.amt) as return_amt FROM ${ws_sale} as sale left join ${ws_return_table} as ws_return_details on sale.`id`= ws_return_details.sale_id WHERE sale.active = 1 and ws_return_details.active = 1 ${condition} group by ws_return_details.cgst
					) as ws_return_table 
					on ws_sale_table.cgst = ws_return_table.cgst ) as fin_tab GROUP by fin_tab.gst ) as report WHERE report.total_unit > 0 ${condition_final}";
            
var_dump($query);

    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";

    $status_query       = "SELECT SUM(cgst_value) as total_cgst,sum(total_unit) as sold_qty,sum(total) as sub_tot,sum(amt) as tot_amt FROM (${query}) AS combined_table";
	$data['s_result']   = $wpdb->get_row( $status_query );

    $data['total']      = $wpdb->get_var( $total_query );

    //$page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
    $page               = $this->cpage;
    $ppage 				= $this->ppage;
    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

    $data['result']         = $wpdb->get_results( $query . " ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

    $totalPage         = ceil($data['total'] / $args['items_per_page']);

    if($totalPage > 1){
        $data['start_count'] = ($ppage * ($page-1));

        $pagination = paginate_links( array(
                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=list_report_account')),
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
    $end_count = $data['start_count'] + count($data['result']);

    if( $end_count == 0){
    	$start_count = 0;
    }
    else {
    	$start_count = $data['start_count'] + 1;
    }
    $data['status_txt'] = "<div class='dataTables_info' role='status' aria-live='polite'>Showing ".$start_count." to ".$end_count." of ".$data['total']." entries</div>";
    return $data;

}
}

?>
