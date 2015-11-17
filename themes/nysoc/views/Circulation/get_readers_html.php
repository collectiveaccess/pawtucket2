<?php
	// Colors for each series (match Chartist stylesheet)
	$va_series_colors = $this->getVar('series_colors'); 
	
	// List of currently displayed entity_ids
	$va_entity_list = $this->getVar('entity_list');
	
	// List of entity_ids to add to display
	$va_added_entity_ids = $this->getVar('added_entity_ids');
	
	// List of entity_ids to remove from display
	$va_removed_entity_ids = $this->getVar('removed_entity_ids');
	
	// Get cached stats per-reader (entity)
	$stat_entity_checkout_distribution = CompositeCache::fetch('stat_entity_checkout_distribution', 'vizData');
	
	// Generate data to pass to Chartist
	$va_payload = [];
	if (is_array($va_added_entity_ids)) { 
		foreach($va_added_entity_ids as $vn_entity_id) {
			$t_entity = new ca_entities($vn_entity_id);
			$va_payload[$vn_entity_id] = ['name' => $t_entity->get('ca_entities.preferred_labels.displayname'), 'data' => array_values($stat_entity_checkout_distribution[$vn_entity_id])];
		}
	}
?>
<script type="text/javascript">
<?php
	// add entities to graph
?>
	var _entity_data = <?php print json_encode($va_payload); ?>;
	for(e in _entity_data) { 
		_circulationGraphEntityList.push(parseInt(e));
		_circulationGraphData.series.push(_entity_data[e]); 
	}
	
<?php
	if(is_array($va_removed_entity_ids) && sizeof($va_removed_entity_ids)) {
		// remove entities from graph
?>
		var entity_ids = <?php print json_encode(array_values($va_removed_entity_ids)); ?>;
		for(i in entity_ids) {
			if ((x = _circulationGraphEntityList.indexOf(parseInt(entity_ids[i]))) !== -1) {
				_circulationGraphData.series.splice(x, 1);
				_circulationGraphEntityList.splice(x, 1);
			}
		}
<?php
	}	
?>
		
	_circulationGraph.update(_circulationGraphData);
</script>

	<div class='readerList clearfix'>
		<!-- Average circulate stats are always displayed -->
		<div class='readerListColorKey' style='background-color: #<?php print $va_series_colors[0]; ?>;'>&nbsp;</div>
		<div class='readerListImage'><div class="readerListImagePlaceholder"></div></div>
		<a href="#" id="toggleAverage" class="readerListShowHide">Hide</a>
		<div class='readerListName'>Library Average</div>
	</div>
<?php
		// Output entity list
		if (is_array($va_entity_list) && sizeof($va_entity_list)) {
			$qr_res = caMakeSearchResult('ca_entities', array_values($va_entity_list));
			$vn_c = 1;
			while($qr_res->nextHit()) {
				$vn_entity_id = $qr_res->get('ca_entities.entity_id');
				if (!($vs_image_tag = $qr_res->get('ca_object_representations.media.icon'))) {
					$vs_image_tag = "<div class='readerListImagePlaceholder'>".caGetThemeGraphic($this->request, 'cameo.jpg')."</div>";
				}
?>
	<div class='readerList clearfix'>
		<div class='readerListRemove' data-entity_id='<?php print $vn_entity_id; ?>'>&#10006;</div>
		<div class='readerListColorKey' style='background-color: #<?php print $va_series_colors[$vn_c]; ?>;'>&nbsp;</div>
		<div class='readerListImage'><?php print caDetailLink($this->request, $vs_image_tag, '', 'ca_entities', $vn_entity_id); ?></div>
		<div class='readerListName'><?php print caDetailLink($this->request, $qr_res->get('ca_entities.preferred_labels.displayname'), '', 'ca_entities', $vn_entity_id); ?><br/><?php print $qr_res->get('ca_entities.life_dates', array('format' => 'Y - Y')); ?></div>
	</div>
<?php			
				$vn_c++;
			}
		}
?>
<script type="text/javascript">
	jQuery(".readerListRemove").bind("click", function() {
		var id = jQuery(this).data('entity_id');
		
		jQuery('#readerContent').load('<?php print caNavUrl($this->request, '*', '*', 'GetReaders', array('m' => 'remove')); ?>/id/' + id);
	});
	jQuery("#toggleAverage").bind("click", function(e) {
		jQuery('.ct-series-a').toggle(250);
		jQuery(this).text((jQuery(this).text() == 'Hide') ? 'Show' : 'Hide');
		e.preventDefault();
		return false;
	});
</script>