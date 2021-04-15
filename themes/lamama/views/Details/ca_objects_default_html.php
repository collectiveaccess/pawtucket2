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
				<div class='col-sm-12 col-lg-8 col-lg-offset-2 text-center'>
					<H1>{{{ca_objects.preferred_labels.name}}}</H1>
					<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
					{{{<ifdef code="ca_objects.description">
						<div class='unit description'>
							<span class="trimText">^ca_objects.description.description_text<ifdef code="ca_objects.description.description_source"><br/><br/>^ca_objects.description.description_source</ifdef></span>
						</div>
					</ifdef>}}}
					
				</div>
			</div>
			<div class="row">
				<div class='col-sm-12 col-lg-6 col-lg-offset-3 text-center'>
					{{{representationViewer}}}
				</div>
			</div>
			<div class="row">
				<div class='col-sm-12'>
					<div id="detailAnnotations"></div>
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-1 col-xs-2", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
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
				</div>
			</div>
			<div class="row">
				<div class='col-sm-12'>
					<hr/>
				</div>
			</div>
			<div class="row">
				<div class='col-sm-12 col-sm-4 col-lg-4'>				
					{{{<ifdef code="ca_objects.object_date.object_dates_value"><div class="unit"><label>Date</label><unit relativeTo="ca_objects.object_date" delimiter="<br/>"><if rule="^dc_dates_types !~ /-/">^dc_dates_types: </if>^object_dates_value</unit></div></ifdef>}}}
					{{{<ifdef code="ca_objects.language"><div class="unit"><label>Language</label>^ca_objects.language%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
					{{{<ifdef code="ca_objects.format_text"><div class="unit"><label>Format</label>^ca_objects.format_text%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_objects.photo_format"><div class="unit"><label>Format</label>^ca_objects.photo_format%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_objects.artifact_format"><div class="unit"><label>Format</label>^ca_objects.artifact_format%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_objects.av_format"><div class="unit"><label>Format</label>^ca_objects.av_format%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_objects.document_format"><div class="unit"><label>Format</label>^ca_objects.document_format%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_objects.materials_text"><div class="unit"><label>Materials</label>^ca_objects.materials_text%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_objects.object_extent.extent_value"><div class="unit"><label>Extent</label><unit relativeTo="ca_objects.object_extent" delimiter="<br/>">^ca_objects.object_extent.extent_value<ifdef code="ca_objects.object_extent.extent_type"> ^ca_objects.object_extent.extent_type</unit></ifdef></div></ifdef>}}}
					{{{<ifdef code="ca_objects.measurementSet.measurements"><div class="unit"><label>Measurements</label><unit relativeTo="ca_objects.measurementSet" delimiter="<br/>">^ca_objects.measurementSet.measurements<ifdef code="ca_objects.measurementSet.measurementsType"> (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements"> ^ca_objects.measurementSet.measurements</ifdef><ifdef code="ca_objects.measurementSet.measurementsType2"> (^ca_objects.measurementSet.measurementsType2)</ifdef></unit></div></ifdef>}}}
					{{{<ifdef code="ca_objects.measurementSet.alt_measurements"><div class="unit"><label>Alternative Measurements</label><unit relativeTo="ca_objects.measurementSet" delimiter="<br/>">^ca_objects.measurementSet.alt_measurements<ifdef code="ca_objects.measurementSet.alt_measurements_type">(^ca_objects.measurementSet.alt_measurements_type)</ifdef></unit></div></ifdef>}}}
					{{{<ifdef code="ca_objects.av_measurements"><div class="unit"><label>Measurements</label><unit relativeTo="ca_objects.av_measurements" delimiter=" x ">^ca_objects.av_measurements.measurement_value<ifdef code="ca_objects.av_measurements.meas_type">(^ca_objects.av_measurements.meas_type)</ifdef></unit></div></ifdef>}}}
				</div>
				<div class='col-sm-12 col-sm-4 col-lg-4'>				
					{{{<ifcount code="ca_entities" min="1"><div class="unit"><label>Related <ifcount code="ca_entities" min="1" max="1">person</ifcount><ifcount code="ca_entities" min="2">people</ifcount></label>
						<unit relativeTo="ca_entities" delimiter=", "><l>^ca_entities.preferred_labels (^relationship_typename)</l></unit>
					</div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="work"><div class="unit"><label>Related work<ifcount code="ca_occurrences" min="2" restrictToTypes="work">s</ifcount></label>
						<unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="work"><l>^ca_occurrences.preferred_labels</l></unit>
					</ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="production"><div class="unit"><label>Related production<ifcount code="ca_occurrences" min="2" restrictToTypes="production">s</ifcount></label>
						<unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="production"><l>^ca_occurrences.preferred_labels</l></unit>
					</div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="special_event"><div class="unit"><label>Related special event<ifcount code="ca_occurrences" min="2" restrictToTypes="special_event">s</ifcount></label>
						<unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="special_event"><l>^ca_occurrences.preferred_labels</l></unit>
					</div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="lamama_venues"><div class="unit"><label>Related venue<ifcount code="ca_occurrences" min="2" restrictToTypes="lamama_venues">s</ifcount></label>
						<unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="lamama_venues"><l>^ca_occurrences.preferred_labels</l></unit>
					</div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="off_site"><div class="unit"><label>Related offsite venue<ifcount code="ca_occurrences" min="2" restrictToTypes="off_site">s</ifcount></label>
						<unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="off_site"><l>^ca_occurrences.preferred_labels</l></unit>
					</div></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="tours"><div class="unit"><label>Related tour<ifcount code="ca_occurrences" min="2" restrictToTypes="tours">s</ifcount></label>
						<unit relativeTo="ca_occurrences" delimiter=", " restrictToTypes="tours"><l>^ca_occurrences.preferred_labels</l></unit>
					</div></ifcount>}}}
					{{{<ifcount code="ca_objects.related" min="1">
						<div class="unit">
							<label>Related Object<ifcount code="ca_objects.related" min="2">s</ifcount></label>
							<unit relativeTo="ca_objects.related" delimiter="<br/>">
								<div class="row"><ifdef code="ca_object_representations.media.small"><div class="col-xs-3"><l>^ca_object_representations.media.small</l></div></ifdef><div class="col-xs-9"><l>^ca_objects.preferred_labels.name</l></div></div>
							</unit>
						</div>
					</ifcount>}}}
<?php
					$va_all_subjects = array();
				
					foreach(array("lcshNames", "lcshTopical", "lcshGeo") as $vs_field){
						$va_lc = $t_object->get("ca_objects.".$vs_field, array("returnAsArray" => true));
						$va_lc_names_processed = array();
						if(is_array($va_lc) && sizeof($va_lc)){
							foreach($va_lc as $vs_lc_terms){
								if($vs_lc_terms){
									$vs_lc_term = "";
									if($vs_lc_terms && (strpos($vs_lc_terms, " [") !== false)){
										$vs_lc_term = mb_substr($vs_lc_terms, 0, strpos($vs_lc_terms, " ["));
									}
									$va_all_subjects[] = caNavLink($this->request, $vs_lc_term, "", "", "Search", "objects", array("search" => "ca_objects.".$vs_field.": ".$vs_lc_term));
								}
							}
						}
					}
					if(is_array($va_all_subjects) && sizeof($va_all_subjects)){
						print "<div class='unit'><label>Subjects</label>".join(", ", $va_all_subjects)."</div>";
					}
?>
				</div>
				<div class='col-sm-12 col-sm-4 col-lg-4'>
					{{{<ifdef code="ca_objects.rightsStatement2"><div class="unit"><label>Rights statement</label>^ca_objects.rightsStatement2</div></ifdef>}}}
					{{{<ifdef code="ca_objects.rights_statement"><div class="unit"><label>Additional rights statement</label>^ca_objects.rights_statement</div></ifdef>}}}
					{{{<ifdef code="ca_objects.rights_types"><div class="unit"><label>Rights Type</label>^ca_objects.rights_types</div></ifdef>}}}
					{{{<ifdef code="ca_objects.use_restrictions"><div class="unit"><label>Use restrictions</label>^ca_objects.use_restrictions</div></ifdef>}}}
					{{{<ifdef code="ca_objects.rights_notes"><div class="unit"><label>Rights Notes</label>^ca_objects.rights_notes</div></ifdef>}}}
				</div>
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
		  maxHeight: 140
		});
	});
</script>