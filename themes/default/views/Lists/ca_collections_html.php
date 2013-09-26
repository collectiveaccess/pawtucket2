<?php
	$qr_res = $this->getVar('result');
	$va_results = caSplitSearchResultByType($qr_res, array());
?>
<div id='pageArea'>
	<div id='pageTitle'>
		<?php print _t('Collections'); ?>
	</div>
	<div id='contentArea'>
<?php	
		foreach($va_results as $vn_type_id => $va_result) {
			$qr_result_for_type = $va_result['result'];
			print "<div class='collectionUnit'>";
			print "<h2>Archival Collection type:{$va_result['type']['name_plural']} </h2>\n";
			
			$qr_result_for_type->seek(0);

			while($qr_result_for_type->nextHit()) {
				print "<div class='collectionInfo'>";
				$vn_collection_idno = $qr_result_for_type->get('ca_collections.idno');
				print "<h3>".caNavLink($this->request, $qr_result_for_type->get('ca_collections.preferred_labels.name'), '', '', 'Detail', 'Collections/'.$vn_collection_idno)."</h3>";
				print "<p>".$qr_result_for_type->get('ca_collections.description')."</p>";
				print "</div>";
			}
			print "</div>";
		}
?>
	</div>
</div>