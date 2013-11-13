<?php
	$qr_results = $this->getVar('result');
	$va_block_info = $this->getVar('blockInfo');
?>

<div class='blockTitle'>
	<?php print $va_block_info['displayName']; ?>
</div>
<div class='blockResults'>
<div style='width:100000px'>
<?php
	$vn_count = 0;
	$vn_i = 0;
	while($qr_results->nextHit()) {
		if ($vn_i == 0) {print "<div class='placeSet'>";}
		print "<div class='placeResult'>";
		print "<div>".caNavLink($this->request, $qr_results->get('ca_places.preferred_labels.name'), '', '', 'Detail', 'Place/'.$qr_results->getIdentifierForUrl())."</div>";
		print "</div>";
		$vn_count++;
		$vn_i++;
		if ($vn_i == 5) {
			print "</div>";
			$vn_i = 0;
		}
		if ($vn_count == 25) {break;}
	}
	if (!($qr_results->nextHit()) && ($vn_i < 5)) {print "</div>";}
?>
</div>
</div>