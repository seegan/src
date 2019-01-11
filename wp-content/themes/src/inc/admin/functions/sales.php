<?php
	function getSaleDataByYearInvoice($year = '', $inv_no = '') {
		global $wpdb;
		$sales_table 			= $wpdb->prefix. 'sale';
		$data = $wpdb->get_row("SELECT * from ${sales_table} as s WHERE s.active = 1 AND s.locked = 1 AND s.financial_year = ${year} AND s.invoice_id = ${inv_no}");
		return $data;
	}

	function getSalesList($sale_id = '') {
		global $wpdb;
		$sale_detail 			= $wpdb->prefix. 'sale_detail';

		$query = "SELECT sd.*, l.lot_number, l.brand_name, l.product_name, l.unit_type,

(CASE WHEN return_table.return_weight is NULL
 THEN 0
 ELSE return_table.return_weight
 END ) as tot_returned, 

(CASE WHEN delivery_table.delivery_weight is NULL
 THEN 0
 ELSE delivery_table.delivery_weight
 END ) as tot_delivered,
 
 ( sd.sale_weight - (CASE WHEN return_table.return_weight is NULL
 THEN 0
 ELSE return_table.return_weight
 END ) ) as current_sale_weight,
 
 (  sd.sale_weight - (CASE WHEN delivery_table.delivery_weight is NULL
 THEN 0
 ELSE delivery_table.delivery_weight
 END )
 ) as delivery_balance,
 (
    (CASE WHEN delivery_table.delivery_weight is NULL
     THEN 0
     ELSE delivery_table.delivery_weight
     END )    -  (CASE WHEN return_table.return_weight is NULL
     THEN 0
     ELSE return_table.return_weight
    END )
 ) as return_avail
  

FROM wp_sale_detail as sd JOIN wp_lots as l ON sd.lot_id = l.id 

LEFT JOIN 

(SELECT rd.sale_detail_id, SUM(rd.return_weight) as return_weight FROM wp_return_detail as rd JOIN wp_return as r ON rd.return_id = r.id WHERE rd.active = 1 AND r.active = 1 AND rd.sale_id = ${sale_id} GROUP BY rd.sale_detail_id) as return_table  

ON return_table.sale_detail_id = sd.id 

LEFT JOIN 

( SELECT dd.sale_detail_id, SUM(dd.delivery_weight) as delivery_weight FROM wp_delivery_detail as dd JOIN wp_delivery as d ON dd.delivery_id = d.id WHERE dd.active = 1 AND d.active = 1 AND dd.sale_id = ${sale_id} GROUP BY dd.sale_detail_id ) as delivery_table

ON delivery_table.sale_detail_id = sd.id

WHERE sd.active = 1 AND sd.sale_id = ${sale_id}";

		$data = $wpdb->get_results($query);
		return $data;
	}
?>