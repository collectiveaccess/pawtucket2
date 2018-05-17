<?php
	require_once(__CA_MODELS_DIR__."/ca_collections.php");

	$qr_res = ca_collections::find(['show' => 'yes'], ['returnAs' => 'searchResult']);

?>

<div class="row">
	<div class="col-md-12 col-lg-12 collectionsList">
		<h1>Collections</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sem in erat varius dapibus. Aliquam nec magna eget ligula efficitur ultrices. Donec sollicitudin massa in posuere viverra.</p>
<?php
		if ($qr_res && $qr_res->numHits()) {
			print '<div class="row">';
			while ($qr_res->nextHit()){
				print '
			<div class="col-sm-6">
				<div class="collectionTile">';
					print '<div class="title">'.$qr_res->get('ca_collections.preferred_labels', array('returnAsLink' => true)).'</div>';
					print '<div>'.$qr_res->get('ca_collections.adminbiohist').'</div>';
					print '
				</div>
			</div>';
			}
			print '</div><!-- end row -->';
		}
?>		
	</div>
</div>