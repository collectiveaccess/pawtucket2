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

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
				<H2>{{{<unit>^ca_objects.type_id<ifdef code="ca_objects.idno">: ^ca_objects.idno</ifdef></unit>}}}</H2>
				<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
<?php
				$vs_art_archival_creator_date = $t_object->getWithTemplate("<ifcount code='ca_entities' restrictToRelationshipTypes='creator' min='1'><unit relativeTo='ca_entities' restrictToRelationshipTypes='creator' delimiter=', '>^ca_entities.preferred_labels</unit></ifcount><ifdef code='ca_objects.artwork_date'><unit relativeTo='ca_objects.artwork_date'><if rule='^ca_objects.artwork_date.artwork_date_types =~ /Creation/'><ifcount code='ca_entities' restrictToRelationshipTypes='creator' min='1'>, </ifcount>^ca_objects.artwork_date.artwork_date_value</if></unit></ifdef><ifdef code='ca_objects.archival_object_date'><unit relativeTo='ca_objects.archival_object_date'><if rule='^ca_objects.archival_object_date.archival_object_date_types =~ /Creation/'><ifcount code='ca_entities' restrictToRelationshipTypes='creator' min='1'>, </ifcount>^ca_objects.archival_object_date.archival_object_date_value</if></unit></ifdef>");
				$vs_pub_author_date = $t_object->getWithTemplate("<ifcount code='ca_entities' restrictToRelationshipTypes='author' min='1'><unit relativeTo='ca_entities' restrictToRelationshipTypes='author' delimiter=', '>^ca_entities.preferred_labels</unit></ifcount><ifdef code='ca_objects.publication_date'><unit relativeTo='ca_objects.publication_date'><if rule='^ca_objects.publication_date.publication_date_types =~ /Publication/'><ifcount code='ca_entities' restrictToRelationshipTypes='author' min='1'>, </ifcount>^ca_objects.publication_date.publication_date_value</if></unit></ifdef>");
				$vs_oral_history_date = $t_object->getWithTemplate("<ifdef code='ca_objects.interview.oral_history_dates_value'><unit relativeTo='ca_objects.interview'><if rule='^ca_objects.interview.oral_history_dates_types =~ /Interview/'>^ca_objects.interview.oral_history_dates_value</if></unit></ifdef>");
				
				if($vs_pub_author_date || $vs_art_archival_creator_date || $vs_oral_history_date){
					print "<div class='unit'>".$vs_art_archival_creator_date.$vs_pub_author_date.$vs_oral_history_date."</div>";
				}

?>				
				<HR>
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><span class="trimText">^ca_objects.description</span></div>
				</ifdef>}}}
				
				<!--publication-->
				{{{<ifdef code="ca_objects.isbn_number"><div class="unit"><label>ISBN</label>^ca_objects.isbn_number</div></ifdef>}}}
				{{{<ifdef code="ca_objects.call_number"><div class="unit"><label>Call Number</label>^ca_objects.call_number</div></ifdef>}}}
				{{{<ifdef code="ca_objects.oclc"><div class="unit"><label>OCLC</label>^ca_objects.oclc</div></ifdef>}}}
				{{{<ifdef code="ca_objects.publications_lc.publications_lccn"><div class="unit"><label>LCCN</label>^ca_objects.publications_lc.publications_lccn ^ca_objects.publications_lc.publications_lc_classification</div></ifdef>}}}
				{{{<ifdef code="ca_objects.dewey_decimal.dewey_decimal_number"><div class="unit"><label>Dewey Decimal</label>^ca_objects.dewey_decimal.dewey_decimal_number ^ca_objects.dewey_decimal.dewey_decimal_label</div></ifdef>}}}
				
				<!--artwork & archival-->
				{{{<ifdef code="ca_objects.PhysicalMediumDisplay"><div class="unit"><label>Medium</label>^ca_objects.PhysicalMediumDisplay</div></ifdef>}}}
				{{{<ifdef code="ca_objects.citation"><div class="unit"><label>Citation</label>^ca_objects.citation</div></ifdef>}}}
				{{{<ifdef code="ca_objects.inscription"><div class="unit"><label>Inscription</label>^ca_objects.inscription</div></ifdef>}}}
				{{{<ifdef code="ca_objects.courtesy_line"><div class="unit"><label>Courtesy</label>^ca_objects.courtesy_line</div></ifdef>}}}
				
				<!-- oral history -->
				{{{<ifdef code="ca_objects.interview.interview_location"><div class="unit"><label>Location</label>^ca_objects.interview.interview_location</div></ifdef>}}}
				{{{<ifdef code="ca_objects.duration"><div class="unit"><label>Duration</label>^ca_objects.duration</div></ifdef>}}}
				
<?php
				$va_entities = $t_object->get("ca_entities", array("excludeRelationshipTypes" => array("creator", "author"), "returnWithStructure" => 1, "checkAccess" => $va_access_values));
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
				{{{<ifcount code="ca_occurrences" restrictToTypes="exhibitions" min="1"><div class="unit"><label>Related Exhibitions</label>
					<unit relativeTo="ca_occurrences" restrictToTypes="exhibitions" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit></div></ifcount>}}}
				
				{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="1"><div class="unit"><label>Related Events</label>
					<unit relativeTo="ca_occurrences" restrictToTypes="event" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit></div></ifcount>}}}

				{{{<ifcount code="ca_objects.related" min="1"><div class="unit"><label>Related Collection Items</label>
					<unit relativeTo="ca_objects.related"  delimiter=" ">
						<div style="clear:left;"><l><ifdef code="ca_object_representations.media.icon"><div class="relatedIcon">^ca_object_representations.media.icon</div></ifdef>^ca_objects.preferred_labels<ifcount code='ca_entities' restrictToRelationshipTypes='creator' min='1'><unit relativeTo='ca_entities' restrictToRelationshipTypes='creator' delimiter=', '>, ^ca_entities.preferred_labels</unit></ifcount><ifdef code='ca_objects.artwork_date'><unit relativeTo='ca_objects.artwork_date'><if rule='^ca_objects.artwork_date.artwork_date_types =~ /Creation/'>, ^ca_objects.artwork_date.artwork_date_value</if></unit></ifdef><ifdef code='ca_objects.archival_object_date'><unit relativeTo='ca_objects.archival_object_date'><if rule='^ca_objects.archival_object_date.archival_object_date_types =~ /Creation/'>, ^ca_objects.archival_object_date.archival_object_date_value</if></unit></ifdef><ifcount code='ca_entities' restrictToRelationshipTypes='author' min='1'><unit relativeTo='ca_entities' restrictToRelationshipTypes='author' delimiter=', '>, ^ca_entities.preferred_labels</unit></ifcount><ifdef code='ca_objects.publication_date'><unit relativeTo='ca_objects.publication_date'><if rule='^ca_objects.publication_date.publication_date_types =~ /Publication/'>, ^ca_objects.publication_date.publication_date_value</if></unit></ifdef><ifdef code='ca_objects.interview.oral_history_dates_value'><unit relativeTo='ca_objects.interview'><if rule='^ca_objects.interview.oral_history_dates_types =~ /Interview/'>, ^ca_objects.interview.oral_history_dates_value</if></unit></ifdef>
							</l></div></unit></div></ifcount>}}}

						
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
