<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = caGetUserAccessValues($this->request);
	$t_lists = new ca_lists();
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

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{^ca_objects.preferred_labels.name}}}</H4>
				<?php
				
				if($t_object->get("ca_objects.date")){
					print $t_object->get("ca_objects.date")."<br/>";
				}
				
				$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("author"), "checkAccess" => $va_access_values, "sort" => "ca_entities.preferred_labels.name"));
				if(sizeof($va_entities)){
					print "<H6>Author</H6>";
					foreach($va_entities as $va_entity){
						print caDetailLink($this->request, $va_entity["displayname"], "", "ca_entities", $va_entity["entity_id"])."<br/>";
					}
				}
				
				$va_collections = $t_object->get("ca_collections", array("returnWithStructure" => true, "restrictToTypes" => array("publication"), "checkAccess" => $va_access_values, "sort" => "ca_collections.preferred_labels.name"));
				if(sizeof($va_collections)){
					print "<H6>Publication category</H6>";
					foreach($va_collections as $va_collection){
						print caDetailLink($this->request, $va_collection["name"], "", "ca_collections", $va_collection["collection_id"])."<br/>";
					}
				}
?>
				<HR/>
<?php								
				$va_publications = $t_object->get("ca_objects.related", array("returnWithStructure" => true, "restrictToTypes" => array("publication"), "checkAccess" => $va_access_values, "sort" => "ca_objects.preferred_labels.name"));
				if(sizeof($va_publications)){
					print "<H6>Related Publications</H6>";
					foreach($va_publications as $va_publication){
						print caDetailLink($this->request, $va_publication["name"], "", "ca_objects", $va_publication["object_id"])."<br/>";
					}
				}
				
				$va_artworks = $t_object->get("ca_objects.related", array("returnWithStructure" => true, "restrictToTypes" => array("artwork"), "checkAccess" => $va_access_values, "sort" => "ca_objects.preferred_labels.name"));
				if(sizeof($va_artworks)){
					print "<H6>Related Artworks</H6>";
					foreach($va_artworks as $va_artwork){
						print caDetailLink($this->request, $va_artwork["name"], "", "ca_objects", $va_artwork["object_id"])."<br/>";
					}
				}
				
				$va_events = $t_object->get("ca_occurrences", array("returnWithStructure" => true, "restrictToTypes" => array("event"), "checkAccess" => $va_access_values, "sort" => "ca_occurrences.preferred_labels.name"));
				if(sizeof($va_events)){
					print "<H6>Related Events</H6>";
					foreach($va_events as $va_event){
						print caDetailLink($this->request, $va_event["name"], "", "ca_occurrences", $va_event["occurrence_id"])."<br/>";
					}
				}
				
				if($t_object->get("ca_objects.publication_url")){
					print "<H6>Doi</H6>".$t_object->get("ca_objects.publication_url")."<br/>";
				}
				
				if($t_object->get("ca_objects.reference")){
					print "<H6>Reference</H6>".$t_object->get("ca_objects.reference")."<br/>";
				}
?>
				<HR/>

				{{{<ifdef code="ca_objects.idno"><H6>Publication Identifier</H6>^ca_objects.idno</ifdef>}}}			

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