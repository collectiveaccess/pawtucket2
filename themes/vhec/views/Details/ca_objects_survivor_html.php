<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = $this->getVar('access_values');
	
	$vs_home = caNavLink($this->request, "Home", '', '', '', '');
	$vs_type = $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));

	if ($vs_type == "Survivor Testimony") {
		$vs_type_link = caNavLink($this->request, 'Testimony', '', '', 'Testimony', 'Index');
	}			
	$vs_title 	= caTruncateStringWithEllipsis($t_object->get('ca_objects.preferred_labels.name'), 60);	
	
	$breadcrumb_link = $vs_home." > ".$vs_type_link." > ".$vs_title;

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
		<div class="breadcrumb"><?php print $breadcrumb_link; ?></div>

		<div class="container">
			<div class="row">
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{representationViewer}}}
				
				
					<div id="detailAnnotations"></div>
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
	<?php
					# Comment and Share Tools
					if ($vn_comments_enabled | $vn_share_enabled) {
						
						print '<div id="detailTools">';
						if ($vn_comments_enabled) {
	?>				
							<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
							<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
	<?php				
						}
	?>					
						<div class="detailTool"><a href="#" onclick='$("#shareWidgetsContainer").toggle(300);return false;'><span class="glyphicon glyphicon-share-alt"></span> Share</a></div><!-- end detailTool -->
	<?php					
						print '</div><!-- end detailTools -->';
					}				
	?>	
				<div id="shareWidgetsContainer" style='display:none;'>
					<div class="addthis_toolbox addthis_default_style" >
						<a class="addthis_button_pinterest_pinit"></a>
						<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
						<a class="addthis_button_tweet"></a>
						<a class="addthis_counter addthis_pill_style"></a>
					</div>
					<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-50278eb55c33574f"></script>
				</div>	
<?php
				if ($va_local_subjects = $t_object->get('ca_objects.local_subject', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
					$vn_subject = 1;
					print "<div class='subjectBlock'>";
					print "<h8 style='margin-bottom:10px;'>Access Points</h8>";
					foreach ($va_local_subjects as $va_key => $va_local_subject) {
						if ($vn_subject > 3) {
							$vs_subject_style = "class='subjectHidden'";
						}
						print "<div {$vs_subject_style}>".caNavLink($this->request, $va_local_subject, '', '', 'Search', 'objects', array('search' => "'".$va_local_subject."'"))."</div>";
						if (($vn_subject == 3) && (sizeof($va_local_subjects) > 3)) {
							print "<a class='seeMore' href='#' onclick='$(\".seeMore\").hide();$(\".subjectHidden\").slideDown(300);return false;'>more...</a>";
						}
						$vn_subject++;
					}
					print "</div>";
				}
				$vs_rights = false;
				$vs_rights_text = "";
				if ($vs_conditions_use = $t_object->get('ca_objects.RAD_useRepro')) {
					$vs_rights = true;
					$vs_rights_text.= "<h8>Conditions on Use</h8>";
					$vs_rights_text.= "<div>".$vs_conditions_use."</div>";
				}
				if ($vs_conditions_access = $t_object->get('ca_objects.govAccess')) {
					$vs_rights = true;
					$vs_rights_text.= "<h8>Conditions on Access</h8>";
					$vs_rights_text.= "<div>".$vs_conditions_access."</div>";
				}
				if ($vs_licensing = $t_object->get('ca_objects.licensing')) {
					$vs_rights = true;
					$vs_rights_text.= "<h8>Licensing</h8>";
					$vs_rights_text.= "<div>".$vs_licensing."</div>";
				}
				if ($vs_rights_statement = $t_object->get('ca_objects.dc_rights')) {
					$vs_rights = true;
					$vs_rights_text.= "<h8>Rights Holder</h8>";
					$vs_rights_text.= "<div>".$vs_rights_statement."</div>";
				}
				if ($vs_rights_reproduction = $t_object->get('ca_objects.RAD_useRepro')) {
					$vs_rights = true;
					$vs_rights_text.= "<h8>Terms governing reproduction</h8>";
					$vs_rights_text.= "<div>".$vs_rights_reproduction."</div>";
				}				
				if ($vs_rights == true) {
					print "<div class='rightsBlock'>";
					print "<h8 style='margin-bottom:10px;'><a href='#' onclick='$(\"#rightsText\").toggle(300);return false;'>Rights <i class='fa fa-chevron-down'></i></a></h8>";
					print "<div style='display:none;' id='rightsText'>".$vs_rights_text."</div>";
					print "</div>";
				}												
?>					
				</div><!-- end col -->
			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					<H4>{{{ca_objects.preferred_labels.name}}}</H4>
					<H5>{{{<unit>^ca_objects.type_id</unit>}}}</H5>
					<HR>
	<?php
	
						if ($va_resource_type_testimony = $t_object->get('ca_objects.resourceType', array('convertCodesToDisplayText' => true))) {
							print "<div class='unit'><h8>Resource Type</h8>".$va_resource_type_testimony."</div>";
						}
						if ($va_genre_testimony = $t_object->get('ca_objects.genre', array('convertCodesToDisplayText' => true))) {
							print "<div class='unit'><h8>Genre</h8>".$va_genre_testimony."</div>";
						}
						if ($va_alt_id = $t_object->get('ca_objects.alt_id')) {
							print "<div class='unit'><h8>Object ID</h8>".$va_alt_id."</div>";
						}
						if ($va_interview_date = $t_object->get('ca_objects.interview_dates', array('delimiter', ', '))) {
							print "<div class='unit'><h8>Date of Recording</h8>".$va_interview_date."</div>";
						}
						if ($va_creator_testimony = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('creator'), 'delimiter' => ', ', 'returnAsLink' => true))) {
							print "<div class='unit'><h8>Creator</h8>".$va_creator_testimony."</div>";
						}
						print "<hr>";	
						if ($va_interviewer_testimony = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('interviewer'), 'delimiter' => ', ', 'returnAsLink' => true))) {
							print "<div class='unit'><h8>Interviewer</h8>".$va_interviewer_testimony."</div>";
						}
						if ($va_interviewee_testimony = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('interviewee'), 'delimiter' => ', ', 'returnAsLink' => true))) {
							print "<div class='unit'><h8>Interviewee</h8>".$va_interviewee_testimony."</div>";
						}
						if ($va_contributor_testimony = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('contributor'), 'delimiter' => ', ', 'returnAsLink' => true))) {
							print "<div class='unit'><h8>Contributor</h8>".$va_contributor_testimony."</div>";
						}
						if ($va_speaker_testimony = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('speaker'), 'delimiter' => ', ', 'returnAsLink' => true))) {
							print "<div class='unit'><h8>Speaker</h8>".$va_speaker_testimony."</div>";
						}
						if ($va_duration = $t_object->get('ca_objects.duration', array('delimiter', ', '))) {
							print "<div class='unit'><h8>Duration</h8>".$va_duration."</div>";
						}
						if ($va_language = $t_object->get('ca_objects.language', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
							print "<div class='unit'><h8>Language</h8>".$va_language."</div>";
						}
						if ($va_language_note = $t_object->get('ca_objects.language_note')) {
							print "<div class='unit'><h8>Language Note</h8>".$va_language_note."</div>";
						}
						print "<hr>";
						if ($va_summary = $t_object->get('ca_objects.MARC_summary')) {
							print "<div class='unit trimText'><h8>Synopsis</h8>".$va_summary."</div>";
						}
						if ($va_general_note = $t_object->get('ca_objects.MARC_generalNote')) {
							print "<div class='unit trimText'><h8>Note</h8>".$va_general_note."</div>";
						}
						if ($va_related_entities = $t_object->getWithTemplate('<unit delimiter=", " relativeTo="ca_entities" excludeRelationshipTypes="interviewer, interviewee, creator"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
							print "<div class='unit trimText'><h8>Related Entities</h8>".$va_related_entities."</div>";
						}	
						print "<hr>";
						if ($va_test_project = $t_object->get('ca_objects.testimony_project_notes')) {
							print "<div class='unit trimText'><h8>Testimony Project</h8>".$va_test_project."</div>";
						}
						if ($va_funding_note = $t_object->get('ca_objects.funding_note')) {
							print "<div class='unit'><h8>Funding Note</h8>".$va_funding_note."</div>";
						}																																																																																																																																																																						
	?>				
					</div><!-- end col -->
								

			
			</div><!-- end row -->
<?php
			#Testimony
			$vs_related_testimony = "";
			if ($va_related_testimony_objects = $t_object->get('ca_objects.related.object_id', array('returnWithStructure' => true, 'restrictToTypes' => array('survivor'), 'checkAccess' => $va_access_values))) {
				foreach ($va_related_testimony_objects as $va_key => $va_related_testimony_object_id) {				
					$t_testimony = new ca_objects($va_related_testimony_object_id);
					$vs_related_testimony.= "<div class='col-sm-4'>";
					$vs_related_testimony.= "<div class='relatedThumb'>".caNavLink($this->request, $t_testimony->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_related_testimony_object_id);
					$vs_related_testimony.= "<div>".caNavLink($this->request, $t_testimony->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_related_testimony_object_id)."</div>";
					$vs_related_testimony.= "</div></div>";					
				}
			}
			#Museum Objects
			$vs_related_museum = "";
			if ($va_related_museum_objects = $t_object->get('ca_objects.related.object_id', array('returnWithStructure' => true, 'restrictToTypes' => array('work', 'archival', 'library'), 'checkAccess' => $va_access_values))) {
				foreach ($va_related_museum_objects as $va_key => $va_related_museum_object_id) {				
					$t_museum = new ca_objects($va_related_museum_object_id);
					$vs_related_museum.= "<div class='col-sm-4'>";
					$vs_related_museum.= "<div class='relatedThumb'>".caNavLink($this->request, $t_museum->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_related_museum_object_id);
					$vs_related_museum.= "<div>".caNavLink($this->request, $t_museum->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_related_museum_object_id)."</div>";
					$vs_related_museum.= "</div></div>";					
				}
			}
			#Places
			$vs_related_places = "";
			if ($va_related_places = $t_object->get('ca_places.place_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
				foreach ($va_related_places as $va_key => $va_related_place_id) {				
					$t_place = new ca_places($va_related_place_id);
					$vs_related_places.= "<div class='col-sm-4'>";
					$vs_related_places.= "<div class='entityThumb'>";
					$vs_related_places.= "<p>".$t_place->get('ca_places.preferred_labels')."</p></div>";
					$vs_related_places.= "</div>";					
				}
			}
			#Fonds
			$vs_related_fonds = "";
			if ($va_related_fonds = $t_object->get('ca_collections.collection_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('fonds', 'series', 'sub_series', 'file')))) {
				foreach ($va_related_fonds as $va_key => $va_related_fonds_id) {				
					$t_fond = new ca_collections($va_related_fonds_id);
					$vs_related_fonds.= "<div class='col-sm-4'>";
					$vs_related_fonds.= "<div class='entityThumb'>";
					$vs_related_fonds.= "<p>".$t_fond->get('ca_collections.preferred_labels')."</p></div>";
					$vs_related_fonds.= "</div>";					
				}
			}			
			#Collections
			$vs_related_collections = "";
			if ($va_related_collections = $t_object->get('ca_collections.collection_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('collection')))) {
				foreach ($va_related_collections as $va_key => $va_related_collection_id) {				
					$t_collection = new ca_collections($va_related_collection_id);
					$vs_related_collections.= "<div class='col-sm-4'>";
					$vs_related_collections.= "<div class='entityThumb'>";
					$vs_related_collections.= "<p>".$t_collection->get('ca_collections.preferred_labels')."</p></div>";
					$vs_related_collections.= "</div>";					
				}
			}
			#Events
			$vs_related_events = "";
			if ($va_related_events = $t_object->get('ca_occurrences.occurrence_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
				foreach ($va_related_events as $va_key => $va_related_event_id) {				
					$t_occurrence = new ca_occurrences($va_related_event_id);
					$va_related_events.= "<div class='col-sm-4'>";
					$va_related_events.= "<div class='entityThumb'>";
					$va_related_events.= "<p>".$t_occurrence->get('ca_occurrences.preferred_labels')."</p></div>";
					$va_related_events.= "</div>";					
				}
			}
			if ($vs_related_testimony | $vs_related_places | $vs_related_collections | $vs_related_events) {															
?>		
			<hr>	
			<div class='row'>
				<div class='col-sm-12'>
					<h4 style='font-size:16px;'>Relationships</h4>
					<div class='container' id='relationshipTable'>
						<ul class='row'>
<?php	
							if ($vs_related_testimony) { print '<li><a href="#testimonyTab">Testimonies</a></li>'; }					
							if ($vs_related_museum) { print '<li><a href="#museumTab">Objects</a></li>'; }
							if ($vs_related_places) { print '<li><a href="#placeTab">Places</a></li>'; }
							if ($vs_related_fonds) { print '<li><a href="#fondsTab">Archival Collections</a></li>'; }
							if ($vs_related_collections) { print '<li><a href="#collectionTab">Collections</a></li>'; }
							if ($vs_related_events) { print '<li><a href="#eventTab">Events</a></li>'; }																																			
?>																					
						</ul>
						<div id='testimonyTab' class='row'>									
							<?php print $vs_related_testimony; ?>	 												
						</div>						
						<div id='museumTab' class='row'>									
							<?php print $vs_related_museum; ?>	 												
						</div>						
						<div id='placeTab' class='row'>
							<?php print $vs_related_places; ?>
						</div>	
						<div id='fondsTab' class='row'>
							<?php print $vs_related_fonds; ?>
						</div>																			
						<div id='collectionTab' class='row'>
							<?php print $vs_related_collections; ?>
						</div>
						<div id='eventTab' >
							<?php print $vs_related_events; ?>
						</div>						
					</div>	

			
				</div><!-- end col -->
			</div><!-- end row -->
<?php
			}
?>			
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
		  maxHeight: 97
		});
		$('#relationshipTable').tabs();
	});
</script>
