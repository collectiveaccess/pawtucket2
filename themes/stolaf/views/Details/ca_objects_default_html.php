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
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
<?php
				print "<div class='inquireButton'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default btn-small", "", "Contact", "Form", array("table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";
?>

				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<HR>
				
				{{{<ifdef code="ca_objects.material_type"><div class="unit"><label>Material Type</label>^ca_objects.material_type%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.unitdate.dacs_date_text"><div class="unit"><label>Date</label><unit relativeTo="ca_objects.unitdate" delimiter="<br/>"><ifdef code="ca_objects.unitdate.dacs_dates_labels">^ca_objects.unitdate.dacs_dates_labels: </ifdef>^ca_objects.unitdate.dacs_date_text <ifdef code="ca_objects.unitdate.dacs_dates_types">^ca_objects.unitdate.dacs_dates_types</ifdef></unit></div></ifdef>}}}
				
				
				
				<hr></hr>
					
				{{{<ifcount code="ca_entities" min="1" max="1" restrictToTypes="ind"><label>Related person</label></ifcount>}}}
				{{{<ifcount code="ca_entities" min="2" restrictToTypes="ind"><label>Related people</label></ifcount>}}}
				{{{<unit relativeTo="ca_entities" restrictToTypes="ind" delimiter="<br/>">^ca_entities.preferred_labels (^relationship_typename)</unit>}}}
			
				{{{<ifcount code="ca_entities" min="1" max="1" restrictToTypes="org"><label>Related organization</label></ifcount>}}}
				{{{<ifcount code="ca_entities" min="2" restrictToTypes="org"><label>Related organizations</label></ifcount>}}}
				{{{<unit relativeTo="ca_entities" restrictToTypes="org" delimiter="<br/>">^ca_entities.preferred_labels (^relationship_typename)</unit>}}}
			
				{{{<ifcount code="ca_entities" min="1" max="1" restrictToTypes="fam"><label>Related family</label></ifcount>}}}
				{{{<ifcount code="ca_entities" min="2" restrictToTypes="fam"><label>Related families</label></ifcount>}}}
				{{{<unit relativeTo="ca_entities" restrictToTypes="fam" delimiter="<br/>">^ca_entities.preferred_labels (^relationship_typename)</unit>}}}
				
				{{{<ifdef code="ca_objects.LcshSubjects"><div class="unit"><label>Subjects</label>^ca_objects.LcshSubjects%delimiter=<br/></div></ifdef>}}}
					
				{{{<ifdef code="ca_objects.LcshGenre|ca_objects.aat"><div class="unit"><label>Genres</label><unit delimiter="<br/>">^ca_objects.LcshGenre</unit><ifdef code="ca_objects.LcshGenre"><br/></ifdef><unit delimiter="<br/>">^ca_objects.aat</unit></div></ifdef>}}}
				
				{{{<ifcount code="ca_places" min="1" max="1"><label>Related place</label></ifcount>}}}
				{{{<ifcount code="ca_places" min="2"><label>Related places</label></ifcount>}}}
				{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>}}}
				
				<br/>{{{map}}}
						
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