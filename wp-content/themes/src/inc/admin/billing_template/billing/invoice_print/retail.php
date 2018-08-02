<style type="text/css" >

	
	  @media screen {
    .A4_HALF .footer {
      bottom: 0px;
      left: 0px;
    }
    .A4_HALF{
      display: none;
    }
    .A4_HALF .footer .foot {
        background-color: #67a3b7 !important;
        -webkit-print-color-adjust: exact;
    }

  }
  /** Fix for Chrome issue #273306 **/
  @media print {
   #adminmenumain, #wpfooter, .print-hide,.icons-labeled,.print_content,.widget-top,.screen-meta,.my-button {
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




    .A4_HALF .footer {
      position: fixed;
      bottom: 0px;
      left: 0px;
    }
    .A4_HALF .footer .foot {
        background-color: #67a3b7 !important;
        -webkit-print-color-adjust: exact;
    }

    .text-right {
      text-align: right;
    }
  }

      @page { margin: 0;padding: 0; }
      .sheet {
        margin: 0;
        font-size: 14px
      }


      .A4_HALF {
        width: 100mm;
      }
      .inner-container {
        padding-left: 20mm;
        padding-right: 20mm;
        width: 100mm;

      }

      .left-float {
        float: left;
      }

      .text-center {
        text-align: center;
      }
      .text-rigth {
        text-align: right;
      }
      .table td, .table th {
        background-color: transparent !important;
      }


      .table>tbody>tr>td {
        padding: 0 3px;
        height: 20px;
      }
      .table-bordered>tbody>tr>td, .table-bordered>thead>tr>th {
        border: 1px solid #000 !important;
        -webkit-print-color-adjust: exact;
      }

      .A4_HALF h3 {
        margin-top: 10px;
      }
      .exempted span{
        margin-left: 40%;
        font-size: 14px;
      }
    .text-right {
      text-align: right;
    }
</style>   
 <div class="A4_HALF">
  <div class="sheet padding-10mm">
    <?php
      if($bill_data) {
    ?>
    <table cellspacing='3' cellpadding='1' WIDTH='100%' >
      <tr class="text-center" >
        <td valign='top' WIDTH='50%'>
            <strong><?php echo "Saravana Rice Centre";  ?></strong>
            <span style=" font-size: 13px;line-height:12px; " ><br/><?php echo"Adyar";  ?>
            <br/><?php echo 'Chennai';  ?>    
            <br/>PH : <?php echo '142536374'; ?>
            <br/>GST No : <?php echo 'FGFGSA0127127';  ?></span>
        </td>
      </tr>
    </table>

    <table cellspacing='3' cellpadding='3' WIDTH='100%' >
      <tr><?php $customer_name = ($bill_data['bill_data']->bill_from_to =='counter')? 'Counter Sale': $bill_data['customer_data']->name;?>
        <td valign='top' WIDTH='50%'>Customer : <?php echo $customer_name; ?> </td>         
        <td valign='top' WIDTH='50%'>Address : <?php echo $bill_data['customer_data']->address;?></td>         
      </tr>
      <tr>        
        <td valign='top' WIDTH='50%'>Phone No :<?php echo $bill_data['customer_data']->mobile;  ?> </td>     
      </tr>
      
    </table>
    <div class="text-center" >CASH BILL</div>
    <table cellspacing='3' cellpadding='3' WIDTH='100%' >
      <tr>
        <td valign='top' WIDTH='70%'>Inv No : <b><?php echo $bill_data['bill_data']->invoice_id; ?></b></td>
        <td valign='top' WIDTH='100%'>Date : <?php $timestamp = $bill_fdata->invoice_date; 
        $splitTimeStamp = explode(" ",$timestamp);
        echo $date = $splitTimeStamp[0];?></td>    
      </tr>
      
      <tr>
        <!-- <td valign='top' WIDTH='30%'>Date : <?php echo date("d/m/Y"); ?></td> -->
        <td valign='top' WIDTH='30%'> </td>
      </tr>
    </table>
    <style>
      .dotted_border_top  {
        border-top: 1px dashed #000;        

      }
      .dotted_border_bottom  {        
        border-bottom: 1px dashed #000;
      }
    </style>

    <table cellspacing='3' cellpadding='3' WIDTH='100%' class="table table-striped" >
      <tr>
        <th class="dotted_border_top dotted_border_bottom text-center"  valign='top'>SNO</th>
        <th class="dotted_border_top dotted_border_bottom text-center"  valign='top'>Lot No</th>
<!--         <th class="dotted_border_top dotted_border_bottom text-center"  valign='top' >MRP</th>
        <th class="dotted_border_top dotted_border_bottom text-center"  valign='top'>PRODUCT<br>NAME</th>
        <th class="dotted_border_top dotted_border_bottom text-center"  valign='top'>QTY</th>
        <th class="dotted_border_top dotted_border_bottom"  valign='top' align='center'>Dis.Rs</th> -->
        <th class="dotted_border_top dotted_border_bottom text-center"  valign='top'>TOTAL</th>
      </tr>
      <tr>

      </tr>
     <?php
             
            if(isset($bill_data['bill_detail_data']) AND count($bill_data['bill_detail_data'])>0 ) {
              $i=0;
              foreach ($bill_data['bill_detail_data'] as $value) {
                $i++;
        ?>
                
      <tr>
        <td valign='top' align='center'><?php echo $i; ?></td>
        <td valign='top' align='left'>
        <?php
          if($value->brand_display === '1') {
            echo $value->brand_name;
          } else {
            echo $value->lot_number; 
          }
          echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$value->price_orig_hidden;
          echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          echo  $value->unit_price.' x '.(float) $value->sale_weight;
        ?>
        </td>
        <!-- <td valign='top' align='center'><?php echo $value->price_orig_hidden; ?></td> -->
        <!-- <td valign='top' align='center'><?php echo $value->product_name ?></td> -->
        <!-- <td valign='top' align='center'></td> -->
        <!-- <td valign='top' align='left'><?php echo $value->unit_price; ?></td> -->
        <td valign='top' align='right'><?php echo $value->sale_value; ?></td></tr>
      </tr>
      <?php
          }
        } 
        ?> 

     
    </table>


      <table cellspacing='3' cellpadding='3' WIDTH='100%' class="table table-striped">
      <!-- <tr>
        <td valign='top' colspan="3" >No.Of.Items : 4    </td>
        <td valign='top'  align='right' >Total Qty : 10&nbsp;&nbsp;&nbsp;</td>
      </tr> -->
      
       <tr> 
         <td class="dotted_border_top " colspan="6" valign='top' align='center'><b>AMOUNT</b></td>
         <td  class="dotted_border_top " valign='top' align='right'><span class="amount"> <?php echo '<b>'.$bill_data['bill_data']->sale_value.'</b>'; ?></span></td>
      </tr>

     <!--  <tr> 
         <td class="dotted_border_top " colspan="6" valign='top' align='center'><b>DISCOUNT</b></td>
         <td  class="dotted_border_top " valign='top' align='right'>
            <span class="amount">           
            <?php echo $bill_data['bill_data']->sale_discount_price; ?>
          </span>
        </td>
      </tr> -->

      <tr> 
         <td class="dotted_border_top dotted_border_bottom" colspan="6" valign='top' align='center'><b>TOTAL AMOUNT</b></td>
         <td  class="dotted_border_top dotted_border_bottom" valign='top' align='right'><span class="amount"><?php echo '<b>'.$bill_data['bill_data']->sale_total.'</b>'; ?></span></td>
      </tr>
    </table>

          <?php
            }
          ?>
              
				
        <?php 

        if(isset($gst_data)) {
          $total_tax=0;
          foreach( $gst_data as $g_data) {
            $total_tax = ( $g_data->sale_igst) +$total_tax;
            $gst_tot = $g_data->sale_igst + $gst_tot;
          }
          if($gst_tot == '0.00'){
            echo "<div class='exempted'><span><b>GST EXEMPTED</span></b></div>";
          }
        } 
        
      ?>
      <?php if($bill_data['bill_data']->gst_to == 'cgst'){ ?>
          <table cellspacing='3' cellpadding='3' WIDTH='100%' class="table table-striped" style="font-size:15px;" >
      <thead>
        <tr>
          <th colspan="5" class="dotted_border_bottom"  align="center" >GST Details</th>
        </tr>     
        <tr>
          <th valign='top' class="center-th" style="width:90px;padding:0;" rowspan="2">
            <div class="text-center">Taxable Value(Rs)</div>
          </th>
          <th class="center-th" style="padding: 0;" colspan="2">
            <div class="text-center">CGST</div>
          </th>
          <th class="center-th" style="padding: 0;" colspan="2">
            <div class="text-center">SGST</div>
          </th>
        </tr>
        <tr>
          <th style="padding: 0;width: 70px;"><div class="text-center">%</div></th>
          <th style="padding: 0;width: 70px;"><div class="text-right">Amt. (Rs)</div></th>
          <th style="padding: 0;width: 70px;"><div class="text-center">%</div></th>
          <th style="padding: 0;width: 70px;"><div class="text-right">Amt. (Rs)</div></th>
        </tr>
      </thead>
      <tbody>


      <?php  
      if(isset($gst_data)) { 
          $total_tax=0;
          $gst_tot=0;
        foreach( $gst_data['gst_data'] as $g_data) {
      ?>
          <tr class="">
            <td class=""><div class="text-right"><?php  echo $g_data->sale_amt; ?></div></td>
            <td class=""><div class="text-center"><?php echo $g_data->cgst_percentage; ?></div></td>
            <td class=""><div class="text-right"><?php echo $g_data->sale_cgst; ?></div></td>
            <td class=""><div class="text-center"><?php echo $g_data->cgst_percentage; ?></div></td>
            <td class=""><div class="text-right"><?php echo $g_data->sale_sgst; ?></div></td>
          </tr>
           <?php 
           $total_tax = ( 2 * $g_data->sale_sgst) +$total_tax;
           $gst_tot = $g_data->sale_sgst + $gst_tot;

        }
      }
    ?>
      <tr class="">
        <td class=""><div class="text-right"></div></td>
        <td class=""><div class="text-right"></div></td>
        <td class=""><div class="text-right"><?php echo $gst_tot; ?></div></td>
        <td class=""><div class="text-right"></div></td>
        <td class=""><div class="text-right"><?php echo $gst_tot; ?></div></td>
      </tr>
      <tr>
        <td  class="dotted_border_bottom" colspan="4">
          <div class="text-center">
            <b>Total Tax</b>
          </div>
        </td>
        <td class="dotted_border_bottom" >
          <div class="text-right">
           <b><?php echo $total_tax; ?></b>
          </div>
        </td>
      </tr>
      </tbody>
    </table>
     <?php  } else { ?>
    <table cellspacing='3' cellpadding='3' WIDTH='100%' class="table table-striped" style="font-size:15px;" >
      <thead>
        <tr>
          <th colspan="5" class="dotted_border_bottom"  align="center" >GST Details</th>
        </tr>     
        <tr>
          <th valign='top' class="center-th" style="padding:0;" rowspan="2">
            <div class="text-center">Taxable Value(Rs)</div>
          </th>
          <th class="center-th" style="padding: 0;" colspan="4">
            <div class="text-center">IGST</div>
          </th>
        </tr>
        <tr>
          <th style="padding: 0;" colspan="2"><div class="text-center">%</div></th>
          <th style="padding: 0;" colspan="2"><div class="text-right">Amount</div></th>
        </tr>
      </thead>
      <tbody>


      <?php  
      if(isset($gst_data)) { 
          $total_tax=0;
          $gst_tot=0;
        foreach( $gst_data['gst_data']as $g_data) {
      ?>
          <tr class="">
            <td class=""><div class="text-right"><?php  echo $g_data->sale_amt; ?></div></td>
            <td class="" colspan="2"><div class="text-center"><?php echo $g_data->igst_percentage; ?></div></td>
            <td class="" colspan="2"><div class="text-right"><?php echo $g_data->sale_igst; ?></div></td>
          </tr>
           <?php 
           $total_tax = ($g_data->sale_igst) +$total_tax;
           $gst_tot = $g_data->sale_igst + $gst_tot;

        }
      } ?>
      <tr class="">
        <td class="" colspan="4"><div class="text-right"></div></td>
        <td class=""><div class="text-right"><?php echo $gst_tot; ?></div></td>
      </tr>
      <tr>
        <td  class="dotted_border_bottom" colspan="4">
          <div class="text-center">
            <b>Total Tax</b>
          </div>
        </td>
        <td class="dotted_border_bottom" >
          <div class="text-right">
           <b><?php echo $total_tax; ?></b>
          </div>
        </td>
      </tr>
      </tbody>
    </table>
    <?php } ?>
    <div style="text-align: center;" >Thank You !!!. Visit Again !!!.</div>
    <?php $is_delivery = $bill_data['bill_data']->delivery_avail; 
    if($is_delivery == '1') { ?>
  <table>
    <tr><td><b>Delivery To</b></td><td>  </td></tr>
    <tr><td>Name</td><td>  : <?php echo $bill_data['customer_data']->name; ?></td></tr>
    <tr><td>Address</td><td>  : <?php echo $bill_data['customer_data']->address; ?></td></tr>
    <tr><td>Phone No</td><td>  : <?php echo $bill_data['customer_data']->mobile; ?></td></tr>
  </table> 
  <?php } ?>

  </div>
<div>
 
  <br/>
</div>
</div>

