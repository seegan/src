<script type="text/javascript">
jQuery(document).ready(function () {
	var chart = new CanvasJS.Chart("chartContainer",
	{
		title:{
			text: "<?php echo 'Sale Statistics '.date('Y-m-d'); ?>"
		},
        animationEnabled: true,
		legend:{
			verticalAlign: "center",
			horizontalAlign: "left",
			fontSize: 20,
			fontFamily: "Helvetica"        
		},
		theme: "theme2",
		data: [
		{        
			type: "pie",       
			indexLabelFontFamily: "Garamond",       
			indexLabelFontSize: 20,
			indexLabel: "{label} {y} Rs",
			startAngle:-20,      
			showInLegend: true,
			toolTipContent:"{legendText} {y}&#8377;",
			dataPoints: <?php echo getSalesStatistics(date('Y-m-d')); ?>
		}
		]
	});
	chart.render();
});
</script>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
