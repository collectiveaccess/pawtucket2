<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2024 Whirl-i-Gig
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
$t_object = 		$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_object->getPrimaryKey();
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
$media_options = $this->getVar('media_options') ?? [];

$lightboxes = $this->getVar('lightboxes') ?? [];
$in_lightboxes = $this->getVar('inLightboxes') ?? [];

$media_options = array_merge($media_options, [
	'id' => 'mediaviewer'
]);
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
	pawtucketUIApps['mediaViewerManager'] = <?= json_encode($media_options); ?>;
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
			<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_objects.type_id"><div class="fw-medium mb-3">^ca_objects.type_id</div></ifdef>}}}
			<hr class="mb-0">
		</div>
	</div>
<?php
	if(caDisplayLightbox($this->request) || $inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">
		<div class="col text-center text-md-end">
			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_objects", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'));
				}
				if($copy_link_enabled){
					print $this->render('Details/snippets/copy_link_html.php');
				}
?>				
			</div>
			<?= $this->render('Details/snippets/lightbox_list_html.php'); ?>
		</div>
	</div>
<?php
	}
?>

	<div class="row mb-4">
		<div class="col-md-6">
			{{{media_viewer}}}
		</div>
		<div class="col-md-6">
			<div class="bg-light py-3 px-4 mb-3 h-100"><!-- height is to make the gray background of box same height as the containing row -->			
				{{{<dl class="mb-0">
					<ifdef code="ca_objects.nonpreferred_labels">
						<dt><?= _t('Alternate Title(s)'); ?></dt>
						<unit relativeTo="ca_objects.nonpreferred_labels" delimiter="">
							<dd>^ca_objects.nonpreferred_labels.name<ifdef code="ca_objects.nonpreferred_labels.type_id">, ^ca_objects.nonpreferred_labels.type_id</ifdef></dd>
						</unit>
					</ifdef>
					<ifdef code="ca_objects.idno"><dt>Identifier</dt><dd>^ca_objects.idno</dd></ifdef>
					<ifdef code="ca_objects.altID"><dt>Alt Identifier</dt><dd>^ca_objects.altID</dd></ifdef>
					<ifdef code="ca_objects.altID"><dt>Asset Type</dt><dd>^ca_objects.asset_type</dd></ifdef>
					<ifdef code="ca_objects.date.dates_value"><dt>Date</dt></ifdef>			
					<unit relativeTo="ca_objects.date.dates_value" delimiter=""><dd>^ca_objects.date.dc_dates_types <if rule="^ca_objects.date.date_approximate2 =~ /Yes/">circa </if>^ca_objects.date.dates_value</dd></unit>

					<ifdef code="ca_objects.av_date.av_dates_value"><dt>Date</dt><dd>^ca_objects.av_date.av_dates_value<ifdef code="ca_objects.av_date.av_dates_value">, ^ca_objects.av_date.av_dates_value</ifdef></dd></ifdef>
					<ifdef code="ca_objects.description_w_type">
						<dt>Description<ifdef code="ca_objects.description_w_type.description"> (^ca_objects.description_w_type.description)</ifdef></dt><dd>^ca_objects.description_w_type.description</dd>
					</ifdef>
					<ifcount restrictToRelationshipTypes="artist,co_producer,composer,director,illustrator,performer,photographer,producer,writer" code="ca_entities" min="1" max="1"><dt>Creator</dt></ifcount>
					<ifcount restrictToRelationshipTypes="artist,co_producer,composer,director,illustrator,performer,photographer,producer,writer" code="ca_entities" min="2"><dt>Creators</dt></ifcount>
					<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="artist,co_producer,composer,director,illustrator,performer,photographer,producer,writer"><dd>^ca_entities.preferred_labels (^relationship_typename)</dd></unit>
					<ifcount restrictToRelationshipTypes="actor,animator,audio_engineer,author,broadcast_engineer,camera_assistant,camera_operator,cinematographer,composer,contributing_artist,editor,engineer,filmmaker,interviewee,interviewer,musician,narrator,performer,recording_engineer,sound_mixer,subject,writer,publisher" code="ca_entities" min="1" max="1"><dt>Contributor</dt></ifcount>
					<ifcount restrictToRelationshipTypes="actor,animator,audio_engineer,author,broadcast_engineer,camera_assistant,camera_operator,cinematographer,composer,contributing_artist,editor,engineer,filmmaker,interviewee,interviewer,musician,narrator,performer,recording_engineer,sound_mixer,subject,writer,publisher" code="ca_entities" min="2"><dt>Contributors</dt></ifcount>
					<unit relativeTo="ca_entities.related" delimiter="" restrictToRelationshipTypes="actor,animator,audio_engineer,author,broadcast_engineer,camera_assistant,camera_operator,cinematographer,composer,contributing_artist,editor,engineer,filmmaker,interviewee,interviewer,musician,narrator,performer,recording_engineer,sound_mixer,subject,writer,publisher"><dd>^ca_entities.preferred_labels (^relationship_typename)</dd></unit>
					<ifdef code="ca_objects.duration"><dt>Duration</dt><dd>^ca_objects.duration</dd></ifdef>
					<ifdef code="ca_objects.media_type"><dt>Media Type</dt><dd>^ca_objects.media_type</dd></ifdef>
					<ifdef code="ca_objects.av_format_Hierachical"><dt>Physical Format</dt><dd>^ca_objects.av_format_Hierachical</dd></ifdef>
					<ifdef code="ca_objects.ph_digital_format"><dt>Digital Format</dt><dd>^ca_objects.ph_digital_format</dd></ifdef>
					<ifdef code="ca_objects.photo_format"><dt>Format</dt><dd>^ca_objects.photo_format</dd></ifdef>
					<ifdef code="ca_objects.paper_format"><dt>Format</dt><dd>^ca_objects.paper_format</dd></ifdef>
					<ifdef code="ca_objects.erec_format"><dt>Format</dt><dd>^ca_objects.erec_format</dd></ifdef>
					<ifdef code="ca_objects.generation_element"><dt>Generation:</dt><dd>^ca_objects.generation_element</dd></ifdef>
					<ifdef code="ca_objects.generation_general")><dt>Generation - General</dt><dd>^ca_objects.generation_general</dd></ifdef>
					<ifdef code="ca_objects.container"><dt>Container</dt><dd>^ca_objects.container</dd></ifdef>	
					<ifdef code="ca_objects.georeference"><dt>Georeference</dt><dd>^ca_objects.georeference</dd></ifdef>	
					<ifdef code="ca_objects.color"><dt>Color</dt><dd>^ca_objects.color</dd></ifdef>	
					<ifdef code="ca_objects.av_sound"><dt>Sound</dt><dd>^ca_objects.av_sound</dd></ifdef>
				}}}				
<?php
				$va_list_items = $t_object->get("ca_list_items", array("returnWithStructure" => true));
				if(is_array($va_list_items) && sizeof($va_list_items)){
					$va_terms = array();
					foreach($va_list_items as $va_list_item){
						$va_terms[] = caNavLink($this->request, $va_list_item["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_list_item["item_id"]));
					}
					print "<dt>Subject".((sizeof($va_terms) > 1) ? "s" : "")."</dt><dd>".join(", ", $va_terms)."</dd>";	
				}
				if($va_lcsh = $t_object->get("ca_objects.lcsh_topical", array("returnAsArray" => true))){
					if(is_array($va_lcsh) && sizeof($va_lcsh)){
						print "<dt>Topics, Library of Congress Authority</dt>";
						print "<dd>";
						$i = 0;
						foreach($va_lcsh as $vs_lcsh){
							$va_tmp = explode(" [", $vs_lcsh);
							print $va_tmp[0];
							$i++;
							if($i < sizeof($va_lcsh)){
								print ", ";
							}
						}
						print "</dd>";
					}
				}
				if($va_lcsh = $t_object->get("ca_objects.lcsh_names", array("returnAsArray" => true))){
					if(is_array($va_lcsh) && sizeof($va_lcsh)){
						print "<dt>Names, Library of Congress Authority</dt>";
						print "<dd>";
						$i = 0;
						foreach($va_lcsh as $vs_lcsh){
							$va_tmp = explode(" [", $vs_lcsh);
							print $va_tmp[0];
							$i++;
							if($i < sizeof($va_lcsh)){
								print ", ";
							}
						}
						print "</dd>";
					}
				}
				if($va_lcsh_geo = $t_object->get("ca_objects.lcsh_geo", array("returnAsArray" => true))){
					if(is_array($va_lcsh_geo) && sizeof($va_lcsh_geo)){
						print "<dt>Geographical Areas, Library of Congress Authority</dt>";
						print "<dd>";
						$i = 0;
						foreach($va_lcsh_geo as $vs_lcsh_geo){
							$va_tmp = explode(" [", $vs_lcsh_geo);
							print $va_tmp[0];
							$i++;
							if($i < sizeof($va_lcsh_geo)){
								print ", ";
							}
						}
						print "</dd>";
					}
				}
				if($va_lcsh = $t_object->get("ca_objects.lcsh_genre", array("returnAsArray" => true))){
					if(is_array($va_lcsh) && sizeof($va_lcsh)){
						print "<dt>Genre, Library of Congress Authority</dt>";
						print "<dd>";
						$i = 0;
						foreach($va_lcsh as $vs_lcsh){
							$va_tmp = explode(" [", $vs_lcsh);
							print $va_tmp[0];
							$i++;
							if($i < sizeof($va_lcsh)){
								print ", ";
							}
						}
						print "</dd>";
					}
				}
?>
				
				{{{
					<ifdef code="ca_objects.coverage"><dt>Coverage</dt><dd>^ca_objects.coverage</dd></ifdef>
					<ifdef code="ca_objects.source"><dt>Source</dt><dd>^ca_objects.source</dd></ifdef>	
					<ifdef code="ca_objects.rights"><dt>Rights Summary</dt><dd>^ca_objects.rights</dd></ifdef>
					<ifdef code="ca_objects.access_restrictions"><dt>Access Restrictions</dt><dd>^ca_objects.access_restrictions</dd></ifdef>			
					<ifdef code="ca_objects.user_restrictions"><dt>User Restrictions</dt><dd>^ca_objects.user_restrictions</dd></ifdef>
					<ifdef code="ca_objects.externalLink"><dt>External Links</dt><unit relativeTo="ca_objects" delimiter=""><dd><a href="^ca_objects.externalLink.url_entry" target="_blank">^ca_objects.externalLink.url_source</a></dd></unit></ifdef>
					<ifcount code="ca_collections" unique="1"  min="1" max="1"><dt>Related Collection</dt></ifcount>
					<ifcount code="ca_collections" unique="1"  min="2"><dt>Related Collections</dt></ifcount>
					<unit unique="1" relativeTo="ca_collections" delimiter=""><dd><l>^ca_collections.preferred_labels.name</l></dd></unit>						
					<ifcount code="ca_occurrences" min="1" max="1"><dt>Related Work</dt></ifcount>
					<ifcount code="ca_occurrences" min="2"><dt>Related Works</dt></ifcount>
					<unit relativeTo="ca_occurrences" delimiter=""><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>		
					<ifcount code="ca_places" min="1" max="1"><dt>Related Place</dt></ifcount>
					<ifcount code="ca_places" min="2"><dt>Related Places</dt></ifcount>
					<unit relativeTo="ca_places" delimiter=""><dd><l>^ca_places.preferred_labels</l></dd></unit>
					
				</dl>}}}
							
			</div>
		</div>
	</div>
<?php
		if($t_object->get("ca_places.georeference", array("checkAccess" => $access_values))){
?>
		<div class="row mb-4">
			<div class="col-md-6 offset-md-6"><div id="map" class="map">{{{map}}}</div></div>
		</div>
<?php
		}
		$vs_rel_objects = $t_object->getWithTemplate("<unit relativeTo='ca_objects.related' delimiter='~'><ifdef code='ca_object_representations.media.iconlarge'>^ca_object_representations.media.iconlarge</ifdef><div class='relObjectLabel'><l>^ca_objects.preferred_labels.name%truncate=40&ellipsis=1</l></div></unit>");
		$vn_c = 0;
		if($vs_rel_objects){
?>
	<div class="row my-4">
		<div class="col-12">	
			<H2>Related Objects</H2>
<?php
			$va_rel_objects = explode("~", $vs_rel_objects);
			foreach($va_rel_objects as $vs_rel_object){
				if($vn_c == 0){
					print "<div class='row'>";
				}
				print "<div class='col-6 col-sm-3 col-lg-2 text-center img-fluid mb-3'>".$vs_rel_object."</div>";
				$vn_c++;
				if($vn_c == 6){
					print "</div>";
					$vn_c = 0;
				}
			}
			if($vn_c > 0){
				print "</div>";
			}
?>
			</div><!-- end col -->
		</div>
<?php
		}
?>