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
<?php
				print "<h4 class='entity'>".$t_object->get('ca_entities.preferred_labels', array('delimiter' => ', ', 'returnAsLink' => true, 'restrictToRelationshipTypes' => array('author', 'collected', 'creator', 'engraver', 'draftsmen_surveyor', 'lithographer', 'photographer')))."</h4>";
?>			
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<HR>
<?php
					if ($vs_pub_description = $t_object->get('ca_objects.publication_description')){
						print "<div class='unit'><h6>Publication Information</h6>".$vs_pub_description."</div>";
					}
					$va_format_buf = null;
					if ($t_object->get('ca_objects.format')) {
						$va_format_buf .= "<div class='unit'><b>Format: </b>".$t_object->get('ca_objects.format')."</div>";
					}
					if (($t_object->get('ca_objects.digitization_info.digital_status') != 272) && $t_object->get('ca_objects.digitization_info.digital_status')) {
						$va_format_buf .= "<div class='unit'><b>Digitization Status: </b>".$t_object->get('ca_objects.digitization_info.digital_status', array('convertCodesToDisplayText' => true))."</div>";
					}
					if ($t_object->get('ca_objects.reproduction')) {
						$va_format_buf .= "<div class='unit'><b>Reproduction: </b>".$t_object->get('ca_objects.reproduction', array('convertCodesToDisplayText' => true))."</div>";
					}
					if ($t_object->get('ca_objects.dimensions')) {
						$va_dimensions = $t_object->get('ca_objects.dimensions', array('returnWithStructure' => true));
						print "<pre>";
						print_r($va_dimensions);
						print "</pre>";
						$va_format_buf .= "<div class='unit'><b>Dimensions: </b>".$t_object->get('ca_objects.dimensions')."</div>";
					}										
					if ($va_format_buf) {
						print "<div class='unit'><h3>Format and extent</h3>".$va_format_buf."</div>";
					}					
					if ($vs_description = $t_object->get('ca_objects.description.description_text')){
						print "<div class='unit'><h6>Description</h6>".$vs_description."</div>";
					}
					if ($vs_extent = $t_object->get('ca_objects.extent_text')) {
						print "<div class='unit'><h6>Extent</h6>".$vs_extent."</div>";
					}
					if ($vs_date = $t_object->get('ca_objects.date', array('delimiter' => '<br/>', 'template' => '^ca_objects.date.date_value ^ca_objects.date.date_types <ifdef code="date_notes"><br/>^ca_objects.date.date_notes</ifdef>', 'convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
					}

					if ($vs_language = $t_object->get('ca_objects.language', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Language</h6>".$vs_language."</div>";
					}
					if ($vs_format = $t_object->get('ca_objects.format', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Format</h6>".$vs_format."</div>";
					}																			
?>								
				<hr></hr>
					<div class="row">
						<div class="col-sm-6">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
							
							{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
							{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
							{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels</l></unit>}}}
														
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
						</div><!-- end col -->				
						<div class="col-sm-6 colBorderLeft">
							{{{map}}}
<?php
							if ($va_spatial = $t_object->get('ca_objects.coverageSpatial', array('delimiter' => '<br/>'))) {
								print "<div class='unit'><h6>Spatial Coverage</h6>".$va_spatial."</div>";
							}
?>							
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