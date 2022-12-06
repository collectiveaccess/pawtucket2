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
	$va_access_values = 	caGetUserAccessValues($this->request);
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
		<div class="row">
			<div class='col-sm-6 col-md-6'>
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
				{{{<ifdef code="ca_objects.accessibility_description"><div class="unit"><label>Accessibility Description</label>^ca_objects.accessibility_description</div></ifdef>}}}
				
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
				<H2>{{{^ca_objects.type_id<ifdef code="ca_objects.idno">: ^ca_objects.idno</ifdef>}}}</H2>
				<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
				<div class='unit'>
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="1">
					<div><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div>
				</ifcount>}}}	
<?php
				$vs_display_date = $t_object->get("ca_objects.display_date", array("delimiter" => ", "));
				$vs_index_date = $t_object->get("ca_objects.index_date", array("delimiter" => ", "));
				if($vs_display_date){
					print "<div>".$vs_display_date."</div>";
				}elseif($vs_index_date){
					print "<div>".$vs_index_date."</div>";
				}
?>
				{{{<ifdef code="ca_objects.PhysicalMediumDisplay"><div>^ca_objects.PhysicalMediumDisplay</div></ifdef>}}}
				</div>
				<HR>				
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><span class="trimText">^ca_objects.description</span></div>
				</ifdef>}}}
				
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="contributor" min="1">
					<div class="unit"><label>Contributor<ifcount code="ca_entities" restrictToRelationshipTypes="contributor" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="contributor" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div>
				</ifcount>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="printer" min="1">
					<div class="unit"><label>Printer<ifcount code="ca_entities" restrictToRelationshipTypes="printer" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="printer" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div>
				</ifcount>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="publisher" min="1">
					<div class="unit"><label>Publisher<ifcount code="ca_entities" restrictToRelationshipTypes="publisher" min="2">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="publisher" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div>
				</ifcount>}}}
				{{{<ifdef code="ca_objects.publication"><div class="unit"><label>Publication</label><unit relativeTo="ca_objects.publication" delimiter="<br/>">^ca_objects.publication</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.call_number"><div class="unit"><label>Call Number</label>^ca_objects.call_number</div></ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions.display_dimensions"><div class="unit"><label>Dimensions</label><unit relativeTo="ca_objects.dimensions" delimiter="<br/>">^ca_objects.dimensions.display_dimensions</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.editionInformation"><div class="unit"><label>Edition</label>^ca_objects.editionInformation</div></ifdef>}}}
				{{{<ifdef code="ca_objects.series.series_title|ca_objects.series.series_id"><div class="unit"><label>Series</label>^ca_objects.series.series_title<ifdef code="ca_objects.series.series_id,ca_objects.series.series_title">, </ifdef>^ca_objects.series.series_id</div></ifdef>}}}
				{{{<ifdef code="ca_objects.rights.rightsStatement"><div class="unit"><label>Rights Statement</label>^ca_objects.rights.rightsStatement</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.creditLine"><div class="unit"><label>Credit</label>^ca_objects.creditLine</div></ifdef>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="photographer,videographer,audio_recordist,producer,distributor" min="1">
					<div class="unit"><label>Documentation Credit<ifcount code="ca_entities" restrictToRelationshipTypes="photographer,videographer,audio_recordist,producer,distributor" min="2">s</ifcount></label><unit relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="photographer,videographer,audio_recordist,producer,distributor" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div>
				</ifcount>}}}
				{{{<ifdef code="ca_objects.citation"><div class="unit"><label>Citation</label>^ca_objects.citation</div></ifdef>}}}
				{{{<ifdef code="ca_objects.external_link.url_entry"><div class="unit"><label>External Link</label><unit relativeTo="ca_objects.external_link" delimiter="<br/>"><a href="^ca_objects.external_link.url_entry" target="_blank"><ifdef code="ca_objects.external_link.url_source">^ca_objects.external_link.url_source</ifdef><ifnotdef code="ca_objects.external_link.url_source">^ca_objects.external_link.url_entry</ifnotdef></a></unit></div></ifdef>}}}
<?php
				$va_entities = $t_object->get("ca_entities", array("excludeRelationshipTypes" => array("creator", "contributor", "printer", "publisher", "photographer", "videographer", "audio_recordist", "producer", "distributor"), "returnWithStructure" => 1, "checkAccess" => $va_access_values));
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
				{{{<ifcount code="ca_collections" min="1"><div class="unit"><label>Collection</label>
					<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels</l></unit></div></ifcount>}}}
				
				{{{<ifdef code="ca_objects.exhibition_history"><div class="unit"><label>Exhibition History</label><unit relativeTo="ca_objects.exhibition_history" delimiter="<br/><br/>">^ca_objects.exhibition_history</unit></div></ifdef>}}}
				{{{<ifcount code="ca_occurrences" restrictToTypes="exhibitions" min="1"><div class="unit"><label>Related Exhibitions</label>
					<unit relativeTo="ca_occurrences" restrictToTypes="exhibitions" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.bibliography"><div class="unit"><label>Bibliography</label><unit relativeTo="ca_objects.bibliography" delimiter="<br/><br/>">^ca_objects.bibliography</unit></div></ifdef>}}}
				
				{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="1"><div class="unit"><label>Related Events</label>
					<unit relativeTo="ca_occurrences" restrictToTypes="event" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit></div></ifcount>}}}

				{{{<ifcount code="ca_objects.related" min="1" restrictToTypes="artwork, oral_history, archival_object, publication"><div class="unit"><label>Related Objects</label>
					<unit relativeTo="ca_objects.related"  delimiter=" "><div style="clear:left;"><l><ifdef code="ca_object_representations.media.icon"><div class="relatedIcon">^ca_object_representations.media.icon</div></ifdef>^ca_objects.preferred_labels<ifcount code='ca_entities' restrictToRelationshipTypes='creator,author' min='1'><unit relativeTo='ca_entities' restrictToRelationshipTypes='creator,author' delimiter=', '>, ^ca_entities.preferred_labels</unit></ifcount><ifdef code='ca_objects.index_date'>, ^ca_objects.index_date</ifdef></l> (^relationship_typename)</div><unit></ifcount>}}}

						
			</div><!-- end col -->
		</div><!-- end row -->
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
