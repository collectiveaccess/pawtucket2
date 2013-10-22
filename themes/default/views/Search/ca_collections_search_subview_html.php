<?php
	$qr_results = $this->getVar('result');
	$va_block_info = $this->getVar('blockInfo');

if ($qr_results->numHits() > 0) {
?>
	<div class='blockTitle'>
		<?php print _t('Artworks'); ?>
	</div>
	<div class='blockResults'>
		<div style='width:100000px'>
<?php
			$vn_count = 0;
			while($qr_results->nextHit()) {
				$va_related_object_ids = $qr_results->get('ca_objects.object_id', array('returnAsArray' => true));

				print "<div class='collectionResult'>";
				$va_images = caGetPrimaryRepresentationsForIDs($va_related_object_ids, array('versions' => array('widepreview'), 'return' => 'tags'));
				if (sizeof($va_images) > 0){
					foreach ($va_images as $image_id => $va_image) {
						print caNavLink($this->request, "<div class='objImage'>".$va_image."</div>", '', '', 'Detail', 'Collections/'.$qr_results->getIdentifierForUrl());
					} 
				} else {
					print "<div class='objImage'></div>";
				}
				print "<div>".caNavLink($this->request, $qr_results->get('ca_collections.preferred_labels.name'), '', '', 'Detail', 'Collections/'.$qr_results->getIdentifierForUrl())."</div>";
				print "</div>";
				$vn_count++;
				if ($vn_count == 25) {break;}
			}
?>
		</div>
	</div>
<?php
}
?>