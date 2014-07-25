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
				<H4>{{{<ifdef code="ca_objects.preferred_labels"><H6>Title:</H6>^ca_objects.preferred_labels<br/></ifdef>}}}</H4>
				<HR>				
				
				{{{<ifcount min="1" code="ca_objects.date.date_value"><H6>Date:</H6><unit delimiter='<br/>'>^ca_objects.date.date_value <ifdef code='ca_objects.date.date_type'>(^ca_objects.date.date_type)</ifdef></unit></ifcount>}}}
		
							
				{{{<ifdef code="ca_objects.description">
					<span class="trimText"><H6>Description:</H6>^ca_objects.description</span>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.duration"><H6>Duration:</H6>^ca_objects.duration<br/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.rights.rightsText"><H6>Rights:</H6>^ca_objects.rights.rightsText<br/></ifdef>}}}
				
<?php
			if($vs_entities = $t_object->get("ca_entities", array('delimiter' => '<br/>', 'template' => '^preferred_labels (^relationship_typename)', "returnAsLink" => true))){
				print "<div class='unit'><H6>"._t('People & Organizations').":</H6> {$vs_entities}</div><!-- end unit -->";
				}
?>			
				
				{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="1" max="1"><H6>Related Exhibition:</H6></ifcount>}}}
				{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="2"><H6>Related Exhibitions:</H6></ifcount>}}}
				{{{<unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="exhibition"><l>^ca_occurrences.preferred_labels.name</l></unit><br/><br/>}}}
				
				{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="1" max="1"><H6>Related Event:</H6></ifcount>}}}
				{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="2"><H6>Related Events:</H6></ifcount>}}}
				{{{<unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="event"><l>^ca_occurrences.preferred_labels.name</l></unit><br/><br/>}}}
				
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