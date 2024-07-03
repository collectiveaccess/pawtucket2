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
	
	$va_fields = array(
		#"Unit ID" => "^ca_objects.unit_id%delimiter=,_",
		"Alternate Name" => "^ca_objects.nonpreferred_labels%delimiter=,_",
		"Container ID" => "^ca_objects.container_id",
		"AV Subtype" => "^ca_objects.av_subtype",
		"Dates" => "<ifdef code='ca_objects.inclusive_dates'>^ca_objects.inclusive_dates%delimiter=,_</ifdef><ifnotdef code='ca_objects.inclusive_dates'>^ca_objects.display_date%delimiter=,_</ifnotdef>",
		"Description" => "^ca_objects.description",
		"Language" => "^ca_objects.language%delimiter=,_",
		"Related Creators" => "<ifcount code='ca_entities' excludeRelationshipTypes='donor,depicted,original_owner,subject'><unit relativeTo='ca_entities' excludeRelationshipTypes='donor,depicted,original_owner,subject' delimiter='<br/>'>^ca_entities.preferred_labels.displayname (^relationship_typename)</unit></ifcount>",
		"Event Type" => "^ca_objects.event_type%delimiter=,_",
		"Related Publications" => "^ca_objects.related_publications",
		"Related Materials" => "<ifdef code='ca_objects.related_materials'><span class='trimText'>^ca_objects.related_materials</span></ifdef>",
		"Transcript Availability" => "^ca_objects.transcript_availability",
		"Transcript Notes" => "^ca_objects.transcript_notes",
		"URL" => "<unit relativeTo='ca_objects.url' delimiter='<br/>'><a href='^ca_objects.url.link_url' target='_blank'><ifdef code='ca_objects.url.link_text'>^ca_objects.url.link_text</ifdef><ifnotdef code='ca_objects.url.link_text'>^ca_objects.url.link_url</ifnotdef></a></unit>",
		"Notes" => "^ca_objects.notes%delimiter=,_",
		"Physical Description" => "^ca_objects.physical_description",
		"Material" => "^ca_objects.material",
		"Materials and Techniques" => "^ca_objects.material_techniques",
		"Format" => "^ca_objects.format",
		"AV Format " => "^ca_objects.av_format",
		"Dimensions" => "^ca_objects.dimensions.dimensions_display%delimiter=,_",
		"Duration" => "<ifdef code='ca_objects.duration'>^ca_objects.duration</ifdef><ifnotdef code='ca_objects.duration'>^ca_objects.duration_text</ifnotdef>",
		"Extent" => "<ifdef code='ca_objects.item_extent.extent_value'>^ca_objects.item_extent.extent_value </ifdef>^ca_objects.item_extent.extent_unit<ifdef code='ca_objects.item_extent.extent_value|ca_objects.item_extent.extent_unit'><br/></ifdef>^ca_objects.item_extent.extent_note",
		"Number of Copies" => "^ca_objects.num_copies",
		"Volume Number" => "^ca_objects.volume_number",
		"Issue Number" => "^ca_objects.issue_number",
		"Existence and Location of Originals/Copies " => "^ca_objects.copies_originals",
		"Photograph Format (AAT)" => "^ca_objects.photograph_format%delimiter=,_",
		"Object/Work Type (AAT)" => "^ca_objects.object_work_type%delimiter=,_",
		"Components/Parts" => "^ca_objects.components_parts",
		"Inscriptions and Markings" => "^ca_objects.inscriptions",
		"Library of Congress Subject Headings" => "^ca_objects.lcsh_terms%delimiter=,_",
		"People Depicted" => "^ca_objects.people_depicted",
		"Related People and Organizations (Library of Congress Name Authority File)" => "^ca_objects.lc_names%delimiter=,_",
		"Related People and Organizations" => "<ifcount code='ca_entities' restrictToRelationshipTypes='depicted,subject'><unit relativeTo='ca_entities' restrictToRelationshipTypes='depicted,subject' delimiter='<br/>'>^ca_entities.preferred_labels.displayname (^relationship_typename)</unit></ifcount>",
		"Key Terms" => "^ca_objects.key_terms",
		"Subjects" => "^ca_objects.local_subjects%delimiter=,_",
		"Transcription" => "<ifdef code='ca_objects.transcription.transcription_text'>^ca_objects.transcription.transcription_text</ifdef><ifdef code='ca_objects.transcription.transcription_date'><br/>^ca_objects.transcription.transcription_date</ifdef>",
		"Media Notes" => "^ca_objects.media_notes%delimiter=,_",
		"Conditions Governing Access" => "^ca_objects.accessrestrict",
		"Rights" => "<unit relativeTo='ca_objects.rights' delimiter='<br/><br/>'><ifdef code='ca_objects.rights.rightsText'>^ca_objects.rights.rightsText<br/></ifdef><ifdef code='ca_objects.rights.endRestriction'><b>End of Restriction:</b> ^ca_objects.rights.endRestriction<br/></ifdef><ifdef code='ca_objects.rights.endRestrictionNotes'><b>Restriction Notes:</b> ^ca_objects.rights.endRestrictionNotes<br/></ifdef><ifdef code='ca_objects.rights.rightsHolder'><b>Rights Holder:</b> ^ca_objects.rights.rightsHolder<br/></ifdef><ifdef code='ca_objects.rights.copyrightStatement'><b>Copyright:</b> ^ca_objects.rights.copyrightStatement</ifdef></unit>",
		"Rights Notes" => "^ca_objects.rights_notes",
		"Related Exhibitions" => "<ifcount code='ca_occurrences' restrictToTypes='exhibit' min='1'><unit relativeTo='ca_occurrences' restrictToTypes='exhibit' delimiter='<br/>'>^ca_occurrences.preferred_labels.name</unit></ifcount>",
		"Related Objects" => "<ifcount code='ca_objects.related' min='1'><unit relativeTo='ca_objects' delimiter='<br/>'><l>^ca_objects.preferred_labels.name</l></unit></ifcount>",
	);
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
				
				<?= caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "basic", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
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
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
				<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
				<HR>
				
				{{{<ifcount code='ca_collections' min='1'><div class='unit'><label>Collection</label><unit relativeTo='ca_collections'><unit relativeTo='ca_collections.hierarchy' delimiter=' > '><l>^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates</ifdef></l></unit></unit></div></ifcount>}}}
				
				{{{<ifdef code="ca_objects.idno"><label>Identifier:</label>^ca_objects.idno<br/></ifdef>}}}
<?php
				foreach($va_fields as $vs_label => $vs_template){
					if($vs_tmp = $t_object->getWithTemplate($vs_template, array("checkAccess" => $va_access_values))){
						print "<div class='unit'><label>".$vs_label."</label>".caConvertLineBreaks($vs_tmp)."</div>";
					}
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
