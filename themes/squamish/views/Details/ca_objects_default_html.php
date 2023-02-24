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
					print $vs_rep_viewer;
				}else{
					# placeholder
					$vs_placeholder_text = $this->getVar("detail_media_note");
					print "<div class='detailPlaceholderContainer'>".$vs_placeholder_text."</div>";					
				}
?>
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
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
				{{{<ifcount code="ca_collections" min="1">
					<div class="unit"><label>Part of</label>
						<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>
					</div></ifcount>}}}
				{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code="ca_objects.ISBN"><div class="unit"><label>ISBN</label>^ca_objects.ISBN</div></ifdef>}}}
				{{{<ifdef code="ca_objects.ISSN"><div class="unit"><label>ISSN</label>^ca_objects.ISSN</div></ifdef>}}}
				{{{<ifdef code="ca_objects.display_date"><div class="unit"><label>Date</label>^ca_objects.display_date%delimiter=,_</div></ifdef>}}}
				{{{<ifnotdef code="ca_objects.display_date"><ifdef code="ca_objects.date"><div class="unit"><label>Date</label>^ca_objects.date%delimiter=,_</div></ifdef></ifnotdef>}}}

				{{{<ifdef code="ca_objects.publisher"><div class="unit"><label>Publisher</label>^ca_objects.publisher</div></ifdef>}}}
				{{{<ifdef code="ca_objects.pub_place"><div class="unit"><label>Place of Publicaton</label>^ca_objects.pub_place</div></ifdef>}}}
				{{{<ifdef code="ca_objects.edition"><div class="unit"><label>Edition Statement</label>^ca_objects.edition</div></ifdef>}}}
				{{{<ifdef code="ca_objects.series_title"><div class="unit"><label>Series Title</label>^ca_objects.series_title</div></ifdef>}}}
				{{{<ifdef code="ca_objects.volume_designation"><div class="unit"><label>Volume and Sequential Designation</label>^ca_objects.volume_designation</div></ifdef>}}}
				{{{<ifdef code="ca_objects.creation_production"><div class="unit"><label>Creation/Production Credits Note</label>^ca_objects.creation_production</div></ifdef>}}}
			
				{{{<ifdef code="ca_objects.phys_desc">
					<div class='unit'><label>Physical Description</label>
						<span class="trimText">^ca_objects.phys_desc</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.additional_form"><div class="unit"><label>Additional Physical Form Note</label>^ca_objects.additional_form</div></ifdef>}}}
					
				{{{<ifdef code="ca_objects.inscription"><div class="unit"><label>Inscription</label>^ca_objects.inscription%delimiter=,_</div></ifdef>}}}
				
				
<?php
				$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
				if(is_array($va_entities) && sizeof($va_entities)){
					$va_entities_by_type = array();
					foreach($va_entities as $va_entity_info){
						$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
					}
					foreach($va_entities_by_type as $vs_type => $va_entity_links){
						print "<div class='unit'><label>".$vs_type."</label>".join("<br/>", $va_entity_links)."</div>";
					}
				}
?>
				
				
				{{{<ifdef code="ca_objects.GMD"><div class="unit"><label>General Material Designation</label>^ca_objects.GMD%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.materials"><div class="unit"><label>Materials</label>^ca_objects.materials%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.record_type"><div class="unit"><label>Record Type</label>^ca_objects.record_type%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.object_type"><div class="unit"><label>Object Type</label>^ca_objects.object_type%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.oral_history_type"><div class="unit"><label>Oral History Type</label>^ca_objects.oral_history_type%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.theme"><div class="unit"><label>Themes</label>^ca_objects.theme%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.subjects"><div class="unit"><label>Subjects</label>^ca_objects.subjects%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.subjects_academic"><div class="unit"><label>Subjects</label>^ca_objects.subjects_academic%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.keywords"><div class="unit"><label>Keywords</label>^ca_objects.keywords%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.genre"><div class="unit"><label>Genre</label>^ca_objects.genre%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.language"><div class="unit"><label>Language</label>^ca_objects.language%delimiter=,_</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.publication_container.publication"><div class="unit"><label>Publication Details</label><unit relativeTo="ca_objects.publication_container" delimiter="<br/><br/>"><ifdef code="ca_objects.publication_container.publication">^ca_objects.publication_container.publication<br/></ifdef><ifdef code="ca_objects.publication_container.volume">^ca_objects.publication_container.volume, </ifdef><ifdef code="ca_objects.publication_container.issue">^ca_objects.publication_container.issue, </ifdef><ifdef code="ca_objects.publication_container.page_numbers">^ca_objects.publication_container.page_numbers</ifdef></div></ifdef>}}}
				{{{<ifdef code="ca_objects.rights_summary"><div class="unit"><label>Rights Summary</label>^ca_objects.rights_summary%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.doi"><div class="unit"><label>DOI</label>^ca_objects.doi</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.website"><div class="unit"><label>Website</label><unit relativeTo="ca_objects.website"><a href="^ca_objects.website">^ca_objects.website</a></unit></div></ifdef>}}}
						
				{{{<ifcount code="ca_entities" min="1"><div class="unit">
					<ifcount code="ca_entities" min="1" max="1"><label>Related person</label></ifcount>
					<ifcount code="ca_entities" min="2"><label>Related people</label></ifcount>
					<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
				</div></ifcount>}}}
				
				{{{<ifcount code="ca_occurrences" min="1"><div class="unit">
					<ifcount code="ca_occurrences" min="1" max="1"><label>Related occurrence</label></ifcount>
					<ifcount code="ca_occurrences" min="2"><label>Related occurrences</label></ifcount>
					<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</unit>
				</div></ifcount>}}}
				
				{{{<ifcount code="ca_places" min="1"><div class="unit">
					<ifcount code="ca_places" min="1" max="1"><label>Related place</label></ifcount>
					<ifcount code="ca_places" min="2"><label>Related places</label></ifcount>
					<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>
				</div></ifcount>}}}
				
				{{{<ifcount code="ca_list_items" min="1"><div class="unit">
					<ifcount code="ca_list_items" min="1" max="1"><label>Related Term</label></ifcount>
					<ifcount code="ca_list_items" min="2"><label>Related Terms</label></ifcount>
					<unit relativeTo="ca_list_items" delimiter="<br/>"><l>^ca_list_items.preferred_labels.name_plural</l> (^relationship_typename)</unit>
				</div></ifcount>}}}
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
