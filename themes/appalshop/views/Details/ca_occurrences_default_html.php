<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_occurrences_default_html.php : 
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
 
$t_item = 			$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_item->get('ca_occurrences.occurrence_id');
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>

<?php
	if($show_nav){
?>
	<div class="row mt-n3">
		<div class="col text-center text-md-end">
			<nav aria-label="result">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</nav>
		</div>
	</div>
<?php
	}
?>
	<div class="row">
		<div class="col-md-12">
			<H1 class="fs-3">{{{^ca_occurrences.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_occurrences.type_id|ca_occurrences.idno"><div class="fw-medium mb-3 text-capitalize"><ifdef code="ca_occurrences.type_id">^ca_occurrences.type_id</ifdef><ifdef code="ca_occurrences.idno">, ^ca_occurrences.idno</ifdef></div></ifdef>}}}
			<hr class="mb-0">
		</div>
	</div>
<?php
	if($inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">
		<div class="col text-center text-md-end">
			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_occurrences", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_occurrences", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'));
				}
				if($copy_link_enabled){
					print $this->render('Details/snippets/copy_link_html.php');
				}
?>
			</div>
		</div>
	</div>
<?php
	}
?>
	<div class="row row-cols-1 row-cols-md-2">
		<div class="col">				
		{{{
			<ifcount code="ca_objects" min="1" restrictToRelationshipTypes="primary">
				<div class="mb-2">
					<unit relativeTo="ca_objects" delimiter="<br/><br/>" restrictToRelationshipTypes="primary">
						<div class='detailPrimaryImage object-fit-contain'><l>^ca_object_representations.media.large</l><div class='pt-1 text-center'>Related Object: <l>^ca_objects.preferred_labels.name</l></div></div>
					</unit>
				</div>
			</ifcount>
		}}}
		</div>
		<div class="col">
				{{{<dl class="mb-0">
					<ifdef code="ca_occurrences.idno"><div class="unit"><dt>Identifier</dt><dd>^ca_occurrences.idno</dd></ifdef>
					<ifdef code="ca_occurrences.dateProduced"><div class="unit"><dt>Date of Production</dt><dd>^ca_occurrences.dateProduced</dd></ifdef>
					<ifdef code="ca_occurrences.color"><div class="unit"><dt>Color</dt><dd>^ca_occurrences.color</dd></ifdef>
					<ifdef code="ca_occurrences.duration"><div class="unit"><dt>Duration</dt><dd>Run time: ^ca_occurrences.duration.runTime</dd></ifdef>
					<ifcount code="ca_entities" restrictToRelationshipTypes="artist,co_producer,composer,director,illustrator,performer,photographer,producer,writer" code="ca_entities" min="1" max="1"><dt>Creator</dt></ifcount>
					<ifcount code="ca_entities" restrictToRelationshipTypes="artist,co_producer,composer,director,illustrator,performer,photographer,producer,writer" code="ca_entities" min="2"><dt>Creators</dt></ifcount>
					<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="artist,co_producer,composer,director,illustrator,performer,photographer,producer,writer"><dd>^ca_entities.preferred_labels.displayname (^relationship_typename)</dd></unit>
				
					<ifcount code="ca_entities" restrictToRelationshipTypes="actor,animator,audio_engineer,author,broadcast_engineer,camera_assistant,camera_operator,cinematographer,composer,contributing_artist,editor,engineer,filmmaker,interviewee,interviewer,musician,narrator,performer,recording_engineer,sound_mixer,subject,writer" min="1" max="1"><dt>Contributor</dt></ifcount>
					<ifcount code="ca_entities" restrictToRelationshipTypes="actor,animator,audio_engineer,author,broadcast_engineer,camera_assistant,camera_operator,cinematographer,composer,contributing_artist,editor,engineer,filmmaker,interviewee,interviewer,musician,narrator,performer,recording_engineer,sound_mixer,subject,writer" min="2"><dt>Contributors</dt></ifcount>
					<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="actor,animator,audio_engineer,author,broadcast_engineer,camera_assistant,camera_operator,cinematographer,composer,contributing_artist,editor,engineer,filmmaker,interviewee,interviewer,musician,narrator,performer,recording_engineer,sound_mixer,subject,writer"><dd>^ca_entities.preferred_labels.displayname (^relationship_typename)</dd></unit>
					<ifdef code="ca_occurrences.abstract"><div class="unit"><dt>Summary</dt><dd>^ca_occurrences.abstract</dd></ifdef>
					<ifdef code="ca_occurrences.externalLink"><dt>External Links</dt><unit relativeTo="ca_occurrences" delimiter=""><dd><a href="^ca_occurrences.externalLink.url_entry" target="_blank">^ca_occurrences.externalLink.url_source</a></dd></ifdef>
					
				</dl>}}}
		</div>
	</div>
	<div class="row row-cols-1 row-cols-md-2 mt-3">
		<div class="col">
<?php
			$va_loc_md = array("Names (Library of Congress)" => "lcsh_names", "Topics (Library of Congress)" => "lcsh_topical", "Geographical Areas (Library of Congress)" => "lcsh_geo", "Genre (Library of Congress)" => "lcsh_genre");
			if(is_array($va_loc_md) && sizeof($va_loc_md)){
				foreach($va_loc_md as $vs_label => $vs_loc_md){
					if($va_terms = $t_item->get("ca_occurrences.".$vs_loc_md, array("returnAsArray" => true))){
						$va_tmp = array();
						print "<dt>".$vs_label."</dt>";
						foreach($va_terms as $vs_term){
							if($vn_str_pos = strpos($vs_term, " [")){
								$va_tmp[] = substr($vs_term, 0, $vn_str_pos);
							}else{
								$va_tmp[] = $vs_term;
							}
						}
						print "<dd>".join(", ", $va_tmp)."</dd>";
					}
				}
			}
?>
		</div>
		<div class="col">
		
				<dl>
					{{{<ifdef code="ca_occurrences.work_description_w_type.work_description"><dt>Description</dt>
					<dd>^ca_occurrences.work_description_w_type.work_description</dd></ifdef>}}}
<?php
					if($va_subjects = $t_item->get("ca_list_items.preferred_labels.name_plural", array("returnAsArray" => true, "checkAccess" => $va_access_values))){
						print "<dt>Subject".((sizeof($va_subjects) > 1) ? "s" : "")."</dt>";
						$va_subject_links = array();
						foreach($va_subjects as $vs_subject){
							$va_subject_links[] = caNavLink($this->request, $vs_subject, '', '', 'Search', 'GeneralSearch', array('search' => '"'.$vs_subject.'"'));	
						}
						print "<dd>".join(", ", $va_subject_links)."</dd>";
					}
?>				
				{{{	
					<ifcount code="ca_occurrences.related" min="1" max="1"><dt>Related Work</dt></ifcount>
					<ifcount code="ca_occurrences.related" min="2"><dt>Related Works</dt></ifcount>
					<unit relativeTo="ca_occurrences" delimiter=""><dd><l>^ca_occurrences.related.preferred_labels.name</l></dd></unit>
					
					<ifcount code="ca_collections" min="1" max="1"><dt>Related Collection</dt></ifcount>
					<ifcount code="ca_collections" min="2"><dt>Related Collections</dt></ifcount>
					<unit relativeTo="ca_collections" delimiter=""><dd><l>^ca_collections.preferred_labels.name</l></dd></unit>
						
					<ifcount code="ca_places" min="1" max="1"><dt>Related Place</dt></ifcount>
					<ifcount code="ca_places" min="2"><dt>Related Places</dt></ifcount>
					<unit relativeTo="ca_places" delimiter=""><dd><l>^ca_places.preferred_labels.name</l></dd></unit>
				}}}
				</dl>			
<?php
		if($t_item->get("ca_occurrences.georeference", array("checkAccess" => $access_values))){
?>
			<div><div id="map" class="map">{{{map}}}</div></div>
<?php
		}
?>
		</div>
	</div>

{{{<ifcount code="ca_objects" min="2">
	<div class="row mt-4">
		<div class="col"><h2>Related Objects</h2><hr></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_occurrences.occurrence_id:'.$t_item->get("ca_occurrences.occurrence_id"))); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
</ifcount>}}}