<?php

	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');
	$va_visualizations = caNavLink($this->request, "Visualizations", '', '', 'About', 'visualizations');
	MetaTagManager::setWindowTitle($va_home." > ".$va_visualizations." > Compare Reader Activity");
	
	// List of entity ids to display on load
	$va_entity_list = $this->getVar('entity_list');
	
	// Cached stats data used to generate plots
	$stat_entity_checkout_distribution = CompositeCache::fetch('stat_entity_checkout_distribution', 'vizData');
	$stat_avg_entity_checkout_distribution = CompositeCache::fetch('stat_avg_entity_checkout_distribution', 'vizData');
	
	// Generate Chartist-format data "payload"				
	$va_payload = [0 => ['name' => 'Library Average', 'data' =>  array_values($stat_avg_entity_checkout_distribution)]];	// first item is always "average" circulation plot
	$va_graph_labels = array_keys($stat_avg_entity_checkout_distribution);	
	foreach($va_entity_list as $vs_color => $vn_entity_id) {
		$t_entity = new ca_entities($vn_entity_id);
		if(!is_array($stat_entity_checkout_distribution[$vn_entity_id])) { continue; }
		$va_payload[$vn_entity_id] = ['name' => $t_entity->get('ca_entities.preferred_labels.displayname'), 'data' => array_values($stat_entity_checkout_distribution[$vn_entity_id])];
	}

?>
<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 col-lg-10 col-lg-offset-2">
			<h1 style="margin-top:20px;">Compare Reader Activity</h1>

		</div>
	</div>
	<div class="row">
		<div class="col-sm-2" >
			<div id='readerContentContainer'>
				<p class='vizTitle' style='text-align:left;'>Readers to Compare</p>
				<div id='readerContent'>
					<!-- List of currently displays readers -->
				</div>
				<div class="clearfix"></div>
				<div id='readerListToggle'><i class="fa fa-plus"></i> Compare Readers</div>

			</div>
		</div>	
		<div class="col-sm-10 ">
			<div id='readerList' class='clearfix row'>
				<!-- Index of all readers -->
			</div>		
			<div class="ct-chart ct-golden-section" id='circulationGraph'>
				<!-- The graph -->
			</div>
		</div>
		

	</div>
</div>

<script type="text/javascript">
	var _circulationGraph;			// GLOBAL for Chartist graph object
	var _circulationGraphData;		// GLOBAL for Chartist data
	var _circulationGraphEntityList = <?php print json_encode(array_keys($va_payload)); ?>;	// GLOBAL for series data
	
	jQuery(document).ready(function() {
		
		// Load reader index via ajax
		jQuery("#readerList").load('<?php print caNavUrl($this->request, '*', '*', 'readerIndex'); ?>');
		
		// Load reader list via ajax
		jQuery("#readerContent").load('<?php print caNavUrl($this->request, '*', '*', 'GetReaders'); ?>');
		
		//
		// Set up chart 
		//
		_circulationGraphData = {
		  labels: <?php print json_encode($va_graph_labels); ?>,
		  series: <?php print json_encode(array_values($va_payload)); ?>
		};

		var options = {
			fullWidth: true,
			// As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
			axisY: {
				onlyInteger: true,
				offset: 20
			},
			axisY: {
				onlyInteger: true,
				offset: 20
			},

		};
		
		var $chart = $('#circulationGraph');
		var $graphToolTip = $chart
		  .append('<div class="tooltip"></div>')
		  .find('.tooltip')
		  .hide();

		$chart.on('mouseenter', '.ct-point', function() {
			var $pt = $(this), $slice = $(this).parent(),
			sliceName = $slice.attr('ct:series-name'), value = $pt.attr('ct:value');
	
			$graphToolTip.html(sliceName + " (" + value + ")").show();
		});

		$chart.on('mouseleave', '.ct-point', function() {
		  $graphToolTip.hide();
		});

		$chart.on('mousemove', function(event) {
		  $graphToolTip.css({
			left: (event.offsetX || event.originalEvent.layerX) - $graphToolTip.width() / 2 - 10,
			top: (event.offsetY || event.originalEvent.layerY) - $graphToolTip.height() - 40
		  });
		});

		var responsiveOptions = [
		  ['screen and (min-width: 640px)', {
			chartPadding: 20,
			labelOffset: 30,
			labelDirection: 'explode'
		  }],
		  ['screen and (min-width: 1024px)', {
			labelOffset: 30,
			chartPadding: 20
		  }]
		];

		_circulationGraph = new Chartist.Line('#circulationGraph', _circulationGraphData, options, responsiveOptions);
	});
</script>