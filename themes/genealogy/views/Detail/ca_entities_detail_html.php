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
	$t_entity 			= $this->getVar('t_item');
	$vn_entity_id 		= $t_entity->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');

if (!$this->request->isAjax()) {		
?>
	<div id="detailBody">
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
		<h1><?php print $vs_title; ?></h1>
		<div id="leftCol">		
<?php
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

			# --- attributes
			$va_attributes = $this->request->config->get('ca_entities_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_entity->get("ca_entities.{$vs_attribute_code}")){
						print "<div class='unit'><b>".$t_entity->getDisplayLabel("ca_entities.{$vs_attribute_code}").":</b> {$vs_value}</div><!-- end unit -->";
					}
				}
			}
			if ($va_entity_name = $t_entity->get("ca_entities.preferred_labels", array('template' => '^forename ^middlename ^surname<br/>'))){
				print "<div class='unit'><h2>"._t('Full Name')."</h2> ".$va_entity_name."</div>";
			}	
			if ($va_alt_name = $t_entity->get("ca_entities.nonpreferred_labels", array('template' => '^forename ^other_forenames ^middlename ^surname<br/>'))){
				print "<div class='unit'><h2>"._t('Other Names')."</h2> ".$va_alt_name."</div>";
			}			
			if ($va_description_text = $t_entity->get("ca_entities.life_dates")){
				print "<div class='unit'><h2>"._t('Lifetime')."</h2> ".$va_description_text."</div>";
			}
			if ($t_entity->get("ca_entities.entity_dates.date")) {	
				if ($va_entity_date = $t_entity->get("ca_entities.entity_dates", array('template' => '^date_type: ^date', 'delimiter' => '<br/>','convertCodesToDisplayText' => true))){
					print "<div class='unit'><h2>"._t('Other Dates')."</h2> ".$va_entity_date."</div>";
				}
			}
			if ($va_nationality = $t_entity->get("ca_entities.nationality", array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><h2>"._t('Nationality')."</h2> ".$va_nationality."</div>";
			}			
			# --- description
			if($this->request->config->get('ca_entities_description_attribute')){
				if($vs_description_text = $t_entity->get("ca_entities.biography")){
					print "<div class='unit'><div id='description'><b>".$t_entity->getDisplayLabel('ca_entities.'.$this->request->config->get('ca_entities_description_attribute')).":</b> {$vs_description_text}</div></div><!-- end unit -->";				
?>
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('#description').expander({
								slicePoint: 300,
								expandText: '<?php print _t('[more]'); ?>',
								userCollapse: false
							});
						});
					</script>
<?php
				}
			}
			# --- entities
			$va_entities = $t_entity->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities)){	
?>
				<div class="relatedinfo"><div class="unit">
<?php
				
				$va_entities_by_rel_type = array();
				foreach($va_entities as $va_entity) {
					if (!is_array($va_entities_by_rel_type[$va_entity['relationship_typename']])) { $va_entities_by_rel_type[$va_entity['relationship_typename']] = array(); }
					array_push($va_entities_by_rel_type[$va_entity['relationship_typename']], $va_entity);
				}
				
				// Loop through types
				foreach($va_entities_by_rel_type as $vs_type => $va_entities) {
					// Print type name
					print "<div class=\"unit\"><h2>".unicode_ucfirst($vs_type)."</h2>\n";
					
					// Print entities for current type
					foreach($va_entities as $vn_index => $va_entity) {
?>
					<div><?php print (($this->request->config->get('allow_detail_for_ca_entities')) ? 
						caNavLink($this->request, $va_entity['label'], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) 
						: 
						caNavLink($this->request, $va_entity['label'], '', '', 'Search', 'Index', array('search' => '"'.$va_entity['label'].'"'))); 
					
					?></div>
<?php					
					}
					print "</div>";
				}
?>
				</div></div><!-- end unit -->
<?php
			}
			
			# --- occurrences
			$va_occurrences = $t_entity->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
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
						<div class="unit"><h2><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></h2>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						print "<div>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])." (".$va_info['relationship_typename'].")</div>";
					}
					print "</div><!-- end unit -->";
				}
			}
			# --- places
			$va_places = $t_entity->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places) > 0){
				print "<div class='unit'><h2>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</h2>";
				foreach($va_places as $va_place_info){
					print "<div>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".$va_place_info['relationship_typename'].")</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- map
			if($this->request->config->get('ca_objects_map_attribute') && $t_entity->get($this->request->config->get('ca_objects_map_attribute'))){
				$o_map = new GeographicMap(230, 200, 'map');
				$o_map->mapFrom($t_entity, $this->request->config->get('ca_objects_map_attribute'));
				print "<div class='unit' style='margin-top:15px; margin-bottom:20px;'>".$o_map->render('HTML')."</div>";
			}			
			# --- collections
			$va_collections = $t_entity->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_collections) > 0){
				print "<div class='unit'><h2>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</h2>";
				foreach($va_collections as $va_collection_info){
					print "<div>";
					print (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".$va_collection_info['relationship_typename'].")</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- vocabulary terms
			$va_terms = $t_entity->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				print "<div class='unit'><h2>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</h2>";
				foreach($va_terms as $va_term_info){
					print "<div>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</div>";
				}
				print "</div><!-- end unit -->";
			}			

			//
			// Visualization link
			//
			print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', $this->request->getController(), 'GetViz', array('id' => $t_entity->getPrimaryKey()))."\"); return false;' ><img src='".$this->request->getThemeUrlPath()."/graphics/icons/visualization.png' border='0' title='Visualize relationships'></a>";

?>
	</div><!-- end leftCol -->
	<div id="rightCol">
		
<?php
}
	// set parameters for paging controls view
	$this->setVar('other_paging_parameters', array(
		'entity_id' => $vn_entity_id
	));
	print $this->render('related_objects_grid.php');
	

?>
		
	<div style='height:20px; clear:both; width: 100%'></div>
	</div><!-- end rightCol -->
</div><!-- end detailBody -->
<?php

?>