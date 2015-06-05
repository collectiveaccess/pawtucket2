<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
			<div class='col-sm-6 col-md-6 col-lg-6'>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}{{{<ifdef code="ca_objects.type">, <unit>^ca_objects.type</unit></ifdef>}}}</H6>
				{{{<ifdef code="ca_objects.subtype"><unit>^ca_objects.subtype</unit></ifdef>}}}
				<HR>
				
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.idno"><H6>Identifer</H6>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_entities" restrictToRelationshipTypes="creator"><H6>Creator</H6><unit restrictToRelationshipTypes="creator" relativeTo="ca_entities">^ca_entities.preferred_labels.displayname</unit><br/></ifdef>}}}				
				{{{<ifdef code="ca_objects.date"><H6>Date</H6>^ca_objects.date<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.material"><H6>Material</H6><div><unit delimiter=', '>^ca_objects.material</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.software"><H6>Software</H6><div><unit delimiter=', '>^ca_objects.software</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.hardware"><H6>Hardware</H6><div><unit delimiter=', '>^ca_objects.hardware</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.algorithms"><H6>Algorithms</H6><div><unit delimiter=', '>^ca_objects.algorithms</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.measurements.measurement_display"><H6>Measurements</H6><div><unit delimiter=', '>^ca_objects.measurements.measurement_display</unit></div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.formatNotes">
					<H6>Notes</H6>
					<div class="trimText">^ca_objects.formatNotes</div>
				</ifdef>}}}
				
				
				
				<hr></hr>
					{{{<ifdef code="ca_objects.historical_significance"><H6>Historical Significance</H6>^ca_objects.historical_significance<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.artists_comments"><H6>Artist's Comments</H6>^ca_objects.artists_comments<br/></ifdef>}}}
				
					{{{<ifdef code="ca_objects.rights"><hr></hr><H6>Rights</H6><div><unit><ifdef code="ca_objects.rights.rightsText">^ca_objects.rights.rightsText<br/></ifdef><b>Rights Holder:</b> ^ca_objects.rights.rightsHolder<br/><b>Copyright Statement:</b> ^ca_objects.rights.copyrightStatement<br/></unit></div></ifdef>}}}
					<div class="row">
						<div class="col-sm-6">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_entities" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit>}}}
							
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}
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