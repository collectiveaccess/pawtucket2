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
		<div class="container">
			<div class="row">
				<div class='col-md-10'>
					<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
<?php
					$vs_object_date = $t_object->get("ca_objects.date_container.date");
					$vs_artist = $t_object->getWithTemplate("<ifcount code='ca_entities' min='1' restrictToRelationshipTypes='Artist'><unit relativeTo='ca_entities' delimiter=', ' restrictToRelationshipTypes='Artist'><l>^ca_entities.preferred_labels</l></unit></ifcount>", array("checkAccess" => $va_access_values));
					if($vs_artist || $vs_object_date){
						print "<H2>".$vs_artist.(($vs_object_date && $vs_artist) ? "<br/>" : "").$vs_object_date."</H2>";
					}
?>
				</div>
				<div class='col-md-2'>
<?php
					print "<div id='detailTools'><div class='detailTool'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "", "", "Contact", "Form", array("table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div></div>";
?>
				</div><!-- end col -->
			</div>
			<div class="row">
				<div class='col-md-12'>
					<HR/>
				</div>
			</div>
			<div class="row">
<?php
$vb_2_col = false;
if($t_object->get("ca_objects.creative_access_desc") || trim($this->getVar("representationViewer") || $t_object->get("ca_objects.transcript_upload_container.transcript_upload.url") || $t_object->get("ca_objects.visual_description_container.visual_description_upload"))){
	$vb_2_col = true;
}
if($vb_2_col){
?>
				<div class='col-sm-6 col-md-6 col-lg-8'>
					{{{representationViewer}}}
				
				
					<div id="detailAnnotations"></div>
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
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

					{{{<ifdef code="ca_objects.transcript_upload_container.transcript_upload.url"><div class="unit"><unit relativeTo="ca_objects.transcript_upload_container.transcript_upload" delimiter="<br/>"><ifdef code="ca_objects.transcript_upload_container.transcript_upload.url"><a href="^ca_objects.transcript_upload_container.transcript_upload.url%version=original" target="_blank"><span class="glyphicon glyphicon-download-alt" role="button" aria-label="Download"></span></a> <a href="^ca_objects.transcript_upload_container.transcript_upload.url%version=original" target="_blank"><ifdef code="ca_objects.transcript_upload_container.transcript_caption">^ca_objects.transcript_upload_container.transcript_caption</ifdef><ifnotdef code="ca_objects.transcript_upload_container.transcript_caption">Download Transcript</ifnotdef></a></ifdef></unit></div></ifdef>}}}
					{{{<ifdef code="ca_objects.visual_description_container.visual_description_upload.url"><div class="unit"><unit relativeTo="ca_objects.visual_description_container.visual_description_upload" delimiter="<br/>"><ifdef code="ca_objects.visual_description_container.visual_description_upload.url"><a href="^ca_objects.visual_description_container.visual_description_upload.url%version=original" target="_blank"><span class="glyphicon glyphicon-download-alt" role="button" aria-label="Download"></span></a> <a href="^ca_objects.visual_description_container.visual_description_upload.url%version=original" target="_blank"><ifdef code="ca_objects.visual_description_container.visual_description_caption">^ca_objects.visual_description_container.visual_description_caption</ifdef><ifnotdef code="ca_objects.visual_description_container.visual_description_caption">Download Visual Description</ifnotdef></a></ifdef></unit></div></ifdef>}}}
					{{{<ifdef code="ca_objects.creative_access_desc"><div class='unit'><H3>Creative Access Description</H3><span class="trimText">^ca_objects.creative_access_desc</span></div></ifdef>}}}
					
				</div><!-- end col -->
			
				<div class='col-sm-6 col-md-6 col-lg-4'>
<?php
}else{
?>
				<div class='col-sm-12'>
<?php
}
?>				
					{{{<ifdef code="ca_objects.dc_description">
						<div class='unit'>
							<H3>Description</H3><span class="trimText">^ca_objects.dc_description</span>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_objects.idno"><div class="unit"><H3>Identifier</H3>^ca_objects.idno</div></ifdef>}}}
					{{{<ifdef code="ca_objects.custom_extent"><div class="unit"><H3>Extent</H3>^ca_objects.custom_extent</div></ifdef>}}}
					{{{<ifdef code="ca_objects.tape_number"><div class="unit"><H3>Tape Number</H3>^ca_objects.tape_number</div></ifdef>}}}
					
					{{{<ifdef code="ca_objects.language"><div class='unit'><H3>Language</H3><unnit relativeTo="ca_objects.language" delimiter="<br/>">^ca_objects.language</unit></div></ifdef>}}}
					
<?php
				$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
				if(is_array($va_entities) && sizeof($va_entities)){
					$va_entities_by_type = array();
					foreach($va_entities as $va_entity_info){
						$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
					}
					foreach($va_entities_by_type as $vs_type => $va_entity_links){
						print "<div class='unit'><H3>".$vs_type."</H3>".join(", ", $va_entity_links)."</div>";
					}
				}
?>					
					{{{<ifcount code="ca_objects.related" min="1"><div class="unit"><H3>Related Object<ifcount code="ca_objects.related" min="2">s</ifcount></H3><unit relativeTo="ca_objects.related" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l> (^relationship_typename)</unit></div></ifcount>}}}
					{{{<ifcount code="ca_collections" min="1"><div class="unit"><H3>Collection</H3><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="program"><div class="unit"><H3>Related program<ifcount code="ca_occurrences" min="2" restrictToTypes="program">s</ifcount></H3><span class="trimTextShort"><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="program"><l>^ca_occurrences.preferred_labels.name</l> (^relationship_typename)</unit></span></div></ifcount>}}}
					
					
					{{{<ifdef code="ca_objects.object_history.bib_ref"><div class='unit'><H3>Bibliography</H3>^ca_objects.object_history.bib_ref</div></ifdef>}}}
					{{{<ifdef code="ca_objects.object_history.exhibition_hist"><div class='unit'><H3>Exhibition History</H3>^ca_objects.object_history.exhibition_hist</div></ifdef>}}}

					{{{<ifdef code="ca_objects.rightsSummary_asset"><div class="unit"><i>^ca_objects.rightsSummary_asset</i></div></ifdef>}}}
					{{{<ifdef code="ca_objects.content_notice"><div class="unit"><H3>Contains</H3>^ca_objects.content_notice</div></ifdef>}}}
					{{{<ifcount code="ca_places" min="1"><div class="unit"><H3>Related place</H3><unit relativeTo="ca_places" delimiter=", ">^ca_places.preferred_labels.name</unit></div></ifcount>}}}
					
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
		  maxHeight: 300,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 112,
		  moreLink: '<a href="#">More &#8964;</a>'
		});
	});
</script>
