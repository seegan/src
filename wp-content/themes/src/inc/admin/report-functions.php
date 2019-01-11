<?php

function getSalesStatistics($date='')
{
	global $wpdb;
	$sale_table = $wpdb->prefix. 'sale';
	$petty_cash_table = $wpdb->prefix. 'petty_cash';
	$income_cash_table = $wpdb->prefix. 'income_list';


	$query = " SELECT * from ( SELECT 
                
                (CASE
                WHEN SUM(sale_total) Is Null 
                THEN 0
                ELSE SUM(sale_total)
                END) as sal_total
                
                
                FROM ${sale_table} WHERE active = 1 AND DATE(invoice_date) = DATE('".$date."') )as s_total 

INNER JOIN 

( SELECT 
 
 (CASE
  WHEN SUM(cash_amount) Is Null 
  THEN 0
  ELSE SUM(cash_amount)
  END) as petty_cash 
 
 FROM ${petty_cash_table} WHERE active = 1 AND DATE(cash_date) = DATE('".$date."') ) as pt_total

ON 1=1
INNER JOIN

( SELECT 
  (CASE
  WHEN SUM(cash_amount) Is Null 
  THEN 0
  ELSE SUM(cash_amount)
  END) as income_cash 
 
 FROM ${income_cash_table} WHERE active = 1 AND DATE(cash_date) = DATE('".$date."') ) as in_total";


	$res = $wpdb->get_row( $query );
	if($res) {
		$result[] = array('y' => $res->sal_total, 'legendText' => 'Sale', 'label' => 'Sale');
		$result[] = array('y' => $res->petty_cash, 'legendText' => 'Petty Cash', 'label' => 'Petty Cash');
		$result[] = array('y' => $res->income_cash, 'legendText' => 'Income Cash', 'label' => 'Income Cash');
	}
	return json_encode($result, JSON_PRETTY_PRINT);

}


function laseDaysSaleTotal() {
	global $wpdb;
	$sale_table = $wpdb->prefix. 'sale';

	$query ="SELECT days.day as label, 

		(CASE 
		 WHEN sl.sal_val Is Null
		 THEN 0
		 ELSE sl.sal_val
		 END
		) as y

		FROM ( select curdate() as day
		   union select curdate() - interval 1 day
		   union select curdate() - interval 2 day
		   union select curdate() - interval 3 day
		   union select curdate() - interval 4 day
		   union select curdate() - interval 5 day
		   union select curdate() - interval 6 day
		   union select curdate() - interval 7 day
		   union select curdate() - interval 8 day
		   union select curdate() - interval 9 day
		) days 

		LEFT JOIN 

		(SELECT SUM(s.sale_total) sal_val, s.invoice_date FROM ${sale_table} s WHERE s.active = 1 GROUP BY s.invoice_date ) sl

		ON sl.invoice_date = days.day ORDER BY days.day ASC";


	$res = $wpdb->get_results( $query );

	return json_encode($res, JSON_NUMERIC_CHECK );

}