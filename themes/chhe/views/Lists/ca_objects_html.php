<?php
	$qr_res = $this->getVar('result');
	#$va_results = caSplitSearchResultByType($qr_res, array());
?>
<div id='pageArea'>
	<div id='pageTitle'>
		<?php print _t('Objects'); ?>
	</div>
	<div id='contentArea'>
<?php	
		while ($qr_res->nextHit()) {
			print $qr_res->get('ca_objects.object_id').": ".$qr_res->get('ca_objects.preferred_labels.name')."<br/>";
		}
?>
	</div>
</div>