<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$t_lists = new ca_lists();
	$va_video_audio_type_ids = $t_lists->getItemIDsFromList("Root node for object_types", array("moving_image", "sound", "outside_entity_moving_image", "outside_entity_sound"));
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
				{{{<ifdef code="ca_objects.nonpreferred_labels.name"><H4>^ca_objects.nonpreferred_labels.name</H4></ifdef>}}}
				{{{<ifdef code="ca_objects.alt_description.alt_description_text">
					<p>^ca_objects.alt_description.alt_description_text</p>
				</ifdef>}}}				
				<HR/>
<?php
				$va_dates_display = array();
				$va_dates_mentioned = array();
				$va_date_values = $t_object->get("ca_objects.date.dates_value", array("returnAsArray" => true));
				$va_date_types = $t_object->get("ca_objects.date.dc_dates_types", array("returnAsArray" => true, "convertCodesToDisplayText" => true));
				foreach($va_date_types as $vn_i => $vs_type){
					if($va_date_values[$vn_i]){
						if(strpos($vs_type, "mention")){
							$va_dates_mentioned[] = $va_date_values[$vn_i].", ".$vs_type;
						}else{
							$va_dates_display[] = $va_date_values[$vn_i].", ".$vs_type;
						}
					}
				}
				if(is_array($va_dates_display) && sizeof($va_dates_display)){
					print "<H6>Date</H6>";
					print join("<br/>", $va_dates_display); 
				}
				
				print $t_object->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator"><H6>Creator</H6></ifcount>');
				print $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="creator"><l>^ca_entities.preferred_labels.displayname</l></unit>');

				# --- moving image/sound
				if(in_array($t_object->get("ca_objects.type_id"), $va_video_audio_type_ids)){
					print $t_object->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="interviewee"><H6>Interviewee</H6></ifcount>');
					print $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="interviewee"><l>^ca_entities.preferred_labels.displayname</l></unit>');
				
					print $t_object->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="interviewer"><H6>Interviewer</H6></ifcount>');
					print $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="interviewer"><l>^ca_entities.preferred_labels.displayname</l></unit>');				
					
					print $t_object->getWithTemplate('<ifdef code="ca_objects.duration"><H6>Duration</H6>^ca_objects.duration</ifdef>');
				}
				if($this->getVar("map") || $t_object->get("ca_objects.georeference.coverageNotes")){
					print "<H6>Location";
					if(in_array($t_object->get("ca_objects.type_id"), $va_video_audio_type_ids)){
						print " of interview";
					}
					print "</H6>";
				}
				print $this->getVar("map");
				if($t_object->get("ca_objects.georeference.coverageNotes")){
					print "<p>".$t_object->get("ca_objects.georeference.coverageNotes")."</p>";
				}
?>
				
				{{{<ifdef code="ca_objects.language"><H6>Language</H6>^ca_objects.language%delimiter=,_</ifdef>}}}
					
<?php
				if(in_array($t_object->get("ca_objects.type_id"), $va_video_audio_type_ids)){
					if($t_object->get("ca_objects.type_id")){
						print "<H6>Object Type</H6>".$t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true));
					}
				}else{
					if($t_object->get("ca_objects.document_type")){
						print "<H6>Document Type</H6>".$t_object->get("ca_objects.document_type", array("convertCodesToDisplayText" => true));
					}
				}
?>
				
				{{{<ifdef code="ca_objects.number"><H6>Number of Pages</H6>^ca_objects.number</ifdef>}}}
				
				{{{<ifdef code="ca_objects.idno"><H6>Identifier</H6>^ca_objects.idno</ifdef>}}}
				
				<HR/>
				
				{{{<ifdef code="ca_objects.centro_keywords"><H6>Related Keywords</H6>^ca_objects.centro_keywords%delimiter=,_}}}
				
				{{{<ifcount code="ca_objects.lcsh_terms" min="1"><H6>Library of Congress Subject Headings</H6></ifcount>}}}
				{{{<unit delimiter="<br/>">^ca_objects.lcsh_terms</unit>}}}				
<?php			
				print $t_object->getWithTemplate('<ifcount code="ca_entities" excludeRelationshipTypes="interviewee,interviewer,creator" min="1"><H6>Individuals or Organizations Mentioned</H6></ifcount>');
				print $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter=", " excludeRelationshipTypes="interviewee,interviewer,creator"><l>^ca_entities.preferred_labels.displayname</l></unit>');				

				$vs_related_places = $t_object->getWithTemplate("<unit relativeto='ca_places'><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit>", array("checkAccess" => $va_access_values, "delimiter" => ", "));
				if($vs_related_places){
					print "<H6>Related Places</H6>".$vs_related_places;
				}
				if(is_array($va_dates_mentioned) && sizeof($va_dates_mentioned)){
					print "<H6>Related Dates</H6>";
					print join("<br/>", $va_dates_mentioned); 
				}
?>
				{{{<ifdef code="ca_objects.related"><H6>Related Items</H6><unit relativeto="ca_objects.related" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></ifdef>}}}
<?php
				if($t_object->get("ca_objects.external_link.url_entry")){
					print "<H6>Related Links</H6>";
					print $t_object->getWithTemplate("<unit><a href='^ca_objects.external_link.url_entry' target='_blank'>^ca_objects.external_link.url_source</a></unit>", array("delimiter" => "<br/>"));
				}
				if($t_object->get("ca_objects.external_link.url_entry") || $t_object->get("ca_objects.related") || $t_object->get("ca_places", array("checkAccess" => $va_access_values)) || $t_object->get("ca_entities", array("restrictToRelationshipTypes" => array("subject"), "checkAccess" => $va_access_values)) || $t_object->get("ca_objects.LcshNames") || $t_object->get("ca_objects.keyword") || $t_object->get("ca_objects.LcshNames")){
?>				
					<HR/>				
<?php				
				}

				print "<H6>Citation</H6>";
				print (($vs_collection_name) ? $vs_collection_name.". " : "").$t_object->get("ca_objects.preferred_labels.name").": ".$t_object->get("ca_objects.idno").". Center for Puerto Rican Studies Library & Archives, Hunter College, CUNY. Web. ".date("d M Y", time()).".";

				#if($t_object->get("ca_objects.rights.rightsText") || $t_object->get("ca_objects.rights.rightsHolder") || $t_object->get("ca_objects.rights.copyrightStatement")){
					print "<H6>Use Restrictions</H6>";
					if($t_object->get("ca_objects.rights.rightsText")){
						print "<p>".$t_object->get("ca_objects.rights.rightsText")."</p>";
					}else{
						print "Copyright to this resource is held by the Center for Puerto Rican Studies, Library & Archives and is provided here for educational purposes only. It may not be downloaded, reproduced or distributed in any format without written permission of the Center for Puerto Rican Studies, Library & Archives. Any attempt to circumvent the access controls place on this file is a violation of United States and international copyright laws, and is subject to criminal prosecution.";
					}
					if($t_object->get("ca_objects.rights.rightsHolder")){
						print "<H6>Rights Holder</H6> ".$t_object->get("ca_objects.rights.rightsHolder")."<br/>";
					}else{
						# default text 
						print "<H6>Rights Holder</H6> Center for Puerto Rican Studies, Library & Archive<br/>";
					}
					if($t_object->get("ca_objects.rights.copyrightStatement")){
						print "<p>".$t_object->get("ca_objects.rights.copyrightStatement")."</p>";
					}
				#}				
?>
				{{{<ifdef code="ca_objects.repository"><H6>Repository</H6>^ca_objects.repository</ifdef>}}}
				
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