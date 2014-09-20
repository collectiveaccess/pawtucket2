<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	
	
	TooltipManager::add('#caDetailZoomLink', 'View Fullscreen');
	TooltipManager::add('#caDetailDownloadLink', 'Download');
	TooltipManager::add('#caEntity', 'Related person or organization');
	//TooltipManager::add('#foo', 'This is a tooltip!');
?>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-6'>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				<div id="detailTools">
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					<div style="clear:both;"><!-- empty --></div>
				</div><!-- end detailTools -->
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H1>{{{<unit delimiter=" ➔ " relativeTo="ca_collections"><l>^ca_collections.hierarchy.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H1>
					<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
					<HR>
					
					{{{<ifcount code="ca_entities" min="1" max="1"><H3>Related person/organization</H3></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H3>Related people/organizations</H3></ifcount>}}}
					{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
					{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H3>Date</H3>^ca_objects.dateSet.setDisplayValue<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.pbcoreDate.pbcoreDates_value"><H3>Date</H3>^ca_objects.pbcoreDate.pbcoreDates_value<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtDrawings"><H3>Work Type</H3>^ca_objects.wtDrawings<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtPhotographic"><H3>Work Type</H3>^ca_objects.wtPhotographic<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtPosters"><H3>Work Type</H3>^ca_objects.wtPosters<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtClippings"><H3>Work Type</H3>^ca_objects.wtClippings<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtPlans"><H3>Work Type</H3>^ca_objects.wtPlans<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtCourse"><H3>Work Type</H3>^ca_objects.wtCourse<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtExhibition"><H3>Work Type</H3>^ca_objects.wtExhibition<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtBooks"><H3>Work Type</H3>^ca_objects.wtBooks<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtPeriodicals"><H3>Work Type</H3>^ca_objects.wtPeriodicals<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtScores "><H3>Work Type</H3>^ca_objects.wtScores<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtScrapbooks"><H3>Work Type</H3>^ca_objects.wtScrapbooks<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtPhotoAlbums"><H3>Work Type</H3>^ca_objects.wtPhotoAlbums<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtSketchbooks"><H3>Work Type</H3>^ca_objects.wtSketchbooks<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtTextual"><H3>Work Type</H3>^ca_objects.wtTextual<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtProofs"><H3>Work Type</H3>^ca_objects.wtProofs<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtThree"><H3>Work Type</H3>^ca_objects.wtThree<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.wtOther"><H3>Work Type</H3>^ca_objects.wtOther<br/></ifdef>}}}
					
					
					
					
					
					{{{<ifdef code="ca_objects.measurementSet.measurements"><H3>Measurements:</H3>^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
					

					
					{{{<ifdef code="ca_objects.descriptionSet.descriptionText"><H3>Description:</H3>^ca_objects.descriptionSet.descriptionText<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.pbcoreDescription.pBdescription_text%[pbcore_description_types=abstract]"><H3>Abstract:</H3>^ca_objects.pbcoreDescription.pBdescription_text%[pbcore_description_types=abstract]<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.inscriptionSet.inscriptionText"><H3>Inscription:</H3>^ca_objects.inscriptionSet.inscriptionText<br/></ifdef>}}}
					
					
					
					
					
					{{{<ifcount code="ca_objects.LcshTopical" min="1" max="1"><h3>Subject Heading:</h3>^ca_objects.LcshTopical</ifcount>}}}
					{{{<ifcount code="ca_objects.LcshTopical" min="2" max="30" delimiter=";">><h3>Subject Headings:</h3>^ca_objects.LcshTopical</ifcount>}}}

					{{{<ifcount code="ca_list_items" min="1" max="30"><h3>Related Terms:</h3></ifcount>}}}
					{{{<unit delimiter="<br/>">^ca_list_items.preferred_labels</unit>}}}
					
					
					{{{<ifdef code="ca_objects.containerID"><H3>Location:</H3>^ca_objects.containerID<br/></ifdef>}}}
					
					{{{<ifdef code="ca_objects.idno"><H3>Identifier:</H3>^ca_objects.idno<br/></ifdef>}}}
					
					{{{<h3>Citation:</h3><i><unit>^ca_objects.preferred_labels.name</unit>. </i><ifdef code="ca_objects.dateSet.setDisplayValue"><unit>^ca_objects.dateSet.setDisplayValue</unit>. </ifdef><ifcount code="ca_collections" min="1" max="1"><unit>^ca_collections.hierarchy.preferred_labels.name</unit>. </ifcount><i>New School Archives and Special Collections Digital Archive</i>. Web. <font>^DATE</font>.}}}
					<h3>Use Restrictions:</H3>To publish images of material from this collection, permission must be obtained in writing from The New School Archives and Special Collections. Please contact: archivist@newschool.edu.</H3>
					
					<br><br>
						{{{<ifcount code="ca_objects.related" min="1">
							<hr></hr><div class="row"><div class="col-sm-12"><H6>Related Objects</H6><div class="row rowSmallPadding"><unit relativeTo="ca_objects.related" delimiter=" "><div class="col-xs-4 col-md-2 smallpadding"><div class="detailRelObject"><l>^ca_object_representations.media.icon</l></div><!--end detailRelObject--></div><!--end col--></unit></div><!-- end row --></div><!-- end col --></div><!-- end row -->
						</ifcount>}}}									
				<hr></hr>
					<div class="row">
						<div class="col-sm-12">		
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							{{{<ifcount code="ca_places" min="1"><br/><br/></ifcount>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name</unit>}}}
							{{{<ifcount code="ca_list_items" min="1"><br/><br/></ifcount>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}
						</div><!-- end col -->				
						<div class="col-sm-12">	
						<p>
						There’s more! What you see on this site is only what is viewable online. Please visit our website to find out more about what’s in the archives. </p>
						</div>
					</div><!-- end row -->
					
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
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