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
				<H4>{{{^ca_objects.preferred_labels.name}}}<?php
				if($t_object->get("ca_objects.creation_date")){
					print ", ";
					if(strtolower($t_object->get("ca_objects.creation_date")) == "unknown"){
						print "Date ".$t_object->get("ca_objects.creation_date");
					}else{
						print $t_object->get("ca_objects.creation_date");
					}
				}
?>
				</H4>
<?php
				$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("creator"), "checkAccess" => $va_access_values));
				if(sizeof($va_entities)){
					$t_entity = new ca_entities();
					print "<H5>";
					foreach($va_entities as $va_entity){
						$t_entity->load($va_entity["entity_id"]);
						print caDetailLink($this->request, $t_entity->getLabelForDisplay(), "", "ca_entities", $t_entity->get("entity_id"));
						$vs_nationality = trim($t_entity->get("nationality", array("delimiter" => "; ", "convertCodesToDisplayText" => true)));
						$vs_dob = $t_entity->get("dob_dod");
						if(strtolower($vs_dob) == "unknown"){
							$vs_dob = "";
						}
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
<?php
				$va_classification_links = array();
				$t_list_item = new ca_list_items();
				$va_decorative_types = $t_object->get("ca_objects.decorative_types", array("returnWithStructure" => true));
				if(sizeof($va_decorative_types)){
					foreach($va_decorative_types as $va_decorative_type){
						$vn_decorative_type = $va_decorative_type["decorative_types"];
						$t_list_item->load($vn_decorative_type);
						if(trim($t_list_item->get("ca_list_item_labels.name_singular"))){
							$va_classification_links[] = caNavLink($this->request, $t_list_item->get("ca_list_item_labels.name_singular"), "", "", "Browse", "Objects", array("facet" => "decorative_types_facet", "id" => $vn_decorative_type));
						}
					}
					if(sizeof($va_classification_links)){
						print "<H6>Classification</H6>";
						print join(", ", $va_classification_links);
					}
				}
				$va_documentation_types = $t_object->get("ca_objects.documentation_types", array("returnWithStructure" => true));
				if(sizeof($va_documentation_types)){
					foreach($va_documentation_types as $va_documentation_type){
						$vn_documentation_type = $va_documentation_type["documentation_types"];
						$t_list_item->load($vn_documentation_type);
						if(trim($t_list_item->get("ca_list_item_labels.name_singular"))){
							$va_classification_links[] = caNavLink($this->request, $t_list_item->get("ca_list_item_labels.name_singular"), "", "", "Browse", "Objects", array("facet" => "documentation_types_facet", "id" => $vn_documentation_type));
						}
					}
					if(sizeof($va_classification_links)){
						print "<H6>Classification</H6>";
						print join(", ", $va_classification_links);
					}
				}
				$va_fine_art_types = $t_object->get("ca_objects.fine_art_types", array("returnWithStructure" => true));
				if(sizeof($va_fine_art_types)){
					foreach($va_fine_art_types as $va_fine_art_type){
						$vn_fine_art_type = $va_fine_art_type["fine_art_types"];
						$t_list_item->load($vn_fine_art_type);
						if(trim($t_list_item->get("ca_list_item_labels.name_singular"))){
							$va_classification_links[] = caNavLink($this->request, $t_list_item->get("ca_list_item_labels.name_singular"), "", "", "Browse", "Objects", array("facet" => "fine_art_types_facet", "id" => $vn_fine_art_type));
						}
					}
					if(sizeof($va_classification_links)){
						print "<H6>Classification</H6>";
						print join(", ", $va_classification_links);
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
						print join(" x ", $va_dimension_pieces);
					}
					if($t_object->get("ca_objects.dimensions_frame.dimensions_frame_weight")){
						print " ".$t_object->get("ca_objects.dimensions_frame.dimensions_frame_weight");
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
					if($t_object->get("ca_objects.dimensions.dimensions_weight")){
						print " ".$t_object->get("ca_objects.dimensions.dimensions_weight");
					}
				}
				
				if($va_materials = $t_object->get("ca_objects.material", array("returnWithStructure" => true, "convertCodesToDisplayText" => false))){
					$i = 0;
					$va_materials_display = array();
					foreach($va_materials as $vn_material_id => $va_material){
						$vs_material = $t_lists->getItemFromListForDisplayByItemID("material", $va_material["material"]);
						if(trim($vs_material)){
							$va_materials_display[] = caNavLink($this->request, $vs_material, "", "", "Browse", "Objects", array("facet" => "material_facet", "id" => $va_material["material"]));
						}
					}
					if(sizeof($va_materials_display)){
						print "<H6>"._t("Material")."</H6>";
						print join(", ", $va_materials_display);
					}
				}
?>
				{{{<ifdef code="ca_objects.description"><H6>Description</H6>^ca_objects.description</ifdef>}}}
<?php				
				if(trim($t_object->get("ca_objects.dimensions_frame.display_dimensions_frame")) || $t_object->get("ca_objects.dimensions_frame.dimensions_frame_height") || $t_object->get("ca_objects.dimensions.dimensions_height") || trim($t_object->get("ca_objects.dimensions.display_dimensions")) || trim($t_object->get("ca_objects.material")) || trim($t_object->get("description"))){
					print "<HR/>";
				}
				if($va_styles = $t_object->get("ca_objects.styles_movement", array("returnWithStructure" => true, "convertCodesToDisplayText" => false))){
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
				$va_collections = $t_object->get("ca_collections", array("returnWithStructure" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.preferred_labels.name"));
				if(sizeof($va_collections)){
					print "<H6>Collection".((sizeof($va_collections) > 1) ? "s" : "")."</H6>";
					foreach($va_collections as $va_collection){
						print caDetailLink($this->request, $va_collection["name"], "", "ca_collections", $va_collection["collection_id"])."<br/>";
					}
				}
				$t_set = new ca_sets();
				$va_galleries = caExtractValuesByUserLocale($t_set->getSetsForItem("ca_objects", $t_object->get("object_id"), array("checkAccess" => $va_access_values, "setType" => "public_presentation")));
				if(sizeof($va_galleries)){
					print "<H6>Galler".((sizeof($va_galleries) > 1) ? "ies" : "y")."</H6>";
					foreach($va_galleries as $va_gallery){
						print caNavLink($this->request, $va_gallery["name"], "", "", "Gallery", $va_gallery["set_id"])."<br/>";
					}
				}
				if($va_themes = $t_object->get("ca_objects.steelcase_themes", array("returnWithStructure" => true, "convertCodesToDisplayText" => false))){
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
				if($vs_style_display || $vs_theme_display || sizeof($va_collections)){
					print "<HR/>";
				}
?>
				{{{<ifdef code="ca_objects.idno"><H6>Steelcase Number</H6>^ca_objects.idno</ifdef>}}}			
<?php
				$va_storage_locations = $t_object->get("ca_storage_locations", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
				if(sizeof($va_storage_locations)){
					$t_location = new ca_storage_locations();
					$t_relationship = new ca_objects_x_storage_locations();
					$vn_now = date("Y.md");
					$va_location_display = array();
					foreach($va_storage_locations as $va_storage_location){
						$t_relationship->load($va_storage_location["relation_id"]);
						$va_daterange = null; //$t_relationship->get("effective_date", array("returnWithStructure" => true, "returnAsArray" => true));
					
						if(is_array($va_daterange) && sizeof($va_daterange)){
							foreach($va_daterange as $va_date){
								break;
							}
						
							if(is_array($va_date)){
								if(($vn_now > $va_date["start"]) && ($vn_now < $va_date["end"])){
									# --- only display the top level from the hierarchy
									$va_hierarchy_ancestors = array_reverse($t_location->getHierarchyAncestors($va_storage_location["location_id"], array("includeSelf" => 1, "additionalTableToJoin" => "ca_storage_location_labels", "additionalTableSelectFields" => array("name"))));
									foreach($va_hierarchy_ancestors as $va_ancestor){
										$va_location_display[] = caNavLink($this->request, $va_ancestor['NODE']["name"], "", "", "Browse", "Objects", array("facet" => "storage_location_facet", "id" => $va_ancestor['NODE']["location_id"]));
										break;
									}
								}
							}
						}else{
							# --- only display the top level from the hierarchy
							$va_hierarchy_ancestors = array_reverse($t_location->getHierarchyAncestors($va_storage_location["location_id"], array("includeSelf" => 1, "additionalTableToJoin" => "ca_storage_location_labels", "additionalTableSelectFields" => array("name"))));
							
							foreach($va_hierarchy_ancestors as $va_ancestor){
								//print_R($va_ancestor);
								$va_location_display[] = caNavLink($this->request, $va_ancestor['NODE']["name"], "", "", "Browse", "Objects", array("facet" => "storage_location_facet", "id" => $va_ancestor['NODE']["location_id"]));
								break;
							}
						}
					}
					if(sizeof($va_location_display)){
						print "<H6>Location</H6>".join(", ", $va_location_display);
					}
				}
?>
				{{{<ifdef code="ca_objects.credit_line"><H6>Credit</H6>&copy; ^ca_objects.credit_line</ifdef>}}}
<?php				
				if($vs_location_display || $t_object->get("ca_objects.idno") || trim($t_object->get("ca_objects.credit_line"))){
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