<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	$va_access_values = caGetUserAccessValues($this->request);
#	$o_browse = caGetBrowseInstance("ca_objects");
	
#	$va_collections_with_objects = $o_browse->getFacet("collection_facet", array('checkAccess' => $va_access_values, 'request' => $this->request, 'checkAvailabilityOnly' => false));
#	$va_collection_ids_with_objects = array();
#	foreach($va_collections_with_objects as $va_facet_collection){
#		$va_collection_ids_with_objects[] = $va_facet_collection["id"];
#	}
	
#	$vs_sort = ($o_collections_config->get("landing_page_sort")) ? $o_collections_config->get("landing_page_sort") : "ca_collections.preferred_labels.name";
	#$qr_collections = ca_collections::find(array('parent_id' => null, 'preferred_labels' => ['is_preferred' => 1]), array('returnAs' => 'searchResult', 'checkAccess' => $va_access_values, 'sort' => $vs_sort));
	
	# --- show collections that have objects with the collection set as their object_collection field
#	$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids_with_objects);		
?>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2 collectionsList">
			<h1>Snuister doorheen onze collecties<br/><hr/></h1>
<?php
	#if($vs_intro = $this->getVar("collections_intro_text")){
	#	print "<div class='sectionIntro'>".$vs_intro."</div>";
	#}
		
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			if(in_array($qr_collections->get("ca_collections.access"), $va_access_values)){
				if ( $vn_i == 0) { print "<div class='row'>"; } 
				print "<div class='col-sm-4'><div class='collectionList'>".$qr_collections->getWithTemplate("<l>^ca_object_representations.media.widepreview</l>").
							"<label>".$qr_collections->getWithTemplate("<l>^ca_collections.preferred_labels</l>")."</label>
						</div></div>\n";
				
				$vn_i++;
				if ($vn_i == 3) {
					print "</div><!-- end row -->\n";
					$vn_i = 0;
				}
			}
		}
		if (($vn_i < 3) && ($vn_i != 0) ) {
			print "</div><!-- end row -->\n";
		}
	} else {
		print _t('No collections available');
	}
?>
		</div>
	</div>
