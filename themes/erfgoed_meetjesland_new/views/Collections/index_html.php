<?php
	$o_collections_config = $this->getVar("collections_config");
	#$qr_collections = $this->getVar("collection_results");
	$va_access_values = caGetUserAccessValues($this->request);
	$o_browse = caGetBrowseInstance("ca_objects");
	
	$va_collections_with_objects = $o_browse->getFacet("collection_facet", array('checkAccess' => $va_access_values, 'request' => $this->request, 'checkAvailabilityOnly' => false));
	$va_collection_ids_with_objects = array();
	foreach($va_collections_with_objects as $va_facet_collection){
		$va_collection_ids_with_objects[] = $va_facet_collection["id"];
	}
	
	$vs_sort = ($o_collections_config->get("landing_page_sort")) ? $o_collections_config->get("landing_page_sort") : "ca_collections.preferred_labels.name";
	$qr_collections = ca_collections::find(array('parent_id' => null, 'preferred_labels' => ['is_preferred' => 1]), array('returnAs' => 'searchResult', 'checkAccess' => $va_access_values, 'sort' => $vs_sort));
	
	# --- show collections that have objects with the collection set as their object_collection field
	#$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids_with_objects);		
?>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2 collectionsList">
			<h1><?php print $this->getVar("section_name"); ?></h1>
<?php
	if($vs_intro = $this->getVar("collections_intro_text")){
		print "<p>".$vs_intro."</p>";
	}
		
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			if(in_array($qr_collections->get("ca_collections.access"), $va_access_values)){
				if ( $vn_i == 0) { print "<div class='row'>"; } 
				$vs_image = $qr_collections->getWithTemplate("<unit relativeTo='ca_collections' length='1'>^ca_object_representations.media.iconlarge</unit>");
				if(!$vs_image){
					$vs_image = $qr_collections->getWithTemplate("<unit relativeTo='ca_objects' length='1'>^ca_object_representations.media.iconlarge</unit>");
				}
				if(!$vs_image){
					$va_images = explode(";", $qr_collections->getWithTemplate("<unit relativeTo='ca_collections.children' length='1' limit='1'><unit relativeTo='ca_objects' length='1'>^ca_object_representations.media.iconlarge</unit></unit>"));
					$vs_image = $va_images[0];
				}
				print "<div class='col-sm-6'><div class='collectionTile'>".caDetailLink($this->request, $vs_image, "collectionTileImage", "ca_collections",  $qr_collections->get("ca_collections.collection_id"));
				print "<div class='title'>".caDetailLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";	
				if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
					print "<div>".$vs_scope."</div>";
				}
				print "<div style='clear:both;'><!-- empty --></div></div></div>";
				$vn_i++;
				if ($vn_i == 2) {
					print "</div><!-- end row -->\n";
					$vn_i = 0;
				}
			}
		}
		if (($vn_i < 2) && ($vn_i != 0) ) {
			print "</div><!-- end row -->\n";
		}
	} else {
		print _t('No collections available');
	}
?>
		</div>
	</div>
