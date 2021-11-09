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
		
	$coll = Datamodel::getInstance('ca_collections', true);	
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			if(in_array($qr_collections->get("ca_collections.access"), $va_access_values)){
				if ( $vn_i == 0) { print "<div class='row'>"; } 
				$vs_image = $qr_collections->getWithTemplate("<unit relativeTo='ca_collections' length='1'>^ca_object_representations.media.iconlarge</unit>", $va_access_values);
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
