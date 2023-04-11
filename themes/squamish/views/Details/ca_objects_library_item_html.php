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
<?php
				if($vs_rep_viewer = trim($this->getVar("representationViewer"))){
					print "<div>".$vs_rep_viewer."</div>";
				}else{
					# placeholder
					$vs_placeholder_text = $this->getVar("detail_media_note");
					print "<div class='detailPlaceholderContainer'>".$vs_placeholder_text."</div>";					
				}
?>
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				{{{<ifdef code="ca_objects.transcription_container.transcription_upload"><div class="unit"><label>Transcript</label><unit relativeTo="ca_objects.transcription_container" delimiter="<br/>"><a href="^ca_objects.transcription_container.transcription_upload.original.url"><span class='glyphicon glyphicon glyphicon-download' aria-hidden='true'></span> <ifdef code="ca_objects.transcription_container.transcription_caption">^ca_objects.transcription_container.transcription_caption</ifdef><ifnotdef code="ca_objects.transcription_container.transcription_caption">Download</ifnotdef></a></unit></div></ifdef>}}}

<?php
				print "<div id='detailTools'><div class='detailTool'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Ask / Comment", "", "", "Contact", "Form", array("table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
				
				if ($vn_pdf_enabled) {
					print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
				}
				print "</div>";
?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
				<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
				<HR>
				
				{{{<ifdef code="ca_objects.description">
					<div class='unit'>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="author"><div class="unit"><label>Author<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="author">s</ifcount></label>
						<unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>
					</div></ifcount>}}}
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="contributor,editor,elder,illustrator,knowledge_keeper,translator"><div class="unit"><label>Additional Contributors and Acknowledgements</label>
						<unit relativeTo="ca_entities" restrictToRelationshipTypes="contributor,editor,elder,illustrator,knowledge_keeper,translator" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit>
					</div></ifcount>}}}
				
				
				{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code="ca_objects.publisher"><div class="unit"><label>Publisher</label>^ca_objects.publisher</div></ifdef>}}}
				{{{<ifdef code="ca_objects.date"><div class="unit"><label>Date</label>^ca_objects.date%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.ISBN"><div class="unit"><label>ISBN</label>^ca_objects.ISBN</div></ifdef>}}}
				{{{<ifdef code="ca_objects.ISSN"><div class="unit"><label>ISSN</label>^ca_objects.ISSN</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.edition"><div class="unit"><label>Edition Statement</label>^ca_objects.edition</div></ifdef>}}}
				{{{<ifdef code="ca_objects.series_title"><div class="unit"><label>Series Title</label>^ca_objects.series_title</div></ifdef>}}}
				{{{<ifdef code="ca_objects.volume_designation"><div class="unit"><label>Volume and Sequential Designation</label>^ca_objects.volume_designation</div></ifdef>}}}
				{{{<ifdef code="ca_objects.creation_production"><div class="unit"><label>Creation/Production Credits Note</label>^ca_objects.creation_production</div></ifdef>}}}
			
				{{{<ifdef code="ca_objects.additional_form"><div class="unit"><label>Additional Physical Form Note</label>^ca_objects.additional_form</div></ifdef>}}}
				{{{<ifdef code="ca_objects.formatted_contents">
					<div class='unit'><label>Table of Contents</label>
						<span class="trimText">^ca_objects.formatted_contents</span>
					</div>
				</ifdef>}}}
				
					
				{{{<ifdef code="ca_objects.GMD"><div class="unit"><label>General Material Designation</label>^ca_objects.GMD%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.theme"><div class="unit"><label>Themes</label>^ca_objects.theme%delimiter=,_</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.language"><div class="unit"><label>Language</label>^ca_objects.language%delimiter=,_</div></ifdef>}}}
				
				{{{<ifcount code="ca_storage_locations" min="1"><div class="unit"><label>Location / Box-Folder</label>
						<unit relativeTo="ca_storage_locations" delimiter="<br/>">^ca_storage_locations.preferred_labels.name</unit>
					</div></ifcount>}}}
				{{{<ifdef code="ca_objects.bd_call"><div class="unit"><label>Call Number</label><ifdef code="ca_objects.bd_call.classification_code">^ca_objects.bd_call.classification_code </ifdef>^ca_objects.bd_call.bd_call_number</div></ifdef>}}}
				
				<div class="unit">{{{map}}}</div>
						
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
