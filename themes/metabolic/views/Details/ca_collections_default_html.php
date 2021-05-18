 <?php
/* ----------------------------------------------------------------------
 * themes/default/views/Details/ca_collections_default_html.php : 
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2019 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */

	$t_item =	 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_inquire_enabled = 	$this->getVar("inquireEnabled");
	$vn_id =				$t_item->get('ca_collections.collection_id');
	$va_access_values = 	caGetUserAccessValues();
	$vn_representation_id = $this->getVar("representation_id");
	$va_config_options = 	$this->getVar("config_options");
	MetaTagManager::addMetaProperty("og:url", $this->request->config->get("site_host").caNavUrl("*", "*", "*"));
	MetaTagManager::addMetaProperty("og:title", ($va_config_options["og_title"]) ? $t_item->getWithTemplate($va_config_options["og_title"]) : $t_item->get("ca_occurrences.preferred_labels.name"));
	MetaTagManager::addMetaProperty("og:type", ($va_config_options["og_type"]) ? $va_config_options["og_type"] : "website");
	if($va_config_options["og_description"] && ($vs_tmp = $t_item->getWithTemplate($va_config_options["og_description"]))){
		MetaTagManager::addMetaProperty("og:description", htmlentities(strip_tags($vs_tmp)));
	}
	if($vs_tmp = $va_config_options["fb_app_id"]){
		MetaTagManager::addMetaProperty("fb:app_id", $vs_tmp);
	}
	if($vs_rep = $t_item->get("ca_object_representations.media.page.url", array("checkAccess" => $va_access_values))){
		MetaTagManager::addMetaProperty("og:image", $vs_rep);
		MetaTagManager::addMetaProperty("og:image:width", $t_item->get("ca_object_representations.media.page.width"));
		MetaTagManager::addMetaProperty("og:image:height", $t_item->get("ca_object_representations.media.page.height"));
	}
?>
	<div class="row borderBottom">
		<div class='col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 pt-5 pb-2'>
			<H1>Action: {{{^ca_collections.preferred_labels}}}</H1>
		</div>
	</div>
	<div class="row">
		<div class='col-12 navTop text-center'><!--- only shown at small screen size -->
			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
		</div><!-- end detailTop -->
	<div class='navLeftRight text-left col-sm-1 col-lg-2'>
		<div class="detailNavBgLeft">
			{{{resultsLink}}}<br/>{{{previousLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-12 col-sm-10 col-md-10 col-lg-8'>
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled || $vn_pdf_enabled || $vn_inquire_enabled) {
						
					print '<div id="detailTools" class="mt-2">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><ion-icon name="chatboxes"></ion-icon> <span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</span></a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'>".caDetailLink("<ion-icon name='document'></ion-icon> <span>Download as PDF</span>", "", "ca_collections",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					if ($vn_inquire_enabled) {
						print "<div class='detailTool'>".caNavLink("<ion-icon name='ios-mail'></ion-icon> <span>Inquire</span>", "", "", "Contact", "form", array("table" => "ca_collections", "id" => $vn_id))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>
				<div class="row mt-3">
					<div class="col-12 col-md-12">
						{{{<ifdef code="ca_collections.date">
							<div class="mb-3">
								<div class="label">^ca_collections.date</div>
							</div>
						</ifcount>}}}
						{{{<ifdef code="ca_collections.description">
							<div class="mb-3">
								<div class="readMore">
									<div class="collapse" id="collapseSummary">
										<div>^ca_collections.description</div>
									</div>
										<a class="collapsed" data-toggle="collapse" href="#collapseSummary" aria-expanded="false" aria-controls="collapseSummary"></a>
								</div>
							</div>
						</ifdef>}}}					
<?php						
						# --- bio-regions
						$t_list_item = new ca_list_items();
						$va_bio_regions = $t_item->get("ca_collections.bio_regions", array("returnAsArray" => true));
						if(is_array($va_bio_regions) && sizeof($va_bio_regions)){
?>
							<div class="mb-3">
								<div class="label">Bio-Regions <span class="material-icons" role="button" data-toggle="collapse" data-target="#bioRegionDesc" aria-expanded="false" aria-controls="bioRegionDesc">info</span></div>
								<div class="mb-3 collapse small" id="bioRegionDesc">
								  A region defined by characteristics of the natural environment rather than man-made division.
								</div>
<?php
								$va_bio_region_links = array();
								foreach($va_bio_regions as $vn_bio_region_id){
									$t_list_item->load($vn_bio_region_id);
									$va_bio_region_links[] = caNavLink($t_list_item->get("ca_list_item_labels.name_singular"), "", "", "Browse", "objects", array("facet" => "bio_regions_facet", "id" => $vn_bio_region_id));
								}
								print join($va_bio_region_links, ", ");
?>
							</div>
<?php								
							

						}

						# --- rel entities by role
						$va_entities = $t_item->get("ca_entities", array("excludeRelationshipTypes" => array("related"), "returnWithStructure" => true, "checkAccess" => $va_access_value, "sort" => "ca_entity_labels.surname"));
						if(is_array($va_entities) && sizeof($va_entities)){
							$va_entities_by_role = array();
							$va_visionary = array();
							foreach($va_entities as $va_entity_info){
								if(strToLower($va_entity_info["relationship_typename"]) == "visionary"){
									$va_visionary[] = caNavLink($va_entity_info["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_entity_info["entity_id"]));
								}else{
									$va_entities_by_role[$va_entity_info["relationship_typename"]][] = caNavLink($va_entity_info["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_entity_info["entity_id"]));
								}
							}
							if(sizeof($va_visionary)){
?>
								<div class="mb-3">
									<div class="label">Visionary</div>
<?php
									print join($va_visionary, ", ");
?>
								</div>
<?php
								
							}
							ksort($va_entities_by_role);
							foreach($va_entities_by_role as $vs_role => $va_names){
?>
								<div class="mb-3">
									<div class="label"><?php print $vs_role; ?></div>
<?php
									print join($va_names, ", ");
?>
								</div>
<?php
							}
						}


if($x_show_exhibitions){
						#$vs_exhibitions = $t_item->getWithTemplate("<unit relativeTo='ca_objects' aggregateUnique='1' unique='1' delimiter=' '><unit relativeTo='ca_occurrences' restrictToTypes='exhibition' delimiter=' '><div class='mb-3'>^ca_occurrences.preferred_labels</div></unit></unit>", array("checkAccess" => $va_access_values));
						$va_related_exhibition_ids = $t_item->get("ca_occurrences.occurrence_id", array("restrictToTypes" => array("exhibition"), "relativeTo" => "ca_objects", "returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_occurrences.date"));
						$va_related_exhibition_ids = array_reverse($va_related_exhibition_ids);
						if(is_array($va_related_exhibition_ids) && sizeof($va_related_exhibition_ids)){
							$q_exhibitions = caMakeSearchResult("ca_occurrences", $va_related_exhibition_ids);
							if($q_exhibitions->numHits()){
								print "<div class='mb-3'><div class='label'>Exhibitions</div>";
								while($q_exhibitions->nextHit()){
									print $q_exhibitions->getWithTemplate("<div class='mb-3'><l>^ca_occurrences.preferred_labels.name</l><case><ifcount code='ca_entities' restrictToTypes='org' restrictToRelationshipTypes='venue' min='1'><br/></ifcount><ifdef code='ca_occurrences.date'><br/></ifdef></case><ifcount code='ca_entities' restrictToTypes='org' restrictToRelationshipTypes='venue' min='1'><unit relativeTo='ca_entities' restrictToTypes='org' restrictToRelationshipTypes='venue' delimiter=', '>^ca_entities.preferred_labels</unit><ifdef code='ca_occurrences.date'>, </ifdef></ifcount><ifdef code='ca_occurrences.date'>^ca_occurrences.date</ifdef></div>");
								}
								print "</div><HR></HR>";
							}
						}
}
?>
					</div>
				</div>
						
	</div><!-- end col -->
	<div class='navLeftRight text-right col-sm-1 col-lg-2'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<div class="row">
	<div class="col-sm-12">
<?php
	# --- subjects
	$t_list_item = new ca_list_items();
	$va_subjects = $t_item->get("ca_collections.subject", array("returnAsArray" => true));
	if(is_array($va_subjects) && sizeof($va_subjects)){
?>
		<div class="row mt-3">
			<div class="col-sm-12 mt-5">
				<H1>Themes</H1>
			</div>
		</div>
		<div class="row bg-1 pt-4 mb-5 detailTags">
<?php
			foreach($va_subjects as $vn_subject_id){
				$t_list_item->load($vn_subject_id);
				if(in_array($t_list_item->get("ca_list_items.access"), $va_access_values)){
?>
				<div class="col-sm-6 col-md-3 pb-4">
					<?php print caNavLink("<div class='bg-2 text-center py-2 uppercase'>".$t_list_item->get("ca_list_item_labels.name_singular")."</div>", "", "", "Browse", "objects", array("facet" => "subject_facet", "id" => $vn_subject_id)); ?>
				</div>
<?php
				}
			}

?>
		</div>
<?php
	}
if($x_show_events){
	# --- related actions
	$va_related_action_ids = $t_item->get("ca_occurrences.occurrence_id", array("restrictToTypes" => array("action"), "returnAsArray" => true, "checkAccess" => $va_access_values, "length" => 50));
	if(is_array($va_related_action_ids) && sizeof($va_related_action_ids)){
		shuffle($va_related_action_ids);
		$q_actions = caMakeSearchResult("ca_occurrences", $va_related_action_ids);
?>
	<div class="row mt-3">
		<div class="col-8 mt-5">
			<H1>Events</H1>
		</div>
		<div class="col-4 mt-5 text-right">

<?php
			if($q_actions->numHits() > 6){
				print caNavLink("View All", "btn btn-primary", "", "Browse", "actions", array("facet" => "collection_facet", "id" => $t_item->get("ca_collections.collection_id")));		
			}
?>
		</div>
	</div>
<?php
}
?>
	<div class="row mb-3 detailRelated">
<?php
		$i = 0;
		$va_tmp_ids = array();
		while($q_actions->nextHit()){
			if($vs_img = $q_actions->getWithTemplate("<unit relativeTo='ca_objects' length='1'>^ca_object_representations.media.widepreview</unit>")){
				print "<div class='col-sm-6 col-md-4 col-lg-4 col-xl-2'>";
				print caDetailLink($vs_img, '', 'ca_occurrences', $q_actions->get("ca_occurrences.occurrence_id"));
				#print "<div class='pt-2'>".caDetailLink(substr(strip_tags($q_actions->get("ca_occurrences.preferred_labels")), 0, 30), '', 'ca_occurrences', $q_actions->get("ca_occurrences.occurrence_id"))."</div>";
				print "<div class='pt-2'>".caDetailLink($q_actions->get("ca_occurrences.preferred_labels"), '', 'ca_occurrences', $q_actions->get("ca_occurrences.occurrence_id"))."</div>";
				print "</div>";
				$i++;
				$va_tmp_ids[] = $q_actions->get("ca_occurrences.occurrence_id");
			}
			if($i == 6){
				break;
			}
		}
?>
	</div>

<?php		
		$o_context = new ResultContext($this->request, 'ca_occurrences', 'detailRelated');
		$o_context->setAsLastFind();
		$o_context->setResultList($va_tmp_ids);
		$o_context->saveContext();
	}

	$va_tmp_ids = array();
	$va_related_album_ids = $t_item->get("ca_objects.object_id", array("restrictToTypes" => array("album"), "restrictToRelationshipTypes" => array("featured"), "returnAsArray" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_related_album_ids)){	
		# --- related_items
		shuffle($va_related_album_ids);
		$q_objects = caMakeSearchResult("ca_objects", array_slice($va_related_album_ids,0,400));
?>
		<div class="row mt-3">
			<div class="col-7 mt-5">
				<H1>Albums</H1>
			</div>
			<div class="col-5 mt-5 text-right">
				<?php print caNavLink("View All", "btn btn-primary", "", "Browse", "objects", array("facet" => "collection_facet", "id" => $t_item->get("ca_collections.collection_id"))); ?>
			</div>
		</div>
		<div class="row mb-3 detailRelated">
<?php
			$i = 0;
			while($q_objects->nextHit()){
				#if(!$q_objects->get("ca_objects.parent_id") && $q_objects->get("ca_object_representations.media.widepreview")){
					print "<div class='col-sm-6 col-md-4 col-lg-4 col-xl-2 pb-4 mb-4'>";
					print $q_objects->getWithTemplate("<l>^ca_object_representations.media.widepreview</l>");
					$vs_idno = substr(strip_tags($q_objects->get("ca_objects.idno")), 0, 30);
					if($q_objects->get("ca_objects.preferred_labels.name")){
						$vs_title = "<br/>".$q_objects->get("ca_objects.preferred_labels.name");
					}
					print "<div class='pt-2'>".caDetailLink($vs_idno.$vs_title, '', 'ca_objects', $q_objects->get("ca_objects.object_id"))."</div>";
					print "</div>";
					$i++;
					$va_tmp_ids[] = $q_objects->get("ca_objects.object_id");
				#}
				if($i == 12){
					break;
				}
			}
?>
		</div>

<?php		
	}
	//$va_related_item_ids = $t_item->get("ca_objects.object_id", array("restrictToTypes" => array("item"), "restrictToRelationshipTypes" => array("featured"), "returnAsArray" => true, "checkAccess" => $va_access_values));
	$va_related_item_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_related_item_ids)){	
		# --- related_items
		shuffle($va_related_item_ids);
		$q_objects = caMakeSearchResult("ca_objects", array_slice($va_related_item_ids,0,400));
?>
		<div class="row mt-3">
			<div class="col-7 mt-5">
				<H1>Assets</H1>
			</div>
			<div class="col-5 mt-5 text-right">
				<?php print caNavLink("View All", "btn btn-primary", "", "Browse", "objects", array("facet" => "collection_facet", "id" => $t_item->get("ca_collections.collection_id"))); ?>
			</div>
		</div>
		<div class="row mb-3 detailRelated">
<?php
			$i = 0;
			while($q_objects->nextHit()){
				if($q_objects->get("ca_object_representations.media.widepreview")){
					print "<div class='col-sm-6 col-md-4 col-lg-4 col-xl-2 pb-4 mb-4'>";
					print $q_objects->getWithTemplate("<l>^ca_object_representations.media.widepreview</l>");
					print "<div class='pt-2'>".caDetailLink(substr(strip_tags($q_objects->get("ca_objects.idno")), 0, 30), '', 'ca_objects', $q_objects->get("ca_objects.object_id"))."</div>";
					print "</div>";
					$i++;
					$va_tmp_ids[] = $q_objects->get("ca_objects.object_id");
				}
				if($i == 12){
					break;
				}
			}
?>
		</div>

<?php		
	}
	if(sizeof($va_tmp_ids)){
		$o_context = new ResultContext($this->request, 'ca_objects', 'detailRelated');
		$o_context->setAsLastFind();
		$o_context->setResultList($va_tmp_ids);
		$o_context->saveContext();
	}
?>

	</div>
</div>