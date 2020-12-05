 <?php
/* ----------------------------------------------------------------------
 * themes/default/views/Details/ca_occurrences_action_default_html.php : 
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
	$vn_id =				$t_item->get('ca_occurrences.occurrence_id');
	$va_access_values = 	caGetUserAccessValues();
	$vn_representation_id = $this->getVar("representation_id");
	$va_config_options = 	$this->getVar("config_options");
		
	MetaTagManager::addMetaProperty("og:url", $this->request->config->get("site_host").caNavUrl("*", "*", "*"));
	MetaTagManager::addMetaProperty("og:title", ($va_config_options["og_title"]) ? $t_item->getWithTemplate($va_config_options["og_title"]) : $t_item->get("ca_occurrences.preferred_labels.name"));
	MetaTagManager::addMetaProperty("og:type", ($va_config_options["og_type"]) ? $va_config_options["og_type"] : "website");
	if($va_config_options["og_description"] && ($vs_tmp = $t_item->getWithTemplate($va_config_options["og_description"]))){
		MetaTagManager::addMetaProperty("og:description", $vs_tmp);
	}
	if($vs_tmp = $va_config_options["fb_app_id"]){
		MetaTagManager::addMetaProperty("fb:app_id", htmlentities(strip_tags($vs_tmp)));
	}
	if($vs_rep = $t_item->get("ca_object_representations.media.page.url", array("checkAccess" => $va_access_values))){
		MetaTagManager::addMetaProperty("og:image", $vs_rep);
		MetaTagManager::addMetaProperty("og:image:width", $t_object->get("ca_object_representations.media.page.width"));
		MetaTagManager::addMetaProperty("og:image:height", $t_object->get("ca_object_representations.media.page.height"));
	}
	
	$va_related_item_ids = $t_item->get("ca_objects.object_id", array("restrictToTypes" => array("item_select"), "returnAsArray" => true, "checkAccess" => $va_access_values));
	if(is_array($va_related_item_ids) && sizeof($va_related_item_ids)){
		$q_objects = caMakeSearchResult("ca_objects", $va_related_item_ids);
	}
?>
	<div class="row borderBottom">
		<div class='col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 pt-5 pb-2'>
			<H1>Action: {{{^ca_occurrences.preferred_labels}}}</H1>
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
						print "<div class='detailTool'>".caDetailLink("<ion-icon name='document'></ion-icon> <span>Download as PDF</span>", "", "ca_occurrences",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					if ($vn_inquire_enabled) {
						print "<div class='detailTool'>".caNavLink("<ion-icon name='ios-mail'></ion-icon> <span>Inquire</span>", "", "", "Contact", "form", array("table" => "ca_occurrences", "id" => $vn_id))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>
				<div class="row mt-3">
					<div class="col-12 col-md-12">
						{{{<ifdef code="ca_occurrences.date">
							<div class="mb-3">
								<strong>^ca_occurrences.date</strong>
							</div>
						</ifcount>}}}
						{{{<ifdef code="ca_occurrences.idno">
							<div class="mb-3">
								<div class="label">Identifier</div>
								^ca_occurrences.idno
							</div>
							<HR></HR>
						</ifcount>}}}
						{{{<ifdef code="ca_occurrences.external_link">
							<div class="mb-3">
								<unit relativeTo="ca_occurrences.external_link" delimiter="<br/>"><a href="^ca_occurrences.external_link" target="_blank">^ca_occurrences.external_link</a> <ion-icon name="open"></ion-icon></unit>
							</div>
						</ifcount>}}}
						{{{<ifdef code="ca_occurrences.description">
							<div class="mb-3">
								^ca_occurrences.description
							</div>
							<HR></HR>
						</ifdef>}}}
						{{{<ifcount code="ca_objects" min="1" max="1">
							<div class="mb-3">
								<div class="label">Related Item</div>
								<unit relativeTo="ca_objects"><div class="detailPrimaryMedia"><l>^ca_object_representations.media.large</l></div><div class="pt-2 text-center"><l>^ca_objects.preferred_labels</l></div></unit>
							</div>
							<HR></HR>
						</ifcount>}}}
						{{{<ifcount code="ca_collections" min="1">
							<div class="mb-3">
								<div class="label">Project<ifcount code="ca_collections" min="2">s</ifcount></div>
								<unit relativeTo="ca_collections" delimiter=", "><l>^ca_collections.preferred_labels.name</l></unit>
							</div>
						</ifcount>}}}
						{{{<ifdef code="ca_occurrences.phase">
							<div class="mb-3">
								<div class="label">Phase</div>
								^ca_occurrences.phase%delimiter=,_
							</div>
						</ifdef>}}}
						{{{<ifcount code="ca_entities" min="1">
							<div class="mb-3">
								<div class="label">Related People/ Organizations</div>
								<unit relativeTo="ca_entities" delimiter=", ">^ca_entities.preferred_labels</unit>
							</div>
						</ifcount>}}}
						{{{<case>
							<ifcount code="ca_collections" min="1"><HR></HR></ifcount>
							<ifcount code="ca_occurrences" min="1"><HR></HR></ifcount>
							<ifcount code="ca_entities" min="1"><HR></HR></ifcount>
						</case>}}}
<?php
if($showTags){
						$va_tags = $t_item->getTags();
						if(is_array($va_tags) && sizeof($va_tags)){
							$va_tags_processed = array();
							foreach($va_tags as $va_tag){
								$va_tags_processed[$va_tag["tag_id"]] = $va_tag["tag"];
							}
?>
							<div class="mb-3">
								<div class="label">Tags</div>
								<unit relativeTo="ca_item_tags" delimiter=", ">
<?php
									print join(", ", $va_tags_processed);
?>
								</unit>
							</div>
							<HR></HR>
<?php
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
	<div class="col-sm-12 mt-3">
<?php		
	# --- related_items
	if(is_array($va_related_item_ids) && (sizeof($va_related_item_ids) > 2)){
?>
		<div class="row">
			<div class="col-lg-12 mt-5">
				<H1>Related Items</H1>
			</div>
		</div>
		<div class="row mb-5 detailRelated">
<?php
			$i = 0;
			while($q_objects->nextHit()){
				if($q_objects->get("ca_object_representations.media.widepreview")){
					print "<div class='col-sm-6 col-md-4 col-lg-4 col-xl-2 pb-4 mb-4'>";
					print $q_objects->getWithTemplate("<l>^ca_object_representations.media.widepreview</l>");
					print "<div class='pt-2'>".caDetailLink(substr(strip_tags($q_objects->get("ca_objects.preferred_labels")), 0, 30), '', 'ca_objects', $q_objects->get("ca_objects.object_id"))."</div>";
					print "</div>";
					$i++;
				}
			}
?>
		</div>
<?php		
	}
?>

	</div>
</div>