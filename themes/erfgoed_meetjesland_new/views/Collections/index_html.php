<?php
	$o_collections_config = $this->getVar("collections_config");
	$va_access_values = caGetUserAccessValues($this->request);
	
	$vs_sort = ($o_collections_config->get("landing_page_sort")) ? $o_collections_config->get("landing_page_sort") : "ca_collections.preferred_labels.name";
	$qr_collections = ca_collections::find(array('parent_id' => null, 'preferred_labels' => ['is_preferred' => 1]), array('returnAs' => 'searchResult', 'checkAccess' => $va_access_values, 'sort' => $vs_sort));
	
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
					#$vs_image = $qr_collections->getWithTemplate("<unit relativeTo='ca_objects' length='1'>^ca_object_representations.media.iconlarge</unit>");
					#$qr_res = $o_search->search("ca_objects.object_collection.collection_id:".$qr_collections->get("ca_collections.collection_id"), array("limit" => 1));
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
