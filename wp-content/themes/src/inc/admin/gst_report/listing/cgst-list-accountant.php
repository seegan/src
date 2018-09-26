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

<div class="search_bar igst_report_filter">
    <label>Page :</label>
    <select name="per_page" id="per_page">
        <option value="5" <?php echo ($report->ppage == 5) ? 'selected' : ''; ?>>5</option>
        <option value="10" <?php echo ($report->ppage == 10) ? 'selected' : ''; ?>>10</option>
        <option value="15" <?php echo ($report->ppage == 15) ? 'selected' : ''; ?>>15</option>

        <option value="20" <?php echo ($report->ppage == 20) ? 'selected' : ''; ?>>20</option>
        <option value="50" <?php echo ($report->ppage == 50) ? 'selected' : ''; ?>>50</option>
        <option value="100" <?php echo ($report->ppage == 100) ? 'selected' : ''; ?>>100</option>
    </select>
    <select name="slab" class="slab">
        <option value="-" >GST Tax %</option>
        <option value="0.00" <?php echo ($report->slab == '0.00') ? 'selected' : '' ?>>0 %</option>
        <option value="2.50" <?php echo ($report->slab == '2.50') ? 'selected' : '' ?>>5 %</option>
        <option value="6.00" <?php echo ($report->slab == '6.00') ? 'selected' : '' ?>>12 %</option>
        <option value="9.00" <?php echo ($report->slab == '9.00') ? 'selected' : '' ?>>18 %</option>
        <option value="14.00" <?php echo ($report->slab == '14.00') ? 'selected' : '' ?>>28 %</option>
    </select>
    <input type="text" id="date_from" name="bill_from" class="bill_from form-control" value="<?php echo date('Y-m-d'); ?>" placeholder="Bill From">
    <input type="text" id="date_to" name="bill_to" class="bill_to form-control" value="<?php echo date('Y-m-d'); ?>" placeholder="Bill To">
</div>


<div class="widget-content module table-simple list_customers">
    <?php include( get_template_directory().'/inc/admin/gst_report/ajax_loading/cgst-list-accountant.php' ); ?>
</div>

