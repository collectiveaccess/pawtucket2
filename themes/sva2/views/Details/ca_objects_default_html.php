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
	// $va_comments = 			$this->getVar("comments");
	// $va_tags = 				$this->getVar("tags_array");
	// $vn_comments_enabled = 	$this->getVar("commentsEnabled");
	// $vn_share_enabled = 	$this->getVar("shareEnabled");
	// $vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	// $vn_id =				$t_object->get('ca_objects.object_id');
?>

<div class="container-fluid exhibition-detail-container">
	<div class="row breadcrumb-nav justify-content-start">
			<ul class="breadcrumb">
			<li>
				<?= $t_object->getWithTemplate('<unit relativeTo="ca_occurrences" restrictToTypes="exhibition"><l>^ca_occurrences.preferred_labels.name</l></unit>'); ?>
			</li>
				<li><span class="material-icons">keyboard_arrow_right</span></li>
				<li>{{{<l>^ca_objects.preferred_labels.name</l>}}}</li>
			</ul>
	</div>

    <div class="row exhibition-label justify-content-start">
        <h2>{{{^ca_objects.preferred_labels.name}}} </h2>	
			<div class="line-border"></div>
		</div>

		<!--Media Viewer-->
		<div class="row justify-content-center">	
			<div id="mediaDisplay"></div>
		</div>
		
		<div class="row details-heading justify-content-start">
			<h2 class="mt-5">Details</h2>
			<div class="line-border"></div>
		</div>

		<div class="row exhibition-details justify-content-start">

			<div class="col-sm-6">

				<!-- ID -->
				{{{<ifdef code="ca_objects.idno">
						<p class="detail-label">^ca_objects.type_id</p>
						<p class="detail-value">^ca_objects.idno</p>
						<p class="line-border"></p>
						</ifdef>}}}	
	
				<!-- Description -->
				{{{<ifdef code="ca_objects.description_public">
						<p class="detail-label">Description</p>
						<p class="detail-value">^ca_objects.description_public</p>
						<p class="line-border"></p>
				</ifdef>}}}

					<!-- Date -->
				{{{<ifcount code="ca_objects.dates" min="1" max="1">
						<p class="detail-label">Date</p>
						<unit relativeTo="ca_objects" delimiter="<br/>">
							<p class="detail-value">^ca_objects.dates.dates_value</p>
							<p class="line-border"></p>
						</unit>
				</ifcount>}}}
	
				{{{<ifcount code="ca_objects.dates" min="2">
						<p class="detail-label">Dates</p>
						<unit relativeTo="ca_objects" delimiter="<br/>">
							<p class="detail-value">^ca_objects.dates.dates_value</p>
							<p class="line-border"></p>
						</unit>
				</ifcount>}}}
				
				<!-- Materials -->
				{{{<ifdef code="ca_objects.materials">
						<p class="detail-label">Materials</p>
						<p class="detail-value">^ca_objects.materials</p>
						<p class="line-border"></p>
				</ifdef>}}}
	
				{{{<ifdef code="ca_objects.category">
					<p class="detail-label">Materials</p>
					<p class="detail-value">^ca_objects.category</p>
					<p class="line-border"></p>
				</ifdef>}}}
				
				<!-- Measurements -->
				{{{
					<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef>
					<ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef>
					<ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>
				}}}
				
				<!-- Dimensions -->
				{{{
					<ifdef code="ca_objects.dimensions.dimensions_width">
						<p class="detail-label">Dimensions</p>
					</ifdef>
					<p class="detail-value">
						<ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width (W)  </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height (H)  </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth (D)  </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_width">
							<p class="line-border"></p>
						</ifdef>
					</p>
				}}}				
				
			</div>

			<div class="col-sm-6">
			
				<!-- Designer -->
				{{{<ifcount restrictToRelationshipTypes="designer" code="ca_entities" min="1" max="1">
						<p class="detail-label">Designer</p>
						</ifcount>}}}
	
				{{{<ifcount restrictToRelationshipTypes="designer" code="ca_entities" min="2">
						<p class="detail-label">Designers</p></ifcount>}}}
	
				{{{<p class="detail-value"><unit restrictToRelationshipTypes="designer" relativeTo="ca_entities.related" delimiter=",">
							<span class="p"><l>^ca_entities.preferred_labels</l></span>
						</unit></p> </p>}}}
				
				<!-- Artist -->
				{{{<ifcount restrictToRelationshipTypes="artist" code="ca_entities" min="1" max="1">
						<p class="detail-label">Artist</p>
						</ifcount>}}}
	
				{{{<ifcount restrictToRelationshipTypes="artist" code="ca_entities" min="2">
						<p class="detail-label">Artists</p></ifcount>}}}
	
				{{{<p class="detail-value"><unit restrictToRelationshipTypes="artist" relativeTo="ca_entities.related" delimiter=", " >
						<span class="p"><l>^ca_entities.preferred_labels</l></span>
						</unit></p> </p>}}}
				
				<!-- Photographer -->
				{{{<ifcount restrictToRelationshipTypes="photographer" code="ca_entities" min="1" max="1">
						<p class="detail-label">Photographer</p>
						</ifcount>}}}
	
				{{{<ifcount restrictToRelationshipTypes="photographer" code="ca_entities" min="2">
						<p class="detail-label">Photographers</p>
						</ifcount>}}}
	
				{{{<p class="detail-value"><unit restrictToRelationshipTypes="photographer" relativeTo="ca_entities.related" delimiter=", " >
						<span class="p"><l>^ca_entities.preferred_labels</l></span>
						</unit></p> }}}		

			</div>
		
		</div>
		
		
		<!-- <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 related-objects">	
			{{{
				<unit relativeTo="ca_objects.related">
					idno=^ca_objects.idno	
				</unit>
			}}}					
		</div> -->

</div>

<div id="mediaDisplayFullscreen"></div>

<script type="text/javascript">	
    pawtucketUIApps['MediaViewer'] = {
        'selector': '#mediaDisplay',
        'media': <?= caGetMediaViewerDataForRepresentations($t_object, 'detail', ['asJson' => true]); ?>,
        'width': '100%',
        // 'width': '600px',
        'height': '500px',
        'controlHeight': '50px',
        'data': { }
    };
</script>