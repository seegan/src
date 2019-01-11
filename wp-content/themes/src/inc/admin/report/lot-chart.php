
<script type="text/javascript">
jQuery(document).ready(function () {
	var lotChart = new CanvasJS.Chart("chartLotContainer",
	{
		animationEnabled: true,
		title:{
			text: "Chart with Labels on X Axis"
		},
		axisY:{
              valueFormatString: "#,###.## RS", //try properties here
        },
		data: [
		{
			type: "column", //change type to bar, line, area, pie, etc
			dataPoints: <?php echo laseDaysSaleTotal(); ?>
		}
		]
		});

	lotChart.render();
})
</script>
<div id="chartLotContainer" style="height: 300px; width: 100%;"></div>