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
			<div class='col-sm-8'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
			</div>
			<div class='col-sm-4 objectActions text-right'>
			    <a href="#" onclick="caMediaPanel.showPanel(&quot;/index.php/Lightbox/addItemForm/context/objects/object_id/22019&quot;); return false;" title="Add to lightbox">
                    <i class="fa fa-folder"></i>
                </a>
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {	
					if ($vn_comments_enabled) {
?>				
						<a id='commentOpen' href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span></a>
<?php				
					}
					if ($vn_share_enabled) {
						print $this->getVar("shareLink");
					}
					if ($vn_pdf_enabled) {
						print caDetailLink($this->request, "<span class='glyphicon glyphicon-download-alt'></span>", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'));;
					}
				}				

?>
			</div>
		  </div>
		  <div class="row">
			<div class="col-xs-12">
				<hr/>
			</div>
		  </div>
		  <div class="row">
			<div class='col-sm-6'>
				{{{representationViewer}}}
			</div>
			
			<div class='col-sm-6'>
				{{{<unit relativeTo="ca_collections"><h6>^ca_collections.preferred_labels</h6></unit>}}}
				{{{<ifcount code="ca_entities" restrictToTypes="artist" min="1" max="1"><H6>Artist</H6></ifcount>}}}
				{{{<ifcount code="ca_entities" restrictToTypes="artist" min="2"><H6>Artists</H6></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>" restrictToTypes="artist"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit></unit>}}}
				
				{{{<ifdef code="ca_objects.dateSet.displayDate"><h6>Date</h6>^ca_objects.dateSet.displayDate</ifdef>}}}
				
				{{{<ifdef code="ca_objects.culturalContextSet.culturalContextTerm"><h6>Cultural Context</h6>^ca_objects.culturalContextSet.culturalContextTerm</ifdef>}}}
				
				{{{<ifdef code="ca_objects.descriptionSet.descriptionText"><h6>Description</h6>^ca_objects.descriptionSet.descriptionText</ifdef>}}}
				
				{{{<ifcount code="ca_places" min="1"><h6>Location</h6><unit relativeTo="ca_places" delimiter="<br/>">^ca_places.hierarchy.preferred_labels%delimiter=-></unit></ifcount>}}}
				
				{{{<ifdef code="ca_objects.stylePeriodSet.stylePeriod"><h6>Style/Period</h6><unit relativeTo="ca_objects.stylePeriodSet" delimiter="<br/>">^ca_objects.stylePeriodSet.stylePeriod <ifdef code="ca_objects.stylePeriodSet.stylePeriodVocab">(^ca_objects.stylePeriodSet.stylePeriodVocab)</ifdef></unit></ifdef>}}}
                
                {{{<ifdef code="ca_objects.workTypeSet.worktype"><h6>Work Type</h6>^ca_objects.workTypeSet.worktype</ifdef>}}}
                
                {{{<ifdef code="ca_objects.materialSet.material"><h6>Material<ifcount code="ca_objects.materialSet.material" min="2">s</ifcount></h6><unit relativeTo="ca_objects.material" delimiter="<br/>">^ca_objects.materialSet.material</unit></ifdef>}}}
                
                {{{<ifdef code='ca_objects.measurementSet'><h6>MeasureMents</h6>
                    <ifdef code='ca_objects.measurementSet.dimensions_width'>Width: ^ca_objects.measurementSet.dimensions_width<br/></ifdef>
                    <ifdef code='ca_objects.measurementSet.dimensions_height'> Height: ^ca_objects.measurementSet.dimensions_height<br/></ifdef>
                    <ifdef code='ca_objects.measurementSet.dimensions_length'> Length: ^ca_objects.measurementSet.dimensions_length<br/></ifdef>
                    <ifdef code='ca_objects.measurementSet.dimensions_depth'> Depth: ^ca_objects.measurementSet.dimensions_depth<br/></ifdef>
                    <ifdef code='ca_objects.measurementSet.dimensions_weight'> Weight: ^ca_objects.measurementSet.dimensions_weight<br/></ifdef>
                    <ifdef code='ca_objects.measurementSet.dimensions_diameter'> Diameter: ^ca_objects.measurementSet.dimensions_diameter<br/></ifdef>
                    <ifdef code='ca_objects.measurementSet.dimensions_circumference'> Circumference: ^ca_objects.measurementSet.dimensions_circumference<br/></ifdef>
                    <ifdef code='ca_objects.measurementSet.dimensions_thickness'> Thickness: ^ca_objects.measurementSet.dimensions_thicknes</ifdef></ifdef>}}}
                
                {{{<ifdef code="ca_objects.location.locationName"><h6>Location</h6>^ca_objects.location.locationName</ifdef>}}}
                
                {{{<ifcount code="ca_occurrences" min="1"><h6>Course<ifcount code="ca_occurrences" min="2">s</ifcount></h6></ifcount>}}}
                {{{<unit relativeTo="ca_objects_x_occurrences" delimiter="<br/>"><unit relativeTo="ca_occurrences"><l>^ca_occurrences.idno ^ca_occurrences.preferred_labels</l> <unit relativeTo="ca_entities">(Prof. ^ca_entities.preferred_labels)</unit></unit>}}}
                
                {{{<ifdef code="ca_objects.sourceSet.sourceText"><h6>Source</h6><unit relativeTo="ca_objects.sourceSet" delimiter="<br/>">^ca_objects.sourceSet.sourceText</unit></ifdef>}}}
        
                {{{<ifdef code="ca_objects.rightsSet.rightText"><h6>Rights</h6><unit relativeTo="ca_objects.rightsSet" delimiter="<br/>">^ca_objects.rightsSet.rightText <ifdef code="ca_objects.rightsSet.rightsHolder">(^ca_objects.rightsSet.rightsHolder)</ifdef></unit></ifdef>}}}

				<div id='detailComments' name='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->				
			</div><!-- end col -->
		</div>
		<div class="row">
			<div class='col-sm-12'>
				<hr/>
				<!--<div id="detailAnnotations"></div>-->
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding text-center col-sm-1  col-xs-2")); ?>

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
		
		$('.objectInfoToggle').on('click', function(){
			$('.objectMoreInfo').show('600');
			$('.objectInfoToggle').hide('0');
		});
		$('#commentOpen').on('click', function(){
			$(document).scrollTop($('#detailComments').offset().top); 
		});
	});
</script>
