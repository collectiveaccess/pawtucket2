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
		<div class="container"><div class="row">
			<div class='col-sm-8 col-md-9 col-lg-7 col-lg-offset-1'>
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
			
			<div class='col-sm-4 col-md-3 col-lg-3'>
				<div class="tombstone">
					{{{<H1><ifdef code="ca_objects.preferred_labels.name"><i>^ca_objects.preferred_labels.name</i></ifdef><ifdef code="ca_objects.art_date_container"><unit relativeTo="ca_objects.art_date_container"><if rule="^ca_objects.art_date_container.art_date_type =~ /Created/"><ifdef code="ca_objects.art_date_container.art_date">, ^ca_objects.art_date_container.art_date</ifdef></if></unit></ifdef></H1>
						<ifdef code="ca_objects.medium">^ca_objects.medium<br/></ifdef>
						<ifdef code="ca_objects.dim.dim_edition_display">^ca_objects.dim.dim_edition_display</ifdef>
						<ifnotdef code="ca_objects.dim.dim_edition_display"><ifdef code="ca_objects.dim.dim_edition_note">^ca_objects.dim.dim_edition_note</ifdef></ifnotdef>}}}
				</div>
				
				
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class='col-sm-4 col-md-4 col-lg-3 col-lg-offset-1'>	
				{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Artwork Number</label>^ca_objects.idno</div></ifdef>}}}
				{{{<if rule="^ca_objects.type_id !~ /Artwork/"><div class="unit">^ca_objects.type_id</div></if>}}}
				{{{<ifdef code="ca_objects.art_date_container"><unit relativeTo="ca_objects.art_date_container" delimiter=" "><if rule="^ca_objects.art_date_container.art_date_type !~ /Created/"><ifdef code="ca_objects.art_date_container.art_date"><div class="unit"><label>^ca_objects.art_date_container.art_date_type</label>^ca_objects.art_date_container.art_date</div></ifdef></if></unit></ifdef>}}}
				{{{<ifcount code="ca_places" min="1"><div class="unit"><label>Related place<ifcount code="ca_places" min="2">s</ifcount></label><unit relativeTo="ca_places" delimiter="<br/>">^ca_places.preferred_labels.name (^relationship_typename)</unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.art_type_list"><div class="unit"><label>Type/Category</label>^ca_objects.art_type_list%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.theme_motif"><div class="unit"><label>Theme/Motif</label>^ca_objects.theme_motif%delimiter=,_</div></ifdef>}}}
				
			</div>
			<div class='col-sm-8 col-md-8 col-lg-7'>	
				{{{<ifcount code="ca_objects_x_occurrences" min="1" restrictToTypes="bibliography"><div class="unit"><label>Bibliography</label><unit relativeTo="ca_objects_x_occurrences" restrictToTypes="bibliography" delimiter="<br/><br/>"><unit relativeTo="ca_occurrences"><l><ifdef code='ca_occurrences.lit_citation'>^ca_occurrences.lit_citation</ifdef><ifnotdef code='ca_occurrences.lit_citation'>^ca_occurrences.preferred_labels.name</ifnotdef></l></unit><ifdef code="ca_objects_x_occurrences.page"><br/>Page: ^ca_objects_x_occurrences.page</ifdef></unit></div></ifcount>}}}
				
				{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibition_project"><div class="unit"><label>Exhibitions/Projects/Events</label><unit relativeTo="ca_occurrences" restrictToTypes="exhibition_project" delimiter="<br/><br/>"><l>^ca_occurrences.preferred_labels<ifdef code="ca_occurrences.date">, ^ca_occurrences.date</ifdef></l></unit></div></ifcount>}}}
				
				
				{{{<ifcount code="ca_entities" min="1">
					<ifcount code="ca_entities" min="1" max="1"><label>Related person</label></ifcount>
					<ifcount code="ca_entities" min="2"><label>Related people</label></ifcount>
					<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
				</ifcount>}}}
			
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