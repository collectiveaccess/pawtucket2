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
	$vn_object_id = 		$t_object->get('ca_objects.object_id');
	$va_access_values = 	$this->getVar('access_values');
	
	$vs_home = caNavLink($this->request, "Home", '', '', '', '');
	$vs_type = $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));

	if ($vs_type == "Survivor Testimony") {
		$vs_type_link = caNavLink($this->request, 'Holocaust Testimony', '', '', 'Testimony', 'Index');
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
<?php
		if ($va_image_thumbnails = caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "list", "linkTo" => "carousel"))) {				
			print '<div class="jcarousel-wrapper-thumb">
                <div class="jcarousel-thumb" data-jcarousel="true">';
            print $va_image_thumbnails;     
			print '</div>

                <a href="#" class="jcarousel-control-prev-thumb thumbControl" data-jcarouselcontrol="true">‹</a>
                <a href="#" class="jcarousel-control-next-thumb thumbControl" data-jcarouselcontrol="true">›</a>

            </div>';
         }   
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
					<script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js"></script>
				</div>
<?php
				if ($va_local_subjects = $t_object->get('ca_objects.local_subject', array('returnAsArray' => true, 'convertCodesToDisplayText' => false))) {
					$va_subjects_display = array();
					foreach($va_local_subjects as $vn_subject_id){
						$va_subjects_display[$vn_subject_id] = caGetListItemByIDForDisplay($vn_subject_id, false);
					}
					asort($va_subjects_display);
					$vn_subject = 1;
					print "<div class='subjectBlock'>";
					print "<h8 style='margin-bottom:10px;'>Access Points</h8>";
					foreach ($va_subjects_display as $vn_subject_id => $vs_local_subject) {
						if ($vn_subject > 3) {
							$vs_subject_style = "class='subjectHidden'";
						}
						print "<div {$vs_subject_style}>".caNavLink($this->request, $vs_local_subject, '', '', 'Browse', 'objects', array('facet' => "subject_facet", "id" => $vn_subject_id))."</div>";
						if (($vn_subject == 3) && (sizeof($va_local_subjects) > 3)) {
							print "<a class='seeMore' href='#' onclick='$(\".seeMore\").hide();$(\".subjectHidden\").slideDown(300);return false;'>more...</a>";
						}
						$vn_subject++;
					}
					print "</div>";
				}
				$vs_rights = false;
				$vs_rights_text = "";
				if ($vs_conditions_access = $t_object->get('ca_objects.govAccess')) {
					$vs_rights = true;
					$vs_rights_text.= "<h8>Conditions on Access</h8>";
					$vs_rights_text.= "<div>".$vs_conditions_access."</div>";
				}		
				if ($vs_conditions_use = $t_object->get('ca_objects.RAD_useRepro')) {
					$vs_rights = true;
					$vs_rights_text.= "<h8>Conditions on Use</h8>";
					$vs_rights_text.= "<div>".$vs_conditions_use."</div>";
				}
				if ($vs_rights_reproduction = $t_object->get('ca_objects.RAD_usePub')) {
					$vs_rights = true;
					$vs_rights_text.= "<h8>Conditions on Reproduction and Publications </h8>";
					$vs_rights_text.= "<div>".$vs_rights_reproduction."</div>";
				}
				if ($vs_rights_statement = $t_object->get('ca_objects.rights_holder')) {
					$vs_rights = true;
					$vs_rights_text.= "<h8>Rights Holder</h8>";
					$vs_rights_text.= "<div>".$vs_rights_statement."</div>";
				}	
				if ($vs_licensing = caNavLink($this->request, 'Licensing', '', '', 'About', 'use')) {
					$vs_rights = true;
					$vs_rights_text.= "<div class='unit'><h8>".$vs_licensing."</h8></div>";
				}
							
				if ($vs_rights == true) {
					print "<div class='rightsBlock'>";
					print "<h8 style='margin-bottom:10px;'><a href='#' onclick='$(\"#rightsText\").toggle(300);return false;'>Rights <i class='fa fa-chevron-down'></i></a></h8>";
					print "<div style='display:none;' id='rightsText'>".$vs_rights_text."</div>";
					print "</div>";
				}												
?>	
					<div class='map'>{{{map}}}</div>				
				</div><!-- end col -->
			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					<H4>{{{ca_objects.preferred_labels.name}}}</H4>
					<H5>Holocaust Testimony</H5>
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
						if ($va_summary = $t_object->get('ca_objects.MARC_summary')) {
							print "<div class='unit trimText'><h8>Synopsis</h8>".$va_summary."</div>";
						}
						if ($va_general_note = $t_object->get('ca_objects.MARC_generalNote')) {
							print "<div class='unit trimText'><h8>Note</h8>".$va_general_note."</div>";
						}	
						if ($va_test_project = $t_object->get('ca_objects.testimony_project_notes')) {
							print "<div class='unit trimText'><h8>Testimony Project</h8>".$va_test_project."</div>";
						}
						if ($va_other_holding = $t_object->getWithTemplate('<unit delimiter=", " relativeTo="ca_entities" restrictToRelationshipTypes="repository"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
							print "<div class='unit'><h8>Other Holding Institutions</h8>".$va_other_holding."</div>";
						}
						if ($t_object->get('ca_objects.transcript.transcript_media')){
							$va_assoc_materials_pdf = $t_object->get('ca_objects.transcript', array('returnWithStructure' => true, 'ignoreLocale' => true, 'version' => 'preview', 'convertCodesToDisplayText' => true)); 							
							$o_db = new Db();
							$t_element = ca_attributes::getElementInstance('transcript_media');
							$vn_media_element_id = $t_element->getElementID('transcript_media'); 
							foreach ($va_assoc_materials_pdf as $vn_assoc_materials_obj_id => $vn_assoc_materials_pdf_image_array) {
								foreach ($vn_assoc_materials_pdf_image_array as $vn_assoc_materials_pdf_id => $vn_assoc_materials_pdf_image) {
									if ($vn_assoc_materials_pdf_image['transcript_supress'] == "No") {
										print "<div class='unit document'><h8>Time-Coded narrative </h8>";
										$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_assoc_materials_pdf_id, $vn_media_element_id)) ;
										if ($qr_res->nextRow()) {
											print "<p><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $vn_object_id, 'identifier' => 'attribute:'.$qr_res->get('value_id'), 'overlay' => 1))."\"); return false;'><i class='fa fa-file'></i> ".ucfirst($vn_assoc_materials_pdf_image['upload_type'])."</a></p>";
										}
										print "</div>";
									}
								}
							}
						}												
						if ($va_funding_note = $t_object->get('ca_objects.funding_note')) {
							print "<div class='unit'><h8>Funding Note</h8>".$va_funding_note."</div>";
						}
						$vs_permalink = caNavUrl($this->request, 'Detail', 'objects', $vn_object_id, array(), array('absolute' => 1));
						print "<div class='unit'><h8>Permalink</h8><a href='".$vs_permalink."'>".$vs_permalink."</a></div>";																																																																																																																																																																						
	?>				
					</div><!-- end col -->
								

			
			</div><!-- end row -->
<?php

			#Archives Objects etc
			$vs_related_holdings = "";			
			if ($va_related_holdings_objects = $t_object->get('ca_objects.related.object_id', array('returnWithStructure' => true, 'restrictToTypes' => array('archival', 'library', 'survivor', 'work'), 'checkAccess' => $va_access_values, 'sort' => 'ca_objects.type_id'))) {
				$va_my_type = array();
				$va_other_type = array();
				foreach ($va_related_holdings_objects as $va_key => $va_related_holdings_object_id) {				
					$t_holding = new ca_objects($va_related_holdings_object_id);
					if ($t_holding->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))) {
						$va_my_type[] = "<div class='col-sm-3'><div class='relatedThumb'>".caNavLink($this->request, $t_holding->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."<div>".caNavLink($this->request, $t_holding->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."</div></div></div>";	
					} else {
						$va_other_type[] = "<div class='col-sm-3'><div class='relatedThumb'>".caNavLink($this->request, $t_holding->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."<div>".caNavLink($this->request, $t_holding->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."</div></div></div>";	
					}
				}
				foreach ($va_my_type as $va_key => $va_my_type_object_link) {
					$vs_related_holdings.= $va_my_type_object_link;
				}
				foreach ($va_other_type as $va_key => $va_other_type_object_link) {
					$vs_related_holdings.= $va_other_type_object_link;
				}				
				
			}
			if ($va_related_collections = $t_object->get('ca_collections.collection_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('fonds', 'series', 'sub_series', 'file')))) {
				foreach ($va_related_collections as $va_key => $va_related_collection_id) {				
					$t_collection = new ca_collections($va_related_collection_id);
					$vs_related_holdings.= "<div class='col-sm-3'>";
					$vs_related_holdings.= "<div class='relatedThumb'>";
					$vs_related_holdings.= "<p>".caNavLink($this->request, $t_collection->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_related_collection_id)."</p></div>";
					$vs_related_holdings.= "</div>";					
				}
			}					
			#Entities
			$vs_related_entities = "";
			$va_ents_by_type = array();
			if ($va_related_entities = $t_object->get('ca_entities', array('checkAccess' => $va_access_values, 'returnWithStructure' => true, 'excludeRelationshipTypes' => array('donor')))) {
				foreach ($va_related_entities as $va_key => $va_related_entity) {
					$va_ents_by_type[$va_related_entity['item_type_id']][$va_related_entity['entity_id']] = "<div class='col-sm-4'><div class='entityThumb'><p>".caNavLink($this->request, $va_related_entity['label'], '', '', 'Detail', 'entities/'.$va_related_entity['entity_id'])." (".$va_related_entity['relationship_typename'].")</p></div></div>";
				}
				foreach ($va_ents_by_type as $vs_entity_type => $va_entity) {
					if (($va_type_name = caGetListItemByIDForDisplay($vs_entity_type, true)) == "Individuals" ) {
						$vs_related_entities.= "<h8>People</h8>";
					} else {
						$vs_related_entities.= "<h8>".$va_type_name."</h8>";
					}
					$vs_related_entities.= "<div class='row'>";
					foreach ($va_entity as $va_key => $va_entity_name) {
						$vs_related_entities.= $va_entity_name;
					}
					$vs_related_entities.= "</div>";
				}
				#$vs_related_entities.= $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter=" "><div class="col-sm-3"><div class="entityThumb"><p><l>^ca_entities.preferred_labels</l> (^relationship_typename)</p></div></div></unit>');					
			}
			#Places
			$vs_related_places = "";
			if ($va_related_places = $t_object->get('ca_places.place_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
				foreach ($va_related_places as $va_key => $va_related_place_id) {				
					$t_place = new ca_places($va_related_place_id);
					$vs_place_name = $t_place->get('ca_places.preferred_labels');
					$vs_related_places.= "<div class='col-sm-3'>";
					$vs_related_places.= "<div class='entityThumb'>";
					$vs_related_places.= "<p>".caNavLink($this->request, $vs_place_name, '', '', 'Detail', 'places/'.$va_related_place_id)."</p></div>";
					$vs_related_places.= "</div>";					
				}
			}
			#Collections
			$vs_related_collections = "";
			if ($va_related_collections = $t_object->get('ca_collections.collection_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('collection')))) {
				foreach ($va_related_collections as $va_key => $va_related_collection_id) {				
					$t_collection = new ca_collections($va_related_collection_id);
					$vs_related_collections.= "<div class='col-sm-3'>";
					$vs_related_collections.= "<div class='entityThumb'>";
					$vs_related_collections.= "<p>".$t_collection->get('ca_collections.preferred_labels', array('returnAsLink' => true))."</p></div>";
					$vs_related_collections.= "</div>";					
				}
			}
			#Events
			$vs_related_events = "";
			if ($va_related_events = $t_object->get('ca_occurrences', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
				foreach ($va_related_events as $va_key => $va_related_event) {
					$va_events_by_type[$va_related_event['item_type_id']][$va_related_event['occurrence_id']] = "<div class='col-sm-4'><div class='entityThumb'><p>".caNavLink($this->request, $va_related_event['label'], '', '', 'Detail', 'occurrences/'.$va_related_event['occurrence_id'])." (".$va_related_event['relationship_typename'].")</p></div></div>";
				}
				foreach ($va_events_by_type as $vs_event_type => $va_event) {
					$vs_related_events.= "<h8>".caGetListItemByIDForDisplay($vs_event_type)."</h8>";
					$vs_related_events.= "<div class='row'>";
					foreach ($va_event as $va_key => $va_event_name) {
						$vs_related_events.= $va_event_name;
					}
					$vs_related_events.= "</div>";
				}
			}
			if ($vs_related_holdings | $vs_related_entities | $vs_related_places | $vs_related_collections | $vs_related_events) {															
?>		
			<hr>	
			<div class='row'>
				<div class='col-sm-12'>
					<h4 style='font-size:16px;'>Related</h4>
					<div class='container' id='relationshipTable'>
						<ul class='row'>
<?php						
							if ($vs_related_holdings) { print '<li><a href="#objectsTab">Holdings</a></li>'; }
							if ($vs_related_entities) { print '<li><a href="#entityTab">People & Organizations</a></li>'; }
							if ($vs_related_places) { print '<li><a href="#placeTab">Places</a></li>'; }
							if ($vs_related_events) { print '<li><a href="#eventTab">Events & Exhibitions</a></li>'; }
							if ($vs_related_collections) { print '<li><a href="#collectionTab">Collections</a></li>'; }																																			
?>																					
						</ul>						
						<div id='objectsTab' class='row' >
							<?php print $vs_related_holdings; ?>
						</div>
						<div id='entityTab' class='row'>
							<?php print $vs_related_entities; ?>
						</div>
						<div id='placeTab' class='row'>
							<?php print $vs_related_places; ?>
						</div>
						<div id='eventTab' class='row'>
							<?php print $vs_related_events; ?>
						</div>																					
						<div id='collectionTab' class='row'>
							<?php print $vs_related_collections; ?>
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
	
	(function($) {
		$(function() {
			$('.jcarousel-thumb').jcarousel();

			$('.jcarousel-control-prev-thumb')
				.on('jcarouselcontrol:active', function() {
					$(this).removeClass('inactive');
				})
				.on('jcarouselcontrol:inactive', function() {
					$(this).addClass('inactive');
				})
				.jcarouselControl({
					target: '-=1'
				});

			$('.jcarousel-control-next-thumb')
				.on('jcarouselcontrol:active', function() {
					$(this).removeClass('inactive');
				})
				.on('jcarouselcontrol:inactive', function() {
					$(this).addClass('inactive');
				})
				.jcarouselControl({
					target: '+=1'
				});

		});
	})(jQuery);	
</script>
