<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Detail/ca_objects_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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
	$t_object = 						$this->getVar('t_item');
	$vn_object_id = 					$t_object->get('object_id');
	$vs_title = 						$this->getVar('label');
	
	$va_access_values = 				$this->getVar('access_values');
	$t_rep = 							$this->getVar('t_primary_rep');
	$vn_num_reps = 						$t_object->getRepresentationCount(array("return_with_access" => $va_access_values));
	$vs_display_version =				$this->getVar('primary_rep_display_version');
	$va_display_options =				$this->getVar('primary_rep_display_options');
	$t_list = new ca_lists();
	$vn_silo_id = $t_list->getItemIDFromList('collection_types', 'silo');
 	
?>	
	<div id="detailBody">
		<div id="pageNav">
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t("Back"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("Next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->
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

			if($this->request->config->get('enable_bookmarks')){
?>

<?php
			}
			print "<h3>Title</h3><p>".$vs_title."</p>";
			# --- identifier
			if($va_alt_id = $t_object->get('ca_objects.altID')){
				print "<h3>"._t("Alternate ID")."</h3><p>".$va_alt_id."</p><!-- end unit -->";
			}	
			if($va_alt_name = $t_object->get('ca_objects.nonpreferred_labels', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))){
				#print "<pre>";
				#print_r($va_alt_name[$vn_object_id]);
				#print "</pre>";
				if(sizeof($va_alt_name)){
					print "<h3>"._t("Alternate Title%1", ((sizeof($va_alt_name) > 1) ? "s" : ""))."</h3>";
					$vn_alternate_id = $t_list->getItemIDFromList('object_label_types', 'alt');
					$vn_use_for_id = $t_list->getItemIDFromList('object_label_types', 'uf');
					$vn_file_name_id = $t_list->getItemIDFromList('object_label_types', '16');
					$vs_alternate = "";
					$vs_use_for = "";
					$vs_file_name = "";
					$va_alt_name = array_pop($va_alt_name);
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
								$vs_file_name .= "<p style='line-height:1.1em;'>".$va_alt_title_info["name"]." (file name)</p>";
							break;
							# ---
						}
					}
					print $vs_alternate.$vs_use_for.$vs_file_name;
				}
			}
			if(($va_dates = $t_object->get('ca_objects.date', array('returnAsArray' => true, 'convertCodesToDisplayText' => true)))&&(($this->getVar('typename') != 'Audio/Film/Video'))){
				if(sizeof($va_dates)){
					print "<h3>"._t("Date%1", ((sizeof($va_dates) > 1) ? "s" : ""))."</h3>";
					foreach($va_dates as $va_date){
						#print_r($va_date);
						print "<p>".$va_date["dates_value"]." <br/><span class='details'>(".strtolower($va_date["dc_dates_types"]).")</span></p><!-- end unit -->";
					}
				}
			}			
			print "<h3>Type</h3><p>".caNavLink($this->request, unicode_ucfirst($this->getVar('typename')), "", "", "Browse", "clearAndAddCriteria", array("facet" => "type_facet", "id" => $t_object->get('ca_objects.type_id')))."</p>";
			if($vs_artType = $t_object->get('ca_objects.artType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				if ($vs_artType != "-") {
					print "<h3>"._t("Subtype")."</h3><p>".caNavLink($this->request, $vs_artType, "", "", "Browse", "clearAndAddCriteria", array("facet" => "subtypeart_facet", "id" => $t_object->get('ca_objects.artType')))."</p><!-- end unit -->";
				}
			}	
			if($vs_audioType = $t_object->get('ca_objects.audioFilmType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				if ($vs_audioType != "-NONE-") {
					print "<h3>"._t("Subtype")."</h3><p>".caNavLink($this->request, $vs_audioType, "", "", "Browse", "clearAndAddCriteria", array("facet" => "subtypeaudio_facet", "id" => $t_object->get('ca_objects.audioFilmType')))."</p><!-- end unit -->";
				}
			}
			if($vs_miscellaneous = $t_object->get('ca_objects.miscellaneousType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				if ($vs_miscellaneous != "-") {
					print "<h3>"._t("Subtype")."</h3><p>".caNavLink($this->request, $vs_miscellaneous, "", "", "Browse", "clearAndAddCriteria", array("facet" => "subtypemisc_facet", "id" => $t_object->get('ca_objects.miscellaneousType')))."</p><!-- end unit -->";
				}
			}
			if($vs_photographyType = $t_object->get('ca_objects.photographyType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				if ($vs_photographyType != "-") {
					print "<h3>"._t("Subtype")."</h3><p>".caNavLink($this->request, $vs_photographyType, "", "", "Browse", "clearAndAddCriteria", array("facet" => "subtypephoto_facet", "id" => $t_object->get('ca_objects.photographyType')))."</p><!-- end unit -->";
				}
			}
			if($vs_textualType = $t_object->get('ca_objects.textualType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				if ($vs_textualType != "-") {
					print "<h3>"._t("Subtype")."</h3><p>".caNavLink($this->request, $vs_textualType, "", "", "Browse", "clearAndAddCriteria", array("facet" => "subtypetext_facet", "id" => $t_object->get('ca_objects.textualType')))."</p><!-- end unit -->";
				}
			}
			if($vs_toolType = $t_object->get('ca_objects.toolType', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				if ($vs_toolType != "-") {
					print "<h3>"._t("Subtype")."</h3><p>".caNavLink($this->request, $vs_toolType, "", "", "Browse", "clearAndAddCriteria", array("facet" => "subtypetool_facet", "id" => $t_object->get('ca_objects.toolType')))."</p><!-- end unit -->";
				}
			}
			if($vs_technique = $t_object->get('ca_objects.technique', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				print "<h3>"._t("Technique")."</h3><p>".caNavLink($this->request, $vs_technique, "", "", "Browse", "clearAndAddCriteria", array("facet" => "technique_facet", "id" => $t_object->get('ca_objects.technique')))."</p><!-- end unit -->";
			}
			if($vs_techniquePhoto = $t_object->get('ca_objects.techniquePhoto', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				print "<h3>"._t("Technique")."</h3><p>".caNavLink($this->request, $vs_techniquePhoto, "", "", "Browse", "clearAndAddCriteria", array("facet" => "technique_photo_facet", "id" => $t_object->get('ca_objects.techniquePhoto')))."</p><!-- end unit -->";
			}			
			if($vs_material = $t_object->get('ca_objects.materialMedium', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				print "<h3>"._t("Material")."</h3><p>".caNavLink($this->request, $vs_material, "", "", "Browse", "clearAndAddCriteria", array("facet" => "materials_facet", "id" => $t_object->get('ca_objects.materialMedium')))."</p><!-- end unit -->";
			}	
	
			if($va_length = $t_object->get('ca_objects.dimensions.dimensions_length') || $va_height = $t_object->get('ca_objects.dimensions.dimensions_height') || $va_width = $t_object->get('ca_objects.dimensions.dimensions_width') || $va_depth = $t_object->get('ca_objects.dimensions.dimensions_depth') || $va_weight = $t_object->get('ca_objects.dimensions.weight')){
				print "<h3>"._t("Dimensions")."</h3><p>";
					if($va_length = $t_object->get('ca_objects.dimensions.dimensions_length')) {print $va_length." (length) ";}
					if($va_width = $t_object->get('ca_objects.dimensions.dimensions_width')) {print $va_width." (width) ";}
					if($va_height = $t_object->get('ca_objects.dimensions.dimensions_height')) {print $va_height." (height) ";}
					if($va_depth = $t_object->get('ca_objects.dimensions.dimensions_depth')) {print $va_height." (depth) ";}
					if($va_weight = $t_object->get('ca_objects.dimensions.weight')) {print $va_height." (weight) ";}
				
				if ($va_dimensions_type = $t_object->get('ca_objects.dimensions.Type', array('convertCodesToDisplayText' => true))) {
					print "<br/><span class='details'>(".$va_dimensions_type." dimensions)</span>";
				}
				print "</p><!-- end unit -->";
			}
			# --- description
				if($vs_description_text = $t_object->get("ca_objects.description")){
					print "<h3>Description</h3><div class='scrollPane' id='description' style=''><p>".$vs_description_text."</p></div>";				

				}			
			if($va_edition = $t_object->get('ca_objects.editionOfContainer.editionOf')){
				print "<h3>"._t("Edition")."</h3><p>".$va_edition;
				if($va_edition_date = $t_object->get('ca_objects.editionOfContainer.editionDate')){
					print "<span class='details'> (".$va_edition_date.")</span>";
				}			
				print "</p><!-- end unit -->";
			}
			if($va_printedOn = $t_object->get('ca_objects.printedOnContainer.printedOn')){
				print "<h3>"._t("Printed On")."</h3><p>".$va_printedOn;
				if($va_printedOnDate = $t_object->get('ca_objects.printedOnContainer.printedDate')){
					print "<span class='details'> (".$va_printedOnDate.")</span>";
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
					print $va_planting."<span class='details'> (planting date)</span><br/>";
				}
				if ($va_amount = ($t_object->get('ca_objects.planting.lastPlantingAmount'))) {
					print $va_amount."<span class='details'> (planting amount)</span><br/>";
				}
				if ($va_date = ($t_object->get('ca_objects.planting.nextPlantingDate'))) {
					print $va_date."<span class='details'> (next planting)</span><br/>";
				}				
				print "</p><!-- end unit -->";
			}	
			if($t_object->get('ca_objects.harvesting.lastHarvestingDate') | $t_object->get('ca_objects.harvesting.lastHarvestingAmount') | $t_object->get('ca_objects.harvesting.nextHarvestDate')){
				print "<h3>"._t("Harvesting Information")."</h3><p>";
				if ($va_harvesting = ($t_object->get('ca_objects.harvesting.lastHarvestingDate'))) {
					print $va_harvesting."<span class='details'> (harvesting date)</span><br/>";
				}
				if ($va_h_amount = ($t_object->get('ca_objects.harvesting.lastHarvestingAmount'))) {
					print $va_h_amount."<span class='details'> (harvesting amount)</span><br/>";
				}
				if ($va_h_date = ($t_object->get('ca_objects.harvesting.nextHarvestDate'))) {
					print $va_h_date."<span class='details'> (next harvesting)</span><br/>";
				}				
				print "</p><!-- end unit -->";
			}			
			if($va_lauren = $t_object->get('ca_objects.lBSelected.selected2', array('convertCodesToDisplayText' => true))){
				print "<h3>"._t("Lauren Selection")."</h3><p>".$va_lauren."</p><!-- end unit -->";
			}			
			# --- parent hierarchy info
			if($t_object->get('parent_id')){
				print "<div class='unit'><b>"._t("Part Of")."</b>: ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', 'Detail', 'Object', 'Show', array('object_id' => $t_object->get('parent_id')))."</div>";
			}
			# --- attributes
			$va_attributes = $this->request->config->get('ca_objects_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}", array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
						print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}").":</b> {$vs_value}</div><!-- end unit -->";
					}
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
					print "<div>".caNavLink($this->request, $va_child['name'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_child['object_id']))."</div>";
					$i++;
					if($i == sizeof($va_children)){
						print "</div><!-- end moreChildren -->";
					}
				}
				print "</div><!-- end unit -->";
			}
			# --- entities
			$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname'));
			if(sizeof($va_entities) > 0){	
?>
				<h3><?php print _t("Related")." ".((sizeof($va_entities) > 1) ? _t("People/Organizations") : _t("Person/Organization")); ?></h3>
				<div class='scrollPane'>
<?php
				foreach($va_entities as $va_entity) {
					print "<p>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])."<br/><span class='details'> (".$va_entity['relationship_typename'].")</span><br/></p>";
				}
?>
				</div>				
<?php
			}
			
			# --- occurrences
			$va_occurrences = $t_object->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_sorted_occurrences = array();
			if(sizeof($va_occurrences) > 0){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($va_occurrences as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
				}
				
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
?>
						<h3><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></h3>
					<div class='scrollPane'>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						print "<p>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])."<br/><span class='details'> (".$va_info['relationship_typename'].")</span></p>";
					}
?>
					</div>
<?php
				}
			}
			# --- places
			$va_places = $t_object->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			
			if(sizeof($va_places) > 0){
				print "<h3>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</h3>";
?>
				<div class='scrollPane'>
<?php
				foreach($va_places as $va_place_info){
					print "<p>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])."<br/><span class='details'> (".$va_place_info['relationship_typename'].")</span></p>";
				}
				print "</div>";
			}
			# --- collections
			$va_collections = $t_object->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_collections) > 0){
				print "<h3>"._t("Related Project/Silo").((sizeof($va_collections) > 1) ? "s" : "")."</h3>";
				#foreach($va_collections as $va_collection_info){
				#	print "<p>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])."<br/><span class='details'> (".$va_collection_info['relationship_typename'].")</span></p>";
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
								$va_collection_links[$va_related_silo["collection_id"]] = (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_related_silo['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_related_silo['collection_id'])) : $va_related_silo['label']);						
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
					$va_collection_links[$va_collection_info['collection_id']] = (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label']);
					#print "<p>".."<br/><span class='details'> (".$va_collection_info['relationship_typename'].")</span></p>";
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
			$va_object_lots = $t_object->get("ca_object_lots", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_object_lots) > 0){
				print "<div class='unit'><h3>"._t("Related Lot").((sizeof($va_object_lots) > 1) ? "s" : "")."</h3>";
				foreach($va_object_lots as $va_object_lot_info){
					print "<div>".(($this->request->config->get('allow_detail_for_ca_object_lots')) ? caNavLink($this->request, $va_object_lot_info['label'], '', 'Detail', 'ObjectLots', 'Show', array('lot_id' => $va_object_lot_info['lot_id'])) : $va_object_lot_info['label'])."<br/><span class='details'> (".$va_object_lot_info['relationship_typename'].")</span></div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- vocabulary terms
			$va_terms = $t_object->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
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
			# --- map
			if($this->request->config->get('ca_objects_map_attribute') && $t_object->get($this->request->config->get('ca_objects_map_attribute'))){
				$o_map = new GeographicMap(180, 128, 'map');
				$o_map->mapFrom($t_object, $this->request->config->get('ca_objects_map_attribute'));
				print "<div class='unit'>".$o_map->render('HTML')."</div>";
			}			
			# --- output related object images as links
			$va_related_objects = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if (sizeof($va_related_objects)) {
				print "<div class='unit'><h3 style='margin-bottom:7px;'>"._t("Related Objects")."</h3>";
				foreach($va_related_objects as $vn_rel_id => $va_info){
					$t_rel_object = new ca_objects($va_info["object_id"]);
					$va_reps = $t_rel_object->getPrimaryRepresentation(array('icon', 'small'), null, array('return_with_access' => $va_access_values));
					print "<div class='imageIcon icon".$va_info["object_id"]."'>";
					print caNavLink($this->request, $va_reps['tags']['icon'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_info["object_id"]));
					
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
<?php
		if ($t_rep && $t_rep->getPrimaryKey()) {
?>
			<div id="objDetailImage">
<?php
			if($va_display_options['no_overlay']){
				print $t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'));
			}else{
				print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".$t_rep->getMediaTag('media', 'mediumlarge', $this->getVar('primary_rep_display_options'))."</a>";
			}
?>
			</div><!-- end objDetailImage -->
			<div id="objDetailImageNav" >
				<div style="float:right;">
<?php
				if (($this->request->isLoggedIn()) && ($this->request->config->get('can_download_media') && $t_rep && $t_rep->getPrimaryKey())) {
					print caNavLink($this->request, _t("+ Download Media"), '', 'Detail', 'Object', 'DownloadRepresentation', array('representation_id' => $t_rep->getPrimaryKey(), "object_id" => $vn_object_id, "download" => 1, "version" => original)); 
				}
				
				if ($t_rep && $t_rep->getPrimaryKey()) {
					if ($this->getVar('typename') != "Audio/Film/Video") {
						print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >+ ".(($vn_num_reps > 1) ? _t("Zoom/more media") : _t("Zoom"))."</a>";
					}
				}
?>
				</div>			
			</div><!-- end objDetailImageNav -->
<?php
		}
		
if (!$this->request->config->get('dont_allow_comments')) {
		# --- user data --- comments - ranking - tagging
?>			
		<div id="objUserData" style='margin-top:20px;'>
<?php
			if($this->getVar("ranking")){
?>
				<h2 id="ranking"><?php print _t("Average User Ranking"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/user_ranking_<?php print $this->getVar("ranking"); ?>.gif" width="104" height="15" border="0" style="margin-left: 20px;"></h2>
<?php
			}
			$va_tags = $this->getVar("tags_array");
			if(is_array($va_tags) && sizeof($va_tags) > 0){
				$va_tag_links = array();
				foreach($va_tags as $vs_tag){
					$va_tag_links[] = caNavLink($this->request, $vs_tag, '', '', 'Search', 'Index', array('search' => $vs_tag));
				}
?>
				<h2><?php print _t("Tags"); ?></h2>
				<div id="tags">
					<?php print implode($va_tag_links, ", "); ?>
				</div>
<?php
			}
			$va_comments = $this->getVar("comments");
			if(is_array($va_comments) && (sizeof($va_comments) > 0)){
?>
				<h2><div id="numComments">(<?php print sizeof($va_comments)." ".((sizeof($va_comments) > 1) ? _t("comments") : _t("comment")); ?>)</div><?php print _t("User Comments"); ?></h2>
<?php
				foreach($va_comments as $va_comment){
					if($va_comment["media1"]){
?>
						<div class="commentImage" id="commentMedia<?php print $va_comment["comment_id"]; ?>">
							<?php print $va_comment["media1"]["tiny"]["TAG"]; ?>							
						</div><!-- end commentImage -->
<?php
						TooltipManager::add(
							"#commentMedia".$va_comment["comment_id"], $va_comment["media1"]["large_preview"]["TAG"]
						);
					}
					if($va_comment["comment"]){
?>					
					<div class="comment">
						<?php print $va_comment["comment"]; ?>
					</div>
<?php
					}
?>					
					<div class="byLine">
						<?php print $va_comment["author"].", ".$va_comment["date"]; ?>
					</div>
<?php
				}
			}else{
				if(!$vs_tags && !$this->getVar("ranking")){
					$vs_login_message = _t("+ Comment");
				}
			}
			if($this->getVar("ranking") || (is_array($va_tags) && (sizeof($va_tags) > 0)) || (is_array($va_comments) && (sizeof($va_comments) > 0))){
?>
				<div class="divide" style="margin:12px 0px 10px 0px;"><!-- empty --></div>
<?php			
			}
		if($this->request->isLoggedIn()){
?>
			<p class='formLabel' style='font-weight:bold;'><?php print _t("Add your rank, tags and comment"); ?></p>
			<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Object', 'saveCommentRanking', array('object_id' => $vn_object_id)); ?>" name="comment" enctype='multipart/form-data'>
				<div class="formLabel"><?php print _t("Tags (separated by commas)"); ?></div>
				<input type="text" name="tags">
				
				<div class="formLabel"><?php print _t("Comment"); ?></div>
				<textarea name="comment" rows="5"></textarea>
				<br><a href="#" name="commentSubmit" class='formLabel' style='font-weight:bold;' onclick="document.forms.comment.submit(); return false;"><?php print _t("Save"); ?></a>
			</form>
<?php
		}
?>		
		</div><!-- end objUserData-->
<?php
	}
?>
			<div id='bottomBar'>
<?php	
			if($this->request->isLoggedIn()){
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/bookmark.png' border='0' title='Bookmark'>", '', '', 'Bookmarks', 'addBookmark', array('row_id' => $vn_object_id, 'tablename' => 'ca_objects'));
			}else{
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/bookmark.png' border='0' title='Bookmark'>", '', '', 'LoginReg', 'form', array('site_last_page' => 'Bookmarks', 'row_id' => $vn_object_id, 'tablename' => 'ca_objects'));
			}

			if ((!$this->request->config->get('dont_allow_registration_and_login')) && (!$this->request->config->get('disable_my_collections'))) {
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/lightbox.png' border='0' title='Add to Set'>", '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id));
				}else{
					print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/lightbox.png' border='0' title='Add to Set'>", '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets', 'object_id' => $vn_object_id));
				}
			}
		
		
			if(!$this->request->isLoggedIn()){
				if (!$this->request->config->get('dont_allow_comments')) {
					print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/comment.png' border='0' title='Comment'>", "", "", "LoginReg", "form", array('site_last_page' => 'ObjectDetail', 'object_id' => $vn_object_id));
				}
			}
			print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/email.png' border='0' title='Email this record'>", "", "Share", "Share", "objectForm", array('object_id' => $vn_object_id));
			print "<a href='http://www.facebook.com/sharer.php?u=".urlencode($this->request->config->get("site_host").caNavUrl($this->request, "Detail", "Object", "Show", array("object_id" => $vn_object_id)))."&t=".urlencode($vs_title)."'><img src='".$this->request->getThemeUrlPath()."/graphics/icons/facebook.png' border='0' title='Share on Facebook'></a>";	
?>
			</div><!-- end bottomBar -->
		</div><!-- end leftCol -->

	</div><!-- end detailBody -->
<?php
	require_once(__CA_LIB_DIR__.'/core/Parsers/COinS.php');
	
	print COinS::getTags($t_object);
	
	# -- metatags for facebook sharing
	MetaTagManager::addMeta('og:title', $vs_title);
	if($t_rep && $t_rep->getPrimaryKey() && $vs_media_url = $t_rep->getMediaUrl('media', 'thumbnail')){
		MetaTagManager::addMeta('og:image', $vs_media_url);
		MetaTagManager::addLink('image_src', $vs_media_url);
	}
	if($vs_description_text){
		MetaTagManager::addMeta('og:description', $vs_description_text);
	}
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.scrollPane').jScrollPane({
				
				animateScroll: true,
			});
		});
	</script>
