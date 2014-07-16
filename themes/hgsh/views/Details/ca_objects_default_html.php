<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = $this->getVar("access_values");
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
				<?php print "<p style='clear:both;'>".caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel"))."</p>"; ?>	
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
				
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.containerID"><H6>Box/series:</H6>^ca_objects.containerID<br/></ifdef>}}}				
				
				{{{<ifdef code="ca_objects.description">
					<span class="trimText">^ca_objects.description</span>
				</ifdef>}}}			
<?php
					$t_object_thumb = new ca_objects();
					$va_entities = $t_object->get("ca_entities", array("returnAsArray" => true, "checkAccess" => $va_access_values));
					if(sizeof($va_entities)){
						if(sizeof($va_entities) == 1){
							print "<H6>Related person/organisation</H6>";
						}else{
							print "<H6>Related people/organisations</H6>";
						}
						$t_rel_entity = new ca_entities();
						foreach($va_entities as $va_entity){
							$t_rel_entity->load($va_entity["entity_id"]);
							$t_object_thumb->load($t_rel_entity->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
							$vs_thumb = $t_object_thumb->get("ca_object_representations.media.icon", array("checkAccess" => $va_access_values));
							if($vs_thumb){
								print "<div class='row'><div class='col-sm-3 col-md-3 col-lg-3'>".$vs_thumb."</div>\n";
								print "<div class='col-sm-9 col-md-9 col-lg-9'>\n";
							}
							print $t_rel_entity->getWithTemplate("<b><l>^ca_entities.preferred_labels.displayname</l></b>");
							if($vs_brief_description = $t_rel_entity->get("ca_entities.brief_description")){
								print "<br/>".$vs_brief_description;
							}
							if($vs_thumb){
								print "</div></div><!-- end row -->";
							}else{
								print "<br/>";
							}
							print "<br/>";
						}
					}
					$va_collections = $t_object->get("ca_collections", array("returnAsArray" => true, "checkAccess" => $va_access_values));
					if(sizeof($va_collections)){
						print "<H6>Related collection".((sizeof($va_collections) > 1) ? "s" : "")."</H6>";
						$t_rel_collection = new ca_collections();
						foreach($va_collections as $va_collection){
							$t_rel_collection->load($va_collection["collection_id"]);
							$t_object_thumb->load($t_rel_collection->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
							$vs_thumb = $t_object_thumb->get("ca_object_representations.media.icon", array("checkAccess" => $va_access_values));
							if($vs_thumb){
								print "<div class='row'><div class='col-sm-3 col-md-3 col-lg-3'>".$vs_thumb."</div>\n";
								print "<div class='col-sm-9 col-md-9 col-lg-9'>\n";
							}
							print $t_rel_collection->getWithTemplate("<b><l>^ca_collections.preferred_labels.name</l></b>");
							if($vs_brief_description = $t_rel_collection->get("ca_collections.brief_description")){
								print "<br/>".$vs_brief_description;
							}
							if($vs_thumb){
								print "</div></div><!-- end row -->";
							}else{
								print "<br/>";
							}
							print "<br/>";
						}
					}
					$va_places = $t_object->get("ca_places", array("returnAsArray" => true, "checkAccess" => $va_access_values));
					if(sizeof($va_places)){
						print "<H6>Related place".((sizeof($va_places) > 1) ? "s" : "")."</H6>";
						$t_rel_place = new ca_places();
						foreach($va_places as $va_place){
							$t_rel_place->load($va_place["place_id"]);
							$t_object_thumb->load($t_rel_place->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
							$vs_thumb = $t_object_thumb->get("ca_object_representations.media.icon", array("checkAccess" => $va_access_values));
							if($vs_thumb){
								print "<div class='row'><div class='col-sm-3 col-md-3 col-lg-3'>".$vs_thumb."</div>\n";
								print "<div class='col-sm-9 col-md-9 col-lg-9'>\n";
							}
							print $t_rel_place->getWithTemplate("<b><l>^ca_places.preferred_labels.name</l></b>");
							if($vs_brief_description = $t_rel_place->get("ca_places.brief_description")){
								print "<br/>".$vs_brief_description;
							}
							if($vs_thumb){
								print "</div></div><!-- end row -->";
							}else{
								print "<br/>";
							}
							print "<br/>";
						}
					}
					$va_occurrences = $t_object->get("ca_occurrences", array("returnAsArray" => true, "checkAccess" => $va_access_values));
					if(sizeof($va_occurrences)){
						print "<H6>Related event".((sizeof($va_occurrences) > 1) ? "s" : "")."</H6>";
						$t_rel_occurrence = new ca_occurrences();
						foreach($va_occurrences as $va_occurrence){
							$t_rel_occurrence->load($va_occurrence["occurrence_id"]);
							$t_object_thumb->load($t_rel_occurrence->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("cover"), "checkAccess" => $va_access_values)));
							$vs_thumb = $t_object_thumb->get("ca_object_representations.media.icon", array("checkAccess" => $va_access_values));
							if($vs_thumb){
								print "<div class='row'><div class='col-sm-3 col-md-3 col-lg-3'>".$vs_thumb."</div>\n";
								print "<div class='col-sm-9 col-md-9 col-lg-9'>\n";
							}
							print $t_rel_occurrence->getWithTemplate("<b><l>^ca_occurrences.preferred_labels.name</l></b>");
							if($vs_brief_description = $t_rel_occurrence->get("ca_occurrences.brief_description")){
								print "<br/>".$vs_brief_description;
							}
							if($vs_thumb){
								print "</div></div><!-- end row -->";
							}else{
								print "<br/>";
							}
							print "<br/>";
						}
					}
					
?>				
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