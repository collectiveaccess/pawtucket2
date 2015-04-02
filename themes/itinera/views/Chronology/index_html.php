<div id='travelerList' class='clearfix'>
	
</div>
<div id='travelerContent'>
<?php

$va_entity_list = $this->getVar('entity_list');

?>
	<h2 id='intineraChronologyNoEntities'>To start select a traveler from the index</h2>
<?php
if (sizeof($va_entity_list)) {
	$qr_entities = caMakeSearchResult('ca_entities', array_values($va_entity_list));

	while($qr_entities->nextHit()) {
		$vn_entity_id = $qr_entities->get('ca_entities.entity_id');
		$vs_entity_name = $qr_entities->get('ca_entities.preferred_labels.displayname');
	
		$va_stops = $qr_entities->get('ca_tour_stops.stop_id', ['returnAsArray' => true]);
	
		$this->setVar('entity_id', $vn_entity_id);
		$this->setVar('entity_name', $vs_entity_name);
		$this->setVar('entity_image', $qr_entities->get('ca_entities.agentMedia', array('version' => 'icon')));
		
		$this->setVar('stops', $va_stops);
	
		print $this->render('Chronology/get_chronology_track_html.php');
	
	}
?>

<?php
}
?>
</div>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		// Load traveler index via ajax
		jQuery("#travelerList").load('<?php print caNavUrl($this->request, '*', '*', 'TravelerIndex'); ?>');
	});
</script>