<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
				
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.containerID"><H6>Box/series:</H6>^ca_objects.containerID<br/></ifdef>}}}				
				
				{{{<ifdef code="ca_objects.description">
					<span class="trimText">^ca_objects.description</span>
				</ifdef>}}}
				<?php print "<p>".caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel"))."</p>"; ?>
				
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><br/><br/>}}}
					
					{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person/organisation</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H6>Related people/organisations</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit><br/><br/>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related event</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related events</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit><br/><br/>}}}					
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
		  maxHeight: 65
		});
	});
</script>