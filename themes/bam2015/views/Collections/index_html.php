<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
?>

				
	<div class="row">
		<div class='col-xs-12 col-sm-10 col-sm-offset-1'>
			<div class='detailHead'>
				<div class='leader'>Finding Aids</div>
				<h2>Archival and Manuscript Collections</h2> 
				<p style='margin-top:15px;'>
					Collections are listed below. Some are digitized and can be searched online. Others, such as the BAM Board Files and Harvey Lichtenstein President's Records, exist only in original form and require an on-site visit.
				</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class='col-xs-12'>
			<hr class='divide'>
		</div><!-- end col -->
	</div><!-- end row -->
	<div class="row">
		<div class='col-xs-12'>

	
<?php	
	if ($qr_collections) {
		$vn_c = 0;
		while($qr_collections->nextHit()) { 
			if($vn_c == 0){
				print "<div class='row'>";
			}
			$vn_top_level_collection_id = $qr_collections->get('ca_collections.collection_id');
			$vn_collection_image = $qr_collections->get("ca_collections.collection_thumbnail", array("version" => "iconlarge"));
			print "<div class='col-xs-12 col-sm-6'>";
			print "<div class='row'>";
			print "<div class='col-xs-12 col-sm-3'><div class='collectionGraphic'>".$vn_collection_image."</div></div><!-- end col -->";
			print "<div class='col-xs-12 col-sm-8'><div class='collectionName'>";
			print $qr_collections->get('ca_collections.preferred_labels', array('returnAsLink' => true));
			print "</div>\n";
			if (strlen($qr_collections->get('ca_collections.collection_description')) > 250) {
				print "<div class='collectionDescription'>".substr($qr_collections->get('ca_collections.collection_description'), 0, 247)."...</div>";				
			} else {
				print "<div class='collectionDescription'>".$qr_collections->get('ca_collections.collection_description')."</div>";
			}
			print "</div><!-- end col -->\n";
			print "</div><!-- end row -->\n";
			print "</div><!-- end col -->\n";	
			$vn_c++;
			if($vn_c == 2){
				print "</div><!-- end row -->";
				$vn_c = 0;
			}
		}
		if($vn_c == 1){
			print "</div><!-- end row -->";
		}
	} else {
		print _t('No collections available');
	}
?>
</div><!-- end col --></div><!-- end row-->	