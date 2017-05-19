<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
<div class="container">
	<div class="row">
		<div class='col-xs-12'>
			<H1>{{{ca_objects.preferred_labels.name}}}</H1>
		</div>
	</div>
</div>
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
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
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
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caNavLink($this->request, 'Download as PDF', 'faDownload', 'Detail', 'objects', $vn_id.'/view/pdf/export_format/_pdf_ca_objects_summary')."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				{{{<ifcount min="1" code="ca_collections"><H6>Collection</H6><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><br/></ifcount>}}}
				{{{<ifdef code="ca_objects.idno"><H6>Identifier:</H6>^ca_objects.idno<br/></ifdef>}}}			
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><h6>Description</h6>
						<span class="trimText">^ca_objects.description</span>
					</div>
					<HR>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.date"><H6>Date</H6><unit relativeTo="ca_objects.date" delimiter="<br/>">^ca_objects.date.date_value ^ca_objects.date.date_types</unit><br/></ifdev>}}}
				{{{<ifdef code="ca_objects.dimensions.dimensions_length|ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_thickness|ca_objects.dimensions.dimensions_diameter|ca_objects.dimensions.dimensions_weight"><H6>Dimensions</H6></ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_length">^ca_objects.dimensions.dimensions_length (length)<ifdef code="ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_thickness|ca_objects.dimensions.dimensions_diameter|ca_objects.dimensions.dimensions_weight"> x </ifdef></ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width (width)<ifdef code="ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_thickness|ca_objects.dimensions.dimensions_diameter|ca_objects.dimensions.dimensions_weight"> x </ifdef></ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height (height)<ifdef code="ca_objects.dimensions.dimensions_thickness|ca_objects.dimensions.dimensions_diameter|ca_objects.dimensions.dimensions_weight"> x </ifdef></ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_thickness">^ca_objects.dimensions.dimensions_thickness (thickness)<ifdef code="ca_objects.dimensions.dimensions_diameter|ca_objects.dimensions.dimensions_weight"> x </ifdef></ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_diameter">^ca_objects.dimensions.dimensions_diameter (diameter)<ifdef code="ca_objects.dimensions.dimensions_weight"> x </ifdef></ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_weight">^ca_objects.dimensions.dimensions_weight (weight)</ifdef>
						}}}
				{{{<ifdef code="ca_objects.curatorial_category"><H6>Curatorial Category</H6>^ca_objects.curatorial_category<br/></ifdef>}}}
				
				<hr></hr>
					<div class="row">
						<div class="col-sm-6">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
							
							{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related exhibition/event</H6></ifcount>}}}
							{{{<ifcount code="ca_occurrences" min="2"><H6>Related exhibitions/events</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_occurrences" delimiter="<br/>"><unit relativeTo="ca_occurrences"><l>^ca_occurrences.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
							
							
							
						</div><!-- end col -->				
						<div class="col-sm-6 colBorderLeft">
							{{{map}}}
						</div>
					</div><!-- end row -->
						
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