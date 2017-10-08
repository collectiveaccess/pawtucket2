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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H6>{{{<ifdef code="ca_objects.idno">^ca_objects.idno</ifdef>}}}</H6>
				{{{<ifcount code="ca_entities.preferred_labels" relativeTo="ca_entities" restrictToRelationshipTypes="creator" min="1"><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator" delimiter=", "><l>^ca_entities.preferred_labels</l></unit></ifcount>}}}				
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				{{{<ifcount code="ca_objects.date.date_value" min="1"><unit delimiter="<br/>">^ca_objects.date.date_value ^ca_objects.date.date_types</unit></ifcount>}}}
				
				<HR>
				{{{<ifdef code="ca_objects.medium"><h6>Medium</h6>^ca_objects.medium</ifdef>}}}
				{{{<ifdef code="ca_objects.technique"><h6>Technique</h6> ^ca_objects.technique</ifdef>}}}
				{{{<ifdef code="ca_objects.type"><h6>Type</h6>^ca_objects.type</ifdef>}}}
				
				{{{<ifcount min="1" code="ca_objects.dimensions">
				<h6>Dimensions</h6>
				<unit relativeTo="ca_objects.dimensions" delimiter="<br/>">
					<ifdef code="ca_objects.dimensions.dimensions_length">^ca_objects.dimensions.dimensions_length L</ifdef>
					<ifdef code="ca_objects.dimensions.dimensions_length,ca_objects.dimensions.dimensions_width"> x </ifdef>
					<ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width W</ifdef>
					<ifdef code="ca_objects.dimensions.dimensions_width,ca_objects.dimensions.dimensions_height"> x </ifdef>
					<ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height H</ifdef>
					<ifdef code="ca_objects.dimensions.dimensions_height,ca_objects.dimensions.dimensions_depth"> x </ifdef>
					<ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth D</ifdef>
					<ifdef code="ca_objects.dimensions.measurement_type">(^ca_objects.dimensions.measurement_type%useSingular=1)</ifdef>	 				
					<ifdef code="ca_objects.dimensions.measurement_notes"><br/>Notes: ^ca_objects.dimensions.measurement_notes</ifdef>
				</unit>
				</ifcount>}}}
				
				{{{<ifdef code="ca_objects.culture"><h6>Culture</h6>^ca_objects.culture</ifdef>}}}
								
				{{{<ifdef code="ca_objects.description">
					<h6>Description</h6><span class="trimText">^ca_objects.description</span>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.exhibition_label">
					<h6>Exhibition Label</h6><span class="trimText">^ca_objects.exhibition_label</span>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.object_status"><h6>Status</h6>^ca_objects.object_status</ifdef>}}}
				{{{<ifdef code="ca_objects.provenance"><h6>Provenance</h6>^ca_objects.provenance</ifdef>}}}
				{{{<ifdef code="ca_objects.publication_notes"><h6>Bibliography</h6>^ca_objects.publication_notes</ifdef>}}}
				
				<p style='font-style:italic; font-size:10px; margin-top:15px;'>Please note that cataloging is ongoing and that some information may not be complete.</p>				
				<hr></hr>
					<div class="row">
						<div class="col-sm-12">		
							<!-- {{{<ifcount relativeTo="ca_entities" code="ca_entities.preferred_labels" min="1"><H6>Related people</H6><unit relativeTo="ca_objects_x_entities" delimiter="<br/>">^ca_entities.preferred_labels.displayname (^relationship_typename)</unit></ifcount>}}}-->
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
						</div><!-- end col -->				
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