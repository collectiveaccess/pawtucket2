<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$t_lists = new ca_lists();
	$va_video_audio_type_ids = $t_lists->getItemIDsFromList("Root node for object_types", array("moving_image", "sound"));
	$va_access_values = caGetUserAccessValues($this->request);
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
			<div class='col-sm-6'>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				<div id="detailTools">
<?php
				if($this->getVar("commentsEnabled")){
?>

					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'><?php print $this->getVar("itemComments"); ?></div><!-- end itemComments -->
<?php
				}
?>
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			
			<div class='col-sm-6'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				{{{<ifdef code="ca_objects.nonpreferred_labels.name"><H4>^ca_objects.nonpreferred_labels.name</H4></ifdef>}}}
<?php
	$vn_collection_id = $t_object->get("ca_collections.collection_id");
	$vs_collection_name = "";
	if($vn_collection_id){
		$t_collection = new ca_collections();
		$va_root_collection = array_pop($t_collection->getHierarchyAncestors($vn_collection_id, array('includeSelf' => true, 'additionalTableToJoin' => 'ca_collection_labels', 'additionalTableSelectFields' => array("name"), 'additionalTableWheres' => array("ca_collection_labels.is_preferred = 1"))));
		if(is_array($va_root_collection) && sizeof($va_root_collection)){
			$vs_collection_name = $va_root_collection["NODE"]["name"];
			$vs_collection_link = caDetailLink($this->request, $va_root_collection["NODE"]["name"], '', 'ca_collections', $va_root_collection['NODE']['collection_id']);
			print "<p>".$vs_collection_link."</p>";
		}
	}

?>
				{{{<ifdef code="ca_objects.description.description_text">
					<p>^ca_objects.description.description_text</p>
				</ifdef>}}}	
				{{{<ifdef code="ca_objects.alt_description.alt_description_text">
					<p>^ca_objects.alt_description.alt_description_text</p>
				</ifdef>}}}				
				<HR/>
<?php
				#if($t_object->get("ca_objects.date.date") || $t_object->get("ca_objects.date.dates_value")){
				if($t_object->get("ca_objects.date.dates_value")){
					print "<H6>Date</H6>";
					$va_date_parts = array();
					#if($t_object->get("ca_objects.date.date")){
					#	$va_date_parts[] = $t_object->get("ca_objects.date.date");
					#} removed this when Julia cleaned up date configuration in feb 2016
					if($t_object->get("ca_objects.date.dates_value")){
						$va_date_parts[] = $t_object->get("ca_objects.date.dates_value");
					}
					if($vs_date_type = $t_object->get("ca_objects.date.dc_dates_types", array("convertCodesToDisplayText" => true))){
						if($vs_date_type != "-"){
							$va_date_parts[] = $t_object->get("ca_objects.date.dc_dates_types", array("convertCodesToDisplayText" => true));
						}
					}
					print join(", ", $va_date_parts)."<br/>";
				}
				
				if(in_array($t_object->get("ca_objects.type_id"), $va_video_audio_type_ids)){
					print $t_object->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="interviewee"><H6>Interviewee</H6></ifcount>');
					print $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="interviewee"><l>^ca_entities.preferred_labels.displayname</l></unit>');
					
					print $t_object->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="interviewer"><H6>Interviewer</H6></ifcount>');
					print $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="interviewer"><l>^ca_entities.preferred_labels.displayname</l></unit>');
					
					print $t_object->getWithTemplate('<ifdef code="ca_objects.duration"><H6>Duration</H6>^ca_objects.duration</ifdef>');
					
					#print $t_object->getWithTemplate('<ifdef code="ca_objects.georeference.coverageNotes"><H6>Location of Interview</H6>^ca_objects.georeference.coverageNotes</ifdef>');
					print $t_object->getWithTemplate('<ifcount code="ca_places" min="1" restrictToRelationshipTypes="interview_location"><H6>Location of Interview</H6></ifcount>');
					print $t_object->getWithTemplate('<unit relativeTo="ca_places" delimiter=", " restrictToRelationshipTypes="interview_location"><l>^ca_places.preferred_labels.name</l></unit>');
					
				}else{

					$t_object->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator"><H6>Creator</H6></ifcount>');
					$t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="creator"><l>^ca_entities.preferred_labels.displayname</l></unit>');

					$t_object->getWithTemplate('<ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="contributor"><H6>Contributor</H6></ifcount>');
					$t_object->getWithTemplate('<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="contributor"><H6>Contributors</H6></ifcount>');
					$t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="contributor"><l>^ca_entities.preferred_labels.displayname</l></unit>');

					if($this->getVar("map") || $t_object->get("ca_objects.georeference.coverageNotes")){
						print "<H6>Location</H6>";
					}
					print $this->getVar("map");
					if($t_object->get("ca_objects.georeference.coverageNotes")){
						print "<p>".$t_object->get("ca_objects.georeference.coverageNotes")."</p>";
					}
				}
?>
				
				{{{<ifdef code="ca_objects.language"><H6>Language</H6>^ca_objects.language%delimiter=,_</ifdef>}}}
					
				{{{<ifdef code="ca_objects.type_id"><H6>Object Type</H6>^ca_objects.type_id</ifdef>}}}
				{{{<ifdef code="ca_objects.text_format">, ^ca_objects.text_format</ifdef>}}}
				{{{<ifdef code="ca_objects.document_format">, ^ca_objects.document_format</ifdef>}}}
				{{{<ifdef code="ca_objects.image_format">, ^ca_objects.image_format</ifdef>}}}
				{{{<ifdef code="ca_objects.audio_format">, ^ca_objects.audio_format</ifdef>}}}
				{{{<ifdef code="ca_objects.video_format">, ^ca_objects.video_format</ifdef>}}}
				<br/>
				
				{{{<ifdef code="ca_objects.resource_type"><H6>Resource type</H6>^ca_objects.resource_type<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.number"><H6>Number of pages</H6>^ca_objects.number</ifdef>}}}
				
				{{{<ifdef code="ca_objects.idno"><H6>Identifier</H6>^ca_objects.idno</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.repository"><H6>Repository</H6>^ca_objects.repository</ifdef>}}}
<?php
				print "<H6>Citation</H6>";
				print (($vs_collection_name) ? $vs_collection_name.". " : "").$t_object->get("ca_objects.preferred_labels.name").": ".$t_object->get("ca_objects.idno").". Archives of the Puerto Rican Diaspora. Centro de Estudios Puertorriqueños, Hunter College, CUNY. Web. ".date("d M Y", time()).".";

				if($t_object->get("ca_objects.rights.rightsText") || $t_object->get("ca_objects.rights.rightsHolder") || $t_object->get("ca_objects.rights.copyrightStatement")){
					print "<H6>Use Restrictions</H6>";
					if($t_object->get("ca_objects.rights.rightsText")){
						print "<p>".$t_object->get("ca_objects.rights.rightsText")."</p>";
					}
					if($t_object->get("ca_objects.rights.rightsHolder")){
						print "<b>Rights Holder:</b> ".$t_object->get("ca_objects.rights.rightsHolder")."<br/>";
					}
					if($t_object->get("ca_objects.rights.copyrightStatement")){
						print "<p>".$t_object->get("ca_objects.rights.copyrightStatement")."</p>";
					}
				}				
?>
				<HR/>
				{{{<ifdef code="ca_objects.keyword"><H6>Related Keywords</H6>^ca_objects.keyword%delimiter=,_}}}
				
				{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>Library of Congress Subject Headings</H6></ifcount>}}}
				{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
				
				{{{<ifdef code="ca_objects.unitDate"><H6>Dates Mentioned</H6><unit delimiter="<br/>">^ca_objects.unitDate.date_value, ^ca_objects.unitDate.dates_types</unit></ifdef>}}}
					
<?php			
				print $t_object->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="subject"><H6>Individuals or Organizations Mentioned</H6></ifcount>');
				print $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="subject"><l>^ca_entities.preferred_labels.displayname</l></unit>');
					
				
?>
				{{{<ifdef code="ca_objects.time_period"><H6>Dates Mentioned</H6><unit delimiter="<br/>">^ca_objects.time_period</unit></ifdef>}}}
<?php
				if(in_array($t_object->get("ca_objects.type_id"), $va_video_audio_type_ids)){
					print $t_object->getWithTemplate('<ifcount code="ca_places" min="1" restrictToRelationshipTypes="is_referenced"><H6>Places Mentioned</H6></ifcount>');
					print $t_object->getWithTemplate('<unit relativeTo="ca_places" delimiter=", " restrictToRelationshipTypes="is_referenced"><l>^ca_places.preferred_labels.name</l></unit>');
					
				}else{
					$vs_related_places = $t_object->getWithTemplate("<unit relativeto='ca_places'><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit>", array("checkAccess" => $va_access_values, "delimiter" => ", "));
					if($vs_related_places){
						print "<H6>Related Places</H6>".$vs_related_places;
					}
				}
?>
				{{{<ifdef code="ca_objects.related"><H6>Related Items</H6><unit relativeto="ca_objects.related" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></ifdef>}}}
<?php
				if($t_object->get("external_link")){
					print "<H6>Related Links</H6>";
					print $t_object->getWithTemplate("<unit><a href='^ca_objects.external_link.url_entry' target='_blank'>^ca_objects.external_link.url_source</a></unit>", array("delimiter" => "<br/>"));
				}
?>
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