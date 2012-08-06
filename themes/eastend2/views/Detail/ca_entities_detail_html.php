<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_entities_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2011 Whirl-i-Gig
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
 	require_once(__CA_LIB_DIR__."/ca/Search/PlaceSearch.php");
	$t_entity 			= $this->getVar('t_item');
	$vn_entity_id 		= $t_entity->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');

if (!$this->request->isAjax()) {		
?>
	<div id="detailBody"><div id="entity">
		<div id="pageNav">
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_entities', _t("Back"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Entity', 'Show', array('entity_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Entity', 'Show', array('entity_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("Next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->
		<h1>
<?php
			print $vs_title;
			if($t_entity->get("lifespans_date")){
				print ", (".$t_entity->get("lifespans_date").")";
			}
			if($t_entity->get("nationality")){
				print "<div class='nationality'>".$t_entity->get("nationality")."</div><!-- end nationality -->";
			}
?>
		</h1>
		<div id="leftCol">
			<div id="portraitCol">
<?php
			# --- get portrait of entity
			$va_portraits = $t_entity->get("ca_objects", array("restrictToRelationshipTypes" => array("portrait", "depicts"), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
			foreach($va_portraits as $va_portrait){
				$t_object = new ca_objects($va_portrait["object_id"]);
				if($va_portrait = $t_object->getPrimaryRepresentation(array('preview'), null, array('return_with_access' => $va_access_values))){
					print "<div>".$va_portrait['tags']['preview']."</div>";
					break;
				}
			}
			
			# --- get medium and movements
			if($vs_medium = $t_entity->get("fields_mediums", array('checkAccess' => $va_access_values, 'delimiter' => ', ', 'convertCodesToDisplayText' => true))){
				print "<div>".$vs_medium."</div>";
			}
			if($vs_style = $t_entity->get("style_school", array('checkAccess' => $va_access_values, 'delimiter' => ', ', 'convertCodesToDisplayText' => true))){
				print "<div>".$vs_style."</div>";
			}
			if((!$this->request->config->get('dont_allow_registration_and_login')) && $this->request->config->get('enable_bookmarks')){
?>
				<!-- bookmark link BEGIN -->
				<div class="unit">
<?php
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("Bookmark item +"), 'button', '', 'Bookmarks', 'addBookmark', array('row_id' => $vn_entity_id, 'tablename' => 'ca_entities'));
				}else{
					print caNavLink($this->request, _t("Bookmark item +"), 'button', '', 'LoginReg', 'form', array('site_last_page' => 'Bookmarks', 'row_id' => $vn_entity_id, 'tablename' => 'ca_entities'));
				}
?>
				</div><!-- end unit -->
				<!-- bookmark link END -->
<?php
			}
?>				
			</div><!-- end portraitCol -->
<?php
			if($t_entity->get("ca_entities.scope_notes")){
				print "<div id='descriptionCol'>".$t_entity->get("ca_entities.scope_notes")."</div><!-- end descriptionCol -->";
			}	

			print "<div id='relatedLists'>";			
			
			# --- occurrences
			$va_occurrences = $t_entity->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_occurrences) > 0){	
?>
				<div class="relatedListCol"><h2><?php print _t("Events"); ?></h2>
<?php
				foreach($va_occurrences as $va_occurrence) {
					print "<div>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_occurrence["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_occurrence["occurrence_id"])) : $va_occurrence["label"])."<br/>(".$va_occurrence['relationship_typename'].")</div>";		
				}
?>
				</div><!-- end relatedListCol -->
<?php
			}
			
			# --- entities
			$va_entities = $t_entity->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities) > 0){	
?>
				<div class="relatedListCol"><h2><?php print _t("Social Network"); ?></h2>
<?php
				foreach($va_entities as $va_entity) {
					print "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])."<br/>(".$va_entity['relationship_typename'].")</div>";		
				}
?>
				</div><!-- end relatedListCol -->
<?php
			}
			
			# --- list of artists from the same movements
			if($va_style_ids = caExtractValuesByUserLocale($t_entity->get("style_school", array('returnAsArray' => true, 'delimeter' => ', ', 'checkAccess' => $va_access_values)))){
				$va_search_parts = "";
				$vs_search_text = "";
				foreach($va_style_ids as $vn_style_id){
					$va_search_parts[] = "ca_entities.style_school: ".$vn_style_id;
				}
				$vs_search_text = join(" OR ", $va_search_parts);
				$o_ent_search = new EntitySearch();
				# -- exclude the current entity from list
				$o_ent_search->addResultFilter("ca_entities.entity_id", "!=", $vn_entity_id);
				#print_r($o_ent_search->getResultFilters());
				$qr_entities = $o_ent_search->search($vs_search_text, array("sort" => "ca_entities.lname", "checkAccess" => $va_access_values));
				if($qr_entities->numHits()){
					print "<div class='relatedListCol'><H2>"._t("Artists From Same Movement")."</H2>";
					while($qr_entities->nextHit()){
						print "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, join(", ", $qr_entities->getDisplayLabels()), '', 'Detail', 'Entity', 'Show', array('entity_id' => $qr_entities->get("ca_entities.entity_id"))) : join(", ", $qr_entities->getDisplayLabels()))."</div>";
					}
					print "</div><!-- end relatedListCol -->";
				}
			}

			
// 			# --- places
// 			$va_places = $t_entity->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
// 			if(sizeof($va_places) > 0){
// 				print "<div class='relatedListCol'><h2>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</h2>";
// 				foreach($va_places as $va_place_info){
// 					print "<div>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".$va_place_info['relationship_typename'].")</div>";
// 				}
// 				print "</div><!-- end relatedListCol -->";
// 			}

?>
		</div><!-- end relatedLists -->
	</div><!-- end leftCol -->
	<div id="rightCol">
		<div id="resultBox">
<?php
}
	// set parameters for paging controls view
	$this->setVar('other_paging_parameters', array(
		'entity_id' => $vn_entity_id
	));
	print $this->render('related_objects_grid.php');
	
if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox -->
<?php
			$o_place_search = new PlaceSearch();
			$qr_places = $o_place_search->search("ca_entities.entity_id: ".$vn_entity_id, array("checkAccess" => $va_access_values));
 			#print $qr_places->numHits();
 			if($qr_places->numHits()){
				$o_map = new GeographicMap(400, 250, 'map');
				#$va_map_stats = $o_map->mapFrom($qr_places, "georeference", array("ajaxContentUrl" => caNavUrl($this->request, "eastend", "Chronology", "getMapItemInfo"), "request" => $this->request, "checkAccess" => $va_access_values));
				$va_map_stats = $o_map->mapFrom($qr_places, "georeference", array("request" => $this->request, "checkAccess" => $va_access_values));
				#print_r($va_map_stats);
				print '<div id="entityPlaceMap">'.$o_map->render('HTML', array('delimiter' => "<br/>")).'</div><!-- end entityPlaceMap -->';
			}				
?>		
	</div><!-- end rightCol -->
</div><!-- end entity --></div><!-- end detailBody -->
<?php
}
?>