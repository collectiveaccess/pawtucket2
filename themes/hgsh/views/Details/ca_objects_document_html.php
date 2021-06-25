<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = $this->getVar("access_values");
	$va_rep_ids = $t_item->getRepresentationIds(array("checkAccess" => $va_access_values));
	$vb_multiple_reps = false;
	if(is_array($va_rep_ids) && (sizeof($va_rep_ids) > 1)){
		$vb_multiple_reps = true;
	}
	$t_rep = $this->getVar("t_representation");
	if($t_rep){
		$vn_rep_id = $t_rep->get("ca_object_representations.representation_id");
		$va_media_info = $t_rep->getMediaInfo("ca_object_representations.media");
	}
	# --- make an array of all the pages in this issue (parent and siblings from object hierarchy)
	$va_issue_ids = array();
	if($t_item->get("ca_objects.parent_id")){
		$t_parent = new ca_objects($t_item->get("ca_objects.parent_id"));
		$va_issue_ids[] = $t_parent->get("ca_objects.object_id");
		$va_children = $t_parent->get("ca_objects.children.object_id", array("returnAsArray" => true, "sort" => "ca_objects.idno"));
	}else{
		$va_issue_ids[] = $t_item->get("ca_objects.object_id");
		$va_children = $t_item->get("ca_objects.children.object_id", array("returnAsArray" => true, "sort" => "ca_objects.idno"));
	}
	if(is_array($va_children) && sizeof($va_children)){
		foreach($va_children as $va_child_id){
			$va_issue_ids[] = $va_child_id;
		}
	}
	$vn_previous_issue_page_id = $vn_next_issue_page_id;
	if(in_array($t_item->get("ca_objects.object_id"), $va_issue_ids)){
		$vn_this_page_key = array_search($t_item->get("ca_objects.object_id"), $va_issue_ids);
		if($vn_this_page_key > 0){
			$vn_previous_issue_page_id = $va_issue_ids[$vn_this_page_key - 1];
		}
		if($vn_this_page_key < (sizeof($va_issue_ids) - 2)){
			$vn_next_issue_page_id = $va_issue_ids[$vn_this_page_key + 1];
		}
	}
	$va_detail_collections = $t_item->get("ca_collections.collection_id", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("history"), "checkAccess" => $va_access_values));
	if(!$va_detail_collections && $t_parent){
		$va_detail_collections = $t_parent->get("ca_collections.collection_id", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("history"), "checkAccess" => $va_access_values));
	}
	$va_featured_collections = $t_item->get("ca_collections.collection_id", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("featured"), "checkAccess" => $va_access_values));
	if(!$va_featured_collections && $t_parent){
		$va_featured_collections = $t_parent->get("ca_collections.collection_id", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("featured"), "checkAccess" => $va_access_values));
	}
	
	
?>
<div class="row">
	<div class='col-xs-12'>
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div>
</div><!-- end row -->
<div class="row">
	<div class="col-sm-12 col-md-4">
<?php
	if($vn_previous_issue_page_id){
		print caDetailLink($this->request, "< Previous Page", "btn btn-blue btn-small", "ca_objects", $vn_previous_issue_page_id);
	}
?>
	</div>
	<div class="col-sm-12 col-md-4 text-center">
<?php
		$vn_collection_id = $t_item->get("ca_collections.collection_id");
		if(!$vn_collection_id && $t_parent){
			$vn_collection_id = $t_parent->get("ca_collections.collection_id");
		}
		if($vn_collection_id){
			print caDetailLink($this->request, "<< All Issues", "btn btn-blue btn-small", "ca_collections", $vn_collection_id);
		}
?>
	</div>
	<div class="col-sm-12 col-md-4 text-right">
<?php
	if($vn_next_issue_page_id){
		print caDetailLink($this->request, "Next Page >", "btn btn-blue btn-small", "ca_objects", $vn_next_issue_page_id);
	}
?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="detailTitle short">{{{ca_objects.preferred_labels.name}}}</div>
	</div>
</div>
<div class="row">
<?php
	if($vb_multiple_reps){
?>
	<div class='col-sm-1'>
		<div class="row">
			<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-md-12 col-xs-4")); ?>
		</div>
	</div>
<?php
	}
?>

	<div class='col-sm-<?php print ($vb_multiple_reps) ? "11" : "12"; ?>'>
		<div class="detailTitleSmall">{{{ca_objects.preferred_labels.name}}}</div>
		{{{representationViewer}}}
		<div class="row">
			<div class="col-xs-12">
<?php
			if($vn_rep_id){
			#if($vn_rep_id && ($va_media_info["INPUT"]["MIMETYPE"] == "application/pdf")){
				print "<div class='pdfRepNav'><a href='#' class='btn btn-blue' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $t_item->get("ca_objects.object_id"), 'representation_id' => $vn_rep_id, 'overlay' => 1))."\"); return false;' title='"._t("Zoom")."'>Fullscreen <span class='glyphicon glyphicon-zoom-in'></span></a>";
				print caNavLink($this->request, "Download <span class='glyphicon glyphicon-download-alt'></span>", 'btn btn-blue', 'Detail', 'DownloadRepresentation', '', array('context' => 'objects', 'representation_id' => $vn_rep_id, "id" => $t_item->get("ca_objects.object_id"), "download" => 1, "version" => "original"));
				print "</div>";
			}
?>
			</div>
		</div>
		{{{<ifdef code="ca_objects.description"><br/><p>^ca_objects.description</p></ifdef>}}}
		{{{<ifdef code="ca_objects.additional_info">
				<div class="detailMoreInfo" id="additional_info_link"><a href="#" onClick="jQuery('#additional_info').toggle(); jQuery('#additional_info_link').toggle(); return false;">Read More <span class="glyphicon glyphicon-arrow-down small"></span></a></div>
				<p id='additional_info' style='display:none;'>^ca_objects.additional_info<br/><a href="#" onClick="jQuery('#additional_info').toggle(); jQuery('#additional_info_link').toggle(); return false;" class="detailMoreInfo">Hide <span class="glyphicon glyphicon-arrow-up"></span></a></p>
		</ifdef>}}}
		<div class='detailBlueText'>{{{^ca_objects.type_id, }}}{{{^ca_objects.idno}}}</div>
		
		{{{<ifdef code="ca_objects.parent_id">
			<div class="row">
				<div class="col-sm-12"><div class='btn btn-default text-left'>More from this issue</div></div>
			</div>
			<div class="row detailRelatedThumb detailIssuePages">
				<unit relativeTo="ca_objects.parent">
					<div class="col-xs-6 col-sm-2"><l>^ca_object_representations.media.iconlarge<br/>^ca_objects.preferred_labels.name</l></div>
					<unit relativeTo="ca_objects.children" delimiter=" " sort="ca_objects.idno">
						<div class="col-xs-6 col-sm-2"><l>^ca_object_representations.media.iconlarge<br/>^ca_objects.preferred_labels.name</l></div>
					</unit>
				</unit>
		</div></ifdef>}}}
		{{{<ifdef code="ca_objects.children.object_id">
			<div class="row">
				<div class="col-sm-12"><div class='btn btn-default text-left'>More from this issue</div></div>
			</div>
			<div class="row detailRelatedThumb detailIssuePages">
				
				<div class="col-xs-6 col-sm-2"><l>^ca_object_representations.media.iconlarge<br/>^ca_objects.preferred_labels.name</l></div>
				<unit relativeTo="ca_objects.children" delimiter=" " sort="ca_objects.idno">
					<div class="col-xs-6 col-sm-2"><l>^ca_object_representations.media.iconlarge<br/>^ca_objects.preferred_labels.name</l></div>
				</unit>
		</div></ifdef>}}}

	</div><!-- end col -->
</div><!-- end row -->
<div class="row">
	<div class='col-sm-12'>
<?php
	if ($va_links = $t_item->get('ca_objects.external_link', array('returnWithStructure' => true))) {
		print "<div class='btn btn-default text-left'>Related links</div><div>";
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
	$t_object_thumb = new ca_objects();
	$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_entities)){
		if(sizeof($va_entities) == 1){
			print "<div class='btn btn-default text-left'>Related person/organisation</div>";
		}else{
			print "<div class='btn btn-default text-left'>Related people/organisations</div>";
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
			print "<div class='row'>";
			if($vs_thumb){
				print "<div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
				print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			}else{
				print "<div class='col-sm-12'>\n";
			}
			print $t_rel_entity->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_entities.preferred_labels.displayname</l></div>");
			if($vs_brief_description = $t_rel_entity->get("ca_entities.brief_description")){
				print $vs_brief_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	#featured collections
	if(is_array($va_featured_collections) && sizeof($va_featured_collections)){
		$q_featured_collections = caMakeSearchResult('ca_collections', $va_featured_collections);
		if($q_featured_collections->numHits()){
			print "<div class='btn btn-default text-left'>Featured Collection".((sizeof($va_featured_collections) > 1) ? "s" : "")."</div>";
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
			print "<div class='btn btn-default text-left'>Detailed Histor".((sizeof($va_detail_collections) > 1) ? "ies" : "y")."</div>";
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
	if(!$va_collections && $t_parent){
		$va_collections = $t_parent->get("ca_collections", array("returnWithStructure" => true, 'excludeRelationshipTypes' => array('featured', 'history'), "checkAccess" => $va_access_values));
	}
	if(sizeof($va_collections)){
		print "<div class='btn btn-default text-left'>Related Collection".((sizeof($va_collections) > 1) ? "s" : "")."</div>";
		$t_rel_collection = new ca_collections();
		$i = 0;
		foreach($va_collections as $va_collection){
			if($i > 0){
				print "<HR/>";
			}
			$t_rel_collection->load($va_collection["collection_id"]);
			$t_object_thumb->load($t_rel_collection->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
			$vs_thumb = $t_object_thumb->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'>";
			if($vs_thumb){
				print "<div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
				print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			}else{
				print "<div class='col-sm-12'>\n";
			}
			print $t_rel_collection->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_collections.preferred_labels.name</l></div>");
			if($vs_brief_description = $t_rel_collection->get("ca_collections.brief_description")){
				print $vs_brief_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	$va_places = $t_item->get("ca_places", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_places)){
		print "<div class='btn btn-default text-left'>Related place".((sizeof($va_places) > 1) ? "s" : "")."</div>";
		$t_rel_place = new ca_places();
		$i = 0;
		foreach($va_places as $va_place){
			if($i > 0){
				print "<HR/>";
			}
			$t_rel_place->load($va_place["place_id"]);
			$t_object_thumb->load($t_rel_place->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
			$vs_thumb = $t_object_thumb->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'>";
			if($vs_thumb){
				print "<div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
				print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			}else{
				print "<div class='col-sm-12'>\n";
			}
			print $t_rel_place->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_places.preferred_labels.name</l></div>");
			if($vs_brief_description = $t_rel_place->get("ca_places.brief_description")){
				print $vs_brief_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	$va_occurrences = $t_item->get("ca_occurrences", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_occurrences)){
		print "<div class='btn btn-default text-left'>Related event".((sizeof($va_occurrences) > 1) ? "s" : "")."</div>";
		$t_rel_occurrence = new ca_occurrences();
		$i = 0;
		foreach($va_occurrences as $va_occurrence){
			if($i > 0){
				print "<HR/>";
			}
			$t_rel_occurrence->load($va_occurrence["occurrence_id"]);
			$t_object_thumb->load($t_rel_occurrence->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
			$vs_thumb = $t_object_thumb->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'>";
			if($vs_thumb){
				print "<div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
				print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			}else{
				print "<div class='col-sm-12'>\n";
			}
			print $t_rel_occurrence->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_occurrences.preferred_labels.name</l></div>");
			if($vs_brief_description = $t_rel_occurrence->get("ca_occurrences.brief_description")){
				print $vs_brief_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	$va_related_object_ids = $t_item->get("ca_objects.related.object_id", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_related_object_ids)){
		$q_related_objects = caMakeSearchResult('ca_objects', $va_related_object_ids);
		print "<div class='btn btn-default text-left'>Related object".((sizeof($va_related_object_ids) == 1) ? "" : "s")."</div>";
		$i = 0;
		while($q_related_objects->nextHit()){
			if($i > 0){
				print "<HR/>";
			}
			$vs_thumb = $q_related_objects->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'>";
			if($vs_thumb){
				print "<div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
				print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			}else{
				print "<div class='col-sm-12'>\n";
			}
			print $q_related_objects->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_objects.preferred_labels.name</l></div>");
			if($vs_description = $q_related_objects->get("ca_objects.description")){
				print $vs_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	
?><br/><br/>
</div><!-- end col -->
</div><!-- end row -->
