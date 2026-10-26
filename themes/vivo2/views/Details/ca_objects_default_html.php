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
<div class="container"><div class="row">
	<div class='col-xs-12'>
		<div class="container">

			<div class="row">
<?php
$vb_2_col = false;
if(trim($this->getVar("representationViewer")) || $t_object->get("ca_objects.transcript_upload_container.transcript_upload.url")){
	$vb_2_col = true;
}
if($vb_2_col){
?>
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{representationViewer}}}
				
				
					<div id="detailAnnotations"></div>
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-2 col-xs-3", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
					{{{<ifdef code="ca_objects.transcript_upload_container.transcript_upload.url"><div class="unit"><unit relativeTo="ca_objects.transcript_upload_container.transcript_upload" delimiter="<br/>"><ifdef code="ca_objects.transcript_upload_container.transcript_upload.url"><a href="^ca_objects.transcript_upload_container.transcript_upload.url%version=original"><span class="glyphicon glyphicon-download-alt" role="button" aria-label="Download"></span></a> <a href="^ca_objects.transcript_upload_container.transcript_upload.url%version=original"><ifdef code="ca_objects.transcript_upload_container.transcript_caption">^ca_objects.transcript_upload_container.transcript_caption</ifdef><ifnotdef code="ca_objects.transcript_upload_container.transcript_caption">Download Transcript</ifnotdef></a></ifdef></unit></div></ifdef>}}}
				
	<?php
					print "<div id='detailTools'>";
					print "<div class='detailTool'>".caNavLink($this->request, "Inquire <span class='material-symbols-outlined'>chat</span>", "btn btn-default", "", "Contact", "Form", array("table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
					print "<div class='detailTool'>".caNavLink($this->request, "Feedback <span class='material-symbols-outlined'>add_comment</span>", "btn btn-default", "", "Contact", "Form", array("contactType" => "Feedback", "table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
					if($t_object->get("ca_objects.video_out", array("convertCodesToDisplayText" => true)) == "Yes"){
						print "<div class='detailTool'>".caNavLink($this->request, "Rent or Purchase <span class='material-symbols-outlined'>shopping_bag</span>", "btn btn-default", "", "Contact", "Form", array("contactType" => "RentalPurchase", "table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
					}
					print "</div>";

	?>
	
				
					
				</div><!-- end col -->
			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
}else{
?>
				<div class='col-sm-12'>
<?php
}
?>				
					<div class="bgLightGrayDetail">
					<H1><?php print ($t_object->get("ca_objects.preferred_labels.name") == "[BLANK]") ? "Title not available" : $t_object->get("ca_objects.preferred_labels.name"); ?></H1>
					<div class="typeInfo">{{{^ca_objects.type_id}}}</div>
					{{{<ifdef code="ca_objects.title_note"><div class="unit"><H2>Title note</H2><unit relativeTo="ca_objects.title_note" delimiter="<br>">^ca_objects.title_note</unit></div></ifdef>}}}
					{{{<ifdef code="ca_objects.alt_title"><div class="unit"><H2>Alternate Titles</H2><unit relativeTo="ca_objects.alt_title" delimiter="<br>">^ca_objects.alt_title</unit></div></ifdef>}}}
					{{{<ifdef code="ca_objects.language"><div class="unit"><H2>Language</H2>^ca_objects.language%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_objects.idno"><div class="unit"><H2>Identifier</H2>^ca_objects.idno</div></ifdef>}}}
					{{{<ifdef code="ca_objects.custom_extent"><div class="unit"><H2>Extent</H2>^ca_objects.custom_extent</div></ifdef>}}}
					{{{<ifdef code="ca_objects.date_container.date"><div class="unit"><H2>Date</H2><unit relativeTo="ca_objects.date_container" delimiter="<br>">^ca_objects.date_container.date<ifdef code="ca_objects.date_container.date_note">, ^ca_objects.date_container.date_note</ifdef></unit></div></ifdef>}}}
					{{{<ifdef code="ca_objects.object_description.description"><unit relativeTo="ca_objects.object_description" delimiter=" ">
						<div class='unit'>
							<if rule='^ca_objects.object_description.description_type !~ /other/'><H2>^ca_objects.object_description.description_type</H2></if>
							<span class="trimText">^ca_objects.object_description.description</span>
							<ifdef code="ca_objects.object_description.description_source|ca_objects.object_description.description_date|ca_objects.object_description.geographic_coverage"><br/><br/><i>
								<ifdef code="ca_objects.object_description.description_source">^ca_objects.object_description.description_source<ifdef code="ca_objects.object_description.description_date|ca_objects.object_description.geographic_coverage">, </ifdef></ifdef>
								<ifdef code="ca_objects.object_description.description_date">^ca_objects.object_description.description_date<ifdef code="ca_objects.object_description.geographic_coverage">, </ifdef></ifdef>
								<ifdef code="ca_objects.object_description.geographic_coverage">^ca_objects.object_description.geographic_coverage</ifdef>
							</i></ifdef>
						</div>
					</unit></ifdef>}}}
					{{{<ifnotdef code="ca_objects.object_description.description"><div class="unit"><H2>Description</H2><?php print $this->getVar("object_description_placeholder"); ?></div></ifnotdef>}}}
					<!-- lib publication -->
					{{{<ifdef code="ca_objects.physical_lib"><div class="unit"><H2>Physical Description</H2>
						<ifdef code="ca_objects.physical_lib.phys_lib"><div class="unit">^ca_objects.physical_lib.phys_lib</div></ifdef>
						<ifdef code="ca_objects.physical_lib.phys_spine"><div class="unit">Spine height: ^ca_objects.physical_lib.phys_spine</div></ifdef>
					
						<ifdef code="ca_objects.physical_lib.phys_document_type"><div class="unit">^ca_objects.physical_lib.phys_document_type</div></ifdef>
						<ifdef code="ca_objects.physical_lib.phys_notes_lib"><div class="unit">^ca_objects.physical_lib.phys_notes_lib</div></ifdef>
						<ifdef code="ca_objects.physical_lib.phys_source_lib"><div class="unit"><i>^ca_objects.physical_lib.phys_source_lib</i></div></ifdef>
					</div></ifdef>}}}
					<!-- document -->
					{{{<ifdef code="ca_objects.physical_doc.physical_document|ca_objects.physical_doc.height_doc|ca_objects.physical_doc.width_doc|ca_objects.physical_doc.depth_doc|ca_objects.physical_doc.phys_doc_type|ca_objects.physical_doc.bw_doc|ca_objects.physical_doc.pages|ca_objects.physical_doc.phys_doc_notes"><div class="unit"><H2>Physical Description</H2>
						<ifdef code="ca_objects.physical_doc.physical_document"><div class="unit">^ca_objects.physical_doc.physical_document</div></ifdef>
						<ifdef code="ca_objects.physical_doc.height_doc|ca_objects.physical_doc.width_doc|ca_objects.physical_doc.depth_doc"><div class="unit"><ifdef code="ca_objects.physical_doc.height_doc">height: ^ca_objects.physical_doc.height_doc </ifdef><ifdef code="ca_objects.physical_doc.width_doc">width: ^ca_objects.physical_doc.width_doc </ifdef><ifdef code="ca_objects.physical_doc.depth_doc">depth: ^ca_objects.physical_doc.depth_doc </ifdef></div></ifdef>
					
						<ifdef code="ca_objects.physical_doc.phys_doc_type|ca_objects.physical_doc.bw_doc|ca_objects.physical_doc.pages"><div class="unit">
							<ifdef code="ca_objects.physical_doc.phys_doc_type">^ca_objects.physical_doc.phys_doc_type<ifdef code="ca_objects.physical_doc.bw_doc|ca_objects.physical_doc.pages">, </ifdef></ifdef>
							<ifdef code="ca_objects.physical_doc.bw_doc">^ca_objects.physical_doc.bw_doc<ifdef code="ca_objects.physical_doc.pages">, </ifdef>
							<ifdef code="ca_objects.physical_doc.pages">^ca_objects.physical_doc.pages page(s)</ifdef>
						</div></ifdef>
						<ifdef code="ca_objects.physical_doc.phys_doc_notes"><div class="unit">^ca_objects.physical_doc.phys_doc_notes</div></ifdef>
						<ifdef code="ca_objects.physical_doc.phys_doc_source"><div class="unit"><i>^ca_objects.physical_doc.phys_doc_source</i></div></ifdef>
					</div></ifdef>}}}
					
					<!-- image -->
					{{{<ifdef code="ca_objects.physical_image_analogue"><div class="unit"><H2>Physical Description</H2>
						<ifdef code="ca_objects.physical_image_analogue.phys_image_analogue"><div class="unit">^ca_objects.physical_image_analogue.phys_image_analogue</div></ifdef>
						<ifdef code="ca_objects.physical_image_analogue.height_image_a|ca_objects.physical_image_analogue.width_image_a"><div class="unit"><ifdef code="ca_objects.physical_image_analogue.height_image_a">height: ^ca_objects.physical_image_analogue.height_image_a </ifdef><ifdef code="ca_objects.physical_image_analogue.width_image_a">width: ^ca_objects.physical_image_analogue.width_image_a</ifdef></div></ifdef>
					
						<ifdef code="ca_objects.physical_image_analogue.phys_image_type|ca_objects.physical_image_analogue.bw_image_a"><div class="unit">
							<ifdef code="ca_objects.physical_image_analogue.phys_image_type">^ca_objects.physical_image_analogue.phys_image_type<ifdef code="ca_objects.physical_image_analogue.bw_image_a">, </ifdef></ifdef>
							<ifdef code="ca_objects.physical_image_analogue.bw_image_a">^ca_objects.physical_image_analogue.bw_image_a</ifdef>
						</div></ifdef>
						<ifdef code="ca_objects.physical_image_analogue.phys_notes_image"><div class="unit">^ca_objects.physical_image_analogue.phys_notes_image</div></ifdef>
						<ifdef code="ca_objects.physical_image_analogue.phys_source_image"><div class="unit"><i>^ca_objects.physical_image_analogue.phys_source_image</i></div></ifdef>
					</div></ifdef>}}}
					
					<!-- object > born dig -->
					{{{<ifdef code="ca_objects.physical_born_dig"><div class="unit"><H2>Physical Description</H2>
						<ifdef code="ca_objects.physical_born_dig.phys_born_dig"><div class="unit">^ca_objects.physical_born_dig.phys_born_dig</div></ifdef>
						<ifdef code="ca_objects.physical_born_dig.phys_born_dig_notes"><div class="unit">Notes: ^ca_objects.physical_born_dig.phys_born_dig_notes</div></ifdef>
						<ifdef code="ca_objects.physical_born_dig.phys_source_born_dig"><div class="unit"><i>^ca_objects.physical_born_dig.phys_source_born_dig</i></div></ifdef>
					</div></ifdef>}}}
					
					<!-- object > physical -->
					{{{<ifdef code="ca_objects.physical_analogue_dig"><div class="unit"><H2>Physical Description</H2>
						<ifdef code="ca_objects.physical_analogue_dig.phys_analogue_dig_desc"><div class="unit">^ca_objects.physical_analogue_dig.phys_analogue_dig_desc</div></ifdef>
						<ifdef code="ca_objects.physical_analogue_dig.height_born|ca_objects.physical_analogue_dig.width_born|ca_objects.physical_analogue_dig.depth_born"><div class="unit"><ifdef code="ca_objects.physical_analogue_dig.height_born">height: ^ca_objects.physical_analogue_dig.height_born </ifdef><ifdef code="ca_objects.physical_analogue_dig.width_born">width: ^ca_objects.physical_analogue_dig.width_born </ifdef><ifdef code="ca_objects.physical_analogue_dig.depth_born">depth: ^ca_objects.physical_analogue_dig.depth_born </ifdef></div></ifdef>
					
						<ifdef code="ca_objects.physical_analogue_dig.bw_dig"><div class="unit">^ca_objects.physical_analogue_dig.bw_dig</div></ifdef>
						<ifdef code="ca_objects.physical_analogue_dig.phys_analogue_dig"><div class="unit">^ca_objects.physical_analogue_dig.phys_analogue_dig</div></ifdef>
						<ifdef code="ca_objects.physical_analogue_dig.phys_source_analogue_dig"><div class="unit"><i>^ca_objects.physical_analogue_dig.phys_source_analogue_dig</i></div></ifdef>
					</div></ifdef>}}}

					{{{<ifcount code="ca_collections" min="1">
						<div class="unit"><H2>Part of Collection</H2>
							<unit relativeTo="ca_collections" delimiter="<br/>">
								<unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit> (^ca_collections.type_id)
							</unit>
						</div>
					</ifcount>}}}
<?php
					$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
					if(is_array($va_entities) && sizeof($va_entities)){
						$va_entities_by_type = array();
						foreach($va_entities as $va_entity_info){
							$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
						}
						foreach($va_entities_by_type as $vs_type => $va_entity_links){
							print "<div class='unit'><H2>".$vs_type."</H2>".join(", ", $va_entity_links)."</div>";
						}
					}
					$vs_rel_objects = str_replace("[BLANK]", "Title not available", $t_object->getWithTemplate('<ifcount code="ca_objects.related" min="1"><div class="unit"><H2>Related Objects</H2><unit relativeTo="ca_objects.related" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></div></ifcount>'));
					print $vs_rel_objects;
?>					
						
						{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="subject_guide"><div class="unit"><H2>In Subject Guide<ifcount code="ca_occurrences" min="2" restrictToTypes="subject_guide">s</ifcount></H2><div class="trimTextShort"><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="subject_guide"><l>^ca_occurrences.preferred_labels.name</l></unit></div></div></ifcount>}}}
						{{{<ifdef code="ca_objects.RAD_custodial"><div class="unit"><H2>Custodial History</H2>^ca_objects.custom_extent</div></ifdef>}}}
						{{{<ifdef code="ca_objects.places"><div class="unit"><H2>Related Places</H2><unit relativeTo="ca_objects.places" delimiter=", ">^ca_objects.places</unit></div></ifdef>}}}
<?php
		if($this->request->isLoggedIn()){
?>
						{{{<ifdef code="ca_objects.catalogue_control.catalogued_by|ca_objects.catalogue_control.catalogued_date"><div class="unit"><H2>Descriptive Control</H2>^ca_objects.catalogue_control.catalogued_by<ifdef cde="ca_objects.catalogue_control.catalogued_date"> (^ca_objects.catalogue_control.catalogued_date)</ifdef></div></ifdef>}}}
						{{{<ifdef code="ca_objects.object_history.bib_ref"><div class="unit"><H2>Bibliographic References</H2>^ca_objects.object_history.bib_ref</div></ifdef>}}}
		}
		if($this->request->isLoggedIn() && $this->request->user->hasRole("frontendRestricted")){
?>
						{{{<ifdef code="ca_objects.object_history.exhibition_hist"><div class="unit"><H2>Exhibition History</H2>^ca_objects.object_history.exhibition_hist</div></ifdef>}}}
					
<?php
		}
?>				
						<!-- video -->
						{{{<ifdef code="ca_objects.genre"><div class="unit"><H2>Genre</H2>^ca_objects.genre%delimiter=,_</div></ifdef>}}}
						{{{<ifdef code="ca_objects.subjects"><div class="unit"><H2>Subjects</H2>^ca_objects.subjects%delimiter=,_</div></ifdef>}}}
						{{{<ifdef code="ca_objects.tags"><div class="unit"><H2>Tags</H2>^ca_objects.tags%delimiter=,_</div></ifdef>}}}
<?php
		if($this->request->isLoggedIn() && $this->request->user->hasRole("frontendRestricted")){
?>
						{{{<ifdef code="ca_objects.historic_subject"><div class="unit"><H2>Historic Subjects</H2>^ca_objects.historic_subject%delimiter=,_</div></ifdef>}}}
<?php
		}
?>					
					
						{{{<ifcount code="ca_objects.children" min="1"><div class="unit"><H2>Formats</H2><unit relativeTo="ca_objects.children" delimiter="<br/>">^ca_objects.preferred_labels</unit></div></ifcount>}}}
						{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="distribution_contract"><div class="unit"><H2>Video Out Status</H2><unit relativeTo="ca_occurrences" restrictToTypes="distribution_contract" delimiter="<br/>">^ca_occurrences.distribution_status</unit></div></ifcount>}}}
						{{{<ifdef code="ca_objects.contributors_gratitudes"><div class="unit"><H2>Contributors and Gratitudes</H2>^ca_objects.contributors_gratitudes%delimiter=,_</div></ifdef>}}}
						<!-- end video -->
					
						<!-- library publication -->
						{{{<ifdef code="ca_objects.publication_info"><div class="unit"><H2>Place of Publication</H2>^ca_objects.publication_info</div></ifdef>}}}
						{{{<ifdef code="ca_objects.content_description"><div class="unit"><H2>Content Description</H2>^ca_objects.content_description<ifdef code="ca_objects.content_source"><br/><br/><i>^ca_objects.content_source</i></ifdef></div></ifdef>}}}
						{{{<ifdef code="ca_objects.series"><div class="unit"><H2>Series Statement</H2>^ca_objects.series</div></ifdef>}}}
						{{{<ifdef code="ca_objects.ISBN"><div class="unit"><H2>ISBN</H2>^ca_objects.ISBN</div></ifdef>}}}
						{{{<ifdef code="ca_objects.ISSN"><div class="unit"><H2>ISSN</H2>^ca_objects.ISSN</div></ifdef>}}}
						{{{<ifdef code="ca_objects.lcshFull"><div class="unit"><H2>Subject Headings</H2>^ca_objects.lcshFull%delimiter=,_</div></ifdef>}}}
						<!-- end library publication -->
					
						<!-- equipment -->
						{{{<ifdef code="ca_objects.equipment_type"><div class="unit"><H2>Type</H2>^ca_objects.equipment_type</div></ifdef>}}}
						{{{<ifdef code="ca_objects.equipment_manufacturer"><div class="unit"><H2>Manufacturer</H2>^ca_objects.equipment_manufacturer</div></ifdef>}}}
						{{{<ifdef code="ca_objects.equipment_model"><div class="unit"><H2>Model</H2>^ca_objects.equipment_model</div></ifdef>}}}
						{{{<ifdef code="ca_objects.dc_description"><div class="unit"><H2>Object Description</H2>^ca_objects.dc_description</div></ifdef>}}}
						<!-- end equipment -->				
<?php
		if($this->request->isLoggedIn() && $this->request->user->hasRole("frontendRestricted")){
?>					
						{{{<ifdef code="ca_objects.internal_notes"><div class="unit"><H2>Archivist Note</H2><unit relativeTo="ca_objects.internal_notes" delimiter="<br>">^ca_objects.internal_notes</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.condition_container.condition|ca_objects.condition_container.condition_notes"><div class="unit"><H2>Condition</H2><unit relativeTo="ca_objects.condition_container" delimiter="<br>"><ifdef code="ca_objects.condition_container.condition_date">^ca_objects.condition_container.condition_date</ifdef><ifdef code="ca_objects.condition_container.condition_date|ca_objects.condition_container.condition_examiner"> (^ca_objects.condition_container.condition_examiner)</ifdef><ifdef code="ca_objects.condition_container.condition_examiner">: </ifdef><ifdef code="ca_objects.condition_container.condition">^ca_objects.condition_container.condition</ifdef><ifdef code="ca_objects.condition_container.condition,ca_objects.condition_container.condition_notes">, </ifdef><ifdef code="ca_objects.condition_container.condition_notes">^ca_objects.condition_container.condition_notes</ifdef></unit></div></ifdef>}}}

<?php
		}
?>										
					</div>


					
					{{{<ifdef code="ca_objects.content_notice|ca_objects.rightsSummary_asset">
					<div class="bgLightPink">
						<ifdef code="ca_objects.content_notice"><div class="unit"><H2>Content Notice</H2>^ca_objects.content_notice</div>
						<ifdef code="ca_objects.rightsSummary_asset"><div class="unit"><H2>Rights Summary</H2>^ca_objects.rightsSummary_asset</div>					
					</div>
					</ifdef>}}}
<?php

	$va_events = $t_object->get("ca_occurrences.related", array("restrictToTypes" => array("event"), "returnWithStructure" => 1, "checkAccess" => $va_access_values));
	if(is_array($va_events) && sizeof($va_events)){
		$va_rel_events = array();
		$i = 0;
		foreach($va_events as $va_event_info){
			$va_rel_events[$va_event_info["occurrence_id"]] = array("name" => $va_event_info["name"], "relationship_type" => $va_event_info["relationship_typename"]);
			$i++;
			if($i == 24){
				break;
			}
		}
		$qr_events = caMakeSearchResult("ca_occurrences", array_keys($va_rel_events));
?>
		<div class="row">
			<div class="col-sm-12">
				<H3>Related Programs & Events</H3>
<?php

				$col = 0;
				while($qr_events->nextHit()){
					if($col == 0){
						print "<div class='row'>";
					}
					print "<div class='col-sm-6'>".caDetailLink($this->request, "<div class='bgDarkGray text-center'>".$va_rel_events[$qr_events->get("ca_occurrences.occurrence_id")]["name"]."<br/><small>".$qr_events->getWithTemplate("^ca_occurrences.occurrence_date")."</small></div>", "", "ca_occurrences", $qr_events->get("ca_occurrences.occurrence_id"))."</div>";
					$col++;
					if($col == 2){
						$col = 0;
						print "</div>";
					}
				}
				if($col > 0){
					print "</div>";
				}
?>			
			
			</div>
		</div>
<?php
	}

?>

					<div class="row">
						<div class="col-sm-4 text-center">
							{{{previousLink}}}
						</div>
						<div class="col-sm-4 text-center">
							{{{resultsLink}}}
						</div>
						<div class="col-sm-4 text-center">
							{{{nextLink}}}
						</div>
					</div>
				
<?php
				if(!$vb_2_col){
					print "<div id='detailTools'>";
					print "<div class='detailTool'>".caNavLink($this->request, "Inquire <span class='material-symbols-outlined'>chat</span>", "btn btn-default", "", "Contact", "Form", array("table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
					print "<div class='detailTool'>".caNavLink($this->request, "Feedback <span class='material-symbols-outlined'>add_comment</span>", "btn btn-default", "", "Contact", "Form", array("contactType" => "Feedback", "table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
					if($t_object->get("ca_objects.video_out", array("convertCodesToDisplayText" => true)) == "Yes"){
						print "<div class='detailTool'>".caNavLink($this->request, "Rent or Purchase <span class='material-symbols-outlined'>shopping_bag</span>", "btn btn-default", "", "Contact", "Form", array("contactType" => "RentalPurchase", "table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
					}
					print "</div>";

				}
?>

				</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row --></div>

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
