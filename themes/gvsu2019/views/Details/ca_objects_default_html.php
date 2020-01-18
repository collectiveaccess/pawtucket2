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
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print is_array($va_comments) ? sizeof($va_comments) : 0; ?>)</a></div><!-- end detailTool -->
					
				{{{<ifdef code="ca_objects.faculty_responses.faculty_response_text"><H6>Faculty Response:</H6>
					<span class="trimText">^ca_objects.faculty_responses.faculty_response_text</span>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.student_responses.student_response_text"><H6>Student Response:</H6>
					<span class="trimText">^ca_objects.student_responses.student_response_text</span>
				</ifdef>}}}
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
				
				{{{<ifcount code="ca_objects.related" min="1">
				<div class="row"><div class="col-sm-12"><H6>Related Objects</H6><div class="row rowSmallPadding"><unit relativeTo="ca_objects.related" delimiter=" "><div class="col-xs-4 col-md-2 smallpadding"><div class="detailRelObject"><l>^ca_object_representations.media.icon</l></div><!--end detailRelObject--></div><!--end col--></unit></div><!-- end row --></div><!-- end col --></div><!-- end row -->
				</ifcount>}}}
				<div class="row bluebg">	
					<div class="col-sm-12">
						{{{<ifcount code="ca_storage_locations" min="1" max="1"><H6>Current Location:</H6></ifcount>}}}
						{{{<ifcount code="ca_storage_locations" min="2"><H6>Current Location:</H6></ifcount>}}}
						{{{<unit relativeTo="ca_storage_locations" delimiter="<br/>"><l>^ca_storage_locations.parent.preferred_labels</l></unit>}}}
						{{{<unit relativeTo="ca_storage_locations" delimiter="<br/>"> -> <l>^ca_storage_locations.preferred_labels</l></unit>}}}
				
						{{{<ifdef code="ca_objects.storage_location_notes"><H6>Location Notes:</H6>^ca_objects.storage_location_notes<br/></ifdef>}}}
				
						{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
						{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
						{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
		
						{{{map}}} <br/>
					</div>
				</div>	
			</div><!-- end left col -->
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<div class="blue">
					<div class="row">
						<div class="col-sm-6">
						{{{<ifdef code="ca_objects.idno"><H6>Identifier:</H6>^ca_objects.idno</ifdef>}}}
						{{{<ifdef code="ca_objects.containerID"><H6>Box/series:</H6>^ca_objects.containerID<br/></ifdef>}}}
				
						{{{<ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="creator,attributor"><H6>Artist:</H6></ifcount>}}}
						{{{<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="creator,attributor"><H6>Related artists</H6></ifcount>}}}
						{{{<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator,attributor"><l>^ca_entities.preferred_labels.displayname</l></unit><br/>}}}
						
						</div>
						<div class="col-sm-6">
						{{{<ifdef code="ca_objects.work_medium"><H6>Medium:</H6>^ca_objects.work_medium</ifdef>}}}
				
						{{{<ifdef code="ca_objects.work_date"><H6>Date:</H6>^ca_objects.work_date<br/></ifdef>}}}
						</div>
					</div>
				</div>
				{{{<ifdef code="ca_objects.dimensions"><H6>Dimensions:</H6></ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions.height">^ca_objects.dimensions.dimension_type - Height: ^ca_objects.dimensions.height</ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions.width">Width: ^ca_objects.dimensions.width</ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions.depth">Depth: ^ca_objects.dimensions.depth</ifdef><br/>}}}		
				{{{<ifdef code="ca_objects.dimensions.dimensions_notes">Note: ^ca_objects.dimensions.dimensions_notes</ifdef>}}}		
				
				{{{<ifdef code="ca_objects.work_description"><H6>Description:</H6>
					<span class="trimText">^ca_objects.work_description</span>
				</ifdef>}}}
				

				
				{{{<ifdef code="ca_objects.historical_context"><H6>Historical Context:</H6>
					<span class="trimText">^ca_objects.historical_context</span><br/>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.wikipedia" ><H6>Wikipedia Summary:</H6>
					<span class="trimText">^ca_objects.wikipedia.abstract</span><span><a href="^ca_objects.wikipedia.fullurl">^ca_objects.wikipedia.fullurl</a></span>
				</ifdef>}}}
				
				{{{<ifcount code="ca_object_lots" min="1" max="1"><H6>Credit:</H6></ifcount>}}}
				{{{<ifcount code="ca_object_lots" min="2"><H6>Credit:</H6></ifcount>}}}
				{{{<unit relativeTo="ca_object_lots" delimiter="<br/>"><l>^ca_object_lots.credit_line</l></unit><br/>}}}
				<div class="row">
					<div class="col-sm-6">				
<?php
						if($va_subjects = $t_object->get("ca_list_items", array("returnAsArray" => true, 'returnWithStructure' => true))){
							if(is_array($va_subjects) && sizeof($va_subjects)){
								# --- loop through to order alphebeticaly
								$va_subjects_sorted = array();
								$t_list_item = new ca_list_items();
								foreach($va_subjects as $va_subject){
									$t_list_item->load($va_subject["item_id"]);
									$va_subjects_sorted[$va_subject["name_singular"]] = caNavLink($this->request, $va_subject["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_subject["item_id"]));
								}
								ksort($va_subjects_sorted);
								print "<H6>Getty Art and Architecture Thesaurus Term".((sizeof($va_subjects) > 1) ? "s" : "").":</H6>";
								print join($va_subjects_sorted, "<br/>");
							}
						}		
?>
					</div>
					<div class="col-sm-6">				
<?php						
						$va_lcsh_terms = $t_object->get("ca_objects.lcsh", array("returnAsArray" => true, 'returnWithStructure' => true));
				
						if(sizeof($va_lcsh_terms)){
							print "<H6>Library of Congress Subjects:</H6>";
							$va_terms = array();
							foreach($va_lcsh_terms as $va_lcsh_term){
								$va_lcsh_term = array_shift($va_lcsh_term);
								$vs_lcsh_term = $va_lcsh_term["lcsh"];
								$vn_chop = stripos($vs_lcsh_term, "[");
								$vs_lcsh_term = ($vn_chop) ? substr($vs_lcsh_term, 0, $vn_chop) : $vs_lcsh_term;
								$va_terms[] = caNavLink($this->request, $vs_lcsh_term, "", "", "MultiSearch", "Index", array("search" => urlencode($vs_lcsh_term)));
							}
							print join($va_terms, "<br/>");
						}
				
?>				
					</div>
				</div>			
		
			</div><!-- end col -->
		</div><!-- end row -->	
		</div><!-- end container -->
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
		  maxHeight: 150
		});
	});
</script>