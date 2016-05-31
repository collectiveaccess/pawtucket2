<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = $this->getVar("access_values");
	$va_rep_ids = $t_item->getRepresentationIds(array("checkAccess" => $va_access_values));
	$vb_multiple_reps = false;
	if(is_array($va_rep_ids) && (sizeof($va_rep_ids) > 1)){
		$vb_multiple_reps = true;
	}
?>
<div class="row">
	<div class='col-xs-12'>
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div>
</div><!-- end row -->
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
<div class='col-sm-<?php print ($vb_multiple_reps) ? "7" : "8"; ?>'>
	<div class="detailTitleSmall">{{{ca_objects.preferred_labels.name}}}</div>
	{{{representationViewer}}}
	{{{<ifdef code="ca_objects.description"><br/><p>^ca_objects.description</p></ifdef>}}}
	{{{<ifdef code="ca_objects.additional_info">
			<div class="detailMoreInfo" id="additional_info_link"><a href="#" onClick="jQuery('#additional_info').toggle(); jQuery('#additional_info_link').toggle(); return false;">Read More <span class="glyphicon glyphicon-arrow-down small"></span></a></div>
			<p id='additional_info' style='display:none;'>^ca_objects.additional_info<br/><a href="#" onClick="jQuery('#additional_info').toggle(); jQuery('#additional_info_link').toggle(); return false;" class="detailMoreInfo">Hide <span class="glyphicon glyphicon-arrow-up"></span></a></p>
	</ifdef>}}}
	<div class='detailBlueText'>{{{^ca_objects.type_id, }}}{{{^ca_objects.idno}}}</div>
</div><!-- end col -->
<div class='col-sm-4'>
	<div class="detailTitle">{{{ca_objects.preferred_labels.name}}}</div>
<?php
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
	$va_collections = $t_item->get("ca_collections", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_collections)){
		print "<div class='btn btn-default'>Related collection".((sizeof($va_collections) > 1) ? "s" : "")."</div>";
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
	$va_places = $t_item->get("ca_places", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_places)){
		print "<div class='btn btn-default'>Related place".((sizeof($va_places) > 1) ? "s" : "")."</div>";
		$t_rel_place = new ca_places();
		$i = 0;
		foreach($va_places as $va_place){
			if($i > 0){
				print "<HR/>";
			}
			$t_rel_place->load($va_place["place_id"]);
			$t_object_thumb->load($t_rel_place->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
			$vs_thumb = $t_object_thumb->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
			print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
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
	$va_related_object_ids = $t_item->get("ca_objects.related.object_id", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_related_object_ids)){
		$q_related_objects = caMakeSearchResult('ca_objects', $va_related_object_ids);
		print "<div class='btn btn-default'>Related object".((sizeof($va_related_object_ids) == 1) ? "" : "s")."</div>";
		$i = 0;
		while($q_related_objects->nextHit()){
			if($i > 0){
				print "<HR/>";
			}
			$vs_thumb = $q_related_objects->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "limit" => 1));
			print "<div class='row'><div class='col-sm-4 col-md-4 col-lg-4 detailRelatedThumb'>".$vs_thumb."</div>\n";
			print "<div class='col-sm-8 col-md-8 col-lg-8'>\n";
			print $q_related_objects->getWithTemplate("<div class='detailRelatedTitle'><l>^ca_objects.preferred_labels.name</l></div>");
			if($vs_description = $q_related_objects->get("ca_objects.description")){
				print $vs_description;
			}
			print "</div></div><!-- end row -->";
			$i++;
		}
	}
	
?>
</div><!-- end col -->
</div><!-- end row -->