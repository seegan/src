<?php

$bill_no = isset($_GET['bill_no']) ? $_GET['bill_no'] : $_GET['inv_id'];
$bill_data = getBillDetail($bill_no);
$bill_return_data = getBillReturnDetail($bill_no);


$bill_original = '<div class="type-f type-original"></div>';
$bill_duplicate = '<div class="type-f type-duplicate"></div>';
$bill_healthcenter = '<div class="type-f type-health"></div>';
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

		<div class = "print_content">
			<div class = "print_header">
				<div style="width: 320px; margin: 0 auto; padding: 5px 0px; height: 75px;">
					<div class=header_inside><img src="<?php echo get_template_directory_uri().'/inc/images/logo-login.png' ?>"/></div>
					<br/><br/>
				</div>
			</div>
			<div class=info_bar>
				<div class=customer_info_bar>
					<h4>Customer Information</h4>
					<ul>
						<li><span>Name : </span><?php echo $bill_data['customer_data']->name; ?> </li>
						<li><span>Mobile : </span><?php echo $bill_data['customer_data']->mobile; ?></li>
						<li><span>Address : </span> <?php echo $bill_data['customer_data']->address; ?></li>
						<li><span>Delivery Option : </span> -</li>
					</ul>
				</div>
				<div class=bill_info_bar>
					<ul>
						<li><span>Bill No :</span> <?php echo $bill_data['bill_data']->invoice_id; ?></li>
						<li><span>Bill Date :</span><?php echo $bill_data['bill_data']->invoice_date; ?></li>
					</ul>
				</div>
			</div>
			<div style="clear:both;"></div>


			<?php
			//var_dump($bill_data['bill_detail_data']);
			if(isset($bill_return_data['bill_detail_data']) AND count($bill_return_data['bill_detail_data'])>0 ) {
			?>
			<h3 style="margin-bottom:0px;">Item Returned</h3>
			<div class=table-simple>
				<table class=display>
					<thead>
						<tr>
							<th class="first-col">Lot.No</th>
							<th>Unit Price</th>
							<th>Product Name</th>
							<th>Discount Price</th>
							<th>Net Weight</th>
							<th>Sale Option</th>
							<th>Price</th>
						</tr>
					</thead>
					<tbody>
					<?php
							$i=0;
							foreach ($bill_return_data['bill_detail_data'] as $r_value) {
								$i++;
					?>
						<tr>
							<td class="row">
								<?php 
									if($r_value->bill_from == 'health_store') {
										echo $bill_healthcenter;
									} elseif ($r_value->bill_from == 'out_stock') {
										echo $bill_duplicate;
									} else {
										echo $bill_original;
									}
								?>
							<?php echo $r_value->lot_number; ?>
								

							</td>
							<td><?php echo $r_value->basic_price; ?></td>
							<td>
								<?php echo $r_value->product_name; ?>
								<?php
									if($r_value->brand_display === '1') {
										echo "<small>( ".$r_value->brand_name." )</small>";
									}
								?>

							</td>
							<td><?php echo $i_value->unit_price; ?></td>
							<td>
								<strong><?php echo (float) $r_value->sale_weight; ?></strong>
							</td>
							<td style="width: 15%;">
								<?php echo $r_value->sale_type; ?>
							</td>
							<td><?php echo $r_value->sale_value; ?></td>
						</tr>

					<?php
							}

					?>
					</tbody>
				</table>
			</div>
			<?php
			}
			?>


			<div style="clear:both;"></div>
			<h3 style="margin-top:30px;margin-bottom:0px;">Item Ordered</h3>
			<div class=table-simple>
				<table class=display>
					<thead>
						<tr>
							<th class="first-col">Lot.No</th>
							<th>Unit Price</th>
							<th>Product Name</th>
							<th>Discount Price</th>
							<th>Net Weight</th>
							<th>Sale Option</th>
							<th>Price</th>
						</tr>
					</thead>
					<tbody>
					<?php
					//var_dump($bill_data['bill_detail_data']);
						if(isset($bill_data['bill_detail_data']) AND count($bill_data['bill_detail_data'])>0 ) {
							$i=0;
							foreach ($bill_data['bill_detail_data'] as $i_value) {
								$i++;
					?>
						<tr>
							<td class="row">
							<?php 
									//echo '<div class="row-no">'.$i.'</div>';
									if($i_value->bill_from == 'health_store') {
										echo $bill_healthcenter;
									} elseif ($i_value->bill_from == 'out_stock') {
										echo $bill_duplicate;
									} else {
										echo $bill_original;
									}
								?>
							<?php echo $i_value->lot_number; ?>
								
							</td>
							<td><?php echo $i_value->basic_price; ?></td>
							<td>
								<?php echo $i_value->product_name; ?>
								<?php

									if($i_value->brand_display === '1') {
										echo "<small>( ".$r_value->brand_name." )</small>";
									}
								?>

							</td>
							<td><?php echo $i_value->unit_price; ?></td>
							<td>
								<strong><?php echo (float) $i_value->sale_weight; ?></strong>
							</td>
							<td style="width: 15%;">
								<?php echo $i_value->sale_type; ?>
							</td>
							<td><?php echo $i_value->sale_value; ?></td>
						</tr>

					<?php
							}
						}

					?>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td colspan="2">
								<label>Actual Total &nbsp;(Rs)</label>
							</td>
							<td><?php echo $bill_data['bill_data']->sale_value; ?></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td colspan="2">
								<label>Discount &nbsp;(Rs)</label>
							</td>
							<td><?php echo $bill_data['bill_data']->sale_discount_price; ?></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td colspan="2">
								<label>Card Swipping Fee &nbsp;(Rs)</label>
							</td>
							<td><?php echo $bill_data['bill_data']->sale_card_swip; ?></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td colspan="2">
								<label><strong>Total &nbsp;(Rs)</strong></label>
							</td>
							<td>
								<strong><?php echo $bill_data['bill_data']->sale_total; ?></strong>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="clear: both;"></div>
			<div class=footer_addr>
				<div style="width: 72%; margin: 0 auto;">
					Saravana Rice Centre - No : 29, Test Nagar, Testing Street, Chennai - 17.
				</div>
			</div>
		</div>