<?php

$delivery_id = isset($_GET['delivery_id']) ? $_GET['delivery_id'] : 0;
$delivery_data = get_delivery_data($delivery_id);

$bill_id = isset($delivery_data['delivery_data']) ? $delivery_data['delivery_data']->sale_id : 0;
$bill_data = getBillDetail($bill_id);

if(isset($_GET['triger']) && $_GET['triger'] == 'print') {
	echo "<script>";
		echo "jQuery(document).ready(function(){print_current_page();});";
	echo "</script>";
}
?>
		<style type="text/css">
			body{-webkit-print-color-adjust:exact}
			.print_content{width:80%; margin: 0 auto;}
			.print_header{width:100%;float:left;margin:5px 0px}
			.header_inside{float:left}
			.info_bar{width:100%;float:left;font-size:13px}
			.customer_info_bar{width:50%;float:left;padding:0px 15px}
			.bill_info_bar{width:23%;float:right;padding:0px 15px}
			.customer_info_bar ul,.bill_info_bar ul{width:100%;padding:0px;margin:0px}
			.customer_info_bar ul li,.bill_info_bar ul li{list-style:none;margin-bottom:5px}
			.customer_info_bar span,.bill_info_bar span{font-size:14px;font-weight:bold}
			.customer_info_bar h4{margin:5px 0px}
			.table-simple{margin-top:15px;width:100%;/*min-height:350px;*/float:left}
			.display{width:95%;margin:0 auto;border-collapse:collapse}
			.table-simple table thead tr th{font-size:13px;background-color:#777e8c!important;padding:10px 0px;color:#fff;font-weight:bold;border-right:1px solid #ccc}
			.table-simple table thead tr th,.table-simple table tbody tr td{font-size:13px;text-align:center;border-left:1px solid #ccc;border-right:1px solid #ccc}
			.table-simple table tbody tr td{border-bottom:1px solid #ccc;padding:5px 10px}
			.stock_ck_avail_no{width:10px;border-radius:50%;background:#d51d29;color:#fff}
			.footer_addr{width:100%;padding:10px 0px;bottom:0;left:0;border-top:1px solid}


			.row {
				position: relative;
			}
			.row-no {
				color: #fff;
			    position: absolute;
			    left: 18px;
    			top: 8px;
			    font-size: 18px;
			}
			.type-original {
				width: 20px;
				height: 20px;
				background-color: #7d7f84;
				border-radius: 15px;
			}
			.type-duplicate {
				width: 18px;
				height: 18px;
				background-color: #7d7f84;
			}
			.type-health {
			    border-left: 10px solid transparent;
			    border-right: 10px solid transparent;
			    border-bottom: 18px solid #7d7f84;
			}
			.type-f {
				position: absolute;
				left: 0;
				left: 10px;
			}
			.first-col {
				width: 170px;
			}
		</style>
<script>
  function print_current_page() {
  	window.print();
  	//var printPage = window.open(document.URL, '_blank');
  	//setTimeout(printPage.print(), 5);
  }
</script>
		<div style="width: 100%;">
			<ul class="icons-labeled">
				<li>
					<a href="<?php echo menu_page_url( 'bill_delivery', 0 ).'&delivery_id='.$delivery_id.'&action=update'; ?>" ><span class="icon-block-color coins-c"></span>Update Delivery</a>
				</li>
				<li>
					<!-- <a href="<?php echo menu_page_url( 'new_bill', 0 ).'&bill_no='.$bill_no.'&action=invoice'; ?>" ><span class="icon-block-black print-c"></span>Print Delivery</a> -->
					<a href="javascript:print_current_page();" ><span class="icon-block-black print-c"></span>Print Delivery</a>
				</li>
			</ul>
		</div>
		<div class="widget-top">
			<h4>New Billing</h4>
		</div>
		<div class = "print_content">
			<div class = "print_header">
				<div style="width: 320px; margin: 0 auto; padding: 5px 0px; height: 75px;">
					<div class="header_inside"><img src="<?php echo get_template_directory_uri().'/inc/images/logo-login.png' ?>"/></div>
					<br/><br/>
				</div>
			</div>
			<div class="info_bar">
				<div class="customer_info_bar">
					<h4>Customer Information</h4>
					<ul>
						<?php $customer_name = ($bill_data['bill_data']->bill_from_to =='counter')? 'Counter Cash': $bill_data['customer_data']->name;?>
						<li><span>Name : </span><?php echo $customer_name; ?> </li>
						<li><span>Mobile : </span><?php echo $bill_data['customer_data']->mobile; ?></li>
						<li><span>Address : </span><?php echo $bill_data['customer_data']->address; ?> </li>
						<li><span>Delivery Date  : </span> <?php echo $delivery_data['delivery_data']->delivery_date; ?></li>
					</ul>
				</div>
				<div class="bill_info_bar">
					<ul>
						<li><span>Bill No : </span> <?php echo $bill_data['bill_data']->invoice_id; ?></li>
						<li><span>Bill Date : </span> <?php echo $bill_data['bill_data']->invoice_date; ?></li>
						<li><span>Customer Type : </span> <?php echo $bill_data['bill_data']->customer_type; ?></li>
						<li><span>Shop Name  : </span><?php echo ($bill_data['bill_data']->order_shop == 'rice_center')?'Saravana Rice Center':  'Saravana Rice Mandy'; ?></li>
					</ul>
				</div>
			</div>
			<div style="clear:both;"></div>
			<div style="clear:both;"></div>
			<h3 style="margin-top:30px;margin-bottom:0px;text-align:center;">Item Delivery</h3>
			<div class="table-simple">
				<table class="display" style="width: 600px;">
					<thead>
						<tr>
							<th class="first-col">S.No</th>
							<th>Product</th>
							<th>Delivery Weight</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(isset($delivery_data['delivery_detail']) AND count($delivery_data['delivery_detail'])>0 ) {
							$i=0;
							foreach ($delivery_data['delivery_detail'] as $i_value) {
								$i++;
					?>
						<tr>
							<td><?php echo $i; ?></td>
							<td class="row">
								<?php echo $i_value->lot_number; ?>
							</td>
							<td><?php echo $i_value->delivery_weight; ?></td>
						</tr>
					<?php
							}
						}

					?>
						<tr>
							<td colspan="2">
								<label>Bill Amount &nbsp;(Rs)</label>
							</td>
							<td><?php echo $bill_data['bill_data']->sale_total; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="clear: both;"></div>
			<div class="footer_addr" style="margin-top:10px;">
				<div style="width: 72%; margin: 0 auto;">
					Saravana Rice Centre - No : 29, Test Nagar, Testing Street, Chennai - 17.
				</div>
			</div>
		</div>

<?php 
//Printing
	include( get_template_directory().'/inc/admin/sales/delivery/delivery_print/print_template.php' ); 
?>