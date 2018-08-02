<style type="text/css">
  @media screen {
    .A4 {
      display: none;
    }

  }
  /** Fix for Chrome issue #273306 **/
  @media print {
    #adminmenumain, #wpfooter, .print-hide,.icons-labeled,.print_content,.widget-top,.screen-meta,.my-button{
      display: none;
    }
    body, html {
      height: auto;
      padding:0px;
    }
    html.wp-toolbar {
      padding:0;
    }
    #wpcontent {
      background: white;  
      margin: 1mm;
      display: block;
      padding: 0;
    }

  }


</style>

<!DOCTYPE html>
<html>
<head>
  

<meta charset="utf-8">
<style type="text/css">



  /** Fix for Chrome issue #273306 **/
  @page {
    size: A4;
    margin: 20px;
  }
  @media print {
    html, body {
      width: 210mm;
      height: 297mm;
      
    }

    /* ... the rest of the rules ... */
  }


	.footer table tr td {
      border: none;
    }

     .print-table {
      padding-top: 5mm;
      font-size: 16px;
    }
    .print-table hr {
      color: #000;
    }
    .print-table tr td {
      border: 1px solid #000;
      padding: 5px;

    }
    .print-table table {
      color: #000;
      /*border-collapse: collapse;*/
    }
    .declare_section {
      padding-top: 20px;
      padding-left: 30px;
    }
    .text_bold {
      font-weight: 600;

    }
    .text_center {
      text-align: center;
    }


     table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
	.exempted span{
	  margin-left: 45%;
	  font-size: 18px;
	}
 
    .sheet {
      margin: 0;
    }
    
    .inner-container {
      padding-left: 0mm;
            
      width: 210mm;
    }      
    

/*  New Format csss */
   
</style>
<!-- New Table -->

<div class="A4 page-break">
<div class=" print-table">
    <div class="sheet padding-10mm">

    <div class="inner-container" >
      <table class="customer-detail" style="margin-top: 20px;margin-bottom:2px;  border-collapse: collapse; " >
        <tbody>
            <tr>
                <td colspan="12" style="text-align: center; font-weight: bold; font-size: 22px;"  ><b>TAX INVOICE</b></td>
            </tr>
            <tr style="text-align: left;" >
                <td colspan="<?php if($bill_data['bill_data']->gst_to == 'cgst') { echo '6'; }else if($bill_data['bill_data']->gst_to == 'igst') { echo '6'; } else { echo '6'; }?>">
                  <p><strong>Saravana Rice Centre</strong>
                <br/>Adyar
                <br/>Chennai
                <br/>Cell : 142536374
                <br/>GST No : FGFGSA0127127</p>
                </td>
                <td colspan="<?php if($bill_data['bill_data']->gst_to == 'cgst') { echo '6'; }else if($bill_data['bill_data']->gst_to == 'igst') { echo '6'; } else { echo '6'; }?>">
                  <b>INVOICE NO - <?php echo $bill_data['bill_data']->invoice_id; ?><br> 
                  DATE - <?php echo $bill_data['bill_data']->invoice_date; ?></b>
                  <hr>
                  <b>STATE             : TAMILNADU <br> 
                  STATE CODE : 33 </b></td>
            </tr>
             <tr >

                <td colspan="<?php if($bill_data['bill_data']->gst_to == 'cgst') { echo '6'; }else if($bill_data['bill_data']->gst_to == 'igst') { echo '6'; } else { echo '6'; }?>">
                  <b>Buyer,</b><br>
                  <?php $customer_name = ($bill_data['bill_data']->bill_from_to =='counter')? 'Counter Cash': $bill_data['customer_data']->name;?>
                  <b><?php echo $customer_name; ?></b><br>
                  <?php echo $bill_data['customer_data']->mobile; ?><br>
                  <?php echo $bill_data['customer_data']->mobile1;  ?><br>
                  <?php echo $bill_data['customer_data']->address;  ?><br>
                  <b> GST NO <?php echo "EWEWEW131313" ?></b>
                </td>                 
                <td colspan="<?php if($bill_data['bill_data']->gst_to == 'cgst') { echo '6'; }else if($bill_data['bill_data']->gst_to == 'igst') { echo '6'; } else { echo '6'; }?>">
                  <b>DELIVERY ADDRESS</b><br>
                  <?php echo $customer_name; ?><br>
                  <?php echo $bill_data['customer_data']->mobile1; ?><br>
                  <?php echo $bill_data['customer_data']->address; ?><br>
                </td>                
            </tr>
           <?php
					if($bill_data['bill_data']){
						if($bill_data['bill_data']->gst_to == 'cgst' ){
							echo '<style>.igst_td{
									display:none;
								}</style>';
						}
						else if($bill_data['bill_data']->gst_to == 'igst') {
							echo '<style>.cgst_td{
										display:none;
								}</style>';
						}
						else{
							echo '<style>
									.cgst_td{
										display:none;
										}
									.igst_td{
										display:none;
										}
										.yes_gst{
											display:none;
										}	
								</style>';
						}
					}


					 ?>
			   
				<tr class="text_bold text_center">
				  <td rowspan="2">Lot. No</td>
				  <td rowspan="2">HSN CODE</td>
				  <td rowspan="2" style="width: 200px;">PRODUCTS</td>
				  <td rowspan="2">QTY</td>
				  <td rowspan="2">MRP Per Piece</td>
				  <td rowspan="2">Discounted Price</td>
				  <td rowspan="2" class="yes_gst">AMOUNT</td>
				  <td colspan="2" class="cgst_td">CGST</td>
				  <td colspan="2" class="cgst_td">SGST</td>
				  <td colspan="2" class="igst_td">IGST</td>
				  <td colspan="2" >TOTAL</td>
				</tr>
				<tr class="text_bold text_center">
				  <td class="cgst_td">RATE</td>
				  <td class="cgst_td">AMOUNT</td>
				  <td class="cgst_td">RATE</td>
				  <td class="cgst_td">AMOUNT</td>
				  <td class="igst_td">RATE</td>
				  <td class="igst_td">AMOUNT</td>
				  <td class="yes_gst" >AMOUNT</td>
				</tr>
				

					<?php
						 
						if(isset($bill_data['bill_detail_data']) AND count($bill_data['bill_detail_data'])>0 ) {
							$i=0;
							foreach ($bill_data['bill_detail_data'] as $value) {
								$i++;
					?>


				<tr class=" text_center">
					<td>
					    <?php
					       	if($value->brand_display === '1') {
					          echo $value->brand_name;
					        } else {
					          echo $value->lot_number; 
					        }
					    ?>
					</td>
					<td><?php echo $value->hsn_code; ?></td>
					<td>
						<?php 
							echo $value->product_name;
					 	?>
					</td>
					<td><?php echo (float) $value->sale_weight; ?></td>                
					<td><?php echo $value->basic_price; ?></td>
					<td><?php echo $value->unit_price; ?></td>
					<td><?php echo $value->taxless_amt; ?></td>
					<td class="cgst_td" ><?php echo $value->cgst_percentage; ?></td>
					<td class="cgst_td" ><?php echo $value->cgst_value; ?></td>
					<td class="cgst_td" ><?php echo $value->sgst_percentage; ?></td>
					<td class="cgst_td" ><?php echo $value->sgst_value; ?></td>
					<td class="igst_td" ><?php echo $value->igst_percentage; ?></td>
					<td class="igst_td" ><?php echo $value->igst_value; ?></td>
					<td class="yes_gst"><?php echo $value->sale_value; ?></td>                
				</tr>
				<?php
				}

				?>   
				<tr>
				  <td colspan="<?php if($bill_data['bill_data']->gst_to == 'cgst') { echo '11'; }else if($bill_data['bill_data']->gst_to == 'igst') { echo '9'; } else { echo '6'; }?>" style=" text-align: right;" ><div  >Total (Hire Charges)</div></td>
				  <td>
					<div class="text-center"> 
					  <?php echo $bill_data['bill_data']->sale_value; ?>
					  
					</div>
				  </td>
				</tr> 
				<!-- <tr>
				  <td colspan="<?php //if($bill_data['bill_data']->gst_to == 'cgst') { echo '11'; }else if($bill_data['bill_data']->gst_to == 'igst') { echo '9'; } else { echo '6'; }?>" style=" text-align: right;" ><div  >Discount (Hire Charges)</div></td>
				  <td>
					<div class="text-center"> 
					  <?php //echo $bill_data['bill_data']->sale_discount_price; ?>
					  
					</div>
				  </td>
				</tr> -->
				<tr>
				  <td colspan="<?php if($bill_data['bill_data']->gst_to == 'cgst') { echo '11'; }else if($bill_data['bill_data']->gst_to == 'igst') { echo '9'; } else { echo '6'; }?>" style=" text-align: right;" ><div  >Card Swipping Fee  (Rs)</div></td>
				  <td>
					<div class="text-center"> 
					  <?php echo $bill_data['bill_data']->sale_card_swip; ?>
					  
					</div>
				  </td>
				</tr> 
				<tr>
				  <td colspan="<?php if($bill_data['bill_data']->gst_to == 'cgst') { echo '11'; }else if($bill_data['bill_data']->gst_to == 'igst') { echo '9'; } else { echo '6'; }?>" style=" text-align: right;" ><div  >Final Total  (Rs)</div></td>
				  <td>
					<div class="text-center"> 
					  <?php echo $bill_data['bill_data']->sale_total; ?>
					  
					</div>
				  </td>
				</tr>                      

				<?php
				 $final_total = $bill_data['bill_data']->sale_total;
				?>
					
				<?php
				  

				?>
				 <?php
				}
			  ?>
				<tr>
					<td colspan="<?php if($bill_data['bill_data']->gst_to == 'cgst') { echo '12'; }else if($bill_data['bill_data']->gst_to == 'igst') { echo '12'; } else { echo '7'; }?>" style="text-align: left;">Amount Chargable ( In Words)  <b> <?php echo ucfirst(convert_number_to_words_full($final_total)); ?></b></td>
				</tr>

			  </tbody>
			</table>
			</div>

			<?php 
			if(isset($gst_data)) {
			  $total_tax=0;
			  foreach( $gst_data as $g_data) {
				$total_tax = (  $g_data->sale_igst) +$total_tax;
				$gst_tot = $g_data->sale_igst + $gst_tot;
			  }
			  if($gst_tot == '0.00'){
				echo "<div class='exempted'><span><b>GST EXEMPTED</span></b></div>";
			  }
			} 
			
		  ?>
		  <!-- TAX TABLE START -->
		<?php 
	  		if($bill_data['bill_data']->gst_to == 'cgst' ||  $bill_data['bill_data']->gst_to == 'igst'){ 
	  			if($bill_data['bill_data']->gst_to == 'cgst') { ?>
			
			<div class="inner-container" > 
			<table  class="customer-detail" style="margin-top: 20px;margin-bottom:2px; text-align: center;  border-collapse: collapse; ">
			  <tbody>
				<tr class="text_bold text_center" >                
					<td rowspan="2">TAXABLE VALUE</td>
					<td colspan="2">CENTRAL SALES TAX</td>
					<td colspan="2">STATE SALES TAX</td>                
				</tr>
				<tr class="text_bold text_center">                
					
					<td>RATE</td>
					<td>AMOUNT</td>
					<td>RATE</td>
					<td>AMOUNT</td>                
				</tr>
				<?php  
				if(isset($gst_data)) { 
				  $total_tax=0;
				  foreach( $gst_data['gst_data'] as $g_data) {
			   ?>
					<tr class="">
					  <td class="amt_zero">Rs. <?php  echo $g_data->sale_amt; ?></td>
					  <td class="cgst_zero"><?php echo $g_data->cgst_percentage; ?> % </td>
					  <td class="cgst_val_zero"><?php echo $g_data->sale_cgst; ?></td>
					  <td class="sgst_zero"><?php echo $g_data->cgst_percentage; ?> % </td>
					  <td class="sgst_val_zero"><?php echo $g_data->sale_sgst; ?></td>
					</tr>
					<?php $total_tax = ( 2 * $g_data->sale_sgst) +$total_tax;
					}
				  } 
				?>
				<tr>
					<td class="text_center" colspan="4" ><b>TOTAL  TAX</b></td>                
					<td><b><?php echo $total_tax; ?></b></td>                
				</tr>
				<tr>   
				  <td colspan="12" style="text-align: left;" ><b>Tax Amount (in words) : <?php echo ucfirst(convert_number_to_words_full($total_tax)); ?>  </b></td>
				</tr>
			  </tbody>
			</table>
			</div>
		<?php }  else { ?>
		<div class="inner-container" > 
			<table  class="customer-detail" style="margin-top: 20px;margin-bottom:2px; text-align: center;  border-collapse: collapse; ">
			  <tbody>
				<tr class="text_bold text_center" >                
					<td rowspan="2">TAXABLE VALUE</td>
					<td colspan="2">SALES TAX</td>
					
				</tr>
				<tr class="text_bold text_center">                
					
					<td>RATE</td>
					<td>AMOUNT</td>              
				</tr>
				<?php  

				if(isset($gst_data)) { 
				  $total_tax=0;
				  foreach( $gst_data['gst_data'] as $g_data) {
			   ?>
					<tr class="">
					  <td class="amt_zero">Rs. <?php  echo $g_data->sale_amt; ?></td>
					  <td class="cgst_zero"><?php echo $g_data->igst_percentage; ?> % </td>
					  <td class="cgst_val_zero"><?php echo $g_data->sale_igst; ?></td>
					</tr>
					<?php $total_tax = ($g_data->sale_igst) +$total_tax;
					}
				  } 
				?>
				<tr>
					<td class="text_center" colspan="2" ><b>TOTAL  TAX</b></td>                
					<td><b><?php echo $total_tax; ?></b></td>                
				</tr>
				<tr>   
				  <td colspan="12" style="text-align: left;" ><b>Tax Amount (in words) : <?php echo ucfirst(convert_number_to_words_full($total_tax)); ?>  </b></td>
				</tr>
			  </tbody>
			</table>
			</div>
				<?php }
			} ?> 
			<!-- TAX TABLE END  -->
			<style type="text/css">
	      .customer-signature, .company-signature {
			width: 85mm;
		  }
		</style>

		  <div class="footer" style="margin-bottom:20px;">
			  <div class="" style="margin-top: 10px;">

				<table>
				  <tr >
					<td colspan="2">
					  <b><u>Declaration</u></b>
					  <div style="margin-bottom:10px;text-align:left">We declare that  this  invoice  shows  the  actual price of the goods described and that all particulars are true and correct</div>
					</td>
				  </tr>
				  <tr >
					<td>
					  <div class="customer-signature">
						<div class="company-name" style="font-family: serif;font-weight: bold;font-size: 16px;text-align:left">
						  Customer Seal & Signature
						</div>
						<div style="height: 80px;"></div>
					  </div>
					</td>
					<td>
					  <div class="company-signature">
						<div class="company-name" style="font-family: serif;font-weight: bold;font-size: 16px;text-align:right;">
						   For Saravana Rice Centre 
						</div>
						<div style="margin-top: 60px;text-align:right;">Authorised Signatory</div>
					  </div>
					</td>
				  </tr>
				</table>

			  </div>
		  </div>
	  </div>
	</div>
</div>







 <!--  <div class="A4">
	<div class="sheet padding-10mm">
	


	</div>
  </div> -->




