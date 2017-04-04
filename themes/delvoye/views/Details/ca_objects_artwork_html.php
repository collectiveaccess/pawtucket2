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
				
				if($t_object->get("ca_objects.nonpreferred_labels")){
					print "<H6>Alternative name</H6> ".$t_object->get("ca_objects.nonpreferred_labels.name")."<br/>";
				}
?>
				<HR/>
<?php				
				if($t_object->get("ca_objects.work_dimensions")){
					print "<H6>Dimensions</H6>";?>
					{{{<table style="text-align: left; display: inline;">
						<unit relativeTo="ca_objects.work_dimensions">
							<tr>
								<td valign="top" style="text-transform: capitalize;">^ca_objects.work_dimensions.dimensions_type : </td>
								<td><ifdef code="ca_objects.work_dimensions.dimensions_length">Length: ^ca_objects.work_dimensions.dimensions_length<br/></ifdef>
									<ifdef code="ca_objects.work_dimensions.dimensions_width">Width: ^ca_objects.work_dimensions.dimensions_width<br/></ifdef>
									<ifdef code="ca_objects.work_dimensions.dimensions_height">Height: ^ca_objects.work_dimensions.dimensions_height<br/></ifdef>
									<ifdef code="ca_objects.work_dimensions.dimensions_diameter">Diameter: ^ca_objects.work_dimensions.dimensions_diameter<br/></ifdef>
									<ifdef code="ca_objects.work_dimensions.dimensions_weight">Weight: ^ca_objects.work_dimensions.dimensions_weight </ifdef></td>
							</tr>
						</unit>
						</table>}}}
		<?php	}
				
				$va_collections = $t_object->get("ca_collections", array("returnWithStructure" => true, "restrictToTypes" => array("object_category"), "checkAccess" => $va_access_values, "sort" => "ca_collections.preferred_labels.name"));
				if(sizeof($va_collections)){
					print "<H6>Object category</H6>";
					foreach($va_collections as $va_collection){
						print caDetailLink($this->request, $va_collection["name"], "", "ca_collections", $va_collection["collection_id"])."<br/>";
					}
				}
				
				if($t_object->get("ca_objects.alternate_number")){
					print "<H6>NUMBER</H6>".$t_object->get("ca_objects.alternate_number")."<br/>";
				}
				
				if($t_object->get("ca_objects.edition_c.edition_text")){
					print "<H6>EDITION</H6>".$t_object->get("ca_objects.edition_c.edition_text")."<br/>";
				}
				
				$va_collections = $t_object->get("ca_collections", array("returnWithStructure" => true, "restrictToTypes" => array("artwork_category"), "checkAccess" => $va_access_values, "sort" => "ca_collections.preferred_labels.name"));
				if(sizeof($va_collections)){
					print "<H6>Collections</H6>";
					foreach($va_collections as $va_collection){
						print caDetailLink($this->request, $va_collection["name"], "", "ca_collections", $va_collection["collection_id"])."<br/>";
					}
				}
				
				$va_collections = $t_object->get("ca_collections", array("returnWithStructure" => true, "restrictToTypes" => array("keyword"), "checkAccess" => $va_access_values, "sort" => "ca_collections.preferred_labels.name"));
				if(sizeof($va_collections)){
					print "<H6>Keywords</H6>";
					foreach($va_collections as $va_collection){
						print caDetailLink($this->request, $va_collection["name"], "", "ca_collections", $va_collection["collection_id"])."<br/>";
					}
				}
?>
				<HR/>
<?php				
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
				
				$va_publications = $t_object->get("ca_objects.related", array("returnWithStructure" => true, "restrictToTypes" => array("publication"), "checkAccess" => $va_access_values, "sort" => "ca_objects.preferred_labels.name"));
				if(sizeof($va_publications)){
					print "<H6>Related Publications</H6>";
					foreach($va_publications as $va_publication){
						print caDetailLink($this->request, $va_publication["name"], "", "ca_objects", $va_publication["object_id"])."<br/>";
					}
				}
?>
				<HR/>

				{{{<ifdef code="ca_objects.idno"><H6>Object Identifier</H6>^ca_objects.idno</ifdef>}}}			

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