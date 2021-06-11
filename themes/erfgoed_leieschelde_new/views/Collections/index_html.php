<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	$va_access_values = caGetUserAccessValues($this->request);
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
				$vs_image = $qr_collections->getWithTemplate("<unit relativeTo='ca_collections' length='1'>^ca_object_representations.media.iconlarge</unit>", $va_access_values);
				if(!$vs_image){
					$o_browse = caGetBrowseInstance('ca_objects');
					$o_browse->addCriteria("collection_field_facet", $qr_collections->get("ca_collections.collection_id"));
					$o_browse->execute(array('checkAccess' => $va_access_values, 'request' => $this->request));
					$qr_res = $o_browse->getResults(array('sort' => 'ca_objects.idno', 'sort_direction' => 'asc', 'limit' => 1));
					if($qr_res->numHits()){
						$qr_res->nextHit();
						$vs_image = $qr_res->getWithTemplate("^ca_object_representations.media.iconlarge");
					}				
				}
				if(!$vs_image){
					$va_child_collection = $qr_collections->get("ca_collections.children.collection_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
					if(is_array($va_child_collection) && sizeof($va_child_collection)){
						$vn_child_collection = array_shift($va_child_collection);
						$o_browse = caGetBrowseInstance('ca_objects');
						$o_browse->addCriteria("collection_field_facet", $vn_child_collection);
						$o_browse->execute(array('checkAccess' => $va_access_values, 'request' => $this->request));
						$qr_res = $o_browse->getResults(array('sort' => 'ca_objects.idno', 'sort_direction' => 'asc', 'limit' => 1));
						if($qr_res->numHits()){
							$qr_res->nextHit();
							$vs_image = $qr_res->getWithTemplate("^ca_object_representations.media.iconlarge");
						}
					}
				}
				print "<div class='col-sm-4'><div class='collectionList'>".caDetailLink($this->request, $vs_image, "", "ca_collections",  $qr_collections->get("ca_collections.collection_id")).
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
