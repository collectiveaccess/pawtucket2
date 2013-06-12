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
	$qr_hits = $this->getVar('browse_results');


if (!$this->request->isAjax()) {		
?>
	<div id="detailBody" class='detailBodyEntity'>
		<div id="entityTopArea">
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
		<div id="entityType"><?php print unicode_ucfirst($this->getVar('typename')); ?></div>
		<h1><?php print $vs_title; ?></h1>
		
		<div id="rightCol" class='rightColWide'>		
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
			# --- identifier
			if($t_entity->get('idno')){
				print "<div class='mdItem'><div class='mdItemHeading'>"._t("Identifier")."</div> ".$t_entity->get('idno')."</div><!-- end unit -->";
			}
			if($va_dates = $t_entity->get('ca_entities.entity_lifespan.ind_dates_value')){
				print "<div class='mdItem'><div class='mdItemHeading'>"._t("Dates")."</div> ".$va_dates." (".$t_entity->get('ca_entities.entity_lifespan.ind_dates_types', array('convertCodesToDisplayText' => true)).")</div><!-- end unit -->";
			}
			if ($va_gender = $t_entity->get('ca_entities.gender', array('convertCodesToDisplayText' => true))) {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t("Gender")."</div> ".$va_gender."</div><!-- end unit -->";				
			}	
			if ($va_bio = $t_entity->get('ca_entities.biography.bio_text')) {
				print "<div class='mdItemLong'><div class='mdItemHeading'>"._t("Biographical Info")."</div> ".$va_bio." (".$t_entity->get('ca_entities.biography.bio_source').")</div><!-- end unit -->";				
			}						
			if ($va_aff = $t_entity->get('ca_entities.bamAffiliation.affiliation_text')) {
				print "<div class='mdItemLong'><div class='mdItemHeading'>"._t("BAM Affiliation")."</div> ".$va_aff." (".$t_entity->get('ca_entities.bamAffiliation.affiliation_source').")</div><!-- end unit -->";				
			}			

?>
	</div><!-- end leftCol -->
	
			<div style="clear:both;"><!-- empty --></div>
	</div><!-- end productionTopArea -->
	
<?php	
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
			'entity_id' => $vn_entity_id
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
	
	if (($t_entity->get("ca_occurrences")) | ($t_entity->get("ca_collections"))) {
?>	
	<div id="relatedInfo"><table cellpadding="0" cellspacing="0"><tr>
<?php
		# --- productions
		$va_productions = $t_entity->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrictToTypes' => array("production")));
		$va_sorted_productions = array();
		if(sizeof($va_productions) > 0){
			$t_occurrence = new ca_occurrences();
			$va_prod_types = $t_occurrence->getTypeList();
			foreach($va_productions as $va_production) {
				$t_occurrence->load($va_production['occurrence_id']);
				$va_sorted_productions[$va_production['item_type_id']][$va_production['occurrence_id']] = $va_production;
			}
			
			foreach($va_sorted_productions as $vn_production_type_id => $va_production_list) {
?>
					<td id="relatedProduction"><h2><?php print _t("Related")." ".$va_prod_types[$vn_production_type_id]['name_singular'].((sizeof($va_production_list) > 1) ? "s" : ""); ?></h2>
<?php
				foreach($va_production_list as $vn_rel_production_id => $va_info) {
					#print "<div class='relatedItem'>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])."</div>";
					# --- no links to works detail?????
					print "<div class='relatedItem'>".caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_info['occurrence_id']))."<br/><span class='capsText'>".$va_info['relationship_typename']."</span></div>";
				}
				print "</td><!-- end relatedWorks -->";
			}
		}else{
			$vn_showRelatedFiller = 1;
		}		
		# --- occurrences
		$va_occurrences = $t_entity->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrictToTypes' => array("work")));
		$va_sorted_occurrences = array();
		if(sizeof($va_occurrences) > 0){
			$t_occurrence = new ca_occurrences();
			$va_item_types = $t_occurrence->getTypeList();
			foreach($va_occurrences as $va_occurrence) {
				$t_occurrence->load($va_occurrence['occurrence_id']);
				$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
			}
			
			foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
?>
					<td id="relatedWorks"><h2><?php print _t("Related Work")."".((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></h2>
<?php
				foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
					#print "<div class='relatedItem'>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])."</div>";
					# --- no links to works detail?????
					print "<div class='relatedItem'>".caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_info['occurrence_id']))."<br/><span class='capsText'>".$va_info['relationship_typename']."</span></div>";
				}
				print "</td><!-- end relatedWorks -->";
			}
		}else{
			$vn_showRelatedFiller = 1;
		}
		# --- collections
		$va_collections = $t_entity->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
		if(sizeof($va_collections) > 0){
			print "<td id='relatedCollections'><h2>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</h2>";
			foreach($va_collections as $va_collection_info){
				print "<div class='relatedItem'>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])."</div>";
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
<?php
	}
?>	
</div><!-- end detailBody -->
<?php
} else {
	$this->setVar('other_paging_parameters', array(
			'entity_id' => $vn_entity_id
		));
		print $this->render('related_objects_grid.php');
}
?>