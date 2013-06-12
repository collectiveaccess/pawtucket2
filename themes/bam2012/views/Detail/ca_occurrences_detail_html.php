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
	$qr_hits = $this->getVar('browse_results');
	
	# --- get object to feature
	# --- first try to get object linked with rel type primary
	$va_featured_object = $t_occurrence->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('primary')));
	if(!sizeof($va_featured_object)){
		# --- next try to get objects of type photograph or born_digital_photograph
		$va_featured_object = $t_occurrence->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('photograph', 'born_digital_photograph')));
		if(!sizeof($va_featured_object)){
			# --- next try to get any related object
			$va_featured_object = $t_occurrence->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
		}
	}

if (!$this->request->isAjax()) {
?>
	<div id="detailBody" class="detailBodyProduction">
		<div id="productionTopArea">
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
			<div id="occurrenceType"><?php print $t_occurrence->getTypeName(); ?></div>
			<h1><?php print $vs_title; ?></h1>
			<div id="rightCol" <?php if(sizeof($va_featured_object) == 0){ print "class='rightColWide'";} ?>">	
	<?php
				if((!$this->request->config->get('dont_allow_registration_and_login')) && $this->request->config->get('enable_bookmarks')){
	?>
					<!-- bookmark link BEGIN -->
					<div class="unit">
	<?php
					if($this->request->isLoggedIn()){
						print caNavLink($this->request, _t("Bookmark item +"), 'button', '', 'Bookmarks', 'addBookmark', array('row_id' => $vn_occurrence_id, 'tablename' => 'ca_occurrences'));
					}else{
						print caNavLink($this->request, _t("Bookmark item +"), 'button', '', 'LoginReg', 'form', array('site_last_page' => 'Bookmarks', 'row_id' => $vn_occurrence_id, 'tablename' => 'ca_occurrences'));
					}
	?>
					</div><!-- end unit -->
					<!-- bookmark link END -->
	<?php
				}
				# --- production dates
				if($t_occurrence->get("productionDate")){
					print "<div id='productionDate'>";
					print _t("Performance dates");
					print "<div id='productionDateText'>".$t_occurrence->get("productionDate")."</div>";
					print "</div><!-- end productionDate -->";
				}
				$va_attributes = array("idno", "venue", "premiere", "pieces", "country_origin_list", "productionLanguage");
				if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
					foreach($va_attributes as $vs_attribute_code){
						if(trim($vs_value = $t_occurrence->get("ca_occurrences.{$vs_attribute_code}", array("convertCodesToDisplayText" => true)))){
							print "<div class='mdItem'><div class='mdItemHeading'>".$t_occurrence->getDisplayLabel("ca_occurrences.{$vs_attribute_code}")."</div>{$vs_value}</div><!-- end mdItemHeading -->";
						}
					}
				}
				if ($va_date = $t_occurrence->get('ca_occurrences.creationDate')) {
					print "<div class='mdItem'><div class='mdItemHeading'>"._t('Creation Date')."</div>{$va_date}</div><!-- end mdItemHeading -->";
				}
				if ($va_desc = $t_occurrence->get('ca_occurrences.workDescription')) {
					print "<div class='mdItem'><div class='mdItemHeading'>"._t('Description')."</div>{$va_desc}</div><!-- end mdItemHeading -->";
				}
				if ($t_occurrence->get('ca_occurrences.creationLanguage') != 408) {
					if (($va_lang = $t_occurrence->get('ca_occurrences.creationLanguage', array('convertCodesToDisplayText' => true))) && $va_lang != "") {
						print "<div class='mdItem'><div class='mdItemHeading'>"._t('Creation Language')."</div>{$va_lang}</div><!-- end mdItemHeading -->";
					}	
				}
		
				# --- description
				if($t_occurrence->get("description")){
					print "<div id='productionDescription'>";
					print _t("Summary");
					print "<div id='productionDescriptionText'>".$t_occurrence->get("description")."</div>";
					print "</div><!-- end productionDescription -->";
				}
?>
		</div><!-- end rightCol -->
<?php
	if(sizeof($va_featured_object)){
		foreach($va_featured_object as $va_featured_object_info){
			$vn_featured_object_id = $va_featured_object_info["object_id"];
			break;
		}
		$t_object = new ca_objects($vn_featured_object_id);
		$vs_media = $t_object->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values));
		$ca_lists  = new ca_lists();
?>
		<div id="leftCol">
<?php
			print "<div id='featuredMedia'>".$vs_media."</div>";
			# --- get caption for object
			$vs_caption = $t_object->get("ca_objects.image_caption.image_caption_text");
			if(!$vs_caption){
				$vs_caption = $t_object->getLabelForDisplay();
			}
			print "<br/>".$vs_caption;
?>
		</div><!-- end leftCol -->
<?php
	}
?>
		<div style="clear:both;"><!-- empty --></div>
	</div><!-- end productionTopArea -->
<?php
	}
	if($qr_hits->numHits()){
		if (!$this->request->isAjax()) {
?>
	<div id="relatedObjectsArea">
		<H2><?php print _t("Related Objects/Media"); ?></H2>
		<div id="relatedObjects"><div id="resultBox">
<?php
		}
		// set parameters for paging controls view
		$this->setVar('other_paging_parameters', array(
			'occurrence_id' => $vn_occurrence_id
		));
		print $this->render('related_objects_grid.php');

		if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox --><!-- end relatedObjects -->
		<div style="clear:both;"><!-- empty --></div>
	</div><!-- end relatedObjectsArea -->
<?php
		}
	}
	if (!$this->request->isAjax()) {
?>
	<div id="relatedInfo"><table cellpadding="0" cellspacing="0"><tr>
<?php
		# --- genre
		$va_genres = array();
		$va_genres = $t_occurrence->get("genre", array("returnAsArray" => 1, "convertCodesToDisplayText" => true));
		if(sizeof($va_genres) > 0){
			print "<td id='relatedGenres'><h2>"._t("Genre").((sizeof($va_genres) > 1) ? "s" : "")."</h2>";
			foreach($va_genres as $va_genre){
				print "<div class='relatedItem'><span class='capsText'>".$va_genre['genre']."</span></div>";
			}
			print "</td><!-- end relatedGenres -->";
		}else{
			$vn_showRelatedFiller = 1;
		}
		# --- entities
		$va_principal_artists = $t_occurrence->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('principal_artist'), 'sort' => array('ca_entities.surname')));
		$va_entities = $t_occurrence->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, "exclude_relationship_types" => array('principal_artist'), 'sort' => array('ca_entities.surname')));
		if((sizeof($va_entities) > 0) || (sizeof($va_principal_artists) > 0)){	
?>
			<td id="relatedArtists"><h2><?php print _t("Related Artist").((sizeof($va_entities) > 1) ? "s" : ""); ?></h2>
<?php
			if((sizeof($va_principal_artists) > 0)){
				print "<div class='relatedItem'>";
				foreach($va_principal_artists as $va_principal_artist) {
					print (($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_principal_artist["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_principal_artist["entity_id"])) : $va_principal_artist["label"])."<br/>";
				}
				print "<span class='capsText'>".$va_principal_artist['relationship_typename']."</span></div>";
			}
// this code would group by relationship type - not sure which display looks better
// 			if(sizeof($va_entities) > 0){
// 				$va_entities_by_type = array();
// 				foreach($va_entities as $va_entity) {
// 					$va_entities_by_type[$va_entity['relationship_typename']][] = (($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"]);
// 				}
// 				foreach($va_entities_by_type as $vs_type => $va_entities){
// 					print "<div class='relatedItem'>";
// 					print join("<br/>", $va_entities);
// 					print "<br/><span class='capsText'>".$vs_type."</span></div>";
// 				}
// 			}
			if(sizeof($va_entities) > 0){
				foreach($va_entities as $va_entity){
					print "<div class='relatedItem'>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])."<br/><span class='capsText'>".$va_entity['relationship_typename']."</span></div>";
				}
			}
?>
			</td><!-- end relatedArtist -->
<?php
		}else{
			$vn_showRelatedFiller = 1;
		}
		# --- productions
		$va_productions = $t_occurrence->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrictToTypes' => array("production")));
		$va_sorted_productions = array();
		if(sizeof($va_productions) > 0){
			$t_occ = new ca_occurrences();
			$va_prod_types = $t_occ->getTypeList();
			foreach($va_productions as $va_production) {
				$t_occ->load($va_production['occurrence_id']);
				$va_sorted_productions[$va_production['item_type_id']][$va_production['occurrence_id']] = $va_production;
			}
			
			foreach($va_sorted_productions as $vn_production_type_id => $va_production_list) {
?>
					<td id="relatedWorks"><h2><?php print _t("Related")." ".$va_prod_types[$vn_production_type_id]['name_singular'].((sizeof($va_production_list) > 1) ? "s" : ""); ?></h2>
<?php
				foreach($va_production_list as $vn_rel_production_id => $va_info) {
					#print "<div class='relatedItem'>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])."</div>";
					# --- no links to works detail?????
					print "<div class='relatedItem'>".caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_info['occurrence_id']))."</div>";
				}
				print "</td><!-- end relatedWorks -->";
			}
		}else{
			$vn_showRelatedFiller = 1;
		}		
		# --- occurrences
		$va_occurrences = $t_occurrence->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrictToTypes' => array("work")));
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
					<td id="relatedWorks"><h2><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></h2>
<?php
				foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
					#print "<div class='relatedItem'>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])."</div>";
					# --- no links to works detail?????
					print "<div class='relatedItem'>".caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_info['occurrence_id']))."</div>";
				}
				print "</td><!-- end relatedWorks -->";
			}
		}else{
			$vn_showRelatedFiller = 1;
		}
		# --- collections
		$va_collections = $t_occurrence->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
		if(sizeof($va_collections) > 0){
			print "<td id='relatedCollections'><h2>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</h2>";
			foreach($va_collections as $va_collection_info){
				print "<div class='relatedItem'><span class='capsText'>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])."</span></div>";
			}
			print "</td><!-- end relatedCollections -->";
		}else{
			$vn_showRelatedFiller = 1;
		}
		
		if($vn_showRelatedFiller){
			print "<td class='H2Filler'><div class='H2Filler'><!-- empty --></div></td>";
		}
?>
	</tr></table></div><!-- end relatedInfo -->
	
	
	
	
</div><!-- end detailBody -->
<?php
}
?>