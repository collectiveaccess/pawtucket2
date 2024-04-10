<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	$va_access_values = caGetUserAccessValues($this->request);	
	$vs_rep_viewer = trim($this->getVar("representationViewer"));
		
	$vb_bottom_box = false;
	if($t_object->get("ca_entities.entity_id", array("checkAccess" => $va_access_values))){
		$vb_bottom_box = true;
	}
	if($t_object->get("ca_occurrences.occurrence_id", array("checkAccess" => $va_access_values))){
		$vb_bottom_box = true;
	}
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
		<div class="row">
			<div class='col-sm-12 col-md-10'>
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<H2>{{{^ca_objects.type_id<ifdef code="ca_objects.idno">, ^ca_objects.idno</ifdef>}}}</H2>
			</div>
			<div class='col-sm-12 col-md-2 inquireCol'>
				<?php print caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id"))); ?>
			</div>
		</div>
		<div class="row">
			<div class='col-sm-6'>
<?php
				if($vs_rep_viewer){
					print $vs_rep_viewer;
				}else{
					print "<div class='detailPlaceholder'><i class='fa fa-image fa-5x' aria-label='media placeholder'></i></div>";
				}
?>			
				<div id="detailAnnotations"></div>
				
<?php 
				if(strToLower($t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))) == "audio"){
					$va_rep_icons = caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "array", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0));
					if($va_rep_icons && sizeof($va_rep_icons)){
						print "<label>Track List</label><div id='detailRepresentationThumbnails'>";
						foreach($va_rep_icons as $vn_icon_rep_id => $vs_icon_link){
							$vs_caption = "";
							$t_icon_rep = new ca_object_representations($vn_icon_rep_id);
							$vs_caption = $t_icon_rep->get("ca_object_representations.preferred_labels.name");
							if(!$vs_caption || $vs_caption == "[BLANK]"){
								$vs_caption = "Untitled";
							}
							$vs_icon_link = str_replace("</a>", " ".$vs_caption."</a>", $vs_icon_link);
							print "<div id='detailRepresentationThumbnail".$vn_icon_rep_id."' class='repThumbnailAudioLinks'>".$vs_icon_link."</div>";
						}
						print "</div>";
					}	
					if($tmp = $this->getVar("audio_full_track_message")){
						print "<div class='unit'>".$tmp."</div>";	
					}
				}else{
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0));
				}
?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span><?= _t('Comments and Tags'); ?> (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 bgLightGray'>
				{{{<ifcount code="ca_collections" min="1">
					<div class="unit"><label>Part of Collection</label>
						<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>
					</div></ifcount>}}}
				
				{{{<ifdef code="ca_objects.date_container.date"><div class="unit"><label>Date</label><unit relativeTo="ca_objects.date_container" delimiter="<br/>"><ifdef code="ca_objects.date_container.date_type">^ca_objects.date_container.date_type </ifdef>^ca_objects.date_container.date<ifdef code="ca_objects.date_container.date_certainty"> (^ca_objects.date_container.date_certainty)</ifdef><ifdef code="ca_objects.date_container.date_note"><br/>^ca_objects.date_container.date_note</ifdef></unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.extent_medium"><div class="unit"><label>Extent and Medium</label>^ca_objects.extent_medium%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.image_extent.image_dimensions|ca_objects.image_extent.image_typelist|ca_objects.image_extent.image_color"><div class="unit"><label>Extent and Medium</label>
					<ifdef code="ca_objects.image_extent.image_dimensions">^ca_objects.image_extent.image_dimensions</ifdef><ifdef code="ca_objects.image_extent.image_typelist"><ifdef code="ca_objects.image_extent.image_dimensions">, </ifdef>^ca_objects.image_extent.image_typelist</ifdef><ifdef code="ca_objects.image_extent.image_color"><ifdef code="ca_objects.image_extent.image_dimensions|ca_objects.image_extent.image_typelist">, </ifdef>^ca_objects.image_extent.image_color </ifdef>
				</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.material_type"><div class="unit"><label>Material Type</label>^ca_objects.material_type%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.materials"><div class="unit"><label>Materials</label>^ca_objects.materials%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.length"><div class="unit"><label>Duration</label>^ca_objects.length%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions"><div class="unit"><label>Dimensions</label>^ca_objects.dimensions%delimiter=,_</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><label>Description</label>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.descriptive_note"><div class="unit"><label>Descriptive Note</label><unit relativeto="ca_objects.descriptive_note" delimiter="<br/>">^ca_objects.descriptive_note</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.instruments"><div class="unit"><label>Instruments</label>^ca_objects.instruments%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.publisher_container.publisher"><div class="unit"><label>Publisher</label><ifdef code="ca_objects.publisher_container.publisher">^ca_objects.publisher_container.publisher</ifdef><ifdef code="ca_objects.publisher_container.pub_place">, ^ca_objects.publisher_container.pub_place</ifdef></div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.language"><div class="unit"><label>Language</label>^ca_objects.language%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.lcna"><div class="unit"><label>LOC Names</label>^ca_objects.lcna%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.lcsh"><div class="unit"><label>LOC Subjects</label>^ca_objects.lcsh%delimiter=,_</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.rights"><div class="unit"><label>Rights</label>^ca_objects.rights%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.access_conditions"><div class="unit"><label>Access Conditions</label>^ca_objects.access_conditions%delimiter=,_</div></ifdef>}}}
<?php
				if($t_object->get("ca_objects.use_reproduction")){
					print $t_object->getWithTemplate('<ifdef code="ca_objects.use_reproduction"><div class="unit"><label>Use and Reproduction Conditions</label>^ca_objects.use_reproduction%delimiter=,_</div></ifdef>');
				}else{
					print "<div class='unit'><label>Use and Reproduction Conditions</label>".$this->getVar("object_use_repro_conditions")."</div>";
				}
?>
				{{{<ifdef code="ca_objects.credit"><div class="unit"><label>Credit Line</label>^ca_objects.credit%delimiter=,_</div></ifdef>}}}

<?php

				$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
				if(is_array($va_entities) && sizeof($va_entities)){
					$va_entities_by_type = array();
					foreach($va_entities as $va_entity_info){
						$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
					}
					foreach($va_entities_by_type as $vs_type => $va_entity_links){
						print "<div class='unit'><label>".$vs_type."</label>".join(", ", $va_entity_links)."</div>";
					}
				}
?>
				{{{<ifcount code="ca_occurrences" restrictToTypes="tour" min="1"><div class="unit"><label>Tour<ifcount code="ca_occurrences" restrictToTypes="tour" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="tour" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence"><l>^ca_occurrences.preferred_labels.name</l></unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="appearance" min="1"><div class="unit"><label>Appearance<ifcount code="ca_occurrences" restrictToTypes="appearance" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="appearance" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence"><l><ifcount code="ca_occurrences.related" restrictToTypes="tour" restrictToRelationshipTypes="included" min="1"><unit relativeTo="ca_occurrences.related" restrictToTypes="tour" restrictToRelationshipTypes="included" delimiter=", ">^ca_occurrences.preferred_labels.name</unit>: </ifcount>^ca_occurrences.preferred_labels.name<ifdef code="ca_occurrences.date_occurrence_container.date_occurrence">, ^ca_occurrences.date_occurrence_container.date_occurrence<ifdef code="ca_occurrences.date_occurrence_container.date_note_occurrence"> (^ca_occurrences.date_occurrence_container.date_note_occurrence)</ifdef></ifdef></l></unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="album" min="1"><div class="unit"><label>Album<ifcount code="ca_occurrences" restrictToTypes="album" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="album" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence"><l>^ca_occurrences.preferred_labels.name</l></unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="reissue" min="1"><div class="unit"><label>Reissue<ifcount code="ca_occurrences" restrictToTypes="reissue" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="reissue" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence"><l>^ca_occurrences.preferred_labels.name</l></unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="studio_session" min="1"><div class="unit"><label>Studio Session<ifcount code="ca_occurrences" restrictToTypes="studio_session" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="studio_session" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence"><l>^ca_occurrences.preferred_labels.name</l></unit></div>
					</ifcount>}}}

				{{{<ifcount code="ca_occurrences" restrictToTypes="song" min="1">
					<div class="unit trimText"><label>Song<ifcount code="ca_occurrences" restrictToTypes="song" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="song" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence"><l>^ca_occurrences.preferred_labels.name</l></unit>
					</div>
				</ifcount>}}}
									
			</div><!-- end col -->
		</div><!-- end row -->
		

		
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
