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
 	require_once(__CA_MODELS_DIR__.'/ca_object_checkouts.php');
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = 	$this->getVar('access_values');
	$vn_object_id = 		$t_object->get('ca_objects.object_id');
	
	$vs_home = caNavLink($this->request, "Home", '', '', '', '');
	$vs_type = $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));
	if ($vs_type == "Museum Work") {
		$vs_type_link = caNavLink($this->request, 'Museum', '', '', 'Museum', 'Index');
	}
	if ($vs_type == "Archival Item") {
		$vs_type_link = caNavLink($this->request, 'Archives', '', '', 'Archives', 'Index');
	}
	if (($vs_type == "Library Item") | ($vs_type == "Library Component")) {
		$vs_type_link = caNavLink($this->request, 'Library', '', '', 'Library', 'Index');
		if ($vs_parent = $t_object->get('ca_objects.parent.preferred_labels', array('returnAsLink' => true))) {
			$vs_parent_link = " > ".$vs_parent;
		}
	}			
	$vs_title 	= caTruncateStringWithEllipsis($t_object->get('ca_objects.preferred_labels.name'), 60);	
	
	$breadcrumb_link = $vs_home." > ".$vs_type_link.$vs_parent_link." > ".$vs_title;

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
				
				
					<!-- <div id="detailAnnotations"></div>-->
				
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
				$vs_access_point_local = "";
				$no_subjects = 0;
				#LCSH
				if ($va_local_lcsh_subjects = $t_object->get('ca_objects.LOC_text', array('returnAsArray' => true, 'convertCodesToDisplayText' => true, 'delimiter' => '<br/>'))) {
					foreach ($va_local_lcsh_subjects as $va_key => $va_local_lcsh_subject) {
						if ($va_local_lcsh_subject) {
							$vs_access_point_local.= "<div >".caNavLink($this->request, $va_local_lcsh_subject, '', '', 'Search', 'objects', array('search' => "'".$va_local_lcsh_subject."'"))."</div>";
						}
					}
					$no_subjects++;
				}
				#Entities
				$vs_access_point_entity = "";
				$va_entity_subjects = $t_object->get('ca_entities.preferred_labels', array('returnAsArray' => true, 'returnAsLink' => true, 'convertCodesToDisplayText' => true, 'restrictToRelationshipTypes' => array('subject')));
				if (sizeof($va_entity_subjects) >= 1) {
					$vn_subject = 1;
					foreach ($va_entity_subjects as $va_key => $va_entity_subject) {
						if ($vn_entity > 3) {
							$vs_subject_style = "class='subjectHidden'";
						}
						$vs_access_point_entity.= "<div {$vs_subject_style}>".$va_entity_subject."</div>";
						
						if (($vn_subject == 3) && (sizeof($va_local_subjects) > 3)) {
							$vs_access_point_entity.= "<a class='seeMore' href='#' onclick='$(\".seeMore\").hide();$(\".subjectHidden\").slideDown(300);return false;'>more...</a>";
						}
						$vn_subject++;
					}
					$no_subjects++;
				}				
				#Local Subject
				$vs_access_point_subject = "";
				$va_local_subjects = $t_object->get('ca_objects.local_subject', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
				if (sizeof($va_local_subjects) >= 1) {
					asort($va_local_subjects);
					$vn_subject = 1;
					foreach ($va_local_subjects as $va_key => $va_local_subject) {
						if ($va_local_subject == '-') { continue; }
						if ($vn_subject > 3) {
							$vs_subject_style = "class='subjectHidden'";
						}
						$vs_access_point_subject.= "<div {$vs_subject_style}>".caNavLink($this->request, $va_local_subject, '', '', 'Search', 'objects', array('search' => "'".$va_local_subject."'"))."</div>";
						
						if (($vn_subject == 3) && (sizeof($va_local_subjects) > 3)) {
							$vs_access_point_subject.= "<a class='seeMore' href='#' onclick='$(\".seeMore\").hide();$(\".subjectHidden\").slideDown(300);return false;'>more...</a>";
						}
						$vn_subject++;
					}
					$no_subjects++;
				}
				if (($vs_access_point_local != "") | ($vs_access_point_entity != "") | ($vs_access_point_subject != "")) {
					print "<div class='subjectBlock'>";
					print "<h8 style='margin-bottom:10px;'>Access Points</h8>";
					if (sizeof($no_subjects) > 1) {
						print "<h9>Library of Congress Subject Heading(s)</h9>";
						print $vs_access_point_local;
						print "<h9>Subject(s) - People and Organizations</h9>";
						print $vs_access_point_entity;
						print "<h9>Local Access Points </h9>";
						print $vs_access_point_subject;
					} else {
						print $vs_access_point_local;
						print $vs_access_point_entity;
						print $vs_access_point_subject;
					}
					print "</div>";
				}
				
				$vs_rights = false;
				$vs_rights_text = "";
				if ($vs_conditions_use = $t_object->get('ca_objects.RAD_useRepro')) {
					$vs_rights = true;
					$vs_rights_text.= "<div class='unit'><h8>Conditions on Use</h8>".$vs_conditions_use."</div>";
				}
				if (($vs_conditions_access = $t_object->get('ca_objects.govAccess')) | ($vs_conditions_phys = $t_object->get('ca_objects.MARC_physical_access'))) {
					$vs_rights = true;
					if ($vs_conditions_access && $vs_conditions_phys) {$vs_space = "<br/>";}
					$vs_rights_text.= "<div class='unit'><h8>Conditions on Access</h8>".$vs_conditions_access.$vs_space.$vs_conditions_phys."</div>";
				}
				if ($vs_licensing = caNavLink($this->request, 'Licensing', '', '', 'About', 'licensing')) {
					$vs_rights = true;
					$vs_rights_text.= "<div class='unit'><h8>".$vs_licensing."</h8></div>";
				}
				if ($vs_rights_statement = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('rights_holder'), 'delimiter' => ', ', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
					$vs_rights = true;
					$vs_rights_text.= "<div class='unit'><h8>Rights Holder</h8>".$vs_rights_statement."</div>";
				}
				#if ($vs_rights_reproduction = $t_object->get('ca_objects.RAD_useRepro')) {
				#	$vs_rights = true;
				#	$vs_rights_text.= "<h8>Terms governing reproduction</h8>";
				#	$vs_rights_text.= "<div>".$vs_rights_reproduction."</div>";
				#}				
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
					<H5>{{{<unit>^ca_objects.type_id</unit>}}}</H5>
					<HR>
	<?php
					#Library assets
					if (($vs_type == "Library Item") | ($vs_type == "Library Component")) {
						if ($va_parent = $t_object->get('ca_objects.parent.preferred_labels', array('returnAsLink' => true))) {
							print "<div class='unit'><h8>Parent Record</h8>".$va_parent."</div>";
						}
						if ($va_resource_type_library = $t_object->get('ca_objects.resourceType', array('convertCodesToDisplayText' => true))) {
							print "<div class='unit'><h8>Resource Type</h8>".$va_resource_type_library."</div>";
						}
						if ($va_local_call = $t_object->get('ca_objects.MARC_localNo')) {
							print "<div class='unit'><h8>Call Number</h8>".$va_local_call."</div>";
						}					
						$va_date_line = array();
						if ($va_publication_date = $t_object->get('ca_objects.displayDate')) {
							$va_date_line[] = $va_publication_date;
						}
						if ($va_copyright_date = $t_object->get('ca_objects.MARC_copyrightDate')) {
							$va_date_line[] = $va_copyright_date;
						}
						if ($va_date_line) {
							print "<div class='unit'><h8>Dates</h8>".join('; ', $va_date_line)."</div>"; 
						}
						print $t_object->getWithTemplate('<ifcount min="1" code="ca_entities.preferred_labels" relativeTo="ca_entities" restrictToRelationshipTypes="author,creator,compiler"><div class="unit"><h8>Creator</h8><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="author,creator,compiler"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit></div></ifcount>');
						print $t_object->getWithTemplate('<ifcount min="1" code="ca_entities.preferred_labels" relativeTo="ca_entities" restrictToRelationshipTypes="contributor,editor,producer"><div class="unit"><h8>Contributor</h8><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="contributor,editor,producer"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit></div></ifcount>');

						if ($va_summary = $t_object->get('ca_objects.MARC_summary')) {
							print "<div class='unit trimText'><h8>Summary</h8>".$va_summary."</div>";
						}
						if ($va_content_note = $t_object->get('ca_objects.MARC_formattedContents')) {
							print "<div class='unit trimText'><h8>Contents</h8>".$va_content_note."</div>";
						}
						if ($va_physical_desc = $t_object->get('ca_objects.MARC_physical')) {
							print "<div class='unit'><h8>Physical Description </h8>".$va_physical_desc."</div>";
						}
						$va_carrier = array();
						if ($va_carrier_type = $t_object->get('ca_objects.carrier_type_library', array('convertCodesToDisplayText' => true))) {
							$va_carrier[] = $va_carrier_type;
						}
						if ($va_carrier_note = $t_object->get('ca_objects.carrier_type_note')) {
							$va_carrier[] = $va_carrier_note;
						}
						if ($va_carrier) {
							print "<div class='unit'><h8>Carrier Type</h8>".join(', ', $va_carrier)."</div>"; 
						}
						$va_language = array();
						if ($va_language_value = $t_object->get('ca_objects.language', array('convertCodesToDisplayText' => true))) {
							$va_language[] = $va_language_value;
						}
						if ($va_language_note = $t_object->get('ca_objects.language_note')) {
							$va_language[] = $va_language_note;
						}
						if ($va_language) {
							print "<div class='unit'><h8>Language</h8>".join(', ', $va_language)."</div>"; 
						}
						if ($va_publisher_note = $t_object->get('ca_objects.MARC_pubPlace')) {
							print "<div class='unit'><h8>Publisher</h8>".$va_publisher_note."</div>";
						}
						if ($va_distributor_note = $t_object->get('ca_objects.MARC_placeDist')) {
							print "<div class='unit'><h8>Distributor</h8>".$va_distributor_note."</div>";
						}
						if ($va_edition = $t_object->get('ca_objects.MARC_edition')) {
							print "<div class='unit'><h8>Edition</h8>".$va_edition."</div>";
						}	
						if ($va_series = $t_object->get('ca_objects.MARC_series')) {
							$va_series_and_volume = explode('; ', $va_series);
							print "<div class='unit'><h8>Edition</h8>".caNavLink($this->request, $va_series_and_volume[0], '', '', 'Search', 'library', array('search' => "'".$va_series_and_volume[0]."'"))."; ".$va_series_and_volume[1]."</div>";
						}
						if ($va_dc_note = $t_object->get('ca_objects.MARC_generalNote')) {
							print "<div class='unit trimText'><h8>Notes</h8>".$va_dc_note."</div>";
						}
						if ($va_target = $t_object->get('ca_objects.MARC_target')) {
							print "<div class='unit'><h8>Audience</h8>".$va_target."</div>";
						}
						if ($va_recognition = $t_object->get('ca_objects.MARC_sourceAcq')) {
							print "<div class='unit'><h8>Recognition</h8>".$va_recognition."</div>";
						}
						$va_elec_location = array();
						if ($va_electronic_location = $t_object->get('ca_objects.MARC_electronicLocation')) {
							$va_elec_location[] = $va_electronic_location;
						}
						if ($va_elec_location_note = $t_object->get('ca_objects.MARC_publicNote')) {
							$va_elec_location[] = $va_elec_location_note;
						}
						if ($va_elec_location) {
							print "<div class='unit'><h8>URL</h8>".join(', ', $va_elec_location)."</div>"; 
						}
						if ($va_funding_note = $t_object->get('ca_objects.funding_note')) {
							print "<div class='unit'><h8>Funding Note</h8>".$va_funding_note."</div>";
						}
						if ($va_parent_id = $t_object->get('ca_objects.parent.object_id', array('returnAsLink' => true))) {
							print "<div class='unit'>".caNavLink($this->request, '<h8>Request This Item</h8>', '', '', 'Detail', 'objects/'.$va_parent_id)."</div>";
						}	
						if ($va_components = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true))) {
							print "<div class='unit'><h8><a href='#' class='components' onclick='$(\".hiddenComponents\").toggle(300);return false;'>Find This Item <i class='fa fa-chevron-down'></i></a></h8>";
							print "<div class='hiddenComponents' style='display:none;'>";
							foreach ($va_components as $va_key => $va_component) {
								$t_child = new ca_objects($va_component);
								$t_checkout = new ca_object_checkouts();
								$va_checkout_info = $t_checkout->objectIsOut($va_component);
								print "<div class='component'>";
								print "<div>".$t_child->get('ca_objects.preferred_labels', array('returnAsLink' => true))."<br/>";
								print "<b>Call No: </b>".$t_child->get('ca_objects.MARC_localNo')."</div>";
								if (ucfirst(substr($t_child->get('ca_objects.alt_id'), 0, 1)) != "F") {
									if ($va_checkout_info['due_date']) {
										print "<div class='status'>Due ".date('j F Y', $va_checkout_info['due_date'])."</div>";
									} else {
										print "<div class='status'><a href='#' class='available' onclick='caMediaPanel.showPanel(\"".caNavURL($this->request, '', 'Contact', 'libraryRequest', array('object_id' => $va_component))."\"); return false;' title='Request This Item'><i class='fa fa-check-circle'></i> Available</a></div>";
									}
								}
								print "<div class='clearfix'></div>";
								print "<hr/>";
								print "</div>";
								
							}
							print "</div>";
							print "</div>";
						}																																																																																															
					} else {
						if ($va_level_description = $t_object->get('ca_objects.level_desription', array('convertCodesToDisplayText' => true))) {
							print "<div class='unit'><h8>Level of Description</h8>".$va_level_description."</div>";
						}
						if ($va_resource_type = $t_object->get('ca_objects.dc_type', array('convertCodesToDisplayText' => true))) {
							print "<div class='unit'><h8>Resource Type</h8>".$va_resource_type."</div>";
						}
						if ($va_resource_type_archives = $t_object->get('ca_objects.resource_type', array('convertCodesToDisplayText' => true))) {
							print "<div class='unit'><h8>Resource Type</h8>".$va_resource_type_archives."</div>";
						}					
						if ($va_creation_date = $t_object->get('ca_objects.displayDate', array('delimiter', ', '))) {
							print "<div class='unit'><h8>Date of Creation</h8>".$va_creation_date."</div>";
						}																									
						if ($va_genre_archives = $t_object->get('ca_objects.genre', array('convertCodesToDisplayText' => true))) {
							print "<div class='unit'><h8>Genre</h8>".$va_genre_archives."</div>";
						}						 					
						if ($va_genre = $t_object->get('ca_objects.cdwa_work_type', array('convertCodesToDisplayText' => true))) {
							print "<div class='unit'><h8>Genre</h8>".$va_genre."</div>";
						}					
						if ($va_alt_id = $t_object->get('ca_objects.alt_id')) {
							print "<div class='unit'><h8>Object ID</h8>".$va_alt_id."</div>";
						}
						if ($vs_type == "Archival Item") {
							if ($va_idno = $t_object->get('ca_objects.idno')) {
								print "<div class='unit'><h8>Identifier</h8>".$va_idno."</div>";
							}						
							if ($va_creator_archives = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('creator'), 'delimiter' => ', ', 'returnAsLink' => true))) {
								print "<div class='unit'><h8>Creator</h8>".$va_creator_archives."</div>";
							}	
						}				
						if ($va_creator = $t_object->get('ca_objects.cdwa_display_creator')) {
							print "<div class='unit'><h8>Creator</h8>".$va_creator."</div>";
						}
						
						if ($va_bio_hist = $t_object->get('ca_objects.RAD_admin_hist')) {
							print "<div class='unit'><h8>Administrative/Biographical History</h8>".$va_bio_hist."</div>";
						}
						if ($va_scope = $t_object->get('ca_objects.RAD_scopecontent')) {
							print "<div class='unit'><h8>Summary</h8>".$va_scope."</div>";
						}
						if ($va_extent = $t_object->get('ca_objects.RAD_extent')) {
							print "<div class='unit'><h8>Extent & Medium</h8>".$va_extent."</div>";
						}															
						if ($va_place = $t_object->get('ca_objects.creation_place')) {
							print "<div class='unit'><h8>Place of Creation</h8>".$va_place."</div>";
						}
						if ($va_place_note = $t_object->get('ca_objects.place_qualifier')) {
							print "<div class='unit'><h8>Place of Creation Note</h8>".$va_place_note."</div>";
						}
						if ($va_description = $t_object->get('ca_objects.description')) {
							print "<div class='unit trimText'><h8>Description</h8>".$va_description."</div>";
						}
						if ($va_material = $t_object->get('ca_objects.cdwa_displayMaterialsTech')) {
							print "<div class='unit'><h8>Materials/Techniques</h8>".$va_material."</div>";
						}
						if ($va_measurements = $t_object->get('ca_objects.cdwa_displayMeasurements')) {
							print "<div class='unit'><h8>Measurements</h8>".$va_measurements."</div>";
						}
						if ($va_inscriptions = $t_object->get('ca_objects.inscriptions')) {
							print "<div class='unit'><h8>Inscriptions</h8>".$va_inscriptions."</div>";
						}
						if ($va_facture = $t_object->get('ca_objects.facture')) {
							print "<div class='unit'><h8>Method of Construction</h8>".$va_facture."</div>";
						}
						if ($va_language = $t_object->get('ca_objects.language', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
							if ($va_language != '-') {
								print "<div class='unit'><h8>Language</h8>".$va_language."</div>";
							}
						}										
						if ($va_language_note = $t_object->get('ca_objects.language_note')) {
							print "<div class='unit'><h8>Language Note</h8>".$va_language_note."</div>";
						}
						if ($va_statement_responsibility = $t_object->get('ca_objects.RAD_statement')) {
							print "<div class='unit'><h8>Statement of Responsibility</h8>".$va_statement_responsibility."</div>";
						}
						if ($va_archival_history = $t_object->get('ca_objects.RAD_custodial')) {
							print "<div class='unit'><h8>Archival History</h8>".$va_archival_history."</div>";
						}
						if ($va_provenance_museum = $t_object->get('ca_objects.cdwa_ownership.ownership_provenance')) {
							print "<div class='unit'><h8>Provenance</h8>".$va_provenance_museum."</div>";
						}											
						if ($va_provenance = $t_object->get('ca_objects.dc_provenance')) {
							print "<div class='unit'><h8>Provenance</h8>".$va_provenance."</div>";
						}
						if ($va_classification = $t_object->get('ca_objects.classification', array('delimiter' => ', '))) {
							print "<div class='unit'><h8>Classification</h8>".$va_classification."</div>";
						}
						if ($va_provenance_legal = $t_object->get('ca_objects.cdwa_ownership.ownership_legal')) {
							print "<div class='unit'><h8>Status</h8>".$va_provenance_legal."</div>";
						}
						if ($va_provenance_credit = $t_object->get('ca_objects.cdwa_ownership.ownership_credit')) {
							print "<div class='unit'><h8>Credit Line</h8>".$va_provenance_credit."</div>";
						}												
						if ($va_collection = $t_object->get('ca_collections.preferred_labels', array('restrictToRelationshipTypes' => array('part_of'), 'delimiter' => '<br/>', 'returnAsLink' => true))) {
							print "<div class='unit'><h8>Part of</h8>".$va_collection."</div>";
						}
						if ($va_compound = $t_object->getWithTemplate('<unit relativeTo="ca_objects.related" delimiter="<br/>"><l>^ca_objects.preferred_labels</l></unit>')) {
							print "<div class='unit'><h8>Compound Works</h8>".$va_compound."</div>";
						}
						if ($va_assoc_materials = $t_object->get('ca_objects.associated_url')) {
							print "<div class='unit'><h8>Associated Materials</h8><a href='".$va_assoc_materials."' target='_blank'>".$va_assoc_materials."</a></div>";
						}
						if ($va_assoc_materials_note = $t_object->get('ca_objects.associated_text')) {
							print "<div class='unit'><h8>Associated Materials Note</h8>".$va_assoc_materials_note."</div>";
						}						
						if ($t_object->get('ca_objects.alternate_text.alternate_desc_upload')){
							$va_assoc_materials_pdf = $t_object->get('ca_objects.alternate_text', array('returnWithStructure' => true, 'ignoreLocale' => true, 'version' => 'preview', 'convertCodesToDisplayText' => true)); 
							print "<div class='unit document'><h8>Auxiliary Document</h8>";
							$o_db = new Db();
							$vn_media_element_id = $t_object->_getElementID('alternate_desc_upload');
							foreach ($va_assoc_materials_pdf as $vn_assoc_materials_obj_id => $vn_assoc_materials_pdf_image_array) {
								foreach ($vn_assoc_materials_pdf_image_array as $vn_assoc_materials_pdf_id => $vn_assoc_materials_pdf_image) {
									$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_assoc_materials_pdf_id, $vn_media_element_id)) ;
									if ($qr_res->nextRow()) {
										print "<p><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'><i class='fa fa-file'></i> ".ucfirst($vn_assoc_materials_pdf_image['alternate_text_type'])."</a></p>";
									}
								}
							}
							print "</div>";
						}												
						if ($va_general_note = $t_object->get('ca_objects.RAD_generalNote')) {
							print "<div class='unit'><h8>Note</h8>".$va_general_note."</div>";
						}						
						if ($va_dc_note = $t_object->get('ca_objects.dc_notes')) {
							print "<div class='unit'><h8>Note</h8>".$va_dc_note."</div>";
						}
						if ($va_arrangement = $t_object->get('ca_objects.RAD_arrangement')) {
							print "<div class='unit'><h8>System of Arrangement</h8>".$va_arrangement."</div>";
						}					
						if ($va_funding_note = $t_object->get('ca_objects.funding_note')) {
							print "<div class='unit'><h8>Funding Note</h8>".$va_funding_note."</div>";
						}
					}
					$vs_permalink = caNavUrl($this->request, 'Detail', 'objects', $vn_object_id, array(), array('absolute' => 1));
					print "<div class='unit'><h8>Permalink</h8><a href='".$vs_permalink."'>".$vs_permalink."</a></div>";																																																																												
	?>				
					</div><!-- end col -->
								

			
			</div><!-- end row -->
<?php
		if ($vs_type == "Library Item") {
			#Library
			$vs_related_museum = "";
			if ($va_related_museum_objects = $t_object->get('ca_objects.related.object_id', array('returnWithStructure' => true, 'restrictToTypes' => array('library'), 'checkAccess' => $va_access_values))) {
				foreach ($va_related_museum_objects as $va_key => $va_related_museum_object_id) {				
					$t_museum = new ca_objects($va_related_museum_object_id);
					$vs_related_museum.= "<div class='col-sm-3'>";
					$vs_related_museum.= "<div class='relatedThumb'>".caNavLink($this->request, $t_museum->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_related_museum_object_id);
					$vs_related_museum.= "<div>".caNavLink($this->request, $t_museum->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_related_museum_object_id)."</div>";
					$vs_related_museum.= "</div></div>";					
				}
			}
			#Archives Objects etc
			$vs_related_holdings = "";
			if ($va_related_holdings_objects = $t_object->get('ca_objects.related.object_id', array('returnWithStructure' => true, 'restrictToTypes' => array('archival', 'work', 'survivor'), 'checkAccess' => $va_access_values))) {
				foreach ($va_related_holdings_objects as $va_key => $va_related_holdings_object_id) {				
					$t_holding = new ca_objects($va_related_holdings_object_id);
					$vs_related_holdings.= "<div class='col-sm-3'>";
					$vs_related_holdings.= "<div class='relatedThumb'>".caNavLink($this->request, $t_holding->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id);
					$vs_related_holdings.= "<div>".caNavLink($this->request, $t_holding->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."</div>";
					$vs_related_holdings.= "</div></div>";					
				}
			}
			if ($va_related_collections = $t_object->get('ca_collections.collection_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('fonds', 'series', 'sub_series', 'file')))) {
				foreach ($va_related_collections as $va_key => $va_related_collection_id) {				
					$t_collection = new ca_collections($va_related_collection_id);
					$vs_related_holdings.= "<div class='col-sm-3'>";
					$vs_related_holdings.= "<div class='relatedThumb'>";
					$vs_related_holdings.= "<p>".caNavLink($this->request, $t_collection->get('ca_collections.preferred_labels'), '', '', 'Detail', 'objects/'.$va_related_collection_id)."</p></div>";
					$vs_related_holdings.= "</div>";					
				}
			}					
		} else {
			#Museum Objects
			$vs_related_museum = "";
			if ($va_related_museum_objects = $t_object->get('ca_objects.related.object_id', array('returnWithStructure' => true, 'restrictToTypes' => array('work'), 'checkAccess' => $va_access_values))) {
				foreach ($va_related_museum_objects as $va_key => $va_related_museum_object_id) {				
					$t_museum = new ca_objects($va_related_museum_object_id);
					$vs_related_museum.= "<div class='col-sm-3'>";
					$vs_related_museum.= "<div class='relatedThumb'>".caNavLink($this->request, $t_museum->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_related_museum_object_id);
					$vs_related_museum.= "<div>".caNavLink($this->request, $t_museum->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_related_museum_object_id)."</div>";
					$vs_related_museum.= "</div></div>";					
				}
			}
			#Archives Objects etc
			$vs_related_holdings = "";
			if ($va_related_holdings_objects = $t_object->get('ca_objects.related.object_id', array('returnWithStructure' => true, 'restrictToTypes' => array('archival', 'library', 'survivor'), 'checkAccess' => $va_access_values))) {
				foreach ($va_related_holdings_objects as $va_key => $va_related_holdings_object_id) {				
					$t_holding = new ca_objects($va_related_holdings_object_id);
					$vs_related_holdings.= "<div class='col-sm-3'>";
					$vs_related_holdings.= "<div class='relatedThumb'>".caNavLink($this->request, $t_holding->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id);
					$vs_related_holdings.= "<div>".caNavLink($this->request, $t_holding->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_related_holdings_object_id)."</div>";
					$vs_related_holdings.= "</div></div>";					
				}
			}
			if ($va_related_collections = $t_object->get('ca_collections.collection_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('fonds', 'series', 'sub_series', 'file')))) {
				foreach ($va_related_collections as $va_key => $va_related_collection_id) {				
					$t_collection = new ca_collections($va_related_collection_id);
					$vs_related_holdings.= "<div class='col-sm-3'>";
					$vs_related_holdings.= "<div class='relatedThumb'>";
					$vs_related_holdings.= "<p>".caNavLink($this->request, $t_collection->get('ca_collections.preferred_labels'), '', '', 'Detail', 'objects/'.$va_related_collection_id)."</p></div>";
					$vs_related_holdings.= "</div>";					
				}
			}					
		}

			
			#Entities
			$vs_related_entities = "";
			if ($va_related_entities = $t_object->get('ca_entities.entity_id', array('checkAccess' => $va_access_values))) {
				$vs_related_entities.= $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter=" "><div class="col-sm-3"><div class="entityThumb"><p><l>^ca_entities.preferred_labels</l> (^relationship_typename)</p></div></div></unit>');					
			}
			#Places
			$vs_related_places = "";
			if ($va_related_places = $t_object->get('ca_places.place_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
				foreach ($va_related_places as $va_key => $va_related_place_id) {				
					$t_place = new ca_places($va_related_place_id);
					$vs_place_name = $t_place->get('ca_places.preferred_labels');
					$vs_related_places.= "<div class='col-sm-3'>";
					$vs_related_places.= "<div class='entityThumb'>";
					$vs_related_places.= "<p>".caNavLink($this->request, $vs_place_name, '', '', 'Search', 'objects', array('search' => 'ca_places.preferred_labels:"'.$vs_place_name.'"'))."</p></div>";
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
			if ($va_related_events = $t_object->get('ca_occurrences.occurrence_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
				foreach ($va_related_events as $va_key => $va_related_event_id) {				
					$t_occurrence = new ca_occurrences($va_related_event_id);
					$vs_related_events.= "<div class='col-sm-3'>";
					$vs_related_events.= "<div class='entityThumb'>";
					$vs_related_events.= "<p>".$t_occurrence->get('ca_occurrences.preferred_labels', array('returnAsLink' => true))."</p></div>";
					$vs_related_events.= "</div>";					
				}
			}
			if ($vs_related_museum | $vs_related_holdings | $vs_related_entities | $vs_related_places | $vs_related_collections | $vs_related_events) {															
?>		
			<hr>	
			<div class='row'>
				<div class='col-sm-12'>
					<h4 style='font-size:16px;'>Related</h4>
					<div class='container' id='relationshipTable'>
						<ul class='row'>
<?php						
							if (($vs_related_museum) && ($vs_type == "Library Item")) { 
								print '<li><a href="#museumTab">Related Library Items</a></li>'; 
							} elseif ($vs_related_museum) {
								print '<li><a href="#museumTab">Related Works</a></li>';
							}
							if ($vs_related_holdings) { print '<li><a href="#holdingsTab">Holdings</a></li>'; }
							if ($vs_related_entities) { print '<li><a href="#entityTab">People & Organizations</a></li>'; }
							if ($vs_related_places) { print '<li><a href="#placeTab">Places</a></li>'; }
							if ($vs_related_collections) { print '<li><a href="#collectionTab">Collections</a></li>'; }
							if ($vs_related_events) { print '<li><a href="#eventTab">Events</a></li>'; }																																			
?>																					
						</ul>
						<div id='museumTab' class='row'>									
							<?php print $vs_related_museum; ?>	 												
						</div>						
						<div id='holdingsTab' class='row' >
							<?php print $vs_related_holdings; ?>
						</div>
						<div id='entityTab' class='row'>
							<?php print $vs_related_entities; ?>
						</div>
						<div id='placeTab' class='row'>
							<?php print $vs_related_places; ?>
						</div>														
						<div id='collectionTab' class='row'>
							<?php print $vs_related_collections; ?>
						</div>
						<div id='eventTab' class='row'>
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
