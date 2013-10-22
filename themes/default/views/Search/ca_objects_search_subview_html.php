<?php
	$qr_results = $this->getVar('result');
	$va_block_info = $this->getVar('blockInfo');

if ($qr_results->numHits() > 0) {

?>
	<div class='blockTitle'>
		<?php print $va_block_info['displayName']; ?>
	</div>
	<div class='blockResults' style='height:207px;'>
		<div style='width:100000px'>
<?php
			$vn_i = 0;
			while($qr_results->nextHit()) {
				print "<div class='objectResult'>";
				print caNavLink($this->request, "<div class='objImage'>".$qr_results->get('ca_object_representations.media.widepreview')."</div>", '', '', 'Detail', 'Objects/'.$qr_results->getIdentifierForUrl());
				print "<div>".caNavLink($this->request, $qr_results->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'Objects/'.$qr_results->getIdentifierForUrl())."</div>";
				print "</div>";
				$vn_i++;
				if ($vn_i == 10) {break;} 
			}
?>
		</div>
	</div>
<?php
}
?>