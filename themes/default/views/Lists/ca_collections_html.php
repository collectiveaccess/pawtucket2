<?php
	$qr_res = $this->getVar('result');
	#$va_results = caSplitSearchResultByType($qr_res, array());
?>
<div id='pageArea'>
	<div id='pageTitle'>
		<?php print _t('Collections'); ?>
	</div>
	<div id='contentArea'>
<?php	

		while ($qr_res->nextHit()) {
			if ($qr_res->get('ca_collections.collection_category') == 482) {
				$va_permanent_collections[] = $qr_res->get('ca_collections.collection_id');
			}
			if ($qr_res->get('ca_collections.collection_category') == 483) {
				$va_archival_collections[] = $qr_res->get('ca_collections.collection_id');
			}
		}
		
		print "<div class='collectionUnit'>";
		print "<h2>"._t('The Permanent Collection')."</h2>";
		foreach ($va_permanent_collections as $key => $va_permanent_collection_id) {
			$t_collection = new ca_collections($va_permanent_collection_id);
			print "<div class='collectionInfo'>";
			print "<h3>".$t_collection->get('ca_collections.preferred_labels')."</h3>";
			print "<p>".$t_collection->get('ca_collections.description')."</p>";
			print "</div>";
		}
		print "</div>";
		
		print "<div class='collectionUnit'>";
		print "<h2>"._t('The Archival Collections')."</h2>";
		foreach ($va_archival_collections as $key => $va_archival_collection_id) {
			$t_collection = new ca_collections($va_archival_collection_id);
			print "<div class='collectionInfo'>";
			print "<h3>".$t_collection->get('ca_collections.preferred_labels')."</h3>";
			print "<p>".$t_collection->get('ca_collections.description')."</p>";
			print "</div>";
		}
		print "</div>";

		
?>
	</div>
</div>