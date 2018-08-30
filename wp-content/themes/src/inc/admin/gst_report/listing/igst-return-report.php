<?php
    $report = new report();
?>

<div style="width: 100%;">
    <ul class="icons-labeled">
        
    </ul>
</div>
<div class="widget-top">
    <h4>Gst List</h4>
</div>

<div class="search_bar stock_report_filter">
    <label>Page :</label>
    <!-- <select name="per_page" id="per_page">
        <option value="5" <?php //echo ($billing->ppage == 5) ? 'selected' : ''; ?>>5</option>
        <option value="10" <?php //echo ($billing->ppage == 10) ? 'selected' : ''; ?>>10</option>
        <option value="15" <?php //echo ($billing->ppage == 15) ? 'selected' : ''; ?>>15</option>

        <option value="20" <?php //echo ($billing->ppage == 20) ? 'selected' : ''; ?>>20</option>
        <option value="50" <?php //echo ($billing->ppage == 50) ? 'selected' : ''; ?>>50</option>
        <option value="100" <?php //echo ($billing->ppage == 100) ? 'selected' : ''; ?>>100</option>
    </select> -->
    <select name="slap" class="slap" >
        <option value="" >GST Tax %</option>
        <option value="0.00" <?php echo ($report->slap == '0.00') ? 'selected' : '' ?>>0 %</option>
        <option value="2.50" <?php echo ($report->slap == '2.50') ? 'selected' : '' ?>>5 %</option>
        <option value="6.00" <?php echo ($report->slap == '6.00') ? 'selected' : '' ?>>12 %</option>
        <option value="9.00" <?php echo ($report->slap == '9.00') ? 'selected' : '' ?>>18 %</option>
        <option value="14.00" <?php echo ($report->slap == '14.00') ? 'selected' : '' ?>>28 %</option>
    </select>
    <input type="text" name="bill_from" class="bill_from form-control" value="<?php echo date('Y-m-d'); ?>" placeholder="Bill From">
    <input type="text" name="bill_to" class="bill_to form-control" value="<?php echo date('Y-m-d'); ?>" placeholder="Bill To">
   <!--  <button class="btn btn-default accountant_print "><i class="fa fa-print"></i> Print</button>
    <button class="btn btn-primary accountant_download" style="margin-right: 5px;"><i class="fa fa-file-pdf-o" href=""></i> Generate PDF</button>  -->
</div>


<div class="widget-content module table-simple list_customers">
    <?php include( get_template_directory().'/inc/admin/gst_report/ajax_loading/igst-return-report.php' ); ?>
</div>

