<?php
	AssetLoadManager::register('maps');
	$va_access_values = $this->getVar("access_values");
	
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$qr_res = ca_places::find(['parent_id' => $t_item->get('ca_places.place_id'), 'access' => 1], ['returnAs' => 'searchResult']);
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

	# --- place groups type_id = 167
	$qr_place_groups = ca_places::find(['type_id' => 167, 'access' => 1], ['returnAs' => 'searchResult']);

?>
<div class="row">
</div><!-- end row -->
<div class="row">		
<div class='col-sm-8'>
	<div class="row">
		<div class="col-sm-12">
			<div id="placeMapContainer">
<?php
			if($qr_res->numHits()){
				$qr_res->seek(0);
	
				$vs_label_template = "<l>^ca_places.preferred_labels.name</l>";
				$va_opts = array(
				    'renderLabelAsLink' => false, 
				    'request' => $this->request, 
				    'color' => '#cc0000', 
				    'labelTemplate' => $vs_label_template,
				    'contentTemplate' => "<ifdef code='ca_object_representations.media.icon'><div style='float:left; margin:0px 10px 10px 0px;'>^ca_object_representations.media.icon</div></ifdef><ifnotdef code='ca_object_representations.media.icon'><unit relativeTo='ca_objects' length='1'><div style='float:left; margin:0px 10px 10px 0px;'>^ca_object_representations.media.icon</div></unit></ifnotdef><p>^ca_places.brief_description</p>",
				    //'ajaxContentUrl' => caNavUrl($this->request, '*', '*', 'AjaxGetMapItem', array('browse' => $ps_function,'view' => $ps_view))
				);
				
				$o_map = new GeographicMap("100%", "600px");
				$o_map->mapFrom($qr_res, "ca_places.georeference", $va_opts);
				print $o_map->render('HTML', array('labelTemplate' => $vs_label_template, 'circle' => 0, 'minZoomLevel' => null, 'maxZoomLevel' => 100, 'noWrap' => null, 'request' => $this->request));

			}
?>
			</div><!-- end browseResultsContainer -->
		</div>
	</div>
	<div class="row">
		<div id="browsePlaceResultsContainer">
<?php
		$qr_res->seek(0);
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
	# related items
	$va_related_objects = $t_item->get("ca_objects.object_id", array("returnWithStructure" => true, "excludeRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values));
	
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
	<div class="detailTitle short">{{{^ca_places.preferred_labels}}}</div>
	<p>{{{<ifdef code="ca_places.description">^ca_places.description</ifdef>}}}</p>
<?php

	if($qr_place_groups->numHits() > 0){
		print "<div class='btn btn-default'>Explore Places</div>";
		$i = 0;
		while($qr_place_groups->nextHit()){
			if($i > 0){
				print "<HR/>";
			}
			
			$vs_thumb = $qr_place_groups->getWithTemplate("<ifdef code='ca_object_representations.media.widepreview'><l>^ca_object_representations.media.widepreview</l></ifdef>");
			if(!$vs_thumb){
				$vs_thumb = $qr_place_groups->getWithTemplate("<l><unit relativeTo='ca_objects' length='1'>^ca_object_representations.media.widepreview</unit></l>", array("checkAccess" => $va_access_values, "limit" => 1));
			}
			print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
			print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			print $qr_place_groups->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_places.preferred_labels</l></div>");
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
