<?php
	// List of entity ids to display on load
	$va_entity_list = $this->getVar('entity_list');
	
	// Cached stats data used to generate plots
	$stat_entity_checkout_distribution = CompositeCache::fetch('stat_entity_checkout_distribution', 'vizData');
	$stat_avg_entity_checkout_distribution = CompositeCache::fetch('stat_avg_entity_checkout_distribution', 'vizData');
	
	// Generate Chartist-format data "payload"				
	$va_payload = [0 => ['name' => 'Average', 'data' =>  array_values($stat_avg_entity_checkout_distribution)]];	// first item is always "average" circulation plot
	$va_graph_labels = array_keys($stat_avg_entity_checkout_distribution);	
	foreach($va_entity_list as $vs_color => $vn_entity_id) {
		$t_entity = new ca_entities($vn_entity_id);
		if(!is_array($stat_entity_checkout_distribution[$vn_entity_id])) { continue; }
		$va_payload[$vn_entity_id] = ['name' => $t_entity->get('ca_entities.preferred_labels.displayname'), 'data' => array_values($stat_entity_checkout_distribution[$vn_entity_id])];
	}

?>
<div id='readerList' class='clearfix'>
	<!-- Index of all readers -->
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-10 ct-chart ct-square" id='circulationGraph'>
			<!-- The graph -->
		</div>
		
		<div class="col-sm-2" id='readerContentContainer'>
			<div id='readerContent' style="height: 600px;">
 				<!-- List of currently displays readers -->
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

		$chart.on('mouseenter', '.ct-series', function() {
			var $slice = $(this),
			sliceName = $slice.attr('ct:series-name');
			console.log($slice);
			$graphToolTip.html(sliceName).show();
		});

		$chart.on('mouseleave', '.ct-series', function() {
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