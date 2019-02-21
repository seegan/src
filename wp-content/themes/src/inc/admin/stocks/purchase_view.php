<style type="text/css">
    .inside_form .form_detail {
        width: 46%;
        float: left;
        margin: 0 10px 5px;
        height: 42px;
    }
    .particulars {
        margin: 0 10px 5px;
    }
    .particulars .part-in {
        margin: 10px;
    }

    .footer-txt {
        text-align: right;
    }
</style>

<div class="widget-top">
    <h4>Purchase Details</h4>
</div>
<?php 
$purchase_id=$_GET['purchase_id'];
$data['result'] =purchase_details($purchase_id);
// print_r($data['result']);
 
foreach ($data['result'] as $lot_value) {

   $name = $lot_value->name;
    $billno=$lot_value->billno;
    $address=$lot_value->address;
    $billdate=$lot_value->billdate;
    $mobile = $lot_value->mobile;
    $email=$lot_value->email;
    $gstno=$lot_value->gstno;
    $gst=$lot_value->gst;    
    $grandtotal=$lot_value->grand_total; 
    $gstamt=$lot_value->gstamt; 
    $taxless=$lot_value->taxlessamt; 
    $discount=$lot_value->discount; 
    $subtotal=$lot_value->sub_total; 
}
?>

<div class="form-grid">  
        <div class="form_detail" style="width:100%;padding:20px;font-size: 13px">
        <div style="width: 70%;float: left;position: relative;    line-height: 25px;">
                 Name : <?php echo $name;?><br/>
          Address :  <?php echo  $address;?>   <br/>
          Phone Number: <?php echo  $mobile;?><br/>
          GST Number: <?php echo  $email;?> <br/>
            Email : <?php echo  $gstno;?>   <br/>
            GST% : <?php echo  $gstpercentage;?> 
           </div>
           <div style="float: left;text-align: left;font-weight: bold;line-height: 25px;">
                   Bill Number: <?php echo  $billno;?> <br/>
            Bill Date <?php echo  $billdate;?>  <br/><br/>
        </div>
          
             
            </div>
        </div>
        <div style="clear:both;"></div>
        <div class="particulars">
                <h2>Particulars</h2>
                <div class="widget-content module table-simple">
                    <table class="display">
                        <thead>
                            <tr>
                            	<th>S.no</th>
                                <th>HSN</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th style="width: 100px;">per</th>
                                <th>Taxless Amount</th>
                                <th>Tax Amount</th>
                                <th>Sub Amount</th>
                            </tr>
                        </thead>
                        <tbody class="purchase_row">
<?php 
 $datas['results'] =purchase_details_list($purchase_id);
 //print_r($datas['results']);
$i=1;
for($j=0;$j<count($datas['results']);$j++) {

$value=$datas['results'][$j];
 ?>
<tr>
	<td><?php echo $i;?></td>
	<td><?php echo $value[hsn];?></td>
	<td><?php echo $value[lot_name];?></td>
	<td><?php echo $value[quantity];?></td>
	<td><?php echo $value[rate_per];?></td>
	<td><?php echo $value[kg_bag];?></td>
	<td><?php echo $value[taxlessamout];?></td>
	<td><?php echo $value[gst_value];?></td>
	<td  style="padding-right: 20px;text-align: right;"><?php echo $value[totalamt];
	$i++;
	?></td>
</tr>
  <?php
  }
?>

                        </tbody>
                        <tbody class="purchase_total">
                            <tr>
                                <td colspan="8"><div class="footer-txt">Sub Total</div></td>
                                <td style="padding-right: 20px;text-align: right;"><?php echo $subtotal;?></td>
                            </tr>
                            <tr>
                                <td colspan="8"><div class="footer-txt">Cash Discount</div></td>
                                <td style="padding-right: 20px;text-align: right;"> <?php echo $discount;?></td>
                            </tr>
                            <tr>
                                <td colspan="8"><div class="footer-txt">Taxless Amount</div></td>
                                <td style="padding-right: 20px;text-align: right;"><?php echo $taxless;?></td>
                            </tr>
                            <tr>
                                <td colspan="8"><div class="footer-txt">Total Gst Amount</div></td>
                                <td style="padding-right: 20px;text-align: right;"><?php echo $gstamt;?></td>
                            </tr>                            
                            <tr>
                                <td colspan="8"><div class="footer-txt">Grand Total</div></td>
                                <td style="padding-right: 20px;text-align: right;"><?php echo $grandtotal;?></td>
                            </tr>
                            <input type="hidden" name="lot_details" value="" class="lot_details">
                        </tbody>
                        <tfoot>
                            <tr>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>


   
    </form>
</div>




<script type="text/javascript">

</script>

