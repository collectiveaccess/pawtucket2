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
				<H4>{{{^ca_objects.preferred_labels.name<ifdef code="ca_objects.creation_date">, ^ca_objects.creation_date</ifdef>}}}</H4>
				{{{<ifcount code='ca_entities' restrictToRelationshipTypes='creator' min='1'><H5><unit relativeTo='ca_entities' restrictToRelationshipTypes='creator' delimiter=', '><l>^ca_entities.preferred_labels.name<ifdef code="ca_entities.dob_dod|ca_entities.nationality"> (</ifdef><ifdef code="ca_entities.nationality">^ca_entities.nationality</ifdef><ifdef code="ca_entities.dob_dod,ca_entities.nationality">, </ifdef>^ca_entities.dob_dod<ifdef code="ca_entities.ca_entities.dob_dod|ca_entities.nationality">)</ifdef></l></unit></H5></ifcount>}}}
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR/>
				
				{{{<ifdef code="ca_objects.dimensions.display_dimensions"><H6>Dimensions</H6>^ca_objects.dimensions.display_dimensions</ifdef>}}}
<?php
				if(!$t_object->get("ca_objects.dimensions.display_dimensions") && ($t_object->get("ca_objects.dimensions.dimensions_height") || $t_object->get("ca_objects.dimensions.dimensions_width") || $t_object->get("ca_objects.dimensions.dimensions_depth") || $t_object->get("ca_objects.dimensions.dimensions_length"))){
					print "<H6>Dimensions</H6>";
					$va_dimension_pieces = array();
					if($t_object->get("ca_objects.dimensions.dimensions_height")){
						$va_dimension_pieces[] = $t_object->get("ca_objects.dimensions.dimensions_height");
					}
					if($t_object->get("ca_objects.dimensions.dimensions_width")){
						$va_dimension_pieces[] = $t_object->get("ca_objects.dimensions.dimensions_width");
					}
					if($t_object->get("ca_objects.dimensions.dimensions_depth")){
						$va_dimension_pieces[] = $t_object->get("ca_objects.dimensions.dimensions_depth");
					}
					if($t_object->get("ca_objects.dimensions.dimensions_length")){
						$va_dimension_pieces[] = $t_object->get("ca_objects.dimensions.dimensions_length");
					}
					if(sizeof($va_dimension_pieces)){
						print join(" X ", $va_dimension_pieces);
					}
				}
?>
				{{{<ifdef code="ca_objects.dimensions_frame.display_dimensions_frame"><H6>Framed dimensions</H6>^ca_objects.dimensions_frame.display_dimensions_frame</ifdef>}}}
<?php
				if(!$t_object->get("ca_objects.dimensions_frame.display_dimensions_frame") && ($t_object->get("ca_objects.dimensions_frame.dimensions_frame_height") || $t_object->get("ca_objects.dimensions_frame.dimensions_frame_width") || $t_object->get("ca_objects.dimensions_frame.dimensions_frame_depth") || $t_object->get("ca_objects.dimensions_frame.dimensions_frame_length"))){
					print "<H6>Framed dimensions</H6>";
					$va_dimension_pieces = array();
					if($t_object->get("ca_objects.dimensions_frame.dimensions_frame_height")){
						$va_dimension_pieces[] = $t_object->get("ca_objects.dimensions_frame.dimensions_frame_height");
					}
					if($t_object->get("ca_objects.dimensions_frame.dimensions_frame_width")){
						$va_dimension_pieces[] = $t_object->get("ca_objects.dimensions_frame.dimensions_frame_width");
					}
					if($t_object->get("ca_objects.dimensions_frame.dimensions_frame_depth")){
						$va_dimension_pieces[] = $t_object->get("ca_objects.dimensions_frame.dimensions_frame_depth");
					}
					if($t_object->get("ca_objects.dimensions_frame.dimensions_frame_length")){
						$va_dimension_pieces[] = $t_object->get("ca_objects.dimensions_frame.dimensions_frame_length");
					}
					if(sizeof($va_dimension_pieces)){
						print join(" X ", $va_dimension_pieces);
					}
				}
?>
				{{{<ifdef code="ca_objects.material"><H6>Material</H6>^ca_objects.material</ifdef>}}}
				{{{<ifdef code="ca_objects.styles_movement"><H6>Style/Movement</H6>^ca_objects.styles_movement</ifdef>}}}
				
				<HR/>
				{{{<ifdef code="ca_objects.idno"><H6>Identifer</H6>^ca_objects.idno</ifdef>}}}			
				{{{<ifcount code='ca_collections' min='1'><unit relativeTo='ca_collections'><H6>Collection</H6><l>^ca_collections.preferred_labels.name</l></unit></ifcount>}}}
				{{{<ifcount code='ca_storage_locations' min='1'><unit relativeTo='ca_storage_locations'><H5>^ca_storage_locations.preferred_labels.name</H5></unit></ifcount>}}}
				{{{<ifcount code="ca_objects.steelcase_themes" min='1'><H6>Themes</H6></ifcount>}}}{{{<unit code="ca_objects.steelcase_themes" delimiter=", ">^ca_objects.steelcase_themes</unit>}}}			
				
				<hr></hr>
					<div class="row">
						<div class="col-sm-6">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels.displayname</l></unit> (^relationship_typename)</unit>}}}

							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name</unit>}}}
							
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