<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$t_object = 			$this->getVar("item");
	$vn_object_id = 		$t_object->get('ca_objects.object_id');
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$t_list = new ca_lists();
	$vn_silo_id = $t_list->getItemIDFromList('collection_types', 'silo');

?>
	<div id="detailBody">
		<div id="pageNav">
			{{{resultsLink}}}{{{previousLink}}}{{{nextLink}}}
		</div><!-- end pageNav -->
		<div class='titleBar'>
			<div class='recordTitle'><h1>
<?php	
			if($t_object->get('idno')){
				print $t_object->get('idno');
			}
?>			
			</h1></div>

		</div>
		<div style='clear:both;height:16px;'></div>
		<div id="rightCol">
<?php
			print "<h3>Title</h3><p>".$t_object->get('ca_objects.preferred_labels')."</p>";
			# --- identifier
			if($va_alt_id = $t_object->get('ca_objects.altID')){
				print "<h3>"._t("Alternate ID")."</h3><p>".$va_alt_id."</p><!-- end unit -->";
			}
			#TODO fix alt names	
			if($va_alt_name = $t_object->get('ca_objects.nonpreferred_labels', array('returnWithStructure' => true, 'assumeDisplayField' => false, 'convertCodesToDisplayText' => false))){

				$va_alt_name = array_pop($va_alt_name);
				if(sizeof($va_alt_name)){
					print "<h3>"._t("Alternate Title%1", ((sizeof($va_alt_name) > 1) ? "s" : ""))."</h3>";
					$vn_alternate_id = $t_list->getItemIDFromList('object_label_types', 'alt');
					$vn_use_for_id = $t_list->getItemIDFromList('object_label_types', 'uf');
					$vn_file_name_id = $t_list->getItemIDFromList('object_label_types', '16');
					$vs_alternate = "";
					$vs_use_for = "";
					$vs_file_name = "";
					foreach($va_alt_name as $vn_x => $va_alt_title_info){
						switch($va_alt_title_info["type_id"]){
							case $vn_alternate_id:
								$vs_alternate .= "<p style='line-height:1.1em;'>".$va_alt_title_info["name"]."</p>";
							break;
							# ---
							case $vn_use_for_id:
								$vs_use_for .= "<p style='line-height:1.1em;'>".$va_alt_title_info["name"]."</p>";
							break;
							# ---
							case $vn_file_name_id:
								$vs_file_name .= "<p style='line-height:1.1em;'>".$va_alt_title_info["name"]." <span class='details'>(file name)</span></p>";
							break;
							# ---
						}
					}
					print $vs_alternate.$vs_use_for.$vs_file_name;
				}
			}
			if(($va_dates = $t_object->get('ca_objects.date', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true)))&&(($this->getVar('typename') != 'Audio/Film/Video'))){
				if(sizeof($va_dates)){
					$va_dates_for_display = array();
					foreach($va_dates as $va_date_t){
						foreach ($va_date_t as $va_date) {
						#print_r($va_date);
							if($va_date["dates_value"]){
								$va_dates_for_display[] = "<p>".$va_date["dates_value"]." <span class='details'>(".strtolower($va_date["dc_dates_types"]).")</span></p><!-- end unit -->";
							}
						}
					}
					if(sizeof($va_dates_for_display)){
						print "<h3>"._t("Date%1", ((sizeof($va_dates) > 1) ? "s" : ""))."</h3>";
						print implode("\n", $va_dates_for_display);
					}
				}
			}			
			print "<h3>Type</h3><p>".caNavLink($this->request, caUcFirstUTF8Safe($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))), "", "", "Browse", "objects/facet/type_facet/id/".$t_object->get('ca_objects.type_id'))."</p>";
			if($vs_artType = $t_object->get('ca_objects.artType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				if ($vs_artType != "-") {
					print "<h3>"._t("Subtype")."</h3><p>".caNavLink($this->request, $vs_artType, "", "", "Browse", "objects/facet/subtypeart_facet/id/".$t_object->get('ca_objects.artType'))."</p><!-- end unit -->";
				}
			}	
			if($vs_audioType = $t_object->get('ca_objects.audioFilmType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				if ($vs_audioType != "-NONE-") {
					print "<h3>"._t("Subtype")."</h3><p>".caNavLink($this->request, $vs_audioType, "", "", "Browse", "objects/facet/subtypeaudio_facet/id/".$t_object->get('ca_objects.audioFilmType'))."</p><!-- end unit -->";
				}
			}
			if($vs_miscellaneous = $t_object->get('ca_objects.miscellaneousType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				if ($vs_miscellaneous != "-") {
					print "<h3>"._t("Subtype")."</h3><p>".caNavLink($this->request, $vs_miscellaneous, "", "", "Browse", "objects/facet/subtypemisc_facet/id/".$t_object->get('ca_objects.miscellaneousType'))."</p><!-- end unit -->";
				}
			}
			if($vs_photographyType = $t_object->get('ca_objects.photographyType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				if ($vs_photographyType != "-") {
					print "<h3>"._t("Subtype")."</h3><p>".caNavLink($this->request, $vs_photographyType, "", "", "Browse", "objects/facet/subtypephoto_facet/id/".$t_object->get('ca_objects.photographyType'))."</p><!-- end unit -->";
				}
			}
			if($vs_textualType = $t_object->get('ca_objects.textualType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				if ($vs_textualType != "-") {
					print "<h3>"._t("Subtype")."</h3><p>".caNavLink($this->request, $vs_textualType, "", "", "Browse", "objects/facet/subtypetext_facet/id".$t_object->get('ca_objects.textualType'))."</p><!-- end unit -->";
				}
			}
			if($vs_toolType = $t_object->get('ca_objects.toolType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				if ($vs_toolType != "-") {
					print "<h3>"._t("Subtype")."</h3><p>".caNavLink($this->request, $vs_toolType, "", "", "Browse", "objects/facet/subtypetool_facet/id".$t_object->get('ca_objects.toolType'))."</p><!-- end unit -->";
				}
			}
			if($vs_technique = $t_object->get('ca_objects.technique', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				print "<h3>"._t("Technique")."</h3><p>".caNavLink($this->request, $vs_technique, "", "", "Browse", "objects/facet/technique_facet/id/".$t_object->get('ca_objects.technique'))."</p><!-- end unit -->";
			}
			if($va_techniquePhoto = $t_object->get('ca_objects.techniquePhoto', array('convertCodesToDisplayText' => false, 'returnAsArray' => true))){
				print "<h3>"._t("Technique")."</h3><p>";
				foreach ($va_techniquePhoto as $va_key => $vs_techniquePhoto) {
					print caNavLink($this->request, caGetListItemByIDForDisplay($vs_techniquePhoto), "", "", "Browse", "objects/facet/technique_photo_facet/id/".$vs_techniquePhoto)."<br/>";
				}
				print "</p><!-- end unit -->";
			}			
			if($vs_material = $t_object->get('ca_objects.materialMedium', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				print "<h3>"._t("Material")."</h3><p>".caNavLink($this->request, $vs_material, "", "", "Browse", "objects/facet/materials_facet/id".$t_object->get('ca_objects.materialMedium'))."</p><!-- end unit -->";
			}	
	
			if($va_dims = $t_object->getWithTemplate('<unit delimiter="<br/>"><ifdef code="ca_objects.dimensions.dimensions_length">^ca_objects.dimensions.dimensions_length L</ifdef> <ifdef code="ca_objects.dimensions.dimensions_length,ca_objects.dimensions.dimensions_width"> x </ifdef><ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width W</ifdef><ifdef code="ca_objects.dimensions.dimensions_width,ca_objects.dimensions.dimensions_height"> x </ifdef><ifdef code="ca_objects.dimensions.dimensions_height"> ^ca_objects.dimensions.dimensions_height H</ifdef><ifdef code="ca_objects.dimensions.dimensions_depth,ca_objects.dimensions.dimensions_height"> x </ifdef><ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth D</ifdef> <ifdef code="ca_objects.dimensions.Type">(^ca_objects.dimensions.Type)</ifdef></unit>')){
				print "<h3>"._t("Dimensions")."</h3><p>";
				print $va_dims;
				print "</p><!-- end unit -->";
			}
			# --- description
				if($vs_description_text = $t_object->get("ca_objects.description")){
					print "<h3>Description</h3><div class='scrollPane' id='description' style=''><p>".$vs_description_text."</p></div>";				

				}			
			if($va_edition = $t_object->get('ca_objects.editionOfContainer.editionOf')){
				print "<h3>"._t("Edition")."</h3><p>".$va_edition;
				if($va_edition_date = $t_object->get('ca_objects.editionOfContainer.editionDate')){
					print " <span class='details'>(".$va_edition_date.")</span>";
				}			
				print "</p><!-- end unit -->";
			}
			if($va_printedOn = $t_object->get('ca_objects.printedOnContainer.printedOn')){
				print "<h3>"._t("Printed On")."</h3><p>".$va_printedOn;
				if($va_printedOnDate = $t_object->get('ca_objects.printedOnContainer.printedDate')){
					print " <span class='details'>(".$va_printedOnDate.")</span>";
				}			
				print "</p><!-- end unit -->";
			}			
			if($va_quantity = $t_object->get('ca_objects.quantity')){
				print "<h3>"._t("Quantity")."</h3><p>".$va_quantity."</p><!-- end unit -->";
			}						

			if($vs_duration = $t_object->get('ca_objects.duration')){
				if($vs_duration != "0h 0m 0s"){
					print "<h3>"._t("Duration")."</h3><p>".$vs_duration."</p><!-- end unit -->";
				}
			}			
			if($va_provenance = $t_object->get('ca_objects.provenance')){
				print "<h3>"._t("Provenance")."</h3><p>".$va_provenance."</p><!-- end unit -->";
			}
			if($va_general = $t_object->get('ca_objects.generalNotes')){
				print "<h3>"._t("General Notes")."</h3><p>".$va_general."</p><!-- end unit -->";
			}
			if($va_article = $t_object->get('ca_objects.references.title')){
				print "<h3>"._t("Article Name")."</h3><p>".$va_article."</p><!-- end unit -->";
			}			
			if($va_publication = $t_object->get('ca_objects.references.publication')){
				print "<h3>"._t("Publication")."</h3><p>".$va_publication."</p><!-- end unit -->";
			}	
			if($va_author = $t_object->get('ca_objects.references.author')){
				print "<h3>"._t("Author")."</h3><p>".$va_author."</p><!-- end unit -->";
			}			
			if($t_object->get('ca_objects.planting.lastPlantingDate') | $t_object->get('ca_objects.planting.lastPlantingAmount') | $t_object->get('ca_objects.planting.nextPlantingDate')){
				print "<h3>"._t("Planting Information")."</h3><p>";
				if ($va_planting = ($t_object->get('ca_objects.planting.lastPlantingDate'))) {
					print $va_planting." <span class='details'>(planting date)</span><br/>";
				}
				if ($va_amount = ($t_object->get('ca_objects.planting.lastPlantingAmount'))) {
					print $va_amount." <span class='details'>(planting amount)</span><br/>";
				}
				if ($va_date = ($t_object->get('ca_objects.planting.nextPlantingDate'))) {
					print $va_date." <span class='details'>(next planting)</span><br/>";
				}				
				print "</p><!-- end unit -->";
			}	
			if($t_object->get('ca_objects.harvesting.lastHarvestingDate') | $t_object->get('ca_objects.harvesting.lastHarvestingAmount') | $t_object->get('ca_objects.harvesting.nextHarvestDate')){
				print "<h3>"._t("Harvesting Information")."</h3><p>";
				if ($va_harvesting = ($t_object->get('ca_objects.harvesting.lastHarvestingDate'))) {
					print $va_harvesting." <span class='details'>(harvesting date)</span><br/>";
				}
				if ($va_h_amount = ($t_object->get('ca_objects.harvesting.lastHarvestingAmount'))) {
					print $va_h_amount." <span class='details'>(harvesting amount)</span><br/>";
				}
				if ($va_h_date = ($t_object->get('ca_objects.harvesting.nextHarvestDate'))) {
					print $va_h_date." <span class='details'>(next harvesting)</span><br/>";
				}				
				print "</p><!-- end unit -->";
			}			
			if($va_lauren = $t_object->get('ca_objects.lBSelected.selected2', array('convertCodesToDisplayText' => true))){
				print "<h3>"._t("Lauren Selection")."</h3><p>".$va_lauren."</p><!-- end unit -->";
			}
			if($va_formatted_citation = $t_object->get('ca_objects.formatted_citation')){
				print "<h3>"._t("Citation")."</h3><p>".$va_formatted_citation."</p><!-- end unit -->";
			}						
			# --- parent hierarchy info
			if($t_object->get('parent_id')){
				print "<div class='unit'><b>"._t("Part Of")."</b>: ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', '', 'Detail', 'objects/'.$t_object->get('parent_id'))."</div>";
			}
			if($va_links = $t_object->get("ca_objects.external_link", array("returnWithStructure" => true))){
				$va_linksToOutput = array();
				foreach($va_links as $va_link){
					if($va_link['url_source']){
						$vs_link = "<a href='".$va_link['url_entry']."' target='_blank'>".$va_link['url_source']."</a>";
					}elseif($va_link['url_entry']){
						$vs_link = "<a href='".$va_link['url_entry']."' target='_blank'>".$va_link['url_entry']."</a>";
					}
					if($vs_link){
						$va_linksToOutput[] = $vs_link;
					}
				}
				if(sizeof($va_linksToOutput)){
					print "<h3>"._t("Link")."</h3><p>";
					print join("<br/>", $va_linksToOutput);
					print "</p>";
				}
			}

			# --- child hierarchy info
			$va_children = $t_object->get("ca_objects.children.preferred_labels", array('returnAsArray' => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_children) > 0){
				print "<div class='unit'><h3>"._t("Part%1", ((sizeof($va_children) > 1) ? "s" : ""))."</h3> ";
				$i = 0;
				foreach($va_children as $va_child){
					# only show the first 5 and have a more link
					if($i == 5){
						print "<div id='moreChildrenLink'><a href='#' onclick='$(\"#moreChildren\").slideDown(250); $(\"#moreChildrenLink\").hide(1); return false;'>["._t("More")."]</a></div><!-- end moreChildrenLink -->";
						print "<div id='moreChildren' style='display:none;'>";
					}
					print "<div>".caNavLink($this->request, $va_child['name'], '', '', 'Detail', 'objects/'.$va_child['object_id'])."</div>";
					$i++;
					if($i == sizeof($va_children)){
						print "</div><!-- end moreChildren -->";
					}
				}
				print "</div><!-- end unit -->";
			}
			# --- entities
			if ($va_entities = $t_object->getWithTemplate("<unit delimiter=', ' sort='ca_entities.preferred_labels' relativeTo='ca_entities'><l>^ca_entities.preferred_labels</l> <span class='details'>(^relationship_typename)</span></unit>")) {
				print "<h3>Related People/Organizations</h3>";
				print "<p>".$va_entities."</p>";
			}

			
			# --- occurrences
			$va_occurrences = $t_object->get("ca_occurrences", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			$va_sorted_occurrences = array();
			if(sizeof($va_occurrences) > 0){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($va_occurrences as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_rel_entities = array();
					$va_rel_entities = $t_occ->get("ca_entities", array('restrictToTypes' => array('organization'), "returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname'));
					$va_occurrence["related_entities"] = $va_rel_entities;
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
				}
				
				$t_list = new ca_lists();
				$vn_exhibition_type_id = $t_list->getItemIDFromList("occurrence_types", "exhibition");
				
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
?>
						<h3><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></h3>
					<div class='scrollPane'>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						print "<p>".caNavLink($this->request, $va_info["label"], '', '', 'Detail', 'occurrences/'.$vn_rel_occurrence_id);
						if($vn_exhibition_type_id == $vn_occurrence_type_id){
							# --- this is an exhibition, so try to display organizations related to the exhibition
							$vn_i = 1;
							foreach($va_info['related_entities'] as $va_organization){
								print ", ".$va_organization;
								if($vn_i < sizeof($va_info['related_entities'])){
									print ", ";
								}
								$vn_i++;
							}
						}
						print " <span class='details'>(".$va_info['relationship_typename'].")</span></p>";
					}
?>
					</div>
<?php
				}
			}
			
			# --- places
			if ($va_places = $t_object->getWithTemplate("<unit delimiter=', ' sort='ca_places.preferred_labels' relativeTo='ca_places'><l>^ca_places.preferred_labels</l> <span class='details'>(^relationship_typename)</span></unit>")) {
				print "<h3>Related Places</h3>";
				print "<p>".$va_places."</p>";
			}
			
			# --- collections
			$va_collections = $t_object->get("ca_collections", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_collections) > 0){
				print "<h3>"._t("Related Project/Silo").((sizeof($va_collections) > 1) ? "s" : "")."</h3>";
				#foreach($va_collections as $va_collection_info){
				#	print "<p>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." <span class='details'>(".$va_collection_info['relationship_typename'].")</span></p>";
				#}
?>
				<div class='scrollPane'>
<?php
				$va_silos = array();
				$va_collection_links = array();
				$t_related_collection = new ca_collections();
				foreach($va_collections as $va_collection_info){				
					if($va_collection_info["item_type_id"] != $vn_silo_id){
						# --- if the related collection is not a silo, check for a related silo to list it under
						$t_related_collection->load($va_collection_info['collection_id']);
						$va_related_silos = $t_related_collection->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('silo')));
						if(sizeof($va_related_silos)){
							foreach($va_related_silos as $va_related_silo){
								$va_silos[$va_related_silo["collection_id"]][] = $va_collection_info['collection_id'];
								$va_collection_links[$va_related_silo["collection_id"]] = caNavLink($this->request, $va_related_silo['label'], '', '', 'Detail', 'collections/'.$va_related_silo['collection_id']);						
							}
						}else{
							if(!$va_silos[$va_collection_info['collection_id']]){
								$va_silos[$va_collection_info['collection_id']] = array();
							}
						}
					}else{
						if(!$va_silos[$va_collection_info['collection_id']]){
							$va_silos[$va_collection_info['collection_id']] = array();	
						}
					}
					$va_collection_links[$va_collection_info['collection_id']] = caNavLink($this->request, $va_collection_info['label'], '', '', 'Detail', 'collections/'.$va_collection_info['collection_id']);
					#print "<p> <span class='details'>(".$va_collection_info['relationship_typename'].")</span></p>";
				
				}
				
				if(sizeof($va_silos)){
					foreach($va_silos as $vn_silo_id => $va_projectsPhases){
						print "<p>".$va_collection_links[$vn_silo_id];
							$i = 0;
							if(sizeof($va_projectsPhases)){
								print " (";
							}
							foreach($va_projectsPhases as $vn_projectPhase_id){
								print "<span class='grayLink'>".$va_collection_links[$vn_projectPhase_id]."</span>";
								$i++;
								if($i < sizeof($va_projectsPhases)){
									print ", ";
								}
							}
							if(sizeof($va_projectsPhases)){
								print ")";
							}
						print "</p>";
					}
				}
?>
				</div>
<?php
			}
			# --- lots
			$va_object_lots = $t_object->get("ca_object_lots", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_object_lots) > 0){
				print "<div class='unit'><h3>"._t("Related Lot").((sizeof($va_object_lots) > 1) ? "s" : "")."</h3>";
				foreach($va_object_lots as $va_object_lot_info){
					print "<div>".$va_object_lot_info['label']." <span class='details'>(".$va_object_lot_info['relationship_typename'].")</span></div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- vocabulary terms
			$va_terms = $t_object->get("ca_list_items", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				print "<h3>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</h3>";
?>
				<div class='scrollPane'>
<?php
				foreach($va_terms as $va_term_info){
					print "<p>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</p>";
				}
				print "</div>";
			}
			#TODO test related objects
			# --- output related object images as links
			$va_related_objects = $t_object->get("ca_objects", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if (sizeof($va_related_objects)) {
				print "<div class='unit'><h3 style='margin-bottom:7px;'>"._t("Related Objects")."</h3>";
				foreach($va_related_objects as $vn_rel_id => $va_info){
					$t_rel_object = new ca_objects($va_info["object_id"]);
					$va_reps = $t_rel_object->getPrimaryRepresentation(array('icon', 'small'), null, array('return_with_access' => $va_access_values));
					print "<div class='imageIcon icon".$va_info["object_id"]."'>";
					print caNavLink($this->request, $va_reps['tags']['icon'], '', '', 'Detail', 'objects/'.$va_info["object_id"]);
					
					// set view vars for tooltip
					$this->setVar('tooltip_representation', $va_reps['tags']['small']);
					$this->setVar('tooltip_title', $va_info['label']);
					$this->setVar('tooltip_idno', $va_info["idno"]);
					TooltipManager::add(
						".icon".$va_info["object_id"], $this->render('../Results/ca_objects_result_tooltip_html.php')
					);
					
					print "</div>";
				}
				print "</div><!-- end unit -->";
			}
?>		
		</div><!-- end rightCol-->
		<div id="leftCol">	
			<div id="objDetailImage">	

				{{{representationViewer}}}
			</div>							
			<div id="detailAnnotations"></div>
				
			<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
			<div id="bottomBar">
<?php				
				#print '<a href="#" onclick="caMediaPanel.showPanel(""'.caNavUrl($this->request, 'Lightbox', 'addItemForm', array('object_id' => $vn_object_id)).'"); return false;" title="Add to lightbox">'.caGetThemeGraphic($this->request, 'lightbox.png').'</a>';
				print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Lightbox', 'addItemForm', array('object_id' => $vn_object_id))."\"); return false;' >".caGetThemeGraphic($this->request, 'lightbox.png')."</a>";

?>			
			</div><!-- end bottomBar -->
		</div><!-- end Leftcol -->
	</div><!-- end detailBody -->

	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.scrollPane').jScrollPane({
				
				animateScroll: true,
			});
		});
	</script>