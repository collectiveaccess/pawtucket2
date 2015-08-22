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
				<H2>{{{<ifdef code="ca_objects.preferred_labels">^ca_objects.preferred_labels<br/></ifdef>}}}</H2>
<?php
				print "<h6>".$t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))."</h6>";
?>				<HR>				
				
				{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/></ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.abstract">
					<span class="trimText"><H6>Abstract:</H6>^ca_objects.abstract</span>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.page_number"><H6>Number of Pages:</H6>^ca_objects.page_number<br/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.graduation_year"><H6>Graduation Year:</H6>^ca_objects.graduation_year<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.graduation_semester"><H6>Graduation Semester:</H6>^ca_objects.graduation_semester<br/></ifdef>}}}
				
				{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related Student</H6></ifcount>}}}
				{{{<ifcount code="ca_entities" min="2"><H6>Related Student</H6></ifcount>}}}
				{{{<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="student"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}
				
				{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related Reader</H6></ifcount>}}}
				{{{<ifcount code="ca_entities" min="2"><H6>Related Readers</H6></ifcount>}}}
				{{{<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="first_reader;second_reader;third_reader"><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}
				
				{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related Board Of Study</H6></ifcount>}}}
				{{{<ifcount code="ca_occurrences" min="2"><H6>Related Boards of Study</H6></ifcount>}}}
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