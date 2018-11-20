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
	
	$t_list = new ca_lists();
	$vs_yes = $t_list->getItemIDFromList("yn", "yes");
	$vs_no = $t_list->getItemIDFromList("yn", "no");
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
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>


			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
<?php
				if ($vs_idno = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Work Code</h6>".$vs_idno."</div>";
				}
				if ($vs_artist = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'returnAsLink' => true))) {
					print "<div class='unit'><h6>Artist</h6>".$vs_artist."</div>";
				}
				if ($vs_year = $t_object->get('ca_objects.creation_date')) {
					print "<div class='unit'><h6>Year of Creation</h6>".$vs_year."</div>";
				}
				if ($vs_medium = $t_object->get('ca_objects.medium')) {
					print "<div class='unit'><h6>Medium</h6>".$vs_medium."</div>";
				}
				if ($vs_dimensions = $t_object->getWithTemplate('<ifcount code="ca_objects.dimensions" min="1"><unit><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height H</ifdef><ifdef code="ca_objects.dimensions.dimensions_width"> x ^ca_objects.dimensions.dimensions_width W</ifdef><ifdef code="ca_objects.dimensions.dimensions_depth"> x ^ca_objects.dimensions.dimensions_depth D</ifdef> <ifdef code="ca_objects.dimensions.height_in|ca_objects.dimensions.width_in|ca_objects.dimensions.depth_in">(</ifdef><ifdef code="ca_objects.dimensions.height_in">^ca_objects.dimensions.height_in H</ifdef><ifdef code="ca_objects.dimensions.width_in"> x ^ca_objects.dimensions.width_in W</ifdef><ifdef code="ca_objects.dimensions.depth_in"> x ^ca_objects.dimensions.depth_in D</ifdef><ifdef code="ca_objects.dimensions.height_in|ca_objects.dimensions.width_in|ca_objects.dimensions.depth_in">)</ifdef><ifdef code="ca_objects.dimensions.dimensions_weight">, ^ca_objects.dimensions.dimensions_weight Weight</ifdef><ifdef code="ca_objects.dimensions.dimensions_notes"><br/>^ca_objects.dimensions.dimensions_notes</ifdef></unit></ifcount>')) {
					print "<div class='unit'><h6>Dimensions</h6>".$vs_dimensions."</div>";
				} elseif ($vs_dimensions = $t_object->get('ca_objects.dimensions_readOnly')) {
					print "<div class='unit'><h6>Dimensions</h6>".$vs_dimensions."</div>";
				}
				if ($vs_edition = $t_object->get('ca_objects.edition')) {
					print "<div class='unit'><h6>Edition</h6>".$vs_edition."</div>";
				}	
				if ($vs_cert = $t_object->getWithTemplate('<ifdef code="ca_objects.certificate_auth.certificate_auth_yn">^ca_objects.certificate_auth.certificate_auth_yn ^ca_objects.certificate_auth.certificate_auth_notes</ifdef>')) {
					print "<div class='unit'><h6>Certificate of Authenticity</h6>".$vs_cert."</div>";
				}
				if ($vs_parts = $t_object->get('ca_objects.children.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Parts</h6>".$vs_parts."</div>";
				}
				if ($vs_description = $t_object->get('ca_objects.description')) {
					print "<div class='unit'><h6>Description</h6>".$vs_description."</div>";
				}
				if ($vs_prov = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('provenance'), 'returnAsLink' => true))) {
					print "<div class='unit'><h6>Provenance</h6>".$vs_prov."</div>";
				}
				if ($vs_acq = $t_object->get('ca_objects.acquisition_date')) {
					print "<div class='unit'><h6>Date of Acquisition</h6>".$vs_acq."</div>";
				}	
				if ($vs_notes = $t_object->get('ca_objects.notes')) {
					print "<div class='unit'><h6>Notes</h6>".$vs_notes."</div>";
				}
				if ($vs_cat = $t_object->get('ca_objects.category', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Category</h6>".$vs_cat."</div>";
				}	
				if ($vs_group = $t_object->get('ca_objects.group', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Group</h6>".$vs_group."</div>";
				}	
				if ($vs_art = $t_object->get('ca_objects.art_types', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Art Type</h6>".$vs_art."</div>";
				}
				print "<hr>";
				
				if ($vs_sound = $t_object->get('ca_objects.sound_types', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Sound Types</h6>".$vs_sound."</div>";
				}
				if ($vs_subtitles = $t_object->get('ca_objects.subtitles_yn', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Subtitles</h6>".$vs_subtitles."</div>";
				}	
				if ($vs_langsubtitles = $t_object->get('ca_objects.subtitles_language', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
					print "<div class='unit'><h6>Language of Subtitles</h6>".$vs_langsubtitles."</div>";
				}
				if ($vs_equipment = $t_object->get('ca_objects.equipment')) {
					print "<div class='unit'><h6>Equipment</h6>".$vs_equipment."</div>";
				}
				if ($vs_copy = $t_object->get('ca_objects.video_copyright')) {
					print "<div class='unit'><h6>Copyright</h6>".$vs_copy."</div>";
				}
				if ($vs_general = $t_object->get('ca_objects.general_use')) {
					print "<div class='unit'><h6>General Terms of Use</h6>".$vs_general."</div>";
				}
				if ($vs_digit = $t_object->get('ca_objects.digitized_yn', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Digitized</h6>".$vs_digit."</div>";
				}
				if ($t_object->get('ca_objects.video_format.master_yn') == $vs_yes) {
					print "<div class='unit'><h6>Master</h6>".$t_object->get('ca_objects.video_format.master_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.org_master_yn') == $vs_yes) {
					print "<div class='unit'><h6>Original Master</h6>".$t_object->get('ca_objects.video_format.org_master_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.sub_master_yn') == $vs_yes) {
					print "<div class='unit'><h6>Submaster</h6>".$t_object->get('ca_objects.video_format.sub_master_text')."</div>";
				}	
				if ($t_object->get('ca_objects.video_format.suborg_master_yn') == $vs_yes) {
					print "<div class='unit'><h6>Original Submaster</h6>".$t_object->get('ca_objects.video_format.suborg_master_text')."</div>";
				}		
				if ($t_object->get('ca_objects.video_format.umatic_yn') == $vs_yes) {
					print "<div class='unit'><h6>Umatic</h6>".$t_object->get('ca_objects.video_format.umatic_text')."</div>";
				}	
				if ($t_object->get('ca_objects.video_format.beta_yn') == $vs_yes) {
					print "<div class='unit'><h6>Beta</h6>".$t_object->get('ca_objects.video_format.beta_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.vhs_yn') == $vs_yes) {
					print "<div class='unit'><h6>VHS</h6>".$t_object->get('ca_objects.video_format.vhs_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.floppy_yn') == $vs_yes) {
					print "<div class='unit'><h6>Floppy Disk</h6>".$t_object->get('ca_objects.video_format.floppy_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.cd_yn') == $vs_yes) {
					print "<div class='unit'><h6>CD</h6>".$t_object->get('ca_objects.video_format.cd_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.dvd_yn') == $vs_yes) {
					print "<div class='unit'><h6>DVD</h6>".$t_object->get('ca_objects.video_format.dvd_text')."</div>";
				}	
				if ($t_object->get('ca_objects.video_format.laser_yn') == $vs_yes) {
					print "<div class='unit'><h6>Laser Disk</h6>".$t_object->get('ca_objects.video_format.laser_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.digital_beta') == $vs_yes) {
					print "<div class='unit'><h6>Digital Betacam</h6>".$t_object->get('ca_objects.video_format.digital_beta_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.tape_yn') == $vs_yes) {
					print "<div class='unit'><h6>Digital Betacam</h6>".$t_object->get('ca_objects.video_format.tape_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.other') == $vs_yes) {
					print "<div class='unit'><h6>Other</h6>".$t_object->get('ca_objects.video_format.other_text')."</div>";
				}
				if ($vs_content = $t_object->get('ca_objects.content')) {
					print "<div class='unit'><h6>Content</h6>".$vs_content."</div>";
				}
				if ($vs_historical = $t_object->get('ca_objects.historical_background')) {
					print "<div class='unit'><h6>Historical Background</h6>".$vs_historical."</div>";
				}
				if ($vs_descformats = $t_object->get('ca_objects.description_formats')) {
					print "<div class='unit'><h6>Description of the Formats</h6>".$vs_descformats."</div>";
				}
				if ($vs_elementsaudio = $t_object->get('ca_objects.elements_nonav')) {
					print "<div class='unit'><h6>Elements Non-audiovisual</h6>".$vs_elementsaudio."</div>";
				}	
				print "<hr>";
				if ($vs_type_of_material = $t_object->get('ca_objects.type_of_material')) {
					print "<div class='unit'><h6>Type of Material</h6>".$vs_type_of_material."</div>";
				}
				if ($vs_number_of_material = $t_object->get('ca_objects.number_of_material')) {
					print "<div class='unit'><h6>Number of Material</h6>".$vs_number_of_material."</div>";
				}	
				if ($vs_original_trans = $t_object->get('ca_objects.original_trans')) {
					print "<div class='unit'><h6>Original transparencies</h6>".$vs_original_trans."</div>";
				}
				if ($vs_10125_original = $t_object->get('ca_objects.10125_original')) {
					print "<div class='unit'><h6>10x12.5 Original</h6>".$vs_10125_original."</div>";
				}
				if ($vs_10125_duplicates = $t_object->get('ca_objects.10125_duplicates')) {
					print "<div class='unit'><h6>10x12.5 Duplicates</h6>".$vs_10125_duplicates."</div>";
				}
				if ($vs_35mm_original = $t_object->get('ca_objects.35mm_original')) {
					print "<div class='unit'><h6>35mm Original</h6>".$vs_35mm_original."</div>";
				}	
				if ($vs_35mm_duplicates = $t_object->get('ca_objects.35mm_duplicates')) {
					print "<div class='unit'><h6>35mm Duplicates</h6>".$vs_35mm_duplicates."</div>";
				}
				if ($vs_large_trans = $t_object->get('ca_objects.large_trans')) {
					print "<div class='unit'><h6>Large Transparencies</h6>".$vs_large_trans."</div>";
				}
				if ($vs_media_path = $t_object->get('ca_objects.media_path', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Path to media</h6>".$vs_media_path."</div>";
				}																																																																																																																																																																															
?>						
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
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