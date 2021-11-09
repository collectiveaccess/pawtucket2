<?php
	$o_collections_config = $this->getVar("collections_config");
	$va_access_values = caGetUserAccessValues($this->request);
	$vs_sort = ($o_collections_config->get("landing_page_sort")) ? $o_collections_config->get("landing_page_sort") : "ca_collections.preferred_labels.name";
	$qr_collections = ca_collections::find(array('parent_id' => null, 'preferred_labels' => ['is_preferred' => 1]), array('returnAs' => 'searchResult', 'checkAccess' => $va_access_values, 'sort' => $vs_sort));
	
	$coll = Datamodel::getInstance('ca_collections', true);
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
				
				
				if (!$vs_image) {
					$collection_ids = array_merge([$qr_collections->getPrimaryKey()], $qr_collections->get("ca_collections.children.collection_id", array("checkAccess" => $va_access_values, "returnAsArray" => true, "sort" => "ca_collection_labels.name")));
				
					foreach($collection_ids as $collection_id) {
						$refs = $coll->getAuthorityElementReferences(['row_id' => $collection_id]);
						if(isset($refs['57']) && sizeof($refs['57'])) { // 57 = ca_objects
							$qr_objects = caMakeSearchResult('ca_objects', array_keys($refs['57']), array("checkAccess" => $va_access_values, "sort" => 'ca_objects.idno'));
							while($qr_objects->nextHit()) {
								if(in_array($qr_objects->get("ca_objects.access"), $va_access_values)){
									if($vs_image = $qr_objects->get('ca_object_representations.media.iconlarge')) {
										break(2);
									}
								}
							}
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
