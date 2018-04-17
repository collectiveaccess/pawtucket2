<?php
	$va_access_values = caGetUserAccessValues($this->request);
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
			
	$vs_directory = __CA_THEME_DIR__."/assets/pawtucket/graphics/research/";
	$vn_filecount = 0;
	$va_files = glob($vs_directory . "*");
	if ($va_files){
	 $vn_filecount = count($va_files);
	}
?>
	<!--<h1>Research</h1>-->
<?php
	print "<div class='bannerImg'>".caGetThemeGraphic($this->request, 'research/'.rand(1,$vn_filecount).'.jpg')."</div>";
?>
	<div class="row">
		<div class="col-sm-12 ">
			<div class="band">
				<div>Examine the Collection</div>
			</div>
		</div>
	</div>
	<div class="row">
<?php	
	$va_colors = array("ee3124", "00ae58", "004e9a", "00abe6", "6e298d", "ec008b", "faa61a");
	if($qr_collections && $qr_collections->numHits()) {
		$vn_color_index = 0;
		while($qr_collections->nextHit()) { 
			print '<div class="col-sm-6 col-md-6">';
			print "<div class='collectionLandingTile' style='background-color:#".$va_colors[$vn_color_index]."'>";
			print "<div class='collectionImg'>".caDetailLink($this->request, $qr_collections->get('ca_object_representations.media.iconlarge', array("checkAccess" => $va_access_values)), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";
			print "<div class='collectionText'><h3>".caDetailLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</h3>";
			#if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
			#	print caTruncateStringWithEllipsis($vs_scope, 130);
			#}
			print "</div>";
			print "<div style='width:100%;clear:both;'></div>";
			print "</div><!-- end collectionTile -->";
			print '</div>';
			$vn_color_index++;
			if($vn_color_index > (sizeof($va_colors) - 1)){
				$vn_color_index = 0;
			}
		}
	} else {
		print _t('No collections available');
	}
?>
					</div>
				</div>
			</div>
