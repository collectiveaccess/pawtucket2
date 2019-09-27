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
	</div>
    <div class="row">
			<div class="col-sm-1 prevnext">
		     	<?php print $this->getVar('resultsLink'); ?><br>
				<span class="flex align-items-start"><?php print $this->getVar('previousLink'); ?> </span>
			</div>
			<div class="col-sm-10">
			  <!--   <H2>{{{^ca_occurrences.type_id}}}{{{<ifdef code="ca_occurrences.idno"> ^ca_occurrences.idno</ifdef>}}}: {{{^ca_occurrences.preferred_labels.name}}}</H2>	-->	
            	<H2>{{{^ca_objects.preferred_labels.name}}}</h2>	
            </div>		
            <div class="col-sm-1 prevnext">
				<br><?php print $this->getVar('nextLink'); ?>
			</div>
			<div class="col-sm-12"><hr></div>
	</div>
	<div class="row">
            <div class="col-sm-12">
            	{{{<ifdef code="ca_objects.description_public"><h3>Description</h3><p>^ca_objects.description_public</p></ifdef>}}}		
            </div>			
		</div>	
		<div class="row">	   
		    {{{<ifdef code="ca_objects.idno"><div class="col-sm-4"><h3>Identifier</h3><p>^ca_objects.idno</p></div></ifdef>}}}		   			
			
			{{{<ifcount code="ca_objects.dates" min="1" max="1"><div class="col-sm-4"><h3>Date</h3><unit relativeTo="ca_objects" delimiter="<br/>"><p>^ca_objects.dates.dates_value</p><br/></unit></div></ifcount>}}}
			{{{<ifcount code="ca_objects.dates" min="2"><div class="col-sm-4"><h3>Dates</h3><unit relativeTo="ca_objects" delimiter="<br/>"><p>^ca_objects.dates.dates_value</p><br/></unit></div></ifcount>}}}
	
			{{{<ifdef code="ca_objects.type_id"><div class="col-sm-4"><h3>Format</h3><p>^ca_objects.type_id</p></div></ifdef>}}}	
	
			<div class="col-sm-4">
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}																					
			    {{{<ifdef code="ca_objects.dimensions.dimensions_width"><h3>Measurements<h3></ifdef>
			    <p><ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width (W)  </ifdef><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height (H)  </ifdef><ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth (D)  </ifdef><p/>}}}																					
			</div>		
		
			{{{<ifdef code="ca_objects.materials"><div class="col-sm-4"><h3>Materials</h3><p>^ca_objects.materials</p></div></ifdef>}}}
			
		</div>
		<div class="row">	
					<div class="col-sm-12">
            	<hr>	
            </div>		
				{{{<unit relativeTo="ca_object_representations" filterNonPrimaryRepresentations="0" delimiter=" "><div class="col-sm-6 mx-auto"><l>^ca_object_representations.media.large</l><div class='masonry-title'>^ca_object_representations.preferred_labels.name</div></div></unit>}}}	
		</div>
	<!--	<div class="row container-fluid">
			    <div class="card-columns">
				{{{<unit relativeTo="ca_object_representations" filterNonPrimaryRepresentations="0" min="3" delimiter=" "><div class="card mx-auto"><l>^ca_object_representations.media.large</l><div class='masonry-title'>^ca_object_representations.preferred_labels.name</div></div></unit>}}}
                </div>
		</div>		-->
</div><!-- end container -->
</div><!-- end row -->
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
