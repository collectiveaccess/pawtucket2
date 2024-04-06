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
 
	$t_item = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_item->get('ca_objects.object_id');
	$va_access_values = caGetUserAccessValues($this->request);
	
	$va_fields = array(
		"Classification" => "^ca_collections.col_classification%delimiter=,_",
		#"Unit ID" => "^ca_collections.unit_id%delimiter=,_",
		"Alternate Title" => "^ca_collections.nonpreferred_labels%delimiter=,_",
		"Container ID" => "^ca_collections.container_id",
		"AV Subtype" => "^ca_collections.av_subtype",
		"Dates" => "<ifdef code='ca_collections.display_date'>^ca_collections.display_date%delimiter=,_</ifdef><ifnotdef code='ca_collections.display_date'><ifdef code='ca_collections.inclusive_dates'>^ca_collections.inclusive_dates%delimiter=,_</ifdef></ifnotdef>",
		"Additional Date Information" => "^ca_collections.date_info",
		"Description" => "^ca_collections.description",
		"Language" => "^ca_collections.language%delimiter=,_",
		"Related Creators" => "<ifcount min='1' code='ca_entities' excludeRelationshipTypes='donor,depicted,original_owner,subject'><unit relativeTo='ca_entities' excludeRelationshipTypes='donor,depicted,original_owner,subject' delimiter='<br/>'><if rule='^ca_entities.added_on_import =~ /Yes/'>^ca_entities.preferred_labels.displayname (^relationship_typename)</if><if rule='^ca_entities.added_on_import !~ /Yes/'><l>^ca_entities.preferred_labels.displayname (^relationship_typename)</l></if></unit></ifcount>",
		"Event Type" => "^ca_collections.event_type%delimiter=,_",
		"Related Publications" => "^ca_collections.related_publications",
		"Related Materials" => "<ifdef code='ca_collections.related_materials'><span class='trimText'>^ca_collections.related_materials</span></ifdef>",
		"Links to Related Materials" => "<ifcount code='ca_collections.related' min='1'><unit relativeTo='ca_collections.related' delimiter='<br/>'><a href='https://archive.carleton.edu/Detail/collections/^ca_collections.collection_id'>^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.display_date'>, ^ca_collections.display_date%delimiter=,_</ifdef><ifnotdef code='ca_collections.display_date'><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates%delimiter=,_</a></ifdef></ifnotdef></unit></ifcount>",	"Transcript Availability" => "^ca_collections.transcript_availability",
		"Transcript Notes" => "^ca_collections.transcript_notes",
		"URL" => "<unit relativeTo='ca_collections.url' delimiter='<br/>'><a href='^ca_collections.url.link_url' target='_blank'><ifdef code='ca_collections.url.link_text'>^ca_collections.url.link_text</ifdef><ifnotdef code='ca_collections.url.link_text'>^ca_collections.url.link_url</ifnotdef></a></unit>",
		"Notes" => "^ca_collections.notes%delimiter=,_",
		"Physical Description" => "^ca_collections.physical_description",
		"Material" => "^ca_collections.material",
		"Materials and Techniques" => "^ca_collections.material_techniques",
		"Format" => "^ca_collections.format",
		"AV Format " => "^ca_collections.av_format",
		"Dimensions" => "^ca_collections.dimensions.dimensions_display%delimiter=,_",
		"Duration" => "<ifdef code='ca_collections.duration'>^ca_collections.duration</ifdef><ifnotdef code='ca_collections.duration'>^ca_collections.duration_text</ifnotdef>",
		"Extent" => "<ifdef code='ca_collections.item_extent.extent_value'>^ca_collections.item_extent.extent_value </ifdef>^ca_collections.item_extent.extent_unit<ifdef code='ca_collections.item_extent.extent_value|ca_collections.item_extent.extent_unit'><br/></ifdef>^ca_collections.item_extent.extent_note",
		"Number of Copies" => "^ca_collections.num_copies",
		"Volume Number" => "^ca_collections.volume_number",
		"Issue Number" => "^ca_collections.issue_number",
		"Existence and Location of Originals/Copies " => "^ca_collections.copies_originals",
		"Photograph Format (AAT)" => "^ca_collections.photograph_format%delimiter=,_",
		"Object/Work Type (AAT)" => "^ca_collections.object_work_type%delimiter=,_",
		"Components/Parts" => "^ca_collections.components_parts",
		"Inscriptions and Markings" => "^ca_collections.inscriptions",
		"Library of Congress Subject Headings" => "^ca_collections.lcsh_terms%delimiter=,_",
		"People Depicted" => "^ca_collections.people_depicted",
		"Related People and Organizations (Library of Congress Name Authority File)" => "^ca_collections.lc_names%delimiter=,_",
		"Related People and Organizations" => "<ifcount code='ca_entities' min='1' restrictToRelationshipTypes='depicted,subject'><unit relativeTo='ca_entities' restrictToRelationshipTypes='depicted,subject' delimiter='<br/>'><if rule='^ca_entities.added_on_import =~ /Yes/'>^ca_entities.preferred_labels.displayname (^relationship_typename)</if><if rule='^ca_entities.added_on_import !~ /Yes/'><l>^ca_entities.preferred_labels.displayname (^relationship_typename)</l></if></unit></ifcount>",
		"Key Terms" => "^ca_collections.key_terms",
		"Subjects" => "^ca_collections.local_subjects%delimiter=,_",
		"Transcription" => "<ifdef code='ca_collections.transcription.transcription_text'>^ca_collections.transcription.transcription_text</ifdef><ifdef code='ca_collections.transcription.transcription_date'><br/>^ca_collections.transcription.transcription_date</ifdef>",
		"Media Notes" => "^ca_collections.media_notes%delimiter=,_",
		"Conditions Governing Access" => "^ca_collections.accessrestrict",
		"Rights" => "<unit relativeTo='ca_collections.rights' delimiter='<br/><br/>'><ifdef code='ca_collections.rights.rightsText'>^ca_collections.rights.rightsText<br/></ifdef><ifdef code='ca_collections.rights.endRestriction'><b>End of Restriction:</b> ^ca_collections.rights.endRestriction<br/></ifdef><ifdef code='ca_collections.rights.endRestrictionNotes'><b>Restriction Notes:</b> ^ca_collections.rights.endRestrictionNotes<br/></ifdef><ifdef code='ca_collections.rights.rightsHolder'><b>Rights Holder:</b> ^ca_collections.rights.rightsHolder<br/></ifdef><ifdef code='ca_collections.rights.copyrightStatement'><b>Copyright:</b> ^ca_collections.rights.copyrightStatement</ifdef></unit>",
		"Rights Notes" => "^ca_collections.rights_notes",
		"Related Exhibitions" => "<ifcount code='ca_occurrences' restrictToTypes='exhibit' min='1'><unit relativeTo='ca_occurrences' restrictToTypes='exhibit' delimiter='<br/>'>^ca_occurrences.preferred_labels.name</unit></ifcount>",
	);
	if($this->request->isLoggedIn()){
		$va_fields["Unit ID"] = "^ca_collections.unit_id%delimiter=,_";
		$va_fields["Serial ID"] = "^ca_collections.idno";
		$va_fields["Internal Notes"] = "^ca_collections.internal_notes";
		$va_fields["Legacy Metadata"] = "^ca_collections.legacy_metadata.legacy_metadata_value";
		$va_fields["Storage Location"] = "<ifcount code='ca_storage_locations' min='1'><unit relativeTo='ca_collections_x_storage_locations' delimiter='<br/><br/>'>^ca_storage_locations.hierarchy.preferred_labels.name%delimiter=_➜_<ifdef code='ca_collections_x_storage_locations.effective_date'><br>Location Date: ^ca_collections_x_storage_locations.effective_date</ifdef><ifdef code='ca_collections_x_storage_locations.staff'><br>Staff: ^ca_collections_x_storage_locations.staff</ifdef><ifdef code='ca_collections_x_storage_locations.description'><br>Content: ^ca_collections_x_storage_locations.description</ifdef><ifdef code='ca_collections_x_storage_locations.item_extent.extent_value'><br>Extent: ^ca_collections_x_storage_locations.item_extent.extent_value ^ca_collections_x_storage_locations.item_extent.extent_unit<ifdef code='ca_collections_x_storage_locations.item_extent.extent_note'><br/>^ca_collections_x_storage_locations.item_extent.extent_note</ifdef></ifdef></unit></ifcount>";
		$edit_link = "https://archive.carleton.edu/admin/editor/collections/CollectionEditor/Edit/collection_id/" . "^ca_collections.collection_id";
		$va_fields["Edit record"] = "<a href='" . $edit_link . "'target=\"_blank\">Click here to edit this record</a>";
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
				<div class='col-md-12'>
					<H1>{{{<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>^ca_collections.preferred_labels</if>}}}</H1>
					<H2>{{{^ca_collections.type_id ^ca_collections.id_number}}}</H2>
					{{{<ifdef code="ca_collections.parent_id"><div class="collectionHierarchyPath"><b>Part of:</b> <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.display_date'>, ^ca_collections.display_date%delimiter=,_</ifdef><ifnotdef code='ca_collections.display_date'><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates%delimiter=,_</ifdef></ifnotdef></l></unit></div></ifdef>}}}
					<HR/>
				</div>

			</div>
			<div class="row">
<?php
		$vs_representationViewer = trim($this->getVar("representationViewer"));
		
		if($vs_representationViewer){
?>
			<div class='col-sm-6 col-md-6'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?= caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "basic", "bsColClasses" => "smallpadding col-xs-3 col-sm-3 col-md-2", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6'>
<?php
		}else{
?>
			<div class='col-md-12'>
<?php		
		}
				# Comment and Share Tools
				if ($x && $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_collections",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}
				
				print "<div class='text-right'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default btn-small", "", "Contact", "Form", array("table" => "ca_collections", "id" => $t_item->get("ca_collections.collection_id")))."</div>";

				foreach($va_fields as $vs_label => $vs_template){
					if($vs_tmp = $t_item->getWithTemplate($vs_template, array("checkAccess" => $va_access_values))){
						print "<div class='unit'><label>".$vs_label."</label>".caConvertLineBreaks($vs_tmp)."</div>";
					}
				}
?>
						
			</div><!-- end col -->
		</div>
<?php
	#$vs_parent_collection_type = $t_item->getWithTemplate("^ca_collections.parent.type_id");
?>
		{{{<ifdef code="ca_collections.parent_id"><unit relativeTo="ca_collections.parent"><ifcount code="ca_collections.children" min="2">
			<div class="row">
				<div class="col-sm-12"><H2>Other items in this ^ca_collections.type_id</H2><hr/></div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'items', array('_advanced' => 0, 'search' => 'ca_collections.parent_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount></unit></ifdef>}}}
		
		
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