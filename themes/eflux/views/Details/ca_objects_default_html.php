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
			
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
				
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.containerID"><H6>Box/series:</H6>^ca_objects.containerID<br/></ifdef>}}}
<?php
					if (is_array($va_format_type_ids = $t_object->get('ca_objects.format_type', array('returnAsArray' => true))) && sizeof($va_format_type_ids)) {
						$va_format_types = $t_object->get('ca_objects.format_type', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
						print "<H6>Category:</H6>";
		
						$va_list = array();
						foreach($va_format_type_ids as $vn_i => $va_format_type_id) {
							if (!$va_format_type_id['format_type']) { continue; } // skip blank format types
							$va_list[] = caNavLink($this->request, $va_format_types[$vn_i]['format_type'], '', '', 'Browse', 'objects', array('facet' => 'category_facet', 'id' => $va_format_type_id['format_type']));
						}
						print join(", ", $va_list);
					}
?>
				<!--{{{<ifcount min="1" code="ca_objects.format_type"><H6>Category:</H6><unit delimiter=", ">^ca_objects.format_type</unit></ifdef>}}}	-->
				
<?php
				if ($t_object->get('ca_objects.date')) {
					$va_raw_date = $t_object->get('ca_objects.date', array('rawDate' => 1, 'returnAsArray' => true));
					print "<h6>Date: </h6> ";
					foreach ($va_raw_date as $id => $raw_date) {
						$va_the_date = $raw_date['date']['start'];
						print caNavLink($this->request, caGetLocalizedHistoricDateRange($raw_date['date']['start'], $raw_date['date']['end']), '', '', 'Search', 'objects/search/ca_objects.date:'.substr($va_the_date, 0, 4))."<br/>";
					}
				}
?>			
				{{{<ifdef code="ca_objects.isbn"><H6>ISBN:</H6>^ca_objects.isbn<br/></ifdef>}}}			
				{{{<ifdef code="ca_objects.copies"><H6>Copies:</H6>^ca_objects.copies<br/></ifdef>}}}							
				{{{<ifdef code="ca_objects.printing"><H6>Printing:</H6>^ca_objects.printing<br/></ifdef>}}}							
				{{{<ifdef code="ca_objects.length"><H6>Length:</H6>^ca_objects.length<br/></ifdef>}}}							
<?php
				if ($va_languages = $t_object->get('ca_objects.language', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
					print "<H6>Language:</H6>";
					foreach ($va_languages as $va_id => $va_language) {
						print caNavLink($this->request, $va_language['language'], '', '', 'Search', 'objects/search/ca_objects.language:'.$va_language['language'])."<br/>";
					}	
				}
?>				
													
				{{{<ifcount min="1" code="ca_objects.website"><H6>Website:</H6><unit delimiter="<br/>"><a href='^ca_objects.website' target='_blank'>^ca_objects.website</a></unit></ifdef>}}}			
		
					
				{{{<ifdef code="ca_objects.number_of_copies"><H6>Number of Copies:</H6>^ca_objects.number_of_copies<br/></ifdef>}}}			
				
				{{{<ifdef code="ca_objects.description">
					<span class="trimText">^ca_objects.description</span>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.series"><H6>Series:</H6>^ca_objects.series<br/></ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}
				
			</div><!-- end col -->
					<div class="col-sm-6">
						
						{{{<ifcount code="ca_entities" restrictToRelationshipTypes="author" min="1" ><H6>Author</H6></ifcount>}}}
						{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
				
						{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="editor"><H6>Editor</H6></ifcount>}}}
						{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="editor" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
			
						{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="publisher"><H6>Publisher</H6></ifcount>}}}
						{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="publisher" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
											
						{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="contributing_institution"><H6>Contributing Institution</H6></ifcount>}}}
						{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="contributing_institution" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
						
						{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
						{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
						{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
						
						{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
						{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
						{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name</unit>}}}
						
						{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
						{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}
						
						<div class="map">
							{{{map}}}
						</div>
					</div><!-- end col -->
				</div><!-- end row -->
				<div class="row">
					<div class='col-sm-12 col-md-12 col-lg-12' >
						<hr>
						<?php print $this->getVar("representationViewer"); ?>
				
						<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
						<div id="detailTools">
							<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
							<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
							<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
						</div><!-- end detailTools -->
					</div><!-- end col -->							
				</div><!-- end row -->
</div><!-- end container -->
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