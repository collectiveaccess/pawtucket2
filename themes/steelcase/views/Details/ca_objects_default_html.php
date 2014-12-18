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
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{^ca_objects.preferred_labels.name<ifdef code="ca_objects.creation_date">, ^ca_objects.creation_date</ifdef>}}}</H4>
<?php
				$va_entities = $t_object->get("ca_entities", array("returnAsArray" => true, "restrictToRelationshipTypes" => array("creator"), "checkAccess" => $va_access_values));
				if(sizeof($va_entities)){
					$t_entity = new ca_entities();
					print "<H5>";
					foreach($va_entities as $va_entity){
						$t_entity->load($va_entity["entity_id"]);
						print caDetailLink($this->request, $t_entity->getLabelForDisplay(), "", "ca_entities", $t_entity->get("entity_id"));
						$vs_nationality = trim($t_entity->get("nationality", array("delimiter" => "; ", "convertCodesToDisplayText" => true)));
						$vs_dob = $t_entity->get("dob_dod");
						if($vs_nationality || $vs_dob){
							print " (".$vs_nationality;
							if($vs_nationality && $vs_dob){
								print ", ";
							} 
							print $vs_dob.")";
						}
						print "<br/>";
					}
					print "</H5>";
				}
?>
				<HR/>
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
						print join(" x ", $va_dimension_pieces);
					}
				}
?>				
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
						print join(" x ", $va_dimension_pieces);
					}
				}
				
				if($va_materials = $t_object->get("ca_objects.material", array("returnAsArray" => true, "convertCodesToDisplayText" => false))){
					print "<H6>"._t("Material")."</H6>";
					$i = 0;
					foreach($va_materials as $vn_material_id => $va_material){
						$i++;
						$vs_material = $t_lists->getItemFromListForDisplayByItemID("material", $va_material["material"]);
						print caNavLink($this->request, $vs_material, "", "", "Browse", "Objects", array("facet" => "material_facet", "id" => $va_material["material"]));
						if($i < sizeof($va_materials)){
							print ", ";
						}
					}
				}
?>
				{{{<ifdef code="ca_objects.credit_line"><H6>Credit</H6>&copy; ^ca_objects.credit_line</ifdef>}}}
				{{{<ifdef code="ca_objects.description"><H6>Description</H6>^ca_objects.description</ifdef>}}}
<?php				
				if(trim($t_object->get("ca_objects.dimensions_frame.display_dimensions_frame")) || $t_object->get("ca_objects.dimensions_frame.dimensions_frame_height") || $t_object->get("ca_objects.dimensions.dimensions_height") || trim($t_object->get("ca_objects.dimensions.display_dimensions")) || trim($t_object->get("ca_objects.material")) || trim($t_object->get("description")) || trim($t_object->get("credit_line"))){
					print "<HR/>";
				}
				if($va_styles = $t_object->get("ca_objects.styles_movement", array("returnAsArray" => true, "convertCodesToDisplayText" => false))){
					$vs_style_display = "";
					$i = 0;
					foreach($va_styles as $vn_style_id => $va_style){
						$i++;
						$vs_style_movement = $t_lists->getItemFromListForDisplayByItemID("styles_movement", $va_style["styles_movement"]);
						if(trim($vs_style_movement)){
							$vs_style_display .= caNavLink($this->request, $vs_style_movement, "", "", "Browse", "Objects", array("facet" => "styles_movement_facet", "id" => $va_style["styles_movement"]));
							if($i < sizeof($va_styles)){
								$vs_style_display .= ", ";
							}
						}
					}
					if($vs_style_display){
						print "<H6>"._t("Style/Movement")."</H6>";
						print $vs_style_display;
					}
				}
?>				
				{{{<ifcount code='ca_collections' min='1' max='1'><H6>Collection</H6></ifcount>}}}{{{<ifcount code='ca_collections' min='2'><H6>Collections</H6></ifcount>}}}{{{<unit relativeTo='ca_collections' delimiter='<br/>'><l>^ca_collections.preferred_labels.name</l></unit>}}}
<?php				
				if($va_themes = $t_object->get("ca_objects.steelcase_themes", array("returnAsArray" => true, "convertCodesToDisplayText" => false))){
					$i = 0;
					$vs_theme_display = "";
					foreach($va_themes as $vn_theme_id => $va_theme){
						$i++;
						$vs_theme = $t_lists->getItemFromListForDisplayByItemID("custom_subject", $va_theme["steelcase_themes"]);
						if(trim($vs_theme)){
							$vs_theme_display .= caNavLink($this->request, $vs_theme, "", "", "Browse", "Objects", array("facet" => "theme_facet", "id" => $va_theme["steelcase_themes"]));
							if($i < sizeof($va_themes)){
								$vs_theme_display .= ", ";
							}
						}
					}
					if($vs_theme_display){
						print "<H6>"._t("Themes")."</H6>";
						print $vs_theme_display;
					}
				}
				if($vs_style_display || $vs_theme_display || $t_object->get("ca_collections")){
					print "<HR/>";
				}
?>
				{{{<ifdef code="ca_objects.idno"><H6>Steelcase Number</H6>^ca_objects.idno</ifdef>}}}			
<?php
				$va_storage_locations = $t_object->get("ca_storage_locations", array("returnAsArray" => true, "checkAccess" => $va_access_values));
				if(sizeof($va_storage_locations)){
					$t_location = new ca_storage_locations();
					$t_relationship = new ca_objects_x_storage_locations();
					$vn_now = date("Y.md");
					$va_location_display = array();
					foreach($va_storage_locations as $va_storage_location){
						$t_relationship->load($va_storage_location["relation_id"]);
						$va_daterange = $t_relationship->get("storage_daterange", array("rawDate" => true, "returnAsArray" => true));
						if(is_array($va_daterange) && sizeof($va_daterange)){
							foreach($va_daterange as $va_date){
								break;
							}
							#print $vn_now." - ".$va_date["storage_daterange"]["start"]." - ".$va_date["storage_daterange"]["end"];
							if(is_array($va_date)){
								if(($vn_now > $va_date["storage_daterange"]["start"]) && ($vn_now < $va_date["storage_daterange"]["end"])){
									# --- only display the top level from the hierarchy
									$va_hierarchy_ancestors = array_reverse(caExtractValuesByUserLocale($t_location->getHierarchyAncestors($va_storage_location["location_id"], array("additionalTableToJoin" => "ca_storage_location_labels", "additionalTableSelectFields" => array("name")))));
									foreach($va_hierarchy_ancestors as $va_ancestor){
										$va_location_display[] = $va_ancestor["name"];
										break;
									}
								}
							}
						}else{
							# --- only display the top level from the hierarchy
							$va_hierarchy_ancestors = array_reverse(caExtractValuesByUserLocale($t_location->getHierarchyAncestors($va_storage_location["location_id"], array("additionalTableToJoin" => "ca_storage_location_labels", "additionalTableSelectFields" => array("name")))));
							foreach($va_hierarchy_ancestors as $va_ancestor){
								$va_location_display[] = $va_ancestor["name"];
								break;
							}
							#$vs_location_display .= $va_storage_location["name"]."<br/>";
						}
					}
					if(sizeof($va_location_display)){
						print "<H6>Location</H6>".join(", ", $va_location_display);
					}
				}
				if($vs_location_display || $t_object->get("ca_objects.idno")){
					print "<HR/>";
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