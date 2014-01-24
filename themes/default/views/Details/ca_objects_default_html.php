<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>

<div id="detail">
	<div class="row">
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgLeft">
				{{{previousLink}}}{{{resultsLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
		<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
			<div class="container"><div class="row">
				<div class='col-md-6 col-lg-6'>
					{{{representationViewer}}}
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					<H1>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H1>
					<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
					<HR>
					
					{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
					
					
					{{{<ifdef code="ca_objects.idno"><H3>Identifer:</H3>^ca_objects.idno<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.containerID"><H3>Box/series:</H3>^ca_objects.containerID<br/></ifdef>}}}
					
					{{{<ifdef code="ca_objects.description">^ca_objects.description<br/></ifdef>}}}
					
					
					{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H3>Date:</H3>^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}
					
					{{{<ifcount code="ca_entities" min="1" max="1"><h3>Related person</h3></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><h3>Related people</h3></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}
					
					
					{{{<ifcount code="ca_objects.LcshNames" min="1"><h3>LC Terms</h3></ifcount>}}}
					{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}
				</div><!-- end col -->
			</div><!-- end row --></div><!-- end container -->
		</div><!-- end col -->
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgRight">
				{{{nextLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end detail -->