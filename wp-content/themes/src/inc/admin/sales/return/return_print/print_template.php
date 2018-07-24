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
      <tr><?php $customer_name = ($bill_data['bill_data']->bill_from_to =='counter')? 'Counter Cash': $bill_data['customer_data']->name;?>
        <td valign='top' WIDTH='50%'>Customer : <?php echo $customer_name; ?> </td>         
        <td valign='top' WIDTH='50%'>Address : <?php echo $bill_data['customer_data']->address;?></td>         
      </tr>
      <tr>        
        <td valign='top' WIDTH='50%'>Phone No :<?php echo $bill_data['customer_data']->mobile;  ?> </td>     
      </tr>
      
    </table>
    <div class="text-center" >RETURN BILL</div>
    <table cellspacing='3' cellpadding='3' WIDTH='100%' >
      <tr>
        <td valign='top' WIDTH='65%'>Inv No : <b><?php echo $bill_data['bill_data']->invoice_id; ?></b></td>
        <td valign='top'>Date : <?php $timestamp = $bill_data['bill_data']->invoice_date; 
        $splitTimeStamp = explode(" ",$timestamp);
        echo $date = $splitTimeStamp[0];?></td>    
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
        <th class="dotted_border_top dotted_border_bottom text-rigth"  valign='top'>Return Weight</th>
      </tr>
     <?php 
          if(isset($return_data['return_detail']) AND count($return_data['return_detail'])>0 ) {
              $i=0;
              foreach ($return_data['return_detail'] as $value) {
                $i++;
        ?>   
      <tr>
        <td valign='top' align='center'><?php echo $i; ?></td>
        <td valign='top' align='center'><?php echo $value->lot_number; ?></td>
        <td valign='top' align='right'><?php echo $value->return_weight; ?>&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <?php
          }
        } 
        ?>
    </table>


      <table cellspacing='3' cellpadding='3' WIDTH='100%' class="table table-striped" style="border-bottom: 1px dashed #000;">
       <tr> 
         <td class="dotted_border_top " colspan="6" valign='top' align='center'><b>BILL AMOUNT</b></td>
         <td  class="dotted_border_top " valign='top' align='right'><span class="amount"> <?php echo '<b>'.$bill_data['bill_data']->sale_total.'</b>'; ?>&nbsp;&nbsp;&nbsp;</span></td>
      </tr>
    </table>

          <?php
            }
          ?>
              
	
    <div style="text-align: center;" >Thank You !!!. Visit Again !!!.</div>
  </div>
<div>
 
  <br/>
</div>
</div>

