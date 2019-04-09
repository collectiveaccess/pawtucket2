<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$qr_res = ca_places::find(['parent_id' => $t_item->get('ca_places.place_id'), 'access' => 1], ['returnAs' => 'searchResult']);
	$vs_default_placeholder = caGetThemeGraphic($this->request, 'placeholder.jpg');
	while($qr_res->nextHit()){
			$vn_ids[] = $qr_res->get('ca_places.place_id');
			
	}
	$vn_place_id = $t_item->get('ca_places.place_id');
	$vn_place_parent_id = $t_item->get('ca_places.parent.place_id');
	$vn_ids[] = $vn_place_id;
	$va_images = caGetDisplayImagesForAuthorityItems('ca_places', $vn_ids, array('version' => 'resultcrop', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'checkAccess' => $va_access_values));
	$va_detail_image = caGetDisplayImagesForAuthorityItems('ca_places', [$vn_place_id], array('version' => 'large', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'checkAccess' => $va_access_values));
	$va_parent_detail_image = caGetDisplayImagesForAuthorityItems('ca_places', [$vn_place_parent_id], array('version' => 'thumbnail', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'checkAccess' => $va_access_values));
	
	# related items
	$va_related_objects = $t_item->get("ca_objects.object_id", array("returnWithStructure" => true, "excludeRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values));
	$va_featured_collections = $t_item->get("ca_collections.collection_id", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("featured"), "checkAccess" => $va_access_values));
	$va_detail_collections = $t_item->get("ca_collections.collection_id", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("history"), "checkAccess" => $va_access_values));
?>
<div class="row">
</div><!-- end row -->
<div class="row">		
<div class='col-sm-8'>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 placeDetailImage">
			<?php print $va_detail_image[$t_item->get('ca_places.place_id')]; ?>
			<p>{{{<ifdef code="ca_places.description">^ca_places.description</ifdef>}}}</p>
		</div>
	</div>
	<div class="row">
		<div id="browsePlaceResultsContainer">
<?php
		$vn_ids = [];
		while($qr_res->nextHit()){
			$vn_ids[] = $qr_res->get('ca_places.place_id');
		}
		$qr_res->seek(0);
		while($qr_res->nextHit()){
			$vn_id = $qr_res->get('ca_places.place_id');
			
			if($va_images[$vn_id]){
				$vs_rep_detail_link = caDetailLink($this->request, $va_images[$vn_id], '', 'ca_places', $vn_id);		
			} else {
				$vs_rep_detail_link = caDetailLink($this->request, $vs_default_placeholder, '', 'ca_places', $vn_id);
			}
			$vs_label_detail_link = caDetailLink($this->request, $qr_res->get('ca_places.preferred_labels'), '', 'ca_places', $vn_id);
			print "<div class='bResultItemCol col-xs-6 col-sm-4 col-md-4'>
				<div class='bResult'>
					{$vs_rep_detail_link}
					<div class='bResultText'>
						{$vs_label_detail_link}
					</div>
				</div>
			</div>";
		}
?>
		</div><!-- end browseResultsContainer -->
	</div>
<?php
	# related objects
	$t_object_thumb = new ca_objects();
	
	if(is_array($va_related_objects) && sizeof($va_related_objects)){
			$q_related_objects = caMakeSearchResult('ca_objects', $va_related_objects);
			if($q_related_objects->numHits()){
				print "<div class='row'><div class='col-sm-12'><div class='btn btn-default'>"._t("Objects")."</div></div></div><!-- end row -->\n";
				$i = 0;
				while($q_related_objects->nextHit()){
					if($i == 0){
						print "<div class='row'>";
					}
					if($q_related_objects->get("ca_object_representations.media.resultcrop", array("checkAccess" => $va_access_values))){
						$vs_media = $q_related_objects->getWithTemplate("<l>^ca_object_representations.media.resultcrop</l>", array("checkAccess" => $va_access_values));
					} else {
						$vs_media = caNavLink($this->request, caGetThemeGraphic($this->request, 'placeholder.jpg'), '', 'Detail', 'objects', $q_related_objects->get("ca_objects.idno"));
					}
					$vs_caption = $q_related_objects->getWithTemplate('<l>^ca_objects.preferred_labels.name</l>');
					if($vs_caption){
						$vs_caption = "<div class='bResultText'>".$vs_caption."</div>";
					}
					
					print "<div class='bResultItemCol col-xs-6 col-sm-4 col-md-4'>
						<div class='bResult'>
							{$vs_media}
							{$vs_caption}
						</div>
					</div><!-- end col -->";
					$i++;
					if($i == 3){
						print "</div><!-- end row -->";
						$i = 0;
					}
				}
				if($i > 0){
					print "</div><!-- end row -->";
				}
			}
		}
?>
</div><!-- end col -->
<div class='col-sm-4'>
	<div class="detailTitle">{{{^ca_places.preferred_labels}}}</div>
	<?php
	# Parent Place
	$vn_parent_id = $t_item->get("ca_places.parent.place_id");
	$vn_parent_label = $t_item->get('ca_places.parent.preferred_labels');
	$t_parent = new ca_places($vn_parent_id);
	if($t_parent && $vn_parent_label != "Root node for dc"){	
		print "<div class='btn btn-default'>Part of</div>";
		print "<div class='row'><div class='col-sm-12 text-center'>";
		print $t_parent->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_places.preferred_labels</l></div>");
		print "</div><div class='col-sm-12 detailRelatedThumb'>".$va_parent_detail_image[$t_item->get('ca_places.parent.place_id')]."</div>";
		print "</div><!-- end row -->";
	}
	#featured collections
	if(is_array($va_featured_collections) && sizeof($va_featured_collections)){
		$q_featured_collections = caMakeSearchResult('ca_collections', $va_featured_collections);
		if($q_featured_collections->numHits()){
			print "<div class='btn btn-default'>Featured Collection".((sizeof($va_featured_collections) > 1) ? "s" : "")."</div>";
			$i = 0;
			while($q_featured_collections->nextHit()){
				if($i > 0){
					print "<HR/>";
				}
				if(!($vs_thumb = $q_featured_collections->getWithTemplate("<unit relativeTo='ca_objects' length='1'><unit relativeTo='ca_object_representations' length='1'>^ca_object_representations.media.resultcrop</unit></unit>", array("checkAccess" => $va_access_values)))){
					$vs_thumb = caGetThemeGraphic($this->request, 'placeholder.jpg');
				}
				$vs_caption = $q_featured_collections->getWithTemplate('<l>^ca_collections.preferred_labels.name</l>');
				print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
				print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
				print $q_featured_collections->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_collections.preferred_labels.name</l></div>");
				if($vs_brief_description = $q_featured_collections->get("ca_collections.brief_description")){
					print $vs_brief_description;
				}
				print "</div></div><!-- end row -->";
				$i++;
			}
		}
	}
	# Detail collections
	if(is_array($va_detail_collections) && sizeof($va_detail_collections)){
		$q_detail_collections = caMakeSearchResult('ca_collections', $va_detail_collections);
		if($q_detail_collections->numHits()){
			print "<div class='btn btn-default'>Detailed Histor".((sizeof($va_detail_collections) > 1) ? "ies" : "y")."</div>";
			$i = 0;
			while($q_detail_collections->nextHit()){
				if($i > 0){
					print "<HR/>";
				}
				if(!($vs_thumb = $q_detail_collections->getWithTemplate("<unit relativeTo='ca_objects' length='1'><unit relativeTo='ca_object_representations' length='1'>^ca_object_representations.media.resultcrop</unit></unit>", array("checkAccess" => $va_access_values)))){
					$vs_thumb = caGetThemeGraphic($this->request, 'placeholder.jpg');
				}
				$vs_caption = $q_detail_collections->getWithTemplate('<l>^ca_collections.preferred_labels.name</l>');
				print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
				print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
				print $q_detail_collections->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_collections.preferred_labels.name</l></div>");
				if($vs_brief_description = $q_detail_collections->get("ca_collections.brief_description")){
					print $vs_brief_description;
				}
				print "</div></div><!-- end row -->";
				$i++;
			}
		}
	}
	$t_object_thumb = new ca_objects();
	# Related Collections
	$va_collections = $t_item->get("ca_collections", array("returnWithStructure" => true, 'excludeRelationshipTypes' => array('featured', 'history'),"checkAccess" => $va_access_values));
	if(sizeof($va_collections)){
		print "<div class='btn btn-default'>Related Collection".((sizeof($va_collections) > 1) ? "s" : "")."</div>";
		$t_rel_collection = new ca_collections();
		$i = 0;
		foreach($va_collections as $va_collection){
			if($i > 0){
				print "<HR/>";
			}
			$t_rel_collection->load($va_collection["collection_id"]);
			$t_object_thumb->load($t_rel_collection->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
			$vs_thumb = $t_object_thumb->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
			print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			print $t_rel_collection->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_collections.preferred_labels.name</l></div>");
			if($vs_brief_description = $t_rel_collection->get("ca_collections.brief_description")){
				print $vs_brief_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	if ($va_links = $t_item->get('ca_objects.external_link', array('returnWithStructure' => true))) {
		print "<div class='btn btn-default'>Related links</div><div>";
		foreach ($va_links as $va_key => $va_link_t) {
			foreach ($va_link_t as $va_key2 => $va_link) {
				if ($va_link['url_entry'] && $va_link['url_source']) {
					print "<p class='detailRelatedTitle'><a href='".$va_link['url_entry']."' target='_blank'>".$va_link['url_source']."</a></p>";
				} elseif ($va_link['url_entry']) {
					print "<p class='detailRelatedTitle'><a href='".$va_link['url_entry']."' target='_blank'>".$va_link['url_entry']."</a></p>";
				}
			}
		}
		print "</div>";
	}
	# related entities
	$t_object_thumb = new ca_objects();
	$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_entities)){
		if(sizeof($va_entities) == 1){
			print "<div class='btn btn-default'>Related person/organisation</div>";
		}else{
			print "<div class='btn btn-default'>Related people/organisations</div>";
		}
		$t_rel_entity = new ca_entities();
		$i = 0;
		foreach($va_entities as $va_entity){
			if($i > 0){
				print "<HR/>";
			}
			$t_rel_entity->load($va_entity["entity_id"]);
			$t_object_thumb->load($t_rel_entity->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
			$vs_thumb = $t_object_thumb->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
			print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			print $t_rel_entity->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_entities.preferred_labels.displayname</l></div>");
			if($vs_brief_description = $t_rel_entity->get("ca_entities.brief_description")){
				print $vs_brief_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	$va_occurrences = $t_item->get("ca_occurrences", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_occurrences)){
		print "<div class='btn btn-default'>Related event".((sizeof($va_occurrences) > 1) ? "s" : "")."</div>";
		$t_rel_occurrence = new ca_occurrences();
		$i = 0;
		foreach($va_occurrences as $va_occurrence){
			if($i > 0){
				print "<HR/>";
			}
			$t_rel_occurrence->load($va_occurrence["occurrence_id"]);
			$t_object_thumb->load($t_rel_occurrence->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
			$vs_thumb = $t_object_thumb->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
			print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			print $t_rel_occurrence->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_occurrences.preferred_labels.name</l></div>");
			if($vs_brief_description = $t_rel_occurrence->get("ca_occurrences.brief_description")){
				print $vs_brief_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	
?>
</div><!-- end col -->
</div><!-- end row -->
