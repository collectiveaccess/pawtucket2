<?php
	$o_locations_config = $this->getVar("locations_config");
	$qr_locations = $this->getVar("location_results");
	$va_access_values = $this->getVar("access_values");
?>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
			<h1><?php print $this->getVar("section_name"); ?></h1>
			<p>{{{locations_intro_text}}}</p>
<?php	
	$vn_i = 0;
	if($qr_locations && $qr_locations->numHits()) {
		while($qr_locations->nextHit()) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			print "<div class='col-sm-6 col-md-3'><div class='locationTile'><div class='title'>".caDetailLink($this->request, $qr_locations->get("ca_storage_locations.preferred_labels"), "", "ca_storage_locations",  $qr_locations->get("ca_storage_locations.location_id"))."</div>";	
			if ($vs_tmp = $qr_locations->getWithTemplate("<l>^ca_object_representations.media.iconlarge</l>")) {
				print "<div>".$vs_tmp."</div>";
			}
			if ($va_child_buildings = $qr_locations->get("ca_storage_locations.children.location_id", array("returnAsArray" => true, "restrictToTypes" => array("buildings"), "checkAccess" => $va_access_values))) {
				if(is_array($va_child_buildings) && sizeof($va_child_buildings)){
					print "<div>".sizeof($va_child_buildings)." building".((sizeof($va_child_buildings) == 1) ? "" : "s")."</div>";
				}
			}
			print "</div></div>";
			$vn_i++;
			if ($vn_i == 4) {
				print "</div><!-- end row -->\n";
				$vn_i = 0;
			}
		}
		if ($vn_i > 0) {
			print "</div><!-- end row -->\n";
		}
	} else {
		print _t('No locations available');
	}
?>
		</div>
	</div>
