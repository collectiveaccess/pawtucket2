<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
			<div class="row">
				<div class='col-md-12 col-lg-12 text-center'>
					<H1>{{{^ca_objects.type_id}}}</H1>
					<H2>{{{^ca_objects.preferred_labels.name}}}</H2>
					<hr/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
<?php
			if($vs_rep_viewer){
?>
				<div class='col-sm-6 col-md-6 col-lg-6'>
					
					<?php print $vs_rep_viewer; ?>
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
					
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
			}else{
?>
				<div class='col-sm-12'>
<?php
			}
?>
					{{{<ifdef code="ca_objects.descriptionWithSource.prodesc_text"><div class='unit trimText'><label>Description</label>^ca_objects.descriptionWithSource.prodesc_text</div></ifdef>}}}
					{{{<ifdef code="ca_objects.eventDate"><div class='unit trimText'><label>Date</label>^ca_objects.eventDate</div></ifdef>}}}
					
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="author" min="1"><div class='unit trimText'><label>Author</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="depicts" min="1"><div class='unit trimText'><label>Depicts</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="depicts" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="described" min="1"><div class='unit trimText'><label>Describes</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="described" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifdef code="ca_objects.av_camera_angle_type"><div class='unit trimText'><label>Camera Angle</label>^ca_objects.av_camera_angle_type</div></ifdef>}}}
					{{{<ifdef code="ca_objects.format_av_analog"><div class='unit trimText'><label>Original media format</label>^ca_objects.format_av_analog</div></ifdef>}}}
					
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="photographer" min="1"><div class='unit trimText'><label>Photographer<ifcount code="ca_entities" restrictToRelationshipTypes="photographer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="photographer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="videographer" min="1"><div class='unit trimText'><label>Videographer<ifcount code="ca_entities" restrictToRelationshipTypes="videographer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="videographer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="1"><div class='unit trimText'><label>Creator<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="presenter" min="1"><div class='unit trimText'><label>Presenter<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="presenter" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
					{{{<ifdef code="ca_objects.language"><div class='unit trimText'><label>Language</label>^ca_objects.language</div></ifdef>}}}
					
<?php

					if(in_array(strToLower($t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => "true"))), array("program", "programs"))){
						print "<div class='unit trimText'><label>Usage Statement</label>";
						if($vs_rights = $this->getVar("detail_usage_statement_programs")){
							print $vs_rights;
						}
						print "</div>";
					}
?>
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="rights_holder" min="1"><div class='unit trimText'><label>Rights Holder<ifcount code="ca_entities" restrictToRelationshipTypes="rights_holder" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="rights_holder" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></ifcount>}}}
										
					{{{<ifdef code="ca_objects.idno"><div class='unit trimText'><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
<?php
					if(in_array(strToLower($t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => "true"))), array("photograph", "photographs"))){
						print "<div class='unit trimText'><label>Rights Statement</label>";
						if($vs_rights = $this->getVar("detail_rights_statement")){
							print $vs_rights;
						}
						if($vs_tmp = $t_object->get("ca_objects.rightsStatement.rightsStatement_text")){
							print " ".$vs_tmp;
						}
						print "</div>";
					}
					if(in_array(strToLower($t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => "true"))), array("videos"))){
						if($vs_rights = $this->getVar("detail_rights_statement_videos")){
							print "<div class='unit trimText'><label>Rights Statement</label>";
							print $vs_rights;
							print "</div>";
						}
					}
					
?>
				</div>
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php					
					if ($va_works = $t_object->get('ca_occurrences', array('sort' => 'ca_occurrences.premiereDate', 'restrictToTypes' => array('work'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$vb_show_view_all = false;
						print "<div class='unit'><H3>Related Works</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
						if(sizeof($va_works) > 18){
							$vb_show_view_all = true;
						}
						foreach ($va_works as $va_work) {
							if($i == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".caDetailLink($this->request, $va_work['name'], '', 'ca_occurrences', $va_work['occurrence_id'])."</div></div>";
							$i++;
							$c++;
							if($i == 3){
								print "</div><!-- end row -->";
								$i = 0;
							}
							if($c == 18){
								break;
							}
						}
						if($i > 0){
							print "</div>";
						}
						print "</div></div><!-- end unit -->";
						if($vb_show_view_all){
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Works", "btn btn-default", "", "Browse", "works", array("facet" => "object_general_facet", "id" => $t_object->get("ca_objects.object_id")))."</div>";
						}
					}
					
					if ($va_events = $t_object->get('ca_occurrences', array('sort' => 'ca_occurrences.eventDate', 'restrictToTypes' => array('event'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$vb_show_view_all = false;
						print "<div class='unit'><H3>Related Performances & Events</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
						if(sizeof($va_events) > 18){
							$vb_show_view_all = true;
						}
						foreach ($va_events as $va_event) {
							if($i == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".caDetailLink($this->request, $va_event['name'], '', 'ca_occurrences', $va_event['occurrence_id'])."</div></div>";
							$i++;
							$c++;
							if($i == 3){
								print "</div><!-- end row -->";
								$i = 0;
							}
							if($c == 18){
								break;
							}
						}
						if($i > 0){
							print "</div>";
						}
						print "</div></div><!-- end unit -->";
						if($vb_show_view_all){
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Performances & Events", "btn btn-default", "", "Browse", "events", array("facet" => "object_general_facet", "id" => $t_object->get("ca_objects.object_id")))."</div>";
						}
					}
					
					if ($va_venues = $t_object->get('ca_occurrences', array('sort' => 'ca_occurrences.preferred_labels', 'restrictToTypes' => array('venue'), 'returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
						$vb_show_view_all = false;
						print "<div class='unit'><H3>Venues</H3><div class='unit detailLinksGrid'>";
						$i = 0;
						$c = 0;
						if(sizeof($va_venues) > 18){
							$vb_show_view_all = true;
						}
						foreach ($va_venues as $va_venue) {
							if($i == 0){
								print "<div class='row'>";
							}
							print "<div class='col-sm-12 col-md-4'><div class='detailLinksGridItem'>".caDetailLink($this->request, $va_venue['name'], '', 'ca_occurrences', $va_venue['occurrence_id'])."</div></div>";
							$i++;
							$c++;
							if($i == 3){
								print "</div><!-- end row -->";
								$i = 0;
							}
							if($c == 18){
								break;
							}
						}
						if($i > 0){
							print "</div>";
						}
						print "</div></div><!-- end unit -->";
						if($vb_show_view_all){
							print "<div class='unit text-center'>".caNavLink($this->request, "View All Performances & Events", "btn btn-default", "", "Browse", "events", array("facet" => "object_general_facet", "id" => $t_object->get("ca_objects.object_id")))."</div>";
						}
					}
?>					
					
					
				</div><!-- end col -->
			</div><!-- end row -->
			
{{{<ifcount code="ca_objects.related" min="1">
			<div class="unit"><H3>Related Media</H3>
				<div id="browseResultsContainer">
					<unit relativeTo="ca_objects.related" length="21" delimiter=" " aggregateUnique="1">
						<div class="bResultItemCol col-xs-12 col-sm-4">
							<div class="bResultItem" id="row^ca_objects.object_id">
								<div class="bResultItemContent"><div class="text-center bResultItemImg"><case><ifcount code="ca_object_representations.media.medium" min="1"><l>^ca_object_representations.media.medium</l></ifcount><ifcount code="ca_object_representations" min="0" max="0"><l><?php print "<div class='bResultItemImgPlaceholderLogo'>".caGetThemeGraphic($this->request, 'mmdg_lines.png', array("alt" => "media not available for this item"))."</div>"; ?></l></ifcount></case></div>
									<div class="bResultItemText">
										<small>^ca_objects.type_id</small><br/>
										<l>^ca_objects.preferred_labels.name</l>
									</div><!-- end bResultItemText -->
								</div><!-- end bResultItemContent -->
							</div><!-- end bResultItem -->
						</div><!-- end col -->
					</unit>
				</div><!-- end browseResultsContainer -->
			</div><!-- end unit -->
			<ifcount code="ca_objects" min="21">
				<div class="unit text-center">
					<?php print caNavLink($this->request, "View All Media", "btn btn-default", "", "Browse", "objects", array("facet" => "related_object_facet", "id" => $t_object->get("ca_objects.object_id"))); ?>
				</div>
			</ifcount>
</ifcount>}}}
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
		  maxHeight: 400
		});
	});
</script>