<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_occurrences_detail_html.php : 
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
	$t_occurrence 			= $this->getVar('t_item');
	$vn_occurrence_id 	= $t_occurrence->getPrimaryKey();
	
	$vs_title 					= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');

if (!$this->request->isAjax()) {
?>
	<div id="detailBody" >
		<div id="pageNav">
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_occurrences', _t("Back"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("Next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->
		<div class='recordTitle'><h1><?php print unicode_ucfirst($t_occurrence->getTypeName()).': '.$vs_title; ?></h1></div>
		<div id="rightCol" class="occurrence">	
<?php

			# --- identifier
			print "<h3>"._t("Identifier")."</h3><p>";
			print $t_occurrence->get('idno');
			print "</p>";
			if($va_alt_name = $t_occurrence->get('ca_occurrences.nonpreferred_labels')){
				print "<h3>"._t("Alternate Title")."</h3><p> ".$va_alt_name."</p>";
			}			
			# --- attributes
			$va_attributes = $this->request->config->get('ca_occurrences_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_occurrence->get("ca_occurrences.{$vs_attribute_code}")){
						print "<div class='unit'><b>".$t_occurrence->getDisplayLabel("ca_occurrences.{$vs_attribute_code}").":</b> {$vs_value}</div><!-- end unit -->";
					}
				}
			}
			if($va_date = $t_occurrence->get('ca_occurrences.date.dates_value')){
				print "<h3>"._t("Date")."</h3><p>".$va_date." <br/><span class='details'>(".strtolower($t_occurrence->get('ca_occurrences.date.dc_dates_types', array('convertCodesToDisplayText' => true))).")</span></p><!-- end unit -->";
			}			
			# --- description
				if($vs_description_text = $t_occurrence->get("ca_occurrences.description")){
					print "<h3>Description</h3><div id='description' class='scrollPane'><p>".$vs_description_text."</p></div>";				

				}

			# --- entities
			$va_entities = $t_occurrence->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities) > 0){	
?>
				<h3><?php print _t("Related")." ".((sizeof($va_entities) > 1) ? _t("People/Organizations") : _t("Person/Organization")); ?></h3>
				<div class='scrollPane'>
<?php
				foreach($va_entities as $va_entity) {
					print "<p>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])."<br/><span class='details'> (".$va_entity['relationship_typename'].")</span></p>";
				}
?>
				</div>
<?php
			}
			
			# --- occurrences
			$va_occurrences = $t_occurrence->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
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
			$va_places = $t_occurrence->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places) > 0){
				print "<h3>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</h3>";
?>
				<div class='scrollPane'>
<?php
				foreach($va_places as $va_place_info){
					print "<p>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])."<br/><span class='details'> (".$va_place_info['relationship_typename'].")</span></p>";
				}
?>
				</div>
<?php				
			}
			# --- collections
			$va_collections = $t_occurrence->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_collections) > 0){
				print "<h3>"._t("Related Project/Silo")."</h3>";
?>
				<div class='scrollPane'>
<?php
				foreach($va_collections as $va_collection_info){
					print "<p>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])."<br/><span class='details'> (".$va_collection_info['relationship_typename'].")</span></p>";
				}
?>
				</div>
<?php				
			}
			# --- vocabulary terms
			$va_terms = $t_occurrence->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				print "<h3>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</h3>";
?>
				<div class='scrollPane'>
<?php
				foreach($va_terms as $va_term_info){
					print "<p>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</p>";
				}
?>
				</div>
<?php				
			}
			# --- map
			if($t_occurrence->get('ca_occurrences.georeference.geocode')){
				$o_map = new GeographicMap(285, 200, 'map');
				$o_map->mapFrom($t_occurrence, 'ca_occurrences.georeference.geocode');
				print "<div class='unit'>".$o_map->render('HTML')."</div>";
				if($t_occurrence->get('ca_occurrences.georeference.geo_notes')) {
					print "<p><b>Location notes: </b>".$t_occurrence->get('ca_occurrences.georeference.geo_notes')."</p>";
				}
				if($t_occurrence->get('ca_occurrences.georeference.geo_date')) {
					print "<p><b>Location dates: </b>".$t_occurrence->get('ca_occurrences.georeference.geo_date')."</p>";
				}
			}

?>
	</div><!-- end rightCol -->
			
	<div id="leftCol">
		<div id="resultBox">
<?php
}
		// set parameters for paging controls view
		$this->setVar('other_paging_parameters', array(
			'occurrence_id' => $vn_occurrence_id
		));
		print $this->render('related_objects_grid_carousel.php');
		#print $this->render('related_objects_grid.php');

if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox -->


	</div><!-- end leftCol -->
</div><!-- end detailBody -->
	<div id='bottomBar'>
<?php
		if($this->request->isLoggedIn()){
			print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/bookmark.png' border='0' title='Bookmark'>", '', '', 'Bookmarks', 'addBookmark', array('row_id' => $vn_occurrence_id, 'tablename' => 'ca_occurrences'));
		}else{
			print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/bookmark.png' border='0' title='Bookmark'>", '', '', 'LoginReg', 'form', array('site_last_page' => 'Bookmarks', 'row_id' => $vn_occurrence_id, 'tablename' => 'ca_occurrences'));
		}
		print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', $this->request->getController(), 'GetViz', array('id' => $t_occurrence->getPrimaryKey()))."\"); return false;' ><img src='".$this->request->getThemeUrlPath()."/graphics/icons/visualization.png' border='0' title='Visualize relationships'></a>";
?>
	</div>
<?php
}
?>

	<script type="text/javascript">

		jQuery('.scrollPane').jScrollPane({
			
			animateScroll: true,
		});
	</script>