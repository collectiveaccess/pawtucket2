<?php
	// Colors for each series (match Chartist stylesheet)
	$va_series_colors = $this->getVar('series_colors'); 
	
	// List of currently displayed object_ids
	$va_object_list = $this->getVar('object_list');
	
	// List of object_ids to add to display
	$va_added_object_ids = $this->getVar('added_object_ids');
	
	// List of object_ids to remove from display
	$va_removed_object_ids = $this->getVar('removed_object_ids');
	
	// Get cached stats per-reader (object)
	$stat_object_checkout_distribution = CompositeCache::fetch('stat_bib_checkout_distribution', 'vizData');
	$stat_avg_object_checkout_distribution = CompositeCache::fetch('stat_avg_checkout_distribution', 'vizData');
	
	// Generate data to pass to Chartist
	$va_payload = [];
	if (is_array($va_added_object_ids)) { 
		foreach($va_added_object_ids as $vn_object_id) {
			$t_object = new ca_objects($vn_object_id);
			$va_payload[$vn_object_id] = ['name' => $t_object->get('ca_objects.preferred_labels.name'), 'data' => array_values($stat_object_checkout_distribution[$vn_object_id])];
		}
	}
?>
<script type="text/javascript">
<?php
	// add objects to graph
?>
	var _object_data = <?php print json_encode($va_payload); ?>;
	for(e in _object_data) { 
		_circulationGraphobjectList.push(parseInt(e));
		_circulationGraphData.series.push(_object_data[e]); 
	}
	
<?php
	if(is_array($va_removed_object_ids) && sizeof($va_removed_object_ids)) {
		// remove objects from graph
?>
		var object_ids = <?php print json_encode(array_values($va_removed_object_ids)); ?>;
		for(i in object_ids) {
			if ((x = _circulationGraphobjectList.indexOf(parseInt(object_ids[i]))) !== -1) {
				_circulationGraphData.series.splice(x, 1);
				_circulationGraphobjectList.splice(x, 1);
			}
		}
<?php
	}	
?>
		
	_circulationGraph.update(_circulationGraphData);
</script>

	<div class='readerMapList clearfix'>
		<!-- Average circulate stats are always displayed -->
		<div class='readerMapListColorKey' style='background-color: #<?php print $va_series_colors[0]; ?>;'>&nbsp;</div>
		<div class='readerMapListImage'></div>
		<div class='readerMapListArtistName'>Average</div>
	</div>
<?php
		// Output object list
		if (is_array($va_object_list) && sizeof($va_object_list)) {
			$qr_res = caMakeSearchResult('ca_objects', array_values($va_object_list));
			$vn_c = 1;
			while($qr_res->nextHit()) {
				$vn_object_id = $qr_res->get('ca_objects.object_id');
				if (!($vs_image_tag = $qr_res->get('ca_object_representations.media.icon'))) {
					$vs_image_tag = "<div class='readerMapListImagePlaceholder'>&nbsp;</div>";
				}
?>
	<div class='readerMapList clearfix'>
		<div class='readerMapListRemove' data-object_id='<?php print $vn_object_id; ?>'>&#10006;</div>
		<div class='readerMapListColorKey' style='background-color: #<?php print $va_series_colors[$vn_c]; ?>;'>&nbsp;</div>
		<div class='readerMapListImage'><?php print caDetailLink($this->request, $vs_image_tag, '', 'ca_objects', $vn_object_id); ?></div>
		<div class='readerMapListArtistName'><?php print caDetailLink($this->request, $qr_res->get('ca_objects.preferred_labels.name'), '', 'ca_objects', $vn_object_id); ?><br/><?php print $qr_res->get('ca_objects.life_dates', array('format' => 'Y - Y')); ?></div>
	</div>
<?php			
				$vn_c++;
			}
		}
?>
		<script type="text/javascript">
			jQuery(".readerMapListRemove").bind("click", function() {
				var id = jQuery(this).data('object_id');
				
				jQuery('#readerContent').load('<?php print caNavUrl($this->request, '*', '*', 'GetBooks', array('m' => 'remove')); ?>/id/' + id);
			});
		</script>
<?php
	