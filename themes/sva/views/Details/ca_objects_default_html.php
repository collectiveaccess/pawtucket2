<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
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
<div class="container-fluid">
<div class="row" id="sec2">
	<div class="container-fluid">
	<br/>
		<H1--smaller>{{{ca_objects.preferred_labels.name}}}</H1--smaller>			
		<div class="row">
			<div class='col-sm-12'>		 
		  	  <ul class="breadcrumbs--nav">
					<li><a href="#">School of Visual Arts Archives</a><span></li>
					<li><?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "arrow")); ?>
					</span></li>
					<li><a href="/index.php/">SVA Exhibitions Archives<span></a></li>
					<li><?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "arrow")); ?>
					</span>
					</li>
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><li><l> ^ca_occurrences.preferred_labels.name Exhibition</l></li></unit>}}} 
					<li><?php print caGetThemeGraphic('icon-arrow-right.svg', array("alt" => "arrow")); ?>
					</span>
					</li>
					{{{<unit relativeTo="ca_objects" delimiter="<br/>"><li>^ca_objects.preferred_labels.name</li></unit>}}} 

				</ul>
			</div> 
			<div class="col-sm-12">
            	{{{<ifdef code="ca_objects.description_public"><h2 class="exhibit-about">About the Item</h2><hr><p>^ca_objects.description_public</p></ifdef>}}}		
            </div>				
			<div class="col-sm-12"><hr>
				<ul class="nav nav-pills nav-justified">
					<li class="nav-item breadcrumbs--tab first-tab">
					<a class="nav-link active" id="depictions-tab" data-toggle="pill" href="#depictions" role="tab" aria-controls="depictions" aria-selected="true">Depictions</a>
					</li>
					<li class="nav-item breadcrumbs--tab">
					<a class="nav-link" id="metadata-tab" data-toggle="pill" href="#metadata" role="tab" aria-controls="metadata" aria-selected="false">Metadata</a>
					</li>
				</ul>
			<hr></div>
		</div>	
<div class="tab-content">
	<div class="tab-pane" id="metadata" role="tabpanel" aria-labelledby="metadata-tab">		
		<div class="container">
		<div class="row">	   
			<div class="col-sm-4">
			    {{{<ifdef code="ca_objects.idno"><h2>Identifier</h2><p>^ca_objects.idno</p></ifdef>}}}		   			
			</div>
			<div class="col-sm-4">
				{{{<ifcount code="ca_objects.dates" min="1" max="1"><h2>Date</h2></ifdef>}}}
				{{{<ifcount code="ca_objects.dates" min="2"><h2>Dates</h2></ifdef>}}}
				{{{<unit relativeTo="ca_objects" delimiter="<br/>"><p>^ca_objects.dates.dates_value</p><br/></unit>}}}
			</div>	
			<div class="col-sm-4">
				 {{{<ifdef code="ca_objects.type_id"><h2>Format</h2><p>^ca_objects.type_id</p></ifdef>}}}	
			</div>	
			<div class="col-sm-4">
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}																					
			    {{{<ifdef code="ca_objects.dimensions.dimensions_width"><h2>Measurements<h2></ifdef>
			    <p><ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width (W)  </ifdef><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height (H)  </ifdef><ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth (D)  </ifdef><p/>}}}																					
			</div>		
			<div class="col-sm-4">
			    {{{<ifdef code="ca_objects.materials"><h2>Materials</h2><p>^ca_objects.materials</p></ifdef>}}}
			</div>			
		</div>
		</div>		
	</div> <!--end metadata tab-->
	<div class="tab-pane active" id="depictions" role="tabpanel" aria-labelledby="depictions-tab">
		<div class="row">		
				{{{<unit relativeTo="ca_objects.representations" filterNonPrimaryRepresentations="0" delimiter=" "><div class='col-sm-6 mx-auto'>^ca_object_representations.media.large</div></unit>}}}
			<!-- end col -->	
		</div>
	</div><!-- end tab -->
</div><!-- end tabs -->
</div><!-- end container -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
