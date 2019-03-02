
<?php
  $gst_extemted = 0;
if($bill_data['bill_data']->gst_to == 'cgst'){
  foreach( $gst_data['gst_data'] as $g_data) {
    $gst_extemted = $g_data->sale_sgst + $gst_extemted;
  }

} else if($bill_data['bill_data']->gst_to == 'igst'){
  foreach( $gst_data['gst_data'] as $g_data) {
    $gst_extemted = $g_data->sale_igst + $gst_extemted;
  }
} else {
  $gst_extemted  = 0;
}
 ?>



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
     .dotted_border_top  {
        border-top: 1px dashed #000;        

      }
      .dotted_border_bottom  {        
        border-bottom: 1px dashed #000;
      }
      .td_class{
        font-weight: 700;
      }

.strikethrough {
  position: relative;
}
.strikethrough:before {
  position: absolute;
  content: "";
  left: 0;
  top: 50%;
  right: 0;
  border-top: 1px solid;
  border-color: inherit;

  -webkit-transform:rotate(-70deg);
  -moz-transform:rotate(-70deg);
  -ms-transform:rotate(-70deg);
  -o-transform:rotate(-70deg);
  transform:rotate(-70deg);
}
</style>   
 <div class="A4_HALF strikethrough">
  <div class="sheet padding-10mm">
    <?php
      if($bill_data) {
    ?>
     <b><h1 style="text-align: center;">CANCELLED BILL</h1></b>
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
    <table cellspacing='3' cellpadding='3' WIDTH='100%'>
      <tr>
        <td valign='top' WIDTH='65%'>Inv No : <b><?php echo $bill_data['bill_data']->invoice_id; ?></b></td>
        <td valign='top' WIDTH='100%'>Date : <?php $timestamp = machine_to_man_date($bill_data['bill_data']->invoice_date); 
        $splitTimeStamp = explode(" ",$timestamp);
        echo $date = $splitTimeStamp[0];?></td>    
      </tr>
      <tr>
        <!-- <td valign='top' WIDTH='30%'>Date : <?php echo date("d/m/Y"); ?></td> -->
        <td valign='top' WIDTH='30%'> </td>
      </tr>
    </table>
    <table cellspacing='3' cellpadding='3' WIDTH='100%' class="table table-striped" >
      <tr>
        <th class="dotted_border_top dotted_border_bottom text-center"  valign='top'>NO</th>
        <th class="dotted_border_top dotted_border_bottom text-center"  valign='top'>Products</th>
        <th class="dotted_border_top dotted_border_bottom text-center"  valign='top'>Units</th>
        <th class="dotted_border_top dotted_border_bottom text-center"  valign='top'>TOTAL</th>
      </tr>
      <tr>

      </tr>
     <?php
            if(isset($bill_data['bill_detail_data']) AND count($bill_data['bill_detail_data'])>0 ) {
              $i=0;
              foreach ($bill_data['bill_detail_data'] as $value) {
                $unit_type_arr = getUnitType($value->unit_type);

                $slab_type = ($value->slab == 1) ? $unit_type_arr['single'] : $unit_type_arr['batch'];
                $sale_weight = ($value->slab == 1) ? $value->sale_weight : $value->bag_count;
                $i++;
        ?>    
      <tr>
        <td valign='top' class="dotted_border_bottom" align='center'><?php echo $i; ?></td>
        <td valign='top' class="dotted_border_bottom" align='left'>
          <span class="td_class">
        <?php
          if($value->brand_display === '1') {
            echo $value->brand_name;
          } else {
            echo $value->lot_number; 
          }
          echo '<span style="float:right;">'.$value->price_orig_hidden.'</span></span>';
          echo "<br>(".$value->product_name.")&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          echo  $value->unit_price.' x '.(float) $sale_weight.$slab_type ;
        ?>
        </td>
        <td valign='top' class="dotted_border_bottom">
          <span style="font-size: 12px;"><?php echo '<b>'.bagKgSplitter($value->sale_weight, $value->bag_weight, $value->unit_type).'</b>'; ?></span>
        </td>
        <td valign='top' class="dotted_border_bottom" align='right'><br><?php echo $value->sale_value; ?></td></tr>
      </tr>
      <?php
          }
        } 
        ?> 

     
    </table>


      <table cellspacing='3' cellpadding='3' WIDTH='100%' class="table table-striped">
       <tr> 
         <td class=" " colspan="6" valign='top' align='center'><b>AMOUNT</b></td>
         <td  class=" " valign='top' align='right'><span class="amount"> <?php echo '<b>'.$bill_data['bill_data']->sale_value.'</b>'; ?></span></td>
      </tr>
      <tr> 
         <td class=" dotted_border_bottom" colspan="6" valign='top' align='center'><b>Round Off</b></td>
         <td  class=" dotted_border_bottom" valign='top' align='right'><span class="amount"><?php echo '<b>'.$bill_data['bill_data']->round_off_value.'</b>'; ?></span></td>
      </tr>
      <tr> 
         <td class=" dotted_border_bottom" colspan="6" valign='top' align='center'><b>TOTAL AMOUNT</b></td>
         <td  class=" dotted_border_bottom" valign='top' align='right'><span class="amount"><?php echo '<b>'.$bill_data['bill_data']->sale_total.'</b>'; ?></span></td>
      </tr>
     
    </table>

          <?php
            }
          ?>
   <br/>           
				<?php 
        if($gst_extemted == 0) {
          echo "<div class='exempted'><span><b>GST EXEMPTED</span></b></div>";
        }
        ?>
       
        
      <?php if($bill_data['bill_data']->gst_to == 'cgst'){ ?>
    <table WIDTH='100%' class="table table-striped" style="font-size:15px;">
        <thead>
            <tr>
                <th class="dotted_border_bottom">HSN Code</th>
                <th class="dotted_border_bottom">Taxable Value</th>
            </tr>
        </thead>
        <tbody>
            <?php  
      if(isset($gst_data)) { 
        foreach( $gst_data['gst_data'] as $g_data) {
      ?>
            <tr>
                <td><div class="text-center"><?php  echo $g_data->hsn_code; ?></div></td>
                <td><div class="text-center"><?php  echo $g_data->sale_amt; ?></div></td>
            </tr>
        <?php 
        }
      }
    ?>
        </tbody>
    </table>
     <br/> 
     <table cellspacing='3' cellpadding='3' WIDTH='100%' class="table table-striped" style="font-size:15px;" >
      <thead>
        <tr>
          <th colspan="4" class="dotted_border_bottom"  align="center" >GST Details</th>
        </tr>     
        <tr>
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
          $total_tax    = 0;
          $gst_tot      = 0;
        foreach( $gst_data['gst_data'] as $g_data) {
      ?>
          <tr class="">
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

      <tr>
        <td  class="dotted_border_bottom" colspan="3">
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
            <div class="text-center">Hsn Code</div>
          </th>
           <th valign='top' class="center-th" style="padding:0;" rowspan="2">
            <div class="text-center">Taxable Value(Rs)</div>
          </th>
          <th class="center-th" style="padding: 0;" colspan="2">
            <div class="text-center">IGST</div>
          </th>
        </tr>
        <tr>
          <th style="padding: 0;" colspan="2"><div class="text-center">%</div></th>
          <th style="padding: 0;" colspan="2"><div class="text-right">Amt(Rs)</div></th>
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
            <td class=""><div class="text-center"><?php  echo $g_data->hsn_code; ?></div></td>
            <td class=""><div class="text-center"><?php  echo $g_data->sale_amt; ?></div></td>
            <td class="" colspan="2"><div class="text-center"><?php echo $g_data->igst_percentage; ?></div></td>
            <td class="" colspan="2"><div class="text-right"><?php echo $g_data->sale_igst; ?></div></td>
          </tr>
           <?php 
           $total_tax = ($g_data->sale_igst) +$total_tax;
           $gst_tot = $g_data->sale_igst + $gst_tot;

        }
      } ?>
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
    <tr><td>Name</td><td>  : <?php echo $bill_data['bill_data']->delivery_name; ?></td></tr>
    <tr><td>Address</td><td>  : <?php echo $bill_data['bill_data']->delivery_address; ?></td></tr>
    <tr><td>Phone No</td><td>  : <?php echo $bill_data['bill_data']->delivery_phone; ?></td></tr>
  </table> 
  <?php }
  if($bill_data['bill_data']->cancel_reason!=''){
    echo '<br/><b>REASON FOR CANCELLED :</b> <br>'.$bill_data['bill_data']->cancel_reason;

  } ?>

  </div>
<div>
 
  <br/>
</div>
</div>

