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
			<div class='col-md-6 col-lg-6'>
				{{{representationViewer}}}
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			<div class='col-md-6 col-lg-6 metadata'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
<?php
				if ($t_object->get('ca_objects.generation_video', array('excludeValues' => array('not_specified'))) != "") {
					print "<div><span class='metaTitle'>Generation</span><span class='meta'>".$t_object->get('ca_objects.generation_video', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
				}	
				if ($t_object->get('ca_objects.generation_supporting', array('excludeValues' => array('not_specified'))) != "") {
					print "<div><span class='metaTitle'>Generation</span><span class='meta'>".$t_object->get('ca_objects.generation_supporting', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
				}					
?>				
				{{{<unit><ifdef code="ca_objects.supporting_type"><div><span class='metaTitle'>Type</span><span class='meta'>^ca_objects.supporting_type</span></ifdef></div></unit>}}}
				{{{<unit><ifdef code="ca_objects.idno"><div><span class='metaTitle'>Identifer</span><span class='meta'>^ca_objects.idno</span></div></ifdef></unit>}}}
				{{{<unit><ifdef code="ca_storage_locations.preferred_labels"><div><span class='metaTitle'>Storage Location</span><span class='meta'>^ca_storage_locations.preferred_labels</span></div></ifdef></unit>}}}
<?php
				if ($t_object->get('ca_objects.video_physical', array('excludeValues' => array('not_specified'))) != "") {
					print "<div><span class='metaTitle'>Format</span><span class='meta'>".$t_object->get('ca_objects.video_physical', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
				}
				if ($t_object->get('ca_objects.physical', array('excludeValues' => array('not_specified'))) != "") {
					print "<div><span class='metaTitle'>Format</span><span class='meta'>".$t_object->get('ca_objects.physical', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
				}
				if ($t_object->get('ca_objects.digital_moving_image', array('excludeValues' => array('not_specified'))) != "") {
					print "<div><span class='metaTitle'>Format</span><span class='meta'>".$t_object->get('ca_objects.digital_moving_image', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
				}
				if ($t_object->get('ca_objects.digital_supporting', array('excludeValues' => array('not_specified'))) != "") {
					print "<div><span class='metaTitle'>Format</span><span class='meta'>".$t_object->get('ca_objects.digital_supporting', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
				}
				if ($t_object->get('ca_objects.carrier', array('excludeValues' => array('not_specified'))) != "") {
					print "<div><span class='metaTitle'>Carrier</span><span class='meta'>".$t_object->get('ca_objects.carrier', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
				}								
?>				
				
				{{{<unit><ifdef code="ca_objects.date"><div><span class='metaTitle'>Date</span><span class='meta'>^ca_objects.date</span></div></ifdef></unit>}}}
				{{{<unit><ifdef code="ca_objects.description"><div><span class='metaTitle'>Description</span><span class='meta'>^ca_objects.description</span></div></ifdef></unit>}}}
				{{{<unit><ifdef code="ca_objects.notes"><div><span class='metaTitle'>Notes</span><span class='meta'>^ca_objects.notes</span></div></ifdef></unit>}}}
				{{{<unit><ifdef code="ca_objects.technicalNotes"><div><span class='metaTitle'>Technical Notes</span><span class='meta'>^ca_objects.technicalNotes</span></div></ifdef></unit>}}}
				{{{<unit><ifdef code="ca_objects.rights"><div><span class='metaTitle'>Rights</span><span class='meta'>^ca_objects.rights</span></div></ifdef></unit>}}}
				{{{<ifdef code="ca_objects.essenceTrack"><div><span class='metaTitle'>Essence Track</span><div class='meta'><unit>
						<p>Type: ^ca_objects.essenceTrack.essenceTrackType</p>
						<p>Frame Rate: ^ca_objects.essenceTrack.essenceTrackFrameRate</p>
						<p>Frame Size: ^ca_objects.essenceTrack.essenceTrackFrameSize</p>
						<p>Scan Type: ^ca_objects.essenceTrack.ScanType</p>
						<p>Standard: ^ca_objects.essenceTrack.essenceTrackStandard</p>
						<p>Aspect Ratio: ^ca_objects.essenceTrack.essenceTrackAspectRatio</p>
						<p>Duration: ^ca_objects.essenceTrack.essenceTrackDuration</p>
					</unit></div></div></ifdef>}}}
				{{{<unit><ifdef code="ca_objects.alt_modes"><div><span class='metaTitle'>Alternative Modes</span><span class='meta'>^ca_objects.alt_modes</span></div></ifdef></unit>}}}
				{{{<unit><ifdef code="ca_objects.color"><div><span class='metaTitle'>Color</span><span class='meta'>^ca_objects.color</span></div></ifdef></unit>}}}
	
				{{{<ifcount code="ca_occurrences" min="1" max="1"><span class='metaTitle'>Related Work</span></ifcount>}}}
				{{{<ifcount code="ca_occurrences" min="2"><span class="metaTitle">Related Works</span></ifcount>}}}
				{{{<div class='meta'><unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.displayname</l></unit></div>}}}				
				
				{{{<ifcount code="ca_objects.related" min="1" max="1"><span class='metaTitle'>Related Object</span></ifcount>}}}
				{{{<ifcount code="ca_objects.related" min="2"><span class="metaTitle">Related Objects</span></ifcount>}}}
				{{{<div class='meta'><unit relativeTo="ca_objects" delimiter="<br/>"><l>^ca_objects.related.preferred_labels.displayname</l></unit></div>}}}					
				
				{{{<ifcount code="ca_entities" min="1" max="1"><span class='metaTitle'>Related person</H6></span>}}}
				{{{<ifcount code="ca_entities" min="2"><span class='metaTitle'>Related people</H6></span>}}}
				{{{<div class='meta'><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit></div>}}}
				
				
				{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
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